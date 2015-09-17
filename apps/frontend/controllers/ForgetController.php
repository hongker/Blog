<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;

/**
 * 忘记密码控制器
 * @author hongker
 * @version 1.0
 */
class ForgetController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('忘记密码');
		parent::initialize();
		$this->operation = new UserOperation($this->di);
	}

	public function indexAction() {

	}
}