<?php
namespace Blog\User\Controllers;
use Blog\Operations\CommentOperation;
/**
 * 用户评论管理首页控制器
 * @author hongker
 * @version 1.0
 */
class CommentController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('评论管理');
		parent::initialize();
		$this->operation = new CommentOperation($this->di);
	}

	/**
	 * 文章列表
	 */
	public function indexAction(){
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$comments = $this->operation->findAll(array(
				"conditions"=>"is_delete=0 and author_id={$this->user['id']}",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($comments,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 添加文章
	 */
	public function addAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1010;
			}else {
				$article = array();
				$article['author_id'] = $this->user['id'];
				$article['title'] = $this->getPost('title');
				$article['digest'] = $this->getPost('digest');
				$article['type_id'] = $this->getPost('type','int');
				$article['content'] = $this->getPost('content',false);
			}
			
			$return = $this->operation->save($article);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
		$this->view->setVar('types',$this->types);
	}
	
	/**
	 * 编辑文章
	 */
	public function editAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1010;
			}else {
				$article = array();
				$id = $this->getPost('id','int');
				$article['title'] = $this->getPost('title');
				$article['digest'] = $this->getPost('digest');
				$article['type_id'] = $this->getPost('type','int');
				$article['content'] = $this->getPost('content',false);
			}
			
			$return = $this->operation->update($id, $article);
			$this->json_return($return);
		}else {
			$id = $this->dispatcher->getParam(0);
			$article = $this->operation->get($id);
			
			if($article) {
				$this->view->setVar('article',$article);
				$this->view->setVar('types',$this->types);
			}else {
				$this->show404();
			}
			
			
		}
	}
	
	/**
	 * 删除文章
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			
			if($this->operation->checkIsAuthor($id,$this->user['id'])) {
				if($this->operation->delete($id)) {
					$return['errNo'] = 0;
				}
			}else {
				$return['errNo'] = 1014;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	

}