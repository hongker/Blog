<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\ScoreOperation;
/**
 * 评分管理控制器
 * @author hongker
 * @version 1.0
 */
class ScoreController extends BaseController
{
	protected $types;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('评分管理');
		parent::initialize();
		$this->operation = new ScoreOperation($this->di);
		
	}

	/**
	 * 评分列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$scores = $this->operation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
		));
		
		$page = $this->getPaginate($scores,$currentPage);
		
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',0);
	}
	
	/**
	 * 删除文章
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1708;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	

}