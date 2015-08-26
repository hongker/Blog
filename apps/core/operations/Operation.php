<?php
namespace Blog\Operations;

/**
 * 操作类接口
 * @author hongker
 * @version 1.0
 */
interface Operation {
	public function get($id);
	public function save(Array $data);
	public function update($id,array $array);
	public function delete($id);
}

