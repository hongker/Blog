<?php
namespace Blog\Models;
/**
 * Answers模型
 * @author hongker
 * @version 1.0
 */
class Answers extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
         ));
		
		$this->belongsTo("question_id", "Blog\Models\Questions", "id", array(
				'alias' => 'Question'
		));
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 2401);
		$validates[] = $this->setPresenceOf('question_id', 2403);
		$validates[] = $this->setPresenceOf('content', 2402);
		
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}