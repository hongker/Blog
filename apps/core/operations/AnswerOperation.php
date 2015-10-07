<?php
namespace Blog\Operations;

use Blog\Models\Answers;
/**
 * 答复操作类
 * @author hongker
 * @version 1.0
 */
class AnswerOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取回答内容
	 * @param int $id
	 * @return Answers
	 */
	public function get($id) {
		return Answers::findFirst($id);
	}
	
	/** 答复
	 * @see \Blog\Operations\Operation::save()
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 2401;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 2402;
			return $return;
		}
		
		if(empty($data['question_id'])) {
			$return['errNo'] = 2403;
			return $return;
		}
		
		$answer = new Answers();
		
		foreach ($data as $key => $value){
			$answer->$key = $value;
		}
		
		if($answer->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('答复问题', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1805;
			foreach ($answer->getMessages() as $message) {
				$return['errNo'] = $message;
				$logString = $this->getLogString('答复问题', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 答复
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $array
	 * @return boolean
	 */
	public function update($id, array $array) {
		$answer = $this->get($id);
		if($answer) {
			foreach ($array as $key => $value) {
				$answer->$key = $value;
			}
			
			if($answer->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2406;
			}
		}else {
			$return['errNo'] = 2405;
		}
		return $return;
	}

	/** 答复
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$answer = $this->get($id);
		
		if ($answer != false) {
			if ($answer->delete() != false) {
				$logString = $this->getLogString('删除答复');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
		
	}

	
	
}