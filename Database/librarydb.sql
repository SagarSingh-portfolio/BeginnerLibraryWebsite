-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 06:59 PM
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
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `ISBN` bigint(13) UNSIGNED NOT NULL,
  `title` varchar(40) NOT NULL,
  `author` varchar(40) NOT NULL,
  `edition` tinyint(3) UNSIGNED NOT NULL,
  `pubYear` year(4) NOT NULL,
  `categoryID` bigint(20) UNSIGNED NOT NULL,
  `reserveStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `title`, `author`, `edition`, `pubYear`, `categoryID`, `reserveStatus`) VALUES
(1234567891234, 'Harry Potter: Shadow Money Wizard', 'Harold Potters', 5, '2021', 5, 1),
(1351320515131, 'Peppa Pig', 'Chris P. Bacon', 2, '2015', 6, 0),
(1351984238482, 'Liam the Lamb', 'Chris P. Bacon', 2, '2013', 6, 0),
(1398438191686, 'Percy Jackson Gets Arrested for drug dea', 'Rick Riordan', 2, '2010', 6, 0),
(1681616161618, 'Hunger Games', 'Ian Starver', 4, '2012', 1, 0),
(6571354987654, 'Killers of the Flower Moon', 'David Grann', 4, '2018', 4, 0),
(8168161686366, 'Percy Jackson Signs a prenup', 'Rick Riordan', 2, '2018', 6, 0),
(9516468426167, 'Dune part 2', 'Peter Sanders', 3, '1991', 2, 1),
(9846516849615, 'Dune part 1', 'Peter Sanders', 3, '1988', 2, 1),
(9849448461111, 'Percy Jackson Goes to Paris', 'Rick Riordan', 5, '2023', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` bigint(20) UNSIGNED NOT NULL,
  `categoryTitle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryTitle`) VALUES
(1, 'Fantasy'),
(2, 'Sci-Fi'),
(3, 'Action & Adventure'),
(4, 'Mystery'),
(5, 'Horror'),
(6, 'History'),
(7, 'Romance'),
(8, 'Childrens'),
(9, 'Biography');

-- --------------------------------------------------------

--
-- Table structure for table `reservedbook`
--

CREATE TABLE `reservedbook` (
  `ISBN` bigint(13) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservedbook`
--

INSERT INTO `reservedbook` (`ISBN`, `username`, `date`) VALUES
(1234567891234, 'sagar1', '0000-00-00'),
(9516468426167, 'admin', '0000-00-00'),
(9846516849615, 'admin', '2023-11-28');

--
-- Triggers `reservedbook`
--
DELIMITER $$
CREATE TRIGGER `bookReserved` AFTER INSERT ON `reservedbook` FOR EACH ROW UPDATE book SET book.reserveStatus = 1 WHERE book.ISBN = new.ISBN
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `bookUnreserved` AFTER DELETE ON `reservedbook` FOR EACH ROW UPDATE book SET book.reserveStatus = 0 WHERE book.ISBN = old.ISBN
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(6) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `addLineSt` varchar(25) NOT NULL,
  `addLineDis` varchar(25) NOT NULL,
  `city` varchar(25) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `firstName`, `lastName`, `addLineSt`, `addLineDis`, `city`, `telephone`, `mobile`) VALUES
('admin', 'admin1', 'Adam', 'Minster', '26 Fork Street', 'Glasnevin', 'Dublin', '1234567891', '1987654321'),
('neda', '123456', 'neda', 'last', 'stret', 'dis', 'city', '1234567890', '0987654321'),
('sagar1', '123456', 'first', 'last', 'st', 'dis', 'city', '1234567890', '1234567890'),
('test', '123456', 'sagar', 'singh', 'stret', 'dis', 'dublin', '1234567890', '0987654321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `categoryID` (`categoryID`) USING BTREE;

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `reservedbook`
--
ALTER TABLE `reservedbook`
  ADD PRIMARY KEY (`ISBN`,`username`),
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `ISBN` (`ISBN`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `categoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `categoryID` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`);

--
-- Constraints for table `reservedbook`
--
ALTER TABLE `reservedbook`
  ADD CONSTRAINT `ISBN` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
