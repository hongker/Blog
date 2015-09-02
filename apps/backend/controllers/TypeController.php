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

	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$types = $this->operation->findAll();
		
		$page = $this->getPaginate($types,$currentPage);
		$this->view->setVar('page',$page);
	}

}