<?php
header ( "Content-type: text/html; charset=utf-8" );
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Security;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Xcache;
use Phalcon\Cache\Backend\File as FileCache;
use Phalcon\Cache\Backend\Redis as RedisCache;
use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger;
use Phalcon\Flash\Direct as FlashDirect;
/**
 * 读取配置文件
 */
$config = new Phalcon\Config\Adapter\Ini ( "../apps/configs/config.ini" );
$di = new FactoryDefault ();

// 自定义路由
$di->set ( 'router', function () {
	
	$router = new Router ();
	
	$router->setDefaultModule ( "frontend" );
	
	$router->add ( '/:controller/:action/:params', array (
			'module' => 'frontend',
			'controller' => 1,
			'action' => 2,
			"params" => 3 
	) );
	
	$router->add ( "/login", array (
			'module' => 'frontend',
			'controller' => 'login',
			'action' => 'index' 
	) );
	
	$router->add ( '/admin', array (
			'module' => 'backend',
			'controller' => 'index',
			'action' => 'index' 
	) );
	$router->add ( '/admin/', array (
			'module' => 'backend',
			'controller' => 'index',
			'action' => 'index' 
	) );
	$router->add ( '/admin/:controller', array (
			'module' => 'backend',
			'controller' => 1 
	) );
	$router->add ( '/admin/:controller/', array (
			'module' => 'backend',
			'controller' => 1 
	) );
	
	$router->add ( '/admin/:controller/:action', array (
			'module' => 'backend',
			'controller' => 1,
			'action' => 2 
	) );
	
	return $router;
} );
// 建立flash服务
$di->set ( 'flash', function () {
	return new FlashDirect ();
} );
$di->set ( 'db', function () use($config) {
	$eventsManager = new EventsManager ();
	
	$logger = new FileLogger( "../apps/logs/debug.log" );
	
	// Listen all the database events
	$eventsManager->attach ( 'db', function ($event, $connection) use($logger) {
		if ($event->getType () == 'beforeQuery') {
			$logger->log ( $connection->getSQLStatement (), Logger::INFO );
		}
	} );
	
	$connection = new DbAdapter ( array (
			"host" => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"dbname" => $config->database->dbname,
			"charset" => $config->database->charset 
	) );
	
	$connection->setEventsManager ( $eventsManager );
	
	return $connection;
} );

// Set the views cache service
$di->set ( 'viewCache', function () {
	
	// Cache data for one day by default
	$frontCache = new OutputFrontend ( array (
			"lifetime" => 86400 
	) );
	
	// Memcached connection settings
	$cache = new RedisCache ( $frontCache, array (
			"prefix" => 'cache_',
			"host" => "118.244.201.40",
			"port" => "6379" 
	) );
	
	return $cache;
} );

/**
 * 多级缓存
 */
$di->set ( 'cache', function () {
	
	$ultraFastFrontend = new DataFrontend ( array (
			"lifetime" => 3600 
	) );
	
	$fastFrontend = new DataFrontend ( array (
			"lifetime" => 86400 
	) );
	
	$slowFrontend = new DataFrontend ( array (
			"lifetime" => 604800 
	) );
	
	$cache = new Multiple ( array (
			new Xcache ( $ultraFastFrontend, array (
					"prefix" => 'cache' 
			) ),
			new RedisCache ( $fastFrontend, array (
					"prefix" => 'cache',
					"host" => "118.244.201.40",
					"port" => "6379" 
			) ),
			new FileCache ( $slowFrontend, array (
					"prefix" => 'cache',
					"cacheDir" => "../apps/cache/" 
			) ) 
	) );
	
	return $cache;
} );

$di->set ( 'security', function () {
	
	$security = new Security ();
	
	// Set the password hashing factor to 12 rounds
	$security->setWorkFactor ( 12 );
	
	return $security;
}, true );

$di->setShared ( 'session', function () {
	$session = new Phalcon\Session\Adapter\Files ();
	$session->start ();
	return $session;
} );

try {
	
	// 创建应用
	$application = new Application ( $di );
	
	// 注册模块
	$application->registerModules ( array (
			'frontend' => array (
					'className' => 'Blog\Frontend\Module',
					'path' => '../apps/frontend/Module.php' 
			),
			'backend' => array (
					'className' => 'Blog\Backend\Module',
					'path' => '../apps/backend/Module.php' 
			) 
	) );
	
	// 处理请求
	echo $application->handle ()->getContent ();
} catch ( \Exception $e ) {
	echo $e->getMessage ();
}