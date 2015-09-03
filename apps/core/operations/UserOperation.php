<?php
namespace Blog\Operations;

use Blog\Models\Users;
/**
 * 用户信息操作类
 * @author hongker
 * @version 1.0
 */
class UserOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('user.log');
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
	public function login(Array $info) {
		$return = array();
		if($info['username']) {
			if($this->checkUserExist($info['username'])) {
				if($this->checkPassword($info)) {
					$user = Users::findFirst("username='$info[username]'");
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
				$return['errNo'] = 1011;
			}
		}else {
			$return['errNo'] = 1010;
		}
		
		$logString = "IP:{$this->ip},用户名:{$info['username']}登录，errNo：{$return['errNo']}";
		
		if($return['errNo']==0) {
			$this->log($logString,'info');
		}else {
			$this->log($logString,'error');
		}
		
		return $return;
	}
	
	
	/**
	 * 检查用户是否存在
	 * @param string $username
	 * @return boolean
	 */
	public function checkUserExist($username) {
		$user = Users::findFirst("username='$username'");
		
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
		$user = Users::findFirst("email='$email'");
	
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
			$user = Users::findFirst(array("username='$condition[username]'"));
			
			if($this->getDI()->get('security')->checkHash($condition['password'],$user->password)) {
				return true;
			}
		
		return false;
	}
	
	/**
	 * 用户注册
	 * @param array $info
	 * @return array
	 */
	public function register(Array $info) {
		$return = array();
		if($info['username']) {
			if(!$this->checkUserExist($info['username'])) {
				if($info['email']) {
					if(!$this->checkEmailExist($info['email'])) {
						if($info['password']) {
							$info['password'] = $this->getDI()->get('security')->hash($info['password']);
							if($this->save($info)) {
								$return['errNo'] = 0;
							}
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
		
		$logString = "IP:{$this->ip},用户名:{$info['username']}注册，errNo：{$return['errNo']}";
		
		if($return['errNo']==0) {
			$this->log($logString,'info');
		}else {
			$this->log($logString,'error');
		}
		
		return $return;
	}	
	
	/**
	 * 退出
	 * @return boolean
	 */
	public function logout() {
		if($this->getDI()->get('session')->destroy()) {
			return true;
		}
		return false;
	}
	
}