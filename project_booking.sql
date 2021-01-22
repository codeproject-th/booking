-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2021 at 10:07 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_type` varchar(255) NOT NULL,
  `bank_number` varchar(255) NOT NULL,
  `bank_acc` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='ธนาคาร';

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `bank_type`, `bank_number`, `bank_acc`) VALUES
(1, 'กสิกรไทย', 'ออมทรัพย์', '111-222-333', 'Tese');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(11) NOT NULL,
  `room_type_id` int(5) NOT NULL COMMENT 'ประเภทห้อง',
  `member_id` int(5) NOT NULL COMMENT 'หมายเลขสมาชิก',
  `booking_in_date` datetime NOT NULL COMMENT 'วันที่เข้าพัก',
  `booking_out_date` datetime NOT NULL COMMENT 'วันที่ออก',
  `booking_room_number` int(5) NOT NULL COMMENT 'จำนวนห้องที่จอง',
  `booking_amount` int(5) NOT NULL COMMENT 'นวนเงินทั้งหมด',
  `booking_cash_pledge` int(5) NOT NULL COMMENT 'เงินมัดจำ',
  `booking_status` int(1) NOT NULL COMMENT 'สถานะการจอง',
  `booking_date` datetime NOT NULL COMMENT 'วันที่จอง'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='จอง';

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `room_type_id`, `member_id`, `booking_in_date`, `booking_out_date`, `booking_room_number`, `booking_amount`, `booking_cash_pledge`, `booking_status`, `booking_date`) VALUES
(1, 3, 1, '2017-10-05 12:00:00', '2017-10-07 11:00:00', 1, 1600, 600, 1, '2017-10-07 23:48:48'),
(6, 3, 1, '2017-10-08 12:00:00', '2017-10-09 11:00:00', 1, 1600, 600, 1, '2017-10-08 11:35:59'),
(8, 3, 1, '2017-10-08 12:00:00', '2017-10-09 11:00:00', 1, 1600, 600, 1, '2017-10-08 11:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `booking_room`
--

CREATE TABLE IF NOT EXISTS `booking_room` (
  `booking_room_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_room_start_date` datetime NOT NULL,
  `booking_room_end_date` datetime NOT NULL,
  `booking_room_status` int(1) NOT NULL COMMENT '0=จอง 1=จ่ายเงิน 2=ยกเลิก'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='ข้อมูลการจองห้อง';

--
-- Dumping data for table `booking_room`
--

INSERT INTO `booking_room` (`booking_room_id`, `booking_id`, `room_id`, `booking_room_start_date`, `booking_room_end_date`, `booking_room_status`) VALUES
(11, 1, 4, '2017-10-05 12:00:00', '2017-10-07 11:00:00', 1),
(14, 6, 3, '2017-10-08 12:00:00', '2017-10-09 11:00:00', 1),
(18, 9, 2, '2017-10-12 12:00:00', '2017-10-13 11:00:00', 0),
(17, 8, 4, '2017-10-08 12:00:00', '2017-10-09 11:00:00', 1),
(19, 11, 2, '2017-11-28 12:00:00', '2017-11-30 11:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `confirm_payment`
--

CREATE TABLE IF NOT EXISTS `confirm_payment` (
  `confirm_payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `bank_id` int(5) NOT NULL,
  `price` varchar(100) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `time` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `confirm_payment_date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(11) NOT NULL,
  `content_data` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='วิธีการจอง';

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_data`) VALUES
(1, '<p>bbbkkk</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `member_id` int(11) NOT NULL,
  `member_full_name` varchar(255) NOT NULL,
  `member_tel` varchar(255) NOT NULL,
  `member_password` varchar(100) NOT NULL,
  `member_email` varchar(200) NOT NULL,
  `member_img` varchar(100) NOT NULL,
  `id_card` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `province` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='สมาชิก';

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_full_name`, `member_tel`, `member_password`, `member_email`, `member_img`, `id_card`, `address`, `province`, `tel`) VALUES
(1, 'อำพล เทียมนุช', '', 'amphol', 'amphol@gmail.com', '', '1101800254633', 'xxx', 'นครปฐม', '0899999991'),
(3, '1111111', '', '11111', 'aaa@aaac.com', '', '1111111111111', '111111111', '11111111', '1111111111'),
(4, 'zzzz', '', 'qqqqq', 'qqq@aaa.com', '', '1101800254633', 'xx', 'xx', '0899999990');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int(11) NOT NULL,
  `room_type_id` int(5) NOT NULL COMMENT 'ประเภทห้อง',
  `room_name` varchar(255) NOT NULL COMMENT 'ชื่อห้อง',
  `room_code` varchar(100) NOT NULL COMMENT 'หมายเลขห้อง',
  `room_detail` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='หมายเลขห้อง';

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_type_id`, `room_name`, `room_code`, `room_detail`) VALUES
(1, 1, 'ห้อง1', '10001', 'ทดสอบ'),
(2, 4, 'ห้อง2', '10002', ''),
(3, 3, 'ห้อง3', '10003', ''),
(4, 3, 'ห้อง4', '10004', '');

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE IF NOT EXISTS `room_type` (
  `room_type_id` int(11) NOT NULL,
  `room_type_name` text NOT NULL,
  `room_type_people` int(5) NOT NULL COMMENT 'จำนวนคนที่เข้าพักได้',
  `room_type_detail` text NOT NULL,
  `room_type_price` int(10) NOT NULL,
  `room_type_deposit` int(10) NOT NULL COMMENT 'ค่ามัดจำ',
  `room_type_img1` varchar(100) DEFAULT NULL,
  `room_type_img2` varchar(100) DEFAULT NULL,
  `room_type_img3` varchar(100) DEFAULT NULL,
  `room_type_img4` varchar(100) DEFAULT NULL,
  `room_type_img5` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='ห้องพัก';

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`room_type_id`, `room_type_name`, `room_type_people`, `room_type_detail`, `room_type_price`, `room_type_deposit`, `room_type_img1`, `room_type_img2`, `room_type_img3`, `room_type_img4`, `room_type_img5`) VALUES
(1, 'Superior', 2, 'Superior test', 850, 300, '00001-1.jpg', '', '', '', ''),
(4, 'Panorama', 2, '', 2000, 1000, '00004-1.jpg', '00004-2.jpg', '00004-3.jpg', '', ''),
(3, 'Deluxe', 2, '', 1600, 600, '00003-1.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `slider_id` int(11) NOT NULL,
  `slider_no` int(11) NOT NULL,
  `slider_img` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_no`, `slider_img`) VALUES
(1, 1, '00001.jpg'),
(2, 2, '00002.jpg'),
(3, 3, ''),
(4, 4, ''),
(5, 5, ''),
(6, 6, ''),
(7, 7, ''),
(8, 8, ''),
(9, 9, ''),
(10, 10, ''),
(11, 11, ''),
(12, 12, ''),
(13, 13, ''),
(14, 14, ''),
(15, 15, ''),
(16, 16, ''),
(17, 17, ''),
(18, 18, ''),
(19, 19, ''),
(20, 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL,
  `users_name` varchar(100) NOT NULL,
  `users_pass` varchar(50) NOT NULL,
  `users_firstname` varchar(100) NOT NULL,
  `users_lastname` varchar(100) NOT NULL,
  `users_type` int(1) NOT NULL COMMENT '1=admin 2=user'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='ผู้ใช้งาน';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_name`, `users_pass`, `users_firstname`, `users_lastname`, `users_type`) VALUES
(1, 'admin', 'admin', 'Admin', 'Super', 1),
(2, 'test', 'test', 'tesr', 'testh', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD PRIMARY KEY (`booking_room_id`);

--
-- Indexes for table `confirm_payment`
--
ALTER TABLE `confirm_payment`
  ADD PRIMARY KEY (`confirm_payment_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `booking_room`
--
ALTER TABLE `booking_room`
  MODIFY `booking_room_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `confirm_payment`
--
ALTER TABLE `confirm_payment`
  MODIFY `confirm_payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
