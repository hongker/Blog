<?php
namespace Blog\Models;
/**
 * Users模型
 * @author hongker
 *
 */
class Users extends BaseModel {
	
	/**
	 * 模型初始化
	 */
	public function initialize() {
		//关联articles表
		$this->hasMany("id", "Blog\Models\Articles", "author_id", array(
              'alias' => 'Articles'
         ));
	}
}