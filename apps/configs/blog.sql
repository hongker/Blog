create database blog charset=utf8;
use blog;
/**
 * 1.users用户表
 * id 主键
 * username 用户名
 * email 邮箱
 * type 用户类型(1:普通用户,2:管理员)
 * password 密码
 * age 年龄
 * is_delete 是否删除(1:是，0：否)
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists users;
create table users(
	id int not null primary key auto_increment,
	username varchar(30) not null,
	email varchar(50) not null,
	type tinyint not null default 1,
	password char(60) not null,
	age tinyint not null default 0,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into users(username,email,type,password,age)
values('hongker','xiaok2013@live.com',1,'$2a$12$0Y8tnffNb6PMCBi7SmlAHe8jFNYBvtFEodUav6YiaJbnnMmaAMAw6',21);

/**
 * articles 文章表
 * id 主键
 * title 标题
 * picture 封面图片
 * digest 摘要
 * author_id 作者id
 * type_id 类型id
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
	content text not null,
	status tinyint not null default 1,
	is_delete tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;




/**
 * comments 评论表
 * id 主键
 * author_id 作者id
 * content 评论内容
 * target 评论目标
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
	target int not null,
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
 * messages 消息表
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
 * status 状态(1:已关注,2:已取消)
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
	status tinyint not null default 1,
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