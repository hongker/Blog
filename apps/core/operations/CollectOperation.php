<?php
namespace Blog\Operations;
use Blog\Models\Collects;
use Blog\Models\Articles;
/**
 * 收藏操作类
 * @author hongker
 * @version 1.0
 */
class CollectOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('collect.log');
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
		
		if(empty($data['author_id'])) {
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
	 * 获取收藏状态
	 * @todo 设计收藏
	 * @param array $data
	 * @return Array [errNo=>错误代码,status=>0(未收藏),1(已收藏),2(已取消)]
	 */
	public function getStatus(Array $data) {
		//
		$return['status'] = 0;
		if(empty($data['author_id'])) {
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
		
		$collect = Collects::findFirst("author_id={$data['author_id']} and target_id={$data['target_id']}");
		
		$return['errNo'] = 0;
		if($collect) {
			$return['status'] = $collect->is_delete?1:2;
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
	 * @param array $condition
	 * @return array
	 */
	public function findAll($condition=null) {
		$collects = Collects::find($condition);
		/*
		$return = array();
		foreach ($collects as $collect) {
			if($collect->type==1) {
				$collect->target = Articles::findFirst($collect->id);
			}
			$return[] = $collect->toArray();
		}
		*/
		return $collects;
	}
	
	/**
	 * 根据author_id查找全部收藏
	 * @param int $id
	 */
	public function getCollects($id) {
		$collects = $this->findAll(array(
			"conditions"=>"author_id=$id and is_delete=0 and status=1",
		));
		return $collects;
	}
	
	/**
	 * 检查收藏是否存在
	 * @param unknown $id
	 * @return boolean
	 */
	public function checkIsExist($id) {
		$collect = $this->get($id);
		
		if($collect) {
			return true;
		}
		return false;
	}
	
	/**
	 * 检查是否是作者本人
	 * @param int $id
	 * @param int $author_id
	 * @return boolean
	 */
	public function checkIsAuthor($id,$author_id) {
		$collect = $this->get($id);
		if($collect&&$collect->author_id==$author_id) {
			return true;
		}
		return false;
	}
	
	/**
	 * 修改状态
	 * @param array $condition
	 * @return number
	 */
	public function changeStatus(Array $condition) {
		$collect = Collects::findFirst($condition);
		
		if($collect) {
			if($collect->is_delete==1) {
				$data['is_delete'] = 0;
				$return = $this->update($collect->id, $data);
			}else {
				$data['is_delete'] = 1;
				$return = $this->update($collect->id, $data);
			}
		}else {
			$return['errNo'] = 1606;
		}
		
		return $return;
	}
	
}