<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\ArticleOperation;
use Blog\Operations\UserOperation;
/**
 * 首页控制器
 * @author hongker
 * @version 1.0
 */
class IndexController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('首页');
		parent::initialize();
		
	}

	public function indexAction(){
		//获取最新文章
		$articleOperation = new ArticleOperation($this->di);
		$articles = $articleOperation->findAll(array(
				"conditions"=>"is_delete=0 and status=1",
				"order"=>"created_at desc",
				"limit"=>5,
		));
		
		//获取活跃用户
		$userOperation = new UserOperation($this->di);
		$users = $userOperation->getActives();
		
		//获取点击周榜
		$week_ranks = $articleOperation->getWeekRanks();
		
		$this->view->setVar('articles',$articles);
		$this->view->setVar('users',$users);
		$this->view->setVar('week_ranks',$week_ranks);
	}
	
	

}