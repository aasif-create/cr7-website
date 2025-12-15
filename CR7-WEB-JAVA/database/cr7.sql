CREATE DATABASE cr7db;
USE cr7db;
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50),
  password VARCHAR(50)
);
INSERT INTO users(username,password)
VALUES ('admin','cr7');
