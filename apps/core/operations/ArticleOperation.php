<?php
namespace Blog\Operations;

use Blog\Models\Articles;
/**
 * 文章操作类
 * @author hongker
 *
 */
class ArticleOperation extends BaseOperation implements Operation {
	protected $articleLogFile = '../apps/logs/article.log';
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据文章id获取文章信息
	 * @param int $id
	 * @return Users 返回文章
	 */
	public function get($id) {
		return Articles::findFirst($id);
	}
	
	/**
	 * 添加文章
	 * @param array $data
	 * @return boolean
	 */
	public function save(Array $data) {
		$article = new Articles();
		foreach ($data as $key=>$value) {
			$article->$key = $value;
		}
	
		if($article->save()==true) {
			return true;
		}else {
			foreach ($article->getMessages() as $message) {
				$errorMessage = '用户:'.$article->author_id.'添加文章失败,提示内容:'.$message;
				$this->log($errorMessage,$this->articleLogFile);
				$this->getDI()->get('flash')->error($message);
			}
		}
		return false;
	}
	
	/**
	 * 根据文章id更改文章信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$article = $this->get($id);
		foreach ($array as $key=>$value) {
			$article->$key = $value;
		}
		
		if($article->save()) {
			return true;
		}
		return false;
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
	 * @param array $condition
	 */
	public function findAll(array $condition = null) {
		return Articles::find($condition);
	}
}