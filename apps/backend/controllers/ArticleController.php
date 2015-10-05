<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\TypeOperation;
/**
 * 文章管理控制器
 * @author hongker
 * @version 1.0
 */
class ArticleController extends BaseController
{
	protected $types;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('文章管理');
		parent::initialize();
		$this->operation = new ArticleOperation($this->di);
		$typeOperation = new TypeOperation($this->di);
		$this->types = $typeOperation->findAll(array("conditions"=>"is_delete=0"));
		
	}

	/**
	 * 文章列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$articles = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
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
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1001;
			}else {
				$article = array();
				$article['author_id'] = $this->user['id'];
				$article['title'] = $this->getPost('title');
				$article['picture'] = $this->getPost('picture')?$this->getPost('picture'):'';
				$article['digest'] = $this->getPost('digest');
				$article['type_id'] = $this->getPost('type','int');
				$article['content'] = $this->getPost('content',false);
				$article['class'] = $this->getPost('className','int');
			}
				
			$return = $this->operation->save($article);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
		$this->view->setVar('types',$this->types);
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
				$return['errNo'] = 1109;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 通过审核
	 */
	public function checkAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
	
			$return = $this->operation->check($id);
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 驳回审核
	 */
	public function rejectAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
	
			$return = $this->operation->reject($id);
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}

}