<?php
namespace Blog\Operations;
use Blog\Models\Tags;
/**
 * 标签操作类
 * @author hongker
 * @version 1.0
 */
class TagOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('tag.log');
	}
	
	/** 标签信息
	 * @see \Blog\Operations\Operation::get()
	 * @param int $id 评分id
	 */
	public function get($id) {
		return Tags::findFirst($id);
	}

	/** 标签
	 * @see \Blog\Operations\Operation::save()
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['author_id'])) {
			$return['errNo'] = 1901;
			return $return;
		}
		
		if(empty($data['target_id'])) {
			$return['errNo'] = 1902;
			return $return;
		}
		
		if(empty($data['content'])) {
			$return['errNo'] = 1903;
			return $return;
		}
		
		$tag = new Tags();
		foreach ($data as $key=>$value) {
			$tag->$key = $value;
		}
		
		if($tag->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('添加标签', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1904;
			foreach ($tag->getMessages() as $message) {
				$logString = $this->getLogString('添加标签', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 标签
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update($id, array $data) {
		$tag = $this->get($id);
		if($tag) {
			foreach ($data as $key => $value) {
				$tag->$key = $value;
			}
			
			if($tag->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1907;
			}
		}else {
			$return['errNo'] = 1905;
		}

		return $return;
		
	}

	/** 标签
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$tag = $this->get($id);
		
		if ($tag != false) {
			if ($tag->delete() != false) {
				$logString = $this->getLogString('删除标签');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据条件查找消息数据
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Tags::find($condition);
	}
	
	
}