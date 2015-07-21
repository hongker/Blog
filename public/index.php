<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;


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