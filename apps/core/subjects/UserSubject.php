<?php
namespace Blog\Subjects;
use Blog\Observers\UserObserver;
/**
 * 用户观察对象类
 * @author hongker
 * @version 1.0
 */
class UserSubject extends BaseSubject {
	public $observers = array();
	
	const OBSERVER_TYPE_LOGIN = 1; //登录
	const OBSERVER_TYPE_REGISTER = 2; //注册
	const OBSERVER_TYPE_CHANGE_PASS = 3;
	
	/**
	 * @see \Blog\Subjects\BaseSubject::attach()
	 */
	public function attach(UserObserver $observer, $type) {
		$this->observers[$type][] = $observer;
	}
	
	/**
	 * @see \Blog\Subjects\BaseSubject::detach()
	 */
	public function detach(UserObserver $observer, $type) {
		$index = array_search($observer, $this->observers[$type], true);
		
		if($index) {
			unset($this->observers[$type][$index]);
		}
	}
	
	/**
	 * 用户操作
	 * @see \Blog\Subjects\BaseSubject::notify()
	 */
	public function notify($type) {
		if(!empty($this->observers[$type])) {
			foreach ($this->observers[$type] as $observer) {
				$observer->update($this);
			}
		}
	}
}