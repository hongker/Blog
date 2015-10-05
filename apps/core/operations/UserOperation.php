<?php
namespace Blog\Operations;

use Blog\Models\Users;
use Blog\Utils\Redis;
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
	 * @return array
	 */
	public function save(Array $data) {
		if(empty($data['username'])) {
			$return['errNo'] = 1010;
			return $return;
		}
		
		if(empty($data['email'])) {
			$return['errNo'] = 1003;
			return $return;
		}
		
		if(empty($data['password'])) {
			$return['errNo'] = 1007;
			return $return;
		}
		
		$user = new Users();
		foreach ($data as $key=>$value) {
			$user->$key = $value;
		}
		
		if(!isset($data['type'])) {
			$user->type = 1;
		}
		$return['errNo'] = 0;
		if($user->save()==true) {
			$return['user_id'] = $user->id;
		}else {
			foreach ($user->getMessages() as $message) {
				$return['errNo'] = $message;
			}
		}
		return $return;
	}
	
	/**
	 * 查找某个用户
	 * @param int|string $param
	 */
	public function findOne($param) {
		return Users::findFirst($param);
	}
	
	/**
	 * 根据条件查找用户信息
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Users::find($condition);
	}
	
	/**
	 * 根据用户id更改用户信息
	 * @param unknown $id
	 * @param array $array
	 * @return boolean 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$user = $this->get($id);
		if($user) {
			foreach ($array as $key=>$value) {
				$user->$key = $value;
			}
			if($user->update()==true) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1013;
			}
		}else {
			$return['errNo'] = 1011;
		}
		
		return $return;
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
						'picture'=>$user->picture,
					);
					if($user->type==1) {
						$this->store('user',$userSession);
						$this->storeLoginTimes($user->id);
						$return['isAdmin'] = 0;
					}elseif($user->type==2) {
						$this->store('admin',$userSession);
						$return['isAdmin'] = 1;
					}
					
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
			$user = $this->findOne("username='{$condition['username']}'");
			if($this->getService('security')->checkHash($condition['password'],$user->password)) {
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
							$return = $this->save($info);
							
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
			$return['errNo'] = 1010;
		}
		
		$logString = $this->getLogString('用户注册',$return['errNo']);
		
		if($return['errNo']==0) {
			$user = $this->get($return['user_id']);
			$userSession = array(
					'id'=>$user->id,
					'username'=>$user->username,
					'picture'=>$user->picture,
			);
			if($user->type==1) {
				$this->store('user',$userSession);
				$this->storeLoginTimes($user->id);
				$return['isAdmin'] = 0;
			}
			
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
	
	/**
	 * 修改密码
	 * @param array $data
	 */
	public function changePass(Array $data) {
		if(empty($data['email'])) {
			$return['errNo'] = 1003;
			return $return;
		}
		
		if(empty($data['password'])) {
			$return['errNo'] = 1007;
			return $return;
		}
		
		$user = $this->findOne("email='{$data['email']}'");
		
		if(!$user) {
			$return['errNo'] = 1011;
			return $return;
		}
		
		$user->password = $this->getService('security')->hash($data['password']);
		
		if($user->update()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('修改密码',$return['errNo']);
			$this->log($logString,'info');
		}else {
			$return['errNo'] = 1012;
			$logString = $this->getLogString('修改密码',$return['errNo']);
			$this->log($logString,'error');
		}
		
		return $return;
		
	}
	
	/**
	 * 记录登陆次数
	 * @param unknown $user_id
	 */
	public function storeLoginTimes($user_id) {
		$redis = new Redis();
		$key = 'user_login';
		$redis->zIncrBy($key, 1, "user:$user_id");
	}
	
	/**
	 * 获取活跃用户
	 * @param int $limit
	 */
	public function getActives($limit = 5) {
		$redis = new Redis();
		$key = 'user_login';
		$result = $redis->zrevrange($key,0,$limit);
		$users = array();
		foreach ($result as $value) {
			$user_id = explode(':', $value)[1];
			$user = $this->get($user_id);
			if($user) {
				$users[] = $user;
			}
		}
		
		return $users;
	}
	
	public function testObserver() {
		$observer = new SendMailObserver('xiaok2013@qq.com', '中秋', '去哪儿玩？');
		$this->subject->attach($observer,self::OBSERVER_TYPE_REGISTER);
		
		$this->subject->notify(self::OBSERVER_TYPE_REGISTER);
	}
	
}