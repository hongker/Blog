<?php
namespace Blog\Frontend\Controllers;
use Phalcon\Mvc\Controller;


/**
 * 基础控制器
 * @author hongker
 *
 */
class BaseController extends Controller
{
	protected function initialize() {
        //Prepend the application name to the title
        \Phalcon\Tag::prependTitle('Blog | ');
        $this->view->setTemplateAfter('common');
    }
    
    /**
     * 跳转到404页面
     */
    public function show404() {
		$this->response->redirect('404.html');
		$this->response->send();
    }
    
}