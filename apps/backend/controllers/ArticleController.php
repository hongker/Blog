<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\ArticleOperation;
/**
 * 文章管理控制器
 * @author hongker
 * @version 1.0
 */
class ArticleController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('文章管理');
		parent::initialize();
		$this->operation = new ArticleOperation($this->di);
		
	}

	public function indexAction()
	{
		echo "<h1>admin!</h1>";
	}
	
	/**
	 * 查看详情
	 */
	public function infoAction() {
		
	}
	
	/**
	 * 添加文章
	 */
	public function addAction() {
		
	}
	
	/**
	 * 修改文章
	 */
	public function editAction() {
		
	}
	
	/**
	 * 删除文章
	 */
	public function deleteAction() {
		$id = 1;
		if($this->operation->delete($id)) {
			echo 'true';
		}else {
			echo 'false';
		}
		exit;
	}

}