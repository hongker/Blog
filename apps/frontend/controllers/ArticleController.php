<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\TypeOperation;
/**
 * 资讯控制器
 * @author hongker
 * @version 1.0
 */
class ArticleController extends BaseController
{
	protected $types;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('资讯');
		parent::initialize();
		$this->operation = new ArticleOperation($this->di);
		$typeOperation = new TypeOperation($this->di);
		$this->types = $typeOperation->findAll(array("conditions"=>"is_delete=0"));
	}

	/**
	 * 资讯列表
	 */
	public function indexAction() {
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$articles = $this->operation->findAll(array(
				"conditions"=>"is_delete=0 and status=1",
				"order"=>"created_at desc"
		));
		
		$page = $this->getPaginate($articles,$currentPage);
		
		$users = $this->operation->getUsersByCount();
		
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',0);
		$this->view->setVar('types',$this->types);
		$this->view->setVar('users',$users);
	}
	
	/**
	 * 文章分类
	 */
	public function classifyAction() {
		$id =  $this->dispatcher->getParam(0);
		
		$articles = $this->operation->classify($id);
		
		$currentPage = $this->getQuery('page','int')?$this->getQuery('page','int'):1;
		
		$page = $this->getPaginate($articles,$currentPage);
		
		$users = $this->operation->getUsersByCount();
		
		$this->view->setVar('users',$users);
		$this->view->setVar('page',$page);
		$this->view->setVar('currentType',$id);
		$this->view->setVar('types',$this->types);
		$this->view->pick('article/index');
	}
	
	/**
	 * 文章详情
	 */
	public function infoAction() {
		$id =  $this->dispatcher->getParam(0);
		//if (!$this->checkViewCacheExist($this->getViewKey($id))) {
			$article = $this->operation->get($id);
			
			if($article) {
				$article->author = $article->getAuthor();
					
				$comments = $article->getComments();
				$article->view = $this->operation->addView($id);
					
				$result = $this->operation->getRecommends($id);
				if($result['errNo']==0) {
					$recommendArticles = $result['articles'];
				}else {
					$recommendArticles = array();
				}
				$this->view->setVar('article',$article);
				$this->view->setVar('recommendArticles',$recommendArticles);
				$this->view->setVar('comments',$comments);
					
			}else {
				$this->show404();
			}
		//}
		
		//$this->setViewCache($this->getViewKey($id),300);
	}
	
}
