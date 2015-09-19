<?php
namespace Blog\User\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\UserOperation;
/**
 * 个人中心首页控制器
 * @author hongker
 * @version 1.0
 */
class HomeController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('个人中心');
		parent::initialize();
		$userOperation = new UserOperation($this->di);
		$this->view->setVar('userinfo', $userOperation->get($this->user['id']));
		
	}

	public function indexAction(){
		$articleOperation = new ArticleOperation($this->di);
		$systemArticles = $articleOperation->findAll(array(
			"conditions"=>"is_delete=0 and class=2",
			"order"=>"created_at desc",
			"limit"=>5
		));
		
		$this->view->setVar('systemArticles',$systemArticles);
	}
	
	/**
	 * 个人信息详情
	 */
	public function infoAction() {
		
	}
	
	/**
	 * 修改个人信息
	 */
	public function editAction() {
		
	}
	
	

}