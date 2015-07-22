<?php
namespace Blog\Operations;

use Blog\Models\Articles;
/**
 * 文章操作类
 * @author hongker
 *
 */
class ArticleOperation extends BaseOperation implements Operation {
	
	public function __construct() {
		
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
}