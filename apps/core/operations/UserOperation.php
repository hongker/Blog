<?php
namespace Blog\Operations;

use Blog\Models\Users;
/**
 * 用户信息操作类
 * @author hongker
 *
 */
class UserOperation extends BaseOperation implements Operation {
	/**
	 * 获取用户信息
	 * @return string
	 */
	public function __construct() {
		
	}
	
	/**
	 * 根据用户id获取用户信息
	 * @param int $id
	 * @return Users 返回用户类型
	 */
	public function get($id) {
		return Users::findFirst($id);
	}
	
	/**
	 * 根据用户id更改用户信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$user = $this->get($id);
		foreach ($array as $key=>$value) {
			$user->$key = $value;
		}
		
		if($user->save()) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据用户id删除用户信息
	 * @param int $id
	 * @return 成功返回true,失败返回false
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
	 */
	public function getArticles($id) {
		$user = $this->get($id);
		return $user->getArticles();
	}
	
}