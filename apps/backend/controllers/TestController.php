<?php
namespace Blog\Backend\Controllers;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;
/**
 * 测试控制器
 * @author hongker
 * @version 1.0
 */
class TestController extends BaseController
{
	public function initialize()
	{
		\Phalcon\Tag::setTitle('测试');
		parent::initialize();
	}

	public function indexAction() {
		
	}
	
	public function aclAction() {
		echo 'this is acl test!<br>';
		
		$acl = new AclList();
		$acl->setDefaultAction(Acl::DENY);
		
		// 创建角色
		// The first parameter is the name, the second parameter is an optional description.
		$roleAdmins = new Role("Administrators");
		$roleEditors= new Role("Editors");
		
		// 添加 "Guests" 角色到ACL
		$acl->addRole($roleAdmins);
		$acl->addRole($roleEditors);
		// 添加"Designers"到ACL, 仅使用此字符串。
		//$acl->addRole("Designers");
		
		// 定义 "Customers" 资源
		$customersResource = new Resource("Customers");
		
		$acl->addResource($customersResource, "search");
		$acl->addResource($customersResource, array("create", "update"));
		
		// 设置角色对资源的访问级别
		$acl->allow("Administrators", "Customers", "search");
		$acl->allow("Administrators", "Customers", "create");
		$acl->deny("Editors", "Customers", "update");
		var_dump($acl);exit;
		// 查询角色是否有访问权限
		var_dump($acl->isAllowed("Administrators", "Customers", "search"));  
		
		exit;
	}
	

}