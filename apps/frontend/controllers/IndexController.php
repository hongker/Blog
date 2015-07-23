<?php
namespace Blog\Frontend\Controllers;
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
		for($i=1;$i<50;$i++) {
			echo $i;
		}
	}

}