<?php
namespace Blog\Backend\Controllers;
use Phalcon\Mvc\Controller;


/**
 * 基础控制器
 * @author hongker
 *
 */
class BaseController extends Controller
{
	protected function initialize() {
        //Prepend the application name to the title
        \Phalcon\Tag::prependTitle('Blog | ');
    }
}