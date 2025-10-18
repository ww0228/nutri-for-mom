-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 04:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_NutriForMom`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`c_id`, `c_name`, `c_email`, `c_message`, `submission_date`) VALUES
(6, 'Sophia Adams', 'sophia.adams@example.com', 'I have a question about the donation process.', '2024-12-15 08:57:56'),
(7, 'Liam Turner', 'liam.turner@example.com', 'Can I get a receipt for my recent donation?', '2024-12-15 08:57:56'),
(8, 'Olivia Scott', 'olivia.scott@example.com', 'I would like to know more about your organization’s mission.', '2024-12-15 08:57:56'),
(9, 'Noah Clark', 'noah.clark@example.com', 'Do you accept cryptocurrency donations?', '2024-12-15 08:57:56'),
(10, 'Emma Mitchell', 'emma.mitchell@example.com', 'How can I volunteer with your cause?', '2024-12-15 08:57:56'),
(11, 'James Robinson', 'james.robinson@example.com', 'Where can I find your products to donate?', '2024-12-15 09:27:40'),
(12, 'Amelia Carter', 'amelia.carter@example.com', 'I would like to know if donations are tax-deductible.', '2024-12-15 09:27:40'),
(13, 'Mason Harris', 'mason.harris@example.com', 'I want to support your efforts with a large donation.', '2024-12-15 09:27:40'),
(14, 'Isabella Young', 'isabella.young@example.com', 'Can you update me on my donation status?', '2024-12-15 09:27:40'),
(15, 'Lucas Evans', 'lucas.evans@example.com', 'I would like to set up a recurring donation.', '2024-12-15 09:27:40'),
(16, 'John Doe', 'john.doe@example.com', 'I am interested in making a donation, please send more details.', '2024-12-15 09:28:17'),
(17, 'Jane Smith', 'jane.smith@example.com', 'Can I get more information about how donations are used?', '2024-12-15 09:28:17'),
(18, 'Michael Johnson', 'michael.johnson@example.com', 'I would like to volunteer for your cause. Please contact me.', '2024-12-15 09:28:17'),
(19, 'Emily Davis', 'emily.davis@example.com', 'I have a question about the donation process.', '2024-12-15 09:28:17'),
(20, 'David Brown', 'david.brown@example.com', 'Looking for ways to help out. Do you have any specific needs right now?', '2024-12-15 09:28:17'),
(21, 'Sarah Wilson', 'sarah.wilson@example.com', 'Can I get a receipt for my last donation?', '2024-12-15 09:28:17'),
(22, 'James Lee', 'james.lee@example.com', 'I recently donated and would like to know the impact it made.', '2024-12-15 09:28:17'),
(23, 'Rachel Moore', 'rachel.moore@example.com', 'Please let me know if you have any upcoming events or campaigns.', '2024-12-15 09:28:17'),
(24, 'Chris Taylor', 'chris.taylor@example.com', 'I am interested in partnering with your organization.', '2024-12-15 09:28:17'),
(25, 'Amanda Harris', 'amanda.harris@example.com', 'I would love to learn more about your mission and how I can contribute.', '2024-12-15 09:28:17'),
(26, 'weiwen', 'weiwen@gmail.com', '123', '2024-12-16 12:11:37'),
(27, 'ww', 'ww@gmail.com', '123', '2024-12-16 14:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `u_id` int(11) DEFAULT NULL,
  `d_id` int(11) NOT NULL,
  `d_amount` decimal(10,2) DEFAULT NULL,
  `d_payment_token` varchar(255) DEFAULT NULL,
  `d_payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`u_id`, `d_id`, `d_amount`, `d_payment_token`, `d_payment_date`) VALUES
(5, 9, 100.00, '810733fc814b0fd6fa0ed3c5e6af76b8', '2024-12-15 09:24:18'),
(32, 10, 20.10, '70e2a2a04b37e3a6683c533926e29ce6', '2024-12-15 09:25:31'),
(32, 12, 57.20, '13a3d9928f2eb14f2df4422d4a597692', '2024-12-16 12:02:05'),
(32, 13, 25.00, '1e24f76c74bc1154f83571c45ed832fe', '2024-12-16 15:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `groceries`
--

CREATE TABLE `groceries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groceries`
--

INSERT INTO `groceries` (`id`, `name`, `weight`, `price`, `image`, `code`) VALUES
(1, 'Cereal', '300g', 14.00, 'pic/cereal.png', 'G01'),
(2, 'Garlic', '900g', 4.00, 'pic/garlic.png', 'G02'),
(3, 'Bananas', '1kg', 7.20, 'pic/banana.png', 'G03'),
(4, 'Cooking Oil', '1kg', 6.75, 'pic/oil.png', 'G04'),
(5, 'Eggs', '10pcs', 12.90, 'pic/egg.png', 'G05'),
(6, 'Sliced Bread ', '500g', 3.80, 'pic/bread.png', 'G06'),
(7, 'Milk Powder', '900g', 160.00, 'pic/milk.png', 'G07'),
(8, 'Rice', '5kg', 32.00, 'pic/rice.png', 'G08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(100) DEFAULT NULL,
  `u_email` varchar(100) DEFAULT NULL,
  `u_password` varchar(255) DEFAULT NULL,
  `u_registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `u_name`, `u_email`, `u_password`, `u_registration_date`, `u_is_admin`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$Ql.mjKDmhrwbQzRS/y2Xceje.zpJmTNYzYlBzJJTdWc62w52Wj85C', '2024-12-15 17:33:17', 1),
(2, 'Tan Wei Wen', 'weiwen@gmail.com', '$2y$10$Iaw/oz0WL5BVQZsZb6z2ouw6Ayzwuc5NDOGB/tuiEnFxC25OKyrXS', '2024-12-15 08:53:23', 0),
(5, 'Bob Smith', 'bob.smith@example.com', '$2y$10$iejabn0qU2RO50iWY.ix0uXKs6ELwutD1wMAo3Lf8O6SF/nUmTesG', '2024-12-15 08:55:45', 0),
(32, 'me', 'me@gmail.com', '$2y$10$VMXyTP1.vzmRdNMLB2B3FunqDyxWe2Ydm1QiYfQr5V4UdIxDOFf.m', '2024-12-16 08:33:53', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`d_id`),
  ADD UNIQUE KEY `d_payment_token` (`d_payment_token`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `groceries`
--
ALTER TABLE `groceries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groceries`
--
ALTER TABLE `groceries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
