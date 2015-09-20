<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\UserOperation;
/**
 * 用户管理控制器
 * @author hongker
 * @version 1.0
 */
class UserController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('用户管理');
		parent::initialize();
		$this->operation = new UserOperation($this->di);
	}

	/**
	 * 用户列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$config = $this->operation->findAll(array(
				"conditions"=>"is_delete=0 and type=1",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($config,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 管理员列表
	 */
	public function adminAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$config = $this->operation->findAll(array(
				"conditions"=>"is_delete=0 and type=2",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($config,$currentPage);
		
		$this->view->setVar('page',$page);
		$this->view->pick('user/index');
	}
	
	/**
	 * 查看用户信息
	 */
	public function infoAction() {
		
	}
	
	/**
	 * 添加用户
	 */
	public function addAction() {
		if($this->isPost()) {
			$user = array();
			$user['username'] = $this->getPost('username','string');
			$user['password'] = $this->getPost('password','string');
			$user['email'] = $this->getPost('email','email');
			$user['type'] = $this->getPost('type','string');
			
			$return = $this->operation->register($user);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
	
	/**
	 * 修改用户信息
	 */
	public function editAction() {
		
	}
	
	/**
	 * 删除用户
	 */
	public function deleteAction() {
		
	}

}