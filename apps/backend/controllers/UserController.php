<?php
namespace Blog\Backend\Controllers;
/**
 * 用户管理控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('用户管理');
		parent::initialize();
	}

	public function indexAction()
	{
		echo "<h1>admin!</h1>";
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