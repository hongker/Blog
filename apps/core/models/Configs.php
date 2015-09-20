<?php
namespace Blog\Models;
/**
 * Configs 模型
 * @author hongker
 * @version 1.0
 */
class Configs extends BaseModel {
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
		$validates[] = $this->setPresenceOf('name', 2101);
		$validates[] = $this->setPresenceOf('ckey', 2102);
		$validates[] = $this->setPresenceOf('cvalue', 2103);
		$validates[] = $this->setPresenceOf('description', 2104);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}