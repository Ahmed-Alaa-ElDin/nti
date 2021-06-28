-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2021 at 03:31 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses4u`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Quia reprehenderit '),
(2, 'Corrupti voluptate asdsdas'),
(3, 'Galvin Daniels');

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
(2, 'Giza', 1),
(4, 'Harlan Robinson', 1),
(6, 'Makka', 4);

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
(6, 'Sudan'),
(7, 'Xeracalms');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `hours` int(11) NOT NULL DEFAULT 0,
  `minutes` int(11) NOT NULL DEFAULT 0,
  `course_img` varchar(100) NOT NULL DEFAULT 'default_course.png',
  `category_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `price`, `hours`, `minutes`, `course_img`, `category_id`, `created_by`, `created_at`) VALUES
(2, 'Est aliquip commodo ', 423, 0, 0, 'default_course.png', 1, 25, '2021-06-25 13:23:20'),
(3, 'Debitis sadas', 32, 0, 0, 'default_course.png', 2, 10, '2021-06-25 13:24:04'),
(6, 'Chandler Hester', 739, 4, 48, 'default_teacher.png	', 1, 40, '2021-06-26 03:45:51'),
(8, 'Winter Murray', 43, 18, 20, 'default_teacher.png	', 1, 32, '2021-06-26 03:47:06'),
(9, 'Naomi Guerra', 312, 33, 46, 'default_course.png	', 2, 49, '2021-06-26 03:48:02'),
(10, 'Riley Ingram', 735, 64, 32, '13732012281624705564.png', 1, 22, '2021-06-26 03:53:31'),
(12, 'Hamish Perez', 42, 80, 19, '5042367081624705550.jpeg', 3, 52, '2021-06-26 04:11:16'),
(13, 'Rafael Grimes', 260, 26, 42, '3136825501624673486.jpeg', 3, 30, '2021-06-26 04:11:26'),
(14, 'Reece Clements', 178, 92, 7, 'default_course.png	', 2, 23, '2021-06-28 14:44:00'),
(15, 'Lydia Marquez', 452, 35, 3, 'default_course.png	', 3, 10, '2021-06-28 14:44:17'),
(16, 'Mallory Thompson', 74, 20, 1, 'default_course.png	', 2, 51, '2021-06-28 14:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `rating` float NOT NULL DEFAULT 0,
  `review` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `course_id`, `student_id`, `rating`, `review`) VALUES
