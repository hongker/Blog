<?php
namespace Blog\Frontend\Controllers;
/**
 * 联系我们控制器
 * @author hongker
 * @version 1.0
 */
class ContactController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('联系我们');
		parent::initialize();
		
	}

	public function indexAction(){
		
	}
	
	

}