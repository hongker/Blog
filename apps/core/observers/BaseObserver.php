<?php
namespace Blog\Observers;
use Blog\Subjects\BaseSubject;
/**
 * 观察者基础类
 * @author hongker
 * @version 1.0
 */
class BaseObserver implements Observer {
	/** 
	 * @see \Blog\Observers\Observer::update()
	 */
	public function update(BaseSubject $subject) {
		// TODO Auto-generated method stub
		
	}

	
}