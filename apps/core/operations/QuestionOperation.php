<?php
namespace Blog\Operations;

use Blog\Models\Questions;
/**
 * 问题操作类
 * @author hongker
 * @version 1.0
 */
class QuestionOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('question.log');
	}
	
	/**
	 * 问题
	 * @param int $id
	 * @return Questions
	 */
	public function get($id) {
		return Questions::findFirst($id);
	}
	
	/**
	 * 添加阅读量
	 * @param int $id
	 */
	public function addView($id) {
		$key = 'question_view';
		$this->addTodayView($id);
		return $this->redis->zIncrBy($key,1,"question:$id");
	}
	
	/**
	 * 根据天数保存阅读量，以备统计之用
	 * @param int $id
	 */
	public function addTodayView($id) {
		$key = 'question_view:'.date('Ymd');
		$this->redis->zIncrBy($key,1,"question:$id");
	}
	
	/**
	 * 根据编号查找
	 * @param string $code
	 */
	public function getByCode($code) {
		return Questions::findFirstByCode($code);
	}
	
	/** 问题
	 * @see \Blog\Operations\Operation::save()
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 2301;
			return $return;
		}
		
		if(empty($data['title'])) {
			$return['errNo'] = 2302;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 2303;
			return $return;
		}
		
		
		
		$question = new Questions();
		
		foreach ($data as $key => $value){
			$question->$key = $value;
		}
		
		if($question->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('提问', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 2304;
			foreach ($question->getMessages() as $message) {
				$return['errNo'] = $message;
				$logString = $this->getLogString('提问', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 问题
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $array
	 * @return boolean
	 */
	public function update($id, array $array) {
		$question = $this->get($id);
		if($question) {
			foreach ($array as $key => $value) {
				$question->$key = $value;
			}
			
			if($question->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2308;
			}
		}else {
			$return['errNo'] = 2305;
		}
		return $return;
	}

	/** 问题
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$question = $this->get($id);
		
		if ($question != false) {
			if ($question->delete() != false) {
				$logString = $this->getLogString('删除问题');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
		
	}
	
	/**
	 * 根据条件查找问题
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Questions::find($condition);
	}
	
	/**
	 * 判断用户是否为问题作者
	 * @param int $id 
	 * @param int $user_id 用户id
	 * @return boolean
	 */
	public function checkIsAuthor($id,$user_id) {
		$question = $this->get($id);
	
		if($question&&$question->author_id==$user_id) {
			return true;
		}
		return false;
	
	}
	
}