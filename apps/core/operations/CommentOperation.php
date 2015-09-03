<?php
namespace Blog\Operations;

use Blog\Models\Comments;
/**
 * 评论操作类
 * @author hongker
 * @version 1.0
 */
class CommentOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取评论信息
	 * @param int $id
	 * @return Users 返回文章
	 */
	public function get($id) {
		return Comments::findFirst($id);
	}
	
	/**
	 * 添加评论
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 1010;
			return $return;
		}
		if(empty($data['content'])) {
			$return['errNo'] = 1027;
			return $return;
		}
		if(empty($data['target'])) {
			$return['errNo'] = 1028;
			return $return;
		}
		if(empty($data['type'])) {
			$return['errNo'] = 1029;
			return $return;
		}
		$comment = new Comments();
		foreach ($data as $key=>$value) {
			$comment->$key = $value;
		}
	
		if($comment->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1011;
		}
		return $return;
	}
	
	/**
	 * 根据id更改评论信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$comment = $this->get($id);
		foreach ($array as $key=>$value) {
			$comment->$key = $value;
		}
		
		if($comment->save()) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据id删除评论信息
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$comment = $this->get($id);
		
		if ($comment != false) {
			if ($comment->delete() != false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据id获取评论作者信息
	 * @param unknown $id
	 * 
	 */
	public function getAuthor($id) {
		$comment =$this->get($id);
		return $comment->getAuthor();
	}
	
	/**
	 * 根据id获取评论文章信息
	 * @param array $condition
	 */
	public function getArticle($id) {
		$comment =$this->get($id);
		return $comment->getArticle();
	}
	
	/**
	 * 获取回复内容
	 * @param unknown $id
	 */
	public function getReplies($id) {
		$comment =$this->get($id);
		return $comment->getReplies();
	}
}