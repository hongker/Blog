<?php
namespace Blog\Operations;

use Blog\Models\Types;
/**
 * 类型操作类
 * @author hongker
 * @version 1.0
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
	 * @return array
	 */
	public function save(Array $data) {
		$type = new Types();
		
		if(empty($data['name'])) {
			$return['errNo'] = 1021;
			return $return;
		}
		
		foreach ($data as $key=>$value) {
			$type->$key = $value;
		}
	
		if($type->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1022;
		}
		return $return;
	}
	
	/**
	 * 根据id更改类型信息
	 * @param array $id
	 * @param array $array
	 * @return array 
	 */
	public function update($id,array $array) {
		$type = $this->get($id);
		
		if($type) {
			if(empty($array['name'])) {
				$return['errNo'] = 1021;
				return $return;
			}
			
			foreach ($array as $key=>$value) {
				$type->$key = $value;
			}
			
			if($type->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1026;
			}
		}else {
			$return['errNo'] = 1025;
		}
		
		return $return;
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
	public function findAll($condition=null) {
		return Types::find($condition);
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