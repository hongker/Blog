<?php
namespace Blog\Models;
/**
 * Types模型
 * @author hongker
 * @version 1.0
 */
class Types extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联users表
		$this->hasMany("id", "Blog\Models\Articles", "type_id", array(
              'alias' => 'Articles'
         ));
		
	}
}