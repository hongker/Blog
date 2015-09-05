<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\CommentOperation;
use Blog\Operations\ReplyOperation;
/**
 * 评论控制器
 * @author hongker
 * @version 1.0
 */
class CommentController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('评论');
		parent::initialize();
		$this->operation = new CommentOperation($this->di);
		
	}

	public function indexAction(){
		
	}
	
	/**
	 * 发表评论
	 */
	public function addAction() {
		if($this->request->isPost()) {
			if($this->checkIsLogin()) {
				$author = $this->session->get('user');
				$data['author_id'] = $author['id'];
				$data['content'] = $this->request->getPost('content','string');
				$data['target'] = $this->request->getPost('target','int');
				$data['type'] = $this->request->getPost('type','int');
				
				$return = $this->operation->save($data);
			}else {
				$return['errNo'] = 1001;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 删除评论
	 */
	public function delAction() {
		if($this->request->isPost()) {
			$id = $this->request->getPost('id','int');
			
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1012;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		$this->json_return($return);
	}
	
	public function replyAction() {
		if($this->request->isPost()) {
			if($this->checkIsLogin()) {
				$author = $this->session->get('user');
				$data['author_id'] = $author['id'];
				$data['content'] = $this->request->getPost('content','string');
				$data['target_id'] = $this->request->getPost('target_id','int');
				$data['comment_id'] = $this->request->getPost('comment_id','int');
		
				$replyOperation = new ReplyOperation($this->di);
				$return = $replyOperation->save($data);
			}else {
				$return['errNo'] = 1001;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	
	
	/**
	 * 点赞
	 */
	public function praiseAction() {
		
	}
	
	/**
	 * 取消点赞
	 */
	public function cancelPraiseAction() {
		
	}
	
	

}