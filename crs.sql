-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2024 at 10:53 PM
-- Server version: 8.0.31
-- PHP Version: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crs`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `Title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Weight` decimal(10,0) NOT NULL,
  `Max Mark` decimal(10,0) NOT NULL,
  `Post Date` date NOT NULL,
  `Due Date` date NOT NULL,
  `assign_id` int NOT NULL,
  `assign_instructions` text COLLATE utf8mb4_general_ci NOT NULL,
  `course_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`Title`, `Weight`, `Max Mark`, `Post Date`, `Due Date`, `assign_id`, `assign_instructions`, `course_id`) VALUES
('Test assignment', '5', '100', '2024-04-10', '2024-04-23', 1, '', 2),
('a3', '2', '3', '2024-04-01', '2024-04-20', 2, 'uploads/uploaded_assignments/db22j-a3.pdf', 3),
('a2', '3', '2', '2024-04-17', '2024-04-01', 3, 'uploads/uploaded_assignments/db24j-asg2.pdf', 1),
('A1', '2', '1', '2024-03-31', '2024-04-10', 5, 'uploads/uploaded_assignments/db24j-a1.pdf', 3),
('Asn1', '2', '2', '2024-04-07', '2024-04-16', 6, 'uploads/uploaded_assignments/Assignment1.pdf', 1),
('a2', '45', '12', '2024-04-08', '2024-04-17', 7, 'uploads/uploaded_assignments/a2.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `course_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `course_code` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `dept_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `room_no` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `instructor_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `dept_name`, `semester`, `room_no`, `instructor_name`) VALUES
(1, 'Computer Organization and Design', 'COMP5201', 'Computer Science', 'Fall 2023', 'ER201', 'David'),
(2, 'Principles of Data Structures', 'COMP5511', 'Computer Science', 'Fall 2023', 'H831', 'Bipin Desai'),
(3, 'Files and Databases', 'COMP5531', 'Computer Science', 'Winter 2024', 'H5201', 'Bipin Desai');

-- --------------------------------------------------------

--
-- Table structure for table `course_material`
--

CREATE TABLE `course_material` (
  `Post Date` date NOT NULL,
  `Uploaded File` text COLLATE utf8mb4_general_ci NOT NULL,
  `material_ID` int NOT NULL,
  `Title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `TYPE` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `course_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_material`
--

INSERT INTO `course_material` (`Post Date`, `Uploaded File`, `material_ID`, `Title`, `TYPE`, `course_id`) VALUES
('2024-01-10', 'uploads/10-Storage-files-indexing.pdf', 5, 'Lecture 10', 'Lecture', 3),
('2024-04-02', 'uploads/2-Simple-Sql.pdf', 9, 'Lecture 2', 'Lecture', 3),
('2024-04-02', 'uploads/Lab 1.pdf', 12, 'Tutorial 1', 'tutorial', 3),
('2024-04-02', 'uploads/Lecture1.pdf', 14, 'Lecture 1', 'lecture', 1),
('2024-04-02', 'uploads/00. Course Outline.pdf', 15, 'Course Outline', 'lecture', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleID` int NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Professor'),
(4, 'Student'),
(3, 'TA');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `first_login` tinyint(1) DEFAULT '1',
  `roleID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `first_name`, `last_name`, `dob`, `email`, `username`, `password`, `first_login`, `roleID`) VALUES
(1000, 'John', 'Doe', '1990-05-15', 'john@example.com', 'johndoe', '12345', 1, 1),
(1001, 'Alice', 'Smith', '1988-09-23', 'alice@example.com', 'alicesmith', '12345', 1, 2),
(1002, 'user2FN', 'user2LN', '1999-11-01', 'user2@example.com', 'user2', '12345', 1, 2),
(1003, 'Bob', 'Johnson', '1995-02-10', 'bob@example.com', 'bobjohnson', '12345', 1, 3),
(1004, 'Emily', 'Brown', '1992-11-30', 'emily@example.com', 'emilybrown', '12345', 1, 3),
(1005, 'Michael', 'Davis', '1987-07-18', 'michael@example.com', 'michaeldavis', '12345', 1, 4),
(1006, 'user1FN', 'user1LN', '1991-07-12', 'user1@example.com', 'user1', '12345', 1, 4),
(1007, 'Sophia', 'Wilson', '1998-04-05', 'sophia@example.com', 'sophiawilson', '12345', 1, 4),
(1008, 'Daniel', 'Martinez', '1993-12-20', 'daniel@example.com', 'danielmartinez', '12345', 1, 4),
(1009, 'Emma', 'Taylor', '1991-08-08', 'emma@example.com', 'emmataylor', '12345', 1, 4),
(1010, 'Christopher', 'Anderson', '1994-06-25', 'chris@example.com', 'chrisanderson', '12345', 1, 4),
(1011, 'Olivia', 'Hernandez', '1989-03-12', 'olivia@example.com', 'oliviahernandez', '12345', 1, 4),
(1012, 'student', 'student', '1996-11-01', 'student@student.com', 'student', 'student', 1, 4),
(1013, 'professor', 'professor', '1984-01-12', 'professor@professor.com', 'professor', 'professor', 0, 2),
(1014, 'Teaching', 'Assistant', '1990-02-12', 'ta@ta.com', 'ta', 'ta', 1, 3),
(1015, 'admin', 'admin', '1994-03-11', 'admin@admin.com', 'admin', 'admin', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `course_id_2` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_material`
--
ALTER TABLE `course_material`
  ADD PRIMARY KEY (`material_ID`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `course_id_2` (`course_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleID`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `roleID` (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assign_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_material`
--
ALTER TABLE `course_material`
  MODIFY `material_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1016;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_material`
--
ALTER TABLE `course_material`
  ADD CONSTRAINT `course_material_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
