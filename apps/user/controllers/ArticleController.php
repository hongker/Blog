<?php
namespace Blog\User\Controllers;
use Blog\Operations\ArticleOperation;
/**
 * 用户文章管理首页控制器
 * @author hongker
 * @version 1.0
 */
class ArticleController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('文章管理');
		parent::initialize();
		$this->operation = new ArticleOperation($this->di);
		
	}

	/**
	 * 文章列表
	 */
	public function indexAction(){
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		
		$articles = $this->operation->findAll(array("order"=>"created_at desc"));
		
		$page = $this->getPaginate($articles,$currentPage);
		
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',0);
	}
	
	

}