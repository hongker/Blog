<?php
namespace Blog\Models;
use Phalcon\Mvc\Model;

class BaseModel extends Model {
	public $updated_at;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		$this->skipAttributes(array('created_at', ));
		
		$this->skipAttributesOnCreate(array('updated_at'));
	}
	
	/**
	 * 更新前的操作
	 */
	public function beforeUpdate() {
		$this->updated_at = date('Y-m-d H:i:s');
	}
	
	/**
	 * 验证字段是否合法
	 * @param array $array
	 * @return boolean
	 */
	protected function validateAll(Array $array) {
		foreach ($array as $validator) {
			if($this->validate($validator)==false) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 重写validate方法
	 * @param unknown $validator
	 * @return boolean
	 */
	protected function validate($validator) {
		parent::validate($validator);
		
		if ($this->validationHasFailed() == true) {
			return false;
		}
		return true;
	}
	
}