<?php
namespace Blog\Models;
use Phalcon\Mvc\Model\Validator\PresenceOf;
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
		$validates[] = new PresenceOf(array(
				"field" => 'title',
				"message" => '文章标题不能为空'
		));
		$validates[] = new PresenceOf(array(
				"field" => 'content',
				"message" => '文章内容不能为空'
		));
		$validates[] = new PresenceOf(array(
				"field" => 'author_id',
				"message" => '作者不能为空'
		));
		$validates[] = new PresenceOf(array(
				"field" => 'type_id',
				"message" => '文章类型不能为空'
		));
	
		
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}