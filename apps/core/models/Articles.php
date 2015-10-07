<?php
namespace Blog\Models;
use Blog\Utils\Redis;
/**
 * Articles模型
 * @author hongker
 * @version 1.0
 */
class Articles extends BaseModel {
	public $id;
	public $class;
	public $picture;
	public $created_at;
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
		
		$this->hasMany("id", "Blog\Models\Comments", "target_id", array(
				'alias' => 'Comments'
		));
		$this->skipAttributesOnUpdate(array('author_id','class'));
		$this->skipAttributesOnCreate(array('status'));
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
		$validates[] = $this->setPresenceOf('class', 1108);
		$validates[] = $this->setPresenceOf('picture', 1105);
		$validates[] = $this->setPresenceOf('author_id', 1106);
		$validates[] = $this->setPresenceOf('content', 1108);
		
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
	
	/**
	 * 获取阅读量
	 * @return number
	 */
	public function getView() {
		$key = 'article_view';
		$redis = new Redis();
		$view = $redis->zScore($key, 'article:'.$this->id);
		if($view) {
			return $view;
		}
		return 0;
	}
	
	/**
	 * 获取所属模块名称
	 */
	public function getClass() {
		$class = '普通文章';
		if($this->class==2) {
			$class = '系统公告';
		}
		
		return $class;
			
	}
	
	/**
	 * 判断新建文章时是否设置封面图片
	 * @return boolean
	 */
	public function isSetPicture() {
		$img = explode('/', $this->picture);
		if($img[1]=='images') {
			return false;
		}
		return true;
	}
	
}