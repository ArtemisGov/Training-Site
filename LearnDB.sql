-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2018 at 02:19 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rs`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `id` int(11) NOT NULL,
  `usrid` int(11) NOT NULL,
  `realUsername` varchar(20) NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL,
  `reqUsername` varchar(20) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `sessionID` varchar(128) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`id`, `usrid`, `realUsername`, `timestamps`, `ip`, `reqUsername`, `success`, `sessionID`, `type`) VALUES
(1, 1, 'wombat2', '2018-11-16 15:29:33', '::1', 'wombat2', 1, '$2y$10$lXrld5bZTry.an4YpneAI.29/GM89pFYhjRubUmEqbz5837At.VJG', 'login'),
(2, 1, '', '2018-11-16 15:30:59', '', '', 0, '', 'group'),
(3, 1, '', '2018-11-16 15:39:15', '', '', 0, '', 'group'),
(4, 1, '', '2018-11-16 15:47:57', '', '', 0, '', 'group'),
(5, 1, '', '2018-11-16 15:49:05', '', '', 0, '', 'group'),
(6, 1, '', '2018-11-16 15:49:18', '', '', 0, '', 'group'),
(7, 1, '', '2018-11-16 15:50:08', '', '', 0, '', 'group'),
(8, 1, '', '2018-11-16 15:50:24', '', '', 0, '', 'group'),
(9, 1, '', '2018-11-16 15:50:41', '', '', 0, '', 'group'),
(10, 0, '', '2018-11-16 15:51:11', '', '', 0, '', 'group'),
(11, 1, '', '2018-11-16 15:51:31', '', '', 0, '', 'group'),
(12, 1, '', '2018-11-16 16:23:58', '', '', 0, '', 'group'),
(13, 1, '', '2018-11-16 21:43:54', '', '', 0, '', 'group'),
(14, 1, 'wombat2', '2018-11-16 21:49:27', '::1', 'wombat2', 1, '$2y$10$D.R7ttpI.JxNaIcfnXrEruKfdVs.JwyDypxOy4qvCIHapU.fOPbyW', 'login'),
(15, 1, '', '2018-11-16 21:49:34', '', '', 0, '', 'group'),
(16, 1, 'wombat2', '2018-11-19 19:38:27', '::1', 'wombat2', 1, '$2y$10$vIpoaDojy0vh5rWJnXMeZeuC3NbLX/82mT8lB4BxMNNRM5HuocNBW', 'login'),
(17, 1, '', '2018-11-19 19:38:41', '', '', 0, '', 'group'),
(18, 1, '', '2018-11-19 20:32:30', '', '', 0, '', 'group'),
(19, 1, 'wombat2', '2018-11-30 22:28:28', '::1', 'wombat2', 1, '$2y$10$7/pbjWlbIJPFMU6.9CBZ3OCsaUeflaW5I.TopetBkCMYTPzZ1rRDS', 'login'),
(20, 1, '', '2018-12-02 02:48:20', '', '', 0, '', 'group'),
(21, 1, 'wombat2', '2018-12-16 01:02:00', '::1', 'wombat2', 1, '$2y$10$NQKxm3IRMZZIKnrhgI1Gru4O8TeEGy09cknABQAvcSyAHbCbBw3e6', 'login'),
(22, 1, '', '2018-12-16 01:02:05', '', '', 0, '', 'group');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `catnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `course`, `creator`, `name`, `description`, `catnum`) VALUES
(1, 1, 1, NULL, NULL, 1),
(2, 2, 1, NULL, NULL, 1),
(3, 3, 0, NULL, NULL, 1),
(4, 4, 1, NULL, NULL, 1),
(5, 5, 1, 'sss', '111', 1),
(6, 6, 1, NULL, NULL, 1),
(7, 7, 1, NULL, NULL, 1),
(8, 5, 1, NULL, NULL, 2),
(9, 5, 1, NULL, NULL, 3),
(10, 5, 1, NULL, NULL, 4),
(11, 10, 1, NULL, NULL, 1),
(12, 11, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(150) NOT NULL,
  `creator` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `description`, `creator`, `type`, `status`, `timedate`) VALUES
