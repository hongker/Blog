<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\TaskOperation;
/**
 * 任务管理控制器
 * @author hongker
 * @version 1.0
 */
class TaskController extends BaseController
{
	public function initialize() {
		\Phalcon\Tag::setTitle('任务管理');
		parent::initialize();
		$this->operation = new TaskOperation($this->di);
	}

	/**
	 * 任务列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$tasks = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($tasks,$currentPage);
		
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 添加任务
	 */
	public function addAction() {
		if($this->isPost()) {
			$task = array();
			$task['title'] = $this->getPost('title');
			$task['start_date'] = $this->getPost('start_date');
			$task['end_date'] = $this->getPost('end_date');
			$task['content'] = $this->getPost('content',false);
			$task['author_id'] = $this->admin['id'];
			$return = $this->operation->save($task);
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
	
	/**
	 * 删除任务
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2207;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	

}