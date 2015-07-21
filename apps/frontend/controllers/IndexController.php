<?php
namespace Blog\Frontend\Controllers;
/**
 * 首页控制器
 * @author hongker
 *
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('首页');
		parent::initialize();
		$this->view->setTemplateAfter('common');
	}

	public function indexAction()
	{
		echo "<h1>Hello!</h1>";
	}

}