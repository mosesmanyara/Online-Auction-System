-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2022 at 07:39 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse480`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(15) NOT NULL,
  `country` varchar(15) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `user_name`, `email`, `password`, `address`, `city`, `country`, `country_code`, `gender`, `dob`, `age`) VALUES
(1, 'MosesManyara', 'osoromoses06@gmail.com', '1234567asdfghjklzxcvbnm', 'Nairobi,Kenya', 'Nairobi', 'Kenya', '254', 'male', '1996-01-28', 24);

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE `bid` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`product_id`, `user_id`, `amount`, `time`) VALUES
(18, 10004, '29.99', '2021-01-07 23:28:03'),
(22, 10004, '2450.00', '2021-01-07 23:28:25'),
(23, 10004, '699.99', '2021-01-07 23:28:32'),
(24, 10004, '497.07', '2021-01-07 23:28:42'),
(29, 10008, '29.99', '2022-10-16 19:20:30'),
(29, 10008, '30.99', '2022-10-16 19:47:46'),
(30, 10009, '739.00', '2022-10-16 19:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `product_id` int(11) NOT NULL,
  `end_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `duration`
--

INSERT INTO `duration` (`product_id`, `end_date`) VALUES
(18, '2021-01-11 04:28:03'),
(22, '2021-01-11 04:28:25'),
(23, '2021-01-11 04:28:32'),
(24, '2021-01-11 04:28:42'),
(25, '2021-01-11 04:55:25'),
(26, '2022-10-19 19:04:27'),
(29, '2022-10-19 19:20:30'),
(30, '2022-10-19 19:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `base_price` decimal(6,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `image1` varchar(30) NOT NULL,
  `image2` varchar(30) NOT NULL,
  `image3` varchar(30) NOT NULL,
  `description1` varchar(1000) NOT NULL,
  `description2` varchar(1000) NOT NULL,
  `description3` varchar(1000) NOT NULL,
  `description4` varchar(1000) NOT NULL,
  `description5` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `base_price`, `duration`, `image1`, `image2`, `image3`, `description1`, `description2`, `description3`, `description4`, `description5`) VALUES
