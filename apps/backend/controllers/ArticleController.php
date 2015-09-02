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

	/**
	 * 文章列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$articles = $this->operation->findAll(array("order"=>"created_at desc"));
		
		$page = $this->getPaginate($articles,$currentPage);
		
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',0);
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
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			
			
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1023;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}

}