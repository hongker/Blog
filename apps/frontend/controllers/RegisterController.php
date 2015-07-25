<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
/**
 * 注册控制器
 * @author hongker
 *
 */
class RegisterController extends BaseController
{
	protected $operation;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('注册');
		parent::initialize();
		$this->view->setTemplateAfter('common');
		
		$this->operation = new UserOperation($this->di);
	}

	public function indexAction() {
		
	}
	
	/**
	 * 添加用户
	 */
	public function addUser() {
		$return = array();
		if($this->request->isPost()) {
			$data['username'] = $this->request->getPost('username','string');
			$data['email'] = $this->request->getPost('email','email');
			$data['password'] = $this->security->hash($this->request->getPost('password','string'));
			
			if($this->operation->save($data)) {
				$return['errNo'] = 0;
				$return['errMsg'] = '';
			}else {
				//注册失败
				//$return['errNo'] = 1002;
				//$return['errMsg'] = $this->flash->output();
			}
			
		}else {
			$return['errNo'] = 1002;
			$return['errMsg'] = '请求方式错误';
		}
	}

}