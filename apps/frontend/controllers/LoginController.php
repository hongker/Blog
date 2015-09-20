<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;

/**
 * 首页控制器
 * @author hongker
 * @version 1.0
 */
class LoginController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('登录');
		parent::initialize();
		$this->view->setTemplateAfter('login_register');
		$this->operation = new UserOperation($this->di);
	}

	public function indexAction() {

	}
	
	public function checkAction() {
		$return = array();
		if($this->request->isPost()) {
			$token_key = $this->getPost('token_key','string');
			$token_value = $this->getPost('token_value','string');
			if ($this->security->checkToken($token_key, $token_value)) {
				$user['username'] = $this->getPost('username','string');
				$user['password'] = $this->getPost('password','string');
				$return = $this->operation->login($user);
			}else {
				$return['errNo'] = 1015;
			}
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		
		$this->json_return($return);
	}
	
	public function logoutAction() {
		if($this->request->isPost()) {
			if($this->operation->logout()) {
				$return['errNo'] = 0;
			}
		}else {
			$return['errNo'] = 1002;
		}
		
		$return['errMsg'] = $this->error[$return['errNo']];
		
		$this->json_return($return);
	}

}