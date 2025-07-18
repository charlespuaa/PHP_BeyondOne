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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `size` varchar(30) NOT NULL,
  `has_size` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL,
  `hover_image` varchar(100) NOT NULL,
  `stock` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `size`, `has_size`, `price`, `image`, `hover_image`, `stock`) VALUES
(1, 'Malbom Golf Hat', '100% cotton golf cap with adjustable back strap and embroided logo', 'Hats and Caps', 'Small', 1, 2711.03, 'hats_and_caps/MGOLF_cap_front.png', 'hats_and_caps/MGOLF_cap_back.png', 10),
(2, 'Legend Trucker Hat', '53% polyester and 47% cotton cap with adjustable back strap and mesh back panel', 'Hats and Caps', 'Small', 1, 2823.99, 'hats_and_caps/LEGENDS_cap_front.png', 'hats_and_caps/LEGENDS_cap_back.png', 15),
(3, 'Bear Loft Bucket Hat', '100% cotton with canvas fabric and a front embroided graphic logo detail', 'Hats and Caps', 'Small', 1, 3923.22, 'hats_and_caps/BEAR_buckethat_front.png', 'hats_and_caps/BEAR_buckethat_back.png', 3),
(4, 'Heart Patch Baseball Cap', '100% cotton baseball cap with adjustable back strap, front patch detail, and ventilating eyelets', 'Hats and Caps', 'Small', 1, 4461.90, 'hats_and_caps/HEARTS_cap_front.png', 'hats_and_caps/HEARTS_cap_back.png', 13),
(5, 'Market Studio Beanie', '100% acrylic beanie with an embroided logo detail and ribbed knit fabric', 'Hats and Caps', 'Small', 1, 1129.80, 'hats_and_caps/MARKETSTUDIOS_beanie_front.png', 'hats_and_caps/MARKETSTUDIOS_beanie_back.png', 8),
(6, 'Jones Aviator Sunglasses', 'Silver-tone metal frame sunglasses', 'Eyewear', 'One Size', 0, 3321.89, 'eyewear/JONESAVIATOR_front.png', 'eyewear/JONESAVIATOR_side.png', 32),
(7, 'Earl Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 0, 4322.98, 'eyewear/EARL_front.png', 'eyewear/EARL_side.png', 4),
(8, 'Oval Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 0, 32382.21, 'eyewear/OVAL_front.png', 'eyewear/OVAL_side.png', 9),
(9, 'Pluto Sunglasses', 'Acetate frame with sof case and cleaning cloth included', 'Eyewear', 'One Size', 0, 2202.71, 'eyewear/PLUTO_front.png', 'eyewear/PLUTO_side.png', 19),
(10, 'Tag 3.0 Sunglasses', 'Silver-tone metal frame sunglasses', 'Eyewear', 'One Size', 0, 23311.29, 'eyewear/TAG3_front.png', 'eyewear/TAG3_back.png', 4),
(11, 'Biliwin', 'Laptop Handbag with removable adjustable crossbody strap', 'Hand Bags', 'Large', 0, 3000.00, 'handbags/BILIWIN_front.png', 'handbags/BILIWIN_side.png', 12),
(12, 'Wigoand', 'Messenger bag with non-removable adjustable crossbody strap', 'Hand Bags', 'Medium', 0, 2500.00, 'handbags/WIGOAND_front.png', 'handbags/WIGOAND_side.png', 8),
(13, 'Tardes', 'Backpack with adjustable shoulder strap and two compartments', 'Hand Bags', 'Large', 0, 3400.00, 'handbags/TARDES_front.png', 'handbags/TARDES_back.png', 5),
(14, 'Seawave', 'Cross body bag with non-removable adjustable crossbody strap with one compartment', 'Hand Bags', 'Small', 0, 2400.00, 'handbags/SEAWAVE_front.png', 'handbags/SEAWAVE_side.png', 5),
(15, 'Tonstrina 17', '17 is a classic and impeccable fougere construction and a clear contrast between fresh and aromatic notes', 'Fragrance', '100ml', 0, 3200.20, 'fragrance/TONSTRINA17_front.png', 'fragrance/TONSTRINA17_back.png', 5),
(16, 'Tonstrina 55', '55 is woody parfum de cologne that wants to embody all the strength and elegeance of the person that wears it', 'Fragrance', '100ml', 0, 3200.20, 'fragrance/TONSTRINA55_front.png', 'fragrance/TONSTRINA55_back.png', 5),
(17, 'Tonstrina 376', '367 is a fresh and bitter citrus parfum de cologne that elegantly claims a modern and lively style', 'Fragrance', '100ml', 0, 3200.20, 'fragrance/TONSTRINAA367_front.png', 'fragrance/TONSTRINA367_back.png', 5),
(18, 'Fisherman Sandal', 'Leather upper and manmade sole with adjustabe ankle strap', 'Shoes', '7', 1, 9319.17, 'shoes/fisherman_front.png', 'shoes/fisherman_back.png', 10),
(19, 'Lowell Oxford Shoes', 'Croc embossed leather upper with oil-resistant sole', 'Shoes', '7', 1, 9600.57, 'shoes/oxford_front.png', 'shoes/oxford_back.png', 10),
(20, 'Adrian', 'Leather upper with oil-resistant sole with tassel detail and fringe trim', 'Shoes', '7', 1, 8400.89, 'shoes/adrian_front.png', 'shoes/adrian_back.png', 10),
(21, 'Speedcat OG', 'Suede upper with rubber sole and lace-up front', 'Shoes', '7', 1, 5647.90, 'shoes/puma_front.png', 'shoes/puma_back.png', 10),
(22, 'Coors Beer Cropped Tee', '100% Cotton with a front graphic design', 'Tops', 'XS', 1, 2711.03, 'tops/coors_front.png', 'tops/coors_back.png', 20),
(23, 'Stripe Graphic Tee', '100% Cotton with a front graphic design', 'Tops', 'XS', 1, 2251.03, 'tops/toms_front.png', 'tops/toms_back.png', 60),
(24, 'Wanted Tee', '100% Cotton with a front graphic design', 'Tops', 'XS', 1, 3388.03, 'tops/wanted_front.png', 'tops/wanted_back.png', 5),
(25, 'Underground Polo Shirt', '100% Cotton with a front graphic design', 'Tops', 'XS', 1, 7008.03, 'tops/allsaints_front.png', 'tops/allsaints_back.png', 15),
(26, 'Bait and Tackle Tee', '100% Cotton with a front graphic design', 'Tops', 'XS', 1, 2938.64, 'tops/bat_front.png', 'tops/bat_back.png', 15),
(27, 'Berkley Pant', '100% cotton with adjustable belt and waistband', 'Bottoms', 'XS', 1, 8728.12, 'bottoms/berkley_front.png', 'bottoms/berkley_back.png', 7),
(28, 'Track Pants', '100% nylon with drawstring closure', 'Bottoms', 'XS', 1, 3473.90, 'bottoms/track_front.png', 'bottoms/track_back.png', 20),
(29, 'Monogram Chino Pant', '100% cotton with side seam pockets and back welt pockets', 'Bottoms', 'XS', 1, 6783.22, 'bottoms/chino_front.png', 'bottoms/chino_back.png', 10),
(30, 'Morel Nicola Terry Short', '100% cotton with drawstring closure and elasic waistband', 'Bottoms', 'XS', 1, 5400.22, 'bottoms/terry_front.png', 'bottoms/terry_back.png', 15),
(31, 'Underground Swim Shorts', '100% cotton with side pockets and single rear pocket', 'Bottoms', 'XS', 1, 6571.99, 'bottoms/swim_front.png', 'bottoms/swim_back.png', 15),
(32, 'Polycarbon 37mm Watch', 'Polycarbonate case and strap with brass dial, indexes, and hands', 'Accessories', 'One Size', 0, 11000.20, 'accessories/polycarbonwhite_front.png', 'accessories/polycarbonwhite_back.png', 4),
(33, 'Leather Suffield Belt', '100% cowhide leather with silver-tone buckle closure', 'Accessories', 'One Size', 0, 4555.90, 'accessories/suffiled_front.png', 'accessories/suffiled_back.png', 10),
(34, 'Recycled Cotton Logo Socks', '80% cotton socks', 'Accessories', 'One Size', 0, 3000.90, 'accessories/creamsocks_front.png', 'accessories/sockscream_back.png', 10),
(35, 'Cornet Ring', 'Gold-plated sterling silver', 'Accessories', 'One Size', 0, 5900.20, 'accessories/cornetring_front.png', 'accessories/cornetring_back.png', 3),
(36, 'Hybridge Lite Vest', '100% polyamide with two-way front zipper closure', 'Jackets', 'XS', 1, 29882.90, 'jackets/goose_front.png', 'jackets/goose_back.png', 11),
(37, 'Rhett Jacket', '100% cotton with 4-pcoket styling', 'Jackets', 'XS', 1, 32412.20, 'jackets/rhett_front.png', 'jackets/rhett_back.png', 18),
(38, 'Work Shirt', '100% polyester made from lightweight fleece fabric', 'Jackets', 'XS', 1, 7829.90, 'jackets/pattern_front.png', 'jackets/pattern_back.png', 8),
(39, 'NYC Cafe Racer Jacket', '100% polyester made from heavyweight buttery leather fabric', 'Jackets', 'XS', 1, 45673.90, 'jackets/scholt_front.png', 'jackets/scholt_back.png', 23),
(40, 'Mission Jacket', '100% cotton and 100% recycled polyester', 'Jackets', 'XS', 1, 8536.90, 'jackets/mission_front.png', 'jackets/mission_back.png', 21);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
