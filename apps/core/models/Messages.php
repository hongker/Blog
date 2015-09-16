<?php
namespace Blog\Models;
/**
 * Messages模型
 * @author hongker
 * @version 1.0
 */
class Messages extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
				'alias' => 'Author'
		));
		
		//关联users表
		$this->belongsTo("target_id", "Blog\Models\Users", "id", array(
				'alias' => 'Target'
		));
		$this->skipAttributesOnCreate(array('status'));
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 1801);
		$validates[] = $this->setPresenceOf('target_id', 1802);
		$validates[] = $this->setPresenceOf('content', 1803);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}