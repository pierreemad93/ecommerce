-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2018 at 10:46 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` smallint(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Pc', 'Auctor venenatis quam animi mauris pellentesque? Sociis curae ipsa dignissimos veritatis occaecat saepe. At cras venenatis! Blandit mus? Et! Venia', 1, 0, 0, 0),
(2, 'Mobile', 'Totam placeat? Aperiam corrupti ligula fermentum nostrud mauris, molestie dignissimos? Beatae! Habitant anim sunt aliqua laborum ex diamlorem, ', 2, 0, 0, 0),
(3, 'Games', 'Quas interdum nisi! Fugiat hac consequuntur veritatis aliquip nonummy ullamco perferendis vulputate unde pharetra esse incididunt eiusmod explicabo! Nec molestias.', NULL, 1, 0, 0),
(4, 'Shoes', 'Tellus ornare! Porro magna nam.', 0, 0, 1, 0),
(5, 'secert', 'Tellus ornare! Porro magna nam.', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@info.com', 'administrator', 1, 0, 1, '0000-00-00'),
(2, 'pierre', '601f1889667efaebb33b8c12572835da3f027f78', 'pierre@info.com', 'Pierre Emad', 0, 0, 1, '0000-00-00'),
(3, 'thomas', '601f1889667efaebb33b8c12572835da3f027f78', 'thomas@info.com', 'Thomas Emad', 0, 0, 1, '0000-00-00'),
(4, 'louerm', '601f1889667efaebb33b8c12572835da3f027f78', 'lourem@info.com', 'Lourem Ipsum', 0, 0, 1, '0000-00-00'),
(5, 'beshoy', '87acec17cd9dcd20a716cc2cf67417b71c8a7016', 'beshoy@info.com', 'Beshoy Medhat', 0, 0, 1, '0000-00-00'),
(6, 'marian', '601f1889667efaebb33b8c12572835da3f027f78', 'marian@info.com', 'Marian Magdy', 0, 0, 1, '0000-00-00'),
(7, 'eman', '601f1889667efaebb33b8c12572835da3f027f78', 'eman@info.com', 'Eman Kamal', 0, 0, 1, '0000-00-00'),
(8, 'paula', '601f1889667efaebb33b8c12572835da3f027f78', 'paula@info.com ', 'Paula Raffat', 0, 0, 1, '2018-06-28'),
(9, 'emad', '601f1889667efaebb33b8c12572835da3f027f78', 'emad@info.com', 'Emad Adieb ', 0, 0, 1, '2018-06-28'),
(10, 'rofael', '601f1889667efaebb33b8c12572835da3f027f78', 'rofael@info.com', 'Rofael Milad', 0, 0, 1, '2018-06-29'),
(11, 'maximous', '601f1889667efaebb33b8c12572835da3f027f78', 'maximous@info.com', 'Maximous Gamil', 0, 0, 1, '2018-06-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
