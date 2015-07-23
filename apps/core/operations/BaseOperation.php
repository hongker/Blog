<?php
namespace Blog\Operations;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger;
/**
 * 基础操作类
 * @author hongker
 *
 */
class BaseOperation {
	protected $_di;
	
	public function __construct($di) {
		$this->_di = $di;	
	}
	
	public function getDI() {
		return $this->_di;
	}
	
	/**
	 * 保存日志
	 * @param unknown $string
	 * @param unknown $logFile
	 * @param unknown $level
	 */
	public function log($string,$logFile) {
		$logger = new FileLogger($logFile);
		$logger->log ( $string, Logger::ERROR);
	}
	
}