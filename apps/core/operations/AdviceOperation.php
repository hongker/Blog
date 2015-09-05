<?php
namespace Blog\Operations;

use Blog\Models\Advices;
/**
 * 建议操作类
 * @author hongker
 * @version 1.0
 */
class AdviceOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('advice.log');
	}
	
	/**
	 * 根据id获取建议内容
	 * @param int $id
	 * @return Advices
	 */
	public function get($id) {
		return Advices::findFirst($id);
	}
	
	/** (建议)
	 * @see \Blog\Operations\Operation::save()
	 */
	public function save(array $data) {
		if(empty($data['email'])) {
			$return['errNo'] = 1501;
			return $return;
		}
		
		if(empty($data['name'])) {
			$return['errNo'] = 1502;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 1503;
			return $return;
		}
		
		
		$advice = new Advices();
		foreach ($data as $key=>$value) {
			$advice->$key = $value;
		}
	
		if($advice->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1504;
			$logString = "IP:{$this->ip},提交建议，errNo：{$return['errNo']}";
			$this->log($logString, 'error');
		}
		return $return;
		
	}

	/** (建议)
	 * @see \Blog\Operations\Operation::update()
	 */
	public function update($id, array $array) {
		$advice = $this->get($id);
		foreach ($array as $key=>$value) {
			$advice->$key = $value;
		}
		
		if($advice->update()) {
			return true;
		}
		return false;
		
	}

	/** (建议)
	 * @see \Blog\Operations\Operation::delete()
	 */
	public function delete($id) {
		$advice = $this->get($id);
		
		if ($advice != false) {
			if ($advice->delete() != false) {
				$logString = $this->getLogString('删除建议', 0);
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
		
	}
	
	/**
	 * 查找记录
	 * @param array $condition
	 */
	public function findAll($condition=null) {
		return Advices::find($condition);
	}

	
	
}