<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\UserOperation;
/**
 * 首页控制器
 * @author hongker
 *
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('首页');
		parent::initialize();
		
	}

	public function indexAction()
	{
		
		$operation = new UserOperation();
		
		$data['username'] = 'ubuntu1';
		$data['email'] = 'test1@qq.com';
		$data['password'] = $this->security->hash('ubuntu1');
		$data['age'] = 25;
		
		$operation->save($data);
		
		/*
		$id = 2;
		//$data['age'] = 22;
		//var_dump($operation->update($id, $data));
		//var_dump($operation->checkIsUpdated($id));
		$user = $operation->get($id);
		echo $user->username;
		*/
		exit;
	}

}