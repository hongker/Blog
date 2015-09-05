<?php
namespace Blog\Models;
/**
 * Advices模型
 * @author hongker
 *
 */
class Advices extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		
		$this->skipAttributesOnCreate(array('status'));
		
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('email', 1501);
		$validates[] = $this->setPresenceOf('name', 1502);
		$validates[] = $this->setPresenceOf('content', 1503);
		$validates[] = $this->setEmailValidator('email', 1505);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}