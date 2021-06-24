-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2021 at 09:59 AM
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
-- Database: `courses4U`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `country_id`) VALUES
(1, 'Cairo', 1),
(2, 'Giza', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Egypt'),
(2, 'Turkey'),
(3, 'Libya'),
(4, 'KSA'),
(5, 'Qatar'),
(6, 'Sudan');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `duration` time NOT NULL DEFAULT '00:00:00',
  `course_img` varchar(100) NOT NULL DEFAULT 'default_course.png',
  `category_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` datetime DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL COMMENT '1 --> Bad , 5 --> Good',
  `status` tinyint(4) NOT NULL COMMENT '0 --> pended ; 1 --> bought ; 2--> canceled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_img` varchar(100) NOT NULL DEFAULT 'default_student.png',
  `gender` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 --> Male , 2 --> Female',
  `country_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `age`, `phone`, `email`, `password`, `profile_img`, `gender`, `country_id`, `city_id`, `created_at`) VALUES
(1, 'ahmed', 'aldin', 30, '01423183616', 'ahmedalaaaldin100@gmail.com', '$2y$10$Sz1WXr3TVB9EBcx2aFvWSupyAeIaSK3K1RLwnFT8VwDLUUSnwiSZC', 'default_student.png', 2, 1, NULL, '2021-06-19 06:47:48'),
(2, 'ahmed', 'aldin', 30, '01423183616', 'ahmedalaaaldin100@gmail.com', '$2y$10$hKuiM44AzoX.lM3zKINmVeg6cXIUFRiIIm3xpZFJDUa52PG05f8aq', 'default_student.png', 2, 1, NULL, '2021-06-19 15:00:44'),
(3, 'Arthur', 'Jimenez', 24, '01521452900', 'kajaketem@mailinator.com', '$2y$10$/dsiGxvetIiuk.5reAZNBOstZa/OMlzdLo2EPNWyYKGC9DxCyOaLy', 'default_student.png', 1, 3, NULL, '2021-06-19 16:10:12'),
(4, 'Armand', 'Klein', 72, '01293887159', 'koxexokyp@mailinator.com', '$2y$10$v1A/9LaW33.Sf7tMbVgcrOgMN3VozjwjydpgrI693Wm2Sm3WMTa96', '10292390081624119365download (1).png', 1, 5, NULL, '2021-06-19 18:17:19'),
(5, 'Gay', 'Mckenzie', 59, '01962726463', 'karabywajy@mailinator.com', '$2y$10$rTew.0CkNcTpueIISsqjzelcKs6UCJf/sTVG92zdJ4AarhIYm/9aK', '48720631624119820Untitled (1).png', 1, 5, NULL, '2021-06-19 18:23:40'),
(6, 'Bernard', 'Lloyd', 26, '01553716549', 'hohex@mailinator.com', '$2y$10$rvxn/DVS13OSRzzZxgOaIOOb173lK51pUQHnVQCNeTaJrZIvMxlVq', 'default_student.png	', 2, 1, NULL, '2021-06-19 22:37:06'),
(7, 'Keane', 'Davis', 45, '01677869252', 'felyned@mailinator.com', '$2y$10$0cu/PHWDzcehi215Uok8PeNbzyQZ0Hr9pOw3M825R9ONdHP667BTe', 'default_student.png	', 1, 2, NULL, '2021-06-19 22:40:40'),
(8, 'Breanna', 'Fuentes', 35, '01204142211', 'zezaly@mailinator.com', '$2y$10$4zm0Gy2kikJsS.2i7.m7cu7fOd2KFN8yvLicJdGQYZ3bQxDX3tFFC', 'default_student.png	', 2, 3, NULL, '2021-06-19 22:41:09'),
(9, 'Abdul', 'Hyde', 60, '01342812179', 'fovybyxe@mailinator.com', '$2y$10$577uXtnujMN.qcU2mWiIMuXsaoouHOFeYKPEqugZ0ycx.Jjiywj.e', 'default_student.png	', 2, 6, NULL, '2021-06-19 22:46:21'),
(10, 'Karina', 'Jarvis', 72, '01739889974', 'lotoqav@mailinator.com', '$2y$10$.J/QAV/JQPqeS7DX6HYige1vblLsJKv4I5q9oeVGD2E5R08ohIaBm', 'default_student.png	', 1, 1, NULL, '2021-06-19 22:46:48'),
(11, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '$2y$10$jInMR.H1/2jG2rCaGYZVx.eFlhIYm7VyMyVfSOvJyDX8kQtZ6kCQC', 'default_student.png	', 2, 3, NULL, '2021-06-19 22:47:05'),
(12, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '$2y$10$YS3wdoW12KFL0/nAGGzFV.j6bDGb9AeS.gdX1xdXB75HxNjin03wO', 'default_student.png	', 2, 3, NULL, '2021-06-19 23:03:54'),
(13, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '$2y$10$oXl/M3k05vXKgblR2H6U7Ov/yDqHU.Q279EwosbB0DHD7RCWSd4LO', 'default_student.png	', 2, 3, NULL, '2021-06-19 23:06:24'),
(14, 'Jerry', 'Sullivan', 39, '01667221585', 'tasiv@mailinator.com', '$2y$10$fR9Z/VSD9UmP5saPsedTnOnvi1hcaD2g2gK831ozFAG4BN40sgiQK', 'default_student.png	', 1, 3, NULL, '2021-06-19 23:10:17'),
(15, 'Nelle', 'Dickson', 83, '01501402114', 'tusulaq@mailinator.com', '$2y$10$.Htfz.qEx2ztD64uxJYdmOTMxDOz/wpI1dZCSTM.crkH8oaIU/6e2', 'default_student.png	', 2, 4, NULL, '2021-06-19 23:16:23'),
(16, 'Jerry', 'Bradshaw', 22, '01309516115', 'tekotenylo@mailinator.com', '$2y$10$kb5mpAXVF5AtvOGnSAvwd.jAZL6y7jp0o57kygToQHuQJZ31WPgVG', '11639901741624137750.png', 1, 3, NULL, '2021-06-19 23:22:30'),
(17, 'Jayme', 'Greene', 100, '01263533664', 'nydav@mailinator.com', '$2y$10$Ms5H54caxfXuXGcK5DkOMuQiE73PyqB5zPbtJRaaoH1LcJxhggnXW', 'default_student.png	', 1, 2, NULL, '2021-06-19 23:23:48'),
(18, 'Prescott', 'Nolan', 84, '01147841434', 'xifaxo@mailinator.com', '$2y$10$RcfYFIOQUBJ32noORyLRTubNCimzuVhR7UwxsgVt1m0TclgbZHaKq', 'default_student.png	', 1, 6, NULL, '2021-06-20 08:45:50'),
(19, 'Hunter', 'Hart', 59, '01148134475', 'remu@mailinator.com', '$2y$10$fvsGNmRuYDfeLOCTh2mkNuZynlxyXSjz3yrAOY68sN4H49nQq1EvO', '10581615781624171595.jpeg', 2, 4, NULL, '2021-06-20 08:46:35'),
(20, 'Xenos', 'Howe', 30, '01459329418', 'qahanija@mailinator.com', '$2y$10$047JGTDs76If.BzkdZDAturEGLhtUJcqOyRX19GN/YmrvLVjqliJ2', 'default_student.png	', 1, 3, NULL, '2021-06-21 20:16:28'),
(21, 'Jescie', 'Santana', 16, '01305911283', 'rikeduzesy@mailinator.com', '$2y$10$1jCpYbuXRuolpuIplsggWuQO3E2nMn7n/P9JcjMfthHikv.3d1G2m', 'default_student.png	', 1, 1, NULL, '2021-06-21 20:19:42'),
(22, 'Berk', 'Stone', 51, '01845361398', 'maqul@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '12680306631624435356.jpeg', 1, 4, NULL, '2021-06-23 10:02:36'),
(23, 'Gail', 'Kaufman', 47, '01973832182', 'viqyc@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_student.png	', 1, 5, NULL, '2021-06-23 10:25:28'),
(24, 'Nathaniel', 'Massey', 38, '01722221634', 'kagozuxoga@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_student.png	', 1, 1, NULL, '2021-06-23 10:26:17'),
(25, 'Aphrodite', 'Aguilar', 39, '01573182587', 'gaqilehux@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '9616266121624436884.jpeg', 2, 1, NULL, '2021-06-23 10:28:04'),
(26, 'Jackson', 'Beck', 5, '01748144648', 'xavypylon@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '15912300961624436935.png', 1, 3, NULL, '2021-06-23 10:28:55'),
(27, 'Galvin', 'Bartlett', 51, '01595579233', 'vumeti@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '8067218541624437083.png', 1, 2, NULL, '2021-06-23 10:31:23'),
(28, 'Kendall', 'Crane', 22, '01127582702', 'mural@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '9727318621624437579.png', 2, 2, NULL, '2021-06-23 10:39:39'),
(29, 'Tarik', 'Townsend', 82, '01139227525', 'tosu@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '1617197841624439084.png', 1, 4, NULL, '2021-06-23 11:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_img` varchar(100) NOT NULL DEFAULT 'default_teacher.png',
  `gender` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 --> Male , 2 --> Female',
  `country_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `last_name`, `age`, `phone`, `email`, `password`, `profile_img`, `gender`, `country_id`, `city_id`, `created_at`) VALUES
(1, 'Arden', 'Chaney', 1, '01582604841', 'natavuqaki@mailinator.com', '$2y$10$hKuiM44AzoX.lM3zKINmVeg6cXIUFRiIIm3xpZFJDUa52PG05f8aq', 'default_teacher.png', 1, 1, 2, '2021-06-19 15:02:59'),
(2, 'Arden', 'Chaney', 1, '01582604841', 'natavuqaki@mailinator.com', '$2y$10$hKuiM44AzoX.lM3zKINmVeg6cXIUFRiIIm3xpZFJDUa52PG05f8aq', 'default_teacher.png', 1, 1, 2, '2021-06-19 15:03:15'),
(3, 'Bevis', 'Mcfadden', 12, '01192814820', 'lygazyhy@mailinator.com', '$2y$10$3rtmac5LQgonrJ6i2YRZ2.8ABe910IcxNh0rQeJnMj43t8pR0gNxK', 'default_teacher.png', 2, 2, NULL, '2021-06-19 15:06:55'),
(4, 'Bevis', 'Mcfadden', 12, '01192814820', 'lygazyhy@mailinator.com', '$2y$10$oiGks4.IM5vNH7CIapQhfOGxuHaETf6s5BKcbOsJ75KiT/TDFbghy', 'default_teacher.png', 2, 2, NULL, '2021-06-19 15:49:32'),
(5, 'Bevis', 'Mcfadden', 12, '01192814820', 'lygazyhy@mailinator.com', '$2y$10$I06qeyfNDNCD5.x2nxwJRukob7GBL4XwG0gp8DYPleZplXYR76XAm', 'default_teacher.png', 2, 2, NULL, '2021-06-19 16:08:26'),
(6, 'Perry', 'Velasquez', 28, '01381542419', 'tiwi@mailinator.com', '$2y$10$YuP6tF2ZsCKq7a5JPoquBu9pbxBLnr/j4P9yt4ATuyWHWe4Ny9aRq', 'default_teacher.png', 1, 2, NULL, '2021-06-19 16:09:03'),
(7, 'Amela', 'Sanders', 48, '01348335201', 'nipi@mailinator.com', '$2y$10$tHayZWhJx3JxsbvBYxHHWO.kKE32a/A7Q7TqO2l8g.KcygpDV6Sfm', 'default_teacher.png	', 1, 1, NULL, '2021-06-19 18:23:07'),
(8, 'Dean', 'Berry', 48, '01433694738', 'buhycodaqe@mailinator.com', '$2y$10$Z9rRkgp3CuGCJUP45LppY.xqrlt6hj6V.8382bEJivzj/Yp7VjUFG', 'default_teacher.png	', 1, 5, NULL, '2021-06-19 18:23:22'),
(9, 'Nichole', 'Dunlap', 88, '01892629781', 'nuga@mailinator.com', '$2y$10$uY8Cc67Vw5pFAXGcCv5v0.eVKzZzxs6bDGxdN94ePrJNb/FNqOOSS', 'default_teacher.png	', 2, 5, NULL, '2021-06-19 18:23:26'),
(10, 'Daphne', 'Pace', 77, '01202932949', 'dawolyxefi@mailinator.com', '$2y$10$lRoCaHV3Z2rsKIUylOgf7O5R/l32mAYKKNzGs5NSSCMm/YwP1xqy2', '5264556281624132395.png', 2, 5, NULL, '2021-06-19 21:53:15'),
(11, 'Neil', 'Byers', 48, '01518745962', 'vihi@mailinator.com', '$2y$10$z9FhdpGsNdGXxcZ12MNBXe46/3HXmIENrwfe4zuYnmIlLzrJFEnAG', '20614132511624134600.png', 2, 1, NULL, '2021-06-19 22:30:00'),
(12, 'Jolene', 'Reynolds', 14, '01438238318', 'pynokasami@mailinator.com', '$2y$10$INq0R7Mv65qJ9Q4X5L3TsOvlrtQY1rj9HvvXJgjk8YTnkwB.79H/K', '2148497731624134620.png', 2, 3, NULL, '2021-06-19 22:30:20'),
(13, 'Levi', 'Mcintyre', 15, '01248945237', 'hyka@mailinator.com', '$2y$10$ToVla8E7WLHA.E0Ay1ygteZ2.x5P/KgS9UK9s3/XZ2nyPZJICQjte', '8314394151624134672.png', 2, 1, NULL, '2021-06-19 22:31:12'),
(14, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$5i3Xag468tkwKJGSua3WfumYfmsnW2IIXj3TLc0zskMe1fpriaymq', '8132362241624134731.png', 2, 3, NULL, '2021-06-19 22:32:11'),
(15, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$Pn.47s670QSaz8YUebp4H.91qI6qAa.Zuhf7tYsddVlw213Lklv.2', '21400888781624134870.png', 2, 3, NULL, '2021-06-19 22:34:30'),
(16, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$s/pW2R8DZ0ObKqIhFgeu0eBLomEde7LnB3lWiIDTEX5z/w5r1/HcK', '1612522501624134918.png', 2, 3, NULL, '2021-06-19 22:35:18'),
(17, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$WsAPB0wuflhKmhNLbsjqa./26gPYlxbZ/HopfekHoddLKrg0zA0a2', '11305687941624134953.png', 2, 3, NULL, '2021-06-19 22:35:53'),
(18, 'Simone', 'Wright', 36, '01585764727', 'keviri@mailinator.com', '$2y$10$tTXIKyFm13ZRH2AzSmrQW.L.uiunP6bnvmhhzZp4DMFG8fc8CuF4W', '5796017801624134979.png', 1, 4, NULL, '2021-06-19 22:36:19'),
(19, 'Kiayada', 'Richardson', 94, '01196822969', 'hoxutodec@mailinator.com', '$2y$10$F2zrUUFTrXTksn1IIsSaPOTWHFJ.nxEZbEvfwLKgWBapGYvoe3KHa', '2480468401624134999.png', 1, 1, NULL, '2021-06-19 22:36:39'),
(20, 'Lunea', 'Collier', 89, '01863355353', 'cadu@mailinator.com', '$2y$10$QWyPwhv3ePFk9gLeZeSrzuYtOjVyECdWNdsA3MZXCm/1qaMwrrQnu', 'default_teacher.png	', 2, 3, NULL, '2021-06-19 22:38:04'),
(21, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$N659mNWcirrSUchE4AKLGeDxyRFgRomGdOrYx0BLol7slaxMiZ59C', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:06:36'),
(22, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$ikxHBsa10BJ1U3kJlp.POOD.CPj25tojP0DSM4pCvE.2dwgF0tSt2', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:07:54'),
(23, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$KF9u7cc1Ri9sOoY4Zgihp.XS6OCkOr/o7e6Iq38DdMiX7sSpSiYVu', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:08:04'),
(24, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$P0ZuUT/E2qZ4k3HFiEJVEOjKtzvwNYwz7hRmLxZEdPyYmkiBOx1xm', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:09:23'),
(25, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$ayzpve94etQCAg/s8WO2cOAREI9exYMSl3/D9Ne8HAwC149cZE2jK', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:09:41'),
(26, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$hZ8Z.19k3Yrx1oun4hysYOTd2fu0xuSJMSVWdc3u2AzdkCwuNlTAy', 'default_teacher.png	', 2, 1, NULL, '2021-06-19 23:09:51'),
(27, 'Maryam', 'Simon', 57, '01823662477', 'pilejecaci@mailinator.com', '$2y$10$JNHn7JvFIny4DUcDZgMGNOnzc/DBvVPU7QWq6vUccihRdpN2yZuha', 'default_teacher.png	', 1, 3, NULL, '2021-06-19 23:10:10'),
(28, 'Nero', 'Porter', 78, '01362409329', 'rikabuxyg@mailinator.com', '$2y$10$QfpV15byanXvY8uCnhDzs.l33msfeiN05t8p1NLt0gQGBlDgKI7i.', 'default_teacher.png	', 2, 4, NULL, '2021-06-19 23:13:42'),
(29, 'Beverly', 'Gallegos', 43, '01155119304', 'doborib@mailinator.com', '$2y$10$bE2kOoe0Kv7fy4Uop.Z1keSNqr6UHvuKo1dhl/7Gkp.M9BtyZdZkq', 'default_teacher.png	', 1, 2, NULL, '2021-06-19 23:16:33'),
(30, 'Gisela', 'Doyle', 77, '01271147263', 'zasyvusak@mailinator.com', '$2y$10$a/8VpPUw05.xstQYumnuW.2JZXOtucewbzIQuzwxSzmGUmfL/MCaO', 'default_teacher.png	', 1, 3, NULL, '2021-06-19 23:17:29'),
(31, 'Ahmed', NULL, NULL, NULL, 'ahmedalaa_100@yahoo.com', '$2y$10$I06qeyfNDNCD5.x2nxwJRukob7GBL4XwG0gp8DYPleZplXYR76XAm', 'default_teacher.png', 0, 2, NULL, '2021-06-20 20:33:39'),
(32, 'Sloane', 'Collier', 72, '01135303448', 'keji@mailinator.com', '$2y$10$VZkWeBg6L2LA0uQ1v9ltsuWGMvQSPuEB2FTHZrj1cUK5pqc9AkX9K', 'default_teacher.png	', 2, 2, NULL, '2021-06-22 20:22:07'),
(33, 'Dorian', 'Young', 24, '01608548355', 'mubuguma@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 1, NULL, '2021-06-22 20:44:01'),
(34, 'Ferdinand', 'Moses', 50, '01333929565', 'tyhysuf@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 3, NULL, '2021-06-23 10:40:14'),
(35, 'Kimberly', 'Perkins', 75, '01899857768', 'vuko@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 3, NULL, '2021-06-23 20:06:24'),
(36, 'Hectordasdada', 'Wagner', 53, '01844452326', 'fulog@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 1, 2, '2021-06-23 11:40:21'),
(37, 'Carissa', 'Guzman', 14, '01602447375', 'habupor@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 2, NULL, '2021-06-23 13:02:34'),
(38, 'Sybill', 'Solis', 54, '01438581133', 'nesobakik@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 2, NULL, '2021-06-23 13:39:15'),
(39, 'Kasimir', 'Tanner', 31, '01642703971', 'dejun@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 3, NULL, '2021-06-23 13:46:08'),
(40, 'Cassandra', 'Brady', 48, '01811206520', 'dywo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 1, 1, '2021-06-23 13:46:17'),
(41, 'Yen', 'Alvarez', 80, '01921578492', 'lylo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 6, NULL, '2021-06-23 13:47:28'),
(42, 'Channing', 'Calhoun', 3, '01155798347', 'qozoto@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 5, NULL, '2021-06-23 13:51:12'),
(43, 'Hayley', 'Hickman', 51, '01463481551', 'kevaf@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 3, NULL, '2021-06-23 13:53:08'),
(44, 'Alyssa', 'Ryan', 19, '01789505266', 'vequtegul@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 4, NULL, '2021-06-23 13:59:51'),
(45, 'Forrest', 'Fleming', 0, '01365835160', 'rebi@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 3, NULL, '2021-06-23 14:00:02'),
(46, 'Ulysses', 'Russo', 59, '01726961600', 'xoni@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '13442659631624449615.jpeg', 2, 6, NULL, '2021-06-23 14:00:15'),
(47, 'Camilla', 'Vazquez', 73, '01201366806', 'ciryzy@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 5, NULL, '2021-06-23 14:04:05'),
(48, 'Germane', 'Hudson', 38, '01511993118', 'lepykamu@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 1, NULL, '2021-06-23 17:41:36'),
(49, 'Emerald', 'Lane', 43, '01824911123', 'syvefaza@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 5, NULL, '2021-06-23 17:42:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_city` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_courses` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student course` (`student_id`),
  ADD KEY `course course` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_city` (`city_id`),
  ADD KEY `teacher_country` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `country_city` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `category_courses` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `course course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student course` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teacher_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
