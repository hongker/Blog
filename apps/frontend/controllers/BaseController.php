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
	protected $controller;
	protected $action;
	protected $error;
	protected $operation ;
	
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
    
    public function beforeExecuteRoute($dispatcher) {
    	$this->controller = $dispatcher->getControllerName();
    	$this->action = $dispatcher->getActionName();
    	$config = new \Phalcon\Config\Adapter\Ini ( "../apps/configs/config.ini" );
    	$this->error = $config->message->error;
    }
    
    /**
     * 输出json数据
     * @param array $array
     */
    public function json_return(Array $array) {
    	echo json_encode($array);exit;
    }
}