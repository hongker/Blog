<?php
namespace Blog\Backend\Controllers;
use Blog\Controllers\Controller;
/**
 * 基础控制器
 * @author hongker
 * @version 1.0
 */
class BaseController extends Controller
{
	protected $admin;
	/**
	 * 初始化
	 */
	protected function initialize() {
		parent::initialize();
        //Prepend the application name to the title
        \Phalcon\Tag::prependTitle('Blog | ');
        
        if($this->checkIsLogin()) {
        	$this->admin = $this->session->get('admin');
        }else {
        	$this->response->redirect('/login',true);
        }
        
        $this->view->setTemplateAfter('common');
    }
    
    /**
     * 检查管理员是否登录
     * @return boolean
     */
    protected function checkIsLogin() {
    	if($this->session->has('admin')) {
    		return true;
    	}
    	return false;
    }
    
        
    
}