<?php
namespace Blog\Models;
/**
 * Address 模型
 * @author hongker
 * @version 1.0
 */
class Address extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('name', 2001);
		$validates[] = $this->setPresenceOf('parent_id', 2002);
		$validates[] = $this->setPresenceOf('level', 2003);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}