<?php
namespace Blog\Operations;
use Blog\Models\Articles;
/**
 * 文章操作类
 * @author hongker
 * @version 1.0
 */
class ArticleOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('article.log');
	}
	
	/**
	 * 根据文章id获取文章信息
	 * @param int $id
	 * @return Users 返回文章
	 */
	public function get($id) {
		$article = Articles::findFirst($id);
		
		return $article;
	}
	
	/**
	 * 添加阅读量
	 * @param unknown $id
	 */
	public function addView($id) {
		$key = 'article_view';
		return $this->redis->zIncrBy($key,1,"article_$id");
	}
	
	/**
	 * 添加文章
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data) {
		if(empty($data['title'])) {
			$return['errNo'] = 1102;
			return $return;
		}
		
		if(empty($data['picture'])) {
			$return['errNo'] = 1106;
			return $return;
		}
		
		if(empty($data['digest'])) {
			$return['errNo'] = 1103;
			return $return;
		}
		
		if(empty($data['type_id'])) {
			$return['errNo'] = 1104;
			return $return;
		}
		
		if(empty($data['class'])) {
			$return['errNo'] = 1115;
			return $return;
		}
		
		
		$article = new Articles();
		foreach ($data as $key=>$value) {
			$article->$key = $value;
		}
	
		if($article->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('添加文章', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1015;
			foreach ($article->getMessages() as $message) {
				$logString = $this->getLogString('添加文章', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}
	
	/**
	 * 根据文章id更改文章信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$article = $this->get($id);
		if($article) {
			if(empty($array['title'])) {
				$return['errNo'] = 1016;
				return $return;
			}
			
			if(empty($array['picture'])) {
				$return['errNo'] = 1105;
				return $return;
			}
			
			if(empty($array['digest'])) {
				$return['errNo'] = 1017;
				return $return;
			}
			
			if($array['type_id']==0) {
				$return['errNo'] = 1018;
				return $return;
			}
			
			foreach ($array as $key=>$value) {
				$article->$key = $value;
			}
			
			if($article->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1020;
			}
		}else {
			$return['errNo'] = 1110;
		}
		
		return $return;
	}
	
	/**
	 * 通过审核
	 * @param int $id
	 * @return array
	 */
	public function check($id) {
		$article = $this->get($id);
		
		if($article) {
			if($article->status==1) {
				$return['errNo'] = 1111;
			}else {
				$article->status = 1;
				if($article->update()) {
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1112;
				}
			}
		}else {
			$return['errNo'] = 1110;
		}
		return $return;
	}
	
	/**
	 * 驳回审核
	 * @param int $id
	 * @return array
	 */
	public function  reject($id) {
		$article = $this->get($id);
	
		if($article) {
			if($article->status==0) {
				$return['errNo'] = 1113;
			}else {
				$article->status = 0;
				if($article->update()) {
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1114;
				}
			}
		}else {
			$return['errNo'] = 1110;
		}
		return $return;
	}
	
	/**
	 * 根据文章id删除文章信息
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$article = $this->get($id);
		
		if ($article != false) {
			if ($article->delete() != false) {
				$logString = $this->getLogString('删除文章');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据文章id获取作者信息
	 * @param unknown $id
	 * 
	 */
	public function getAuthor($id) {
		$article =$this->get($id);
		return $article->getAuthor();
	}
	
	/**
	 * 根据条件查找文章数据
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Articles::find($condition);
	}
	
	/**
	 * 根据类型获取文章
	 * @param unknown $type
	 */
	public function classify($type) {
		return $this->findAll(array(
				"conditions"=>"type_id=$type and status=1 and is_delete=0",
				"order"=>"created_at desc",
		));
	}
	
	/**
	 * 判断用户是否为文章作者
	 * @param int $id 文章id
	 * @param int $user_id 用户id
	 * @return boolean
	 */
	public function checkIsAuthor($id,$user_id) {
		$article = $this->get($id);
		
		if($article&&$article->author_id==$user_id) {
			return true;
		}
		return false;
		
	}
}