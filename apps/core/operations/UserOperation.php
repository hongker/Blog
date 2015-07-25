<?php
namespace Blog\Operations;

use Blog\Models\Users;
/**
 * 用户信息操作类
 * @author hongker
 *
 */
class UserOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据用户id获取用户信息
	 * @param int $id
	 * @return Users
	 */
	public function get($id) {
		return Users::findFirst($id);
	}
	
	/**
	 * 添加用户信息
	 * @param array $data
	 * @return boolean
	 */
	public function save(Array $data) {
		$user = new Users();
		foreach ($data as $key=>$value) {
			$user->$key = $value;
		}
		if(!isset($data['type'])) {
			$user->type = 1;
		}
		
		if($user->save()==true) {
			return true;
		}else {
			foreach ($user->getMessages() as $message) {
				$this->getDI()->get('flash')->error($message);
			}
		}
		return false;
	}
	
	/**
	 * 根据用户id更改用户信息
	 * @param unknown $id
	 * @param array $array
	 * @return boolean 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$user = $this->get($id);
		foreach ($array as $key=>$value) {
			$user->$key = $value;
		}
		
		if($user->update()==true) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据用户id删除用户信息
	 * @param int $id
	 * @return boolean 成功返回true,失败返回false
	 */
	public function delete($id) {
		$user = $this->get($id);
		
		if ($user != false) {
			if ($user->delete() != false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据用户id获取他的文章
	 * @param unknown $id
	 * @return Articles
	 */
	public function getArticles($id) {
		$user = $this->get($id);
		return $user->getArticles();
	}
	
	/**
	 * 用户登录
	 * @param array $user 
	 * @return array
	 */
	public function login(Array $user) {
		$return = array();
		if($user['username']) {
			if($this->checkUserExist(array('username'=>$user['username']))) {
				if($this->checkPassword($user)) {
					$user = Users::findFirst(array('username'=>$user['username']));
					$userSession = array(
						'id'=>$user->id,
						'username'=>$user->username,
					);
					$this->store('user',$userSession);
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1008;
				}
			}else {
				$return['errNo'] = 1001;
			}
		}else {
			$return['errNo'] = 1000;
		}
		
		return $return;
	}
	
	/**
	 * 检查用户是否存在
	 * @param array $condition
	 * @return boolean
	 */
	public function checkUserExist(Array $condition) {
		$user = Users::findFirst($condition);
		
		if($user) {
			return true;
		}
		return false;
	}
	
	/**
	 * 检查邮箱是否已绑定
	 * @param string $email 邮箱
	 * @return boolean
	 */
	public function checkEmailExist($email) {
		$user = Users::findFirst(array('email'=>$email));
	
		if($user) {
			return true;
		}
		return false;
	}
	
	/**
	 * 检查用户密码是否正确
	 * @param array $condition
	 * @return boolean
	 */
	public function checkPassword(Array $condition) {
			$user = Users::findFirst(array('username'=>$condition['username']));
			
			if($this->getDI()->get('security')->checkHash($condition['password'],$user->password)) {
				return true;
			}
		
		return false;
	}
	
	public function register(Array $user) {
		$return = array();
		if($user['username']) {
			if(!$this->checkUserExist(array('username'=>$user['username']))) {
				if($user['email']) {
					if(!$this->checkEmailExist($user['email'])) {
						if($user['password']) {
							
						}else {
							$return['errNo'] = 1007;
						}
					}else {
						$return['errNo'] = 1005;
					}
				}else {
					$return['errNo'] = 1003;
				}
				
			}else {
				$return['errNo'] = 1004;
			}
		}else {
			$return['errNo'] = 1000;
		}
		
		return $return;
	}	
}