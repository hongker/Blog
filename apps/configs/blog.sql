create database blog charset=utf8;

/**
 * 1.users用户表
 * id 主键
 * username 用户名
 * type 用户类型(1:普通用户,2:管理员)
 * password 密码
 * age 年龄
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists users;
create table users(
	id int not null primary key auto_increment,
	username varchar(30) not null,
	type tinyint not null default 1,
	password char(60) not null,
	age tinyint not null default 0,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into users(username,type,password,age)
values('hongker',1,'$2a$12$0Y8tnffNb6PMCBi7SmlAHe8jFNYBvtFEodUav6YiaJbnnMmaAMAw6',21);

/**
 * articles 文章表
 * id 主键
 * title 标题
 * author_id 作者id
 * content 内容
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists articles;
create table articles(
	id int not null primary key auto_increment,
	title varchar(100) not null,
	author_id int not null,
	content text not null,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;
insert into articles(title,author_id,content)
values('this is title',1,'this is content');

/**
 * tables 表模板
 * id 主键
 * created_at 创建时间
 * updated_at 更改时间
 */
drop table if exists tables;
create table tables(
	id int not null primary key auto_increment,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00'
)engine=myisam default charset=utf8;