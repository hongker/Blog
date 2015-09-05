<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\AdviceOperation;
/**
 * 意见管理控制器
 * @author hongker
 * @version 1.0
 */
class AdviceController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('意见管理');
		parent::initialize();
		$this->operation= new AdviceOperation($this->di);
	}

	/**
	 * 评论列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$advices = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($advices,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 删除意见
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
				
			if ($this->operation->delete( $id )) {
				$return ['errNo'] = 0;
			} else {
				$return ['errNo'] = 1202;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 标记为已读
	 */
	public function markAction() {
		
	}

}