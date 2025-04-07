-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 09:34 AM
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
-- Database: `foodapp`
--
CREATE DATABASE IF NOT EXISTS `foodapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foodapp`;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(200) NOT NULL,
  `rest_id` int(200) NOT NULL,
  `rest_name` varchar(200) NOT NULL,
  `vendor_id` varchar(200) NOT NULL,
  `dish_name` varchar(200) NOT NULL,
  `dish_desc` varchar(200) NOT NULL,
  `dish_price` varchar(200) NOT NULL,
  `dish_category` varchar(200) NOT NULL,
  `dish_image` varchar(200) NOT NULL,
  `dish_availability` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `rest_id`, `rest_name`, `vendor_id`, `dish_name`, `dish_desc`, `dish_price`, `dish_category`, `dish_image`, `dish_availability`, `created_at`) VALUES
(22, 1, 'Abhishek Resto', '3', 'Paneer Butter Masala', 'A rich and creamy tomato-based curry made with butter, cream, and aromatic spices, featuring soft paneer cubes.', '220', 'Main Course', '../images/dishimg/paneer-butter-masala.jpg', 'available', '2025-03-11 08:16:15'),
(23, 1, 'Abhishek Resto', '3', 'Kadai Paneer', 'A spicy and flavorful dish cooked with paneer, bell peppers, onions, and a blend of freshly ground spices in a thick gravy.', '240', 'Main Course', '../images/dishimg/kadai-paneer-recipe.jpg', 'available', '2025-03-11 08:17:49'),
(24, 1, 'Abhishek Resto', '3', 'Palak Paneer', 'A nutritious dish where paneer cubes are cooked in a smooth, mildly spiced spinach-based gravy.', '280', 'Main Course', '../images/dishimg/palak-Paneer.jpg', 'available', '2025-03-11 08:19:27'),
(25, 6, 'Ratna', '7', 'aaaaa', 'Test', '10', 'Main Course', '../images/dishimg/pimg.jpg', 'available', '2025-03-13 06:46:44'),
(26, 6, 'Ratna', '7', 'Masala Papad', 'TEst', '50', 'Starter', '../images/dishimg/masala-papad.jpg', 'available', '2025-03-16 04:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `invoice_no` varchar(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `dish_id` text NOT NULL,
  `rest_id` text NOT NULL,
  `quantity` text NOT NULL,
  `total_payment` int(200) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `ordered_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `invoice_no`, `user_id`, `dish_id`, `rest_id`, `quantity`, `total_payment`, `status`, `ordered_date`) VALUES
(47, '2147483647', 9, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-17 06:51:56'),
(48, '2147483647', 9, '[22,23,25,26]', '[1,1,6,6]', '[7,2,2,4]', 2168, 'pending', '2025-03-17 06:52:21'),
(49, '0', 9, '[22,23,24,25]', '[1,1,1,6]', '[5,2,3,2]', 2358, 'pending', '2025-03-17 07:00:06'),
(50, '0', 22, '[22,23,24]', '[1,1,1]', '[2,2,2]', 1446, 'pending', '2025-03-17 07:03:22'),
(51, '215925', 8, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-17 07:10:02'),
(52, '0', 8, '[23]', '[1]', '[5]', 1180, 'pending', '2025-03-17 07:10:50'),
(53, '0', 8, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-17 07:11:55'),
(54, '0', 8, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-17 07:12:53'),
(55, '#756482', 8, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-17 07:13:19'),
(56, '#780610', 9, '[26]', '[6]', '[5]', 278, 'pending', '2025-03-17 07:14:00'),
(58, '#116953', 11, '[22,23,24,25]', '[1,1,1,6]', '[1,1,1,2]', 762, 'pending', '2025-03-17 10:07:00'),
(59, '#140726', 11, '[22,23,26,24]', '[1,1,6,1]', '[5,2,4,13]', 5189, 'pending', '2025-03-17 10:38:41'),
(60, '#568018', 11, '[26]', '[6]', '[57]', 2748, 'pending', '2025-03-17 17:55:29'),
(61, '#642396', 10, '[22,23,24,25,26]', '[1,1,1,6,6]', '[4,6,4,2,2]', 3422, 'pending', '2025-03-18 05:52:54'),
(62, '#146587', 10, '[22,23]', '[1,1]', '[1,1]', 477, 'pending', '2025-03-18 05:54:16'),
(63, '#827994', 9, '[22]', '[1]', '[6]', 1294, 'pending', '2025-03-18 06:08:10'),
(64, '#177405', 9, '[22,24]', '[1,1]', '[1,15]', 4239, 'pending', '2025-03-18 06:57:08'),
(65, '#782431', 9, '[22]', '[1]', '[1]', 249, 'pending', '2025-03-29 05:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `rest_id` int(200) NOT NULL,
  `vendor_id` varchar(200) NOT NULL,
  `vendor_name` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `o_time` time(6) NOT NULL,
  `c_time` time(6) NOT NULL,
  `image` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`rest_id`, `vendor_id`, `vendor_name`, `name`, `address`, `phone`, `email`, `o_time`, `c_time`, `image`, `created_at`) VALUES
(1, '3', '', 'Abhishek Resto', 'Pune', '', '', '09:00:00.000000', '23:00:00.000000', '', '2025-03-10 07:13:07'),
(2, '3', '', 'Abhishek Resto', 'Pune', '', '', '09:00:00.000000', '23:00:00.000000', '', '2025-03-10 07:13:07'),
(3, '7', '', 'Athiti Hotel', 'Nagar', '', '', '11:00:00.000000', '20:00:00.000000', '', '2025-03-10 07:13:07'),
(4, '3', '', 'Athiti Hotel', 'Nagar', '', '', '10:00:00.000000', '23:00:00.000000', '', '2025-03-10 07:13:07'),
(5, '3', 'Tushar Gaikwad', 'Akshay Resto', 'Solapur', '798465310', 'akshay@gmail.com', '09:00:00.000000', '03:21:00.000000', '', '2025-03-10 07:34:55'),
(6, '7', 'Shubham Kolhe', 'Ratna', 'Karve Nagar', '9784651320', 'ratna@gmail.com', '11:00:00.000000', '22:00:00.000000', '', '2025-03-10 09:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `name`, `email`, `phone`, `password`, `role`, `image`, `address`, `created_at`) VALUES
(1, 'admin', 'Abhishek Hingmire', 'hingmireabhishek250@gmail.com', '', '$2y$10$MjE336kPAaTxbNeqsOdxLevML1x3tuvRTF5iv.5ulbDKsNFpbgPBy', 'admin', '', '', '2025-03-10 07:17:48'),
(2, 'user1', 'Shubham Kolhe', 'user1@gmail.com', '', '$2y$10$xQaesly0CnNRMYBO.FH6jOvkI1QPrUT8SszYdIKRrx/be4xqbVjSq', 'user', '', '', '2025-03-10 07:17:48'),
(3, 'vendor1', 'Tushar Gaikwad', 'vendor1@gmail.com', '', '$2y$10$.oktq23F6zrEN1936bsXhO00S3xpwPOBeGB72bPdOeog1r6fY3t96', 'vendor', '', '', '2025-03-10 07:17:48'),
(7, 'vendor2', 'Shubham Kolhe', 'bsilent2502@gmail.com', '', '$2y$10$RakVJipeEw1233kRvJSmM.mNEdaqeHzKtX56mIawNiYKv5i8o7ouu', 'vendor', '', '', '2025-03-10 07:17:48'),
(8, 'user2', 'Abhishek Hingmire', 'abhi@gmail.com', '', '$2y$10$4VmTZ23gUIELHNlCLYRksuYiuw6MMjI8VIlAy1G7wnUTFCBkCFfXK', 'user', '', '', '2025-03-11 06:58:21'),
(9, 'user3', 'Tushar Gaikwad', 'bsilent2502@gmail.com', '', '$2y$10$0nW4lHTa5nSzS58OR98k0.xTtjDMzBmIfk4ydmJSI28FRAAVhlDvi', 'user', '', '', '2025-03-14 05:46:05'),
(10, 'user4', 'Akshay ', 'akshay@gmail.com', '', '$2y$10$ex1tVc4Umy7KKeZDHXrHFOuUuRBFTNO/kOnjh/Wf6dy5tGayRg2Mm', 'user', '', '', '2025-03-15 06:31:36'),
(11, 'user5', 'Ram Jadhav', 'ram@gmail.com', '', '$2y$10$cPKq7Kf6dJWuF.eZwfpPBuH26pBhOGQ0nGA.G0QXtO1R0qUI2ONQq', 'user', '', '', '2025-03-15 17:07:21'),
(18, 'user6', 'Omkar Jadhav', 'omkar@gmail.com', '', '$2y$10$LodYfFbZIZbFJpAc4vlvT.HVkYIrWaOqRo0IGyvMPTXIzHwDFxUPG', 'user', 'profileImg/photo.jpg', '', '2025-03-15 18:20:10'),
(21, 'user7', 'Sagar', 'sagar@gmail.com', '', '$2y$10$CgGAgrGtzhKUzKAspDeFZuCnbjxWPvRb9GOikDSCCXAE.aDq1AfSe', 'user', '../images/profileImg/Abhishek sign.jpg', '', '2025-03-15 18:33:17'),
(22, 'user10', 'Suraj', 'suraj@gmail.com', '', '$2y$10$z9PsC/7VPTXHEZvwGbbZKO9ti0Cm8QOjbEgGnKLCQZ0s.y34An2jS', 'user', '../images/profileImg/kadai-paneer-recipe.jpg', '', '2025-03-17 07:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(200) NOT NULL,
  `menu_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `quantity` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `menu_id`, `user_id`, `quantity`) VALUES
(156, 22, 11, 1),
(157, 23, 11, 3),
(158, 25, 11, 1),
(167, 24, 10, 1),
(168, 25, 10, 1),
(169, 26, 10, 1),
(170, 22, 10, 1),
(171, 23, 10, 3),
(174, 23, 9, 3),
(176, 26, 9, 1),
(177, 25, 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`rest_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `rest_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
