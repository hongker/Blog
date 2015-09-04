<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
use Blog\Utils\Email;
use Blog\Operations\ArticleOperation;
/**
 * 首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('首页');
		parent::initialize();
		
	}

	public function indexAction(){
		$articleOperation = new ArticleOperation($this->di);
		
		$articles = $articleOperation->findAll(array(
				"conditions"=>"is_delete=0",
				"order"=>"created_at desc",
				"limit"=>5,
		));
		
		$this->view->setVar('articles',$articles);
	}
	
	

}