-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2021 at 07:57 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `join_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'pharmacology'),
(2, 'biochemistry'),
(3, 'microbiology'),
(4, 'analytical chemistry'),
(5, 'toxicologyy'),
(6, 'botany');

-- --------------------------------------------------------

--
-- Table structure for table `nationalIds`
--

CREATE TABLE `nationalIds` (
  `id` int(11) NOT NULL,
  `number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nationalIds`
--

INSERT INTO `nationalIds` (`id`, `number`) VALUES
(1, '1231638163786178361'),
(2, '23423423131231'),
(3, '423234432352342'),
(4, '42342342342412312'),
(5, '564743213543645534'),
(6, '4234861348689123'),
(7, '23482164871628746'),
(8, '18974823478263488172364'),
(9, '32748962834682176'),
(10, '38276487632786423'),
(11, '3284798234897291834'),
(12, '7349721938798231423'),
(13, '23489712394879213874912'),
(14, '392749712389471298472'),
(15, '34798237489723849');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `nationalID_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `nationalID_id`, `department_id`) VALUES
(1, 'Ahmed', '231231231', 1, 2),
(2, 'Emad', '32123123', 2, 4),
(3, 'Haytham', '1231233243452', 3, 6),
(4, 'Mona', '131323432523', 5, 5),
(5, 'Youssuf', '2314353234', 6, 4),
(6, 'Hoda', '2343454636', 7, 6),
(7, 'Hanan', '534114246586', 8, 5),
(8, 'Mahmoud', '3234543634', 9, 2),
(9, 'Hesham', '324241234', 10, 3),
(10, 'Magdy', '123124341234', 11, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalIds`
--
ALTER TABLE `nationalIds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments` (`department_id`),
  ADD KEY `National ID` (`nationalID_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nationalIds`
--
ALTER TABLE `nationalIds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `National ID` FOREIGN KEY (`nationalID_id`) REFERENCES `nationalIds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
