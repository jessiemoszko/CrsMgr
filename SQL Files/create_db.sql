CREATE DATABASE IF NOT EXISTS CRS;
use CRS;

CREATE TABLE IF NOT EXISTS role
(
  roleID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(50) NOT NULL UNIQUE
) AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS user
(
  userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  dob DATE NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  first_login BOOLEAN DEFAULT TRUE,
  roleID INT NOT NULL,
  FOREIGN KEY (roleID) REFERENCES role (roleID),
  INDEX (roleID)
) AUTO_INCREMENT = 1000;

INSERT INTO role (role_name) VALUES
("Admin"),
("Professor"),
("TA"),
("Student");

INSERT INTO user (first_name, last_name, dob, email, username, password, first_login, roleID) VALUES 
('John', 'Doe', '1990-05-15', 'john@example.com', 'johndoe', '12345', 1, 1),
('Alice', 'Smith', '1988-09-23', 'alice@example.com', 'alicesmith', '12345', 1, 2),
('user2FN', 'user2LN', '1999-11-01', 'user2@example.com', 'user2', '12345', 1, 2),
('Bob', 'Johnson', '1995-02-10', 'bob@example.com', 'bobjohnson', '12345', 1, 3),
('Emily', 'Brown', '1992-11-30', 'emily@example.com', 'emilybrown', '12345', 1, 3),
('Michael', 'Davis', '1987-07-18', 'michael@example.com', 'michaeldavis', '12345', 1, 4),
('user1FN', 'user1LN', '1991-07-12', 'user1@example.com', 'user1', '12345', 1, 4),
('Sophia', 'Wilson', '1998-04-05', 'sophia@example.com', 'sophiawilson', '12345', 1, 4),
('Daniel', 'Martinez', '1993-12-20', 'daniel@example.com', 'danielmartinez', '12345', 1, 4),
('Emma', 'Taylor', '1991-08-08', 'emma@example.com', 'emmataylor', '12345',  1, 4),
('Christopher', 'Anderson', '1994-06-25', 'chris@example.com', 'chrisanderson', '12345', 1, 4),
('Olivia', 'Hernandez', '1989-03-12', 'olivia@example.com', 'oliviahernandez', '12345', 1, 4);


