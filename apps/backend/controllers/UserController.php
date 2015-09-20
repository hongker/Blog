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
	 * 查看用户信息
	 */
	public function infoAction() {
		
	}
	
	/**
	 * 添加用户
	 */
	public function addAction() {
		
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