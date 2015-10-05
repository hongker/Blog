<?php
namespace Blog\User\Controllers;
use Blog\Operations\UserOperation;
use Blog\Utils\Email;
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
		
	}

	public function indexAction(){
		echo 'user';exit;		
	}
	
	/**
	 * 用户主页
	 */
	public function infoAction() {
		echo '用户主页';exit;
	}
	
	

}