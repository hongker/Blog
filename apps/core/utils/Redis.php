<?php
namespace Blog\Utils;

/**
 * Redis类
 * @author hongker
 *
 */
class Redis {
	
	private $redis;
	
	/**
	 * 初始化redis
	 */
	function __construct() {
		$this->redis = new \Redis();
		
		$config = new \Phalcon\Config\Adapter\Ini ( "../../configs/config.ini" );
		
		$this->redis->connect($config->redis->host);
	}
	
	private function connect($host,$port=6379) {
		$this->redis->pconnect($host);
	}
}

?>