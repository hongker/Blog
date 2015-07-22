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
		$operation = new ArticleOperation();
		$author = $operation->getAuthor(1);
		echo $author->username;exit;
	}

}