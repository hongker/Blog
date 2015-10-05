<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
/**
 * 注册控制器
 * @author hongker
 * @version 1.0
 */
class RegisterController extends BaseController
{
	protected $operation;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('注册');
		parent::initialize();
		$this->view->setTemplateAfter('login_register');
		
		$this->operation = new UserOperation($this->di);
	}

	public function indexAction() {
		
	}
	
	/**
	 * 添加用户
	 */
	public function addUserAction() {
		$return = array();
		if($this->request->isPost()) {
			$token_key = $this->getPost('token_key','string');
			$token_value = $this->getPost('token_value','string');
			if ($this->security->checkToken($token_key, $token_value)) {
				$data['username'] = $this->request->getPost('username','string');
				$data['email'] = $this->request->getPost('email','email');
				$data['password'] = $this->request->getPost('password','string');
				
				$return = $this->operation->register($data);
			}else {
				$return['errNo'] = 1015;
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		
		if($return['errNo']!=0) {
			//生成token并返回
			$return['tokenKey'] = $this->security->getTokenKey();
			$return['tokenVal'] = $this->security->getToken();
		}
		
		$this->json_return($return);
	}

}