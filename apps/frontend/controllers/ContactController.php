<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\AdviceOperation;
/**
 * 联系我们控制器
 * @author hongker
 * @version 1.0
 */
class ContactController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('联系我们');
		parent::initialize();
		
		$this->operation = new AdviceOperation($this->di);
		
	}

	public function indexAction(){
		
	}
	
	public function addAction() {
		if($this->isPost()) {
			$data['email'] = $this->getPost('email','email');
			$data['name'] = $this->getPost('name');
			$data['content'] = $this->getPost('content');
			
			$return = $this->operation->save($data);
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		
		$this->json_return($return);
	}
	
	

}