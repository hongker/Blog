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
	
	/**
	 * 上传图片
	 */
	public function imgAction() {
		if($this->request->isPost()) {
			if ($this->request->hasFiles() == true) {
				$file = $this->request->getUploadedFiles()[0];
				
				$folder = $this->getFolder();
				
				if ( $folder === false ) {
					$return['errNo'] = 1107;
					return;
				}
				
				$file->moveTo($folder.$file->getName());
				//$image = new \Phalcon\Image\Adapter\GD($dir.$file->getName());
				//$image->resize(590, 330);
				//$image->save();
				
				$return['path'] = '/'.$folder.$file->getName();
				$return['errNo'] = 0;
			}else {
				//错误：未选择文件
				$return['errNo'] = 1105;
			}
		}else {
			$return['errNo'] = 1002;
		}
		
		$return['errMsg'] = $this->getErrorMessage($return['errNo']);
		$this->json_return($return);
	}
	
	/**
	 * 按照日期自动创建存储文件夹
	 * @return string
	 */
	private function getFolder()
	{
		$pathStr = 'uploads/';
		$pathStr .= date( "Ymd" ).'/';
		if ( !file_exists( $pathStr ) ) {
			if ( !mkdir( $pathStr , 0777 , true ) ) {
				return false;
			}
		}
		return $pathStr;
	}
	

}