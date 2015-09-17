<?php
namespace Blog\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
/**
 * Users模型
 * @author hongker
 * @version 1.0
 */
class Users extends BaseModel {
	
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联articles表
		$this->hasMany("id", "Blog\Models\Articles", "author_id", array(
              'alias' => 'Articles'
         ));
		
		$this->skipAttributesOnUpdate(array('email','username'));
	}
	
	public function beforeCreate() {
		parent::beforeCreate();
		$this->picture = '/images/common_user.png';
	}
	
	public function beforeUpdate() {
		parent::beforeUpdate();
		$this->age = 0;
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = new PresenceOf(array(
				"field" => 'username',
				"message" => 1000,
		));
		$validates[] = new PresenceOf(array(
				"field" => 'email',
				"message" => 1003,
		));
		
		$validates[] = new Uniqueness(array(
				"field"   => "username",
				"message" => 1004,
		));
		
		$validates[] = new Uniqueness(array(
				"field"   => "email",
				"message" => 1005,
		));
		
		$validates[] = new EmailValidator(array(
				'field' => 'email',
				'message' => 1006,
		));
		
		if($this->validateAll($validates)==false) {
			return false;
		}
		
	}
	
}