<?php
namespace Blog\Models;
/**
 * Replies模型
 * @author hongker
 * @version 1.0
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
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 1301);
		$validates[] = $this->setPresenceOf('target_id', 1302);
		$validates[] = $this->setPresenceOf('comment_id', 1303);
		$validates[] = $this->setPresenceOf('content', 1304);
		
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}