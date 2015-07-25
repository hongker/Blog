<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
use Blog\Operations\ArticleOperation;

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
		$this->operation = new UserOperation($this->di);
	}

	public function indexAction() {

	}
	
	public function checkAction() {
		$return = array();
		if($this->request->isPost()) {
			$user['username'] = $this->request->getPost('username','string');
			$user['password'] = $this->request->getPost('password','string');
			$return = $this->operation->login($user);
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		
		$this->json_return($return);
	}

}