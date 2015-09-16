<?php
namespace Blog\Operations;

use Blog\Models\Messages;
/**
 * 消息操作类
 * @author hongker
 * @version 1.0
 */
class MessageOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取消息内容
	 * @param int $id
	 * @return Messages 返回消息
	 */
	public function get($id) {
		return Messages::findFirst($id);
	}
	
	/** 消息
	 * @see \Blog\Operations\Operation::save()
	 */
	public function save(array $data) {
		
		
	}

	/** (non-PHPdoc)
	 * @see \Blog\Operations\Operation::update()
	 */
	public function update($id, array $array) {
		// TODO Auto-generated method stub
		
	}

	/** (non-PHPdoc)
	 * @see \Blog\Operations\Operation::delete()
	 */
	public function delete($id) {
		// TODO Auto-generated method stub
		
	}

	
	
}