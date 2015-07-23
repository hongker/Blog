<?php
namespace Blog\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
/**
 * Users模型
 * @author hongker
 *
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
		$this->setup(
				array('notNullValidations'=>false)
		);
		
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = new PresenceOf(array(
				"field" => 'username',
				"message" => '用户名不能为空'
		));
		$validates[] = new PresenceOf(array(
				"field" => 'email',
				"message" => '邮箱不能为空'
		));
		
		$validates[] = new Uniqueness(array(
				"field"   => "username",
				"message" => "该用户名已被使用"
		));
		
		$validates[] = new Uniqueness(array(
				"field"   => "email",
				"message" => "该邮箱已被使用"
		));
		
		$validates[] = new EmailValidator(array(
				'field' => 'email',
				'message' => '邮箱格式不正确'
		));
		
		if($this->validateAll($validates)==false) {
			return false;
		}
		
	}
	
}