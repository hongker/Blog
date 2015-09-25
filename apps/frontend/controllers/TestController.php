<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
use Blog\Models\Users;
use Blog\Utils\Code;
/**
 * 测试
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

	public function indexAction(){
		echo 'test';exit;
	}
	
	public function loginAction() {
		$username = 'aaa';
		$password='111';
		//$operation = new UserOperation($this->di);
		$user = Users::findFirst("username='$username'");
		
		var_dump($user);exit;
		
	}
	
	public function codeAction() {
		$code = new Code();
		echo $code->getCode();exit;
	}
	
	public function getIpAction() {
		echo $this->request->getClientAddress();exit;
	}
	
	public function observerAction() {
		$user = new UserOperation($this->di);
		$user->testObserver();exit;
	}
	
	

}