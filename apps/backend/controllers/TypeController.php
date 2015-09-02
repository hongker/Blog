<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\TypeOperation;
/**
 * 类型管理控制器
 * @author hongker
 * @version 1.0
 */
class TypeController extends BaseController
{
	public function initialize() {
		\Phalcon\Tag::setTitle('类型管理');
		parent::initialize();
		$this->operation = new TypeOperation($this->di);
	}

	/**
	 * 分类列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$types = $this->operation->findAll(array("order"=>"is_delete"));
		
		$page = $this->getPaginate($types,$currentPage);
		$this->view->setVar('page',$page);
	}
	
	/**
	 * 添加分类
	 */
	public function addAction() {
		if($this->isPost()){
			$type['name'] = $this->getPost('name');
			
			$return = $this->operation->save($type);
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 删除分类
	 */
	public function deleteAction() {
		$return = array();
		if($this->isPost()) {
			$id = $this->getPost('id','int');
			if($this->operation->delete($id)) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1024;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}

}