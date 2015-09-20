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
		
	}
	
	/**
	 * 修改配置
	 */
	public function editAction() {
	
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