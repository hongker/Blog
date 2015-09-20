<?php
namespace Blog\User\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\UserOperation;
/**
 * 个人中心首页控制器
 * @author hongker
 * @version 1.0
 */
class HomeController extends BaseController
{
	protected $userOperation;
	protected $articleOperation;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('个人中心');
		parent::initialize();
		$this->userOperation = new UserOperation($this->di);
		$this->articleOperation = new ArticleOperation($this->di);
		$this->view->setVar('userinfo', $this->userOperation->get($this->user['id']));
		
	}

	public function indexAction(){
		$systemArticles = $this->articleOperation->findAll(array(
			"conditions"=>"is_delete=0 and class=2",
			"order"=>"created_at desc",
			"limit"=>5
		));
		
		$this->view->setVar('systemArticles',$systemArticles);
	}
	
	/**
	 * 个人信息详情
	 */
	public function infoAction() {
		
	}
	
	/**
	 * 修改个人信息
	 */
	public function editAction() {
		if($this->isPost()) {
			if(!$this->checkIsLogin()) {
				$return['errNo'] = 1010;
			}else {
				$userinfo = array();
				$id = $this->user['id'];
				$userinfo['age'] = $this->getPost('age','int');
				$userinfo['sex'] = $this->getPost('sex','string');
				
				$return = $this->userOperation->update($id, $userinfo);
			}
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 头像设置
	 */
	public function headimgAction() {
		if($this->isPost()) {
			$userinfo = array();
			$id = $this->user['id'];
			$userinfo['picture'] = $this->getPost('picture','string');
			$return = $this->userOperation->update($id, $userinfo);
			if($return['errNo']==0) {
				//修改头像后更新session
				$userSession = array(
						'id'=>$this->user['id'],
						'username'=>$this->user['username'],
						'picture'=>$userinfo['picture'],
				);
				$this->store('user',$userSession);
			}
			$return['errMsg'] = $this->getErrorMessage($return['errNo']);
			$this->json_return($return);
		}
	}
	
	

}