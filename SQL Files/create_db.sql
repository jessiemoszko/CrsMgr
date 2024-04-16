CREATE DATABASE IF NOT EXISTS CRS;
use CRS;

CREATE TABLE IF NOT EXISTS role
(
  `roleID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE
) AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `groups`
(
  `groupID` INT PRIMARY KEY,
  `group_name` VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `user`
(
  `userID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `dob` DATE NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  `first_login` BOOLEAN DEFAULT TRUE,
  `roleID` INT NOT NULL,
  FOREIGN KEY (`roleID`) REFERENCES role (`roleID`),
  INDEX (`roleID`),
  `groupID` INT,
  FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`),
  INDEX (`groupID`)
) AUTO_INCREMENT = 1000;

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(150) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `dept_name` varchar(150) NOT NULL,
  `semester` varchar(150) NOT NULL,
  `room_no` varchar(150) NOT NULL,
  `instructor_name` varchar(150) NOT NULL,
  PRIMARY KEY (`course_id`)
) AUTO_INCREMENT=4;

CREATE TABLE IF NOT EXISTS `assignments` (
  `Title` varchar(100) NOT NULL,
  `Weight` decimal(10,0) NOT NULL,
  `Max Mark` decimal(10,0) NOT NULL,
  `Post Date` date NOT NULL,
  `Due Date` date NOT NULL,
  `assign_id` int NOT NULL AUTO_INCREMENT,
  `assign_instructions` text NOT NULL,
  `course_id` int NOT NULL,
  PRIMARY KEY (`assign_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `course_material` (
  `Post Date` date NOT NULL,
  `Uploaded File` text NOT NULL,
  `material_ID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(250) NOT NULL,
  `TYPE` varchar(100) DEFAULT NULL,
  `course_id` int NOT NULL,
  PRIMARY KEY (`material_ID`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_material_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT=16;

/*Added on April 15th*/

CREATE TABLE IF NOT EXISTS section (
  `sectionID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `section_name` VARCHAR(10) NOT NULL,
  `course_id` INT NOT NULL,
  FOREIGN KEY (`course_id`) REFERENCES courses(`course_id`)
);

CREATE TABLE IF NOT EXISTS `user_course_section` (
  `userID` INT NOT NULL,
  `course_id` INT NOT NULL,
  `sectionID` INT NOT NULL,
  PRIMARY KEY (`userID`, `sectionID`),
  FOREIGN KEY (`userID`) REFERENCES `user`(`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`sectionID`) REFERENCES `section`(`sectionID`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tbl_student
(
  `studentID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userID` INT NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user`(`userID`),
  INDEX (`userID`)
);

CREATE TABLE tbl_ta
(
  `taID_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userID` INT NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user`(`userID`),
  INDEX (`userID`)
);

CREATE TABLE tbl_professor
(
  `professorID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userID` INT NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user`(`userID`),
  INDEX (`userID`)
);










/*Fill the database*/

INSERT INTO role (`role_name`) VALUES
("Admin"),
("Professor"),
("TA"),
("Student");

INSERT INTO `user` (`first_name`, `last_name`, `dob`, `email`, `username`, password, `first_login`, `roleID`) VALUES 
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

INSERT IGNORE INTO `groups` (`groupID`, `group_name`) VALUES
(1, "group_1"),
(2, "group_2"),
(3, "group_3"),
(4, "group_4");

UPDATE `user`
SET `groupID` = NULL
WHERE `roleID` IN (1, 2, 3);

UPDATE `user`
SET `groupID` = 1
WHERE `username` IN ("danielmartinez", "sophiawilson", "user1");

UPDATE `user`
SET `groupID` = 2
WHERE `username` IN ("oliviahernandez", "chrisanderson", "emmataylor");

INSERT IGNORE INTO `courses` (`course_id`, `course_name`, `course_code`, `dept_name`, `semester`, `room_no`, `instructor_name`) VALUES
(1, 'Computer Organization and Design', 'COMP5201', 'Computer Science', 'Fall 2023', 'ER201', 'David'),
(2, 'Principles of Data Structures', 'COMP5511', 'Computer Science', 'Fall 2023', 'H831', 'Bipin Desai'),
(3, 'Files and Databases', 'COMP5531', 'Computer Science', 'Winter 2024', 'H5201', 'Bipin Desai');

INSERT IGNORE INTO `assignments` (`Title`, `Weight`, `Max Mark`, `Post Date`, `Due Date`, `assign_id`, `assign_instructions`, `course_id`) VALUES
('Test assignment', '5', '100', '2024-04-10', '2024-04-23', 1, '', 2),
('a3', '2', '3', '2024-04-01', '2024-04-20', 2, 'uploads/uploaded_assignments/db22j-a3.pdf', 3),
('a2', '3', '2', '2024-04-17', '2024-04-01', 3, 'uploads/uploaded_assignments/db24j-asg2.pdf', 1),
('A1', '2', '1', '2024-03-31', '2024-04-10', 5, 'uploads/uploaded_assignments/db24j-a1.pdf', 3),
('Asn1', '2', '2', '2024-04-07', '2024-04-16', 6, 'uploads/uploaded_assignments/Assignment1.pdf', 1),
('a2', '45', '12', '2024-04-08', '2024-04-17', 7, 'uploads/uploaded_assignments/a2.pdf', 1);

INSERT IGNORE INTO `course_material` (`Post Date`, `Uploaded File`, `material_ID`, `Title`, `TYPE`, `course_id`) VALUES
('2024-01-10', 'uploads/10-Storage-files-indexing.pdf', 5, 'Lecture 10', 'Lecture', 3),
('2024-04-02', 'uploads/2-Simple-Sql.pdf', 9, 'Lecture 2', 'Lecture', 3),
('2024-04-02', 'uploads/Lab 1.pdf', 12, 'Tutorial 1', 'tutorial', 3),
('2024-04-02', 'uploads/Lecture1.pdf', 14, 'Lecture 1', 'lecture', 1),
('2024-04-02', 'uploads/00. Course Outline.pdf', 15, 'Course Outline', 'lecture', 2);

/*Added on April 15th*/

INSERT IGNORE INTO `section` (`section_name`, `course_id`) VALUES
('Section A', 1),
('Section B', 1),
('Section C', 1),
('Section A', 2),
('Section A', 3),
('Section B', 3);

INSERT IGNORE INTO `user_course_section` (`userID`, `course_id`, `sectionID`)
SELECT u.`userID`, c.course_id, 
    CASE 
        WHEN u.`userID` % 3 = 0 THEN s1.`sectionID`
        WHEN u.`userID` % 3 = 1 THEN s2.`sectionID`
        ELSE s3.`sectionID` 
    END AS `sectionID`
FROM `user` u
JOIN `courses` c ON c.course_id = 1
JOIN `section` s1 ON s1.course_id = c.course_id AND s1.`section_name` = 'Section A'
JOIN `section` s2 ON s2.course_id = c.course_id AND s2.`section_name` = 'Section B'
JOIN `section` s3 ON s3.course_id = c.course_id AND s3.`section_name` = 'Section C'
WHERE u.roleID = 4;
