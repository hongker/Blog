<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\CommentOperation;
/**
 * 评论管理控制器
 * @author hongker
 * @version 1.0
 */
class CommentController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('评论管理');
		parent::initialize();
		$this->operation= new CommentOperation($this->di);
	}

	/**
	 * 评论列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$comments = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($comments,$currentPage);
		
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',0);
	}
	
	/**
	 * 删除评论
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

}