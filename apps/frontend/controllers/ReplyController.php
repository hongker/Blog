<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\ReplyOperation;
/**
 * 回复控制器
 * @author hongker
 * @version 1.0
 */
class ReplyController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('回复');
		parent::initialize();
		$this->operation = new ReplyOperation($this->di);
		
	}

	public function indexAction(){
		
	}
	
	/**
	 * 回复
	 */
	public function addAction() {
		if($this->request->isPost()) {
			if($this->checkIsLogin()) {
				$author = $this->session->get('user');
				$data['author_id'] = $author['id'];
				$data['content'] = $this->request->getPost('content','string');
				$data['target_id'] = $this->request->getPost('target_id','int');
				$data['comment_id'] = $this->request->getPost('comment_id','int');
				
				if($this->operation->save($data)) {
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1011; 
				}
			}else {
				$return['errNo'] = 1010;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		$this->json_return($return);
	}
	
	/**
	 * 删除回复
	 */
	public function delAction() {
		if($this->request->isPost()) {
			$id = $this->request->getPost('id','int');
			
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1013;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		$this->json_return($return);
	}
}