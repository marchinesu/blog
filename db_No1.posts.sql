-- create database blog default character set utf8 collate utf8_general_ci;
-- drop user if exists 'admin'@'localhost';
-- create user 'admin'@'localhost' identified by 'password';
-- grant all on blog.* to 'admin'@'localhost';
-- use blog;

create table posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(255),
  content TEXT,
  created_at DATETIME,
  category TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

