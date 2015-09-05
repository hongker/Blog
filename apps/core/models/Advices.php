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
}