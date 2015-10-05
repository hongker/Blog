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
		
		//关联地址表
		$this->belongsTo("address_id", "Blog\Models\Address", "id", array(
				'alias' => 'Address'
		));
		
		$this->skipAttributesOnUpdate(array('email','username'));
	}
	
	/**
	 * 添加用户信息
	 * @see \Blog\Models\BaseModel::beforeCreate()
	 */
	public function beforeCreate() {
		parent::beforeCreate();
		$this->age = 0;
		$this->sex = 'N'; //默认保密
		$this->picture = '/images/common_user.png';
		$this->address_id = 1;
	}
	
	/**
	 * 修改用户信息
	 * @see \Blog\Models\BaseModel::beforeUpdate()
	 */
	public function beforeUpdate() {
		parent::beforeUpdate();
	}
	
	public function getSex() {
		if($this->sex=='M') {
			return '男';
		}elseif($this->sex=='F') {
			return '女';
		}if($this->sex=='N') {
			return '保密';
		}
		
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = new PresenceOf(array(
				"field" => 'username',
				"message" => 1010,
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