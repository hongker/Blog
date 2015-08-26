<?php
namespace Blog\Backend\Controllers;
/**
 * 类型管理控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('类型管理');
		parent::initialize();
	}

	public function indexAction()
	{
		echo "<h1>admin!</h1>";
	}

}