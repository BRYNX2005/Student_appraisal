-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2024 at 01:52 PM
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
-- Database: `wdproj`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `Enrollment_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Subject_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Faculty_ID` int(11) NOT NULL,
  `Faculty_Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_Number` varchar(15) DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Employment_Status` enum('Full-Time','Part-Time','Contractual') DEFAULT 'Full-Time',
  `Specialization` varchar(100) DEFAULT NULL,
  `Role` enum('Faculty','Admin','Dean') DEFAULT 'Faculty'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `Grade_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Subject_ID` int(11) NOT NULL,
  `Grade` decimal(4,2) NOT NULL CHECK (`Grade` between 0 and 100),
  `Status` enum('Failed','Passed') GENERATED ALWAYS AS (case when `Grade` >= 50 then 'Passed' else 'Failed' end) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Schedule_ID` int(11) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Subject_ID` int(11) DEFAULT NULL,
  `Day` varchar(20) NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL,
  `Room` varchar(50) DEFAULT NULL,
  `School_Year` varchar(20) DEFAULT NULL,
  `Semester` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Student_ID` int(11) NOT NULL,
  `Full_name` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `School_year` varchar(10) NOT NULL,
  `Course` varchar(100) NOT NULL,
  `Status` enum('Enrolled','Graduated','Dropped') NOT NULL DEFAULT 'Enrolled',
  `major` varchar(50) DEFAULT NULL,
  `college` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Student_ID`, `Full_name`, `Age`, `Gender`, `School_year`, `Course`, `Status`, `major`, `college`) VALUES
(202301243, 'HANS ADRIAN A. LAO ', 19, 'Male', '2024', 'CS', 'Enrolled', NULL, NULL),
(202319682, 'BEDUYA, JUSTIN RAE S.', 20, 'Male', '2024', 'CS', 'Enrolled', 'Game Development', 'CCS'),
(202319683, 'GAPOL, LONIEL MARLO', 19, 'Male', '2024', 'CS', 'Enrolled', 'Data Science', 'CCS'),
(202319684, 'GEMINA, JENICA JOY', 20, 'Female', '2024', 'CS', 'Enrolled', 'Software Engineering', 'CCS'),
(202319685, 'JAVAR, KHOFERSHINE L.', 20, 'Female', '2024', 'CS', 'Enrolled', 'Cybersecurity', 'CCS'),
(202319686, 'SEÑALDE, KURT PHILIP P.', 20, 'Male', '2024', 'CS', 'Enrolled', 'Game Development', 'CCS'),
(202319687, 'ETAC, EROS DENZ L.', 20, 'Male', '2024', 'CS', 'Enrolled', 'Game Development', 'CCS'),
(202319688, 'QUE, JOEL JOSH', 20, 'Male', '2024', 'CS', 'Enrolled', 'Cybersecurity', 'CCS');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Full_name` varchar(100) NOT NULL,
  `Section` varchar(50) NOT NULL,
  `School_year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_sections`
--

CREATE TABLE `student_sections` (
  `ID` int(11) NOT NULL,
  `Section_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `Subject_ID` int(11) NOT NULL,
  `Subject_name` varchar(100) NOT NULL,
  `Subject_code` varchar(50) NOT NULL,
  `Schedule` varchar(100) DEFAULT NULL,
  `Units` int(11) NOT NULL,
  `Room` varchar(50) DEFAULT NULL,
  `Faculty_ID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`Subject_ID`, `Subject_name`, `Subject_code`, `Schedule`, `Units`, `Room`, `Faculty_ID`) VALUES
(32, 'DATA STRUCTURES AND ALGORITHM', 'CC103', 'TF 2:30-4:00', 2, 'LR 1', 'SHERARD CHRIS BANQUERIGO'),
(33, 'DATA STRUCTURES AND ALGORITHM', 'CC103L', 'F 7:00-9:00', 1, 'LAB 1', 'GADMAR M. BELAMIDE'),
(34, 'INFORMATION MANAGEMENT', 'CC104', 'W 7:00-10:00', 2, 'LR 3', 'LUCY FELIX'),
(35, 'INFORMATION MANAGEMENT', 'CC104L', 'W 5:00-7:00', 1, 'LAB 1', 'LUCY FELIX'),
(36, 'MOBILE APPLICATION DEVELOPMENT', 'MAD121', 'M 3:00-5:00', 2, 'LAB 1', 'JOHN LLOYD EDIOS'),
(37, 'MOBILE APPLICATION DEVELOPMENTL', 'MAD121L', 'F 4:00-7:00', 1, 'LAB 1', 'JOHN LLOYD EDIOS'),
(38, 'NETWORKS AND COMMUNICATION', 'NC127', 'T 9:00-11:00', 2, 'LR 5', 'EDWIN ARIP'),
(39, 'NETWORKS AND COMMUNICATIONL', 'NC127L', 'W 1:00-4:00', 2, 'LAB 2', 'EDWIN ARIP'),
(40, 'WEB DEVELOPMENT 2', 'WD123', 'Th 3:00-5:00', 1, 'LAB 1', 'RHAMIRL JAAFAR'),
(41, 'WEB DEVELOPMENT 2', 'WD123L', 'M 7:00-10:00', 2, 'LR 1', 'RHAMIRL JAAFAR');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Username` varchar(50) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Is_professor` tinyint(1) DEFAULT 0,
  `Is_dean` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Username`, `Student_ID`, `Password`, `Is_professor`, `Is_dean`) VALUES
('admin', NULL, 'admin', 1, 1),
('beduya', 202319682, 'beduyajustinrae2005', 0, 0),
('brynx', 202319683, '$2y$10$SvvgV8Y4edBPlrIN316uDO8U9Mgk38cBP8T3GN73haFwUdUVaiCma', 0, 0),
('coder1', 202301243, '$2y$10$ctOTwXwRDakgneOaWQJK4eBcuNhtBgj946rv8jaMQkuvp8/GvC1eu', 0, 0),
('fatima', NULL, 'abubakarfatimasheenashareefa', 0, 0),
('javar', 202319685, 'javarkhofer@kurt', 0, 0),
('jehana', NULL, 'kairanjeh10', 0, 0),
('jenica', 202319684, 'jengemina@2005', 0, 0),
('josh', 202319688, 'joeljosh@kids', 0, 0),
('kurt', 202319686, 'hotlatinascom', 0, 0),
('Loniel', 202319683, 'Lonielgapol08202005@', 0, 0),
('prof1', NULL, 'prof', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`Enrollment_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Faculty_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`Grade_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `Faculty_ID` (`Faculty_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Student_ID`),
  ADD UNIQUE KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `student_sections`
--
ALTER TABLE `student_sections`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`Subject_ID`),
  ADD UNIQUE KEY `Subject_code` (`Subject_code`),
  ADD UNIQUE KEY `Schedule` (`Schedule`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Username`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `Enrollment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `Faculty_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `Grade_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `Schedule_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_sections`
--
ALTER TABLE `student_sections`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `Subject_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`Subject_ID`) REFERENCES `subjects` (`Subject_ID`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`Subject_ID`) REFERENCES `subjects` (`Subject_ID`) ON DELETE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`Subject_ID`) REFERENCES `subjects` (`Subject_ID`);

--
-- Constraints for table `student_list`
--
ALTER TABLE `student_list`
  ADD CONSTRAINT `student_list_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`) ON DELETE CASCADE;

--
-- Constraints for table `student_sections`
--
ALTER TABLE `student_sections`
  ADD CONSTRAINT `student_sections_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
