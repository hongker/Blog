<?php
namespace Blog\Observers;

/**
 * 发送邮件观察者
 * @author hongker
 *
 */
class SendMailObserver extends BaseObserver  implements Observer {
	/**
	 * 邮箱
	 * @var email
	 */
	protected $email;
	
	/**
	 * 标题
	 * @var string
	 */
	protected $title;
	
	/**
	 * 内容
	 * @var string
	 */
	protected $content;
	
	/**
	 * 构造方法
	 * @param string $email
	 * @param string $title
	 * @param string $content
	 */
	public function __construct($email, $title, $content) {
		$this->email = $email;
		$this->title = $title;
		$this->content = $content;
	}
	
	/**
	 * 通知
	 */
	public function update() {
		$this->sendMail();
	}
	
	/**
	 * 发送邮件
	 */
	public function sendMail() {
		echo 'sendMail to:'.$this->email.',title:'.$this->title.',content:'.$this->content;
	}
}