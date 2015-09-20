<?php
namespace Blog\Operations;
use Blog\Models\Configs;
/**
 * 系统配置操作类
 * @author hongker
 * @version 1.0
 */
class TagOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('config.log');
	}
	
	/** 配置信息
	 * @see \Blog\Operations\Operation::get()
	 * @param int $id 评分id
	 */
	public function get($id) {
		return Configs::findFirst($id);
	}

	/** 配置信息
	 * @see \Blog\Operations\Operation::save()
	 * @param array $data
	 * @return array
	 */
	public function save(array $data) {
		if(empty($data['name'])) {
			$return['errNo'] = 2101;
			return $return;
		}
		
		if(empty($data['ckey'])) {
			$return['errNo'] = 2102;
			return $return;
		}
		
		if(isset($data['cvalue'])) {
			$return['errNo'] = 2103;
			return $return;
		}
		
		if(empty($data['description'])) {
			$return['errNo'] = 2104;
			return $return;
		}
		
		$config = new Configs();
		foreach ($data as $key=>$value) {
			$config->$key = $value;
		}
		
		if($config->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('添加系统配置', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 2105;
			foreach ($config->getMessages() as $message) {
				$logString = $this->getLogString('添加系统配置', $message);
				$this->log($logString,'error');
			}
		}
		return $return;
	}

	/** 系统配置
	 * @see \Blog\Operations\Operation::update()
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update($id, array $data) {
		$config = $this->get($id);
		if($config) {
			foreach ($data as $key => $value) {
				$config->$key = $value;
			}
			
			if($config->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 2107;
			}
		}else {
			$return['errNo'] = 2106;
		}

		return $return;
		
	}

	/** 标签
	 * @see \Blog\Operations\Operation::delete()
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id) {
		$config = $this->get($id);
		
		if ($config != false) {
			if ($config->delete() != false) {
				$logString = $this->getLogString('删除配置');
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
		return Configs::find($condition);
	}
	
	
}