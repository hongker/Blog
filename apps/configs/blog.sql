create database blog charset=utf8;
use blog;
/**
 * 1.users用户表(保存用户基本信息)
 * id 主键
 * username 用户名
 * password 密码
 * email 邮箱
 * type 用户类型(1:普通用户,2:超级管理员,3:编辑)
 * age 年龄
 * sex 性别(M:男,F:女,N:保密)
 * picture 头像
 * address_id 地址
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists users;
create table users(
	id int not null primary key auto_increment,
	username varchar(30) not null,
	password char(60) not null,
	email varchar(50) not null,
	type tinyint not null default 1,
	age tinyint not null default 0,
	sex char(1) not null default 'N',
	picture varchar(100) not null,
	address_id int not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into users(username,email,type,password,age)
values('admin','xiaok2013@live.com',2,'$2a$12$omJ0WXB97BKwNIsdWcK7gOC4G8OjeHegDFEdc1rROYplV8EFgFK4.',21);
insert into users(username,email,type,password,age)
values('editor1','xiaok123@live.com',3,'$2a$12$omJ0WXB97BKwNIsdWcK7gOC4G8OjeHegDFEdc1rROYplV8EFgFK4.',21);

/**
 * articles 文章表(保存文章信息)
 * id 主键
 * title 标题
 * picture 封面图片
 * digest 摘要
 * author_id 作者id
 * type_id 类型id
 * class 分类(1:普通文章,2:系统公告。。。)
 * content 内容
 * status 是否通过审核(1:是，0：否)
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists articles;
create table articles(
	id int not null primary key auto_increment,
	title varchar(100) not null,
	picture varchar(100) not null,
	digest varchar(255) not null,
	author_id int not null,
	type_id int not null,
	class tinyint not null default 1,
	content text not null,
	status tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * comments 评论表（保存用户评论内容）
 * id 主键
 * author_id 作者id
 * content 评论内容
 * target_id 评论目标
 * type 评论类型(1:文章评论)
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists comments;
create table comments(
	id int not null primary key auto_increment,
	author_id int not null,
	content varchar(255) not null,
	target_id int not null,
	type tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * replies 回复表
 * id 主键
 * author_id 作者
 * target_id 回复目标用户ID
 * content 回复内容
 * comment_id 所属评论id
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists replies;
create table replies(
	id int not null primary key auto_increment,
	author_id int not null,
	target_id int not null,
	content varchar(255) not null,
	comment_id int not null,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * types 类型表
 * id 主键
 * name 类型名称
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists types;
create table types(
	id int not null primary key auto_increment,
	name varchar(10) not null,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into types(name)
values('科技'),('经济'),('工业'),('历史'),('文学'),('健康');

/**
 * messages 消息通知表
 * id 主键
 * author_id 发送人Id
 * target_id 接收人Id
 * content 内容
 * status 是否已读
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists messages;
create table messages(
	id int not null primary key auto_increment,
	author_id int not null,
	target_id int not null,
	content varchar(255) not null,
	status tinyint not null default 0,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * advices 建议表
 * id 主键
 * email 邮箱
 * name 姓名
 * content 内容
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists advices;
create table advices(
	id int not null primary key auto_increment,
	email varchar(50) not null,
	name varchar(20) not null,
	content varchar(255) not null,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * collects 收藏表
 * id 主键
 * author_id 目标id
 * user_id 用户id
 * type 类型(1:文章，2....)
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists collects;
create table collects(
	id int not null primary key auto_increment,
	target_id int not null,
	author_id int not null,
	type tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;



/**
 * scores 评分表
 * id 主键
 * author_id 评分者id
 * target_id 评分目标id
 * type 类型(1:文章,2...)
 * score 分值(0,1,2...10)
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists scores;
create table scores(
	id int not null primary key auto_increment,
	author_id int not null,
	target_id int not null,
	type int not null default 1,
	score tinyint not null default 0,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * tags 标签表
 * id 主键
 * author_id 标签者
 * target_id 标签对象
 * content 标签内容
 * type 类型(1:文章，2：用户)
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists tags;
create table tags(
	id int not null primary key auto_increment,
	author_id int not null,
	target_id int not null,
	content varchar(20) not null,
	type tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * address 地址表
 * id 主键
 * name 名称
 * level 等级(0:国,1:省,2:市,3:县(区))
 * parent_id 父级id
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists address;
create table address(
	id int not null primary key auto_increment,
	name varchar(120) not null default '',
	parent_id smallint(5) unsigned not null default 0,
	level tinyint(1) not null default 2,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * configs 系统配置表(保存系统配置信息)
 * id 主键
 * name 配置名称
 * ckey 配置键名
 * cvalue 配置键值
 * description 配置说明
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists configs;
create table configs(
	id int not null primary key auto_increment,
	name varchar(20) not null,
	ckey varchar(20) not null,
	cvalue varchar(20) not null,
	description varchar(255) not null,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into configs(name,ckey,cvalue,description)
values('用户注册','user_register',1,'用户注册配置项(0:未开通,1:已开通)');

/**
 * tasks 任务表
 * id 主键
 * author_id 任务创建者
 * title 标题
 * content 任务内容
 * status 执行状态(1:等待执行,2:正在执行,3:已完成,4:未完成)
 * start_date 起始日期
 * end_date 完成日期
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists tasks;
create table tasks(
	id int not null primary key auto_increment,
	author_id int not null,
	title varchar(50) not null,
	content text not null,
	status tinyint not null default 1,
	start_date timestamp not null default '0000-00-00 00:00:00',
	end_date timestamp not null default '0000-00-00 00:00:00',
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * questions 问题表
 * id 主键
 * code 唯一编号
 * author_id 作者id
 * title 标题
 * type_id 问题类型ID
 * content 内容
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists questions;
create table questions(
	id int not null primary key auto_increment,
	code char(40) not null,
	author_id int not null,
	title varchar(50) not null,
	content text not null,
	type_id tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * answers 回答表
 * id 主键
 * author_id 作者id
 * question_id 问题id
 * content 回答内容
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists answers;
create table answers(
	id int not null primary key auto_increment,
	author_id int not null,
	question_id int not null,
	content text not null,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;

/**
 * tables 表模板
 * id 主键
 * is_delete 是否删除
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists tables;
create table tables(
	id int not null primary key auto_increment,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;