<?php
namespace Blog\Frontend\Controllers;
use Blog\Operations\AddressOperation;
/**
 * 地址列表控制器
 * @author hongker
 * @version 1.0
 */
class AddressController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('地址');
		parent::initialize();
		$this->operation = new AddressOperation($this->di);
		
	}

	public function indexAction(){
		
	}
	
	/**
	 * 获取省份列表
	 */
	public function getCountriesAction() {
		if($this->isPost()) {
			$countries = $this->operation->getCountries();
			if($countries) {
				$countries = $countries->toArray();
			}	
			$return['errNo'] = 0;
			$return['data'] = $countries;
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		$this->json_return($return);
	}
	
	/**
	 * 获取省份列表
	 */
	public function getProvinceAction() {
		if($this->isPost()) {
			$id= $this->get('id');
			$provinces = $this->operation->getProvinces($id);
			if($provinces) {
				$provinces = $provinces->toArray();
			}
			$return['errNo'] = 0;
			$return['data'] = $provinces;
		}else {
			$return['errNo'] = 1002;
		}
		$return['errMsg'] = $this->error[$return['errNo']];
		$this->json_return($return);
	}
	
	/**
	 * 获取城市列表
	 */
	public function getCityAction() {
	
	}
	
	

}