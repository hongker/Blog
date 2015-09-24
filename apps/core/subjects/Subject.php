<?php
namespace Blog\Subjects;
use Blog\Observers\Observer;
/**
 * 观察对象类
 * @author hongker
 * @version 1.0
 */
interface Subject {
	/**
	 * 添加观察者
	 * @param Observer $observer
	 */
	public function attach(Observer $observer);
	
	/**
	 * 删除观察者
	 * @param Observer $observer
	 */
	public function detach(Observer $observer);
	
	/**
	 * 通知
	 */
	public function notify();
}