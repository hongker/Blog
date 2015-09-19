<?php
namespace Blog\Models;
/**
 * Tags模型
 * @author hongker
 * @version 1.0
 */
class Tags extends BaseModel {
	public $type;
	public $target_id;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
				'alias' => 'Author'
		));
		
		$this->skipAttributesOnUpdate(array('author_id','target_id'));
	}
	
	/**
	 * 获取标签目标信息
	 * @return unknown
	 */
	public function getTarget() {
		if($this->type==1) {
			$target = Articles::findFirst($this->target_id);
		}elseif($this->type==2) {
			$target = Users::findFirst($this->target_id);
		}
		return $target;
	}
}