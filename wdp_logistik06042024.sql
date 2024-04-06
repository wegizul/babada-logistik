-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 05:15 AM
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
-- Database: `wdp_logistik`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_produk`
--

CREATE TABLE `jenis_produk` (
  `jp_id` int(11) NOT NULL,
  `jp_nama` varchar(200) DEFAULT NULL,
  `jp_ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jenis_produk`
--

INSERT INTO `jenis_produk` (`jp_id`, `jp_nama`, `jp_ket`) VALUES
(1, 'Packing', ''),
(2, 'Plastik Belanja', ''),
(3, 'Bahan Baku', '');

-- --------------------------------------------------------

--
-- Table structure for table `manifest`
--

CREATE TABLE `manifest` (
  `mf_id` bigint(20) NOT NULL,
  `mf_kode` varchar(50) DEFAULT NULL,
  `mf_supir` varchar(50) DEFAULT NULL,
  `mf_telp_supir` varchar(20) DEFAULT NULL,
  `mf_nopol` varchar(10) DEFAULT NULL,
  `mf_tgl_pickup` date DEFAULT NULL,
  `mf_tujuan` varchar(100) DEFAULT NULL,
  `mf_total_paket` int(11) DEFAULT NULL,
  `mf_user` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `mtl_id` bigint(20) NOT NULL,
  `mtl_nama` varchar(255) DEFAULT NULL,
  `mtl_deskripsi` text DEFAULT NULL,
  `mtl_stok` int(11) DEFAULT NULL,
  `mtl_satuan` int(11) DEFAULT NULL,
  `mtl_harga_modal` double DEFAULT NULL,
  `mtl_harga_jual` double DEFAULT NULL,
  `mtl_foto` blob DEFAULT NULL,
  `mtl_barcode` blob DEFAULT NULL,
  `mtl_date_created` datetime DEFAULT NULL,
  `mtl_date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`mtl_id`, `mtl_nama`, `mtl_deskripsi`, `mtl_stok`, `mtl_satuan`, `mtl_harga_modal`, `mtl_harga_jual`, `mtl_foto`, `mtl_barcode`, `mtl_date_created`, `mtl_date_updated`) VALUES
