-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 08:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schooldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `course_description` varchar(100) DEFAULT NULL,
  `course_year` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_description`, `course_year`) VALUES
(12, 'BSIT', 1),
(15, 'ABM', 11),
(16, 'BSBA', 1),
(17, 'BSOA', 1),
(18, 'ICT', 11),
(19, 'GAS', 11),
(20, 'HUMSS', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_days`
--

CREATE TABLE `tbl_days` (
  `day_id` int(11) NOT NULL,
  `day_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_days`
--

INSERT INTO `tbl_days` (`day_id`, `day_name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`id`, `title`, `date`, `description`) VALUES
(27, 'Start of Classes', '2024-07-29', 'Beginning of the first semester classes.'),
(28, 'Ninoy Aquino Day', '2024-08-21', 'Commemoration of Ninoy Aquino\'s death.'),
(29, 'National Heroes Day', '2024-08-26', 'Celebration of National Heroes Day.'),
(30, 'Prelim Examination', '2024-08-29', 'Preliminary examinations for the first semester.'),
(31, 'Prelim Examination', '2024-08-30', 'Preliminary examinations for the first semester.'),
(32, 'Prelim Examination', '2024-08-31', 'Preliminary examinations for the first semester.'),
(33, 'Osmeña Day', '2024-09-09', 'Celebration of Osmeña Day.'),
(34, 'SPG/SSG Election', '2024-09-10', 'Student elections for SPG/SSG.'),
(35, 'SPG/SSG Election', '2024-09-11', 'Student elections for SPG/SSG.'),
(36, 'SPG/SSG Election', '2024-09-12', 'Student elections for SPG/SSG.'),
(37, 'SPG/SSG Election', '2024-09-13', 'Student elections for SPG/SSG.'),
(38, 'SPG/SSG Election', '2024-09-14', 'Student elections for SPG/SSG.'),
(39, 'Midterm Examination (1st Quarter Examination)', '2024-10-02', 'Midterm examinations for the first quarter.'),
(40, 'Midterm Examination (1st Quarter Examination)', '2024-10-03', 'Midterm examinations for the first quarter.'),
(41, 'Midterm Examination (1st Quarter Examination)', '2024-10-04', 'Midterm examinations for the first quarter.'),
(42, 'Intramurals', '2024-10-28', 'School-wide intramural sports competition.'),
(43, 'Intramurals', '2024-10-29', 'School-wide intramural sports competition.'),
(44, 'Intramurals', '2024-10-30', 'School-wide intramural sports competition.'),
(45, 'All Saints Day', '2024-11-01', 'Observance of All Saints Day.'),
(46, 'All Souls Day', '2024-11-02', 'Observance of All Souls Day.'),
(47, 'Pre-Final Examination', '2024-11-07', 'Pre-final examinations for the first semester.'),
(48, 'Pre-Final Examination', '2024-11-08', 'Pre-final examinations for the first semester.'),
(49, 'Pre-Final Examination', '2024-11-09', 'Pre-final examinations for the first semester.'),
(50, 'Bonifacio Day', '2024-11-30', 'Commemoration of Andres Bonifacio\'s birthday.'),
(51, 'Feast of the Immaculate Conception', '2024-12-08', 'Religious observance of the Feast of the Immaculate Conception.'),
(52, 'Final Examination (2nd Quarter Examination)', '2024-12-11', 'Final examinations for the second quarter.'),
(53, 'Final Examination (2nd Quarter Examination)', '2024-12-12', 'Final examinations for the second quarter.'),
(54, 'Final Examination (2nd Quarter Examination)', '2024-12-13', 'Final examinations for the second quarter.'),
(55, 'Acquaintance Party / Christmas Party / End of the ', '2024-12-14', 'Acquaintance and Christmas party marking the end of the first semester.'),
(56, 'Christmas Break', '2024-12-16', 'Start of the Christmas break.'),
(57, 'Christmas Break', '2024-12-17', 'Start of the Christmas break.'),
(58, 'Christmas Break', '2024-12-18', 'Start of the Christmas break.'),
(59, 'Christmas Break', '2024-12-19', 'Start of the Christmas break.'),
(60, 'Christmas Break', '2024-12-20', 'Start of the Christmas break.'),
(61, 'Christmas Break', '2024-12-21', 'Start of the Christmas break.'),
(62, 'Christmas Break', '2024-12-22', 'Start of the Christmas break.'),
(63, 'Christmas Break', '2024-12-23', 'Start of the Christmas break.'),
(64, 'Christmas Break', '2024-12-24', 'Start of the Christmas break.'),
(65, 'Christmas Break', '2024-12-25', 'Start of the Christmas break.'),
(66, 'Christmas Break', '2024-12-26', 'Start of the Christmas break.'),
(67, 'Christmas Break', '2024-12-27', 'Start of the Christmas break.'),
(68, 'Christmas Break', '2024-12-28', 'Start of the Christmas break.'),
(69, 'Christmas Break', '2024-12-29', 'Start of the Christmas break.'),
(70, 'Christmas Break', '2024-12-30', 'Start of the Christmas break.'),
(71, 'Christmas Break', '2024-12-31', 'Start of the Christmas break.'),
(74, 'Nutrition Month and Buwan ng Wika Celebration', '2024-08-16', 'Nutrition Month and Buwan ng Wika Celebration');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_grades`
--

CREATE TABLE `tbl_grades` (
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(20) NOT NULL,
  `term` varchar(20) NOT NULL,
  `grade` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_grades`
--

INSERT INTO `tbl_grades` (`grade_id`, `user_id`, `id`, `term`, `grade`) VALUES
(1, 11, 60, 'Final', 1.80),
(2, 11, 62, 'Final', 1.80);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `payment_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `paymentPeriod` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`room_id`, `room_name`) VALUES
(4, 'Room 3'),
(5, 'Room 4'),
(7, 'Room 1'),
(8, 'Room 5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `schedule_id` int(11) NOT NULL,
  `instructor_id` int(20) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`schedule_id`, `instructor_id`, `course_id`, `subject_id`, `room_id`, `time_id`, `day_id`) VALUES
(105, 39, 12, 14, 4, 4, 2),
(106, 44, 18, 23, 5, 4, 4),
(107, 46, 15, 15, 8, 9, 6),
(110, 46, 15, 15, 7, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sched_time`
--

CREATE TABLE `tbl_sched_time` (
  `time_id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sched_time`
--

INSERT INTO `tbl_sched_time` (`time_id`, `start_time`, `end_time`) VALUES
(3, '09:00:00', '11:00:00'),
(4, '10:00:00', '11:00:00'),
(9, '10:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `middleInitial` varchar(10) NOT NULL,
  `Suffix` varchar(15) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year` int(10) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bdate` varchar(50) NOT NULL,
  `pob` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `major` varchar(50) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `civilStatus` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `modality` varchar(20) NOT NULL,
  `fb` varchar(30) NOT NULL,
  `curAddress` varchar(200) NOT NULL,
  `cityAdd` varchar(200) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `fatherName` varchar(50) NOT NULL,
  `fwork` varchar(50) NOT NULL,
  `motherName` varchar(50) NOT NULL,
  `mwork` varchar(50) NOT NULL,
  `primarySchool` varchar(100) NOT NULL,
  `primaryAddress` text NOT NULL,
  `primaryCompleted` varchar(30) NOT NULL,
  `entermediateSchool` varchar(100) NOT NULL,
  `entermediateAddress` text NOT NULL,
  `entermediateCompleted` varchar(30) NOT NULL,
  `hsSchool` varchar(100) NOT NULL,
  `hsAddress` text NOT NULL,
  `hsCompleted` varchar(30) NOT NULL,
  `shSchool` varchar(100) NOT NULL,
  `shAddress` text NOT NULL,
  `shCompleted` varchar(30) NOT NULL,
  `collegeSchool` varchar(100) NOT NULL,
  `collegeAddress` text NOT NULL,
  `collegeCompleted` varchar(30) NOT NULL,
  `user_image` varchar(50) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`user_id`, `user_name`, `lname`, `fname`, `middleInitial`, `Suffix`, `course`, `year`, `contact`, `gender`, `bdate`, `pob`, `email`, `major`, `nationality`, `civilStatus`, `religion`, `modality`, `fb`, `curAddress`, `cityAdd`, `zipcode`, `fatherName`, `fwork`, `motherName`, `mwork`, `primarySchool`, `primaryAddress`, `primaryCompleted`, `entermediateSchool`, `entermediateAddress`, `entermediateCompleted`, `hsSchool`, `hsAddress`, `hsCompleted`, `shSchool`, `shAddress`, `shCompleted`, `collegeSchool`, `collegeAddress`, `collegeCompleted`, `user_image`, `user_role`, `user_pass`, `semester`, `status`) VALUES
(11, 'MIIT-2021-137', 'Dihayco', 'Sheinalie', 'V.', '-', 'BSIT', 4, '09996707038', 'Female', '2003-02-09', 'Mactan, Lapu-Lapu City , Cebu', 'dihayco020903@gmail.com', 'Programming', 'Filipino', 'Single', 'Roman Catholic', 'Face to Face', 'Shien Dihayco', 'Purok Sagay, Kalubihan', 'Tuyan, City of Naga, Cebu', '6037', 'Mechille V. DIhayco', 'N/A', 'Divina V. Dihayco', 'Baby Sitter', 'Punta Engano Elementary School', 'Puntan Engano, Lapu-Lapu City', '2012-2013', 'TCES', 'Tuyan, City of Naga', '2014-2015', 'TNHS', 'Tabtuy, Tuyan, City of Naga, Cebu', '2018-2019 ', 'TUYAN SENIOR HIGH SCHOOL', 'Tabtuy, Tuyan, City of Naga, Cebu', '2020-2021', 'MIIT', 'Inayagan, City of Naga, Cebu', '-', '', 'student', '$2y$10$BM7eCopSmj9S3gert/CseugEt/QB0U9WGwXdnZfzgC8', 1, 'Enrolled'),
(12, 'MIIT-2021-124', 'Algarme', 'Zean Mariuss', '', '', 'BSIT', 4, '', '', '', '', 'zuild@gmail.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'student', '$2y$10$9tOOOKvKC6PmttS.R/qeb.YvEcuyncF3Sm21ae5c5Bx', 1, 'Enrolled'),
(13, 'MIIT-2021-160', 'Tahanlangit', 'Louie', '', '', 'BSIT', 4, '', '', '', '', 'louiethnlngt@gmail.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'student', '$2y$10$5dqMr7rctb4AbkuDzhfXGeYvslAQzUyoa63R0AWQMyj', 1, 'Enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_instructors`
--

CREATE TABLE `tbl_student_instructors` (
  `student_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_instructors`
--

INSERT INTO `tbl_student_instructors` (`student_id`, `instructor_id`) VALUES
(11, 39),
(11, 44),
(11, 48),
(12, 48);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `lec` int(11) NOT NULL,
  `lab` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `pre_req` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id`, `year`, `semester`, `code`, `description`, `lec`, `lab`, `unit`, `pre_req`, `total`, `course`) VALUES
(8, 1, 1, 'GE 1', 'Understanding the Self ', 3, 0, 3, '1', 3, 'BSIT'),
(9, 1, 1, 'GE 2', 'Ethics ', 3, 0, 3, 'none', 3, 'BSIT'),
(10, 1, 1, 'GE 6 ', 'Mathemtatics in the Modern World', 3, 0, 3, 'None', 3, 'BSIT'),
(11, 1, 1, 'GE 4 ', 'Science, Technology and Society', 3, 0, 3, 'None', 3, 'BSIT'),
(12, 1, 1, 'FIL 1 ', 'Wikang Filipino ', 2, 1, 3, 'None', 5, 'BSIT'),
(13, 1, 1, 'CC101', 'Introduction to Computing ', 2, 1, 3, 'None', 5, 'BSIT'),
(14, 1, 1, 'CC102', 'Computer Programming ', 3, 0, 3, 'None', 3, 'BSIT'),
(15, 1, 1, 'ENGPLUS', 'English Enhancement ', 3, 0, 3, 'None', 3, 'BSIT'),
(16, 1, 1, 'MATHPLUS', 'Basic Mathematics ', 3, 0, 3, 'None', 3, 'BSIT'),
(17, 1, 1, 'PE1', 'Physical Fitness ', 2, 0, 2, 'None', 2, 'BSIT'),
(18, 1, 1, 'NSTP1', 'National Service Training Program 1', 3, 0, 3, 'None', 3, 'BSIT'),
(19, 1, 2, 'EN2', 'Technical Writing ', 3, 0, 3, 'None', 3, 'BSIT'),
(20, 1, 2, 'FIL2', 'Pagbasa at Pagsulat Tungo sa Pananaliksik', 3, 0, 3, 'FIL1', 3, 'BSIT'),
(21, 1, 2, 'GE5', 'Purposive Communication ', 3, 0, 3, 'None', 3, 'BSIT'),
(22, 1, 2, 'GE7', 'Contemporary World', 3, 0, 3, 'None', 3, 'BSIT'),
(23, 1, 2, 'HCI101', 'Introduction to Human Computer Interaction', 2, 1, 3, 'CC101', 5, 'BSIT'),
(24, 1, 2, 'CC103', 'Computer Programming 2 ', 2, 1, 3, 'CC 102', 5, 'BSIT'),
(25, 1, 2, 'MS101', 'Discrete Mathematics ', 3, 0, 3, 'None', 3, 'BSIT'),
(26, 1, 2, 'NSTP2', 'National Service Training Program 2', 3, 0, 3, 'NSTP1', 3, 'BSIT'),
(27, 1, 2, 'PE2', 'Rhythmic Activity', 2, 0, 2, 'PE1', 2, 'BSIT'),
(28, 2, 1, 'GE8', 'Art Appreciation ', 3, 0, 3, 'None', 3, 'BSIT'),
(29, 2, 1, 'PF201', 'Object Oriented Programming 1', 2, 1, 3, 'CC103', 5, 'BSIT'),
(30, 2, 1, 'HUM1 ', 'Logic ', 3, 0, 3, 'None', 3, 'BSIT'),
(31, 2, 1, 'SOC1', 'Economics, Taxation and Land Reform ', 3, 0, 3, 'None', 3, 'BSIT'),
(32, 2, 1, 'CC203', 'Information Management 1', 2, 1, 3, 'CC103', 5, 'BSIT'),
(33, 2, 1, 'CC204', 'Data Structures and Algorithm', 2, 1, 3, 'CC101', 5, 'BSIT'),
(34, 2, 1, 'IT201', 'PC Assembling and Disassembling ', 2, 1, 3, 'None', 3, 'BSIT'),
(35, 2, 1, 'ACCTG ', 'Principles of Accounting ', 3, 0, 3, 'None', 3, 'BSIT'),
(36, 2, 1, 'PE3', 'Individual and Dual Sport', 2, 0, 2, 'PE2', 2, 'BSIT'),
(37, 2, 2, 'GE3 ', 'Reading Philippine History ', 3, 0, 3, 'None', 3, 'BSIT'),
(38, 2, 2, 'PF205', 'Object Oriented Progamming 2 ', 2, 1, 3, 'PF201', 5, 'BSIT'),
(39, 2, 2, 'PGC', 'Phil. Governance and Constitution', 3, 0, 3, 'None', 3, 'BSIT'),
(40, 2, 2, 'IM207', 'Fundamentals of Database Systems ', 2, 1, 3, 'CC203', 5, 'BSIT'),
(41, 2, 2, 'NET208', 'Networking 1', 2, 1, 3, 'None', 5, 'BSIT'),
(42, 2, 2, 'IPT209', 'Interactive Programming and Technology 1', 2, 1, 3, 'HCI202', 5, 'BSIT'),
(43, 2, 2, 'MATH3', 'Probability and Statistics ', 3, 0, 3, 'Math 1', 3, 'BSIT'),
(44, 2, 2, 'PE4', 'Team Sports ', 2, 0, 2, 'PE3', 2, 'BSIT'),
(45, 3, 1, 'WS301', 'Free Elective ', 2, 1, 3, 'IPT209', 5, 'BSIT'),
(46, 3, 1, 'NATSCI1', 'Physical Science ', 3, 0, 3, 'None', 3, 'BSIT'),
(47, 3, 1, 'SIA304', 'System Integration and Architecture 1 - Elective ', 2, 1, 3, 'IT201', 5, 'BSIT'),
(48, 3, 1, 'HUM', 'Intro to Literature', 2, 1, 3, 'None', 3, 'BSIT'),
(49, 3, 1, 'IT306 ', 'Multimedia Systems', 2, 1, 3, 'IM207', 5, 'BSIT'),
(50, 3, 1, 'IT307', 'System Analysis and Design ', 2, 1, 3, 'IM207', 5, 'BSIT'),
(51, 3, 1, '-', 'Free Elective ', 2, 1, 3, 'HCI101', 5, 'BSIT'),
(52, 3, 2, 'GE9', 'Life and Works of Rizal & Other Heroes', 3, 0, 3, 'None', 3, 'BSIT'),
(53, 3, 2, 'IT308', 'Software Engineering ', 2, 1, 3, 'CC204', 5, 'BSIT'),
(54, 3, 2, 'MS309', 'Quantitative Methods', 3, 0, 3, 'MS101', 3, 'BSIT'),
(55, 3, 2, 'WS310', 'Technopreneurship', 2, 1, 3, 'WS301', 5, 'BSIT'),
(56, 3, 2, 'IAS311', 'Information Assurance and Security', 2, 1, 2, 'CC101', 5, 'BSIT'),
(57, 3, 2, 'SIA312', 'Elective', 2, 1, 3, 'SIA304', 5, 'BSIT'),
(58, 3, 2, 'NATSCI2', 'College Physics', 3, 0, 3, '-', 5, 'BSIT'),
(59, 3, 2, 'PT206', 'Free Elective(Project Management) ', 2, 1, 3, 'CC103', 5, 'BSIT'),
(60, 3, 2, 'CC313', 'Application Development and Emerging Tech.', 2, 1, 3, 'PF205', 5, 'BSIT'),
(61, 3, 2, 'NATSCI2', 'Physics', 3, 0, 3, 'None', 5, 'BSIT'),
(62, 3, 2, 'CAP314', 'Capstone Project 1', 2, 1, 3, '3rd Year', 5, 'BSIT'),
(63, 4, 1, 'CAP401', 'Capstone Project 2', 2, 1, 3, 'CAP314', 5, 'BSIT'),
(64, 4, 1, 'IT 402', 'Computer Systems Services NC II - Elective', 2, 1, 3, 'CC101', 5, 'BSIT'),
(65, 4, 1, 'SP 403', 'Social and Proffesional Issues', 3, 0, 3, 'None', 3, 'BSIT'),
(66, 4, 1, 'IT 404', 'Seminar in IT Trends/updates - Elective', 3, 0, 3, ' None', 3, 'BSIT'),
(67, 4, 1, 'SA 405', 'System Administration and Maintenance', 2, 1, 3, 'None', 5, 'BSIT'),
(68, 4, 2, 'OJT', 'Internships/OJT/Practicum ', 9, 0, 9, '4th year', 27, 'BSIT'),
(69, 3, 1, 'GE10', 'Social Science And Philosophy', 3, 0, 3, 'ALL GE', 17, 'BSOA'),
(70, 3, 1, 'Comp3', 'Internet Research for Business', 1, 2, 3, 'Comp 1 & 2', 17, 'BSOA'),
(71, 3, 1, 'STENO4', 'Machine Shorthand 1', 3, 2, 3, 'STENO 1, 2, & 3', 17, 'BSOA'),
(72, 3, 1, 'OA Elective 1', 'OA Professional Elective 1 - Legal / Medical Offic', 3, 0, 3, 'OA 1,2, & 3', 17, 'BSOA'),
(73, 3, 1, 'EM', 'Events Management', 3, 0, 3, 'NONE', 17, 'BSOA'),
(74, 3, 1, 'Finance', 'Basic Finance', 3, 0, 3, 'ACCTG1', 17, 'BSOA'),
(75, 3, 1, 'Entrep', 'Entrepreneurial Behavior and Competencies', 3, 0, 3, 'NONE', 17, 'BSOA'),
(77, 3, 2, 'GE11', 'Mathematics, Science and Technology', 3, 0, 3, 'ALL GE', 16, 'BSOA'),
(78, 3, 2, 'Comp4', 'Integrated Software Applications', 1, 3, 3, 'Comp 3', 16, 'BSOA'),
(79, 3, 2, 'RMG101', 'Records Management', 3, 0, 3, 'NONE', 16, 'BSOA'),
(80, 3, 2, 'ENG', 'Business Communication (Conversational English)', 3, 0, 3, 'NONE', 16, 'BSOA'),
(81, 3, 2, 'OA5', 'Public and Customer Relations', 3, 0, 3, 'EM', 16, 'BSOA'),
(82, 3, 2, 'OA6', 'Corporate Social Responsibility', 3, 0, 3, 'NONE', 16, 'BSOA'),
(83, 3, 2, 'MS', 'MS Concept', 3, 0, 3, 'Comp 1, 2, & 3', 16, 'BSOA'),
(85, 1, 1, 'GE 2', 'Ethics', 3, 0, 3, 'None', 23, 'BSOA'),
(86, 1, 1, 'GE 3', 'Readings In Philippine History', 3, 0, 3, 'None', 23, 'BSOA'),
(87, 1, 1, 'GE 4', 'Science, Technology, and Society', 3, 0, 3, 'None', 23, 'BSOA'),
(88, 1, 1, 'PDDR1', 'Personal Development', 3, 0, 3, 'None', 23, 'BSOA'),
(89, 1, 1, 'STENO1', 'Foundation of Shorthand', 3, 0, 3, 'None', 23, 'BSOA'),
(90, 1, 1, 'PathFit1', 'Movement Competency Training', 2, 0, 2, 'None', 23, 'BSOA'),
(91, 1, 1, 'NSTP1', 'Civic Welfare Training Service 1', 3, 0, 3, 'None', 23, 'BSOA'),
(92, 1, 2, 'GE 5', 'Purposive Communication', 3, 0, 3, 'None', 22, 'BSOA'),
(93, 1, 2, 'GE 6', 'Mathematics in the Modern World', 3, 0, 3, 'None', 22, 'BSOA'),
(94, 1, 2, 'GE 7', 'The Contemporary World', 3, 0, 3, 'None', 22, 'BSOA'),
(95, 1, 2, 'COMP1', 'Keyboarding and Documents Processing', 2, 1, 3, 'None', 22, 'BSOA'),
(96, 1, 2, 'OA1', 'Administrative Office Procedures and Management', 3, 0, 3, 'CS1', 22, 'BSOA'),
(97, 1, 2, 'STENO2', 'Advanced Shorthand', 3, 0, 3, 'STENO 1', 22, 'BSOA'),
(98, 1, 2, 'PathFit2', 'Exercise-based Fitness Activities', 2, 0, 2, 'PathFit1', 22, 'BSOA'),
(99, 1, 2, 'NSTP', 'Civic Welfare Training Service 2', 3, 0, 3, 'NSTP 1', 22, 'BSOA'),
(100, 2, 1, 'GE 8', 'Art Appreciation', 3, 0, 3, 'None', 20, 'BSOA'),
(101, 2, 1, 'TQM', 'Operations Management (TQM)', 3, 0, 3, 'OA1', 20, 'BSOA'),
(102, 2, 1, 'POLSCI1', 'Philippine History with Philippine Constitution', 3, 0, 3, 'None', 20, 'BSOA'),
(103, 2, 1, 'ACCTG1', 'Basic Accounting', 3, 0, 3, 'MATH', 20, 'BSOA'),
(104, 2, 1, 'STENO3', 'Medical And Legal Stenography', 3, 0, 3, 'STENO1 & STENO2', 20, 'BSOA'),
(105, 2, 1, 'HBO', 'Human Behavior In Organization', 3, 0, 3, 'MGT101', 20, 'BSOA'),
(106, 2, 1, 'PathFit3', 'Choice of Dance, Sport, Martial Arts, Group Exerci', 2, 0, 2, 'PathFit2', 20, 'BSOA'),
(107, 2, 2, 'GE 9', 'Rizal\'s Life and Works', 3, 0, 3, 'None', 15, 'BSOA'),
(108, 2, 2, 'OA2', 'Business Report Writing', 3, 0, 3, 'OA1', 15, 'BSOA'),
(109, 2, 2, 'COMP2', 'Computer Fundamentals', 3, 0, 3, 'COMP1', 15, 'BSOA'),
(110, 2, 2, 'OA3', 'Customer Relations', 3, 0, 3, 'OA1', 15, 'BSOA'),
(111, 2, 2, 'OA Intern 1', 'Office Administration Internship (300 hours)', 0, 0, 0, 'First Year Standing', 15, 'BSOA'),
(112, 2, 2, 'PathFit4', 'Choice of Dance, Group Exercise, Outdoor and Adven', 2, 0, 2, 'PathFit3', 15, 'BSOA'),
(113, 4, 1, 'GE12', 'Arts and Humanities', 3, 0, 3, 'GEB', 19, 'BSOA'),
(114, 4, 1, 'OA7', 'Strategic Management', 3, 0, 3, 'TQM, EM', 19, 'BSOA'),
(115, 4, 1, 'OA8', 'Business Law', 3, 0, 3, 'None', 19, 'BSOA'),
(116, 4, 1, 'OA9', 'Taxation', 3, 0, 3, 'None', 19, 'BSOA'),
(117, 4, 1, 'Comp5', 'Desktop Publishing', 3, 0, 3, 'Comp 4', 19, 'BSOA'),
(118, 4, 1, 'OA Elective 2', 'OA Professional Elective 2', 3, 0, 3, 'None', 19, 'BSOA'),
(119, 4, 1, 'OA Elective 3', 'OA Professional Elective 3', 3, 0, 3, 'None', 19, 'BSOA'),
(120, 4, 2, 'OA Elective 4', 'OA Professional Elective 4', 1, 2, 3, 'Elect. 1, 2, & 3', 10, 'BSOA'),
(121, 4, 2, 'OA Elective 5', 'OA Professional Elective 5', 1, 2, 3, 'Elect. 1, 2, & 3', 10, 'BSOA'),
(122, 4, 2, 'OA Elective 6', 'OA Professional Elective 6', 1, 2, 3, 'Elect. 1, 2, & 3', 10, 'BSOA'),
(123, 4, 2, 'ACCTG 02', 'Managerial Accounting', 3, 0, 3, 'ACCTG1', 10, 'BSOA'),
(125, 1, 1, 'GE 2', 'Ethics', 3, 0, 3, 'None', 26, 'BSBA'),
(126, 1, 1, 'GE 3', 'Readings in Philippine History', 3, 0, 3, 'None', 26, 'BSBA'),
(127, 1, 1, 'GE 4', 'Science, Technology, and Society', 3, 0, 3, 'None', 26, 'BSBA'),
(128, 1, 1, 'Fil 1', 'Filipino 1', 3, 0, 3, 'None', 26, 'BSBA'),
(129, 1, 1, 'Math Plus', 'Basic Mathematics', 3, 0, 3, 'None', 26, 'BSBA'),
(130, 1, 1, 'English Plus', 'Grammar and Effective Writing', 3, 0, 3, 'None', 26, 'BSBA'),
(131, 1, 1, 'PE 1', 'Physical Fitness', 2, 0, 2, 'None', 26, 'BSBA'),
(132, 1, 1, 'NSTP', 'National Service Training Program 1', 3, 0, 3, 'None', 26, 'BSBA'),
(133, 1, 2, 'GE 5', 'Purposive Communication', 3, 0, 3, 'GE 1', 21, 'BSBA'),
(134, 1, 2, 'GE 6', 'Mathematics in the Modern World', 3, 0, 3, 'None', 21, 'BSBA'),
(135, 1, 2, 'GE 7', 'The Contemporary World', 3, 0, 3, 'None', 21, 'BSBA'),
(136, 1, 2, 'GE 8', 'Art Appreciation', 3, 0, 3, 'None', 21, 'BSBA'),
(137, 1, 2, 'Fil 2', 'Pagbasa at Pagsulat Tungo sa Pananaliksik', 3, 0, 3, 'Fil 1', 21, 'BSBA'),
(138, 1, 2, 'IT 101', 'Fundamentals of Computer', 1, 2, 3, 'None', 21, 'BSBA'),
(139, 1, 2, 'PE 2', 'Rhythmic Activities', 2, 0, 2, 'PE 1', 21, 'BSBA'),
(140, 1, 2, 'NSTP', 'National Service Training Program 2', 3, 0, 3, 'NSTP 1', 21, 'BSBA'),
(141, 2, 1, 'GE 9', 'Rizal\'s Life and Works', 3, 0, 3, 'None', 20, 'BSBA'),
(142, 2, 1, 'BA CORE 1', 'Basic Microeconomics (Eco)', 3, 0, 3, 'None', 20, 'BSBA'),
(143, 2, 1, 'BA CORE 2', 'Business Law (Obligations and Contracts)', 3, 0, 3, 'None', 20, 'BSBA'),
(144, 2, 1, 'Prof. 1', 'Professional Salesmanship', 3, 0, 3, 'None', 20, 'BSBA'),
(145, 2, 1, 'Common Elective 1', 'Business Correspondence and Communication', 3, 0, 3, 'GE 5', 20, 'BSBA'),
(146, 2, 1, 'Common Elective 2', 'Risk Management', 3, 0, 3, 'None', 20, 'BSBA'),
(147, 2, 1, 'PE 3', 'Individual and Dual Sports', 2, 0, 2, 'PE 2', 20, 'BSBA'),
(148, 2, 2, 'GE Elective', 'Arts and Humanities', 3, 0, 3, 'None', 20, 'BSBA'),
(149, 2, 2, 'BA CORE 3', 'Taxation (Income Taxation)', 3, 0, 3, 'None', 20, 'BSBA'),
(150, 2, 2, 'Prof. 2', 'Marketing Research', 3, 0, 3, 'Prof 1', 20, 'BSBA'),
(151, 2, 2, 'Prof. 3', 'Marketing Management', 3, 0, 3, 'Prof 1', 20, 'BSBA'),
(152, 2, 2, 'Common Elective 3', 'Project Management', 3, 0, 3, 'Com Elec 2', 20, 'BSBA'),
(153, 2, 2, 'Common Elective 4', 'Crisis Management', 3, 0, 3, 'Com Elec 2', 20, 'BSBA'),
(154, 2, 2, 'PE 4', 'Team Sports', 2, 0, 2, 'PE 3', 20, 'BSBA'),
(155, 3, 1, 'BA Core 4', 'Good Governance and Social Responsibility', 3, 0, 3, 'None', 18, 'BSBA'),
(156, 3, 1, 'BA Core 5', 'Human Resource Management', 3, 0, 3, 'None', 18, 'BSBA'),
(157, 3, 1, 'BA Core 6', 'Business Research 1', 3, 0, 3, 'None', 18, 'BSBA'),
(158, 3, 1, 'Prof. 4', 'Distribution Management', 3, 0, 3, 'Prof 2&3', 18, 'BSBA'),
(159, 3, 1, 'Prof. 5', 'Advertising', 3, 0, 3, 'Prof 2&3', 18, 'BSBA'),
(160, 3, 1, 'Elective 1', 'Personal Finance', 3, 0, 3, 'None', 18, 'BSBA'),
(161, 3, 2, 'CBMEC 1', 'Strategic Management', 3, 0, 3, 'None', 21, 'BSBA'),
(162, 3, 2, 'BA Core 7', 'International Business and Trade', 3, 0, 3, 'None', 21, 'BSBA'),
(163, 3, 2, 'BA Core 8', 'Business Research 2', 3, 0, 3, 'BA Core 6', 21, 'BSBA'),
(164, 3, 2, 'Prof. 6', 'Product Management', 3, 0, 3, 'Prof 4&5', 21, 'BSBA'),
(165, 3, 2, 'Prof. 7', 'Retail Management', 3, 0, 3, 'Prof 4&5', 21, 'BSBA'),
(166, 3, 2, 'Elective 2', 'Sales Management', 3, 0, 3, 'None', 21, 'BSBA'),
(167, 3, 2, 'Elective 3', 'Direct Marketing', 3, 0, 3, 'None', 21, 'BSBA'),
(168, 4, 1, 'CBMEC 2', 'Operation Management', 3, 0, 3, 'CBMEC 1', 18, 'BSBA'),
(169, 4, 1, 'Common Elective 5', 'Computer/Accounting', 2, 2, 3, 'None', 18, 'BSBA'),
(170, 4, 1, 'Prof. 8', 'Pricing Strategy', 3, 0, 3, 'Prof 6&7', 18, 'BSBA'),
(171, 4, 1, 'Elective 4', 'Service Marketing', 3, 0, 3, 'None', 18, 'BSBA'),
(172, 4, 1, 'Elective 5', 'International Marketing', 3, 0, 3, 'None', 18, 'BSBA'),
(173, 4, 1, 'BA Core 9', 'Thesis or Feasibility Study', 3, 0, 3, 'BA Core 8', 18, 'BSBA'),
(174, 4, 2, 'Internship', 'Practicum/Work Integrated Learning', 0, 6, 6, 'None', 6, 'BSBA'),
(175, 11, 1, 'English 111', 'Oral Communication in Context', 0, 0, 0, '', 80, 'HUMSS'),
(176, 11, 1, 'Filipino 111', 'Komunikasyon at Pananaliksik sa Wika at Kulturang ', 0, 0, 0, '', 80, 'HUMSS'),
(177, 11, 1, 'Mathematics 111', 'General Mathematics', 0, 0, 0, '', 80, 'HUMSS'),
(178, 11, 1, 'Pol Sci 111', 'Understanding Culture, Society, and Politics', 0, 0, 0, '', 80, 'HUMSS'),
(179, 11, 1, 'P.E.H 111', 'Physical Education and Health', 0, 0, 0, '', 20, 'HUMSS'),
(180, 11, 1, 'English 211', 'English for Academic and Professional Purposes', 0, 0, 0, '', 80, 'HUMSS'),
(181, 11, 1, 'Filipino 211', 'Pagbasa at Pagsusuri ng Iba\'t Ibang Teksto Tungo s', 0, 0, 0, '', 80, 'HUMSS'),
(182, 11, 1, 'Pol Sci 211', 'Philippine Politics & Governance', 0, 0, 0, '', 80, 'HUMSS'),
(183, 11, 1, 'Elective 1', 'Creative Writing/Malikhaing Pagsulat', 0, 0, 0, '', 80, 'HUMSS'),
(184, 11, 2, 'English 311', 'Reading and Writing Skill', 0, 0, 0, 'English for Academic and Professional Purposes', 80, 'HUMSS'),
(185, 11, 2, 'Filipino 311', 'Pagbasa at Pagsusuri sa Iba\'t Ibang Teksto Tungo s', 0, 0, 0, 'Pagbasa at Pagsusuri ng Iba\'t Ibang Teksto sa Lara', 80, 'HUMSS'),
(186, 11, 2, 'Mathematics 211', 'Statistics and Probability', 0, 0, 0, 'General Mathematics', 80, 'HUMSS'),
(187, 11, 2, 'Humanities 111', 'Introduction to the Philosophy of the Human Person', 0, 0, 0, '', 80, 'HUMSS'),
(188, 11, 2, 'P.E.H 211', 'Physical Education and Health', 0, 0, 0, 'P.E.H 111', 20, 'HUMSS'),
(189, 11, 2, 'Res 111', 'Practical Research 1', 0, 0, 0, '', 80, 'HUMSS'),
(190, 11, 2, 'B-Tech 111', 'Empowerment Technologies (E-Tech): ICT for Profess', 0, 0, 0, '', 80, 'HUMSS'),
(191, 11, 2, 'Humanities 211', 'Introduction to World Religions and Belief Systems', 0, 0, 0, '', 80, 'HUMSS'),
(192, 11, 2, 'English 411', 'Creative Non-Fiction: Literary Essay', 0, 0, 0, 'Creative Writing/Malikhaing Pagsulat', 80, 'HUMSS'),
(193, 12, 1, 'Humanities 312', 'Contemporary Philippine Arts from the Regions', 0, 0, 0, '', 80, 'HUMSS'),
(194, 12, 1, 'Science 112', 'Earth and Life Science', 0, 0, 0, '', 80, 'HUMSS'),
(195, 12, 1, 'P.E.H 312', 'Physical Education and Health', 0, 0, 0, 'P.E.H 211', 20, 'HUMSS'),
(196, 12, 1, 'Humanities 412', 'Personal Development/Pansariling Kaunlaran', 0, 0, 0, 'Statistics and Probability, Practical Research 1', 80, 'HUMSS'),
(197, 12, 1, 'Res 212', 'Practical Research 2', 0, 0, 0, '', 80, 'HUMSS'),
(198, 12, 1, 'Entrep 112', 'Entrepreneurship', 0, 0, 0, '', 80, 'HUMSS'),
(199, 12, 1, 'Social Science 112', 'Disciplines and Ideas in the Social Sciences', 0, 0, 0, '', 80, 'HUMSS'),
(200, 12, 1, 'Social Science 212', 'Community Engagement, Solidarity, and Citizenship', 0, 0, 0, 'Understanding Culture, Society, and Politics', 80, 'HUMSS'),
(201, 12, 2, 'Literature 112', '21st Century Literature from the Philippines and t', 0, 0, 0, 'Empowerment Technologies (E-Tech): ICT for Profess', 80, 'HUMSS'),
(202, 12, 2, 'Comp 112', 'Media and Information Literacy', 0, 0, 0, '', 80, 'HUMSS'),
(203, 12, 2, 'Science 212', 'Physical Science', 0, 0, 0, 'Earth and Life Science', 80, 'HUMSS'),
(204, 12, 2, 'P.E.H 412', 'Physical Education and Health', 0, 0, 0, 'P.E.H 312', 20, 'HUMSS'),
(205, 12, 2, 'HUMSS-CAP 112', 'Research Project/Culminating Activity', 0, 0, 0, '', 80, 'HUMSS'),
(206, 12, 2, 'HUMSS-APP 112', 'Work Immersion/Research/Career Advocacy/Culminatin', 0, 0, 0, '', 80, 'HUMSS'),
(207, 12, 2, 'English 512', 'Trends, Networks, and Critical Thinking in the 21s', 0, 0, 0, '', 80, 'HUMSS'),
(208, 12, 2, 'Science 312', 'Discipline and Ideas in the Applied Sciences', 0, 0, 0, '', 80, 'HUMSS'),
(209, 11, 1, 'Eng111', 'Oral Communication in Context', 0, 0, 0, '', 660, 'ABM'),
(210, 11, 1, 'Fil111', 'Komunikasyon at Pananaliksik sa Wika at Kulturang ', 0, 0, 0, '', 660, 'ABM'),
(211, 11, 1, 'Math111', 'General Mathematics', 0, 0, 0, '', 660, 'ABM'),
(212, 11, 1, 'PolSci111', 'Understanding Culture, Society and Politics', 0, 0, 0, '', 660, 'ABM'),
(213, 11, 1, 'PE111', 'Physical Education and Health', 0, 0, 0, '', 660, 'ABM'),
(214, 11, 1, 'Eng211', 'English for Academic and Professional Purposes', 0, 0, 0, '', 660, 'ABM'),
(215, 11, 1, 'Fil211', 'Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo s', 0, 0, 0, 'Fil111', 660, 'ABM'),
(216, 11, 1, 'Econ111', 'Applied Economics', 0, 0, 0, '', 660, 'ABM'),
(217, 11, 1, 'Acctg111', 'Fundamentals of Accountancy, Business and Manageme', 0, 0, 0, '', 660, 'ABM'),
(218, 11, 2, 'Eng311', 'Reading and Writing Skill', 0, 0, 0, 'Eng111', 660, 'ABM'),
(219, 11, 2, 'Fil311', 'Pagbasa at Pagsusuri sa Iba’t-ibang Teksto Tungo s', 0, 0, 0, 'Fil211', 660, 'ABM'),
(220, 11, 2, 'Math311', 'Statistics and Probability', 0, 0, 0, 'Math111', 660, 'ABM'),
(221, 11, 2, 'Humanities311', 'Introduction to the Philosophy of the Human Person', 0, 0, 0, '', 660, 'ABM'),
(222, 11, 2, 'PE211', 'Physical Education and Health', 0, 0, 0, 'PE111', 660, 'ABM'),
(223, 11, 2, 'Res111', 'Practical Research 1', 0, 0, 0, '', 660, 'ABM'),
(224, 11, 2, 'Entrep111', 'Principles of Marketing', 0, 0, 0, '', 660, 'ABM'),
(225, 11, 2, 'Acctg211', 'Fundamentals of Accountancy, Business and Manageme', 0, 0, 0, 'Acctg111', 660, 'ABM'),
(226, 12, 1, 'Humanities312', 'Contemporary Philippine Arts from the Regions', 0, 0, 0, '', 580, 'ABM'),
(227, 12, 1, 'Science211', 'Earth and Life Science', 0, 0, 0, '', 580, 'ABM'),
(228, 12, 1, 'PE311', 'Physical Education and Health', 0, 0, 0, 'PE211', 580, 'ABM'),
(229, 12, 1, 'PracticalRes211', 'Practical Research 2', 0, 0, 0, '', 580, 'ABM'),
(230, 12, 1, 'Entrep112', 'Entrepreneurship', 0, 0, 0, '', 580, 'ABM'),
(231, 12, 1, 'Hum411', 'Personal Development', 0, 0, 0, '', 580, 'ABM'),
(232, 12, 1, 'Math312', 'Business Math', 0, 0, 0, 'Math311', 580, 'ABM'),
(233, 12, 1, 'Mgmt111', 'Organization and Management', 0, 0, 0, 'Entrep111', 580, 'ABM'),
(234, 12, 2, 'Lit111', '21st Century Literature from the Philippines and t', 0, 0, 0, '', 580, 'ABM'),
(235, 12, 2, 'Comp112', 'Media and Information Literacy', 0, 0, 0, '', 580, 'ABM'),
(236, 12, 2, 'Science212', 'Physical Science', 0, 0, 0, 'Science211', 580, 'ABM'),
(237, 12, 2, 'PE411', 'Physical Education and Health', 0, 0, 0, 'PE311', 580, 'ABM'),
(238, 12, 2, 'Ethics112', 'Business Ethics and Social Responsibility', 0, 0, 0, '', 580, 'ABM'),
(239, 12, 2, 'ABM-Cul112', 'Research Project/Culminating Activity', 0, 0, 0, 'Acctg211, Mgmt111', 580, 'ABM'),
(240, 12, 2, 'Finance112', 'Business Finance', 0, 0, 0, 'Acctg211, Mgmt111', 580, 'ABM'),
(241, 12, 2, 'ABM-App112', 'Work Immersion/Research/Career Advocacy/Culminatin', 0, 0, 0, 'Acctg211, Mgmt111', 580, 'ABM'),
(242, 11, 1, 'Eng111', 'Oral Communication in Context', 0, 0, 0, '', 660, 'GAS'),
(243, 11, 1, 'Fil111', 'Komunikasyon at Pananaliksik sa Wika at Kulturang ', 0, 0, 0, '', 660, 'GAS'),
(244, 11, 1, 'Math111', 'General Mathematics', 0, 0, 0, '', 660, 'GAS'),
(245, 11, 1, 'PolSci111', 'Understanding Culture, Society and Politics', 0, 0, 0, '', 660, 'GAS'),
(246, 11, 1, 'PE111', 'Physical Education and Health', 0, 0, 0, '', 660, 'GAS'),
(247, 11, 1, 'Eng211', 'English for Academic and Professional Purposes', 0, 0, 0, '', 660, 'GAS'),
(248, 11, 1, 'Fil211', 'Pagbasa at Filipino sa Piling Larangan (Akademik)', 0, 0, 0, '', 660, 'GAS'),
(249, 11, 1, 'PolSci211', 'Philippine Politics and Governance', 0, 0, 0, '', 660, 'GAS'),
(250, 11, 1, 'Elective1', 'Creative Writing/Malikhaing Pagsulat', 0, 0, 0, '', 660, 'GAS'),
(251, 11, 2, 'Eng311', 'Reading and Writing Skill', 0, 0, 0, 'Eng211', 660, 'GAS'),
(252, 11, 2, 'Fil311', 'Pagbasa at Pagsusuri sa Iba’t-ibang Teksto Tungo s', 0, 0, 0, 'Fil211', 660, 'GAS'),
(253, 11, 2, 'Math311', 'Statistics and Probability', 0, 0, 0, 'Math111', 660, 'GAS'),
(254, 11, 2, 'Humanities111', 'Introduction to the Philosophy of the Human Person', 0, 0, 0, '', 660, 'GAS'),
(255, 11, 2, 'PE211', 'Physical Education and Health', 0, 0, 0, 'PE111', 660, 'GAS'),
(256, 11, 2, 'ETech111', 'Empowerment Technologies (E-Tech): ICT for Profess', 0, 0, 0, '', 660, 'GAS'),
(257, 11, 2, 'Humanities211', 'Introduction to World Religions and Belief Systems', 0, 0, 0, '', 660, 'GAS'),
(258, 11, 2, 'Elective2', 'Creative Non-Fiction: Literary Essay', 0, 0, 0, 'Elective1', 660, 'GAS'),
(259, 12, 1, 'Humanities312', 'Contemporary Philippine Arts from the Regions', 0, 0, 0, '', 580, 'GAS'),
(260, 12, 1, 'Science211', 'Earth and Life Science', 0, 0, 0, '', 580, 'GAS'),
(261, 12, 1, 'PE311', 'Physical Education and Health', 0, 0, 0, 'PE211', 580, 'GAS'),
(262, 12, 1, 'Humanities412', 'Personal Development/Pansariling Kaunlaran', 0, 0, 0, 'Math311, PracticalRes211', 580, 'GAS'),
(263, 12, 1, 'Res212', 'Practical Research 2', 0, 0, 0, '', 580, 'GAS'),
(264, 12, 1, 'Entrep112', 'Entrepreneurship', 0, 0, 0, '', 580, 'GAS'),
(265, 12, 1, 'Econ112', 'Applied Economics', 0, 0, 0, '', 580, 'GAS'),
(266, 12, 1, 'Mgmt111', 'Organization and Management', 0, 0, 0, '', 580, 'GAS'),
(267, 12, 2, 'Lit112', '21st Century Literature from the Philippines and t', 0, 0, 0, 'ETech111', 580, 'GAS'),
(268, 12, 2, 'Comp112', 'Media and Information Literacy', 0, 0, 0, '', 580, 'GAS'),
(269, 12, 2, 'Science212', 'Physical Science', 0, 0, 0, 'Science211', 580, 'GAS'),
(270, 12, 2, 'PE411', 'Physical Education and Health', 0, 0, 0, 'PE311', 580, 'GAS'),
(271, 12, 2, 'Ethics112', 'Business Ethics and Social Responsibility', 0, 0, 0, '', 580, 'GAS'),
(272, 12, 2, 'GAS-Cul112', 'Research Project/Culminating Activity', 0, 0, 0, 'Mgmt111, Entrep112', 580, 'GAS'),
(273, 12, 2, 'GAS-App112', 'Work Immersion/Research/Career Advocacy/Culminatin', 0, 0, 0, 'Mgmt111, Entrep112', 580, 'GAS'),
(274, 12, 2, 'Science312', 'Discipline and Ideas in the Applied Social Science', 0, 0, 0, '', 580, 'GAS'),
(275, 12, 2, 'DRR112', 'Disaster Readiness and Risk Reduction', 0, 0, 0, '', 580, 'GAS'),
(276, 11, 1, 'Eng111', 'Oral Communication in Context', 0, 0, 0, '', 660, 'ICT'),
(277, 11, 1, 'Fil111', 'Komunikasyon at Pananaliksik sa Wika at Kulturang ', 0, 0, 0, '', 660, 'ICT'),
(278, 11, 1, 'Math111', 'General Mathematics', 0, 0, 0, '', 660, 'ICT'),
(279, 11, 1, 'PolSci111', 'Understanding Culture, Society and Politics', 0, 0, 0, '', 660, 'ICT'),
(280, 11, 1, 'PE111', 'Physical Education and Health', 0, 0, 0, '', 660, 'ICT'),
(281, 11, 1, 'Eng211', 'English for Academic and Professional Purposes', 0, 0, 0, '', 660, 'ICT'),
(282, 11, 1, 'Fil211', 'Paglutas sa Filipino sa Piling Larangan (Tech-Voc)', 0, 0, 0, '', 660, 'ICT'),
(283, 11, 1, 'CS111', 'Computer System Servicing', 0, 0, 0, '', 660, 'ICT'),
(284, 11, 1, 'COMP111', 'Computer Programming I', 0, 0, 0, '', 660, 'ICT'),
(285, 11, 2, 'Eng311', 'Reading and Writing Skill', 0, 0, 0, 'Eng211', 580, 'ICT'),
(286, 11, 2, 'Fil311', 'Pagbasa at Pagsusuri sa Iba’t-ibang Teksto Tungo s', 0, 0, 0, 'Fil211', 580, 'ICT'),
(287, 11, 2, 'Math311', 'Statistics and Probability', 0, 0, 0, 'Math111', 580, 'ICT'),
(288, 11, 2, 'Humanities111', 'Introduction to the Philosophy of the Human Person', 0, 0, 0, '', 580, 'ICT'),
(289, 11, 2, 'PE211', 'Physical Education and Health', 0, 0, 0, 'PE111', 580, 'ICT'),
(290, 11, 2, 'Res111', 'Practical Research 1', 0, 0, 0, '', 580, 'ICT'),
(291, 11, 2, 'ETech111', 'Empowerment Technologies (E-Tech): ICT for Profess', 0, 0, 0, '', 580, 'ICT'),
(292, 11, 2, 'CS211', 'Computer System Servicing', 0, 0, 0, 'CS111', 580, 'ICT'),
(293, 11, 2, 'COMP211', 'Computer Programming II', 0, 0, 0, 'COMP111', 580, 'ICT'),
(294, 12, 1, 'Humanities312', 'Contemporary Philippine Arts from the Regions', 0, 0, 0, '', 580, 'ICT'),
(295, 12, 1, 'Science112', 'Earth and Life Science', 0, 0, 0, '', 580, 'ICT'),
(296, 12, 1, 'PE311', 'Physical Education and Health', 0, 0, 0, 'PE211', 580, 'ICT'),
(297, 12, 1, 'Humanities412', 'Personal Development/Pansariling Kaunlaran', 0, 0, 0, 'Res111', 580, 'ICT'),
(298, 12, 1, 'Res212', 'Practical Research 2', 0, 0, 0, '', 580, 'ICT'),
(299, 12, 1, 'Entrep112', 'Entrepreneurship', 0, 0, 0, '', 580, 'ICT'),
(300, 12, 1, 'CS311', 'Computer System Servicing', 0, 0, 0, 'CS211', 580, 'ICT'),
(301, 12, 1, 'COMP311', 'Computer Programming III', 0, 0, 0, 'COMP211', 580, 'ICT'),
(302, 12, 2, 'Lit112', '21st Century Literature from the Philippines and t', 0, 0, 0, 'ETech111', 500, 'ICT'),
(303, 12, 2, 'Comp112', 'Media and Information Literacy', 0, 0, 0, '', 500, 'ICT'),
(304, 12, 2, 'Science212', 'Physical Science', 0, 0, 0, 'Science112', 500, 'ICT'),
(305, 12, 2, 'PE411', 'Physical Education and Health', 0, 0, 0, 'PE311', 500, 'ICT'),
(306, 12, 2, 'CS412', 'Computer System Servicing', 0, 0, 0, 'CS111, CS211 & CS311', 500, 'ICT'),
(307, 12, 2, 'COMP412', 'Computer Programming IV', 0, 0, 0, 'COMP111, COMP211 & COMP311', 500, 'ICT'),
(308, 12, 2, 'TVLApp112', 'Work Immersion/Research/Career Advocacy/Culminatin', 0, 0, 0, '', 500, 'ICT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(50) NOT NULL,
  `user_lname` varchar(50) NOT NULL,
  `user_email` varchar(80) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_name`, `user_pass`, `user_role`, `user_image`, `date_of_birth`, `gender`, `hire_date`, `department`, `phone_number`, `address`) VALUES
(37, 'Jessa mae', 'Carzano', 'jessamae@gmail.com', 'Carzano@123', '$2y$10$EvkWpYHY.6O4XjTMI1yXVu4rpw38pW2PUuHpn0V16e2O23oa.BBSq', 'admin', '../admin/upload/upload-files/maam_jessa.png', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Michael John ', 'Bustamante', 'ser.mike@gmail.com', 'Mike@123', '$2y$10$XdcJkft/sR67N8HuIrOJe.fu6Ug1fRRNEl2QLRZvlA4RMCw4wvyzO', 'teacher', '../admin/upload/upload-files/sir_mike.jpg', '1989-01-01', 'Male', '2020-02-10', 'IT', '09999999999', 'Tungkop, Minglanilla'),
(44, 'Rene', 'Ababan', 'reneababan@gmail.com', 'Rene', '$2y$10$USEc/QKrs4jHC2XnX9CgkuHFW4upq/T3ZEunGThz3sERqFCkLYlvi', 'teacher', '', '2002-01-02', 'Male', '2020-01-01', 'IT', '09999999999', 'Inayagan, City of Naga'),
(45, 'Junrih', 'Rizada', 'rizada@gmail.com', 'Rizada', '$2y$10$3iHKFrQhszX8Z3EO9F69ZuaJLkL3VBh3zGry1m.RvnlnRuk2V5bRW', 'teacher', '', '2002-01-20', 'Male', '2018-02-09', 'IT', '09999999999', 'Inayagan, City of Naga'),
(46, 'Louie', 'Tahanlangit', 'louiethnlngt@gmail.com', 'Tahanlangit', '$2y$10$6Y1h.UjpVbMT4UJNHEQ0FOIEsVd7ymojVWXNCOMvWl5YXrfR7tSe6', 'teacher', '', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Teacher', 'Teacher', 'Teacher101@gmail.com', 'Teacher', '$2y$10$rATOBudbbItBA1PesQ7Ix.nyaD7WMQEhCE9TiQXi3/yBNzHb32g4a', 'teacher', '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_days`
--
ALTER TABLE `tbl_days`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `grade_id` (`id`),
  ADD KEY `tbl_grades_ibfk_1` (`user_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment` (`user_id`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `time_id` (`time_id`),
  ADD KEY `tbl_days` (`day_id`);

--
-- Indexes for table `tbl_sched_time`
--
ALTER TABLE `tbl_sched_time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_student_instructors`
--
ALTER TABLE `tbl_student_instructors`
  ADD PRIMARY KEY (`student_id`,`instructor_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_days`
--
ALTER TABLE `tbl_days`
  MODIFY `day_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_grades`
--
ALTER TABLE `tbl_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `payment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `tbl_sched_time`
--
ALTER TABLE `tbl_sched_time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD CONSTRAINT `grade_id` FOREIGN KEY (`id`) REFERENCES `tbl_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_grades_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_students` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `payment` FOREIGN KEY (`user_id`) REFERENCES `tbl_students` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD CONSTRAINT `tbl_days` FOREIGN KEY (`day_id`) REFERENCES `tbl_days` (`day_id`),
  ADD CONSTRAINT `tbl_schedule_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `tbl_users` (`user_id`),
  ADD CONSTRAINT `tbl_schedule_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`course_id`),
  ADD CONSTRAINT `tbl_schedule_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `tbl_subjects` (`id`),
  ADD CONSTRAINT `tbl_schedule_ibfk_4` FOREIGN KEY (`room_id`) REFERENCES `tbl_rooms` (`room_id`),
  ADD CONSTRAINT `tbl_schedule_ibfk_5` FOREIGN KEY (`time_id`) REFERENCES `tbl_sched_time` (`time_id`);

--
-- Constraints for table `tbl_student_instructors`
--
ALTER TABLE `tbl_student_instructors`
  ADD CONSTRAINT `tbl_student_instructors_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`user_id`),
  ADD CONSTRAINT `tbl_student_instructors_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
