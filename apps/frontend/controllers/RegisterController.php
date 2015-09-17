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
			$data['username'] = $this->request->getPost('username','string');
			$data['email'] = $this->request->getPost('email','email');
			$data['password'] = $this->request->getPost('password','string');
			
			$return = $this->operation->register($data);
			
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		
		$this->json_return($return);
	}

}