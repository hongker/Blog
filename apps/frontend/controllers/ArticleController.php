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
		$this->view->setTemplateAfter('common');
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
		
		$article->author = $this->operation->getAuthor($id);
		
		$this->view->setVar('article',$article);
		$this->view->cache(array(
				"lifetime" => 3600
		));
	}
	
	public function editAction() {
		$id = 1;
		$data['content'] = 'test for update';
		
		if($this->operation->update($id, $data)) {
			echo 1;
		}
		exit;
	}

}