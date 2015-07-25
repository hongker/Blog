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
	}

	public function indexAction() {
		var_dump($this->error[0]);exit;
	}
	
	public function addUser() {
		$return = array();
		if($this->request->isPost()) {
			
		}else {
			$return['errNo'] = 1002;
			
		}
		return json_encode($return);
	}

}