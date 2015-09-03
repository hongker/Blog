<?php
namespace Blog\Utils;

/**
 * Redis类
 * @author hongker
 *
 */
class Redis extends \Redis{
	
	
	/**
	 * 初始化redis
	 */
	function __construct() {
		$config = new \Phalcon\Config\Adapter\Ini ( __DIR__."/../../configs/config.ini" );
		$this->connect($config->redis->host);
	}
	
	public function connect($host,$port=6379) {
		$this->pconnect($host);
	}
}

?>