(6, 'Abon Ayam', '', -10, 5, 158, 164.32, NULL, NULL, '2024-03-05 11:09:53', '2024-04-05 11:15:27'),
(7, 'Abon Ayam Alfa', '', 0, 3, 151000, 157040, NULL, NULL, '2024-03-05 11:13:43', '2024-04-05 11:15:27'),
(8, 'Abon Sapi Bengawan', '', 0, 5, 135340, 140753.6, NULL, NULL, '2024-03-05 11:20:14', '2024-03-05 11:20:14'),
(9, 'Ajinomoto', '', 0, 5, 48, 49.92, NULL, NULL, '2024-03-05 11:20:44', '2024-04-04 14:58:56'),
(10, 'ALBA RED', '', 0, 4, 1300000, 1352000, NULL, NULL, '2024-03-05 11:21:35', '2024-04-05 11:15:27'),
(11, 'Albared REF', '', 0, 4, 1300000, 1352000, NULL, NULL, '2024-03-05 11:23:12', '2024-04-05 11:15:27'),
(12, 'Almon Slice', '', 0, 5, 118, 122.89, NULL, NULL, '2024-03-05 11:23:59', '2024-03-05 11:23:59'),
(13, 'Baker Mix', '', -10, 4, 800000, 832000, NULL, NULL, '2024-03-05 11:25:11', '2024-03-05 11:25:11'),
(14, 'Baki Melamin', '', -10, 14, 92500, 96200, NULL, NULL, '2024-03-05 11:26:15', '2024-03-05 11:26:15'),
(15, 'Baking /Soda Asahi', '', 0, 5, 20, 20.8, NULL, NULL, '2024-03-05 11:27:22', '2024-03-05 11:27:22'),
(16, 'Baking Powder Herculles', '', 0, 5, 48, 49.92, NULL, NULL, '2024-03-05 11:28:01', '2024-03-05 11:28:01'),
(17, 'Basil', '', 0, 5, 360, 374.4, NULL, NULL, '2024-03-05 11:29:35', '2024-03-05 11:29:35'),
(18, 'Beras Pulut', '', 0, 5, 14, 14.04, NULL, NULL, '2024-03-05 11:30:11', '2024-03-05 11:30:11'),
(19, 'Bubuk Bawang Putih Bubuk', '', 0, 5, 92, 96.18, NULL, NULL, '2024-03-05 11:31:02', '2024-03-05 11:31:02'),
(20, 'Bubuk Cajun', '', 0, 5, 225, 234, NULL, NULL, '2024-03-05 11:31:46', '2024-03-05 11:31:46'),
(21, 'Bubuk Jintan', '', 0, 5, 90, 93.6, NULL, NULL, '2024-03-05 11:32:37', '2024-03-05 11:32:37'),
(22, 'Bubuk Ketumbar', '', 0, 5, 32, 33.28, NULL, NULL, '2024-03-05 11:33:15', '2024-03-05 11:33:15'),
(23, 'Bubuk Kunyit', '', 0, 5, 38, 40, NULL, NULL, '2024-03-05 11:33:53', '2024-03-05 11:33:53'),
(24, 'Bubuk Merica Giling', '', 0, 5, 125, 130, NULL, NULL, '2024-03-05 11:34:22', '2024-03-05 11:34:22'),
(25, 'Bubuk Origano', '', 0, 5, 440, 457.6, NULL, NULL, '2024-03-05 11:34:55', '2024-03-05 11:34:55'),
(26, 'Bubuk Parsley', '', 0, 5, 315, 327.81, NULL, NULL, '2024-03-06 08:42:18', '2024-03-06 08:42:18'),
(27, 'Bubuk parsley @ 20gr', '', 0, 5, 24000, 24960, NULL, NULL, '2024-03-06 08:42:56', '2024-03-06 08:42:56'),
(28, 'Bumbu Kare', '', 0, 3, 5063, 5265, NULL, NULL, '2024-03-06 08:43:43', '2024-03-06 08:43:43'),
(29, 'Bumbu Kentang Keju', '', 0, 3, 4000, 4160, NULL, NULL, '2024-03-06 08:44:21', '2024-03-06 08:44:21'),
(30, 'Butter Hijack', '', 0, 11, 1111000, 1155440, NULL, NULL, '2024-03-06 08:45:05', '2024-03-06 08:45:05'),
(31, 'Caravelle', '', 0, 5, 30, 31.2, NULL, NULL, '2024-03-06 08:45:42', '2024-03-06 08:45:42'),
(32, 'Caribe White Flake', '', 0, 3, 101558, 105620.32, NULL, NULL, '2024-03-06 08:46:35', '2024-03-06 08:46:35'),
(33, 'Cayenne Paper', '', 0, 5, 180, 187.2, NULL, NULL, '2024-03-06 08:47:08', '2024-03-06 08:47:08'),
(34, 'CETAKAN DONAT', '', 0, 14, 17500, 18200, NULL, NULL, '2024-03-06 08:47:38', '2024-03-06 08:47:38'),
(35, 'Choco Chip', '', 0, 10, 164917, 171514.12, NULL, NULL, '2024-03-06 08:48:44', '2024-03-06 08:48:44'),
(36, 'Choco Chip Lancip', '', 0, 5, 55, 57.2, NULL, NULL, '2024-03-06 08:49:27', '2024-03-06 08:49:27'),
(37, 'Choco Chip Lancip Semi Sweat @ 1kg', '', 0, 3, 52, 56785.04, NULL, NULL, '2024-03-06 08:50:21', '2024-03-06 08:50:21'),
(38, 'Choco Chip Lancip Tulip', '', 0, 5, 53, 54.7, NULL, NULL, '2024-03-06 08:51:00', '2024-03-06 08:51:00'),
(39, 'Coffe Moca Olimpik', '', 0, 2, 75000, 78000, NULL, NULL, '2024-03-06 08:53:14', '2024-03-06 08:53:14'),
(40, 'Coffee Bread Olimpic', '', 0, 2, 300000, 312000, NULL, NULL, '2024-03-06 08:53:41', '2024-03-06 08:53:41'),
(71, 'Hot Paprika', '', 1, 5, 200, 208, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(79, 'Coklat Powder 5Kg', '', 1, 5, 117, 122, '', '', '2024-03-19 15:09:54', '2024-03-19 14:19:05'),
(80, 'Coklat Tiramisu', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(81, 'Coldfil Blueberry', '', 1, 11, 238.65, 248.196, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(82, 'Coldfil Strawberry', '', 1, 11, 238.65, 248.196, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(83, 'Coldfil Puratos Clasik Talas 5 kg', '', 1, 11, 253.08, 263.203, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(84, 'Coldfil Puratos Clasik Caramel 5 kg', '', 1, 11, 270.84, 281.673, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(85, 'Coldfil Puratos Clasik Banana 5 kg ', '', 1, 11, 219.78, 228.571, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(86, 'Coldfil Puratos Clasik Milk 1 kg ', '', 1, 3, 55.389, 57.604, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(87, 'Cream Cheease', '', 1, 10, 114.999, 119.598, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(89, 'Coklat Strawberry', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(90, 'Coklat Dark Collata', '', 1, 3, 57.668, 59.974, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(91, 'Collata Pastri White', '', 1, 3, 43.812, 45.564, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(92, 'Coklat Filling Rotte', '', 1, 3, 216.45, 225.108, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(93, 'Coklat Filling Breadline', '', 1, 3, 157.5, 163.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(94, 'Cup roti', '', 1, 3, 70, 72.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(95, 'Cup Selai SUN', '', 1, 3, 11.25, 11.7, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(96, 'Cup Saus', '', 1, 3, 10.833, 11.266, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(97, 'Cup Puding', '', 1, 3, 16.75, 17.42, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(98, 'Cup Cake ', '', 1, 3, 43.75, 45.5, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(99, 'Cup Gelas Inspira', '', 1, 3, 21, 21.84, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(100, 'Coklat Powder @ 1 kg', '', 1, 3, 117.333, 122.026, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(102, 'Cruncy chocomaltine 5 Kg', '', 1, 11, 310.5, 322.92, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(103, 'Crispy Ball Dark', '', 1, 10, 135.7, 141.128, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(105, 'Coklat Collata Dark @5Kg', '', 5, 5, 47, 48, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(106, 'Cup Muffin @100', '', 1, 3, 32, 33.28, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(107, 'Cup Bubur', '', 1, 3, 14, 14.56, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(108, 'Cup Puding MS 8', '', 1, 3, 32.5, 33.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(109, 'Cuka', '', 1, 5, 17, 18, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(110, 'DIP Glase Dark Coklat', '', 1, 11, 247.5, 257.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(111, 'DIP Glase Strawberry', '', 1, 11, 225, 234, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(112, 'DIP Glase Avocado', '', 1, 11, 245, 254.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(113, 'DIP Glase Taro', '', 1, 11, 247.5, 257.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(114, 'Evaporrade Diary Gold', '', 1, 2, 7.77, 8.08, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(115, 'Ekomul', '', 1, 11, 930, 967.2, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(116, 'Elmer Flake Chubky Dark', '', 1, 5, 59, 61, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(117, 'Easy Rotte', '', 10000, 5, 59, 61, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(118, 'FR', '', 1, 11, 272.7, 283.608, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(119, 'Gula Pasir ', '', 870, 5, 16, 16, '', '', '2024-03-22 15:52:41', '2024-03-22 15:52:41'),
(120, 'Gula Halus Wallet', '', 1, 6, 162, 168.48, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(121, 'Gula Halus Rose brand', '', 0, 0, 180, 187.2, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(122, 'Gula Aren Cair', '', 1, 2, 67, 0, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(123, 'Gandum ', '', 1, 5, 51, 53, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(124, 'Garam @200', '', 1, 5, 8, 8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(125, 'Gula Mint Donat', '', 1, 5, 31, 32, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(126, 'Isolasi', '', 1, 15, 31.25, 32.5, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(127, 'Improver S 500', '', 10, 5, 95, 99, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(128, 'Improver Soft Cotton', '', 1460, 5, 127, 131, '', '', '2024-03-20 15:29:41', '2024-03-20 14:19:11'),
(129, 'Improver Gold Plus', '', 10, 5, 48, 49, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(130, 'Keju Slice', '', 1, 3, 138.972, 144.53, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(131, 'kacang hijau', '', 1, 5, 24, 24, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(132, 'Kelapa Kering', '', 1, 5, 38, 39, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(133, 'Kelapa Kering @ 1 kg', '', 1, 3, 46.5, 48.36, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(134, 'Kotak Donat Barokah', '', 1, 6, 1.23, 1.279, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(135, 'Kotak Snack Box Barokah', '', 1, 6, 660, 686.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(136, 'Kotak Banana Cake', '', 1, 14, 3.45, 3.588, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(137, 'Kotak Swis Roll Cake', '', 1, 14, 2.6, 2.704, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(138, 'Kotak Inspira', '', 1, 14, 1.5, 1.56, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(139, 'Kotak Paper Try L Inspira', '', 1, 14, 1.15, 1.196, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(140, 'Kotak Donat Paha Ayam', '', 1, 14, 2.1, 2.184, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(141, 'Kismis', '', 1, 5, 41, 42, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(142, 'Keju Gold', '', 1, 1, 101.845, 105.918, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(143, 'Keju Cheddar Tasty', '', 1, 1, 147.994, 153.913, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(144, 'Keju Edam', '', 1, 1, 374.69, 389.677, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(145, 'Kertas loyang', '', 1, 10, 535.5, 556.92, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(146, 'Kacang Cincang/jf chopped', '', 1, 3, 50, 52, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(147, 'Kecap Ingris', '', 1, 2, 35, 36.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(148, 'Klip Roti', '', 1, 3, 320, 332.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(149, 'Kertas Thermal', '', 1, 15, 13, 13.52, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(150, 'Kertas Nasi Coklat', '', 1, 3, 20, 20.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(151, 'Kertas Nas Putih', '', 1, 3, 20, 20.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(152, 'Kertas Snack Box Jumbo', '', 1, 14, 4.959, 5.157, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(153, 'Knorr Chiken Powder', '', 1, 3, 88, 91, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(154, 'Larome Vanila Bubuk @500', '', 500, 5, 427, 443, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(155, 'Label harga', '', 1, 15, 32, 33.28, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(156, 'Larome Sweet Potato Pasta  @100', '', 1, 2, 16.733, 17.402, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(157, 'Maizena', '', 25, 5, 11, 11, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(158, 'Maestro Mustard 245gr', '', 1, 2, 21, 21.84, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(159, 'Margarin Cita White', '', 1, 10, 295, 306.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(160, 'Mayonaise', '', 1, 3, 26.787, 27.858, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(161, 'Mangkok Sup Inspira 300 ml', '', 1, 15, 16.25, 16.9, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(162, 'Meses Inova', '', 1, 10, 318, 330.72, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(163, 'Meses Elmer WW', '', 1, 5, 40, 41, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(164, 'Meseis Elmer Merah', '', 1, 5, 40, 41, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(165, 'Meses Elmer Biru Muda', '', 1, 5, 40, 41, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(166, 'Meses Elmer Hijau', '', 1, 5, 40, 41, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(167, 'Meses Elmer Kuning', '', 1, 5, 40, 41, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(168, 'Margarin Filma', '', 1, 10, 308.247, 320.576, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(169, 'Margarin Filma Presties ', '', 1, 11, 465.756, 484.386, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(170, 'Mercolede Capucino', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(171, 'Mercolede Lemon Fresh', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(172, 'Mercolede Blueberry mint', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(173, 'Mercolede Minty green', '', 1, 3, 55.833, 58.066, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(174, 'Meses Bella', '', 1, 10, 61.824, 64.296, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(175, 'Mercolade White', '', 1, 3, 55.833, 58.066, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(176, 'Mercolade Violet', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(177, 'Mercolede Banana', '', 1, 3, 55.833, 58.066, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(178, 'Mercolede Green tea', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(179, 'Mercolede Avocado', '', 1, 3, 52.917, 55.033, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(180, 'Mercolede Melon', '', 1, 3, 53.333, 55.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(181, 'Mika Tawar', '', 100, 13, 72.5, 75.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(182, 'Mika Chiffon', '', 1, 3, 67.5, 70.2, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(183, 'Minyak Padat good fry', '', 1, 10, 343.212, 356.94, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(184, 'Minyak Goreng', '', 1, 3, 34.499, 35.878, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(185, 'Mesin Label Harga', '', 1, 10, 600, 624, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(186, 'Meses A1 Nova Biru', '', 1, 10, 308, 320.32, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(187, 'Mello Cake', '', 1, 10, 745, 774.8, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(188, 'Oreo', '', 12, 5, 52, 53, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(189, 'Pettit erik Premium', '', 0, 5, 52, 54, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(190, 'Pasta Pandan 500 gr', '', 1, 12, 291.608, 303.272, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(191, 'pasta pandan olimpik 1 Kg', '', 1, 2, 130, 135.2, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(192, 'Paya Tenderizer', '', 1, 0, 113, 117, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(193, 'Paper Bowl Sablon inspira', '', 1, 15, 60, 62.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(194, 'Potato @500', '', 4, 3, 46.31, 48.162, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(195, 'Plastik Besar (Tawar) Puratos', '', 100, 6, 43.9, 45.656, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(196, 'Plastik Kecil ( Fit O) Puratos', '', 1, 6, 100, 104, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(197, 'Plastik Menengah Puratos', '', 1, 6, 118, 122.72, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(198, 'Plastik Assoy Besar Puratos', '', 1, 6, 83.5, 86.84, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(199, 'Plastik Assoy sedang Puratos', '', 1, 6, 48.1, 50.024, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(200, 'Plastik Assoy Kecil', '', 1, 6, 43.9, 45.656, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(201, 'Plastik tawar Roda', '', 1, 14, 318, 330, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(202, 'Plastik Segitiga', '', 1, 3, 37.5, 39, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(203, 'Parmesan Cheese', '', 1, 1, 360, 374.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(204, 'Puratos Tegral Chiffon Cake ', '', 10, 16, 660.45, 686.868, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(205, 'Plastik Sampah Kecil', '', 1, 3, 20.416, 21.232, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(206, 'Plastik sampah besar', '', 1, 3, 20.416, 21.232, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(207, 'Pasta Black Forest', '', 1, 2, 165.833, 172.466, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(208, 'Pisau Cake', '', 1, 3, 18, 18.72, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(209, 'Potato', '', 1, 10, 351.9, 365.976, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(210, 'Plastik Premix', '', 990, 14, 1.75, 1.82, '', '', '2024-03-20 15:29:41', '2024-03-20 14:19:11'),
(211, 'Puratos tegral Swiss Roll Cake', '', 1, 16, 508.38, 528.715, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(212, 'Puratos Tegral Cake Banana', '', 1, 16, 306.36, 318.614, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(213, 'Puratos Cream Cake Vanila', '', 1, 16, 440, 457.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(214, 'Puding Pondan Strawberry', '', 1, 14, 9.807, 10.199, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(215, 'Puding Pondan Coklat', '', 1, 14, 10.224, 10.633, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(216, 'Puding Pondan Mangga', '', 1, 14, 9.182, 9.549, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(219, 'Pasta Olimpik Strawberry @ 100', '', 1, 2, 15, 15.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(220, 'Pasta Coklat Toffieco', '', 1, 2, 29, 30.16, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(221, 'Paper Bag Coklat Inspira', '', 1, 14, 650, 676, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(222, 'Paper Bag putih Inspira', '', 1, 14, 650, 676, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(223, 'Red Bean', '', 1, 3, 213.5, 222.04, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(224, 'Red Bean Yu Ai', '', 3, 3, 126.75, 131.82, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(225, 'Ragi OK DO', '', 1, 3, 48.618, 50.562, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(226, 'Ragi Gold', '', 1, 3, 34.8, 36.192, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(227, 'Red Velvet Crumble', '', 1, 3, 145.9, 151.736, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(228, 'Saos Tomat Delmonte', '', 1, 7, 75.4, 78.415, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(229, 'Sosis', '', 1, 3, 22.5, 23.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(230, 'Sendok Puding', '', 1, 3, 5.25, 5.46, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(231, 'Sosis Virgo', '', 1, 3, 32, 33.28, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(232, 'Sukade', '', 1, 3, 29, 30.16, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(233, 'SP Olimpik', '', 1, 11, 54, 56.16, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(234, 'Susu Bubuk', '', 970, 5, 33, 33, '', '', '2024-03-22 15:52:41', '2024-03-22 15:52:41'),
(235, 'SKM', '', 1, 8, 13.125, 13.65, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(236, 'Smoke Beef Vila', '', 1, 3, 130.5, 135.72, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(237, 'Sabun Cuci', '', 1, 3, 90, 93.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(238, 'Sarung Tangan', '', 1, 10, 8.333, 8.666, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(239, 'Saus Sambal Delmonte (Sachset)', '', 1, 3, 5.72, 5.948, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(240, 'Struk Kasir Paperline', '', 1, 4, 65, 67.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(241, 'Sendok Bubur', '', 1, 3, 11, 11.44, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(242, 'Sarikaya Sonton', '', 1, 4, 224.4, 233.376, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(243, 'Sonton Coconut', '', 1, 3, 33.3, 34.632, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(244, 'Spikel', '', 1, 0, 76, 78, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(245, 'Sumpit', '', 1, 5, 8.571, 8.914, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(246, 'susu uht diamond', '', 1, 10, 16.5, 17.16, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(247, 'Susu Grandairy foaming', '', 1, 10, 18.7, 19.447, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(248, 'Sarung Tangan Oven', '', 1, 14, 115.066, 119.668, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(249, 'Srikaya puratos', '', 1, 11, 275.835, 286.868, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(250, 'Sosis Maleo', '', 1, 3, 56.65, 58.916, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(251, 'Sari Pasta', '', 1, 2, 182.97, 190.288, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(252, 'Saus Sambel Sachet AKU', '', 1, 3, 17.3, 17.992, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(253, 'Saus Sambel AKU @ 1 kg', '', 1, 3, 20.836, 21.668, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(254, 'Saus Tomat Sachet ', '', 1, 3, 13.9, 14.456, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(255, 'Saus Sambel Delmonte ', '', 1, 7, 101.8, 105.872, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(256, 'Saus Sambel AKU', '', 1, 3, 98.547, 102.488, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(257, 'Susu Bubuk NZMP', '', 1, 5, 103, 107, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(258, 'Saus Tomat 1 Kg', '', 1, 3, 16.501, 17.161, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(259, 'Tepung Protein Rendah ', '', 725, 5, 10, 10, '', '', '2024-03-20 15:29:41', '2024-03-20 14:19:11'),
(260, 'Tepung Protein Tinggi', '', 825, 5, 11, 11, '', '', '2024-03-20 15:29:41', '2024-03-20 14:19:11'),
(261, 'Tepung Panir', '', 1, 5, 19, 19, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(262, 'Tuna Chuck', '', 1, 8, 17.37, 18.064, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(263, 'Taro 100gr', '', 1, 2, 15, 15.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(264, 'Taro 1KG', '', 1, 2, 160, 166.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(265, 'Udang Rebon', '', 1, 5, 75, 78, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(266, 'Timbangan Digital', '', 1, 14, 317.8, 330.512, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(267, 'Vla Durian', '', 1, 11, 219.78, 228.571, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(268, 'Vla Puding Pondan', '', 1, 14, 5.008, 5.208, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(269, 'Vivafil Nenas', '', 1, 11, 278.61, 289.754, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(270, 'Vla Vanila Rotte', '', 1, 11, 183.15, 190.476, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(271, 'Vegetable Mix Frozen ', '', 1, 3, 31.5, 32.76, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(272, 'Vanila Kupu-kupu ', '', 1, 12, 90, 93.6, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(273, 'Vanila Essece Olimpik 1 kg', '', 1, 2, 130, 135.2, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(274, 'Whipping Cream', '', 1, 5, 56, 58, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(275, 'Wijen Putih ', '', 1, 5, 56, 58, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(276, 'Wijen Hitam', '', 1, 5, 117, 121, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(277, 'Whipiing Cream Mona Lisa', '', 1, 5, 60, 62.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(278, 'Stiker Chiffon', '', 1, 14, 8, 8.32, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(279, 'Loyang Chiffon', '', 1, 14, 35, 36.4, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(281, 'KUAS L', '', 1, 14, 43, 44.72, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(282, 'KUAS M', '', 0, 0, 39, 40.56, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(283, 'Stiker mini', '', 1, 14, 5500, 5720, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(284, 'mtl_nama', 'mtl_deskripsi', 0, 0, 0, 0, 0x6d746c5f666f746f, 0x6d746c5f626172636f6465, '2024-03-07 11:10:53', '0000-00-00 00:00:00'),
(285, 'LABEl harga JAYCO', '', 1, 15, 24, 24.96, '', '', '2024-03-07 11:10:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pbl_id` bigint(20) NOT NULL,
  `pbl_supplier` varchar(255) DEFAULT NULL,
  `pbl_tanggal` date DEFAULT NULL,
  `pbl_no_faktur` varchar(100) DEFAULT NULL,
  `pbl_total_item` bigint(20) DEFAULT NULL,
  `pbl_total_harga` bigint(20) DEFAULT NULL,
  `pbl_user` bigint(20) DEFAULT NULL,
  `pbl_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`pbl_id`, `pbl_supplier`, `pbl_tanggal`, `pbl_no_faktur`, `pbl_total_item`, `pbl_total_harga`, `pbl_user`, `pbl_date_created`) VALUES
(19, 'PT Puratos Indonesia', '2024-03-18', '012345689', 6, 1946800, 1, '2024-03-20 14:19:11'),
(20, 'PT Fonterra Brands Indonesia', '2024-04-04', '038526', 3, 15116280, 1, '2024-04-04 14:58:56'),
(21, 'PT Puratos Indonesia', '2024-04-05', '5354863254', 4, 29024740, 1, '2024-04-05 11:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `pbd_id` bigint(20) NOT NULL,
  `pbd_pbl_id` bigint(20) DEFAULT NULL,
  `pbd_mtl_id` bigint(20) DEFAULT NULL,
  `pbd_qty` int(11) DEFAULT NULL,
  `pbd_satuan` varchar(20) DEFAULT NULL,
  `pbd_harga` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`pbd_id`, `pbd_pbl_id`, `pbd_mtl_id`, `pbd_qty`, `pbd_satuan`, `pbd_harga`) VALUES
(19, 19, 210, 1000, 'Pcs', 1750000),
(20, 19, 260, 1000, 'Gram', 11200),
(21, 19, 259, 1000, 'Gram', 10200),
(22, 19, 234, 1000, 'Gram', 32600),
(23, 19, 128, 1000, 'Gram', 126800),
(24, 19, 119, 1000, 'Gram', 16000),
(25, 20, 6, 100, 'Gram', 15800),
(26, 20, 7, 100, 'Bungkus', 15100000),
(27, 20, 9, 10, 'Gram', 480),
(28, 21, 6, 30, 'Gram', 4740),
(29, 21, 7, 20, 'Bungkus', 3020000),
(30, 21, 10, 10, 'Dus', 13000000),
(31, 21, 11, 10, 'Dus', 13000000);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `kel_id` bigint(20) NOT NULL,
  `kel_tanggal` date DEFAULT NULL,
  `kel_nama` varchar(255) DEFAULT NULL,
  `kel_jml` double DEFAULT NULL,
  `kel_ket` text DEFAULT NULL,
  `kel_user` bigint(20) DEFAULT NULL,
  `kel_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`kel_id`, `kel_tanggal`, `kel_nama`, `kel_jml`, `kel_ket`, `kel_user`, `kel_date_created`) VALUES
(1, '2024-03-19', 'Gas 2kg', 250000, 'beli gas di warung', 1, '2024-03-27 00:00:00'),
(2, '2024-03-26', 'Air Galon', 30000, '3 galon', 1, '2024-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `pjl_id` bigint(20) NOT NULL,
  `pjl_faktur` varchar(50) DEFAULT NULL,
  `pjl_tanggal` date DEFAULT NULL,
  `pjl_customer` varchar(150) DEFAULT NULL,
  `pjl_total_item` bigint(20) DEFAULT NULL,
  `pjl_jenis_harga` smallint(1) DEFAULT NULL COMMENT '1=4%, 2=hpp',
  `pjl_jumlah_bayar` bigint(20) DEFAULT NULL,
  `pjl_jenis_bayar` smallint(1) DEFAULT NULL COMMENT '1=tf, 2=cash',
  `pjl_status_bayar` smallint(1) DEFAULT NULL COMMENT '0=tertunda, 1=jatuh tempo, 2=lunas',
  `pjl_status` smallint(1) DEFAULT NULL COMMENT '1=menunggu, 2=dikirim, 3=ditolak, 4=selesai',
  `pjl_barcode` longblob DEFAULT NULL,
  `pjl_user` bigint(20) DEFAULT NULL,
  `pjl_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`pjl_id`, `pjl_faktur`, `pjl_tanggal`, `pjl_customer`, `pjl_total_item`, `pjl_jenis_harga`, `pjl_jumlah_bayar`, `pjl_jenis_bayar`, `pjl_status_bayar`, `pjl_status`, `pjl_barcode`, `pjl_user`, `pjl_date_created`) VALUES
(1, 'INV0001', '2024-04-05', 'ROTTE BAKERY AIR MOLEK', 1, 1, 1650, 1, 0, 1, 0x89504e470d0a1a0a0000000d49484452000001290000005501030000002fc080cf00000006504c5445000000ffffffa5d99fdd000000097048597300000ec400000ec401952b0e1b00000140494441544889edd1314bc3401806e04a061184ce855244a47170102a62e0e88dfa175cab24ab98258160ea5404a54aa78398fc86fe83968a150cbd55108760e9adca2d0d1cf7995217d345459ceed67beefd5ebe2bc0a3fbb2bf7e7bd1ddadde1f96ae1ae6ce53b7d6b87b782e1d552f0f6ebae6d668139a05c514534c31c514534cb1bf67df393f621a0a5d217d0c2d96480f22b44c59bfb786f05746cbe1c9d4ab63a80d62e1f89532b48701e8699463aba1691b01962e091dbb5e8ea1d892bece699ec554ef500c2992a75640c66dca843c76f3691b9f8c2331b108195b94bd8bd7856e73863486d291d5218c676929907cda76324fa388f7f4eb9519933674f2ddf692896d441822925de3209e318b2d32fe36f530063ca0d2f1c34ad62da0dcc80dd5104f85f48a728935cfb2f5e2a276dea7d9c35f7d96628afd13fb002ca7f6c0acdc56b00000000049454e44ae426082, 1, '2024-04-05 11:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `pjd_id` bigint(20) NOT NULL,
  `pjd_pjl_id` bigint(20) DEFAULT NULL,
  `pjd_mtl_id` bigint(20) DEFAULT NULL,
  `pjd_qty` int(11) DEFAULT NULL,
  `pjd_smt_id` bigint(20) DEFAULT NULL,
  `pjd_harga` double DEFAULT NULL,
  `pjd_status` smallint(1) DEFAULT NULL COMMENT '1=cart, 2=dikirim, 3=ditolak, 4=selesai',
  `pjd_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`pjd_id`, `pjd_pjl_id`, `pjd_mtl_id`, `pjd_qty`, `pjd_smt_id`, `pjd_harga`, `pjd_status`, `pjd_date_created`) VALUES
(1, 1, 6, 10, 5, 1650, 1, '2024-04-05 11:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `premix`
--

CREATE TABLE `premix` (
  `pmx_id` bigint(20) NOT NULL,
  `pmx_nama` varchar(100) DEFAULT NULL,
  `pmx_harga` double DEFAULT NULL,
  `pmx_harga_jual` double DEFAULT NULL,
  `pmx_stok` bigint(20) DEFAULT NULL,
  `pmx_status` smallint(1) DEFAULT NULL COMMENT '0=nonaktif, 1=aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `premix`
--

INSERT INTO `premix` (`pmx_id`, `pmx_nama`, `pmx_harga`, `pmx_harga_jual`, `pmx_stok`, `pmx_status`) VALUES
(1, 'Premix Roti Bagelan 1 Kg', 11062, 0, 1, 1),
(2, 'Premix Roti Bagelan 2 Kg', 20374, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `premix_detail`
--

CREATE TABLE `premix_detail` (
  `pxd_id` bigint(20) NOT NULL,
  `pxd_pmx_id` bigint(20) DEFAULT NULL,
  `pxd_mtl_id` bigint(20) DEFAULT NULL,
  `pxd_mtl_nama` varchar(255) DEFAULT NULL,
  `pxd_qty` int(11) DEFAULT NULL,
  `pxd_hpp` double DEFAULT NULL,
  `pxd_harga` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `premix_detail`
--

INSERT INTO `premix_detail` (`pxd_id`, `pxd_pmx_id`, `pxd_mtl_id`, `pxd_mtl_nama`, `pxd_qty`, `pxd_hpp`, `pxd_harga`) VALUES
(10, 1, 210, 'Plastik Premix', 1, 1750, 1750),
(11, 1, 260, 'Tepung Protein Tinggi', 200, 11.2, 2240),
(12, 1, 259, 'Tepung Protein Rendah ', 300, 10.2, 3060),
(13, 1, 234, 'Susu Bubuk', 30, 32.6, 978),
(14, 1, 128, 'Improver Soft Cotton', 5, 126.8, 634),
(15, 1, 119, 'Gula Pasir ', 150, 16, 2400),
(16, 2, 210, 'Plastik Premix', 1, 1750, 1750),
(17, 2, 260, 'Tepung Protein Tinggi', 400, 11.2, 4480),
(18, 2, 259, 'Tepung Protein Rendah ', 600, 10.2, 6120),
(19, 2, 234, 'Susu Bubuk', 60, 32.6, 1956),
(20, 2, 128, 'Improver Soft Cotton', 10, 126.8, 1268),
(21, 2, 119, 'Gula Pasir ', 300, 16, 4800);

-- --------------------------------------------------------

--
-- Table structure for table `premix_stok`
--

CREATE TABLE `premix_stok` (
  `pxs_id` bigint(20) NOT NULL,
  `pxs_pmx_id` bigint(20) DEFAULT NULL,
  `pxs_tipe` smallint(1) DEFAULT NULL COMMENT '1=penambahan, 2=pengurangan',
  `pxs_qty` bigint(20) DEFAULT NULL,
  `pxs_user` bigint(20) DEFAULT NULL,
  `pxs_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `premix_stok`
--

INSERT INTO `premix_stok` (`pxs_id`, `pxs_pmx_id`, `pxs_tipe`, `pxs_qty`, `pxs_user`, `pxs_date_created`) VALUES
(5, 1, 1, 1, 1, '2024-03-20 15:29:41'),
(6, 1, 1, 1, 1, '2024-03-26 15:04:56'),
(7, 1, 2, 1, 1, '2024-03-26 15:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `satuan_material`
--

CREATE TABLE `satuan_material` (
  `smt_id` int(11) NOT NULL,
  `smt_nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `satuan_material`
--

INSERT INTO `satuan_material` (`smt_id`, `smt_nama`) VALUES
(1, 'Blok'),
(2, 'Botol'),
(3, 'Bungkus'),
(4, 'Dus'),
(5, 'Gram'),
(6, 'Ikat'),
(7, 'Jeregen'),
(8, 'Kaleng'),
(9, 'Karung'),
(10, 'Kotak'),
(11, 'Pail'),
(12, 'PAK'),
(13, 'Pc'),
(14, 'Pcs'),
(15, 'Roll'),
(16, 'Sak');

-- --------------------------------------------------------

--
-- Table structure for table `status_pengiriman`
--

CREATE TABLE `status_pengiriman` (
  `sp_id` int(11) NOT NULL,
  `sp_nama` varchar(100) DEFAULT NULL,
  `sp_kode` varchar(20) DEFAULT NULL,
  `sp_ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `status_pengiriman`
--

INSERT INTO `status_pengiriman` (`sp_id`, `sp_nama`, `sp_kode`, `sp_ket`) VALUES
(1, 'Dikirim', 'BK', 'Terbit Resi'),
(3, 'Transit', 'TR', 'Transit Hub'),
(6, 'Terkirim', 'POD', 'Diterima Konsumen');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `spl_id` bigint(20) NOT NULL,
  `spl_nama` varchar(255) DEFAULT NULL,
  `spl_notelp` varchar(20) DEFAULT NULL,
  `spl_alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`spl_id`, `spl_nama`, `spl_notelp`, `spl_alamat`) VALUES
(1, 'PT Puratos Indonesia', '021-5678113/4', 'Jl. Prof Dr. Latumeten Jakarta 11460'),
(2, 'PT Fonterra Brands Indonesia', '62 21 828 1881', 'Jl. Casablanca Kav 88, Jakarta  12870');

-- --------------------------------------------------------

--
-- Table structure for table `sys_login`
--

CREATE TABLE `sys_login` (
  `log_id` bigint(20) NOT NULL,
  `log_nama` varchar(100) DEFAULT NULL,
  `log_user` varchar(20) DEFAULT NULL,
  `log_pass` varchar(255) DEFAULT NULL,
  `log_level` smallint(1) DEFAULT NULL COMMENT '2=admin, 3=admingudang, 4=konsumen',
  `log_unit_kerja` varchar(200) DEFAULT NULL,
  `log_aktif` smallint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sys_login`
--

INSERT INTO `sys_login` (`log_id`, `log_nama`, `log_user`, `log_pass`, `log_level`, `log_unit_kerja`, `log_aktif`) VALUES
(1, 'Administrator', 'administrator', 'ea60fc010787079d8aa3163ad9ef55e8', 1, NULL, 1),
(5, 'Bobby Saputra', 'bobby', '72b4aef5d1778c6d8151a4589ba57b68', 3, 'PT Logistik Olah Gemilang', 1),
(6, 'Ulani Handa', 'ulani', '82745d38846a29b727e410a3b6a0e821', 2, 'PT Logistik Olah Gemilang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipe_alamat`
--

CREATE TABLE `tipe_alamat` (
  `ta_id` int(11) NOT NULL,
  `ta_nama` varchar(100) DEFAULT NULL,
  `ta_ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tipe_alamat`
--

INSERT INTO `tipe_alamat` (`ta_id`, `ta_nama`, `ta_ket`) VALUES
(1, 'Pabrik', ''),
(2, 'Toko', '');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `tr_id` int(11) NOT NULL,
  `tr_pjl_faktur` varchar(200) DEFAULT NULL,
  `tr_sp_kode` varchar(20) DEFAULT NULL,
  `tr_waktu_scan` datetime NOT NULL,
  `tr_jenis` smallint(1) DEFAULT NULL COMMENT '1=masuk, 2=keluar',
  `tr_user` int(11) DEFAULT NULL,
  `tr_tujuan` varchar(255) DEFAULT NULL,
  `tr_kode_manifest` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  ADD PRIMARY KEY (`jp_id`);

--
-- Indexes for table `manifest`
--
ALTER TABLE `manifest`
  ADD PRIMARY KEY (`mf_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`mtl_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pbl_id`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`pbd_id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`kel_id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`pjl_id`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`pjd_id`);

--
-- Indexes for table `premix`
--
ALTER TABLE `premix`
  ADD PRIMARY KEY (`pmx_id`);

--
-- Indexes for table `premix_detail`
--
ALTER TABLE `premix_detail`
  ADD PRIMARY KEY (`pxd_id`);

--
-- Indexes for table `premix_stok`
--
ALTER TABLE `premix_stok`
  ADD PRIMARY KEY (`pxs_id`);

--
-- Indexes for table `satuan_material`
--
ALTER TABLE `satuan_material`
  ADD PRIMARY KEY (`smt_id`);

--
-- Indexes for table `status_pengiriman`
--
ALTER TABLE `status_pengiriman`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`spl_id`);

--
-- Indexes for table `sys_login`
--
ALTER TABLE `sys_login`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tipe_alamat`
--
ALTER TABLE `tipe_alamat`
  ADD PRIMARY KEY (`ta_id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`tr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  MODIFY `jp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manifest`
--
ALTER TABLE `manifest`
  MODIFY `mf_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `mtl_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pbl_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `pbd_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `kel_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `pjl_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `pjd_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `premix`
--
ALTER TABLE `premix`
  MODIFY `pmx_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `premix_detail`
--
ALTER TABLE `premix_detail`
  MODIFY `pxd_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `premix_stok`
--
ALTER TABLE `premix_stok`
  MODIFY `pxs_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `satuan_material`
--
ALTER TABLE `satuan_material`
  MODIFY `smt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `status_pengiriman`
--
ALTER TABLE `status_pengiriman`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `spl_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sys_login`
--
ALTER TABLE `sys_login`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tipe_alamat`
--
ALTER TABLE `tipe_alamat`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
