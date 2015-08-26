<?php
namespace Blog\Operations;

use Blog\Models\Replies;
/**
 * 回复操作类
 * @author hongker
 * @version 1.0
 */
class ReplyOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取回复信息
	 * @param int $id
	 * @return Users 返回文章
	 */
	public function get($id) {
		return Replies::findFirst($id);
	}
	
	/**
	 * 添加回复
	 * @param array $data
	 * @return boolean
	 */
	public function save(Array $data) {
		$reply = new Replies();
		foreach ($data as $key=>$value) {
			$reply->$key = $value;
		}
		
		if($reply->save()==true) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据id更改回复信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$reply = $this->get($id);
		foreach ($array as $key=>$value) {
			$reply->$key = $value;
		}
		
		if($reply->save()) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据id删除回复信息
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$reply = $this->get($id);
		
		if ($reply != false) {
			if ($reply->delete() != false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据id获取回复作者信息
	 * @param unknown $id
	 * 
	 */
	public function getAuthor($id) {
		$reply =$this->get($id);
		return $reply->getAuthor();
	}
	
	/**
	 * 根据id获取评论目标信息
	 * @param int $id
	 */
	public function getTarget($id) {
		$reply =$this->get($id);
		return $reply->getTarget();
	}
}