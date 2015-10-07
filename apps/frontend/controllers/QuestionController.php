<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\QuestionOperation;
use Blog\Operations\AnswerOperation;
/**
 * 问答控制器
 * @author hongker
 * @version 1.0
 */
class QuestionController extends BaseController
{
	public function initialize() {
		\Phalcon\Tag::setTitle('问答');
		parent::initialize();
		$this->operation = new QuestionOperation($this->di);
		
	}

	/**
	 * 问题列表
	 */
	public function indexAction(){
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$questions = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc"
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
	public function addAnswerAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1001;
			}else {
				$answerOperation = new AnswerOperation($this->di);
				$answer = array();
				$author = $this->session->get('user');
				$answer['author_id'] = $author['id'];
				$answer['question_id'] = $this->getPost('question','int');
				$answer['title'] = $this->getPost('title');
				$answer['content'] = $this->getPost('content',false);
	
				$return = $answerOperation->save($answer);
			}
	
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
}