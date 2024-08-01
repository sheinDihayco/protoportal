-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 11:04 AM
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
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `att_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `absent` float NOT NULL,
  `late` float NOT NULL,
  `overtime` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`att_id`, `transaction_id`, `absent`, `late`, `overtime`) VALUES
(12, 12, 2, 22, 0),
(13, 13, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_borrows`
--

CREATE TABLE `tbl_borrows` (
  `borrow_id` int(20) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_compensation`
--

CREATE TABLE `tbl_compensation` (
  `comp_id` int(20) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `basic_pay` float NOT NULL,
  `sss` float NOT NULL,
  `pagibig` double NOT NULL,
  `philhealth` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_compensation`
--

INSERT INTO `tbl_compensation` (`comp_id`, `employee_id`, `basic_pay`, `sss`, `pagibig`, `philhealth`) VALUES
(10128, 12404, 16000, 200, 200, 200),
(10129, 12405, 20000, 500, 500, 130);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employee_id` int(20) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`employee_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `hire_date`, `job_title`, `department`, `phone_number`, `address`) VALUES
(12404, 'Michael John', 'Bustamante', '1997-12-17', 'Male', '2024-01-24', 'Instructor', 'IT', '094582311', 'Linao-Lipata, Minglanilla, Cebu'),
(12405, 'Jessamae', 'Carzano', '2000-01-01', 'Female', '0004-01-01', 'Accounting', 'Accounting Dept.', '099999999999', 'Inayagan, City of Naga');

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
(24, 'My Birthday', '2025-02-09', 'Another year, another blessing');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_image`
--

CREATE TABLE `tbl_image` (
  `id` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `front_image_path` varchar(50) NOT NULL,
  `back_image_path` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `front_image_hash` varchar(50) NOT NULL,
  `back_image_hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_image`
--

INSERT INTO `tbl_image` (`id`, `uploaded_at`, `front_image_path`, `back_image_path`, `course`, `front_image_hash`, `back_image_hash`) VALUES
(9, '2024-07-29 13:27:17', './uploaded_files/66a798b50608d_front.jpg', './uploaded_files/66a798b506096_back.jpg', 'BSBA', 'c7e68ce7ed0664909c9c686a9abe3bea', '6831224601e6124b99984bbf1c4a856a'),
(11, '2024-07-29 14:22:07', './uploaded_files/66a7a58f39d97_bsoa_front.jpg', './uploaded_files/66a7a58f39d9d_bsoa_back.jpg', 'BSOA', '696d9030513555aa1f13b1ef926cf3c6', 'c2673773a98a30142e48573ea4a26d44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE `tbl_leave` (
  `lvs_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `leave_start` date NOT NULL,
  `leave_end` date NOT NULL,
  `leave_duration` int(11) NOT NULL,
  `leave_status` varchar(50) NOT NULL,
  `leave_filed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='2';

--
-- Dumping data for table `tbl_leave`
--

INSERT INTO `tbl_leave` (`lvs_id`, `employee_id`, `leave_type`, `leave_start`, `leave_end`, `leave_duration`, `leave_status`, `leave_filed`) VALUES
(4, 12404, 'Vacation Leave', '2024-01-26', '2024-01-29', 4, 'Cancelled', '2024-01-24'),
(5, 12404, 'Sick Leave', '2024-01-24', '2024-01-24', 1, 'Approved', '2024-01-24'),
(6, 12404, 'Sick Leave', '2024-01-20', '2024-01-20', 1, 'Approved', '2024-01-19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `payment_id` int(20) NOT NULL,
  `studentID` int(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `prelim` varchar(20) NOT NULL,
  `midterm` varchar(20) NOT NULL,
  `prefinal` varchar(20) NOT NULL,
  `final` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`payment_id`, `studentID`, `payment_status`, `semester`, `prelim`, `midterm`, `prefinal`, `final`) VALUES
(13, 2021124, 'Paid', '2nd', '', '', '', ''),
(14, 2021137, 'Pending', '2nd', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `studentID` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
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
  `collegeCompleted` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`studentID`, `user_id`, `lname`, `fname`, `middleInitial`, `Suffix`, `course`, `year`, `contact`, `gender`, `bdate`, `pob`, `email`, `major`, `nationality`, `civilStatus`, `religion`, `modality`, `fb`, `curAddress`, `cityAdd`, `zipcode`, `fatherName`, `fwork`, `motherName`, `mwork`, `primarySchool`, `primaryAddress`, `primaryCompleted`, `entermediateSchool`, `entermediateAddress`, `entermediateCompleted`, `hsSchool`, `hsAddress`, `hsCompleted`, `shSchool`, `shAddress`, `shCompleted`, `collegeSchool`, `collegeAddress`, `collegeCompleted`) VALUES
(2021124, 8, 'Algrame', 'Zean Mariuss', 'C.', '-', ' BSIT', 3, '09912988991', 'Male', '2002-11-22', 'N/A', 'zuild@gmail.com', 'Programming', 'Filipino', 'Single', 'Roman Catholic', 'Face to Face', 'Zean Marius C. Algarme', 'Tungkop, Minglanilla', 'Minglanilla, Cebu', '6046', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'MIIT', 'Inayagan, City of Naga, Cebu', 'N/A'),
(2021137, 7, 'Dihayco', 'Sheinalie', 'V.', '-', 'BSIT', 3, '09996707038', 'Female', '2003-02-09', 'Mactan, Lapu-Lapu City , Cebu', 'sheinalie020903@gmail.com', 'Programming', 'Filipino', 'Single', 'Roman Catholic', 'Face to Face', 'Shien Dihayco', 'Purok Sagay, Kalubihan', 'Tuyan, City of Naga, Cebu', '6037', 'Mechille V. DIhayco', 'N/A', 'Divina V. Dihayco', 'Baby Sitter', 'Punta Engano Elementary School', 'Puntan Engano, Lapu-Lapu City', '2012-2013', 'TCES', 'Tuyan, City of Naga', '2014-2015', 'TNHS', 'Tabtuy, Tuyan, City of Naga, Cebu', '2018-2019 ', 'TUYAN SENIOR HIGH SCHOOL', 'Tabtuy, Tuyan, City of Naga, Cebu', '2020-2021', 'MIIT', 'Inayagan, City of Naga, Cebu', '-'),
(2021160, 15, 'Tahanlangit', 'Louie', '-', 'C.', ' BSIT', 3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

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
(8, 1, 1, 'GE 1', 'Understanding the Self ', 3, 0, 3, '1st Year', 3, 'BSIT'),
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
(58, 3, 2, 'NATSCI2', 'College Physics', 3, 0, 3, 'CC103', 5, 'BSIT'),
(59, 3, 2, 'PT206', 'Free Elective(Project Management) ', 2, 1, 3, 'CC103', 5, 'BSIT'),
(60, 3, 0, 'CC313', 'Application Development and Emerging Tech.', 2, 1, 3, 'PF205', 5, 'BSIT-SUMMER'),
(61, 3, 0, 'NATSCI2', 'Physics', 3, 0, 3, 'None', 5, 'BSIT-SUMMER'),
(62, 3, 0, 'CAP314', 'Capstone Project 1', 2, 1, 3, '3rd Year', 5, 'BSIT-SUMMER'),
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
(84, 1, 1, 'GE 1', 'Understanding the self', 3, 0, 3, 'None', 23, 'BSOA'),
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
(124, 1, 1, 'GE 1', 'Understanding the Self', 3, 0, 3, 'None', 26, 'BSBA'),
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
(174, 4, 2, 'Internship', 'Practicum/Work Integrated Learning', 0, 6, 6, 'None', 6, 'BSBA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `transaction_id` int(20) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `period` varchar(10) NOT NULL,
  `days` int(11) NOT NULL,
  `gross_amount` float NOT NULL,
  `absent_amount` float NOT NULL,
  `late_amount` float NOT NULL,
  `sss_amount` float NOT NULL,
  `pagibig_amount` float NOT NULL,
  `phil_amount` float NOT NULL,
  `others_type` varchar(20) NOT NULL,
  `others_amount` float NOT NULL,
  `others_desc` varchar(300) NOT NULL,
  `grosspay` float NOT NULL,
  `netpay` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`transaction_id`, `employee_id`, `period`, `days`, `gross_amount`, `absent_amount`, `late_amount`, `sss_amount`, `pagibig_amount`, `phil_amount`, `others_type`, `others_amount`, `others_desc`, `grosspay`, `netpay`, `date`) VALUES
(12, 12404, '2024-01', 27, 16000, 1185.19, 27.16, 200, 200, 200, 'add', 222, '', 16222, 14409.7, '2024-01-24'),
(13, 12405, '2024-05', 27, 20000, 0, 0, 500, 500, 130, '', 0, '', 20000, 18870, '2024-07-20');

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
  `user_role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_name`, `user_pass`, `user_role`) VALUES
(3, 'Jessamae', 'Carzano', 'jessamae@gmail.com', 'Carzano@123', '$2y$10$aDsR8a1Guds2Vf17YchHduBPMu1XnmX.2EwDFlTZtrwni9mTbkITa', 'admin'),
(7, 'Sheinalie', 'Dihayco', 'dihayco020903@gmail.com', '2021137', '$2y$10$l1subB.o/qk8.DU2mXsMyumneRRNPXaQeMQcfNx7mAZjrATDJKyhC', 'student'),
(8, 'Zean Mariuss', 'Algarme', 'zuild@gmail.com', '2021123', '$2y$10$SmI.RADkHu3sYr9/XPFtt.3MW/w02uVVYPjKyCaZDtqFhzRNfYX2W', 'student'),
(15, 'Louie', 'Tahanlangit', 'louiethnlngt@gmail.com', '2021160', '$2y$10$pS4nG8leTekj3W4bvgBSguG.mL6RQK7qRvzIBzIXG6a1LXn4KU/oi', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`att_id`),
  ADD KEY `attendace` (`transaction_id`);

--
-- Indexes for table `tbl_borrows`
--
ALTER TABLE `tbl_borrows`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `empid` (`employee_id`);

--
-- Indexes for table `tbl_compensation`
--
ALTER TABLE `tbl_compensation`
  ADD UNIQUE KEY `comp_id` (`comp_id`),
  ADD KEY `emp` (`employee_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`lvs_id`),
  ADD KEY `leave` (`employee_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment` (`studentID`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transaction` (`employee_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_borrows`
--
ALTER TABLE `tbl_borrows`
  MODIFY `borrow_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_compensation`
--
ALTER TABLE `tbl_compensation`
  MODIFY `comp_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10130;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `employee_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12406;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_image`
--
ALTER TABLE `tbl_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  MODIFY `lvs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `payment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `transaction_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD CONSTRAINT `attendace` FOREIGN KEY (`transaction_id`) REFERENCES `tbl_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_borrows`
--
ALTER TABLE `tbl_borrows`
  ADD CONSTRAINT `borrow` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_compensation`
--
ALTER TABLE `tbl_compensation`
  ADD CONSTRAINT `compensation` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD CONSTRAINT `leave` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `payment` FOREIGN KEY (`studentID`) REFERENCES `tbl_students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `transaction` FOREIGN KEY (`employee_id`) REFERENCES `tbl_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