(24, 2, 22, 2.5, 'dasdas'),
(27, 6, 29, 2.5, '&lt;p&gt;&lt;strong&gt;Laborum molestiae pr. sdfsdfdsf&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;em&gt;&lt;strong&gt;adasdasdasd&lt;/strong&gt;&lt;/em&gt;&lt;/p&gt;'),
(28, 9, 8, 2, '&lt;p style=&quot;text-align: center;&quot;&gt;&lt;strong&gt;sdasdasdasdsadasd Ahmed&lt;/strong&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Pended'),
(2, 'Bought'),
(3, 'Canceled');

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
(1, 'Rae', 'Jefferson', 75, '01478437884', 'zokocaka@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_student.png', 2, 1, NULL, '2021-06-19 06:47:48'),
(3, 'Arthur', 'Jimenez', 24, '01521452900', 'kajaketem@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-19 16:10:12'),
(4, 'Armand', 'Klein', 72, '01293887159', 'koxexokyp@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 5, NULL, '2021-06-19 18:17:19'),
(5, 'Gay', 'Mckenzie', 59, '01962726463', 'karabywajy@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 5, NULL, '2021-06-19 18:23:40'),
(6, 'Bernard', 'Lloyd', 26, '01553716549', 'hohex@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 1, NULL, '2021-06-19 22:37:06'),
(7, 'Keane', 'Davis', 45, '01677869252', 'felyned@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 2, NULL, '2021-06-19 22:40:40'),
(8, 'Breanna', 'Fuentes', 35, '01204142211', 'zezaly@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 3, NULL, '2021-06-19 22:41:09'),
(9, 'Savannah', 'Mercado', 27, '01478752294', 'fuki@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 6, NULL, '2021-06-19 22:46:21'),
(10, 'Karina', 'Jarvis', 72, '01739889974', 'lotoqav@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 1, NULL, '2021-06-19 22:46:48'),
(11, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 3, NULL, '2021-06-19 22:47:05'),
(12, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 3, NULL, '2021-06-19 23:03:54'),
(13, 'Mary', 'Sampson', 19, '01156742414', 'qutysaj@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 3, NULL, '2021-06-19 23:06:24'),
(14, 'Jerry', 'Sullivan', 39, '01667221585', 'tasiv@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-19 23:10:17'),
(15, 'Nelle', 'Dickson', 83, '01501402114', 'tusulaq@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 4, NULL, '2021-06-19 23:16:23'),
(16, 'Jerry', 'Bradshaw', 22, '01309516115', 'tekotenylo@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-19 23:22:30'),
(17, 'Jayme', 'Greene', 100, '01263533664', 'nydav@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 2, NULL, '2021-06-19 23:23:48'),
(18, 'Prescott', 'Nolan', 84, '01147841434', 'xifaxo@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 6, NULL, '2021-06-20 08:45:50'),
(19, 'Hunter', 'Hart', 59, '01148134475', 'remu@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 4, NULL, '2021-06-20 08:46:35'),
(20, 'Xenos', 'Howe', 30, '01459329418', 'qahanija@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-21 20:16:28'),
(21, 'Jescie', 'Santana', 16, '01305911283', 'rikeduzesy@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 1, NULL, '2021-06-21 20:19:42'),
(22, 'Berk', 'Stone', 51, '01845361398', 'maqul@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 4, NULL, '2021-06-23 10:02:36'),
(23, 'Gail', 'Kaufman', 47, '01973832182', 'viqyc@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 5, NULL, '2021-06-23 10:25:28'),
(24, 'Nathaniel', 'Massey', 38, '01722221634', 'kagozuxoga@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 1, NULL, '2021-06-23 10:26:17'),
(26, 'Jackson', 'Beck', 5, '01748144648', 'xavypylon@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-23 10:28:55'),
(27, 'Galvin', 'Bartlett', 51, '01595579233', 'vumeti@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 2, NULL, '2021-06-23 10:31:23'),
(28, 'Kendall', 'Crane', 22, '01127582702', 'mural@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 2, NULL, '2021-06-23 10:39:39'),
(29, 'Tarik', 'Townsend', 82, '01139227525', 'tosu@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 4, NULL, '2021-06-23 11:04:44'),
(30, 'Gil', 'Norman', 39, '01152735363', 'vyguhajori@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 2, NULL, '2021-06-24 20:47:12'),
(31, 'Gisela', 'Logan', 7, '01137927766', 'nypoxupo@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 2, 4, NULL, '2021-06-25 05:10:45'),
(33, 'Wayne', 'Adkins', 34, '01504364756', 'zejexevi@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 3, NULL, '2021-06-25 05:12:34'),
(34, 'Merrill', 'Salazar', 26, '01642226930', 'xotiguh@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png', 1, 1, 1, '2021-06-25 05:13:18'),
(35, 'Kathleen', 'Knight', 33, '01948896777', 'qyzuzug@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', '16432393341624591313.jpeg', 1, 6, NULL, '2021-06-25 05:21:53'),
(36, 'Keegan', 'Peterson', 43, '01988312581', 'demyjuqok@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png	', 2, 2, NULL, '2021-06-25 05:31:32'),
(37, 'Lucian', 'Wolfe', 19, '01239226845', 'cipy@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png	', 1, 1, NULL, '2021-06-25 05:31:44'),
(38, 'Unity', 'Blair', 39, '01847965594', 'wapa@mailinator.com', '1bfe76a453e484de74a2cd5fc44bbb10b55b2f92', 'default_student.png	', 1, 4, 6, '2021-06-25 09:17:28'),
(39, 'Mechelle', 'Sweet', 13, '01835946832', 'gogujaroqo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_student.png	', 2, 5, NULL, '2021-06-25 13:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` datetime DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `course_id`, `student_id`, `join_date`, `expiry_date`, `status_id`) VALUES
(3, 12, 5, '2021-06-26 13:38:19', NULL, 1),
(4, 13, 31, '2021-06-26 13:38:19', '2021-06-02 15:29:01', 2);

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
(6, 'Perry', 'Velasquez', 28, '01381542419', 'tiwi@mailinator.com', '$2y$10$YuP6tF2ZsCKq7a5JPoquBu9pbxBLnr/j4P9yt4ATuyWHWe4Ny9aRq', 'default_teacher.png', 1, 2, NULL, '2021-06-19 16:09:03'),
(8, 'Dean', 'Berry', 48, '01433694738', 'buhycodaqe@mailinator.com', '$2y$10$Z9rRkgp3CuGCJUP45LppY.xqrlt6hj6V.8382bEJivzj/Yp7VjUFG', 'default_teacher.png', 1, 5, NULL, '2021-06-19 18:23:22'),
(9, 'Nichole', 'Dunlap', 88, '01892629781', 'nuga@mailinator.com', '$2y$10$uY8Cc67Vw5pFAXGcCv5v0.eVKzZzxs6bDGxdN94ePrJNb/FNqOOSS', 'default_teacher.png', 2, 5, NULL, '2021-06-19 18:23:26'),
(10, 'Daphne', 'Pace', 77, '01202932949', 'dawolyxefi@mailinator.com', '$2y$10$lRoCaHV3Z2rsKIUylOgf7O5R/l32mAYKKNzGs5NSSCMm/YwP1xqy2', 'default_teacher.png', 2, 5, NULL, '2021-06-19 21:53:15'),
(11, 'Neil', 'Byers', 48, '01518745962', 'vihi@mailinator.com', '$2y$10$z9FhdpGsNdGXxcZ12MNBXe46/3HXmIENrwfe4zuYnmIlLzrJFEnAG', 'default_teacher.png', 2, 1, NULL, '2021-06-19 22:30:00'),
(12, 'Xena', 'Vaughan', 36, '01195852242', 'wibeh@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '19123544281624566757.jpeg', 1, 4, 6, '2021-06-19 22:30:20'),
(13, 'Levi', 'Mcintyre', 15, '01248945237', 'hyka@mailinator.com', '$2y$10$ToVla8E7WLHA.E0Ay1ygteZ2.x5P/KgS9UK9s3/XZ2nyPZJICQjte', 'default_teacher.png', 2, 1, NULL, '2021-06-19 22:31:12'),
(14, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$5i3Xag468tkwKJGSua3WfumYfmsnW2IIXj3TLc0zskMe1fpriaymq', 'default_teacher.png', 2, 3, NULL, '2021-06-19 22:32:11'),
(15, 'Dahlia', 'Armstrong', 97, '01749348912', 'cavi@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 6, NULL, '2021-06-19 22:34:30'),
(16, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$s/pW2R8DZ0ObKqIhFgeu0eBLomEde7LnB3lWiIDTEX5z/w5r1/HcK', 'default_teacher.png', 2, 3, NULL, '2021-06-19 22:35:18'),
(17, 'Holly', 'Mccormick', 66, '01205492926', 'cimobon@mailinator.com', '$2y$10$WsAPB0wuflhKmhNLbsjqa./26gPYlxbZ/HopfekHoddLKrg0zA0a2', 'default_teacher.png', 2, 3, NULL, '2021-06-19 22:35:53'),
(18, 'Simone', 'Wright', 36, '01585764727', 'keviri@mailinator.com', '$2y$10$tTXIKyFm13ZRH2AzSmrQW.L.uiunP6bnvmhhzZp4DMFG8fc8CuF4W', 'default_teacher.png', 1, 4, NULL, '2021-06-19 22:36:19'),
(19, 'Kiayada', 'Richardson', 94, '01196822969', 'hoxutodec@mailinator.com', '$2y$10$F2zrUUFTrXTksn1IIsSaPOTWHFJ.nxEZbEvfwLKgWBapGYvoe3KHa', 'default_teacher.png', 1, 1, NULL, '2021-06-19 22:36:39'),
(20, 'Lunea', 'Collier', 89, '01863355353', 'cadu@mailinator.com', '$2y$10$QWyPwhv3ePFk9gLeZeSrzuYtOjVyECdWNdsA3MZXCm/1qaMwrrQnu', 'default_teacher.png', 2, 3, NULL, '2021-06-19 22:38:04'),
(21, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$N659mNWcirrSUchE4AKLGeDxyRFgRomGdOrYx0BLol7slaxMiZ59C', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:06:36'),
(22, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$ikxHBsa10BJ1U3kJlp.POOD.CPj25tojP0DSM4pCvE.2dwgF0tSt2', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:07:54'),
(23, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$KF9u7cc1Ri9sOoY4Zgihp.XS6OCkOr/o7e6Iq38DdMiX7sSpSiYVu', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:08:04'),
(24, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$P0ZuUT/E2qZ4k3HFiEJVEOjKtzvwNYwz7hRmLxZEdPyYmkiBOx1xm', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:09:23'),
(25, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$ayzpve94etQCAg/s8WO2cOAREI9exYMSl3/D9Ne8HAwC149cZE2jK', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:09:41'),
(26, 'Gabriel', 'Keller', 6, '01637501234', 'dycajyqir@mailinator.com', '$2y$10$hZ8Z.19k3Yrx1oun4hysYOTd2fu0xuSJMSVWdc3u2AzdkCwuNlTAy', 'default_teacher.png', 2, 1, NULL, '2021-06-19 23:09:51'),
(27, 'Maryam', 'Simon', 57, '01823662477', 'pilejecaci@mailinator.com', '$2y$10$JNHn7JvFIny4DUcDZgMGNOnzc/DBvVPU7QWq6vUccihRdpN2yZuha', 'default_teacher.png', 1, 3, NULL, '2021-06-19 23:10:10'),
(28, 'Nero', 'Porter', 78, '01362409329', 'rikabuxyg@mailinator.com', '$2y$10$QfpV15byanXvY8uCnhDzs.l33msfeiN05t8p1NLt0gQGBlDgKI7i.', 'default_teacher.png', 2, 4, NULL, '2021-06-19 23:13:42'),
(29, 'Elvis', 'Burgess', 72, '01488839786', 'maky@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 3, NULL, '2021-06-19 23:16:33'),
(30, 'Gisela', 'Doyle', 77, '01271147263', 'zasyvusak@mailinator.com', '$2y$10$a/8VpPUw05.xstQYumnuW.2JZXOtucewbzIQuzwxSzmGUmfL/MCaO', 'default_teacher.png', 1, 3, NULL, '2021-06-19 23:17:29'),
(31, 'Maia', 'Meyer', 50, '01323222123', 'requsivom@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 5, NULL, '2021-06-20 20:33:39'),
(32, 'Sloane', 'Collier', 72, '01135303448', 'keji@mailinator.com', '$2y$10$VZkWeBg6L2LA0uQ1v9ltsuWGMvQSPuEB2FTHZrj1cUK5pqc9AkX9K', 'default_teacher.png', 2, 2, NULL, '2021-06-22 20:22:07'),
(33, 'Dorian', 'Young', 24, '01608548355', 'mubuguma@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 1, NULL, '2021-06-22 20:44:01'),
(34, 'Ferdinand', 'Moses', 50, '01333929565', 'tyhysuf@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 3, NULL, '2021-06-23 10:40:14'),
(35, 'Kimberlyjhgjaaaa', 'Perkins', 75, '01899857768', 'vuko@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 3, NULL, '2021-06-23 20:06:24'),
(36, 'Hectordasdada', 'Wagner', 53, '01844452326', 'fulog@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 1, 2, '2021-06-23 11:40:21'),
(37, 'Carissa', 'Guzman', 14, '01602447375', 'habupor@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 2, NULL, '2021-06-23 13:02:34'),
(38, 'Sybill', 'Solis', 54, '01438581133', 'nesobakik@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 2, NULL, '2021-06-23 13:39:15'),
(39, 'Kasimir', 'Tanner', 31, '01642703971', 'dejun@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 3, NULL, '2021-06-23 13:46:08'),
(40, 'Cassandra', 'Brady', 48, '01811206520', 'dywo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 1, 1, '2021-06-23 13:46:17'),
(41, 'Yen', 'Alvarez', 80, '01921578492', 'lylo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 6, NULL, '2021-06-23 13:47:28'),
(42, 'Channing', 'Calhoun', 3, '01155798347', 'qozoto@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 5, NULL, '2021-06-23 13:51:12'),
(43, 'Hayley', 'Hickman', 51, '01463481551', 'kevaf@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 3, NULL, '2021-06-23 13:53:08'),
(45, 'Forrest', 'Fleming', 0, '01365835160', 'rebi@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 3, NULL, '2021-06-23 14:00:02'),
(46, 'Ulysses', 'Russo', 59, '01726961600', 'xoni@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 6, NULL, '2021-06-23 14:00:15'),
(47, 'Camilla', 'Vazquez', 73, '01201366806', 'ciryzy@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 5, NULL, '2021-06-23 14:04:05'),
(48, 'Germane', 'Hudson', 38, '01511993118', 'lepykamu@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 1, NULL, '2021-06-23 17:41:36'),
(49, 'Emerald', 'Lane', 43, '01824911123', 'syvefaza@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 2, 5, NULL, '2021-06-23 17:42:05'),
(51, 'Blake', 'Christensen', 88, '01104566457', 'vupor@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png', 1, 6, NULL, '2021-06-24 20:26:14'),
(52, 'Griffin', 'Pollard', 32, '01524686559', 'pykub@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 5, NULL, '2021-06-24 20:43:41'),
(53, 'Upton', 'Kelley', 61, '01441887600', 'gyduqemeli@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 1, NULL, '2021-06-24 22:30:16'),
(54, 'Jerry', 'Stein', 69, '01255806746', 'gilulux@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 5, NULL, '2021-06-24 22:32:55'),
(55, 'Aristotle', 'Marquez', 90, '01928216637', 'xokuducyq@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 7, NULL, '2021-06-25 07:02:03'),
(56, 'Kasper', 'Price', 71, '01121506996', 'suropavuw@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 4, 6, '2021-06-25 09:19:23'),
(57, 'Kelly', 'Holmes', 72, '01993871437', 'lijudafe@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 6, NULL, '2021-06-25 13:08:10'),
(58, 'aaaaaaaaaaa', NULL, 33, '01883102862', 'byfisix@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 1, 3, NULL, '2021-06-25 20:02:43'),
(59, 'Patience', 'Whitney', 79, '+1 (298) 534-3388', 'bulo@mailinator.com', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 'default_teacher.png	', 2, 7, NULL, '2021-06-28 14:44:32'),
(60, 'Ahmed Alaa', 'Hassan', 29, '01111339306', 'ph_ahmedalaa@azhar.edu.eg', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', '10522252871624885375.jpeg', 1, 1, 2, '2021-06-28 15:02:55');

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
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses` (`course_id`),
  ADD KEY `users` (`student_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student course` (`student_id`),
  ADD KEY `course course` (`course_id`),
  ADD KEY `subscription status` (`status_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `course course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student course` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription status` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
