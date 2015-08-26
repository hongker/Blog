<?php
namespace Blog\Models;
use Phalcon\Mvc\Model;

/**
 * 基础Model类
 * @author hongker
 * @version 1.0
 */
class BaseModel extends Model {
	public $updated_at;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		$this->skipAttributes(array('created_at', ));
		
		$this->skipAttributesOnCreate(array('updated_at'));
		
		$this->setup(
				array('notNullValidations'=>false)
		);
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