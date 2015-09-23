<?php
namespace Blog\Operations;

use Blog\Models\Address;
/**
 * 地址操作类
 * @author hongker
 * @version 1.0
 */
class AddressOperation extends BaseOperation implements Operation {
	
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('address.log');
	}
	
	/**
	 * 地址
	 * @param int $id
	 * @return Address
	 */
	public function get($id) {
		return Address::findFirst($id);
	}
	
	/** 地址
	 * @see \Blog\Operations\Operation::save()
	 */
	public function save(array $data) {
		$address = new Address();
		foreach ($data as $key=>$value) {
			$address->$key = $value;
		}
	
		if($address->save()==true) {
			$return['errNo'] = 0;
		}else {
			$return['errNo'] = 1504;
			$logString = "IP:{$this->ip},提交建议，errNo：{$return['errNo']}";
			$this->log($logString, 'error');
		}
		return $return;
		
	}

	/** 地址
	 * @see \Blog\Operations\Operation::update()
	 */
	public function update($id, array $array) {
		$address = $this->get($id);
		foreach ($array as $key=>$value) {
			$address->$key = $value;
		}
		
		if($address->update()) {
			return true;
		}
		return false;
		
	}

	/** 地址
	 * @see \Blog\Operations\Operation::delete()
	 */
	public function delete($id) {
		$address = $this->get($id);
		
		if ($address != false) {
			if ($address->delete() != false) {
				$logString = $this->getLogString('删除地址', 0);
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
		
	}
	
	/**
	 * 查找地址
	 * @param array $condition
	 */
	public function findAll($condition=null) {
		return Address::find($condition);
	}
	
	/**
	 * 获取国家
	 * @param int $id
	 */
	public function getCountries() {
		$countries = $this->findAll(array(
				'conditions' => "is_delete=0 and level=0",
				'columns'=>'id,name'
		));
		return $countries;
	
	}
	
	/**
	 * 根据Id获取下属省份
	 * @param int $id
	 */
	public function getProvinces($id) {
		$provinces = $this->findAll(array(
			'conditions' => "parent_id=$id and is_delete=0 and level=1",
			'columns' => 'id,name',
		));
		return $provinces;
		
	}
	
	/**
	 * 根据Id获取下属城市
	 * @param int $id
	 */
	public function getCitys($id) {
		$citys = $this->findAll(array(
				'conditions' => "parent_id=$id and is_delete=0 and level=2",
				'column' => 'id,name',
		));
		return $citys;
	}

	
	
}