<?php
namespace Blog\Models;
/**
 * Types模型
 * @author hongker
 *
 */
class Types extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		//关联users表
		$this->hasMany("id", "Blog\Models\Articles", "type_id", array(
              'alias' => 'Articles'
         ));
		
	}
}