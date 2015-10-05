<?php
namespace Blog\Models;
/**
 * Tasks 模型
 * @author hongker
 * @version 1.0
 */
class Tasks extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		
		$this->skipAttributesOnUpdate(array('author_id'));
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('title', 2201);
		$validates[] = $this->setPresenceOf('content', 2202);
		$validates[] = $this->setPresenceOf('start_date', 2203);
		$validates[] = $this->setPresenceOf('end_date', 2204);
		$validates[] = $this->setPresenceOf('author_id', 2205);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}