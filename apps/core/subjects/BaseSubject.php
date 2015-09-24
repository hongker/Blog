<?php
namespace Blog\Subjects;
use Blog\Observers\Observer;
/**
 * 观察对象基础类
 * @author hongker
 * @version 1.0
 */
class BaseSubject implements Subject {
	/** 
	 * @see \Blog\Subjects\Subject::attach()
	 */
	public function attach(Observer $observer) {
		// TODO Auto-generated method stub
		
	}

	/**
	 * @see \Blog\Subjects\Subject::detach()
	 */
	public function detach(Observer $observer) {
		// TODO Auto-generated method stub
		
	}

	/** 
	 * @see \Blog\Subjects\Subject::notify()
	 */
	public function notify() {
		// TODO Auto-generated method stub
		
	}

	
}