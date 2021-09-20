-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 16, 2021 at 11:44 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `288wampproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_courses`
--

CREATE TABLE `t_courses` (
  `ID_course` int(11) NOT NULL,
  `course_code` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_desc` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_courses`
--

INSERT INTO `t_courses` (`ID_course`, `course_code`, `course_desc`) VALUES
(1, '12345', 'Biology'),
(2, '23456', 'Mathematics'),
(3, '34567', 'History'),
(4, '45678', 'Intensive Programming');

-- --------------------------------------------------------

--
-- Table structure for table `t_schedules`
--

CREATE TABLE `t_schedules` (
  `ID_schedule` int(11) NOT NULL,
  `ID_student` int(11) NOT NULL,
  `ID_course` int(11) NOT NULL,
  `sched_yr` int(4) NOT NULL,
  `sched_sem` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_letter` char(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_schedules`
--

INSERT INTO `t_schedules` (`ID_schedule`, `ID_student`, `ID_course`, `sched_yr`, `sched_sem`, `grade_letter`) VALUES
(112233, 102030, 3, 2020, 'FA', 'B+'),
(122436, 102030, 4, 2021, 'S2', 'A+'),
(132639, 203040, 2, 2021, 'FA', 'A'),
(142842, 203040, 4, 2021, 'S2', 'A+'),
(153048, 203040, 2, 2020, 'SP', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `t_students`
--

CREATE TABLE `t_students` (
  `ID_student` int(11) NOT NULL,
  `fname` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `start_dte` date NOT NULL,
  `end_dte` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_students`
--

INSERT INTO `t_students` (`ID_student`, `fname`, `lname`, `phone`, `email`, `status`, `start_dte`, `end_dte`) VALUES
(102030, 'Sasha', 'Rider', '234-456-7898', 'sr1469@rutgers.edu', 1, '2021-07-12', '2021-08-18'),
(203040, 'Jerry', 'Illanovsky', '222-222-2222', 'Jerry@rutgers.edu', 1, '2021-07-12', '2021-08-18'),
(203041, 'Vlad', 'Entin', '123-123-1231', 've@rutgers.edu', 1, '2021-08-17', '2021-09-27'),
(203042, 'John', 'Doe', '222-000-0000', 'jdoe@rutgers.edu', 1, '2021-08-16', '2021-09-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_courses`
--
ALTER TABLE `t_courses`
  ADD PRIMARY KEY (`ID_course`);

--
-- Indexes for table `t_schedules`
--
ALTER TABLE `t_schedules`
  ADD PRIMARY KEY (`ID_schedule`),
  ADD KEY `ID_student` (`ID_student`),
  ADD KEY `t_schedules_ibfk_2` (`ID_course`);

--
-- Indexes for table `t_students`
--
ALTER TABLE `t_students`
  ADD PRIMARY KEY (`ID_student`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_courses`
--
ALTER TABLE `t_courses`
  MODIFY `ID_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_schedules`
--
ALTER TABLE `t_schedules`
  MODIFY `ID_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153049;

--
-- AUTO_INCREMENT for table `t_students`
--
ALTER TABLE `t_students`
  MODIFY `ID_student` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203044;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_schedules`
--
ALTER TABLE `t_schedules`
  ADD CONSTRAINT `t_schedules_ibfk_1` FOREIGN KEY (`ID_student`) REFERENCES `t_students` (`ID_student`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_schedules_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `t_courses` (`ID_course`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
