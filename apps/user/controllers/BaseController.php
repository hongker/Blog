<?php
namespace Blog\User\Controllers;
use Blog\Controllers\Controller;


/**
 * 基础控制器
 * @author hongker
 * @version 1.0
 */
class BaseController extends Controller
{
	/**
	 * 用户session
	 * @var array
	 */
	protected $user;
	
	/**
	 * 初始化
	 */
	protected function initialize() {
		parent::initialize();
        //Prepend the application name to the title
        \Phalcon\Tag::prependTitle('Blog | ');
        $this->view->setTemplateAfter('common');
    }
    
    /**
     * @param unknown $dispatcher
     */
    public function beforeExecuteRoute($dispatcher) {
    	parent::beforeExecuteRoute($dispatcher);
    	if($this->checkIsLogin()) {
    		$this->user = $this->session->get('user');
    	}
    	
    }
    
}