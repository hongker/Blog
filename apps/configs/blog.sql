/**
 * 1.users用户表
 * id 主键
 * username 用户名
 * type 用户类型(1:普通用户,2:管理员)
 * password 密码
 */
create table tables(
	id int not null primary key auto_increment,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00',
)engine=myisam default charset=utf8;


create table tables(
	id int not null primary key auto_increment,
	created_at timestamp not null default current_timestamp,
	updated_at timestamp not null default '0000-00-00 00:00:00',
)engine=myisam default charset=utf8;