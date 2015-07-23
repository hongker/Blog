<?php
namespace Blog\Models;
/**
 * Articles模型
 * @author hongker
 *
 */
class Articles extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
          ));
		
		$this->hasMany("id", "Blog\Models\Comments", "article_id", array(
				'alias' => 'Comments'
		));
	}
}