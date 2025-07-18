-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 08:25 AM
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
-- Database: `etierproducts`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) NOT NULL,
  `birthday` date NOT NULL,
  `street_name` varchar(250) NOT NULL,
  `house_number` varchar(250) NOT NULL,
  `building` varchar(250) DEFAULT NULL,
  `barangay` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `region` varchar(250) NOT NULL,
  `province` varchar(250) NOT NULL,
  `postal_code` int(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `birthday`, `street_name`, `house_number`, `building`, `barangay`, `city`, `region`, `province`, `postal_code`, `password`, `username`, `email`, `contact_number`, `created_at`) VALUES
(2, 'Etier', '', 'User', '2025-07-12', 'Sunny Street', '143 Sola', 'Stormy Building', 'Barangay Alexa', 'Choco City', 'NCR', 'Spyro Province ', 1234, 'collocuetopuawei', 'BeyondOne', 'iacedos11@gmail.com', '09123456789', '2025-07-12 09:23:30'),
(14, 'Paul Benedict', 'Viray', 'Collo', '2025-07-16', 'Sunny Street', '143 Sola', 'Stormy Building', 'Barangay Alexa', 'Choco City', 'NCR', 'Spyro Province ', 1234, '$2y$10$iDlIaKUvA/6JO2iBbfNn5u7FE6iI1ax2xpNkBMZGXpmkbSvj5TvVa', 'BeneTest', 'paulbenedictcollo@gmail.com', '09123456789', '2025-07-13 10:06:18'),
(16, 'charles ', 'Galo', 'pua', '2005-02-07', 'Ilang ilang', '48', '', '97', 'Caloocan', 'NCR', 'National Capital Region', 1400, '$2y$10$xsV43xu5sAzJEmb/fRvgUOcjb8JH4AwwAC4q6T/SNaThNViB.sHn2', 'charlespua', 'charlespuasdf@gmail.com', '09766491858', '2025-07-18 05:24:50'),
(17, 'charles ', 'Galo', 'pua', '2005-02-07', 'Ilang ilang', '48', '', '97', 'Caloocan', 'NCR', 'National Capital Region', 1400, '$2y$10$MryLtP//x11P7fC9dtVK8eaUftUIMjB8G1fU1Y2jwbM2ZowCcjY5i', 'charlespua', 'charlespuasdf@gmail.com', '09766491858', '2025-07-18 06:16:07'),
(18, 'charles ', 'Galo', 'pua', '2005-02-07', 'Ilang ilang', '48', '', 'ss', 'Caloocan', 'sss', 'National Capital Region', 1400, '$2y$10$LMpHJLb494jzRFm.rgrNv.aGFBXxTWAlWzIZIQhYk8M3eNJ5MGCYe', 'charlespuaa', 'charlespuasdf@gmail.com', '09766491858', '2025-07-18 06:17:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
