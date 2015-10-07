<?php
namespace Blog\Backend\Controllers;

use Blog\Operations\QuestionOperation;
/**
 * 问答管理控制器
 * @author hongker
 * @version 1.0
 */
class QuestionController extends BaseController
{
	protected $types;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('问答管理');
		parent::initialize();
		$this->operation = new QuestionOperation($this->di);
		
	}

	/**
	 * 问题列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$questions = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($questions,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 问题详情
	 */
	public function infoAction() {
		$code = $this->dispatcher->getParam(0);
		$question = $this->operation->getByCode($code);
		
		if($question) {
			$question->view = $this->operation->addView($question->id);
			$answers = $question->getAnswers("is_delete=0");
			
			$this->view->setVar('question',$question);
			$this->view->setVar('answers',$answers);
		}else {
			$this->show404();
		}
	}
	
	/**
	 * 添加问题
	 */
	public function addAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1001;
			}else {
				$question = array();
				$question['author_id'] = $this->admin['id'];
				$question['title'] = $this->getPost('title');
				$question['content'] = $this->getPost('content',false);
	
				$return = $this->operation->save($question);
			}
	
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
	
	/**
	 * 编辑问题
	 */
	public function editAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1001;
			}else {
				$question = array();
	
				$id = $this->getPost('id','int');
				$question['title'] = $this->getPost('title');
				$question['content'] = $this->getPost('content',false);
	
				$return = $this->operation->update($id, $question);
			}
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}else {
			$id = $this->dispatcher->getParam(0);
			$question = $this->operation->get($id);
	
			if($question) {
				$this->view->setVar('question',$question);
			}else {
				$this->show404();
			}
	
	
		}
	}
	
	/**
	 * 删除问题
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
	
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2307;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	

}