(18, 'YI Home Camera', '29.99', 3, '1610059958a.jpg', '1610059958b.jpg', '1610059958c.jpg', 'Wi-fi IP indoor security system with motion detection, night vision for baby / pet / front porch mon', 'Records in 720p HD to capture clear images for your records and while using 2-way audio (built-in mi', '111 degree wide-angle lens, 940nm infrared non-invasive sensor, 4x digital zoom. Capture the scene i', 'Built-in support for 802.11b/g/n 2.4Ghz (5Ghz currently not supported) WIFI band. Reliable Wi-Fi con', 'Real-time streaming to your phone & activity alerts when motion is detected. YI Home App allows you '),
(22, 'Dell Precision 5540 Mobile Workstation', '2450.00', 3, '1610061158a.jpg', '1610061158b.jpg', '1610061158c.jpg', 'Dell 15.6 inch Precision 5540 Mobile Workstation - Platinum Silver', '15.6 inch Ultrasharp UHD (3840 x 2160) IGZO4 100% Adobe Touch Display, HD Camera', '16GB, 2X8G, DDR4 2666MHz - M.2 512GB PCIe NVMe Class 40 Solid State Drive', 'Intel (R) Core (TM) Processor i7-9850H,(6 Core, 12M Cache, 2 .60GHz up to 4.6GHz Turbo, 45W , vPro)', 'Nvidia Quadro T2000 w/4GB GDDR 5 - WINDOWS 10 PRO'),
(23, 'Samsung Galaxy S20 FE 5G', '699.99', 3, '1610061213a.jpg', '1610061213b.jpg', '1610061213c.jpg', 'Pro-Grade Camera: The new Samsung Galaxy S20 FE mobile phone features high-powered pro lenses for beautiful portraits, stunning landscapes and crisp close-ups in any light with its 3X optical zoom', '30X Space Zoom: Whether you want your cellphone to zoom in close from afar or magnify details of something nearby, 30X Space Zoom gives you the power to get closer', 'Night Mode: Capture crisp images and vibrant video with Night Mode and create high-quality content in low light — no flash required with this smartphone', 'Single-Take AI: One tap of the screen captures multiple images and video all at once; Lenses, effects and filters capture the best of every moment, every time', 'Power of 5G: Get next-level power for everything you love to do with Samsung Galaxy 5G; More sharing, more gaming, more experiences and never miss a beat'),
(24, 'Motorola Edge Solor Black', '497.07', 3, '1610061459a.jpg', '1610061459b.jpg', '1610061459c.jpg', 'Modern Design - Elegant square shade table lamp, perfect for your desk, living room, or bedside table. Upgrade the look of your space today!', 'Wireless Phone Charging Pad - Wireless charging pad integrated into the lamp base allowing you to declutter your desk or table! Simply place your phone on top of the front of the lamp base and to wirelessly charge your phone!', 'USB Charging Port - Along with the integrated wireless charging pad, there is also a USB charging port located on the back of the lamp base! (USB Charging cable and phone not included).', 'Wireless Charging Base is large enough to easily fit phones with up to 6.5” screen size. Compatible with any wireless charging (Qi standard) phone including iPhone 8 and newer, Samsung Galaxy S7 and newer, and many other phones!', 'Rated for 60W Max light bulb (bulb not included).'),
(25, 'Bedroom Lamp', '41.98', 3, '1610061580a.jpg', '1610061580b.jpg', '1610061580c.jpg', 'Modern Design - Elegant square shade table lamp, perfect for your desk, living room, or bedside table. Upgrade the look of your space today!', 'Wireless Phone Charging Pad - Wireless charging pad integrated into the lamp base allowing you to declutter your desk or table! Simply place your phone on top of the front of the lamp base and to wirelessly charge your phone!', 'USB Charging Port - Along with the integrated wireless charging pad, there is also a USB charging port located on the back of the lamp base! (USB Charging cable and phone not included).', 'Wireless Charging Base is large enough to easily fit phones with up to 6.5” screen size. Compatible with any wireless charging (Qi standard) phone including iPhone 8 and newer, Samsung Galaxy S7 and newer, and many other phones!', 'Rated for 60W Max light bulb (bulb not included).'),
(26, 'Xbox One S 1TB Console', '399.00', 3, '1610062308a.jpg', '1610062308b.jpg', '1610062308c.jpg', 'Previous generation bundle includes: Xbox One S 1TB console, one Xbox Wireless Controller (with 3.5mm headset jack), HDMI cable (4K Capable), AC Power cable. 1 Month Xbox Game Pass trial, 14 Day Xbox Live Gold trial', 'Play over 2,200 games including more than 200 exclusives and over 600 classics from Xbox 360 and Original Xbox. (Games sold separately.)', 'Play with friends and family near and far sitting together on the sofa or around the world on Xbox Live, the fastest, most reliable gaming network', 'Xbox One family settings let you choose privacy, screen time, and content limits for each member of the family.', 'Watch 4K Blu ray movies; stream 4K video on Netflix, Amazon, and YouTube, among others; and listen to music with Spotify'),
(29, 'YI Home Camera', '29.99', 3, '1665937157a.jpg', '1665937157b.jpg', '1665937157c.jpg', 'Wi-fi IP indoor security system with motion detection, night vision for baby / pet / front porch monitor, remote control with iOS, Andriod, PC app - cloud service availabe.', 'Records in 720p HD to capture clear images for your records and while using 2-way audio (built-in microphone and speaker). 720P/20FPS,700Kbps; 360P/20FPS,200Kbps.', '111 degree wide-angle lens, 940nm infrared non-invasive sensor, 4x digital zoom. Capture the scene in clarity with the wide-angle lens and zoom capabilities. The non-invasive sensor will not disturb your sleeping children.', 'Built-in support for 802.11b/g/n 2.4Ghz (5Ghz currently not supported) WIFI band. Reliable Wi-Fi connectivity to access your camera with YI Home App on mobile device, and YI Home App on PC at anytime, anywhere.', 'Real-time streaming to your phone &amp; activity alerts when motion is detected. YI Home App allows you to customize your settings according to your preferences: defined activity regions, camera sharing, customize alert schedules, and more. Available for iOS and Android.'),
(30, 'Acer Nitro 5 Gaming Laptop', '739.00', 3, '1665939383a.jpg', '1665939383b.jpg', '1665939383c.jpg', '7th Generation Intel Core i5-7200U Processor (Up to 3.1GHz)', '15.6&quot; Full HD Widescreen Comfy View LED-backlit Display supporting Acer Color Blast technology', 'NVIDIA GeForce 940MX with 2GB of GDDR5 Video Memory', '8GB DDR4 Memory, 256GB SSD,Card Reader:SD Card', 'Up to 12-hours Battery Life');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category`) VALUES
(18, 'Camera'),
(22, 'Laptop'),
(23, 'Mobile'),
(24, 'Mobile'),
(25, 'Lamp'),
(26, 'Electronics'),
(29, 'Camera'),
(30, 'Electronics');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE `product_status` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`product_id`, `user_id`, `status`) VALUES
(18, 10004, 'closed'),
(22, 10004, 'closed'),
(23, 10004, 'closed'),
(24, 10004, 'closed'),
(29, 10008, 'ongoing'),
(30, 10009, 'ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(15) NOT NULL,
  `country` varchar(15) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `password`, `address`, `city`, `country`, `country_code`, `gender`, `dob`, `age`) VALUES
(10004, 'Kevin', 'a@gmail.com', '$2y$10$lWv5778txTesyXtXRZdwRu0qwxNO.CySEjduyRv2T6dWtBLpuefR.', 'Nairobi,Kenya', 'Nairobi', 'Kenya', '254', 'male', '1990-01-01', 30),
(10006, 'Vivian', 'r@gmail.com', '$2y$10$bMKcibs.Bg3tcuIrxD259.KmrVMn5sjsGb4BlvX0PfX3jGi18PQqq', 'Seattle,Usa', 'Seattle', 'Usa', '1', 'female', '1990-01-01', 30),
(10008, 'Chris Atkins', 'manyaram52@gmail.com', '$2y$10$NlrGPQZfzwuVC1WKLUN9/.HHG.4Bfp7qdNartapQv4P/uKn6sgbAC', '00200-99899', 'Nairobi', 'Kenya', '254', 'male', '1990-01-01', 32),
(10009, 'John Mwendwa', 'john@gmail.com', '$2y$10$Bc7aKs3/TZVs6Z0DV6O30O2jstltq.DafT.JSO1YdpVB9LeBDzB42', '00200-00100', 'Nairobi', 'Kenya', '254', 'male', '1991-06-01', 31);

-- --------------------------------------------------------

--
-- Table structure for table `win`
--

CREATE TABLE `win` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `win`
--

INSERT INTO `win` (`product_id`, `user_id`, `amount`) VALUES
(22, 10004, '2450.00'),
(23, 10004, '699.99'),
(24, 10004, '497.07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`time`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- Indexes for table `win`
--
ALTER TABLE `win`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10010;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `duration`
--
ALTER TABLE `duration`
  ADD CONSTRAINT `duration_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_status`
--
ALTER TABLE `product_status`
  ADD CONSTRAINT `product_status_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_status_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `win`
--
ALTER TABLE `win`
  ADD CONSTRAINT `win_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `win_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
