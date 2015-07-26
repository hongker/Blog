<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\TypeOperation;
/**
 * 资讯控制器
 * @author hongker
 *
 */
class ArticleController extends BaseController
{
	protected $typeOperation;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('资讯');
		parent::initialize();
		$this->operation = new ArticleOperation($this->di);
		$this->typeOperation = new TypeOperation($this->di);
	}

	/**
	 * 资讯列表
	 */
	public function indexAction() {
		$articles = $this->operation->findAll();
		
		$this->view->setVar('articles',$articles);
		$this->view->setVar('types',$this->typeOperation->findAll());
	}
	
	/**
	 * 文章详情
	 */
	public function infoAction() {
		$id =  $this->dispatcher->getParam(0);
		
		$article = $this->operation->get($id);
		
		if($article) {
			$article->author = $article->getAuthor();
			
			$artiles->comments = $article->getComments();
			$this->view->setVar('article',$article);
			
			//使用视图缓存
			$this->view->cache(array(
					"lifetime" => 300,
					"key"=>$this->controller.'_'.$this->action.'_'.$id,
			));
		}else {
			$this->show404();
		}
	}
	
	/**
	 * 添加文章
	 */
	public function addAction() {
		$data['title'] = 'test for title';
		$data['author_id'] = 1;
		//$data['content'] = 'test for content';
		
		$this->operation->save($data);
		$this->flashSession->output();
		exit;
	}
	
	/**
	 * 编辑文章
	 */
	public function editAction() {
		$id = 1;
		$data['content'] = 'test for cache1';
		
		if($this->operation->update($id, $data)) {
			echo 1;
		}
		exit;
	}

}
