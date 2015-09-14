<?php
namespace Blog\User\Controllers;
use Blog\Operations\CollectOperation;
/**
 * 我的收藏管理首页控制器
 * @author hongker
 * @version 1.0
 */
class CollectController extends BaseController
{
	
	public function initialize()
	{
		\Phalcon\Tag::setTitle('收藏管理');
		parent::initialize();
		$this->operation = new CollectOperation($this->di);
	}

	/**
	 * 收藏列表
	 */
	public function indexAction(){
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$collects = $this->operation->findAll(array(
				"conditions"=>"is_delete=0 and author_id={$this->user['id']}",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($collects,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 取消收藏
	 */
	public function cancelAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			if($this->operation->checkIsExist($id)) {
				if($this->operation->checkIsAuthor($id,$this->user['id'])) {
					if($this->operation->delete($id)) {
						$return['errNo'] = 0;
					}else {
						$return['errNo'] = 1611;
					}
				}else {
					$return['errNo'] = 1610;
				}
			}else {
				$return['errNo'] = 1606;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
}