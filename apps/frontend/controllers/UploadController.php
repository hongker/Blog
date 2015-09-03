<?php
namespace Blog\Frontend\Controllers;
/**
 * 上传控制器
 * @author hongker
 * @version 1.0
 */
class UploadController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('上传');
		parent::initialize();
		
	}

	public function indexAction(){
		$this->show404();
	}
	
	public function imgAction() {
		echo 'upload/img';exit;
	}
	
	

}