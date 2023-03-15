-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2023 at 11:08 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group3database`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `ClientName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `ClientName`) VALUES
(1, 'Waterman Group');

-- --------------------------------------------------------

--
-- Table structure for table `complianceauditor`
--

CREATE TABLE `complianceauditor` (
  `AuditID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `NumberOfAuditFindings` int(11) NOT NULL,
  `NumberOfGreenComplience` int(11) NOT NULL,
  `NumberOfAmberNonComplience` int(11) NOT NULL,
  `NumberOfRedNonComplience` int(11) NOT NULL,
  `NumberOfAudits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complianceauditor`
--

INSERT INTO `complianceauditor` (`AuditID`, `ClientID`, `Year`, `NumberOfAuditFindings`, `NumberOfGreenComplience`, `NumberOfAmberNonComplience`, `NumberOfRedNonComplience`, `NumberOfAudits`) VALUES
(1, 1, 2020, 27, 23, 3, 1, 12),
(2, 1, 2021, 33, 26, 3, 4, 14),
(5, 1, 2022, 28, 23, 2, 3, 18);

-- --------------------------------------------------------

--
-- Table structure for table `improvementtraker`
--

CREATE TABLE `improvementtraker` (
  `TrackerID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `NumberOfActions` int(11) NOT NULL,
  `NumberOfActionsOpen` int(11) NOT NULL,
  `NumberOfDueActions` int(11) NOT NULL,
  `NumberOfOutstanding` int(11) NOT NULL,
  `NumberReqireingV&V` int(11) NOT NULL,
  `NumberOfActionsClosedBeforeDueDate` int(11) NOT NULL,
  `NumberOfActionsClosedAfterDueDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `improvementtraker`
--

INSERT INTO `improvementtraker` (`TrackerID`, `ClientID`, `Year`, `NumberOfActions`, `NumberOfActionsOpen`, `NumberOfDueActions`, `NumberOfOutstanding`, `NumberReqireingV&V`, `NumberOfActionsClosedBeforeDueDate`, `NumberOfActionsClosedAfterDueDate`) VALUES
(1, 1, 2020, 22, 0, 0, 0, 0, 18, 4),
(2, 1, 2021, 26, 3, 3, 3, 5, 15, 3),
(3, 1, 2022, 32, 7, 3, 4, 2, 18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `legalregister`
--

CREATE TABLE `legalregister` (
  `RegisterID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `NumberOfRedNonComplience` int(11) NOT NULL,
  `NumberOfAmberNonComplience` int(11) NOT NULL,
  `NumberOfGreenComplience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legalregister`
--

INSERT INTO `legalregister` (`RegisterID`, `ClientID`, `NumberOfRedNonComplience`, `NumberOfAmberNonComplience`, `NumberOfGreenComplience`) VALUES
(1, 1, 3, 8, 14);

-- --------------------------------------------------------

--
-- Table structure for table `riskregisters`
--

CREATE TABLE `riskregisters` (
  `RiskID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `NumberOf60PlusAspects` int(11) NOT NULL,
  `NumberOf12PlusHazards` int(11) NOT NULL,
  `NumberOfClimateRisks` int(11) NOT NULL,
  `NumberOfClimateOpportunities` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riskregisters`
--

INSERT INTO `riskregisters` (`RiskID`, `ClientID`, `NumberOf60PlusAspects`, `NumberOf12PlusHazards`, `NumberOfClimateRisks`, `NumberOfClimateOpportunities`) VALUES
(1, 1, 13, 8, 29, 34);

-- --------------------------------------------------------

--
-- Table structure for table `useractions`
--

CREATE TABLE `useractions` (
  `UserActionID` int(11) NOT NULL,
  `TrackerID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `NumberOfActions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useractions`
--

INSERT INTO `useractions` (`UserActionID`, `TrackerID`, `UserID`, `NumberOfActions`) VALUES
(5, 1, 1, 4),
(6, 1, 2, 3),
(7, 2, 1, 8),
(8, 2, 2, 2),
(9, 3, 1, 7),
(10, 3, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `Emails` text NOT NULL,
  `Permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `ClientID`, `FirstName`, `LastName`, `Username`, `Password`, `Emails`, `Permission`) VALUES
(1, 1, 'John', 'Smith', 'JohnSmith123', 'password123', 'JohnSmith@gmail.com', 'Admin'),
(2, 1, 'Jack', 'Woods', 'JackWoods123', '12345Password', 'Jackwoods@gmail.com', 'Basic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `complianceauditor`
--
ALTER TABLE `complianceauditor`
  ADD PRIMARY KEY (`AuditID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `improvementtraker`
--
ALTER TABLE `improvementtraker`
  ADD PRIMARY KEY (`TrackerID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `legalregister`
--
ALTER TABLE `legalregister`
  ADD PRIMARY KEY (`RegisterID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `riskregisters`
--
ALTER TABLE `riskregisters`
  ADD PRIMARY KEY (`RiskID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `useractions`
--
ALTER TABLE `useractions`
  ADD PRIMARY KEY (`UserActionID`),
  ADD KEY `TrackerID` (`TrackerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`,`Emails`) USING HASH,
  ADD KEY `ClientID` (`ClientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complianceauditor`
--
ALTER TABLE `complianceauditor`
  MODIFY `AuditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `improvementtraker`
--
ALTER TABLE `improvementtraker`
  MODIFY `TrackerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `legalregister`
--
ALTER TABLE `legalregister`
  MODIFY `RegisterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riskregisters`
--
ALTER TABLE `riskregisters`
  MODIFY `RiskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `useractions`
--
ALTER TABLE `useractions`
  MODIFY `UserActionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complianceauditor`
--
ALTER TABLE `complianceauditor`
  ADD CONSTRAINT `complianceauditor_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `improvementtraker`
--
ALTER TABLE `improvementtraker`
  ADD CONSTRAINT `improvementtraker_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `legalregister`
--
ALTER TABLE `legalregister`
  ADD CONSTRAINT `legalregister_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `riskregisters`
--
ALTER TABLE `riskregisters`
  ADD CONSTRAINT `riskregisters_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `useractions`
--
ALTER TABLE `useractions`
  ADD CONSTRAINT `useractions_ibfk_1` FOREIGN KEY (`TrackerID`) REFERENCES `improvementtraker` (`TrackerID`),
  ADD CONSTRAINT `useractions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
