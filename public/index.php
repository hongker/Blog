<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Security;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
/**
 * 读取配置文件
 */
$config = new Phalcon\Config\Adapter\Ini("../apps/configs/config.ini");
$di = new FactoryDefault();

// 自定义路由
$di->set('router', function () {

    $router = new Router();

    $router->setDefaultModule("frontend");

    $router->add('/:controller/:action', array(
    		'module' => 'frontend',
    		'controller' => 1,
    		'action' => 2,
    ));
    
    $router->add("/login", array(
    	'module' => 'frontend',
        'controller' => 'login',
        'action'     => 'index',
    ));

    $router->add('/admin/:controller/:action', array(
    		'module' => 'backend',
    		'controller' => 1,
    		'action' => 2,
    ));

    return $router;
});

$di->set ( 'db', function()use ($config) {
	return new DbAdapter ( array (
		"host" => $config->database->host,
		"username" => $config->database->username,
		"password" => $config->database->password,
		"dbname" => $config->database->dbname,
		"charset"=>$config->database->charset,
	) );
} );

$di->set('security', function(){
	
	$security = new Security();
	
	//Set the password hashing factor to 12 rounds
	$security->setWorkFactor(12);
	
	return $security;
}, true);

$di->setShared('session', function() {
	$session = new Phalcon\Session\Adapter\Files();
	$session->start();
	return $session;
});

try {

    // 创建应用
    $application = new Application($di);

    // 注册模块
    $application->registerModules(
        array(
            'frontend' => array(
                'className' => 'Blog\Frontend\Module',
                'path'      => '../apps/frontend/Module.php',
            ),
            'backend'  => array(
                'className' => 'Blog\Backend\Module',
                'path'      => '../apps/backend/Module.php',
            )
        )
    );

    // 处理请求
    echo $application->handle()->getContent();

} catch(\Exception $e){
    echo $e->getMessage();
}