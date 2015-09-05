<?php
namespace Blog\Frontend\Controllers;
use Blog\Controllers\Controller;

/**
 * 基础控制器
 * @author hongker
 * @version 1.0
 */
class BaseController extends Controller
{
	/**
	 * 初始化
	 */
	protected function initialize() {
		parent::initialize();
        //Prepend the application name to the title
        \Phalcon\Tag::prependTitle('Blog | ');
        $this->view->setTemplateAfter('common');
        
    }
}