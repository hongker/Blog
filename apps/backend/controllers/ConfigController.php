<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\ConfigOperation;
/**
 * 系统配置控制器
 * @author hongker
 * @version 1.0
 */
class ConfigController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('系统配置');
		parent::initialize();
		$this->operation = new ConfigOperation($this->di);
	}

	/**
	 * 配置列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$config = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($config,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 添加配置
	 */
	public function addAction() {
		if($this->isPost()) {
			$config = array();
			$config['name'] = $this->getPost('name','string');
			$config['ckey'] = $this->getPost('ckey','string');
			$config['cvalue'] = $this->getPost('cvalue','string');
			$config['description'] = $this->getPost('description','string');
		
			$return = $this->operation->save($config);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
	
	/**
	 * 修改配置
	 */
	public function editAction() {
		if($this->isPost()) {
			$config = array();
			$id = $this->getPost('id','int');
			$config['name'] = $this->getPost('name','string');
			$config['ckey'] = $this->getPost('ckey','string');
			$config['cvalue'] = $this->getPost('cvalue','string');
			$config['description'] = $this->getPost('description','string');
		
			$return = $this->operation->update($id,$config);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}else {
			$id = $this->dispatcher->getParam(0);
			
			$config = $this->operation->get($id);
			
			if($config) {
				$this->view->setVar('config',$config);
			}else {
				$this->show404();
			}
		}
		
	}
	
	/**
	 * 删除配置
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
				
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2108;
			}
				
		}else {
			$return['errNo'] = 2106;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	

}