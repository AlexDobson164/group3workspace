-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2023 at 05:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
-- Table structure for table `archivedgraphs`
--

CREATE TABLE `archivedgraphs` (
  `ArchiveID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `GraphID` int(11) NOT NULL,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archivedgraphs`
--

INSERT INTO `archivedgraphs` (`ArchiveID`, `ClientID`, `GraphID`, `Date`) VALUES
(1, 1, 1, '07/04/2023'),
(2, 1, 2, '13/04/2023');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `ClientID` int(11) NOT NULL,
  `ClientName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ClientID`, `ClientName`) VALUES
(1, 'Waterman Group');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `DataID` int(11) NOT NULL,
  `GraphID` int(11) NOT NULL,
  `DataValue` text NOT NULL,
  `DataText` text NOT NULL,
  `DataType` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`DataID`, `GraphID`, `DataValue`, `DataText`, `DataType`) VALUES
(1, 1, '0', '', 'RedMinValue'),
(2, 1, '25', '', 'RedMaxValue'),
(3, 1, '25', '', 'AmberMinValue'),
(4, 1, '50', '', 'AmberMaxValue'),
(5, 1, '50', '', 'GreenMinValue'),
(6, 1, '75', '', 'GreenMaxValue'),
(7, 1, '64', '', 'ShownValue'),
(8, 2, '30', 'Section 1', 'PieChartValue0'),
(9, 2, '23', 'Section 2', 'PieChartValue1');

-- --------------------------------------------------------

--
-- Table structure for table `graphorderclient`
--

CREATE TABLE `graphorderclient` (
  `ClientID` int(11) NOT NULL,
  `GraphID` int(11) NOT NULL,
  `Position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graphorderclient`
--

INSERT INTO `graphorderclient` (`ClientID`, `GraphID`, `Position`) VALUES
(1, 1, 1),
(1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `graphorderuser`
--

CREATE TABLE `graphorderuser` (
  `UserID` int(11) NOT NULL,
  `GraphID` int(11) NOT NULL,
  `Position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graphorderuser`
--

INSERT INTO `graphorderuser` (`UserID`, `GraphID`, `Position`) VALUES
(4, 1, 2),
(4, 2, 1),
(3, 2, 2),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `graphs`
--

CREATE TABLE `graphs` (
  `GraphID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `GraphName` text NOT NULL,
  `GraphType` text NOT NULL,
  `GraphText` text NOT NULL,
  `XAxisName` text NOT NULL,
  `YAxisName` text NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graphs`
--

INSERT INTO `graphs` (`GraphID`, `ClientID`, `GraphName`, `GraphType`, `GraphText`, `XAxisName`, `YAxisName`, `config`) VALUES
(1, 1, 'Test Angular Gauge', 'angulargauge', 'Example Text', 'x', 'y', '{\r\n    \"chart\": {\r\n        \"caption\": \"Angular Graph\",\r\n        \"subcaption\": \"Decoding Config Direct From JSON!\",\r\n        \"plotToolText\": \"64\",\r\n        \"theme\": \"fusion\",\r\n        \"exportEnabled\": \"1\",\r\n        \"chartBottomMargin\": \"50\",\r\n        \"showValue\": \"1\"\r\n    },\r\n    \"colorRange\": {\r\n        \"color\": [\r\n            {\r\n                \"minValue\": \"0\",\r\n                \"maxValue\": \"25\",\r\n                \"code\": \"#e44a00\"\r\n            },\r\n            {\r\n                \"minValue\": \"25\",\r\n                \"maxValue\": \"50\",\r\n                \"code\": \"#f8bd19\"\r\n            },\r\n            {\r\n                \"minValue\": \"50\",\r\n                \"maxValue\": \"75\",\r\n                \"code\": \"#6baa01\"\r\n            }\r\n        ]\r\n    },\r\n    \"dials\": {\r\n        \"dial\": [\r\n            {\r\n                \"value\": \"64\",\r\n                \"id\": \"id\"\r\n            }\r\n        ]\r\n    }\r\n}\r\n'),
(2, 1, 'Test Pie Chart', 'pie2d', 'Example Text', 'x', 'y', '{\r\n  \"chart\": {\r\n    \"caption\": \"Market Share of Web Servers\",\r\n    \"plottooltext\": \"<b>$percentValue</b> of web servers run on $label servers\",\r\n    \"showlegend\": \"1\",\r\n    \"showpercentvalues\": \"1\",\r\n    \"legendposition\": \"bottom\",\r\n    \"usedataplotcolorforlabels\": \"1\",\r\n    \"theme\": \"fusion\",\r\n    \"exportEnabled\": \"1\"\r\n  },\r\n  \"data\": [\r\n    {\r\n      \"label\": \"Apache\",\r\n      \"value\": \"32647479\"\r\n    },\r\n    {\r\n      \"label\": \"Microsoft\",\r\n      \"value\": \"22100932\"\r\n    },\r\n    {\r\n      \"label\": \"Zeus\",\r\n      \"value\": \"14376\"\r\n    },\r\n    {\r\n      \"label\": \"Other\",\r\n      \"value\": \"18674221\"\r\n    }\r\n  ]\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `ClientID`, `FirstName`, `LastName`, `username`, `password`, `email`, `permission`) VALUES
(3, 1, 'John', 'Smith', 'JohnSmith123', 'password123', 'JohnSmith@gmail.com', 'Admin'),
(4, 1, 'Jack', 'Woods', 'JackWoods123', '12345Password', 'JackWoods@gmail.com', 'Basic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivedgraphs`
--
ALTER TABLE `archivedgraphs`
  ADD PRIMARY KEY (`ArchiveID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `GraphID` (`GraphID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`DataID`),
  ADD KEY `GraphID` (`GraphID`);

--
-- Indexes for table `graphorderclient`
--
ALTER TABLE `graphorderclient`
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `GraphID` (`GraphID`);

--
-- Indexes for table `graphorderuser`
--
ALTER TABLE `graphorderuser`
  ADD KEY `UserID` (`UserID`),
  ADD KEY `GraphID` (`GraphID`);

--
-- Indexes for table `graphs`
--
ALTER TABLE `graphs`
  ADD PRIMARY KEY (`GraphID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archivedgraphs`
--
ALTER TABLE `archivedgraphs`
  MODIFY `ArchiveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `DataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `graphs`
--
ALTER TABLE `graphs`
  MODIFY `GraphID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivedgraphs`
--
ALTER TABLE `archivedgraphs`
  ADD CONSTRAINT `archivedgraphs_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`),
  ADD CONSTRAINT `archivedgraphs_ibfk_2` FOREIGN KEY (`GraphID`) REFERENCES `graphs` (`GraphID`);

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`GraphID`) REFERENCES `graphs` (`GraphID`);

--
-- Constraints for table `graphorderclient`
--
ALTER TABLE `graphorderclient`
  ADD CONSTRAINT `graphorderclient_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`),
  ADD CONSTRAINT `graphorderclient_ibfk_2` FOREIGN KEY (`GraphID`) REFERENCES `graphs` (`GraphID`);

--
-- Constraints for table `graphorderuser`
--
ALTER TABLE `graphorderuser`
  ADD CONSTRAINT `graphorderuser_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `graphorderuser_ibfk_2` FOREIGN KEY (`GraphID`) REFERENCES `graphs` (`GraphID`);

--
-- Constraints for table `graphs`
--
ALTER TABLE `graphs`
  ADD CONSTRAINT `graphs_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
