-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el10_2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2026 at 11:56 AM
-- Server version: 10.11.15-MariaDB
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `np03cs4a240155`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(4, 'root_admin', '$2y$10$PwfHIzClz7fuU/.Tpdt8lulrLeJfbAplBXfVm2xI3nXccc0C1ovqy');

-- --------------------------------------------------------

--
-- Table structure for table `archived_orders`
--

CREATE TABLE `archived_orders` (
  `id` int(11) NOT NULL,
  `original_order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_orders`
--

INSERT INTO `archived_orders` (`id`, `original_order_id`, `customer_name`, `customer_phone`, `total`, `status`, `order_date`, `archived_at`) VALUES
(1, 1, 'Tushar', '1111', 2.25, 'done', '2026-01-30 09:17:33', '2026-02-02 05:29:38'),
(2, 2, 'Tushar', '1111', 150.00, 'done', '2026-02-02 04:58:36', '2026-02-02 05:29:38'),
(3, 3, 'Tushar', '4616651', 150.00, 'done', '2026-02-02 05:22:53', '2026-02-02 05:29:38'),
(4, 4, 'Tushar', '4616651', 55.00, 'pending', '2026-02-02 06:28:58', '2026-02-02 07:17:07'),
(5, 5, 'bishal', '99900908', 150.00, 'done', '2026-02-02 07:14:28', '2026-02-02 07:17:07'),
(6, 6, 'devil', '', 300.00, 'done', '2026-02-02 07:18:55', '2026-02-02 07:24:01'),
(7, 7, 'Devil dog', '1111', 150.00, 'done', '2026-02-02 07:20:04', '2026-02-02 07:24:01'),
(8, 8, 'Devil mate', '11111', 1875.00, 'done', '2026-02-02 07:21:23', '2026-02-02 07:24:01'),
(9, 9, 'rado', '', 560.00, 'done', '2026-02-02 07:31:37', '2026-02-02 07:33:03'),
(10, 10, 'Bishal', '1111', 1009706.00, 'done', '2026-02-02 07:39:19', '2026-02-02 07:41:45'),
(11, 11, 'wow', 'no', 7050.00, 'done', '2026-02-03 11:32:57', '2026-02-02 07:41:45'),
(12, 12, 'Bishal1', '1111', 277775.00, 'done', '2026-02-02 07:40:27', '2026-02-02 07:41:45'),
(13, 13, 'Bishal1', '1111', 102193.00, 'done', '2026-02-02 07:40:53', '2026-02-02 07:41:45'),
(14, 14, 'Bishal1', '1111', 1155.00, 'done', '2026-02-02 08:15:38', '2026-02-02 08:40:39'),
(15, 15, 'Bishal1', '1111', 38500.00, 'done', '2026-02-02 08:17:13', '2026-02-02 08:40:39'),
(16, 16, '13zx22', '32213', 26705.00, 'done', '2026-02-02 08:17:16', '2026-02-02 08:40:39'),
(17, 17, 'Kreel', '11111', 35380.00, 'done', '2026-02-02 08:17:53', '2026-02-02 08:40:39'),
(18, 18, 'Bishal1', '1111', 54145.00, 'done', '2026-02-02 08:22:03', '2026-02-02 08:40:39'),
(19, 19, 'test', NULL, 215.00, 'done', '2026-02-03 11:32:44', '2026-02-02 09:43:26'),
(20, 20, 'ez', '584843', 940.00, 'done', '2026-02-03 11:32:48', '2026-02-02 10:14:27'),
(21, 21, 'Tushar', '', 150.00, 'done', '2026-02-02 11:19:37', '2026-02-02 11:20:03'),
(22, 22, 'Tushar', '4616651', 150.00, 'done', '2026-02-02 11:29:34', '2026-02-02 11:34:17'),
(23, 23, 'adam', '', 190.00, 'done', '2026-02-02 11:46:22', '2026-02-02 12:58:16'),
(24, 24, 'Tushar', '', 150.00, 'done', '2026-02-02 12:09:25', '2026-02-02 12:58:16'),
(25, 25, 'tushar', '', 340.00, 'done', '2026-02-02 12:49:18', '2026-02-02 12:58:16'),
(26, 26, 'PRAJWAL', '', 455.00, 'done', '2026-02-02 12:54:35', '2026-02-02 12:58:16'),
(27, 27, 'Tushar', '', 340.00, 'done', '2026-02-02 13:11:08', '2026-02-03 11:16:06'),
(28, 28, 'Tushar Dhonju', '', 310.00, 'done', '2026-02-02 13:14:43', '2026-02-03 11:16:06'),
(29, 29, 'Bishal1', '', 1450.00, 'pending', '2026-02-03 08:21:40', '2026-02-03 11:16:06'),
(30, 30, 'Bishal1', '1111', 305.00, 'pending', '2026-02-03 08:38:43', '2026-02-03 11:16:06'),
(31, 31, 'Tushar', '', 300.00, 'done', '2026-02-03 09:11:51', '2026-02-03 11:16:06'),
(32, 32, 'Tushar', '', 55.00, 'pending', '2026-02-03 11:15:40', '2026-02-03 11:16:06'),
(33, 33, 'Tushar', '', 150.00, 'pending', '2026-02-03 11:29:37', '2026-02-03 11:45:28'),
(34, 34, 'Tushar', '', 150.00, 'done', '2026-02-03 11:33:25', '2026-02-03 11:45:28'),
(35, 35, 'test', '', 150.00, 'pending', '2026-02-03 11:33:47', '2026-02-03 11:45:28'),
(36, 1, 'Tushar', '', 150.00, 'pending', '2026-02-03 11:47:01', '2026-02-03 11:47:05'),
(37, 1, 'Tushar', '', 150.00, 'pending', '2026-02-03 11:50:59', '2026-02-03 11:51:04'),
(38, 1, 'Tushar', '', 150.00, 'pending', '2026-02-03 11:52:14', '2026-02-03 11:52:18'),
(39, 2, 'test', '', 150.00, 'done', '2026-02-03 11:52:36', '2026-02-03 11:52:57'),
(40, 3, 'Tushar Dhonju', '', 300.00, 'done', '2026-02-03 11:54:33', '2026-02-03 11:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `archived_order_items`
--

CREATE TABLE `archived_order_items` (
  `id` int(11) NOT NULL,
  `archived_order_id` int(11) NOT NULL,
  `menu_item_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_order_items`
--

INSERT INTO `archived_order_items` (`id`, `archived_order_id`, `menu_item_name`, `quantity`, `price`) VALUES
(1, 1, 'Lemonade', 1, 2.25),
(2, 2, 'Lemonade', 1, 150.00),
(3, 3, 'Lemonade', 1, 150.00),
(4, 4, 'Chocolate Donut', 1, 55.00),
(5, 5, 'Lemonade', 1, 150.00),
(6, 6, 'Lemonade', 2, 150.00),
(7, 7, 'Lemonade', 1, 150.00),
(8, 8, 'Espresso', 1, 200.00),
(9, 8, 'Cappuccino', 4, 190.00),
(10, 8, 'Iced Latte', 1, 150.00),
(11, 8, 'Blueberry Muffin', 1, 250.00),
(12, 8, 'Chocolate Cake', 1, 160.00),
(13, 8, 'Lemonade', 2, 150.00),
(14, 8, 'Lemonade', 2, 150.00),
(15, 9, 'Blueberry Muffin', 1, 250.00),
(16, 9, 'Chocolate Cake', 1, 160.00),
(17, 9, 'Chocolate Cake', 1, 160.00),
(18, 10, 'Espresso', 1, 200.00),
(19, 10, 'Cappuccino', 1, 190.00),
(20, 10, 'Iced Latte', 1, 150.00),
(21, 10, 'Blueberry Muffin', 1, 250.00),
(22, 10, 'Chocolate Cake', 1, 160.00),
(23, 10, 'Lemonade', 1, 150.00),
(24, 10, 'Chocolate Donut', 1, 55.00),
(25, 10, 'Wine', 13, 11111.00),
(26, 10, 'Wine', 13, 11111.00),
(27, 11, 'Lemonade', 47, 150.00),
(28, 12, 'Wine', 25, 11111.00),
(29, 13, 'Wine', 91, 1123.00),
(30, 14, 'Espresso', 1, 200.00),
(31, 14, 'Cappuccino', 1, 190.00),
(32, 14, 'Iced Latte', 1, 150.00),
(33, 14, 'Blueberry Muffin', 1, 250.00),
(34, 14, 'Chocolate Cake', 1, 160.00),
(35, 14, 'Lemonade', 1, 150.00),
(36, 14, 'Lemonade', 1, 150.00),
(37, 15, 'Blueberry Muffin', 154, 250.00),
(38, 16, 'Blueberry Muffin', 100, 250.00),
(39, 16, 'Blueberry Muffin', 100, 250.00),
(40, 17, 'Blueberry Muffin', 140, 250.00),
(41, 17, 'Chocolate Cake', 1, 160.00),
(42, 17, 'Chocolate Cake', 1, 160.00),
(43, 18, 'Espresso', 34, 200.00),
(44, 18, 'Cappuccino', 32, 190.00),
(45, 18, 'Iced Latte', 39, 150.00),
(46, 18, 'Blueberry Muffin', 92, 250.00),
(47, 18, 'Chocolate Cake', 37, 160.00),
(48, 18, 'Lemonade', 29, 150.00),
(49, 18, 'Lemonade', 29, 150.00),
(50, 19, 'Chocolate Cake', 1, 160.00),
(51, 19, 'Chocolate Cake', 1, 160.00),
(52, 20, 'Espresso', 1, 200.00),
(53, 20, 'Cappuccino', 1, 190.00),
(54, 20, 'Iced Latte', 1, 150.00),
(55, 20, 'Blueberry Muffin', 1, 250.00),
(56, 20, 'Blueberry Muffin', 1, 250.00),
(57, 21, 'Lemonade', 1, 150.00),
(58, 22, 'Lemonade', 1, 150.00),
(59, 23, 'Cappuccino', 1, 190.00),
(60, 24, 'Lemonade', 1, 150.00),
(61, 25, 'Cappuccino', 1, 190.00),
(62, 25, 'Cappuccino', 1, 190.00),
(63, 26, 'Blueberry Muffin', 1, 250.00),
(64, 26, 'Lemonade', 1, 150.00),
(65, 26, 'Lemonade', 1, 150.00),
(66, 27, 'Cappuccino', 1, 190.00),
(67, 27, 'Cappuccino', 1, 190.00),
(68, 28, 'Chocolate Cake', 1, 160.00),
(69, 28, 'Chocolate Cake', 1, 160.00),
(70, 29, 'Espresso', 1, 195.00),
(71, 29, 'Cappuccino', 1, 190.00),
(72, 29, 'Iced Latte', 1, 150.00),
(73, 29, 'Blueberry Muffin', 1, 250.00),
(74, 29, 'Chocolate Cake', 1, 160.00),
(75, 29, 'Lemonade', 3, 150.00),
(76, 29, 'Lemonade', 3, 150.00),
(77, 30, 'Blueberry Muffin', 1, 250.00),
(78, 30, 'Blueberry Muffin', 1, 250.00),
(79, 31, 'Lemonade', 2, 150.00),
(80, 32, 'Chocolate Donut', 1, 55.00),
(81, 33, 'Lemonade', 1, 150.00),
(82, 34, 'Lemonade', 1, 150.00),
(83, 35, 'Lemonade', 1, 150.00),
(84, 36, 'Lemonade', 1, 150.00),
(85, 37, 'Lemonade', 1, 150.00),
(86, 38, 'Lemonade', 1, 150.00),
(87, 39, 'Iced Latte', 1, 150.00),
(88, 40, 'Iced Latte', 1, 150.00),
(89, 40, 'Lemonade', 1, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Beverages'),
(1, 'Coffee'),
(3, 'Desserts'),
(2, 'Snacks');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `category`, `price`, `description`, `availability`, `created_at`, `image`) VALUES
(1, 'Espresso', 'Coffee', 195.00, 'Rich and bold espresso shot.', 1, '2026-01-30 08:36:28', '1770006630_1261.png'),
(2, 'Cappuccino', 'Coffee', 190.00, 'Espresso with steamed milk and foam.', 1, '2026-01-30 08:36:28', '1770006801_5456.png'),
(3, 'Iced Latte', 'Coffee', 150.00, 'Chilled espresso with milk.', 1, '2026-01-30 08:36:28', '1770006672_2507.png'),
(4, 'Blueberry Muffin', 'Snacks', 250.00, 'Freshly baked muffin with blueberries.', 1, '2026-01-30 08:36:28', '1770006994_6197.jpg'),
(5, 'Chocolate Cake', 'Desserts', 160.00, 'Moist chocolate cake slice.', 1, '2026-01-30 08:36:28', '1770007048_9529.jpg'),
(6, 'Lemonade', 'Beverages', 150.00, 'Refreshing beverage made by mixing lemon juice, water, and sweetener', 1, '2026-01-30 08:36:28', '1770008014_4503.jpg'),
(7, 'Chocolate Donut', 'Snacks', 55.00, 'A donut glazed with chocolate.', 1, '2026-01-30 08:36:28', '1770008071_3255.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(11) NOT NULL,
  `requester_name` varchar(50) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `location_room` varchar(100) NOT NULL,
  `issue_details` text NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revenue_logs`
--

CREATE TABLE `revenue_logs` (
  `id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `total_revenue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue_logs`
--

INSERT INTO `revenue_logs` (`id`, `log_date`, `total_orders`, `total_revenue`, `created_at`) VALUES
(1, '2026-02-02', 26, 17975.00, '2026-02-02 05:29:38'),
(12, '2026-02-03', 14, 4110.00, '2026-02-03 11:16:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `archived_orders`
--
ALTER TABLE `archived_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_order_items`
--
ALTER TABLE `archived_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archived_order_id` (`archived_order_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `revenue_logs`
--
ALTER TABLE `revenue_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_date` (`log_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `archived_orders`
--
ALTER TABLE `archived_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `archived_order_items`
--
ALTER TABLE `archived_order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `revenue_logs`
--
ALTER TABLE `revenue_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archived_order_items`
--
ALTER TABLE `archived_order_items`
  ADD CONSTRAINT `archived_order_items_ibfk_1` FOREIGN KEY (`archived_order_id`) REFERENCES `archived_orders` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
