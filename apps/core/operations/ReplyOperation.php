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
	 * @return Users 返回回复
	 */
	public function get($id) {
		return Replies::findFirst($id);
	}
	
	/**
	 * 添加回复
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 1301;
			return $return;
		}
		if(empty($data['target_id'])) {
			$return['errNo'] = 1302;
			return $return;
		}
		if(empty($data['comment_id'])) {
			$return['errNo'] = 1303;
			return $return;
		}
		if(empty($data['content'])) {
			$return['errNo'] = 1304;
			return $return;
		}
		
		
		$reply = new Replies();
		foreach ($data as $key=>$value) {
			$reply->$key = $value;
		}
		
		if($reply->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1305;
		}
		return $return;
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
		
		if($reply->update()) {
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