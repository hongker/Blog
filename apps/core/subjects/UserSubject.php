<?php
namespace Blog\Subjects;
/**
 * 用户观察对象
 * @author hongker
 *
 */
class UserSubject extends BaseSubject implements Subject{
	public $observers = array();
	
	/**
	 * @see \Blog\Subjects\BaseSubject::attach()
	 */
	public function attach($observer,$type) {
		$this->observers[$type][] = $observer;
	}
	
	/**
	 * @see \Blog\Subjects\BaseSubject::detach()
	 */
	public function detach($observer,$type) {
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