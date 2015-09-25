<?php
namespace Blog\Observers;

/**
 * 发送消息观察者
 * @author hongker
 *
 */
class SendMessageObserver extends BaseObserver implements Observer {
	/**
	 * 发送目标
	 * @var email
	 */
	protected $target;
	
	/**
	 * 发送人
	 * @var string
	 */
	protected $author;
	
	/**
	 * 消息内容
	 * @var string
	 */
	protected $content;
	
	/**
	 * 构造方法
	 * @param int $target
	 * @param int $title
	 * @param string $content
	 */
	public function __construct($target, $author, $content) {
		$this->target = $target;
		$this->author = $author;
		$this->content = $content;
	}
	
	/**
	 * 通知
	 */
	public function update() {
		$this->send();
	}
	
	/**
	 * 发送邮件
	 */
	public function send() {
		echo 'send message to:'.$this->target.',by:'.$this->author.',content:'.$this->content;
	}
}