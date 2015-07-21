<?php
namespace Blog\Frontend\Controllers;
use Blog\Models\Users;
/**
 * 首页控制器
 * @author hongker
 *
 */
class LoginController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('首页');
		parent::initialize();
		$this->view->setTemplateAfter('common');
	}

	public function indexAction() {
		$user = Users::findFirst();
		echo $user->username;exit;
	}

}