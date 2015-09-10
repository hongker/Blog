<?php
namespace Blog\Models;
use Blog\Utils\Redis;
/**
 * Collects模型
 * @author hongker
 * @version 1.0
 */
class Collects extends BaseModel {
	
	/**
	 * 模型初始化
	 */
	public function initialize() {
		
		parent::initialize();
		//关联users表
		$this->belongsTo("user_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
          ));
		
		$this->skipAttributesOnUpdate(array('user_id','target_id'));
		$this->skipAttributesOnCreate(array('status'));
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('user_id', 1601);
		$validates[] = $this->setPresenceOf('target_id', 1602);
		$validates[] = $this->setPresenceOf('type', 1603);
		
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}