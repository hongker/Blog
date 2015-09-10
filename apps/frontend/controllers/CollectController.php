<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\CollectOperation;
/**
 * 收藏控制器
 * @author hongker
 * @version 1.0
 */
class CollectController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('收藏');
		parent::initialize();
		$this->operation = new CollectOperation($this->di);
		
	}

	/**
	 * 显示收藏数据
	 * @todo 统计数据并使用Echart显示
	 */
	public function indexAction(){
		
	}
	
	/**
	 * 发表评论
	 */
	public function addAction() {
		if($this->request->isPost()) {
			if($this->checkIsLogin()) {
				$user = $this->session->get('user');
				$data['user_id'] = $user['id'];
				$data['target_id'] = $this->request->getPost('target_id','int');
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
	
	
	/**
	 * 取消收藏
	 */
	public function cancelAction() {
		
	}
	
	

}