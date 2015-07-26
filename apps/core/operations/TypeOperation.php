<?php
namespace Blog\Operations;

use Blog\Models\Types;
/**
 * 类型操作类
 * @author hongker
 *
 */
class TypeOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取类型
	 * @param int $id
	 * @return Types 返回文章
	 */
	public function get($id) {
		return Types::findFirst($id);
	}
	
	/**
	 * 添加类型
	 * @param array $data
	 * @return boolean
	 */
	public function save(Array $data) {
		$type = new Types();
		foreach ($data as $key=>$value) {
			$type->$key = $value;
		}
	
		if($type->save()==true) {
			return true;
		}else {
			foreach ($type->getMessages() as $message) {
				$this->getDI()->get('flash')->error($message);
			}
		}
		return false;
	}
	
	/**
	 * 根据id更改类型信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$type = $this->get($id);
		foreach ($array as $key=>$value) {
			$type->$key = $value;
		}
		
		if($type->save()) {
			return true;
		}
		return false;
	}
	
	/**
	 * 根据id删除类型
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$type = $this->get($id);
		
		if ($type != false) {
			if ($type->delete() != false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 获取所有类型
	 */
	public function findAll() {
		return Types::find();
	}
	
	/**
	 * 根据id查找所属文章
	 * @param int $id
	 */
	public function getArticles($id) {
		$type = $this->get($id);
		return $type::getArticles();
	}
}