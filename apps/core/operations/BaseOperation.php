<?php
namespace Blog\Operations;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as LineFormatter;
use Phalcon\Logger;
use Blog\Utils\Redis;
/**
 * 基础操作类
 * @author hongker
 * @version 1.0
 */
class BaseOperation {
	private $_di;
	private $logDir = '../apps/logs/';
	private $logFile = 'common.log';
	protected $redis;	
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
		$this->redis = new Redis();
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
	 * @param string $logString 日志信息
	 * @param string $level 日志级别
	 */
	public function log($logString,$level = 'info') {
		$logger = new FileLogger($this->logDir.$this->logFile);
		//$logger->setFormatter(new LineFormatter("%date%:%message%"));
		$logger->log ( $logString, $this->log_level[$level]);
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
	
	/**
	 * 组织保存日志信息格式
	 * @param string $action
	 * @param int $errNo
	 * @return string
	 */
	public function getLogString($action,$errNo = 0) {
		$logString = "IP:{$this->ip},操作：{$action}，errNo：{$errNo}";
		return $logString;
	}
	
	/**
	 * 获取服务
	 * @param string $service
	 */
	public function getService($service) {
		return $this->getDI()->get($service);
	}
	
}