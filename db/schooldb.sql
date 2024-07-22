-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 03:53 PM
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
  `payment_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`payment_id`, `studentID`, `payment_status`) VALUES
(8, 2021123, ''),
(12, 2021137, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `studentID` int(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `middleInitial` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bdate` varchar(50) NOT NULL,
  `pob` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `course` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `major` varchar(50) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `civilStatus` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `modality` varchar(20) NOT NULL,
  `fb` varchar(30) NOT NULL,
  `curAddress` varchar(200) NOT NULL,
  `cityAdd` varchar(200) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `contact` varchar(20) NOT NULL,
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

INSERT INTO `tbl_students` (`studentID`, `fname`, `lname`, `middleInitial`, `gender`, `bdate`, `pob`, `email`, `course`, `year`, `major`, `nationality`, `civilStatus`, `religion`, `modality`, `fb`, `curAddress`, `cityAdd`, `zipcode`, `contact`, `fatherName`, `fwork`, `motherName`, `mwork`, `primarySchool`, `primaryAddress`, `primaryCompleted`, `entermediateSchool`, `entermediateAddress`, `entermediateCompleted`, `hsSchool`, `hsAddress`, `hsCompleted`, `shSchool`, `shAddress`, `shCompleted`, `collegeSchool`, `collegeAddress`, `collegeCompleted`) VALUES
(2021123, 'Zean Mariuss', 'Algrame', 'C.', 'Male', '2002-11-22', 'n/a', 'zuild@gmail.com', ' BSIT', '3', 'Programming', 'Filipino', 'Single', 'Roman Catholic', 'Face to Face', 'Zean Marius C. Algarme', 'n/a', 'n/a', 'n/a', '09912988991', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'MIIT', 'Inayagan, City of Naga, Cebu', '-'),
(2021137, 'Sheinalie', 'Dihayco', 'V.', 'Male', '2003-02-09', 'Mactan, Lapu-Lapu City , Cebu', 'dihayco020903@gmail.com', ' BSIT', '3', 'Programming', 'Filipino', 'Single', 'Roman Catholic', 'Face to Face', 'Shien Dihayco', 'Purok Sagay, Kalubihan', 'Tuyan, City of Naga, Cebu', '6037', '09996707038', 'Mechille V. DIhayco', 'N/A', 'Divina V. Dihayco', 'Baby Sitter', 'PEES', 'Puntan Engano, Lapu-Lapu City', '2012', 'TCES', 'Tuyan, City of Naga', '2015', 'TNHS', 'Tabtuy, Tuyan, City of Naga, Cebu', '2019', 'TNHS- Senior High Dept.', 'Tabtuy, Tuyan, City of Naga, Cebu', '2021', 'MIIT', 'Inayagan, City of Naga, Cebu', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_records`
--

CREATE TABLE `tbl_student_records` (
  `studentID` int(20) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `course` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_records`
--

INSERT INTO `tbl_student_records` (`studentID`, `lname`, `fname`, `course`, `year`, `contact`) VALUES
(2021123, 'Algrame', 'Zean Mariuss', 'BSIT', '3', '0991298899'),
(2021137, 'Dihayco', 'Sheinalie', ' BSIT', '3', '09996707038');

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
  `user_id` int(10) NOT NULL,
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
(5, 'PROTOTYPE', '', 'prototype@gmail.com', 'prototype', '$2y$10$HT19Jg4Me.ZiUwab0kbqLOygR5VE.5/NnFKyka.ejztPrKPaFIfPi', 'admin'),
(6, 'prototype_teacher', '', 'prototypeTeacher@gmail.com', 'TeacherProto111', '$2y$10$NEmiNncRUPLmWdFrxM5RCe/MiHdQEp.fpVqRZNM0u9qzVcbugxy1q', 'teacher'),
(7, 'Dihayco, Sheinalie', '', 'sheinalie020903@gmail.com', 'shein222', '$2y$10$ovTqVlW92kjYGSMRxt/0d./7ZvRsAozFflv0ulQxiVvPIO1KRF0.i', 'admin'),
(8, 'Student Prototype', '', 'studentPrototype@gmail.com', 'student101', '$2y$10$2MfS4c/sAl41p.cFs8WIvuOKqWFQlmA.567MCI4tRNayMV/4YJj7e', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`att_id`);

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
-- Indexes for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`lvs_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `stud_id` (`studentID`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`transaction_id`);

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
-- AUTO_INCREMENT for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  MODIFY `lvs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `payment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `transaction_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `stud_id` FOREIGN KEY (`studentID`) REFERENCES `tbl_students` (`studentID`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `stud` FOREIGN KEY (`studentID`) REFERENCES `tbl_student_records` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
