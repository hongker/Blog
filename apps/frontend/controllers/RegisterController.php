<?php
namespace Blog\Frontend\Controllers;
/**
 * 注册控制器
 * @author hongker
 *
 */
class RegisterController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('注册');
		parent::initialize();
		$this->view->setTemplateAfter('common');
	}

	public function indexAction() {
		
	}

}