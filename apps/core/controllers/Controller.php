<?php
namespace Blog\Controllers;

use Blog\Utils\Redis;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;
/**
 * 公共控制器
 * @author hongker
 * @version 1.0
 */
class Controller extends \Phalcon\Mvc\Controller {
	protected $module;
	/**
	 * 控制器名称
	 * @access protected
	 */
	protected $controller;
	
	/**
	 * 方法名称
	 * @access protected
	 */
	protected $action;
	
	/**
	 * 错误信息
	 * @access protected
	 */
	protected $error;
	
	/**
	 * 操作类名称
	 * @access protected
	 */
	protected $operation ;
	
	protected $redis;
	
	/**
	 * 权限控制
	 * @var unknown
	 */
	protected $acl;
	
	protected $resource;
	
	/**
	 * 初始化
	 */
	protected function initialize() {
		$this->view->setVar('action',$this->action);
		$this->view->setVar('controller',$this->controller);
		
		$this->redis = new Redis();
	}
	/**
	 * @param unknown $dispatcher
	 */
	public function beforeExecuteRoute($dispatcher) {
		$this->module = $dispatcher->getModuleName();
		$this->controller = $dispatcher->getControllerName();
		$this->action = $dispatcher->getActionName();
		$config = new \Phalcon\Config\Adapter\Ini ( "../apps/configs/config.ini" );
		$this->error = $config->message->error;
	}
	
	/**
	 * 输出json数据
	 * @param array $array
	 */
	public function json_return(Array $array) {
		echo json_encode($array);exit;
	}
	
	/**
	 * 检查是否登录
	 * @return boolean
	 */
	protected function checkIsLogin() {
		if($this->session->has('user')) {
			return true;
		}
		return false;
	}
	
	/**
	 * 获取GET数据
	 * @param string $param
	 * @param string $type
	 */
	protected function getQuery($param,$type='string') {
		return $this->request->getQuery($param,$type);
	}
	
	/**
	 * 获取POST数据
	 * @param string $param
	 * @param string $type
	 */
	protected function getPost($param,$type='string') {
		if($type==false) {
			return $this->request->getPost($param);
		}else {
			return $this->request->getPost($param,$type);
		}
	}
	
	/**
	 * 判断是否上GET请求
	 */
	protected function isGet() {
		return $this->request->isGet();
	}
	
	/**
	 * 判断是否上POST请求
	 */
	protected function isPost() {
		return $this->request->isPost();
	}
	
	/**
	 * 获取分页类
	 * @param unknown $data
	 * @param number $currentPage
	 * @param number $limit
	 * @return unknown
	 */
	public function getPaginate($data,$currentPage=1,$limit = 10) {
		$paginator = new \Phalcon\Paginator\Adapter\Model(
				array(
						"data"  => $data,
						"limit" => $limit,
						"page"  => $currentPage,
				));
		$pageinate = $paginator->getPaginate();
	
		return $pageinate;
	}
	
	/**
	 * 跳转到404页面
	 */
	public function show404() {
		$this->response->redirect('404.html');
		$this->response->send();
	}
	
	/**
	 * 根据错误编号获取错误信息
	 * @param int $no
	 * @return string
	 */
	protected function getErrorMessage($no) {
		return $this->error[$no];
	}
	
	/**
	 * 根据唯一键值返回视图key
	 * @param unknown $type
	 * @param unknown $primaryKey
	 * @return string
	 */
	protected function getViewKey($primaryKey) {
		$key = $this->controller.'_'.$this->action.'_'.$primaryKey;
		return $key;
	}
	
	/**
	 * 设置视图缓存
	 * @param string $key 视图缓存Key
	 * @param int $lifetime 缓存时间，默认: one day
	 */
	protected function setViewCache($key,$lifetime=86400) {
		$this->view->cache(
				array(
						'key' => $key,
						'lifetime' => $lifetime,
				)
		);
	}
	
	/**
	 * 查看视图缓存是否存在
	 * @param string $key
	 * @return boolean
	 */
	protected function checkViewCacheExist($key) {
		return $this->view->getCache()->exists($key);
	}
	
	/**
	 * 保存到Redis缓存
	 * @param string $key
	 * @param unknown $value
	 * @return boolean
	 */
	protected function setCache($key, $value) {
		
		if($this->redis->set($key, $value)) {
			return true;
		}
		return false;
	}
	
	/**
	 * 获取Redis缓存中的变量
	 * @param string $key
	 * @return unknown
	 */
	protected function getCache($key) {
		return $this->redis->get($key);
	}
	
	/**
	 * 查看角色是否有访问权限
	 * @param int $type 用户type
	 * @return boolean
	 */
	protected function checkAcl($type) {
		$config = new \Phalcon\Config\Adapter\Ini ( "../apps/configs/config.ini" );
		$roles = $config->acl->roles;
		$this->resource = ucfirst($this->module).ucfirst($this->controller).'Resources';
		// 检查ACL数据是否存在
		$aclCacheFile = __DIR__.'/../../../cache/acl.data';
		if (!is_file($aclCacheFile)) {
		
		    $this->acl = new AclList();
		
		    // 创建角色
			// The first parameter is the name, the second parameter is an optional description.
			$roleAdmins = new Role("Administrators");
			$roleEditors = new Role("Editors");
			$roleUsers = new Role("Users");
			
			$this->acl->addRole($roleAdmins);
			$this->acl->addRole($roleEditors);
			$this->acl->addRole($roleUsers);
			
			$adminsUserResource= new Resource("BackendUserResources");
			
			$this->acl->addResource($adminsUserResource, array("index","add", "edit","delete"));
			
			$this->acl->deny("Editors", "BackendUserResources", "add");
			
			$this->acl->deny("Editors", "BackendUserResources", "delete");
			
		    // 保存实例化的数据到文本文件中
		    file_put_contents($aclCacheFile, serialize($this->acl));
		} else {
		
		     // 返序列化
		     $this->acl = unserialize(file_get_contents($aclCacheFile));
		}
		
		if(isset($roles[$type])) {
			//判断是否有权限
			if($this->acl->isAllowed($roles[$type],$this->resource,$this->action)) {
				return true;
			}
		}
		return false;
	}
}
