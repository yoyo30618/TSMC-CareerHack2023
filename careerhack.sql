-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-02-09 03:43:08
-- 伺服器版本： 10.4.22-MariaDB
-- PHP 版本： 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `careerhack`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE `account` (
  `_ID` int(11) NOT NULL,
  `Account` text COLLATE utf8_bin NOT NULL,
  `Password` text COLLATE utf8_bin NOT NULL,
  `Status` text COLLATE utf8_bin NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `account`
--

INSERT INTO `account` (`_ID`, `Account`, `Password`, `Status`, `IsUsed`) VALUES
(2, 'admin', '123', '管理員', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `blacklist`
--

CREATE TABLE `blacklist` (
  `_ID` int(11) NOT NULL,
  `License` text COLLATE utf8_bin NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Info` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `parkingrecord`
--

CREATE TABLE `parkingrecord` (
  `_ID` int(11) NOT NULL,
  `License` text COLLATE utf8_bin NOT NULL,
  `EnterTime` datetime NOT NULL,
  `LeaveTime` datetime DEFAULT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsIn` double NOT NULL,
  `EnterPhotoPath` text COLLATE utf8_bin NOT NULL,
  `ParkPhotoPath` text COLLATE utf8_bin NOT NULL,
  `LeavePhotoPath` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `parkingrecord`
--

INSERT INTO `parkingrecord` (`_ID`, `License`, `EnterTime`, `LeaveTime`, `SpaceID`, `IsIn`, `EnterPhotoPath`, `ParkPhotoPath`, `LeavePhotoPath`) VALUES
(1, 'YT3039', '2023-02-07 03:11:49', '2023-02-09 03:05:28', 'A11', 0, '', '', ''),
(2, 'YT3039', '2023-02-05 03:11:49', '2023-02-06 03:11:49', '520', 1, '', '', ''),
(3, '123', '2023-02-09 02:20:48', NULL, '', 1, '', '', ''),
(4, '5', '2023-02-09 02:21:08', NULL, '', 1, '4.png', '', ''),
(5, 'YT3039', '2023-02-09 03:06:46', '2023-02-09 03:07:38', 'A38', 0, '4.png', '2.png', '1.png'),
(6, 'YT3039', '2023-02-09 03:09:35', NULL, '', 1, '4.png', '', ''),
(7, 'YT3039', '2023-02-09 03:09:51', NULL, '', 1, '4.png', '', ''),
(8, 'YT3039', '2023-02-09 03:10:27', NULL, '', 1, '4.png', '', ''),
(9, 'YT3039', '2023-02-09 03:12:05', NULL, '', 1, '4.png', '', ''),
(10, 'YT3039', '2023-02-09 03:12:21', NULL, '', 1, '4.png', '', ''),
(11, 'YT3039', '2023-02-09 03:13:10', NULL, '', 1, '4.png', '', ''),
(12, 'YT3039', '2023-02-09 03:14:21', NULL, 'C22', 1, '20230209_031421.', '20230209_032258.png', ''),
(13, 'YT3039', '2023-02-09 03:15:35', '2023-02-09 03:21:28', 'A019', 0, '20230209_031535.png', '', '20230209_032128.png'),
(14, 'YT3039', '2023-02-09 03:15:55', '2023-02-09 03:20:57', 'A020', 0, '20230209_031555.png', '', '20230209_032057.png');

-- --------------------------------------------------------

--
-- 資料表結構 `parkstatusa`
--

CREATE TABLE `parkstatusa` (
  `_ID` int(11) NOT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsVIP` tinyint(1) NOT NULL,
  `IsParked` tinyint(1) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `parkstatusa`
--

INSERT INTO `parkstatusa` (`_ID`, `SpaceID`, `IsVIP`, `IsParked`, `IsUsed`) VALUES
(1, '0', 0, 0, 1),
(2, '1', 0, 0, 1),
(3, '2', 0, 0, 1),
(4, '3', 0, 0, 1),
(5, '4', 0, 0, 1),
(6, '5', 0, 0, 1),
(7, '6', 0, 0, 1),
(8, '7', 0, 0, 1),
(9, '8', 0, 0, 1),
(10, '9', 0, 0, 1),
(11, '10', 0, 0, 1),
(12, '11', 0, 0, 1),
(13, '12', 0, 0, 1),
(14, '13', 0, 0, 1),
(15, '14', 0, 0, 1),
(16, '15', 0, 0, 1),
(17, '16', 0, 0, 1),
(18, '17', 0, 0, 1),
(19, '18', 0, 0, 1),
(20, '19', 0, 0, 1),
(21, '20', 0, 0, 1),
(22, '21', 0, 0, 1),
(23, '22', 0, 0, 1),
(24, '23', 0, 0, 1),
(25, '24', 0, 0, 1),
(26, '25', 0, 0, 1),
(27, '26', 0, 0, 1),
(28, '27', 0, 0, 1),
(29, '28', 0, 0, 1),
(30, '29', 0, 0, 1),
(31, '30', 0, 0, 1),
(32, '31', 0, 0, 1),
(33, '32', 0, 0, 1),
(34, '33', 0, 0, 1),
(35, '34', 0, 0, 1),
(36, '35', 0, 0, 1),
(37, '36', 0, 0, 1),
(38, '37', 0, 0, 1),
(39, '38', 0, 0, 1),
(40, '39', 0, 0, 1),
(41, '40', 0, 0, 1),
(42, '41', 0, 0, 1),
(43, '42', 0, 0, 1),
(44, '43', 0, 0, 1),
(45, '44', 0, 0, 1),
(46, '45', 0, 0, 1),
(47, '46', 0, 0, 1),
(48, '47', 0, 0, 1),
(49, '48', 0, 0, 1),
(50, '49', 0, 0, 1),
(51, '50', 0, 0, 1),
(52, '51', 0, 0, 1),
(53, '52', 0, 0, 1),
(54, '53', 0, 0, 1),
(55, '54', 0, 0, 1),
(56, '55', 0, 0, 1),
(57, '56', 0, 0, 1),
(58, '57', 0, 0, 1),
(59, '58', 0, 0, 1),
(60, '59', 0, 0, 1),
(61, '60', 0, 0, 1),
(62, '61', 0, 0, 1),
(63, '62', 0, 0, 1),
(64, '63', 0, 0, 1),
(65, '64', 0, 0, 1),
(66, '65', 0, 0, 1),
(67, '66', 0, 0, 1),
(68, '67', 0, 0, 1),
(69, '68', 0, 0, 1),
(70, '69', 0, 0, 1),
(71, '70', 0, 0, 1),
(72, '71', 0, 0, 1),
(73, '72', 0, 0, 1),
(74, '73', 0, 0, 1),
(75, '74', 0, 0, 1),
(76, '75', 0, 0, 1),
(77, '76', 0, 0, 1),
(78, '77', 0, 0, 1),
(79, '78', 0, 0, 1),
(80, '79', 0, 0, 1),
(81, '80', 0, 0, 1),
(82, '81', 0, 0, 1),
(83, '82', 0, 0, 1),
(84, '83', 0, 0, 1),
(85, '84', 0, 0, 1),
(86, '85', 0, 0, 1),
(87, '86', 0, 0, 1),
(88, '87', 0, 0, 1),
(89, '88', 0, 0, 1),
(90, '89', 0, 0, 1),
(91, '90', 0, 0, 1),
(92, '91', 0, 0, 1),
(93, '92', 0, 0, 1),
(94, '93', 0, 0, 1),
(95, '94', 0, 0, 1),
(96, '95', 0, 0, 1),
(97, '96', 0, 0, 1),
(98, '97', 0, 0, 1),
(99, '98', 0, 0, 1),
(100, '99', 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `parkstatusb`
--

CREATE TABLE `parkstatusb` (
  `_ID` int(11) NOT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsVIP` tinyint(1) NOT NULL,
  `IsParked` tinyint(1) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `parkstatusb`
--

INSERT INTO `parkstatusb` (`_ID`, `SpaceID`, `IsVIP`, `IsParked`, `IsUsed`) VALUES
(1, '0', 0, 0, 1),
(2, '1', 0, 0, 1),
(3, '2', 0, 0, 1),
(4, '3', 0, 0, 1),
(5, '4', 0, 0, 1),
(6, '5', 0, 0, 1),
(7, '6', 0, 0, 1),
(8, '7', 0, 0, 1),
(9, '8', 0, 0, 1),
(10, '9', 0, 0, 1),
(11, '10', 0, 0, 1),
(12, '11', 0, 0, 1),
(13, '12', 0, 0, 1),
(14, '13', 0, 0, 1),
(15, '14', 0, 0, 1),
(16, '15', 0, 0, 1),
(17, '16', 0, 0, 1),
(18, '17', 0, 0, 1),
(19, '18', 0, 0, 1),
(20, '19', 0, 0, 1),
(21, '20', 0, 0, 1),
(22, '21', 0, 0, 1),
(23, '22', 0, 0, 1),
(24, '23', 0, 0, 1),
(25, '24', 0, 0, 1),
(26, '25', 0, 0, 1),
(27, '26', 0, 0, 1),
(28, '27', 0, 0, 1),
(29, '28', 0, 0, 1),
(30, '29', 0, 0, 1),
(31, '30', 0, 0, 1),
(32, '31', 0, 0, 1),
(33, '32', 0, 0, 1),
(34, '33', 0, 0, 1),
(35, '34', 0, 0, 1),
(36, '35', 0, 0, 1),
(37, '36', 0, 0, 1),
(38, '37', 0, 0, 1),
(39, '38', 0, 0, 1),
(40, '39', 0, 0, 1),
(41, '40', 0, 0, 1),
(42, '41', 0, 0, 1),
(43, '42', 0, 0, 1),
(44, '43', 0, 0, 1),
(45, '44', 0, 0, 1),
(46, '45', 0, 0, 1),
(47, '46', 0, 0, 1),
(48, '47', 0, 0, 1),
(49, '48', 0, 0, 1),
(50, '49', 0, 0, 1),
(51, '50', 0, 0, 1),
(52, '51', 0, 0, 1),
(53, '52', 0, 0, 1),
(54, '53', 0, 0, 1),
(55, '54', 0, 0, 1),
(56, '55', 0, 0, 1),
(57, '56', 0, 0, 1),
(58, '57', 0, 0, 1),
(59, '58', 0, 0, 1),
(60, '59', 0, 0, 1),
(61, '60', 0, 0, 1),
(62, '61', 0, 0, 1),
(63, '62', 0, 0, 1),
(64, '63', 0, 0, 1),
(65, '64', 0, 0, 1),
(66, '65', 0, 0, 1),
(67, '66', 0, 0, 1),
(68, '67', 0, 0, 1),
(69, '68', 0, 0, 1),
(70, '69', 0, 0, 1),
(71, '70', 0, 0, 1),
(72, '71', 0, 0, 1),
(73, '72', 0, 0, 1),
(74, '73', 0, 0, 1),
(75, '74', 0, 0, 1),
(76, '75', 0, 0, 1),
(77, '76', 0, 0, 1),
(78, '77', 0, 0, 1),
(79, '78', 0, 0, 1),
(80, '79', 0, 0, 1),
(81, '80', 0, 0, 1),
(82, '81', 0, 0, 1),
(83, '82', 0, 0, 1),
(84, '83', 0, 0, 1),
(85, '84', 0, 0, 1),
(86, '85', 0, 0, 1),
(87, '86', 0, 0, 1),
(88, '87', 0, 0, 1),
(89, '88', 0, 0, 1),
(90, '89', 0, 0, 1),
(91, '90', 0, 0, 1),
(92, '91', 0, 0, 1),
(93, '92', 0, 0, 1),
(94, '93', 0, 0, 1),
(95, '94', 0, 0, 1),
(96, '95', 0, 0, 1),
(97, '96', 0, 0, 1),
(98, '97', 0, 0, 1),
(99, '98', 0, 0, 1),
(100, '99', 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `parkstatusc`
--

CREATE TABLE `parkstatusc` (
  `_ID` int(11) NOT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsVIP` tinyint(1) NOT NULL,
  `IsParked` tinyint(1) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `parkstatusc`
--

INSERT INTO `parkstatusc` (`_ID`, `SpaceID`, `IsVIP`, `IsParked`, `IsUsed`) VALUES
(1, '0', 0, 0, 1),
(2, '1', 0, 0, 1),
(3, '2', 0, 0, 1),
(4, '3', 0, 0, 1),
(5, '4', 0, 0, 1),
(6, '5', 0, 0, 1),
(7, '6', 0, 0, 1),
(8, '7', 0, 0, 1),
(9, '8', 0, 0, 1),
(10, '9', 0, 0, 1),
(11, '10', 0, 0, 1),
(12, '11', 0, 0, 1),
(13, '12', 0, 0, 1),
(14, '13', 0, 0, 1),
(15, '14', 0, 0, 1),
(16, '15', 0, 0, 1),
(17, '16', 0, 0, 1),
(18, '17', 0, 0, 1),
(19, '18', 0, 0, 1),
(20, '19', 0, 0, 1),
(21, '20', 0, 0, 1),
(22, '21', 0, 0, 1),
(23, '22', 0, 1, 1),
(24, '23', 0, 0, 1),
(25, '24', 0, 0, 1),
(26, '25', 0, 0, 1),
(27, '26', 0, 0, 1),
(28, '27', 0, 0, 1),
(29, '28', 0, 0, 1),
(30, '29', 0, 0, 1),
(31, '30', 0, 0, 1),
(32, '31', 0, 0, 1),
(33, '32', 0, 0, 1),
(34, '33', 0, 0, 1),
(35, '34', 0, 0, 1),
(36, '35', 0, 0, 1),
(37, '36', 0, 0, 1),
(38, '37', 0, 0, 1),
(39, '38', 0, 0, 1),
(40, '39', 0, 0, 1),
(41, '40', 0, 0, 1),
(42, '41', 0, 0, 1),
(43, '42', 0, 0, 1),
(44, '43', 0, 0, 1),
(45, '44', 0, 0, 1),
(46, '45', 0, 0, 1),
(47, '46', 0, 0, 1),
(48, '47', 0, 0, 1),
(49, '48', 0, 0, 1),
(50, '49', 0, 0, 1),
(51, '50', 0, 0, 1),
(52, '51', 0, 0, 1),
(53, '52', 0, 0, 1),
(54, '53', 0, 0, 1),
(55, '54', 0, 0, 1),
(56, '55', 0, 0, 1),
(57, '56', 0, 0, 1),
(58, '57', 0, 0, 1),
(59, '58', 0, 0, 1),
(60, '59', 0, 0, 1),
(61, '60', 0, 0, 1),
(62, '61', 0, 0, 1),
(63, '62', 0, 0, 1),
(64, '63', 0, 0, 1),
(65, '64', 0, 0, 1),
(66, '65', 0, 0, 1),
(67, '66', 0, 0, 1),
(68, '67', 0, 0, 1),
(69, '68', 0, 0, 1),
(70, '69', 0, 0, 1),
(71, '70', 0, 0, 1),
(72, '71', 0, 0, 1),
(73, '72', 0, 0, 1),
(74, '73', 0, 0, 1),
(75, '74', 0, 0, 1),
(76, '75', 0, 0, 1),
(77, '76', 0, 0, 1),
(78, '77', 0, 0, 1),
(79, '78', 0, 0, 1),
(80, '79', 0, 0, 1),
(81, '80', 0, 0, 1),
(82, '81', 0, 0, 1),
(83, '82', 0, 0, 1),
(84, '83', 0, 0, 1),
(85, '84', 0, 0, 1),
(86, '85', 0, 0, 1),
(87, '86', 0, 0, 1),
(88, '87', 0, 0, 1),
(89, '88', 0, 0, 1),
(90, '89', 0, 0, 1),
(91, '90', 0, 0, 1),
(92, '91', 0, 0, 1),
(93, '92', 0, 0, 1),
(94, '93', 0, 0, 1),
(95, '94', 0, 0, 1),
(96, '95', 0, 0, 1),
(97, '96', 0, 0, 1),
(98, '97', 0, 0, 1),
(99, '98', 0, 0, 1),
(100, '99', 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `parkstatusd`
--

CREATE TABLE `parkstatusd` (
  `_ID` int(11) NOT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsVIP` tinyint(1) NOT NULL,
  `IsParked` tinyint(1) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `parkstatusd`
--

INSERT INTO `parkstatusd` (`_ID`, `SpaceID`, `IsVIP`, `IsParked`, `IsUsed`) VALUES
(1, '0', 0, 0, 1),
(2, '1', 0, 0, 1),
(3, '2', 0, 0, 1),
(4, '3', 0, 0, 1),
(5, '4', 0, 0, 1),
(6, '5', 0, 0, 1),
(7, '6', 0, 0, 1),
(8, '7', 0, 0, 1),
(9, '8', 0, 0, 1),
(10, '9', 0, 0, 1),
(11, '10', 0, 0, 1),
(12, '11', 0, 0, 1),
(13, '12', 0, 0, 1),
(14, '13', 0, 0, 1),
(15, '14', 0, 0, 1),
(16, '15', 0, 0, 1),
(17, '16', 0, 0, 1),
(18, '17', 0, 0, 1),
(19, '18', 0, 0, 1),
(20, '19', 0, 0, 1),
(21, '20', 0, 0, 1),
(22, '21', 0, 0, 1),
(23, '22', 0, 0, 1),
(24, '23', 0, 0, 1),
(25, '24', 0, 0, 1),
(26, '25', 0, 0, 1),
(27, '26', 0, 0, 1),
(28, '27', 0, 0, 1),
(29, '28', 0, 0, 1),
(30, '29', 0, 0, 1),
(31, '30', 0, 0, 1),
(32, '31', 0, 0, 1),
(33, '32', 0, 0, 1),
(34, '33', 0, 0, 1),
(35, '34', 0, 0, 1),
(36, '35', 0, 0, 1),
(37, '36', 0, 0, 1),
(38, '37', 0, 0, 1),
(39, '38', 0, 0, 1),
(40, '39', 0, 0, 1),
(41, '40', 0, 0, 1),
(42, '41', 0, 0, 1),
(43, '42', 0, 0, 1),
(44, '43', 0, 0, 1),
(45, '44', 0, 0, 1),
(46, '45', 0, 0, 1),
(47, '46', 0, 0, 1),
(48, '47', 0, 0, 1),
(49, '48', 0, 0, 1),
(50, '49', 0, 0, 1),
(51, '50', 0, 0, 1),
(52, '51', 0, 0, 1),
(53, '52', 0, 0, 1),
(54, '53', 0, 0, 1),
(55, '54', 0, 0, 1),
(56, '55', 0, 0, 1),
(57, '56', 0, 0, 1),
(58, '57', 0, 0, 1),
(59, '58', 0, 0, 1),
(60, '59', 0, 0, 1),
(61, '60', 0, 0, 1),
(62, '61', 0, 0, 1),
(63, '62', 0, 0, 1),
(64, '63', 0, 0, 1),
(65, '64', 0, 0, 1),
(66, '65', 0, 0, 1),
(67, '66', 0, 0, 1),
(68, '67', 0, 0, 1),
(69, '68', 0, 0, 1),
(70, '69', 0, 0, 1),
(71, '70', 0, 0, 1),
(72, '71', 0, 0, 1),
(73, '72', 0, 0, 1),
(74, '73', 0, 0, 1),
(75, '74', 0, 0, 1),
(76, '75', 0, 0, 1),
(77, '76', 0, 0, 1),
(78, '77', 0, 0, 1),
(79, '78', 0, 0, 1),
(80, '79', 0, 0, 1),
(81, '80', 0, 0, 1),
(82, '81', 0, 0, 1),
(83, '82', 0, 0, 1),
(84, '83', 0, 0, 1),
(85, '84', 0, 0, 1),
(86, '85', 0, 0, 1),
(87, '86', 0, 0, 1),
(88, '87', 0, 0, 1),
(89, '88', 0, 0, 1),
(90, '89', 0, 0, 1),
(91, '90', 0, 0, 1),
(92, '91', 0, 0, 1),
(93, '92', 0, 0, 1),
(94, '93', 0, 0, 1),
(95, '94', 0, 0, 1),
(96, '95', 0, 0, 1),
(97, '96', 0, 0, 1),
(98, '97', 0, 0, 1),
(99, '98', 0, 0, 1),
(100, '99', 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `person`
--

CREATE TABLE `person` (
  `_ID` int(11) NOT NULL,
  `Name` text COLLATE utf8_bin NOT NULL,
  `Cname` text COLLATE utf8_bin NOT NULL,
  `Department` text COLLATE utf8_bin NOT NULL,
  `Job` text COLLATE utf8_bin NOT NULL,
  `License` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `person`
--

INSERT INTO `person` (`_ID`, `Name`, `Cname`, `Department`, `Job`, `License`) VALUES
(1, 'BearBear', '熊熊', '資訊工程學系', '學生', 'YT3039'),
(4, '12', '23', '34', '45', '56');

-- --------------------------------------------------------

--
-- 資料表結構 `vip`
--

CREATE TABLE `vip` (
  `_ID` int(11) NOT NULL,
  `License` text COLLATE utf8_bin NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `SpaceID` text COLLATE utf8_bin NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `vip`
--

INSERT INTO `vip` (`_ID`, `License`, `StartTime`, `EndTime`, `SpaceID`, `IsUsed`) VALUES
(1, 'YT3039', '2023-02-08 15:14:00', '2023-02-23 15:14:00', 'A20', 1),
(2, '123', '2023-02-06 15:27:00', '2023-02-07 15:27:00', 'A20', 1),
(3, '123', '2023-02-08 15:29:00', '2023-02-09 15:29:00', 'A29', 1),
(4, '123', '2023-02-01 16:09:00', '2023-02-10 16:09:00', 'A15', 1),
(5, '123', '2023-02-01 16:49:00', '2023-02-02 16:49:00', '', 1),
(6, 'FDS', '2023-02-08 21:42:00', '2023-02-09 21:42:00', 'A52', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `whitelist`
--

CREATE TABLE `whitelist` (
  `_ID` int(11) NOT NULL,
  `License` text COLLATE utf8_bin NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Info` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `parkingrecord`
--
ALTER TABLE `parkingrecord`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `parkstatusa`
--
ALTER TABLE `parkstatusa`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `parkstatusb`
--
ALTER TABLE `parkstatusb`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `parkstatusc`
--
ALTER TABLE `parkstatusc`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `parkstatusd`
--
ALTER TABLE `parkstatusd`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `vip`
--
ALTER TABLE `vip`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`_ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `account`
--
ALTER TABLE `account`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `parkingrecord`
--
ALTER TABLE `parkingrecord`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `parkstatusa`
--
ALTER TABLE `parkstatusa`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `parkstatusb`
--
ALTER TABLE `parkstatusb`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `parkstatusc`
--
ALTER TABLE `parkstatusc`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `parkstatusd`
--
ALTER TABLE `parkstatusd`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `person`
--
ALTER TABLE `person`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vip`
--
ALTER TABLE `vip`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
