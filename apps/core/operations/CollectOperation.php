<?php
namespace Blog\Operations;
use Blog\Models\Collects;
/**
 * 收藏操作类
 * @author hongker
 * @version 1.0
 */
class CollectOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
	}
	
	/**
	 * 根据id获取收藏
	 * @param int $id
	 * @return Collects 返回收藏
	 */
	public function get($id) {
		return Collects::findFirst($id);
	}
	
	/**
	 * 添加收藏
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data) {
		$collect = new Collects();
		
		if(empty($data['user_id'])) {
			$return['errNo'] = 1605;
			return $return;
		}
		
		if(empty($data['target_id'])) {
			$return['errNo'] = 1602;
			return $return;
		}
		
		if(empty($data['type'])) {
			$return['errNo'] = 1603;
			return $return;
		}
		
		foreach ($data as $key=>$value) {
			$collect->$key = $value;
		}
	
		if($collect->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1604;
		}
		return $return;
	}
	
	/**
	 * 根据id更改收藏
	 * @param array $id
	 * @param array $array
	 * @return array 
	 */
	public function update($id,array $array) {
		$collect = $this->get($id);
		
		if($collect) {
			
			foreach ($array as $key=>$value) {
				$collect->$key = $value;
			}
			
			if($collect->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1607;
			}
		}else {
			$return['errNo'] = 1606;
		}
		
		return $return;
	}
	
	/**
	 * 根据id删除收藏
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$collect = $this->get($id);
		if ($collect != false) {
			if ($collect->delete() != false) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 获取所有收藏
	 */
	public function findAll($condition=null) {
		return Collects::find($condition);
	}
	
	/**
	 * 根据user_id查找全部收藏
	 * @param int $id
	 */
	public function getCollects($id) {
		$collects = $this->findAll(array(
			"conditions"=>"user_id=$id and is_delete=0 and status=1",
		));
		return $collects;
	}
}