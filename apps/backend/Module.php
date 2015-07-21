<?php

namespace Blog\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{

    /**
     * 注册自定义加载器
     */
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = NULL)
    {

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Blog\Backend\Controllers' => '../apps/backend/controllers/',
                'Blog\Backend\Models'      => '../apps/core/models/',
            )
        );

        $loader->register();
    }

    /**
     * 注册自定义服务
     */
    public function registerServices(\Phalcon\DiInterface $di)
    {

        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Blog\Backend\Controllers");
            return $dispatcher;
        });

        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir('../apps/backend/views/');
            return $view;
        });
    }

}