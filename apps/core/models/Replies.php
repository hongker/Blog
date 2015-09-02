<?php
namespace Blog\Models;
/**
 * Replies模型
 * @author hongker
 *
 */
class Replies extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
         ));
		$this->belongsTo("target_id", "Blog\Models\Users", "id", array(
				'alias' => 'Target'
		));
		
		$this->belongsTo("comment_id", "Blog\Models\Comments", "id", array(
				'alias' => 'Comment'
		));
	}
}