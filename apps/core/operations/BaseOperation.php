<?php
namespace Blog\Operations;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as LineFormatter;
use Phalcon\Logger;
/**
 * 基础操作类
 * @author hongker
 * @version 1.0
 */
class BaseOperation {
	private $_di;
	private $logDir = '../apps/logs/';
	private $logFile = 'common.log';
	
	/**
	 * 日志级别
	 */
	protected $log_level = array(
		'error'=> Logger::ERROR,
		'info' => Logger::INFO,
	);
	
	/**
	 * 用户IP地址
	 */
	protected $ip;
	
	public function __construct($di) {
		$this->_di = $di;	
		$this->ip = $this->_di->get('request')->getClientAddress();
	}
	
	public function getDI() {
		return $this->_di;
	}
	
	/**
	 * 绑定日志文件
	 * @param unknown $logFile
	 */
	public function setLogFile($logFile) {
		$this->logFile = $logFile;
	}
	
	/**
	 * 保存日志
	 * @param unknown $string
	 * @param unknown $level
	 */
	public function log($string,$level) {
		$logger = new FileLogger($this->logDir.$this->logFile);
		//$logger->setFormatter(new LineFormatter("%date%:%message%"));
		$logger->log ( $string, $this->log_level[$level]);
	}
	
	/**
	 * 保存session
	 * @param unknown $key
	 * @param array $session
	 */
	public function store($key,Array $session) {
		$this->_di->get('session')->set($key,$session);
	}
	
	/**
	 * 检查用户是否登录
	 * @return boolean
	 */
	public function checkIsLogin() {
		if($this->_di->get('session')->has('user')) {
			return true;
		}
		return false;
	}
	
}