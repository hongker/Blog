<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
use Blog\Utils\Email;
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
			
	}
	
	

}