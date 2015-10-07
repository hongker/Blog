<?php
namespace Blog\Models;
use Blog\Utils\Redis;
/**
 * Questions模型
 * @author hongker
 * @version 1.0
 */
class Questions extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
         ));
		
		$this->hasMany("id", "Blog\Models\Answers", "question_id", array(
				'alias' => 'Answers'
		));
	}
	
	/**
	 * 插入前的操作
	 */
	public function beforeCreate() {
		$this->code = $this->getCode();
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 2301);
		$validates[] = $this->setPresenceOf('title', 2302);
		$validates[] = $this->setPresenceOf('content', 2303);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
	/**
	 * 获取阅读量
	 * @return number
	 */
	public function getView() {
		$key = 'question_view';
		$redis = new Redis();
		$view = $redis->zScore($key, 'question:'.$this->id);
		if($view) {
			return $view;
		}
		return 0;
	}
}