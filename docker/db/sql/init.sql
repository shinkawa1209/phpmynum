
CREATE DATABASE IF NOT EXISTS mynumdb;
USE mynumdb;

CREATE TABLE IF NOT EXISTS contacts
(
    id int primary key auto_increment,
    mynum varchar(255),
    name varchar(255),
    gender varchar(10),
    addr text,
    created datetime default now(),
    updated datetime,
    processed boolean default 0
);

CREATE TABLE IF NOT EXISTS admins
(
    id int primary key auto_increment,
    name varchar(255) not null,
    password varchar(255) not null, 
    password_hash varchar(255) not null,
    created datetime,
    updated datetime
);

INSERT INTO admins(
        name,
        password,
        password_hash,
        created,
        updated
    ) values(
        'test',
        'test',
        '$2y$10$TIBCul4QcvOUlMhI2TgsHeEVKP24WG3Dq/pu0kAAI4xt05k2rNxqC',
        now(),
        now()
    );

create user $MYSQL_USER identified by $MYSQL_PASSWORD;
grant all privileges on contacts.* to $MYSQL_USER@'%';
grant all privileges on admins.* to $MYSQL_USER@'%';
-- grant all privileges on *.* to $MYSQL_USER@'%';

-- INSERT INTO contacts (name) VALUES ("yamada");
-- INSERT INTO sample_table (sample) VALUES ("sample2");