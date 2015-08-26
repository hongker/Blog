<?php
namespace Blog\User\Controllers;
use Blog\Operations\UserOperation;
use Blog\Utils\Email;
/**
 * 个人中心首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('个人中心');
		parent::initialize();
		
	}

	public function indexAction(){
		echo 'user';exit;		
	}
	
	

}