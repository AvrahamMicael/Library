create database library charset set utf8 collate utf8_unicode_ci;
create table tb_books(
    id int not null primary key AUTO_INCREMENT,
	author varchar(100) not null,
    title varchar(100) not null,
    description text not null,
    published_at date not null,
    pages int not null,
    available int not null default 0,
    genres varchar(100) not null
);
create table tb_users(
	id_user int not null primary key AUTO_INCREMENT,
    name varchar(50) not null,
    email varchar(50) not null,
    password char(128) not null
);

--the user with id 1 is the admin