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
	 * 添加收藏
	 */
	public function addAction() {
		if($this->request->isPost()) {
			if($this->checkIsLogin()) {
				$user = $this->session->get('user');
				$data['author_id'] = $user['id'];
				$data['target_id'] = $this->request->getPost('target_id','int');
				$data['type'] = $this->request->getPost('type','int');
				
				$return = $this->operation->getStatus($data);
				
				if($return['errNo']==0) {
					$status = $return['status'];
					if($status==0) {
						//未收藏
						$return = $this->operation->save($data);
					}elseif($status==1) {
						//已收藏
						$return['errNo'] = 1608;
					}else {
						//已取消,重新收藏
						$return = $this->operation->changeStatus($data);
					}
				}
			}else {
				$return['errNo'] = 1001;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	

}