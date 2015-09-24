<?php
namespace Blog\Observers;
use Blog\Subjects\UserSubject;
/**
 * 用户观察者
 * @author hongker
 * @version 1.0
 */
class UserObserver extends BaseObserver {
	/**
	 * 监听用户
	 * @see \Blog\Observers\BaseObserver::update()
	 */
	public function update(UserSubject $subject) {
		
	}
	
	/**
	 * 发送邮件
	 * @param email $email
	 * @param string $title
	 * @param string $content
	 */
	public function sendEmail($email, $title, $content) {
		
	}
}