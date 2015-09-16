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
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 1801;
			return $return;
		}
		
		if(empty($data['target_id'])) {
			$return['errNo'] = 1802;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 1803;
			return $return;
		}
		
		$message = new Messages();
		
		foreach ($data as $key => $value){
			$message->$key = $value;
		}
		
		if($message->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('发送消息', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1805;
			foreach ($message->getMessages() as $message) {
				$logString = $this->getLogString('发送消息', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 消息
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $array
	 * @return boolean
	 */
	public function update($id, array $array) {
		$message = $this->get($id);
		if($message) {
			foreach ($array as $key => $value) {
				$message->$key = $value;
			}
			
			if($message->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1806;
			}
		}else {
			$return['errNo'] = 1804;
		}

		return $return;
		
	}

	/** 消息
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$message = $this->get($id);
		
		if ($message != false) {
			if ($message->delete() != false) {
				$logString = $this->getLogString('删除消息');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
		
	}

	
	
}