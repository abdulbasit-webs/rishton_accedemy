-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 02:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rishton`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(50) NOT NULL,
  `Capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassID`, `ClassName`, `Capacity`) VALUES
(1, 'Reception Year', 29),
(5, 'Year One', 29);

-- --------------------------------------------------------

--
-- Table structure for table `dinnermoney`
--

CREATE TABLE `dinnermoney` (
  `DinnerID` int(11) NOT NULL,
  `PupilID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dinnermoney`
--

INSERT INTO `dinnermoney` (`DinnerID`, `PupilID`, `Amount`, `PaymentDate`) VALUES
(2, 1, 700.00, '2024-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `librarybooks`
--

CREATE TABLE `librarybooks` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `IssuedToPupilID` int(11) DEFAULT NULL,
  `PublicationYear` int(4) DEFAULT NULL,
  `ISBN` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarybooks`
--

INSERT INTO `librarybooks` (`BookID`, `Title`, `Author`, `IssuedToPupilID`, `PublicationYear`, `ISBN`) VALUES
(2, 'Maths', 'John deep', NULL, 2024, '1234');

-- --------------------------------------------------------

--
-- Table structure for table `parents_guardians`
--

CREATE TABLE `parents_guardians` (
  `ParentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents_guardians`
--

INSERT INTO `parents_guardians` (`ParentID`, `Name`, `Address`, `Email`, `PhoneNumber`) VALUES
(3, 'mike', '78888', NULL, '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

CREATE TABLE `pupils` (
  `PupilID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `MedicalInfo` varchar(255) DEFAULT NULL,
  `ClassID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`PupilID`, `Name`, `Address`, `MedicalInfo`, `ClassID`) VALUES
(1, 'Kilin', '9988776', 'Fit', 1),
(2, 'mike', '9988776', 'fit', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pupils_parents`
--

CREATE TABLE `pupils_parents` (
  `PupilID` int(11) NOT NULL,
  `ParentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils_parents`
--

INSERT INTO `pupils_parents` (`PupilID`, `ParentID`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `SalaryID` int(11) NOT NULL,
  `StaffType` varchar(20) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`SalaryID`, `StaffType`, `StaffID`, `Amount`, `PaymentDate`) VALUES
(2, 'Teacher', 5, 1000.00, '2024-08-28'),
(3, 'TeachingAssistant', 3, 900.00, '2024-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `TeacherID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `BackgroundCheck` varchar(50) DEFAULT NULL,
  `ClassID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`TeacherID`, `Name`, `Address`, `PhoneNumber`, `BackgroundCheck`, `ClassID`) VALUES
(5, 'Johm deep', '555566677', '1234567', 'Clear', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachingassistants`
--

CREATE TABLE `teachingassistants` (
  `AssistantID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `BackgroundCheck` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachingassistants`
--

INSERT INTO `teachingassistants` (`AssistantID`, `Name`, `Address`, `PhoneNumber`, `BackgroundCheck`) VALUES
(3, 'Jory', '55557666', '123456', 'ok');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`ClassID`);

--
-- Indexes for table `dinnermoney`
--
ALTER TABLE `dinnermoney`
  ADD PRIMARY KEY (`DinnerID`),
  ADD KEY `PupilID` (`PupilID`);

--
-- Indexes for table `librarybooks`
--
ALTER TABLE `librarybooks`
  ADD PRIMARY KEY (`BookID`),
  ADD KEY `IssuedToPupilID` (`IssuedToPupilID`);

--
-- Indexes for table `parents_guardians`
--
ALTER TABLE `parents_guardians`
  ADD PRIMARY KEY (`ParentID`);

--
-- Indexes for table `pupils`
--
ALTER TABLE `pupils`
  ADD PRIMARY KEY (`PupilID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD PRIMARY KEY (`PupilID`,`ParentID`),
  ADD KEY `ParentID` (`ParentID`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`SalaryID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`TeacherID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `teachingassistants`
--
ALTER TABLE `teachingassistants`
  ADD PRIMARY KEY (`AssistantID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dinnermoney`
--
ALTER TABLE `dinnermoney`
  MODIFY `DinnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `librarybooks`
--
ALTER TABLE `librarybooks`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parents_guardians`
--
ALTER TABLE `parents_guardians`
  MODIFY `ParentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pupils`
--
ALTER TABLE `pupils`
  MODIFY `PupilID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `SalaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teachingassistants`
--
ALTER TABLE `teachingassistants`
  MODIFY `AssistantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dinnermoney`
--
ALTER TABLE `dinnermoney`
  ADD CONSTRAINT `dinnermoney_ibfk_1` FOREIGN KEY (`PupilID`) REFERENCES `pupils` (`PupilID`);

--
-- Constraints for table `librarybooks`
--
ALTER TABLE `librarybooks`
  ADD CONSTRAINT `librarybooks_ibfk_1` FOREIGN KEY (`IssuedToPupilID`) REFERENCES `pupils` (`PupilID`);

--
-- Constraints for table `pupils`
--
ALTER TABLE `pupils`
  ADD CONSTRAINT `pupils_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`);

--
-- Constraints for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD CONSTRAINT `pupils_parents_ibfk_1` FOREIGN KEY (`PupilID`) REFERENCES `pupils` (`PupilID`),
  ADD CONSTRAINT `pupils_parents_ibfk_2` FOREIGN KEY (`ParentID`) REFERENCES `parents_guardians` (`ParentID`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
