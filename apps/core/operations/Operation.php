<?php

namespace Blog\operations;

/**
 * 操作类接口
 * @author hongker
 *
 */
interface Operation {
	public function get($id);
	public function save(Array $data);
	public function update($id,array $array);
	public function delete($id);
}

