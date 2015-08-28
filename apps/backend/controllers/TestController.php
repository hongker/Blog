<?php
namespace Blog\Backend\Controllers;
/**
 * 测试控制器
 * @author hongker
 * @version 1.0
 */
class TestController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('测试');
		parent::initialize();
	}

	public function indexAction()
	{
		phpinfo();exit;
	}

}