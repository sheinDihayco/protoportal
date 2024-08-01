-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 07:00 AM
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
(19, 1, 2, 'EN2', 'Technical Writing ', 3, 0, 3, 'None', 3, 'BSIT');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
