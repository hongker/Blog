<?php
namespace Blog\Backend\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\CommentOperation;
/**
 * 管理首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('管理首页');
		parent::initialize();
	}

	/**
	 * 系统首页
	 */
	public function indexAction() {
		$articleOperation = new ArticleOperation($this->di);
		
		$articles = $articleOperation->findAll(array(
			'conditions' => 'is_delete = 0',
			'order' => 'created_at desc',
			'limit' => 5,
		));
		
		$commentOperation = new CommentOperation($this->di);
		$comments = $commentOperation->findAll(array(
			'conditions' => 'is_delete = 0',
			'order' => 'created_at desc',
			'limit' => 5,
		));
		
		$this->view->setVar('articles',$articles);
		$this->view->setVar('comments',$comments);
	}

}