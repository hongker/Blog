<?php
namespace Blog\Operations;

use Blog\Models\Tasks;
/**
 * 任务操作类
 * @author hongker
 * @version 1.0
 */
class TaskOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('task.log');
	}
	
	/**
	 * 任务
	 * @param int $id
	 * @return Address
	 */
	public function get($id) {
		return Tasks::findFirst($id);
	}
	
	/** 任务
	 * @see \Blog\Operations\Operation::save()
	 */
	public function save(array $data) {
		if(empty($data['title'])) {
			$return['errNo'] = 2201;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 2202;
			return $return;
		}
	
		if(empty($data['start_date'])) {
			$return['errNo'] = 2203;
			return $return;
		}
		
		if(empty($data['end_date'])) {
			$return['errNo'] = 2204;
			return $return;
		}
		
		if(empty($data['author_id'])) {
			$return['errNo'] = 2205;
			return $return;
		}
		
		$task = new Tasks();
		foreach ($data as $key=>$value) {
			$task->$key = $value;
		}
	
		if($task->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 2206;
			foreach ($task->getMessages() as $message) {
				$return['errNo'] = $message;
				$logString = $this->getLogString('添加任务',$return['errNo']);
				$this->log($logString, 'error');
				return $return;
			}
		}
		return $return;
		
	}

	/** 任务
	 * @see \Blog\Operations\Operation::update()
	 */
	public function update($id, array $array) {
		$task = $this->get($id);
		foreach ($array as $key=>$value) {
			$task->$key = $value;
		}
		
		if($task->update()) {
			$return['errNo'] = 0;
		}else {
			foreach ($task->getMessages() as $message) {
				$return['errNo'] = $message;
			}
		}
		return $return;
		
	}

	/** 任务
	 * @see \Blog\Operations\Operation::delete()
	 */
	public function delete($id) {
		$task = $this->get($id);
		
		if ($task != false) {
			if ($task->delete() != false) {
				$logString = $this->getLogString('删除任务', 0);
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * 查找任务
	 * @param array $condition
	 */
	public function findAll($condition=null) {
		return Tasks::find($condition);
	}
	
}