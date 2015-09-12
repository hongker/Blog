<?php
namespace Blog\Models;
/**
 * Collects模型
 * @author hongker
 * @version 1.0
 */
class Collects extends BaseModel {
	public $type;
	public $target;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
          ));
		
		$this->skipAttributesOnUpdate(array('user_id','target_id'));
		$this->skipAttributesOnCreate(array('status'));
	}
	
	public function getTarget() {
		if($this->type==1) {
			$this->target = Articles::findFirst($this->target_id);
		}
		
		return $this->target;
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 1601);
		$validates[] = $this->setPresenceOf('target_id', 1602);
		$validates[] = $this->setPresenceOf('type', 1603);
		
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}