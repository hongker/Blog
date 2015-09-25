<?php
namespace Blog\Subjects;

/**
 * 发送邮件观察者
 * @author hongker
 *
 */
class SendMailSubject extends BaseSubject {
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
	 * 发送邮件
	 */
	public function sendMail() {
		echo 'sendMail';
	}
}