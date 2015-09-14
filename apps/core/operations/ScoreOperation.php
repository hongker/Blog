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
	 */
	public function get($id) {
		// TODO Auto-generated method stub
		return Scores::findFirst($id);
	}

	/** 评分
	 * @see \Blog\Operations\Operation::save()
	 */
	public function save(array $data) {
		// TODO Auto-generated method stub
		
	}

	/** 修改评分
	 * @see \Blog\Operations\Operation::update()
	 */
	public function update($id, array $array) {
		// TODO Auto-generated method stub
		
	}

	/** 评分
	 * @see \Blog\Operations\Operation::delete()
	 */
	public function delete($id) {
		// TODO Auto-generated method stub
		
	}

	
}