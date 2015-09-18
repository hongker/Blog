<?php
namespace Blog\Operations;
use Blog\Models\Scores;
/**
 * 评分操作类
 * @author hongker
 * @version 1.0
 */
class ScoreOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('score.log');
	}
	
	/** 评分信息
	 * @see \Blog\Operations\Operation::get()
	 * @param int $id 评分id
	 */
	public function get($id) {
		return Scores::findFirst($id);
	}

	/** 评分
	 * @see \Blog\Operations\Operation::save()
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 1701;
			return $return;
		}
		
		if(empty($data['target_id'])) {
			$return['errNo'] = 1702;
			return $return;
		}
		
		if(empty($data['score'])) {
			$return['errNo'] = 1703;
			return $return;
		}
		
		if($data['score']>10||$data['score']<0) {
			$return['errNo'] = 1704;
			return $return;
		}
		
		
		$score = new Scores();
		foreach ($data as $key=>$value) {
			$score->$key = $value;
		}
		
		if($score->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('添加评分', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1707;
			foreach ($score->getMessages() as $message) {
				$logString = $this->getLogString('添加评分', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 修改评分
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update($id, array $data) {
		$score = $this->get($id);
		if($score) {
			foreach ($data as $key => $value) {
				$score->$key = $value;
			}
			
			if($score->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1706;
			}
		}else {
			$return['errNo'] = 1705;
		}

		return $return;
		
	}

	/** 评分
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$score = $this->get($id);
		
		if ($score != false) {
			if ($score->delete() != false) {
				$logString = $this->getLogString('删除评分');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据条件查找评分数据
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Scores::find($condition);
	}
	
	
}