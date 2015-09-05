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
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
          ));
		
		$this->belongsTo("type_id", "Blog\Models\Types", "id", array(
				'alias' => 'Type'
		));
		
		$this->hasMany("id", "Blog\Models\Comments", "target", array(
				'alias' => 'Comments'
		));
		$this->skipAttributesOnUpdate(array('author_id'));
		
	}
	
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('title', 1102);
		$validates[] = $this->setPresenceOf('digest', 1103);
		$validates[] = $this->setPresenceOf('type_id', 1104);
		$validates[] = $this->setPresenceOf('picture', 1105);
		$validates[] = $this->setPresenceOf('author_id', 1106);
		$validates[] = $this->setPresenceOf('content', 1108);
		
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
}