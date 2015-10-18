<?php
namespace Blog\User\Controllers;
use Blog\Operations\UserOperation;
use Blog\Utils\Email;
use Blog\Operations\ArticleOperation;
/**
 * 用户首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('用户首页');
		parent::initialize();
		$this->operation = new UserOperation($this->di);
		
	}

	public function indexAction(){
		echo 'user';exit;		
	}
	
	/**
	 * 用户主页
	 */
	public function infoAction() {
		$username = $this->dispatcher->getParam(0);
		$userinfo = $this->operation->findOne("username='$username'");
		if($userinfo) {
			$articleOperation = new ArticleOperation($this->di);
			$articles = $articleOperation->findAll(array(
					"conditions"=>"is_delete=0 and author_id={$userinfo->id}",
					"order"=>"created_at desc",
					'limit' => 5,
			));
			
			$this->view->setVar('userinfo',$userinfo);
			$this->view->setVar('articles',$articles);
		}else {
			$this->show404();
		}
		
	}
	
	

}