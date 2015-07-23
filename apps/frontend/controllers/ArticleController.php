<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\ArticleOperation;
/**
 * 资讯控制器
 * @author hongker
 *
 */
class ArticleController extends BaseController
{
	protected $operation ;
	public function initialize()
	{
		\Phalcon\Tag::setTitle('资讯');
		parent::initialize();
		$this->operation = new ArticleOperation();
	}

	/**
	 * 资讯列表
	 */
	public function indexAction() {
		$articles = $this->operation->findAll();
		
		$this->view->setVar('articles',$articles);
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
	
	public function editAction() {
		$id = 1;
		$data['content'] = 'test for cache1';
		
		if($this->operation->update($id, $data)) {
			echo 1;
		}
		exit;
	}

}