(4, '', '1', 1, '', 1, '2018-11-19 19:59:33'),
(5, 'cdddf', '1', 1, 'code', 1, '2018-11-19 20:32:15'),
(6, '', '1', 1, 'writing', 1, '2018-11-19 19:59:41'),
(7, '', '1', 1, 'art', 3, '2018-11-19 20:37:33'),
(8, '', '1', 3, 'art', 3, '2018-11-19 20:37:33'),
(9, '', '1', 2, 'writing', 1, '2018-11-19 19:59:41'),
(10, '', '1', 1, '', 1, '2018-12-02 02:48:20'),
(11, '', '1', 1, '', 1, '2018-12-16 01:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `coursegroups`
--

CREATE TABLE `coursegroups` (
  `id` int(11) NOT NULL,
  `usrid` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `id`
--

CREATE TABLE `id` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `xaxis` int(11) NOT NULL,
  `yaxis` int(11) NOT NULL,
  `text` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE `keywords` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `keyword` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `course`, `groupID`, `class`, `name`, `type`) VALUES
(1, 10, 1, 0, 'default page', 1),
(2, 11, 1, 0, 'default page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usercourses`
--

CREATE TABLE `usercourses` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastOpened` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usercourses`
--

INSERT INTO `usercourses` (`id`, `user`, `course`, `dateAdded`, `lastOpened`) VALUES
(1, 1, 1, '2018-11-16 15:30:59', '2018-11-16 15:30:59'),
(2, 1, 2, '2018-11-16 15:39:15', '2018-11-16 15:39:15'),
(3, 0, 3, '2018-11-16 15:51:11', '2018-11-16 15:51:11'),
(4, 1, 4, '2018-11-16 21:43:54', '2018-11-16 21:43:54'),
(5, 1, 5, '2018-11-16 21:49:34', '2018-11-16 21:49:34'),
(6, 1, 6, '2018-11-19 19:38:42', '2018-11-19 19:38:42'),
(7, 1, 7, '2018-11-19 20:32:31', '2018-11-19 20:32:31'),
(8, 1, 10, '2018-12-02 02:48:20', '2018-12-02 02:48:20'),
(9, 1, 11, '2018-12-16 01:02:05', '2018-12-16 01:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `usrid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `age` tinyint(2) NOT NULL,
  `languages` varchar(40) NOT NULL,
  `oldname` varchar(70) NOT NULL,
  `timezone` char(2) NOT NULL,
  `profilePicture` int(11) NOT NULL,
  `wallpaper` varchar(128) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(400) NOT NULL,
  `email` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `confirmation` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`usrid`, `username`, `joindate`, `age`, `languages`, `oldname`, `timezone`, `profilePicture`, `wallpaper`, `dateAdded`, `password`, `email`, `active`, `confirmation`) VALUES
(1, 'wombat2', '2018-11-16 15:29:15', 0, '', '', '', 0, '', '2018-11-16 15:20:13', '$01$y2$GXvA9cGv0fKxik9OrU5kNxauiVmfaOG.eiJUKf2P2.6pa3UWbJR2B$01$y2$', 'wombat2ñªwombat.com', 1, '8aloUXiEmsmlDoqX7EVK0X7QHf2lwnFGvXKa7K7BUkBY9PZuAcSVr9bQiq1gzhH1QiGycMIbtJ2V5gPCoWXzzQaSTlQAory8NMwg2HIEIBq3Yu51BTDIcof6jVit13q74');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coursegroups`
--
ALTER TABLE `coursegroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id`
--
ALTER TABLE `id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercourses`
--
ALTER TABLE `usercourses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`usrid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coursegroups`
--
ALTER TABLE `coursegroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id`
--
ALTER TABLE `id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keywords`
--
ALTER TABLE `keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usercourses`
--
ALTER TABLE `usercourses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `usrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
