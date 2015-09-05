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
		$validates[] = new PresenceOf(array(
				"field" => 'email',
				"message" => 1501,
		));
		$validates[] = new PresenceOf(array(
				"field" => 'name',
				"message" => 1502,
		));
		$validates[] = new PresenceOf(array(
				"field" => 'content',
				"message" => 1503
		));
		$validates[] = new EmailValidator(array(
				'field' => 'email',
				'message' => 1505,
		));
		
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}