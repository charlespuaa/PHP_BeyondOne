-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 06:19 AM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `size` varchar(30) NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL,
  `hover_image` varchar(100) NOT NULL,
  `stock` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `size`, `price`, `image`, `hover_image`, `stock`) VALUES
(1, 'Malbom Golf Hat', '100% cotton golf cap with adjustable back strap and embroided logo', 'Hats and Caps', 'One Size', 2711.03, 'hats_and_caps/MGOLF_cap_front.png', 'hats_and_caps/MGOLF_cap_back.png', 10),
(2, 'Legend Trucker Hat', '53% polyester and 47% cotton cap with adjustable back strap and mesh back panel', 'Hats and Caps', 'One Size', 2823.99, 'hats_and_caps/LEGENDS_cap_front.png', 'hats_and_caps/LEGENDS_cap_back.png', 15),
(3, 'Bear Loft Bucket Hat', '100% cotton with canvas fabric and a front embroided graphic logo detail', 'Hats and Caps', 'One Size', 3923.22, 'hats_and_caps/BEAR_buckethat_front.png', 'hats_and_caps/BEAR_buckethat_back.png', 3),
(4, 'Heart Patch Baseball Cap', '100% cotton baseball cap with adjustable back strap, front patch detail, and ventilating eyelets', 'Hats and Caps', 'One Size', 4461.90, 'hats_and_caps/HEARTS_cap_front.png', 'hats_and_caps/HEARTS_cap_back.png', 13),
(5, 'Market Studio Beanie', '100% acrylic beanie with an embroided logo detail and ribbed knit fabric', 'Hats and Caps', 'Onr Size', 1129.80, 'hats_and_caps/MARKETSTUDIOS_beanie_front.png', 'hats_and_caps/MARKETSTUDIOS_beanie_back.png', 8),
(6, 'Jones Aviator Sunglasses', 'Silver-tone metal frame sunglasses', 'Eyewear', 'One Size', 3321.89, 'eyewear/JONESAVIATOR_front.png', 'eyewear/JONESAVIATOR_side.png', 32),
(7, 'Earl Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 4322.98, 'eyewear/EARL_front.png', 'eyewear/EARL_side.png', 4),
(8, 'Oval Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 32382.21, 'eyewear/OVAL_front.png', 'eyewear/OVAL_side.png', 9),
(9, 'Pluto Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 2202.71, 'eyewear/PLUTO_front.png', 'eyewear/PLUTO_side.png', 19),
(10, 'Tag 3.0 Sunglasses', 'Silver-tone metal frame sunglasses', 'Eyewear', 'One Size', 23311.29, 'eyewear/TAG3_front.png', 'eyewear/TAG3_back.png', 4),
(11, 'Biliwin', 'Laptop Handbag with removable adjustable crossbody strap', 'Hand Bags', 'Large', 3000.00, 'handbags/BILIWIN_front.png', 'handbags/BILIWIN_side.png', 12),
(12, 'Wigoand', 'Messenger bag with non-removable adjustable crossbody strap', 'Hand Bags', 'Medium', 2500.00, 'handbags/WIGOAND_front.png', 'handbags/WIGOAND_side.png', 8),
(13, 'Tardes', 'Backpack with adjustable shoulder strap and two compartments', 'Hand Bags', 'Large', 3400.00, 'handbags/TARDES_front.png', 'handbags/TARDES_back.png', 5),
(14, 'Seawave', 'Cross body bag with non-removable adjustable crossbody strap with one compartment', 'Hand Bags', 'Small', 2400.00, 'handbags/SEAWAVE_front.png', 'handbags/SEAWAVE_side.png', 5),
(15, 'Tonstrina 17', '17 is a classic and impeccable fougere construction and a clear contrast between fresh and aromatic notes', 'Fragrance', '100ml', 3200.20, 'fragrance/TONSTRINA17_front.png', 'fragrance/TONSTRINA17_back.png', 5),
(16, 'Tonstrina 55', '55 is woody parfum de cologne that wants to embody all the strength and elegeance of the person that wears it', 'Fragrance', '100ml', 3200.20, 'fragrance/TONSTRINA55_front.png', 'fragrance/TONSTRINA55_back.png', 5),
(17, 'Tonstrina 376', '367 is a fresh and bitter citrus parfum de cologne that elegantly claims a modern and lively style', 'Fragrance', '100ml', 3200.20, 'fragrance/TONSTRINAA367_front.png', 'fragrance/TONSTRINA367_back.png', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
