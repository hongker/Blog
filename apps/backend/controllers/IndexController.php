<?php
namespace Blog\Backend\Controllers;
/**
 * 管理首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('管理首页');
		parent::initialize();
	}

	public function indexAction()
	{
		echo "<h1>admin!</h1>";
	}

}