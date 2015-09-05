<?php
namespace Blog\Operations;

/**
 * 操作类接口
 * @author hongker
 * @version 1.0
 */
interface Operation {
	/**
	 * 查找
	 * @param int $id
	 */
	public function get($id);
	
	/**
	 * 添加
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data);
	
	/**
	 * 更新
	 * @param int $id
	 * @param array $array
	 * @return boolean
	 */
	public function update($id,array $array);
	
	/**
	 * 删除
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id);
}

