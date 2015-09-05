<?php
namespace Blog\Frontend\Controllers;
/**
 * 关于Blog控制器
 * @author hongker
 * @version 1.0
 */
class AboutController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('关于Blog');
		parent::initialize();
		
	}

	public function indexAction(){
		
	}
	
	

}