<?php

namespace Blog\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface {
	/**
	 * 注册自定义加载器
	 */
	public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = NULL) {
		$loader = new Loader ();
		
		$loader->registerNamespaces ( array (
				'Blog\Frontend\Controllers' => '../apps/frontend/controllers/',
				'Blog\Models' => '../apps/core/models/',
				'Blog\Operations' => '../apps/core/operations/',
				'Blog\Utils' => '../apps/core/utils/',
		) );
		
		$loader->register ();
	}
	
	/**
	 * 注册自定义服务
	 */
	public function registerServices(\Phalcon\DiInterface $di) {
		
		// Registering a dispatcher
		$di->set ( 'dispatcher', function () {
			$dispatcher = new Dispatcher ();
			$dispatcher->setDefaultNamespace ( "Blog\Frontend\Controllers" );
			return $dispatcher;
		} );
		
		// Registering the view component
		$di->set ( 'view', function () {
			$view = new View ();
			$view->setViewsDir ( '../apps/frontend/views/' );
			return $view;
		} );
	}
}