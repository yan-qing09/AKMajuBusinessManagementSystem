-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2024 at 01:14 PM
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
-- Database: `akmajuco_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

CREATE TABLE `password_reset_temp` (
  `email` varchar(40) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `password_reset_temp`
--

INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES
('oyiyan22@gmail.com', 'a080ddf7b1a10e0b59a1ad9f1b8f37db7256fb5f2b', '2024-02-03 18:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_adjustment`
--

CREATE TABLE `tb_adjustment` (
  `C_id` varchar(5) NOT NULL,
  `U_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_advertisement_adjustment`
--

CREATE TABLE `tb_advertisement_adjustment` (
  `U_id` varchar(3) NOT NULL,
  `AM_id` varchar(6) NOT NULL,
  `AMH_date` datetime NOT NULL,
  `AMH_soldQty` int(11) NOT NULL,
  `AMH_sellingQty` int(11) NOT NULL,
  `AMH_unsoldQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_advertisement_adjustment`
--

INSERT INTO `tb_advertisement_adjustment` (`U_id`, `AM_id`, `AMH_date`, `AMH_soldQty`, `AMH_sellingQty`, `AMH_unsoldQty`) VALUES
('001', 'A001', '2024-01-29 22:39:56', 0, 0, 82),
('001', 'A001', '2024-01-29 23:02:05', 0, 3, 79),
('001', 'A001', '2024-01-29 23:35:53', 10, 3, 69),
('001', 'A001', '2024-01-30 01:12:28', 18, 0, 30),
('001', 'A003', '2024-01-29 23:01:59', 0, 0, 70),
('001', 'A003', '2024-01-29 23:02:05', 0, 2, 68),
('001', 'A003', '2024-01-29 23:35:53', 10, 2, 58),
('001', 'A003', '2024-01-30 01:12:28', 206, 395, 29),
('003', 'A002', '2024-01-03 23:25:09', 20, 0, 0),
('003', 'A002', '2024-01-30 03:34:23', 20, 15, 13),
('003', 'A002', '2024-01-30 03:34:52', 20, 15, 16);

-- --------------------------------------------------------

--
-- Table structure for table `tb_advertisement_material`
--

CREATE TABLE `tb_advertisement_material` (
  `AM_id` varchar(6) NOT NULL,
  `AM_name` varchar(50) NOT NULL,
  `AM_variation` varchar(20) NOT NULL,
  `AM_dimension` varchar(20) NOT NULL,
  `AM_unit` varchar(15) NOT NULL,
  `AM_price` decimal(7,2) NOT NULL,
  `AM_cost` decimal(7,2) NOT NULL,
  `AM_markUp` decimal(5,2) NOT NULL,
  `AM_type` int(11) NOT NULL,
  `AM_lastMod` datetime NOT NULL,
  `AM_totalQty` int(5) NOT NULL,
  `AM_unsoldQty` int(5) NOT NULL,
  `AM_sellingQty` int(5) NOT NULL,
  `AM_soldQty` int(5) NOT NULL,
  `LS_status` varchar(10) NOT NULL,
  `LS_qty` int(11) NOT NULL,
  `is_archived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_advertisement_material`
--

INSERT INTO `tb_advertisement_material` (`AM_id`, `AM_name`, `AM_variation`, `AM_dimension`, `AM_unit`, `AM_price`, `AM_cost`, `AM_markUp`, `AM_type`, `AM_lastMod`, `AM_totalQty`, `AM_unsoldQty`, `AM_sellingQty`, `AM_soldQty`, `LS_status`, `LS_qty`, `is_archived`) VALUES
('A001', 'Wood', 'redwood', '10x5', 'm3', 57.00, 43.00, 32.56, 1, '2024-02-03 00:51:13', 30, 30, 0, 18, 'In Stock', 29, 0),
('A002', 'Wood', 'holo', '25', 'm', 15.00, 20.00, 33.33, 1, '2024-01-30 03:34:52', 31, 16, 15, 20, 'In Stock', 14, 0),
('A003', 'Vinyl Banner', 'Matte Finish', '3ft x 6ft', 'm^2', 30.00, 1.00, 30.00, 2, '2023-12-28 17:40:41', 424, 29, 395, 206, 'LOW', 20, 0),
('A004', 'Wood', 'haha', '50', 'm', 30.00, 45.00, 33.33, 1, '2023-12-25 14:33:38', 30, 15, 15, 20, 'Low', 20, 0),
('A005', 'Water', '-', '25', 'litre', 30.00, 10.00, 33.33, 1, '2024-01-16 15:55:09', 30, 16, 15, 20, 'Low', 20, 1),
('AM0006', 'jojoe', 'jojoe', 'jojoe', '', 4.00, 3.00, 0.00, 3, '2024-01-02 10:05:57', 6, 6, 3, 7, 'In Stock', 5, 1),
('AM0007', 'cc', 'cc', 'cc', 'cc', 145.00, 123.00, 17.89, 1, '2024-01-17 04:26:11', 25, 25, 0, 0, 'In Stock', 12, 0),
('AM0008', 'kk', 'kk', 'kk', 'kk', 34.00, 123.00, -72.36, 1, '2024-01-23 13:17:54', 34, 34, 0, 0, 'Low', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_advertisement_order`
--

CREATE TABLE `tb_advertisement_order` (
  `O_id` varchar(6) NOT NULL,
  `O_date` date NOT NULL,
  `O_remark` varchar(100) NOT NULL,
  `O_totalCost` decimal(8,2) NOT NULL,
  `O_totalPrice` decimal(8,2) NOT NULL,
  `C_id` varchar(5) NOT NULL,
  `O_TOP` int(11) NOT NULL,
  `AO_deliveryStatus` int(11) NOT NULL,
  `AO_paymentStatus` int(11) NOT NULL,
  `AO_invoiceStatus` int(11) NOT NULL,
  `O_quotationStatus` int(11) NOT NULL,
  `AO_deposit` decimal(10,0) NOT NULL,
  `AO_payMethod` int(11) NOT NULL,
  `AO_payDate` date DEFAULT NULL,
  `O_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_advertisement_order`
--

INSERT INTO `tb_advertisement_order` (`O_id`, `O_date`, `O_remark`, `O_totalCost`, `O_totalPrice`, `C_id`, `O_TOP`, `AO_deliveryStatus`, `AO_paymentStatus`, `AO_invoiceStatus`, `O_quotationStatus`, `AO_deposit`, `AO_payMethod`, `AO_payDate`, `O_status`) VALUES
('A0001', '2024-01-31', 'No', 2590.00, 3650.60, 'C003', 1, 11, 0, 11, 11, 0, 0, NULL, 2),
('A0002', '2024-01-29', 'Sign Board', 9000.00, 22230.00, 'C002', 1, 0, 8, 0, 4, 2000, 1, '2024-01-29', 1),
('A0003', '2024-01-30', 'Haha', 173.00, 257.42, 'C003', 1, 0, 8, 0, 4, 0, 0, NULL, 1),
('A0004', '2024-01-30', '23', 1.00, 30.70, 'C017', 1, 0, 0, 0, 0, 0, 0, NULL, 3),
('A0005', '2024-01-31', 'w', 0.00, 0.00, 'C011', 1, 0, 0, 0, 0, 0, 0, NULL, 3),
('A0006', '2024-02-02', 'Assign Board', 1.00, 30.70, 'C002', 2, 0, 0, 0, 0, 0, 0, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_advertisement_quotation`
--

CREATE TABLE `tb_advertisement_quotation` (
  `AQ_id` varchar(50) NOT NULL,
  `AQ_issueDate` date NOT NULL,
  `AQ_dueDate` date NOT NULL,
  `AQ_path` varchar(100) NOT NULL,
  `AQ_remark` varchar(50) DEFAULT NULL,
  `AQ_status` int(11) NOT NULL,
  `O_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_agency_government`
--

CREATE TABLE `tb_agency_government` (
  `C_id` varchar(5) NOT NULL,
  `AG_name` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_agency_government`
--

INSERT INTO `tb_agency_government` (`C_id`, `AG_name`) VALUES
('C002', 'Jabatan Imigresen'),
('C003', 'AKMaju');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ag_phone`
--

CREATE TABLE `tb_ag_phone` (
  `C_id` varchar(5) NOT NULL,
  `AG_phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_ag_phone`
--

INSERT INTO `tb_ag_phone` (`C_id`, `AG_phone`) VALUES
('C002', '063358220'),
('C003', '068882222');

-- --------------------------------------------------------

--
-- Table structure for table `tb_am_history`
--

CREATE TABLE `tb_am_history` (
  `AM_id` varchar(6) NOT NULL,
  `AMH_date` datetime NOT NULL,
  `AMH_cost` float NOT NULL,
  `AMH_price` float NOT NULL,
  `U_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_am_history`
--

INSERT INTO `tb_am_history` (`AM_id`, `AMH_date`, `AMH_cost`, `AMH_price`, `U_id`) VALUES
('A001', '2024-01-17 04:13:27', 46, 57, '001'),
('A001', '2024-01-17 04:38:50', 43, 57, '001'),
('A003', '2024-01-17 04:36:10', 10, 30, '001'),
('A003', '2024-01-17 04:43:56', 11, 30, '001'),
('A003', '2024-01-17 04:44:38', 12, 30, '001'),
('A003', '2024-01-17 04:45:26', 12, 30, '001'),
('A003', '2024-01-17 08:47:44', 15, 30, '001'),
('AM0007', '2024-01-17 04:24:43', 123, 145, '001'),
('AM0008', '2024-01-23 13:17:54', 123, 34, '003');

-- --------------------------------------------------------

--
-- Table structure for table `tb_am_type`
--

CREATE TABLE `tb_am_type` (
  `AM_type` int(11) NOT NULL,
  `T_Desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_am_type`
--

INSERT INTO `tb_am_type` (`AM_type`, `T_Desc`) VALUES
(1, 'Brochures'),
(2, 'Banner'),
(3, 'Posters'),
(4, 'Printers');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ao_material`
--

CREATE TABLE `tb_ao_material` (
  `AM_id` varchar(12) NOT NULL,
  `AOM_qty` int(5) NOT NULL,
  `AOM_unit` decimal(7,2) NOT NULL,
  `AOM_totalcost` decimal(7,2) NOT NULL,
  `AOM_totalprice` decimal(7,2) NOT NULL,
  `AOM_origincost` decimal(7,2) NOT NULL,
  `AOM_adjustprice` decimal(7,2) NOT NULL,
  `AOM_discPct` decimal(7,2) NOT NULL,
  `AOM_discAmt` decimal(7,2) NOT NULL,
  `AOM_taxcode` varchar(10) NOT NULL,
  `AOM_taxAmt` decimal(7,2) NOT NULL,
  `O_id` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_ao_material`
--

INSERT INTO `tb_ao_material` (`AM_id`, `AOM_qty`, `AOM_unit`, `AOM_totalcost`, `AOM_totalprice`, `AOM_origincost`, `AOM_adjustprice`, `AOM_discPct`, `AOM_discAmt`, `AOM_taxcode`, `AOM_taxAmt`, `O_id`) VALUES
('A001', 3, 20.00, 2580.00, 3353.60, 43.00, 57.00, 2.00, 67.07, '22', 2.00, 'A0001'),
('A001', 10, 20.00, 8600.00, 10830.00, 43.00, 57.00, 5.00, 541.50, '-', 0.00, 'A0002'),
('A001', 2, 2.00, 172.00, 226.72, 43.00, 57.00, 1.00, 2.27, '1', 1.00, 'A0003'),
('A003', 2, 5.00, 10.00, 297.00, 1.00, 30.00, 1.00, 2.97, '-', 0.00, 'A0001'),
('A003', 10, 40.00, 400.00, 11400.00, 1.00, 30.00, 5.00, 570.00, '-', 0.00, 'A0002'),
('A003', 1, 1.00, 1.00, 30.70, 1.00, 30.00, 1.00, 0.31, '1', 1.00, 'A0003'),
('A003', 1, 1.00, 1.00, 30.70, 1.00, 30.00, 1.00, 0.31, '1', 1.00, 'A0004'),
('A003', 1, 1.00, 1.00, 30.70, 1.00, 30.00, 1.00, 0.31, '1', 1.00, 'A0006');

-- --------------------------------------------------------

--
-- Table structure for table `tb_aq_generation`
--

CREATE TABLE `tb_aq_generation` (
  `AQ_id` varchar(50) NOT NULL,
  `U_id` varchar(3) NOT NULL,
  `D_Progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_cm_ctgy`
--

CREATE TABLE `tb_cm_ctgy` (
  `CM_ctgy` int(11) NOT NULL,
  `C_desc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_cm_ctgy`
--

INSERT INTO `tb_cm_ctgy` (`CM_ctgy`, `C_desc`) VALUES
(1, 'Elektrik'),
(2, 'Kejuteraan Awam');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cm_type`
--

CREATE TABLE `tb_cm_type` (
  `CM_type` varchar(4) NOT NULL,
  `T_desc` varchar(100) NOT NULL,
  `CM_ctgy` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_cm_type`
--

INSERT INTO `tb_cm_type` (`CM_type`, `T_desc`, `CM_ctgy`) VALUES
('4A', 'MENGGALI TANAH, PARIT DAN LAIN-LAIN', 2),
('4B', 'TUKANG KONKRIT', 2),
('4C', 'TUKANG BATA', 2),
('4D', 'TUKANG TALI AIR NAJIS', 2),
('4E', 'TUKANG BATU', 2),
('4F', 'TUKANG BUMBUNG', 2),
('4G', 'TUKANG KAYU DAN TUKANG TANGGAM', 2),
('4H', 'TUKANG PERALATAN BESI', 2),
('4I', 'KELULI DAN PEKERJAAN BESI', 2),
('4J', 'TUKANG UBIN, TUKANG LEPA DAN PEMASANG JUBIN', 2),
('4K', 'PERTUKANGAN PAIP', 2),
('4L', 'PERTUKANGAN KACA', 2),
('4M', 'TUKANG CAT', 2),
('4N', 'KERJA-KERJA PEMBINAAN JALAN', 2),
('4O', 'KERJA-KERJA PAIP AIR UTAMA', 2),
('4P', 'Pokok', 2),
('I', 'PENDAWAIAN', 1),
('II', 'PAPAN AGIHAN, PEMUTUS LITAR DAN PERALATAN PERLINDUNGAN', 1),
('III', 'ALAT-ALAT LENGKAP PENDAWAIAN ELEKTRIK', 1),
('IV', 'LENGKAPAN PENCAHAYAAN, LAMPU, KOMPONEN-KOMPONEN LAMPU DAN KIPAS', 1),
('V', 'PEMASANGAN LUAR - LAMPU JALAN, LAMPU ISYARAT DAN LAMPU KAWASAN', 1),
('VI', 'KABEL BAWAH TANAH DAN AKSESORI', 1),
('VII', 'PELBAGAI', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_construction_material`
--

CREATE TABLE `tb_construction_material` (
  `CM_type` varchar(5) NOT NULL,
  `CM_subtype` varchar(150) NOT NULL,
  `CM_id` varchar(6) NOT NULL,
  `CM_name` varchar(500) NOT NULL,
  `CM_unit` varchar(5) NOT NULL,
  `CM_variation` varchar(150) NOT NULL,
  `CM_price` decimal(7,2) NOT NULL,
  `is_archived` int(1) NOT NULL DEFAULT 0,
  `CM_lastMod` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_construction_material`
--

INSERT INTO `tb_construction_material` (`CM_type`, `CM_subtype`, `CM_id`, `CM_name`, `CM_unit`, `CM_variation`, `CM_price`, `is_archived`, `CM_lastMod`) VALUES
('4A', 'MEMOTONG POKOK', 'A1', 'Ukur lilit tidak melebihi 600mm', 'NO', 'Pokok biasa', 297.00, 1, NULL),
('4A', 'MEMOTONG POKOK', 'A1', 'Ukur lilit tidak melebihi 600mm', 'NO', 'Pokok kelapa', 198.00, 0, NULL),
('4A', 'MEMOTONG POKOK', 'A2', 'Ukur lilit melebihi 600mm dan tidak melebihi 1200mm.', 'NO', 'Pokok biasa', 387.00, 0, NULL),
('4A', 'MEMOTONG POKOK', 'A2', 'Ukur lilit melebihi 600mm dan tidak melebihi 1200mm.', 'NO', 'Pokok kelapa', 258.00, 0, NULL),
('4A', 'MENGGALI â€˜UNDERPINNINGâ€™', 'A36', 'Mengorek ke bawah permukaan tanah biasa untuk kerja-kerja penambahan asas landasan dasar (ground pinning), jumlah dalamnya tidak melebihi 1500mm, diukur dari paras bumi dan kerja mengangkut keluar (dengan tangan)', 'M3', '-', 62.40, 0, '2024-01-17 02:09:38'),
('4A', 'MENANAM RUMPUT', 'A51', 'Jarak antara kepingan rumput : 1200mm', 'M2', 'Bekal dan tanam', 1.10, 0, NULL),
('4A', 'MENANAM RUMPUT', 'A51', 'Jarak antara kepingan rumput : 1200mm', 'M2', 'Ekstra untuk pasak ke tebing', 0.30, 0, NULL),
('4A', 'MENANAM RUMPUT', 'A51', 'Jarak antara kepingan rumput : 1200mm', 'M2', 'Upah menanam sahaja', 0.40, 0, NULL),
('4A', 'MENANAM RUMPUT', 'A51', 'Jarak antara kepingan rumput : 1200mm', 'M2', 'Upah mengambil di tapak bina', 0.30, 0, NULL),
('4A', 'QQ3', 'SS1', 'REDWOORD', 'A', 'S', 123.00, 0, '2024-01-17 04:55:53'),
('4B', 'QQQ', 'A123', 'na', 'dv', 'ssd', 263.00, 0, '2024-01-15 23:49:05'),
('4B', 'KONKRIT', 'B1', 'Konkrit dalam peparit, lubang, lantai dan dinding yang lebih 300mm tebal.', 'M3', 'Grade 15 (1:3:6-25mm) : B.Kapur', 369.70, 0, NULL),
('4B', 'KONKRIT', 'B1', 'Konkrit dalam peparit, lubang, lantai dan dinding yang lebih 300mm tebal.', 'M3', 'Grade 15 (1:3:6-25mm) : Granit', 362.40, 0, NULL),
('4B', 'KONKRIT', 'B1', 'Konkrit dalam peparit, lubang, lantai dan dinding yang lebih 300mm tebal.', 'M3', 'Grade 15 (1:3:6-38mm) : B.Kapur', 369.60, 0, NULL),
('4B', 'KONKRIT', 'B1', 'Konkrit dalam peparit, lubang, lantai dan dinding yang lebih 300mm tebal.', 'M3', 'Grade 15 (1:3:6-38mm) : Granit', 363.60, 0, NULL),
('4B', 'ANAK TANGGA', 'B22', 'Kepala tembok, konises, birai hias, ambang, tangga, bendul dan lain-lain termasuk semua penetap-penetap (dowels) yang perlu dan dibentuk dengan sempurna (diukur mengikut ukuran keseluruhan)', 'M3', 'Bekal dan Pasang : B.Kapur', 999.99, 0, NULL),
('4B', 'ANAK TANGGA', 'B22', 'Kepala tembok, konises, birai hias, ambang, tangga, bendul dan lain-lain termasuk semua penetap-penetap (dowels) yang perlu dan dibentuk dengan sempurna (diukur mengikut ukuran keseluruhan)', 'M3', 'Bekal dan Pasang : Granit', 994.90, 0, NULL),
('4B', 'ANAK TANGGA', 'B22', 'Kepala tembok, konises, birai hias, ambang, tangga, bendul dan lain-lain termasuk semua penetap-penetap (dowels) yang perlu dan dibentuk dengan sempurna (diukur mengikut ukuran keseluruhan)', 'M3', 'Tanggal & Buang', 142.80, 0, NULL),
('4B', 'ANAK TANGGA', 'B22', 'Kepala tembok, konises, birai hias, ambang, tangga, bendul dan lain-lain termasuk semua penetap-penetap (dowels) yang perlu dan dibentuk dengan sempurna (diukur mengikut ukuran keseluruhan)', 'M3', 'Tanggal & pasang semula', 243.50, 0, NULL),
('4B', 'PAPAK LAPIK DAN PENUTUP', 'B43', '150mm x 150mm x 1200mm Ketinggian tiang pagar dan palang pengukuh	NO	65.30	65.60\r\nbertetulang dengan 4 batang 8mm diameter bar keluli lembut dan 1.6mm dawai pengikat berjarak 150mm dan membuat lubang di tiang untuk memasang pagar\r\n', 'NO', 'B.Kapur', 63.00, 0, NULL),
('4B', 'PAPAK LAPIK DAN PENUTUP', 'B43', '150mm x 150mm x 1200mm Ketinggian tiang pagar dan palang pengukuh	NO	65.30	65.60\r\nbertetulang dengan 4 batang 8mm diameter bar keluli lembut dan 1.6mm dawai pengikat berjarak 150mm dan membuat lubang di tiang untuk memasang pagar\r\n', 'NO', 'B.Pejal', 62.60, 0, NULL),
('4C', 'MEMBAIKI DINDING-DINDING LAMA', 'C19', 'Membuat lurah atau londar pada dinding lama untuk paip tidak melebihi 50mm diameter dan membaiki semula kerosakan disekelilingnya', 'M', '', 20.20, 0, NULL),
('4C', 'DINDING BARU', 'C3', 'Dinding bata tanah liat 225mm tebal', 'M2', 'Mortar : Simen dan pasir (1:3)', 126.00, 0, NULL),
('4C', 'DINDING BARU', 'C3', 'Dinding bata tanah liat 225mm tebal', 'M2', 'Mortar : Simen, kapur, pasir (1:1:6)', 118.00, 0, NULL),
('4C', 'DINDING BARU', 'C3', 'Dinding bata tanah liat 225mm tebal', 'M2', 'Mortar : Simen, pasir (1:6) p\"ciser\r\n', 118.70, 0, NULL),
('4D', 're', '4A1', 're', 're', 're', 23.00, 1, '2024-01-08 23:42:25'),
('4D', 'MENGGALI PARIT', 'D1', 'Menggali peparit untuk paip najis, purata 450mm dalam (dengan cangkul)', 'M', 'Diameter : 100mm', 10.40, 0, NULL),
('4D', 'MENGGALI PARIT', 'D1', 'Menggali peparit untuk paip najis, purata 450mm dalam (dengan cangkul)', 'M', 'Diameter : 150mm', 11.70, 0, NULL),
('4D', 'LURANG', 'D35', 'Lurang tidak melebihi 600mm dalam termasuk penggalian, membentuk 100mm asas konkrit (1:3:6-38mm), membuat rusuk (benching) dan saluran-saluran, membina 115mm dinding bata berlepa simen mortar (1:3), 100mm tebal penutup konkrit (1:2:4-20mm) diperkukuhkan dengan tetulang berkimpal, dinding bahagian dalam dialas dengan 12mm tebal lepa simen dan pasir (1:3) (Penutup lurang diukur berasingan)', 'NO', 'Ukuran dalam : 565mm x 450mm ', 139.60, 0, NULL),
('4D', 'LURANG', 'D35', 'Lurang tidak melebihi 600mm dalam termasuk penggalian, membentuk 100mm asas konkrit (1:3:6-38mm), membuat rusuk (benching) dan saluran-saluran, membina 115mm dinding bata berlepa simen mortar (1:3), 100mm tebal penutup konkrit (1:2:4-20mm) diperkukuhkan dengan tetulang berkimpal, dinding bahagian dalam dialas dengan 12mm tebal lepa simen dan pasir (1:3) (Penutup lurang diukur berasingan)', 'NO', 'Ukuran dalam : 675mm x 565mm ', 184.50, 0, NULL),
('4D', 'LURANG', 'D35', 'Lurang tidak melebihi 600mm dalam termasuk penggalian, membentuk 100mm asas konkrit (1:3:6-38mm), membuat rusuk (benching) dan saluran-saluran, membina 115mm dinding bata berlepa simen mortar (1:3), 100mm tebal penutup konkrit (1:2:4-20mm) diperkukuhkan dengan tetulang berkimpal, dinding bahagian dalam dialas dengan 12mm tebal lepa simen dan pasir (1:3) (Penutup lurang diukur berasingan)', 'NO', 'Ukuran dalam : 785mm x 565mm ', 225.60, 0, NULL),
('4D', 'LURANG', 'D35', 'Lurang tidak melebihi 600mm dalam termasuk penggalian, membentuk 100mm asas konkrit (1:3:6-38mm), membuat rusuk (benching) dan saluran-saluran, membina 115mm dinding bata berlepa simen mortar (1:3), 100mm tebal penutup konkrit (1:2:4-20mm) diperkukuhkan dengan tetulang berkimpal, dinding bahagian dalam dialas dengan 12mm tebal lepa simen dan pasir (1:3) (Penutup lurang diukur berasingan)', 'NO', 'Ukuran dalam : 900mm x 675mm ', 283.80, 0, NULL),
('4E', 'DINDING BATU', 'E1', 'Dinding batu disusun rambang dan tidak diikat (tidak menggunakan \'mortar\')', 'M3', 'B.Kapur', 361.80, 0, NULL),
('4E', 'DINDING BATU', 'E1', 'Dinding batu disusun rambang dan tidak diikat (tidak menggunakan \'mortar\')', 'M3', 'B.Pejal', 366.00, 0, NULL),
('4E', 'DINDING BATU', 'E2', 'Dinding batu disusun rambang dan diikat dengan simen mortar (1:3)', 'M3', 'B.Kapur', 410.00, 0, NULL),
('4E', 'DINDING BATU', 'E2', 'Dinding batu disusun rambang dan diikat dengan simen mortar (1:3)', 'M3', 'B.Pejal', 395.50, 0, NULL),
('4E', 'DINDING BATU', 'E3', 'Dinding batu bercorak ikatan rambang lapisan seragam dan diikat dengan simen mortar (1:3)', 'M3', 'B.Kapur', 414.70, 0, NULL),
('4E', 'DINDING BATU', 'E3', 'Dinding batu bercorak ikatan rambang lapisan seragam dan diikat dengan simen mortar (1:3)', 'M3', 'B.Pejal', 400.00, 0, NULL),
('4E', 'DINDING BATU', 'E4', 'LEBIHKAN harga dinding untuk dikemas sejati dan dikemas ikat pada sebelah muka', 'M2', 'B.Kapur', 45.40, 0, NULL),
('4E', 'DINDING BATU', 'E4', 'LEBIHKAN harga dinding untuk dikemas sejati dan dikemas ikat pada sebelah muka', 'M2', 'B.Pejal', 54.50, 0, NULL),
('4E', 'DINDING BATU', 'E5', 'Upah mencungkil sendi-sendi dinding yang lama dan dikemasikat semula dengan simen mortar (1:3)', 'M2', 'B.Kapur', 30.20, 0, NULL),
('4E', 'DINDING BATU', 'E5', 'Upah mencungkil sendi-sendi dinding yang lama dan dikemasikat semula dengan simen mortar (1:3)', 'M2', 'B.Pejal', 30.20, 0, NULL),
('4E', 'DINDING BATU', 'E6', 'Memecahkan dinding-dinding batu', 'M3', 'B.Kapur', 55.20, 0, NULL),
('4E', 'DINDING BATU', 'E6', 'Memecahkan dinding-dinding batu', 'M3', 'B.Pejal', 55.00, 0, NULL),
('4F', 'Wood', '4A', 'Wood2', 'm', 'Pokok Kelapa', 30.00, 0, '2024-01-17 08:50:34'),
('4F', 'KEPINGAN-KEPINGAN ALUMINIUM', 'F24', 'Kepingan aluminium berombak untuk bumbung atau dinding (diukur mengikut luas yang ditutup sahaja)\r\n', 'M2', '0.30mm', 48.90, 0, NULL),
('4F', 'KEPINGAN-KEPINGAN ALUMINIUM', 'F24', 'Kepingan aluminium berombak untuk bumbung atau dinding (diukur mengikut luas yang ditutup sahaja)\r\n', 'M2', '0.40mm', 51.20, 0, NULL),
('4F', 'KEPINGAN-KEPINGAN ALUMINIUM', 'F24', 'Kepingan aluminium berombak untuk bumbung atau dinding (diukur mengikut luas yang ditutup sahaja)\r\n', 'M2', '0.50mm', 60.70, 0, NULL),
('4F', 'PENEBAT ALUMINIUM', 'F42', 'Memasang satu lapisan penebat aluminium foil dua muka di atas kasau', 'M2', '-', 8.80, 0, NULL),
('4F', 'KEPINGAN SIMEN \'NON- ASBESTOS\' BEROMBAK', 'F9', 'Penutup-penutup bumbung (diukur mengikut luas yang ditutup sahaja)', 'M2', '\"Six\"', 27.80, 0, NULL),
('4F', 'KEPINGAN SIMEN \'NON- ASBESTOS\' BEROMBAK', 'F9', 'Penutup-penutup bumbung (diukur mengikut luas yang ditutup sahaja)', 'M2', 'Berwarna Kelabu', 29.00, 0, NULL),
('4F', 'KEPINGAN SIMEN \'NON- ASBESTOS\' BEROMBAK', 'F9', 'Penutup-penutup bumbung (diukur mengikut luas yang ditutup sahaja)', 'M2', 'Berwarna Merah, Biru, Hijau', 29.20, 0, NULL),
('4F', 'KEPINGAN SIMEN \'NON- ASBESTOS\' BEROMBAK', 'F9', 'Penutup-penutup bumbung (diukur mengikut luas yang ditutup sahaja)', 'M2', 'Piawai', 26.10, 0, NULL),
('4G', 'TUPANG DAN JERMANG', 'G1', 'Tupang dan jermang (sebarang jenis kayu) termasuk mengenakan, mendirikan, merentang dan memecat bol-bol, paku siung-siung, pancang-pancang, paku-paku baji yang mana perlu dan digunakan untuk jangka waktu tiga bulan', 'M3', '-', 999.99, 0, NULL),
('4G', 'PINTU RINTANGAN API', 'G168', 'Membekal dan memasang pintu rintangan api 1 jam satu daun yang diluluskan berukuran 900 x 2100 x 44 mm dan dipasang mengikut spesifikasi pembekal termasuk perlengkapan besi dan sisi jenang berterusan yang bertingkat.', 'NO', '-', 999.99, 0, NULL),
('4G', 'KAYU S.G. 5 & S.G. 6', 'G43', 'Papan tanggam temu yang telah diketam kedua-dua belah muka dan pinggir dalam lingkungan 100mm hingga 200mm lebar', 'M2', '12mm', 65.40, 0, NULL),
('4G', 'KAYU S.G. 5 & S.G. 7', 'G44', 'Papan tanggam temu yang telah diketam kedua-dua belah muka dan pinggir dalam lingkungan 100mm hingga 200mm lebar', 'M2', '20mm', 82.10, 0, NULL),
('4G', 'KAYU S.G. 5 & S.G. 8', 'G45', 'Papan tanggam temu yang telah diketam kedua-dua belah muka dan pinggir dalam lingkungan 100mm hingga 200mm lebar', 'M2', '25mm', 100.20, 0, NULL),
('4G', 'KAYU S.G. 5 & S.G. 9', 'G46', 'Papan tanggam temu yang telah diketam kedua-dua belah muka dan pinggir dalam lingkungan 100mm hingga 200mm lebar', 'M2', '32mm', 121.80, 0, NULL),
('4G', 'MEMBAIKI PAPAN DINDING', 'G57', 'Papan tanggam temu yang tidak diketam', 'M', 'SG 1 & 2', 3.70, 0, NULL),
('4G', 'MEMBAIKI PAPAN DINDING', 'G57', 'Papan tanggam temu yang tidak diketam', 'M', 'SG 3 & 4', 2.60, 0, NULL),
('4G', 'MEMBAIKI PAPAN DINDING', 'G57', 'Papan tanggam temu yang tidak diketam', 'M', 'SG 5 & 6', 2.70, 0, NULL),
('4H', 'ENGSEL', 'H3', '75mm Engsel tumpu keluli tahan karat', 'PASAN', 'Bekal dan pasang', 16.10, 0, NULL),
('4H', 'ENGSEL', 'H3', '75mm Engsel tumpu keluli tahan karat', 'PASAN', 'Tanggal & pasang semula', 7.00, 0, NULL),
('4H', 'ENGSEL', 'H3', '75mm Engsel tumpu keluli tahan karat', 'PASAN', 'Tanggal, bekal dan pasang', 17.50, 0, NULL),
('4H', 'MEMBAIKI IBU KUNCI', 'H59', 'Memasang anak kunci besi yang baru pada alat kunci termasuk membuka dan memasang semula jika perlu', 'NO', 'Cylinder', 0.00, 0, NULL),
('4H', 'MEMBAIKI IBU KUNCI', 'H59', 'Memasang anak kunci besi yang baru pada alat kunci termasuk membuka dan memasang semula jika perlu', 'NO', 'Ibu Kunci Mortice atau Rim', 19.30, 0, NULL),
('4H', 'MEMBAIKI IBU KUNCI', 'H59', 'Memasang anak kunci besi yang baru pada alat kunci termasuk membuka dan memasang semula jika perlu', 'NO', 'Pad', 12.90, 0, NULL),
('4I', 'BOLT KELULI LEMBUT', 'I22', 'Bolt skru berkepala tidak melebihi 12mm diameter dan\r\ntidak melebihi 225mm panjang serta nat dan dua pelapik\r\ntermasuk memasangnya\r', 'KG', '-', 14.20, 0, NULL),
('4I', 'KERJA-KERJA MEMAGAR', 'I36', 'Jejaring keselamatan jenis \" Bulldog rekabentuk A\" atau lain- lain yang setara dan diluluskan termasuk rangka keluli lembut serta memasangnya', 'M2', '-', 144.50, 0, NULL),
('4J', 'TURAPAN', 'J1', 'Turapan simen dan pasir (1:3) atau skrid dilepa licin untuk menerima\r\njubin lantai\r', 'M2', '12mm', 15.70, 0, NULL),
('4J', 'TURAPAN', 'J1', 'Turapan simen dan pasir (1:3) atau skrid dilepa licin untuk menerima\r\njubin lantai\r', 'M2', '20mm', 20.60, 0, NULL),
('4J', 'TURAPAN', 'J1', 'Turapan simen dan pasir (1:3) atau skrid dilepa licin untuk menerima\r\njubin lantai\r', 'M2', '25mm', 24.70, 0, NULL),
('4J', 'MENJUBIN LANTAI', 'J15', '200mm x 200mm x 16mm jubin terazzo berwarna putih tidak\ntermasuk skrid\n', 'M2', '-', 89.40, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 12mm', 13.40, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN        \n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 20mm', 19.00, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 25mm', 23.90, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 32mm', 28.60, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 38mm', 34.40, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 50mm', 48.30, 0, NULL),
('4K', 'PAIP BEKALAN AIR JENIS KELULI SEDERHANA TERGALVANI DAN PASANGAN	\r\n', 'K38', 'Paip kelas \"C\" pada BS 1387 dalam peparit termasuk kupling lurus (straight coupling)                                                                \n', 'M', 'Diameter dalam : 57mm', 70.60, 0, NULL),
('4K', 'SALIRAN AIR HUJAN', 'K5', '0.90mm tebal besi bersadur zing dan semua kerja pada kalis tiris (flashing), lurah-lurah dan lain-lain                                ', 'M2', 'Bekal & pasang', 220.70, 0, NULL),
('4K', 'SALIRAN AIR HUJAN', 'K5', '0.90mm tebal besi bersadur zing dan semua kerja pada kalis tiris (flashing), lurah-lurah dan lain-lain                                ', 'M2', 'Pasang sahaja', 39.80, 0, NULL),
('4L', '-', 'L1', 'Kaca jernih dan kerja memasang kaca dengan kumai atau dempul seperti diarahkan termasuk membekal dan memasang kumai baru atau membersihkan dan memasang kembali kumai yang sedia ada seperti dikehendaki. (kumai baru diukur berasingan)\n', 'M2', '3mm', 93.10, 0, NULL),
('4L', '-', 'L1', 'Kaca jernih dan kerja memasang kaca dengan kumai atau dempul seperti diarahkan termasuk membekal dan memasang kumai baru atau membersihkan dan memasang kembali kumai yang sedia ada seperti dikehendaki. (kumai baru diukur berasingan)\n', 'M2', '4mm', 104.00, 0, NULL),
('4L', '-', 'L1', 'Kaca jernih dan kerja memasang kaca dengan kumai atau dempul seperti diarahkan termasuk membekal dan memasang kumai baru atau membersihkan dan memasang kembali kumai yang sedia ada seperti dikehendaki. (kumai baru diukur berasingan)\n', 'M2', '5mm', 129.50, 0, NULL),
('4L', '-', 'L1', 'Kaca jernih dan kerja memasang kaca dengan kumai atau dempul seperti diarahkan termasuk membekal dan memasang kumai baru atau membersihkan dan memasang kembali kumai yang sedia ada seperti dikehendaki. (kumai baru diukur berasingan)\n', 'M2', '6mm', 145.50, 0, NULL),
('4M', 'PENGAWET KAYU (WOOD PRESERVATIVE)', 'M10', 'Sediakan permukaan dan sapu satu lapis \"Minyak Kayu\" (Creosote)', 'M2', 'Kerja Membaiki Baru', 6.80, 0, NULL),
('4M', 'PENGAWET KAYU (WOOD PRESERVATIVE)', 'M10', 'Sediakan permukaan dan sapu satu lapis \"Minyak Kayu\" (Creosote)', 'M2', 'Kerja Membaiki Lama', 6.20, 0, NULL),
('4M', 'PENGAWET KAYU (WOOD PRESERVATIVE)', 'M10', 'Sediakan permukaan dan sapu satu lapis \"Minyak Kayu\" (Creosote)', 'M2', 'Kerja Mengecat Baru', 6.20, 0, NULL),
('4M', 'PENGAWET KAYU (WOOD PRESERVATIVE)', 'M10', 'Sediakan permukaan dan sapu satu lapis \"Minyak Kayu\" (Creosote)', 'M2', 'Kerja Mengecat Lama', 5.70, 0, NULL),
('4N', 'PENANAMAN DAN PEMOTONGAN RUMPUT DI BAHU JALAN', 'N1', 'Memotong rumput di bahu jalan serta membersihkan rezeb jalan dan\nmenggali parit salur air serta membersihkan segala-galanya. (Ukuran\ndiambil mengikut alur dan lebar kedua-dua belah jalan)\n', 'M', '12 meter rezeb jalan', 0.70, 0, NULL),
('4N', 'PENANAMAN DAN PEMOTONGAN RUMPUT DI BAHU JALAN', 'N1', 'Memotong rumput di bahu jalan serta membersihkan rezeb jalan dan\nmenggali parit salur air serta membersihkan segala-galanya. (Ukuran\ndiambil mengikut alur dan lebar kedua-dua belah jalan)\n', 'M', '20 meter rezeb jalan', 0.80, 0, NULL),
('4N', 'PENANAMAN DAN PEMOTONGAN RUMPUT DI BAHU JALAN', 'N1', 'Memotong rumput di bahu jalan serta membersihkan rezeb jalan dan\nmenggali parit salur air serta membersihkan segala-galanya. (Ukuran\ndiambil mengikut alur dan lebar kedua-dua belah jalan)\n', 'M', '30 meter rezeb jalan', 0.80, 0, NULL),
('4O', 'MEMASANG DAN MENYAMBUNG PAIP AIR UTAMA\r\n(PAIP SIMEN ASBESTOS, PAIP BESI DAN PAIP HDPE)\r', 'O2', 'Menggali peparit untuk 75mm atau 100mm diameter paip air utama,\r\ntidak melebihi 1500mm dalam dan 1050mm dalam hitung panjang,\r\ntermasuk semua kayu penyokong jika perlu, dan mengambus semula\r\ndan dipadatkan seperti yang ditentukan dan baki tanah diangkut\r\nke tempat yang diarahkan termasuk mengawasi peparit supaya\r\nbebas daripada air dan lumpur\r', 'M', '-', 17.30, 0, NULL),
('4O', '\r\nPAIP BEKALAN AIR JENIS\r\nPOLIETILENA KETUMPATAN TINGGI\r\n(HDPE)\r', 'O29', '\nPaip kelas PN10 termasuk kupling lurus\n', 'M', '110mm (diameter)', 36.20, 0, NULL),
('4O', '\r\nPAIP BEKALAN AIR JENIS\r\nPOLIETILENA KETUMPATAN TINGGI\r\n(HDPE)\r', 'O30', '\nPaip kelas PN10 termasuk kupling lurus\n', 'M', '125mm (diameter)', 47.60, 0, NULL),
('4O', '\r\nPAIP BEKALAN AIR JENIS\r\nPOLIETILENA KETUMPATAN TINGGI\r\n(HDPE)\r', 'O31', '\nPaip kelas PN10 termasuk kupling lurus\n', 'M', '160mm (diameter)', 63.50, 0, NULL),
('I', '23', '4A', '23', '23', '23', 23.00, 0, '2024-01-10 09:45:52'),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A1', 'Mata lampu (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 91.10, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A16.1', 'Mata soket alur keluar kuasa l/d suis soket alur keluar 13A bertebat penuh menggunakan kabel PVK:-', 'satu', '2 x 2.5 mm persegi l/d kabel perlindungan.', 143.20, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A16.2', 'Mata soket alur keluar kuasa l/d suis soket alur keluar 13A bertebat penuh menggunakan kabel PVK:-', 'satu', '2 x 4 mm persegi l/d kabel perlindungan.', 206.20, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A2', 'Mata lampu bagi pendawaian dua hala (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 147.30, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A3', 'Mata lampu bagi pendawaian dua hala dan perantaraan (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 159.30, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A4', 'Mata lampu (tanpa suis) l/d pemegang mentol jenis beroti atau beroti sudut bakelit menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 94.80, 0, NULL),
('I', 'A     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian konduit permukaan atau terbenam dengan menggunakan kabel PVK', 'A5', 'Mata lampu (tanpa suis) l/d ros siling dan kabel bulat PVK lentur 3 teras 23/0.16 mm sepanjang 1/2 meter menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 106.70, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B1', 'Mata lampu (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 133.00, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B16.1', 'Mata soket alur keluar kuasa l/d suis soket alur keluar 13A bertebat penuh menggunakan kabel PVK:-', 'satu', '2 x 2.5 mm persegi l/d kabel perlindungan.', 228.80, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B16.2', 'Mata soket alur keluar kuasa l/d suis soket alur keluar 13A bertebat penuh menggunakan kabel PVK:-', 'satu', '2 x 4 mm persegi l/d kabel perlindungan.', 364.60, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B2', 'Mata lampu bagi pendawaian dua hala (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 189.20, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B3', 'Mata lampu bagi pendawaian dua hala dan perantaraan (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 201.20, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B4', 'Mata lampu (tanpa suis) l/d pemegang mentol jenis beroti atau beroti sudut bakelit menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 136.70, 0, NULL),
('I', 'B     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'B5', 'Mata lampu (tanpa suis) l/d ros siling dan kabel bulat PVK lentur 3 teras 23/0.16 mm sepanjang 1/2 meter menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 143.30, 0, NULL),
('I', 'C     Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR secara pendawaian permukaan atau terbenam dengan menggunakan kabel PVK di dala', 'C1', 'Mata lampu (tanpa suis) menggunakan kabel 2 x 1.5 mm persegi l/d kabel perlindungan.', 'satu', '-', 116.20, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D1', 'Biasa Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'meter', '1 x 6 mm persegi.', 14.50, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D14', 'Biasa Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'meter', '2 x 1.5 mm persegi l/d pengalir perlindungan.', 20.10, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D2', 'Biasa Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'meter', '1 x 10mm persegi.', 18.20, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D39', 'Kabel bulat lentur bertebat polivinil klorida', 'meter', '2 teras, 23/0.16 mm persegi', 8.00, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D40', 'Kabel bulat lentur bertebat polivinil klorida', 'meter', '3 teras, 23/0.16 mm persegi', 9.80, 0, NULL),
('I', 'D     Kabel Polivinil Klorida/Polivinil Klorida (PVK/PVK)', 'D43', 'Kabel kembar datar 2 teras, bertebat dan bersalut polivinil klorida (PVK) :-', 'meter', '2.5 mm persegi', 7.00, 0, NULL),
('I', 'E     Kabel Polivinil Klorida (PVK)', 'E1', 'Biasa Kabel Polivinil Klorida (PVK)', 'meter', '1 x 6 mm persegi', 13.50, 0, NULL),
('I', 'F     Kabel XLPE/PVK', 'F1', 'Biasa Kabel XLPE/PVK', 'meter', '1 x 35mm persegi', 30.30, 0, NULL),
('I', 'G     Kabel Fire Resistance (FR)', 'G1', 'Biasa Kabel Fire Resistance (FR)', 'meter', '1 x 1.5 mm persegi.', 16.30, 0, NULL),
('I', 'H     Sistem Perlindungan Kilat dan Sistem Pembumian', 'H1', 'Pita kuprum [25 mm x 3mm]', 'meter', '-', 66.20, 0, NULL),
('I', 'H     Sistem Perlindungan Kilat dan Sistem Pembumian', 'H2', 'Pelana pita kuprum [25 mm x 3mm]', 'satu', '-', 16.50, 0, NULL),
('I', 'H     Sistem Perlindungan Kilat dan Sistem Pembumian', 'H3', 'Elektrod bumi kuprum 2 x [16 mm garis pusat x 1500mm] termasuk penyambungan \'exothermic welding\' dan ruang pemeriksaan konkrit dengan penutup boleh tanggal pasang jenis tahan lasak (heavy duty) termasuk pengujian', 'satu ', '-', 760.90, 0, NULL),
('I', 'I    Mata Rangkaian', 'I1', 'SKOP ICT Mata rangkaian data (ICT) dari patch panel ke faceplate (pengguna) menggunakan kabel UTP CAT 6 23AWG (EIA/TIA) Low Smoke Zero Halogen (LSZH) l/d faceplate bersudut dan CAT 6 RJ45 modular jack di dalam konduit Heavy Duty uPVC termasuk kerja-kerja tamatan & pengujian', 'satu', '-', 296.70, 0, NULL),
('I', 'I    Mata Rangkaian', 'I2', 'SKOP ICT Mata rangkaian data (ICT) dari patch panel ke faceplate (pengguna) menggunakan kabel UTP CAT 6 23AWG (EIA/TIA) Low Smoke Zero Halogen (LSZH) l/d faceplate bersudut dan CAT 6 RJ45 modular jack di dalam konduit Heavy Duty uPVC termasuk kerja-kerja tamatan & pengujian (pengguna) menggunakan kabel UTP CAT 6 l/d faceplate bersudut dan CAT 6 RJ45 modular jack termasuk kerja- kerja tamatan & pengujian', 'satu', '-', 177.80, 0, NULL),
('I', 'I    Mata Rangkaian', 'I5.1', 'Kabel UTP CAT 6 Factory terminated patch cord untuk:', 'satu', 'Jarak 2m', 36.80, 0, NULL),
('I', 'I    Mata Rangkaian', 'I5.2', 'Kabel UTP CAT 6 Factory terminated patch cord untuk:', 'satu', 'Jarak 3m', 41.60, 0, NULL),
('I', 'I    Mata Rangkaian', 'I5.3', 'Kabel UTP CAT 6 Factory terminated patch cord untuk:', 'satu', 'Jarak 5m', 51.20, 0, NULL),
('II', 'A    Pengasing', 'A1', 'Pengasing, dwi kutub jenis satu fasa, bertebat penuh:', 'satu', '20 A', 73.40, 1, NULL),
('II', 'A    Pengasing', 'A2', 'Pengasing, dwi kutub jenis satu fasa, bertebat penuh:', 'satu', '32 A', 77.00, 0, NULL),
('II', 'B    Papan Agihan', 'B1', 'Papan agihan terlitup logam jenis electrogalvanized steel sheet. Papan agihan terlitup logam jenis electrogalvanized steel sheet , kutub tunggal & neutral I/d pemutus litar kecil (MCB) berkadaran hingga 32 A dengan beban memutus 6 kA:', 'satu', '4 hala', 825.60, 0, NULL),
('II', 'B    Papan Agihan', 'B2', 'Papan agihan terlitup logam jenis electrogalvanized steel sheet , kutub tunggal & neutral I/d pemutus litar kecil (MCB) berkadaran hingga 32 A dengan beban memutus 6 kA:', 'satu', '6 hala', 891.70, 0, NULL),
('II', 'C    Peralatan Pemutus Litar', 'C1', 'Pemutus litar kecil (MCB)', 'satu', 'Pemutus litar kecil kutub tunggal berkadaran sehingga 32 A, dengan beban memutus 6 kA.', 32.10, 0, NULL),
('II', 'C    Peralatan Pemutus Litar', 'C10', 'Pemutus litar arus baki, empat kutub jenis tiga fasa:', 'satu', 'Kadaran arus 40 A dengan kepekaan arus 30 mA', 140.80, 0, NULL),
('II', 'C    Peralatan Pemutus Litar', 'C14', 'RCCB Auto Recloser Membekal dan memasang RCCB Auto Recloser yang serasi dengan jenama dan model RCCB yang digunakan', 'satu', 'Dwi kutub', 577.90, 0, NULL),
('II', 'C    Peralatan Pemutus Litar', 'C16', 'Pemutus litar arus baki dengan perlindungan arus lebih (RCBO)', 'satu', 'Pemutus litar arus baki dengan perlindungan arus lebih, 6 kA dwi-kutub jenis satu fasa, kadaran arus 10 A hingga 40 A dengan kepekaan arus 30 mA.', 124.00, 0, NULL),
('II', 'C    Peralatan Pemutus Litar', 'C5', 'Pemutus litar arus baki, dwi kutub jenis satu fasa:', 'satu', 'Kadaran arus 25 A dengan kepekaan arus 10 mA', 100.50, 0, NULL),
('II', 'D    Peralatan Kawalan', 'D1', 'Pemula motor', 'satu', 'Pemula motor, talian terus (DOL) fasa tunggal, sehingga 3 k.k. dengan pelantik beban lebih haba (TOR) dan lampu penunjuk.', 541.60, 0, NULL),
('II', 'D    Peralatan Kawalan', 'D10', 'Sesentuh (AC-1 , AC-3 & AC-5) : Sesentuh tiga kutub:', 'satu', '18 A', 150.00, 0, NULL),
('II', 'D    Peralatan Kawalan', 'D2', 'Pemula motor', 'satu', 'Pemula motor, talian terus (DOL) tiga fasa, sehingga 3 k.k. dengan pelantik beban lebih haba (TOR) dan lampu penunjuk.', 625.60, 0, NULL),
('II', 'D    Peralatan Kawalan', 'D6', 'Sesentuh (AC-1 , AC-3 & AC-5) : Sesentuh dwi kutub:', 'satu', '10 A', 187.60, 0, NULL),
('II', 'D    Peralatan Kawalan', 'D7', 'Sesentuh (AC-1 , AC-3 & AC-5) : Sesentuh dwi kutub:', 'satu', '20 A', 202.00, 0, NULL),
('II', 'E    Surge Protective Device (SPD) :', 'E1', 'Papan Suis Utama (PSU)', 'satu', 'Isc > 10kA, Imax >65kA, Up < 1800V, Mode Of Protection (L-N, L-E & N-E)', 999.99, 0, NULL),
('II', 'E    Surge Protective Device (SPD) :', 'E2', 'Papan Suis Kecil (PSK)', 'satu', 'Isc > 10kA, Imax > 65kA ,Up < 1800V, Mode Of Protection (L-N, L-E & N-E) - (Other location from MSB)', 999.99, 0, NULL),
('II', 'E    Surge Protective Device (SPD) :', 'E3', 'Papan Suis Kecil (PSK)', 'satu', 'Isc > 5kA, Imax > 40kA ,Up < 1500V, Mode Of Protection (L-N, L-E & N-E) - (Same location with MSB)', 999.99, 0, NULL),
('II', 'F    Peralatan Geganti Perlindungan :', 'F1', 'Geganti arus lebih (OCR) jenis mikroprosessor l/d paparan 7-segment atau lampu penunjuk, IDMT, 240V, 50Hz', 'satu', '-', 736.80, 0, NULL),
('II', 'F    Peralatan Geganti Perlindungan :', 'F8', 'Alat ubah arus fasa sifar (ZCT)', 'satu', '25 mm Dia.', 106.70, 0, NULL),
('II', 'F    Peralatan Geganti Perlindungan :', 'F9', 'Alat ubah arus fasa sifar (ZCT)', 'satu', '45 mm Dia.', 111.70, 0, NULL),
('II', 'G     Peralatan Pengukuran Dan Aksesori Papan Suis :', 'G1', 'Ammeter l/d Beban Maksima 60 A sehingga 400 A jenis analog', 'satu', '-', 132.30, 0, NULL),
('II', 'G     Peralatan Pengukuran Dan Aksesori Papan Suis :', 'G10', 'Kipas Pelawas', 'satu', '6\'\'', 125.60, 0, NULL),
('II', 'G     Peralatan Pengukuran Dan Aksesori Papan Suis :', 'G11', 'Kipas Pelawas', 'satu', '8', 177.60, 0, NULL),
('II', 'G     Peralatan Pengukuran Dan Aksesori Papan Suis :', 'G2', 'Voltmeter (0-500V) jenis analog', 'satu', '-', 103.20, 0, NULL),
('II', 'G     Peralatan Pengukuran Dan Aksesori Papan Suis :', 'G9', '12 core 1.5mm kabel PVK/PVK dari CT MSB ke CT meter TNB', 'meter', '-', 36.60, 0, NULL),
('II', 'H     Peralatan Fius, Fius-Suis dan Suis Fius :', 'H1', 'Unit Pemutus l/d penghubung fius:', 'satu', '30 A / 32 A', 56.00, 0, NULL),
('II', 'H     Peralatan Fius, Fius-Suis dan Suis Fius :', 'H2', 'Unit Pemutus l/d penghubung fius:', 'satu', '60 A / 63 A', 56.00, 0, NULL),
('II', 'I    Power Factor Correction Board :', 'I1', 'Kapasitor 525V', 'satu', '5kVAR 525V', 392.10, 0, NULL),
('II', 'I    Power Factor Correction Board :', 'I2', 'Kapasitor 525V', 'satu', '10kVAR 525V', 440.10, 0, NULL),
('III', 'A     Suis bertebat penuh', 'A1', 'Suis pelit leper kutub tunggal.', 'satu', '10A, 1 gang 1 hala.', 18.50, 0, NULL),
('III', 'A     Suis bertebat penuh', 'A2', 'Suis pelit leper kutub tunggal.', 'satu', '10A, 2 gang 1 hala.', 21.50, 0, NULL),
('III', 'B     Suis terlitup logam (metaclad ).', 'B1', 'Suis kutub tunggal.', 'satu', '10A, 1 gang 1 hala.', 32.20, 0, NULL),
('III', 'B     Suis terlitup logam (metaclad ).', 'B2', 'Suis kutub tunggal.', 'satu', '10A, 2 gang 1 hala.', 36.70, 0, NULL),
('III', 'C     Punca Alir Keluar (PAK) , bertebat penuh', 'C1', 'PAK bersuis /tanpa suis jenis leper', 'satu', '13A, 1 gang.', 20.10, 0, NULL),
('III', 'C     Punca Alir Keluar (PAK) , bertebat penuh', 'C2', 'PAK bersuis /tanpa suis jenis leper', 'satu', '13A, 2 gang.', 38.50, 0, NULL),
('III', 'D     Punca Alir Keluar (PAK) , terlitup logam (metalclad)', 'D1', 'PAK bersuis/tanpa suis jenis leper', 'satu', '13A, 1 gang.', 34.00, 0, NULL),
('III', 'D     Punca Alir Keluar (PAK) , terlitup logam (metalclad)', 'D19a', 'Kotak pelekap jenis logam untuk suis/PAK terlitup logam lekapan permukaan', 'satu', '75mm x 75mm', 10.00, 0, NULL),
('III', 'D     Punca Alir Keluar (PAK) , terlitup logam (metalclad)', 'D19b', 'Kotak pelekap jenis logam untuk suis/PAK terlitup logam lekapan permukaan', 'satu', '75mm x 150mm', 11.20, 0, NULL),
('III', 'D     Punca Alir Keluar (PAK) , terlitup logam (metalclad)', 'D2', 'PAK bersuis/tanpa suis jenis leper', 'satu', '13A, 2 gang.', 50.20, 0, NULL),
('III', 'E     Komponen-komponen pendawaian', 'E1', 'Pemegang mentol pangkal kilas E27,tembikar.', 'satu', '-', 8.80, 0, NULL),
('III', 'F     Alat-alat lengkap konduit dan trunking', 'F1', 'Konduit, galvani', 'meter', '20mm', 10.00, 0, NULL),
('III', 'F     Alat-alat lengkap konduit dan trunking', 'F2', 'Konduit, galvani', 'meter', '25mm', 12.20, 0, NULL),
('III', 'F     Alat-alat lengkap konduit dan trunking', 'F66', 'Keluli Galvani Rendam Panas ( Hot Dip Galvanised) Trunking 1.2mm l/d penutup, penyambung kuprum (H x W)', 'meter', '50mm x 50mm', 31.60, 0, NULL),
('III', 'F     Alat-alat lengkap konduit dan trunking', 'F67', 'Keluli Galvani Rendam Panas ( Hot Dip Galvanised) Trunking 1.2mm l/d penutup, penyambung kuprum (H x W)', 'meter', '50mm x 75mm', 43.90, 0, NULL),
('III', 'F     Alat-alat lengkap konduit dan trunking', 'F72', 'Keluli Galvani Rendam Panas ( Hot Dip Galvanised) Trunking 1.6mm l/d penutup, penyambung kuprum (H x W)', 'meter', '50mm x 150mm', 89.30, 0, NULL),
('III', 'G     Lain - lain', 'G1', '3mm X 25mm Penyambung Kuprum (untuk pepasangan sedia ada)', 'satu', '-', 4.00, 0, NULL),
('III', 'G     Lain - lain', 'G2', 'Pendakap keluli galvani bersudut (angle iron ) berbentuk L, U atau C l/d bolt & nat untuk trunking dan talam penatang kabel.', 'satu', '-', 14.80, 0, NULL),
('IV', 'A.    Mentol:', 'A1', 'Mentol, cahaya tumpu atau cahaya limpah PAR 38 240V, E27, 100W/150W.', 'satu', '-', 52.60, 0, NULL),
('IV', 'B     Lengkapan Pendarfluor Jenis T8: Lengkapan Pendarfluor dengan balast elektromagnetik jenis kehilangan rendah 6W atau kurang l/d tiub, pemula dan ', 'B1', 'Lengkapan jenis salur:', 'satu', '1 x 18W', 71.30, 0, NULL),
('IV', 'C     Lengkapan Pendarfluor Jenis T5 Lengkapan Pendarfluor dengan balast elektronik jenis kehilangan rendah 3W atau kurang l/d tiub, :', 'C1', 'Lengkapan jenis salur:', 'satu', '1 x 14W', 100.70, 0, NULL),
('IV', 'D     Lengkapan LED: Lengkapan LED lengkap dengan tiub LED 2 pin jenis G13, pemacu LED (LED driver ) , faktor kuasa > 0.9 dan kecekapan > 90 lm/W :-', 'D1', 'Lengkapan jenis salur:', 'satu', '1 Tiub Led (600mm)', 76.30, 0, NULL),
('IV', 'D     Lengkapan LED: Lengkapan LED lengkap dengan tiub LED 2 pin jenis G13, pemacu LED (LED driver ) , faktor kuasa > 0.9 dan kecekapan > 91 lm/W :-', 'D38', 'Membekal dan memasang semua bahan mengikut spesifikasi standard JKR bagi lampu jenis LED jenis tinggi (highbay) l/d peralatan kawalan dan pemacu LED (LED driver ) , faktor kuasa > 0.9, kecekapan > 90 lm/W, 240V termasuk harga tenaga kerja dan bahan (tanpa sewaan jentera atau perancah): -', 'satu', '100 W', 841.80, 0, NULL),
('IV', 'E     Lengkapan Anti Corrosive Lengkapan LED lengkap dengan tiub LED 2 pin jenis G13, pemacu LED (LED driver ), faktor kuasa > 0.9 dan kecekapan > 90 ', 'E1', 'Lengkapan jenis salur:', 'satu', '1 Tiub Led (600mm)', 91.70, 0, NULL),
('IV', 'E     Lengkapan Anti Corrosive Lengkapan LED lengkap dengan tiub LED 2 pin jenis G13, pemacu LED (LED driver ), faktor kuasa > 0.9 dan kecekapan > 91 ', 'E2', 'Lengkapan jenis salur:', 'satu', '2 Tiub Led (600mm)', 139.10, 0, NULL),
('IV', 'F     Lengkapan Am', 'F1', 'Lengkapan lampu sekatahan l/d mentol 60W.', 'satu', '-', 65.80, 0, NULL),
('IV', 'G     Komponen dan alat ganti lengkapan:', 'G1', 'Rod gantung 51cm. (20) panjang untuk lengkapan', 'satu', '-', 34.00, 0, NULL),
('IV', 'G     Komponen dan alat ganti lengkapan:', 'G26', 'Balast elektronik untuk lengkapan lampu jenis T5:', 'satu', '1 X 14W - 35W', 85.20, 0, NULL),
('IV', 'G     Komponen dan alat ganti lengkapan:', 'G27', 'Balast elektronik untuk lengkapan lampu jenis T5:', 'satu', '2 X 14W - 35W', 105.60, 0, NULL),
('IV', 'H     Kipas dan alat ganti kipas:', 'H1', 'Kipas siling saiz 1524mm jenis preasseamble ( 60\" ) g.p. I/d pengatur, rod gantung, ciri-ciri pemutus penyambung bekalan dan alat-alat lengkap yang diperlukan.', 'satu', '-', 256.90, 0, NULL),
('IV', 'H     Kipas dan alat ganti kipas:', 'H14', 'Kipas Lekapan dinding', 'satu', 'Kipas lekapan dinding 300mm. (12) g.p.', 246.60, 0, NULL),
('IV', 'H     Kipas dan alat ganti kipas:', 'H2', 'Aksesori tambahan dan alat ganti kipas siling', 'satu', 'Rod Gantung bersaiz 16/40cm panjang (Factory Made) l/d kabel keselamatan bagi kipas siling jenis preassemble', 71.20, 0, NULL),
('V', 'A     Tiang lampu dan aksesori lampu', 'A1', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR bagi Tiang keluli bergalvani rendam panas (hot dipped galvanised ) untuk ketinggian :- [ Tiang jenis tanam (Planted type ) ]', 'satu', '6.5m l/d lelengan sehingga 5.5m (Overhead lampu isyarat)', 4.00, 0, NULL),
('V', 'A     Tiang lampu dan aksesori lampu', 'A17', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR bagi Tiang konkrit span bertetulang untuk ketinggian:-', 'satu', 'Sehingga 6 Meter', 708.80, 0, NULL),
('V', 'A     Tiang lampu dan aksesori lampu', 'A9', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR bagi Tiang keluli bergalvani rendam panas (hot dipped galvanised ) untuk ketinggian:- [ Tiang jenis bebibir (Flanged type ) ]', 'satu', '6.5m l/d lelengan sehingga 5.5m (Overhead lampu isyarat)', 4.00, 0, NULL),
('V', 'B     Lantera Lampu Jalan Dan Lampu Limpah', 'B1', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR bagi Lantera lampu jalan lengkap dengan peralatan kawalan dan mentol wap natrium tekanan tinggi (HPSV ), 230V : -', 'satu', '70W', 612.10, 0, NULL),
('V', 'C     Lampu isyarat dan aksesori', 'C1', 'Aspek lampu isyarat berukuran 300 mm garis pusat, jenis LED: -', 'satu', 'Warna merah', 525.60, 0, NULL),
('V', 'C     Lampu isyarat dan aksesori', 'C19', 'Aspek lampu isyarat berukuran (3 X 300 mm) garis pusat, jenis LED', 'satu', '-', 1.00, 0, NULL),
('V', 'C     Lampu isyarat dan aksesori', 'C23', 'Aspek lampu isyarat digital countdown berukuran dua 300mm berfungsi secara Vehicle Actuated (VA) untuk warna (Merah dan Hijau) termasuk ujian dan pengesahan Lengkap Dengan driver', 'satu', '-', 2.00, 0, NULL),
('V', 'C     Lampu isyarat dan aksesori', 'C27', 'Gegelung Pengesan (Loop detector ): -', 'per l', 'Untuk pemasangan setiap satu lorong (Single Lane )', 1.00, 0, NULL),
('V', 'C     Lampu isyarat dan aksesori', 'C30', 'Aksesori Panel Kawalan Lampu Isyarat :-', 'satu', 'CPU Card', 6.00, 0, NULL),
('V', 'D     Kerja-kerja membekal dan memasang semua bahan mengikut spesifikasi piawai JKR menggunakan kabel di dalam paip (Road Crossing ) termasuk kerja-ke', 'D1', 'Kabel bawah tanah PVC/SWA/PVC 1.5 mm? / 2 teras', 'meter', '-', 13.10, 0, NULL),
('V', 'E     Lain-lain', 'E1', 'Kabel aluminium jenis ABC: Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR', 'meter', '1 x 16mm? dan 1 x 25mm?', 41.70, 0, NULL),
('V', 'E     Lain-lain', 'E11', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR bagi Black Box Fuse / Pole Mounted LV Fuse Switch Disconnector', 'satu', '63A Hingga 160A - 1 Pole', 220.20, 0, NULL),
('V', 'E     Lain-lain', 'E23', 'Membekal dan memasang semua bahan mengikut spesifikasi piawai JKR termasuk harga tenaga kerja dan bahan :-', 'satu', 'Pintu servis dari jenis fiber (untuk tiang lampu) l/d ukiran JKR', 136.60, 0, NULL),
('VI', 'A     Kerja-kerja membekal, memasang, menyambung, memateri penghujung kabel, menggali parit, menabur pasir, menyusun batu-bata / penutup kabel perlind', 'A1', 'Kabel PVC/SWA/PVC :', 'meter', '2.5mm persegi 2 teras.', 62.80, 0, NULL),
('VI', 'B     Kerja-kerja membekal, memasang, menyambung, memateri penghujung kabel, menggali parit, menabur pasir, menyusun batu-bata / penutup kabel perlind', 'B1', 'Kabel PVC/SWA/PVC :', 'meter', '2.5mm persegi 2 teras.', 60.30, 0, NULL),
('VI', 'C     Kerja-kerja membekal dan memasang kabel di atas penatang kabel. (Harga tidak termasuk penatang kabel). Kabel jenis KUPRUM', 'C1', 'Kabel PVC/SWA/PVC :', 'meter', '2.5mm persegi 2 teras.', 28.10, 0, NULL),
('VI', 'D     Kerja-kerja membekal dan memasang alat-alat lengkap kabel PVC/SWA/PVC, XLPE/SWA/PVC dan XLPE/AWA/PVC JENIS KUPRUM.', 'D1', 'Cuping kabel (cable lug) untuk saiz kabel :', 'satu', '2.5mm persegi sehingga 16mm persegi.', 7.50, 0, NULL),
('VI', 'E     Kerja-kerja penyambungan kabel jenis KUPRUM di dalam tanah l/d kit sambungan (moulded resin) untuk kabel, termasuk menggali peparit, memotong ka', 'E1', 'Kabel PVC/SWA/PVC :', 'satu', '2.5mm persegi 2 teras.', 243.10, 0, NULL),
('VI', 'F     Kerja-kerja pemotongan dan penyambungan semula kabel di permukaan l/d kit sambungan (moulded resin ) untuk kabel jenis KUPRUM selaras dengan per', 'F1', 'Kabel PVC/SWA/PVC :', 'satu', '2.5mm persegi 2 teras.', 150.00, 0, NULL),
('VI', 'G     Kerja-kerja membekal, memasang, menyambung, memateri penghujung kabel, menggali parit, menabur pasir, menyusun batu-bata / penutup kabel perlind', 'G1', 'Kabel PVC/SWA/PVC :', 'meter', '16mm persegi 2 teras.', 68.30, 0, NULL),
('VI', 'H     Kerja-kerja membekal, memasang, menyambung, memateri penghujung kabel, menggali parit, menabur pasir, menyusun batu-bata / penutup kabel perlind', 'H1', 'Kabel PVC/SWA/PVC :', 'meter', '16mm persegi 2 teras.', 65.80, 0, NULL),
('VI', 'I    Kerja-kerja membekal dan memasang kabel jenis ALUMINIUM di atas penatang kabel. (Harga tidak termasuk penatang kabel).', 'I1', 'Kabel XLPE/SWA/PVC :', 'meter', '16mm persegi 2 teras', 34.80, 0, NULL),
('VI', 'J     Kerja-kerja membekal dan memasang alat-alat lengkap kabel jenis ALUMINIUM PVC/SWA/PVC, XLPE/SWA/PVC dan XLPE/AWA/PVC.', 'J1', 'Cuping kabel jenis \'Bi-Metal\' (cable lug ) untuk saiz kabel:', 'satu', '16mm', 20.00, 0, NULL),
('VII', 'A     Kerja - kerja menanggal sahaja tanpa skop pemasangan baru:-', 'A1', 'Lengkapan lampu/speaker semua jenis', 'satu', '-', 16.40, 0, NULL),
('VII', 'B     Kerja-kerja memasang peralatan sahaja tanpa pembekalan', 'B1', 'Lengkapan lampu/speaker semua jenis', 'satu', '-', 16.90, 0, NULL),
('VII', 'C     Kerja-kerja menyediakan bukaan dan membaiki', 'C1', 'Menyediakan bukaan kepada kaca termasuk memasang bingkai untuk pemasangan kipas pelawas yang bersesuaian.', 'satu', '-', 215.30, 0, NULL),
('VII', 'D     Membekal dan memasang', 'D1', 'Pemanas air jenis \'auto pump\'', 'satu', '-', 999.99, 0, NULL),
('VII', 'E     Kerja-Kerja Pengujian', 'E1', 'Membuat ujian keatas pendawaian elektrik sedia ada dan berurusan dengan pihak TNB untuk penyambungan semula bekalan elektrik satu fasa (kuarters dan setara dengannya) (tidak termasuk cas sambungan pengguna dan wang cagaran)', 'satu', '-', 999.99, 0, NULL),
('VII', 'F     Horizontal Directional Drilling (HDD)', 'F1', 'Membekal dan memasang paip High-density polyethylene (HDPE) menggunakan kaedah Horizontal Directional Drilling (HDD) untuk paip :', 'meter', '1 x 100mm', 331.10, 0, NULL),
('VII', 'G     Sewaan', 'G1', 'Sewaan perancah (scaffolding / staging) bagi anggaranketinggian tidak melebihi 10 meter', 'Lot', '-', 690.00, 0, NULL),
('VII', 'H     Lain - Lain', 'H1', 'Kerja-kerja memotong jalan menggunakan diamond cutter', 'meter', '-', 120.70, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_construction_order`
--

CREATE TABLE `tb_construction_order` (
  `O_id` varchar(5) NOT NULL,
  `O_date` date NOT NULL,
  `O_remark` varchar(100) NOT NULL,
  `EK_addon` int(2) NOT NULL,
  `AK_addon` int(2) NOT NULL,
  `COE_totalCost` decimal(7,2) NOT NULL,
  `COA_totalCost` decimal(7,2) NOT NULL,
  `O_totalCost` decimal(9,2) NOT NULL,
  `CO_markup` decimal(7,2) NOT NULL,
  `O_totalPrice` decimal(9,2) NOT NULL,
  `O_TOP` int(11) NOT NULL,
  `C_id` varchar(5) NOT NULL,
  `O_quotationStatus` int(11) NOT NULL,
  `O_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_construction_order`
--

INSERT INTO `tb_construction_order` (`O_id`, `O_date`, `O_remark`, `EK_addon`, `AK_addon`, `COE_totalCost`, `COA_totalCost`, `O_totalCost`, `CO_markup`, `O_totalPrice`, `O_TOP`, `C_id`, `O_quotationStatus`, `O_status`) VALUES
('C0001', '2024-01-19', 'QR', 1, 1, 0.00, 0.00, 0.00, 0.00, 991.00, 1, 'C002', 0, 3),
('C0002', '2024-01-18', 'Poppy', 1, 1, 135.96, 0.00, 135.96, 0.00, 135.96, 1, 'C001', 11, 1),
('C0003', '2024-01-17', '123', 2, 1, 928.20, 540.50, 1468.70, 5.00, 1542.14, 3, 'C001', 11, 1),
('C0004', '2024-02-02', '13', 2, 1, 1050.46, 0.00, 1050.46, 2.00, 1071.47, 1, 'C002', 11, 3),
('C0005', '2024-01-26', 'sdsc', 1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 1, 'C007', 0, 1),
('C0006', '2024-01-17', 'Taman U', 3, 3, 269.23, 1383.60, 1652.83, 10.00, 1818.11, 1, 'C009', 11, 2),
('C0007', '2024-01-18', 'xxx', 1, 2, 0.00, 16451.37, 16451.37, 20.00, 19741.64, 1, 'C008', 0, 2),
('C0008', '2024-02-01', 'sdsc', 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 1, 'C003', 0, 2),
('C0009', '2024-01-29', 'eq', 2, 3, 80.37, 801.38, 881.75, 0.00, 881.75, 1, 'C002', 11, 2),
('C0010', '2024-02-02', 'sdsc', 2, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 1, 'C003', 0, 2),
('C0011', '2024-01-31', 'WE', 1, 1, 867.76, 0.00, 867.76, 23.00, 1067.34, 1, 'C002', 11, 2),
('C0012', '2024-02-17', 'Plastic Brick', 1, 1, 0.00, 144.60, 144.60, 0.00, 144.60, 1, 'C005', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_construction_quotation`
--

CREATE TABLE `tb_construction_quotation` (
  `CQ_id` varchar(50) NOT NULL,
  `CQ_issueDate` date NOT NULL,
  `CQ_dueDate` date NOT NULL,
  `CQ_path` varchar(100) NOT NULL,
  `CQ_remark` varchar(50) DEFAULT NULL,
  `CQ_status` int(11) NOT NULL,
  `O_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_control`
--

CREATE TABLE `tb_control` (
  `U_id` varchar(3) NOT NULL,
  `CM_id` varchar(6) NOT NULL,
  `CM_type` varchar(5) NOT NULL,
  `CM_variation` varchar(150) NOT NULL,
  `CMH_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_co_material`
--

CREATE TABLE `tb_co_material` (
  `CM_id` varchar(6) NOT NULL,
  `CM_type` varchar(5) NOT NULL,
  `CM_variation` varchar(150) NOT NULL,
  `COM_qty` int(5) NOT NULL,
  `COM_unit` decimal(7,2) NOT NULL,
  `COM_price` decimal(7,2) NOT NULL,
  `COM_discPct` decimal(7,2) NOT NULL,
  `COM_discAmt` decimal(7,2) NOT NULL,
  `COM_taxCode` varchar(10) NOT NULL,
  `COM_taxAmt` decimal(7,2) NOT NULL,
  `O_id` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_co_material`
--

INSERT INTO `tb_co_material` (`CM_id`, `CM_type`, `CM_variation`, `COM_qty`, `COM_unit`, `COM_price`, `COM_discPct`, `COM_discAmt`, `COM_taxCode`, `COM_taxAmt`, `O_id`) VALUES
('B1', '4B', 'Grade 15 (1:3:6-25mm) : Granit', 1, 1.00, 360.00, 1.00, 3.60, '1', 1.00, 'C0003'),
('B1', '4B', 'Grade 15 (1:3:6-25mm) : Granit', 12, 4.00, 13946.00, 20.00, 2789.23, 'See', 30.00, 'C0007'),
('B2', 'II', '6 hala', 1, 1.00, 884.00, 1.00, 8.84, '1', 1.00, 'C0003'),
('B22', '4B', 'Tanggal & Buang', 1, 1.00, 143.00, 0.00, 0.00, '0', 0.00, 'C0006'),
('C3', '4C', 'Mortar : Simen dan pasir (1:3)', 1, 1.00, 125.74, 1.00, 1.26, '1', 1.00, 'C0012'),
('C3', '4C', 'Mortar : Simen, kapur, pasir (1:1:6)', 1, 1.00, 117.82, 1.00, 1.18, '1', 1.00, 'C0009'),
('D1', 'IV', '1 Tiub Led (600mm)', 1, 1.00, 76.54, 1.00, 0.77, '1', 1.00, 'C0009'),
('D38', 'IV', '100 W', 1, 1.00, 834.38, 1.00, 8.34, '1', 1.00, 'C0011'),
('E3', 'II', 'Isc > 5kA, Imax > 40kA ,Up < 1500V, Mode Of Protection (L-N, L-E & N-E) - (Same location with MSB)', 1, 1.00, 991.00, 1.00, 9.91, '1', 1.00, 'C0001'),
('E3', 'II', 'Isc > 5kA, Imax > 40kA ,Up < 1500V, Mode Of Protection (L-N, L-E & N-E) - (Same location with MSB)', 1, 1.00, 991.00, 1.00, 9.91, '1', 1.00, 'C0004'),
('G1', 'II', '-', 1, 1.00, 132.00, 1.00, 1.32, '1', 1.00, 'C0002'),
('H14', 'IV', 'Kipas lekapan dinding 300mm. (12) g.p.', 1, 1.00, 247.00, 0.00, 0.00, '0', 0.00, 'C0006');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cq_generation`
--

CREATE TABLE `tb_cq_generation` (
  `CQ_id` varchar(50) NOT NULL,
  `U_id` varchar(3) NOT NULL,
  `D_Progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `C_id` varchar(5) NOT NULL,
  `C_name` varchar(70) NOT NULL,
  `C_type` int(11) NOT NULL,
  `C_email` varchar(40) NOT NULL,
  `C_street` varchar(25) NOT NULL,
  `C_city` varchar(20) NOT NULL,
  `C_postcode` int(5) NOT NULL,
  `C_state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`C_id`, `C_name`, `C_type`, `C_email`, `C_street`, `C_city`, `C_postcode`, `C_state`) VALUES
('C001', 'Aaron', 1, '123@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C002', 'Poppy', 2, '124@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C003', 'Bernice', 3, '125@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C004', 'Poppy', 1, '124@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C005', 'Poppy', 1, '124@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C006', 'Poppy2', 1, '124@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C007', 'yddw', 1, '123@gmail.com', 'vcs', 'cs', 81300, 'cds'),
('C008', 'Bernice', 1, '125@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C009', 'Yan Qing', 1, '987@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C010', 'Bernice', 3, '125@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C011', 'sd', 1, 'cteh60112@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C012', 'Jojoe', 1, '123@gmail.com', 'Jalan', 'Taman', 74340, 'Melaka'),
('C013', 'Muhammad', 1, 'muhammad@gmail.com', '297,Jln Madu', 'Kangar', 86899, 'Kedah'),
('C014', 'Muhammad', 1, 'muhammad@gmail.com', '297,Jln Madu', 'Kangar', 86790, 'Kedah'),
('C015', 'Bernice', 3, '125@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C016', 'Bernice', 3, '125@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka'),
('C017', 'we321', 1, 'cteh601123@gmail.com', 'Jalan malim jaya', 'Melaka raya', 75250, 'Melaka');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer_phone`
--

CREATE TABLE `tb_customer_phone` (
  `C_id` varchar(5) NOT NULL,
  `C_phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer_phone`
--

INSERT INTO `tb_customer_phone` (`C_id`, `C_phone`) VALUES
('C001', '0123456789'),
('C002', '0112223333'),
('C003', '0142223333'),
('C006', '0123456782'),
('C009', '0112223334'),
('C010', '0112232213'),
('C011', '1322131231'),
('C012', '0198765432'),
('C013', '023123453'),
('C014', '012725347'),
('C017', '0102502497');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer_type`
--

CREATE TABLE `tb_customer_type` (
  `C_type` int(11) NOT NULL,
  `C_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer_type`
--

INSERT INTO `tb_customer_type` (`C_type`, `C_desc`) VALUES
(1, 'Personnel'),
(2, 'Government'),
(3, 'Agency');

-- --------------------------------------------------------

--
-- Table structure for table `tb_delivery_order`
--

CREATE TABLE `tb_delivery_order` (
  `DO_id` varchar(50) NOT NULL,
  `DO_issueDate` date NOT NULL,
  `DO_deliveryDate` date NOT NULL,
  `DO_path` varchar(100) NOT NULL,
  `DO_remark` varchar(50) DEFAULT NULL,
  `DO_status` varchar(11) DEFAULT NULL,
  `O_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_delivery_order`
--

INSERT INTO `tb_delivery_order` (`DO_id`, `DO_issueDate`, `DO_deliveryDate`, `DO_path`, `DO_remark`, `DO_status`, `O_id`) VALUES
('DO596e81', '2024-02-03', '2024-02-27', 'DeliveryOrder/DO596e81_A0001.pdf', NULL, '11', 'A0001');

-- --------------------------------------------------------

--
-- Table structure for table `tb_do_generation`
--

CREATE TABLE `tb_do_generation` (
  `DO_id` varchar(50) NOT NULL,
  `U_id` varchar(3) NOT NULL,
  `D_Progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_do_generation`
--

INSERT INTO `tb_do_generation` (`DO_id`, `U_id`, `D_Progress`) VALUES
('DO596e81', '001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_import_log`
--

CREATE TABLE `tb_import_log` (
  `U_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AK_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AK_ctgy` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `I_id` varchar(50) NOT NULL,
  `I_expiryDate` date NOT NULL,
  `I_issueDate` date NOT NULL,
  `I_path` varchar(100) NOT NULL,
  `I_remark` varchar(50) DEFAULT NULL,
  `I_status` int(11) NOT NULL,
  `O_id` varchar(5) NOT NULL,
  `DO_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice_generation`
--

CREATE TABLE `tb_invoice_generation` (
  `I_id` varchar(50) NOT NULL,
  `U_id` varchar(3) NOT NULL,
  `D_progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_order_rate`
--

CREATE TABLE `tb_order_rate` (
  `O_id` varchar(5) NOT NULL,
  `AK_name` varchar(40) NOT NULL,
  `AK_ctgy` varchar(2) NOT NULL,
  `AK_region` varchar(2) NOT NULL,
  `AKR_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order_rate`
--

INSERT INTO `tb_order_rate` (`O_id`, `AK_name`, `AK_ctgy`, `AK_region`, `AKR_unit`) VALUES
('C0003', 'Tukang Batu-bata', 'T', 'B', 1),
('C0006', 'Excavator', 'L', 'A', 1),
('C0006', 'Tukang Batu-bata', 'T', 'A', 2),
('C0007', 'Tukang Batu', 'T', 'B', 3),
('C0009', 'Backhoe Excavator (bucket 0.77 m3)', 'L', 'A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_order_status`
--

CREATE TABLE `tb_order_status` (
  `O_status` int(11) NOT NULL,
  `O_desc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order_status`
--

INSERT INTO `tb_order_status` (`O_status`, `O_desc`) VALUES
(0, 'Not Yet Start'),
(1, 'Complete'),
(2, 'In Progress'),
(3, 'Cancelled'),
(4, 'Accepted'),
(5, 'Rejected'),
(6, 'Pending Payment'),
(7, 'Deposit Paid'),
(8, 'Fully Paid'),
(9, 'Approved'),
(10, 'Delivered'),
(11, 'Pending Approval'),
(12, 'Pending Review and Approval'),
(13, 'Checked and Approved');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order_zone`
--

CREATE TABLE `tb_order_zone` (
  `O_id` varchar(6) NOT NULL,
  `Z_state` varchar(50) NOT NULL,
  `Z_region` varchar(100) NOT NULL,
  `Z_distance` varchar(3) NOT NULL,
  `CM_ctgy` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order_zone`
--

INSERT INTO `tb_order_zone` (`O_id`, `Z_state`, `Z_region`, `Z_distance`, `CM_ctgy`) VALUES
('C0001', 'KEDAH', 'Kota Setar', 'A', 1),
('C0001', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0002', 'KEDAH', 'Kota Setar', 'A', 1),
('C0002', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0003', 'KEDAH', 'Kota Setar', 'B', 1),
('C0003', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0004', 'P. PINANG', 'Barat Daya', 'D', 2),
('C0004', 'PERLIS', 'Kangar', 'C', 1),
('C0005', 'KEDAH', 'Kota Setar', 'A', 1),
('C0005', 'KEDAH', 'Kubang Pasu', 'A', 2),
('C0006', 'P. PINANG', 'Barat Daya', 'B', 2),
('C0006', 'PERLIS', 'Kangar', 'A', 1),
('C0007', 'KEDAH', 'Kota Setar', 'B', 1),
('C0007', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0008', 'P. PINANG', 'Barat Daya', 'B', 2),
('C0008', 'PERLIS', 'Kangar', 'D', 1),
('C0009', 'KEDAH', 'Kota Setar', 'B', 1),
('C0009', 'P. PINANG', 'Barat Daya', 'B', 2),
('C0010', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0010', 'PERLIS', 'Kangar', 'A', 1),
('C0011', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0011', 'PERLIS', 'Kangar', 'A', 1),
('C0012', 'P. PINANG', 'Barat Daya', 'A', 2),
('C0012', 'PERLIS', 'Kangar', 'A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment_ref`
--

CREATE TABLE `tb_payment_ref` (
  `P_id` varchar(25) NOT NULL,
  `P_path` varchar(50) NOT NULL,
  `P_uploadDate` datetime NOT NULL,
  `P_status` int(11) NOT NULL,
  `U_id` varchar(5) NOT NULL,
  `O_id` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_payment_ref`
--

INSERT INTO `tb_payment_ref` (`P_id`, `P_path`, `P_uploadDate`, `P_status`, `U_id`, `O_id`) VALUES
('Pe38db4fb7e659383', 'paymentRef/001_1706542476.png', '2024-01-29 15:34:36', 0, '001', 'A0002');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymethod`
--

CREATE TABLE `tb_paymethod` (
  `P_id` int(11) NOT NULL,
  `P_desc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_paymethod`
--

INSERT INTO `tb_paymethod` (`P_id`, `P_desc`) VALUES
(0, 'Haven\'t'),
(1, 'Card'),
(2, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tb_progress`
--

CREATE TABLE `tb_progress` (
  `D_progress` int(2) NOT NULL,
  `D_desc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_progress`
--

INSERT INTO `tb_progress` (`D_progress`, `D_desc`) VALUES
(1, 'Generate'),
(2, 'Check'),
(3, 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rate`
--

CREATE TABLE `tb_rate` (
  `AK_name` varchar(40) NOT NULL,
  `AK_unit` varchar(4) NOT NULL,
  `AK_price` decimal(8,2) NOT NULL,
  `AK_region` varchar(2) NOT NULL,
  `AK_ctgy` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rate`
--

INSERT INTO `tb_rate` (`AK_name`, `AK_unit`, `AK_price`, `AK_region`, `AK_ctgy`) VALUES
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 550.00, 'A', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 540.00, 'B', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 550.00, 'C', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 490.00, 'D', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 550.00, 'E', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 600.00, 'F', 'L'),
('Backhoe Excavator (bucket 0.77 m3)', 'Day', 600.00, 'S', 'L'),
('Excavator', 'Day', 900.00, 'A', 'L'),
('Excavator', 'Day', 850.00, 'B', 'L'),
('Excavator', 'Day', 700.00, 'C', 'L'),
('Excavator', 'Day', 600.00, 'D', 'L'),
('Excavator', 'Day', 950.00, 'E', 'L'),
('Excavator', 'Day', 1.00, 'F', 'L'),
('Excavator', 'Day', 800.00, 'S', 'L'),
('Tukang Batu', 'Day', 110.00, 'A', 'T'),
('Tukang Batu', 'Day', 115.00, 'B', 'T'),
('Tukang Batu', 'Day', 120.00, 'C', 'T'),
('Tukang Batu', 'Day', 115.00, 'D', 'T'),
('Tukang Batu', 'Day', 105.00, 'E', 'T'),
('Tukang Batu', 'Day', 110.00, 'F', 'T'),
('Tukang Batu', 'Day', 110.00, 'S', 'T'),
('Tukang Batu-bata', 'Day', 110.00, 'A', 'T'),
('Tukang Batu-bata', 'Day', 110.00, 'B', 'T'),
('Tukang Batu-bata', 'Day', 120.00, 'C', 'T'),
('Tukang Batu-bata', 'Day', 110.00, 'D', 'T'),
('Tukang Batu-bata', 'Day', 100.00, 'E', 'T'),
('Tukang Batu-bata', 'Day', 105.00, 'F', 'T'),
('Tukang Batu-bata', 'Day', 110.00, 'S', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `tb_signature`
--

CREATE TABLE `tb_signature` (
  `S_id` varchar(50) NOT NULL,
  `S_path` varchar(50) NOT NULL,
  `S_uploadDate` datetime NOT NULL,
  `S_status` int(11) NOT NULL,
  `U_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_signature`
--

INSERT INTO `tb_signature` (`S_id`, `S_path`, `S_uploadDate`, `S_status`, `U_id`) VALUES
('S5b5759', 'signatures/001_1706887748.png', '2024-02-02 15:29:08', 1, '001'),
('S81b1d3', 'signatures/003_1706413298.png', '2024-01-28 03:41:38', 0, '003'),
('Sd1d629', 'signatures/001_1705423079.png', '2024-01-16 16:37:59', 0, '001');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supervision`
--

CREATE TABLE `tb_supervision` (
  `U_id` varchar(3) NOT NULL,
  `Admin_id` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_supervision`
--

INSERT INTO `tb_supervision` (`U_id`, `Admin_id`) VALUES
('001', NULL),
('002', '001'),
('003', NULL),
('S04', '003'),
('S05', '001'),
('S07', '001'),
('S08', '001');

-- --------------------------------------------------------

--
-- Table structure for table `tb_terms_of_payment`
--

CREATE TABLE `tb_terms_of_payment` (
  `TOP_id` int(11) NOT NULL,
  `TOP_name` varchar(10) NOT NULL,
  `TOP_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_terms_of_payment`
--

INSERT INTO `tb_terms_of_payment` (`TOP_id`, `TOP_name`, `TOP_desc`) VALUES
(1, 'LO', 'Local Order'),
(2, 'OT', 'Online Transfer'),
(3, 'CHQ', 'Cheque'),
(4, 'CASH', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tb_update_log`
--

CREATE TABLE `tb_update_log` (
  `U_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Z_state` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Z_region` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Z_distance` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Z_ctgy` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `U_id` varchar(3) NOT NULL,
  `U_type` varchar(5) NOT NULL,
  `U_pwd` varchar(100) NOT NULL,
  `U_name` varchar(70) NOT NULL,
  `U_email` varchar(40) NOT NULL,
  `U_lastLogin` datetime DEFAULT NULL,
  `U_position` varchar(20) NOT NULL,
  `is_archived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`U_id`, `U_type`, `U_pwd`, `U_name`, `U_email`, `U_lastLogin`, `U_position`, `is_archived`) VALUES
('001', 'Admin', '$2y$10$hUYGwXSm8PNdwOogISTUmOJCigsZuZHeP6fcRMePprA4AQisOq2nC', 'Ali', 'cteh6011@gmail.com', '2024-02-03 20:01:28', '1233', 0),
('002', 'Staff', '$2y$10$oIOf.dvRKFHnkiQh/aX7je7nCKFvG7Sb3ToL12R.oc3S2YAN.r4AO', '456', 'cteh60112@gmail.com', '2024-01-15 15:53:11', '456', 0),
('003', 'Admin', '$2y$10$hlXhgaJa73XsxjOXJRxi0ujqiIBD.4bmY6labeMHg0N6qGFoHMV7m', 'sssa', 'oyiyan22@gmail.com', '2024-02-03 02:28:43', 'CEO', 0),
('004', 'Admin', '$2y$10$oIOf.dvRKFHnkiQh/aX7je7nCKFvG7Sb3ToL12R.oc3S2YAN.r4AO', '004', 'cteh60112@gmail.com', '2024-01-17 08:38:19', 'CEO', 0),
('S04', 'Staff', '$2y$10$VZPVkxfwS/BeMj1wE81hEeDbXJjJ1YpMU94EN6BKM.8fqfigK3vsi', 'dd', '12a@gmail.com', '2024-01-27 15:45:30', 'polo', 0),
('S05', 'Staff', '$2y$10$M0WU0j472/y6Yeo6FudA0eMBN6oSNLhWL1qCoeqUKQhMoFQGVqjh.', 'Abu', 'abu@gmail.com', NULL, 'Designer', 1),
('S07', 'Staff', '$2y$10$CtlJa3vk40HTCUUJsl4CRek.EIl5mye0m2YY38BJCD0uTjyDYlGnS', 'Lee32', '145@gmail.com', '2024-02-03 12:07:31', 'Senior Designer', 0),
('S08', 'Staff', '$2y$10$KJPAuU.7hX9nXZ0Flrh4KObp0w/x5zikcf8NPtaK2b4NFp47WQGH2', '789', 'gohstdtest@gmail.com', '2024-01-28 00:15:22', 'Junior Designer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_zone`
--

CREATE TABLE `tb_zone` (
  `Z_state` varchar(50) NOT NULL,
  `Z_region` varchar(100) NOT NULL,
  `Z_perc` int(3) NOT NULL,
  `Z_distance` varchar(3) NOT NULL,
  `CM_ctgy` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_zone`
--

INSERT INTO `tb_zone` (`Z_state`, `Z_region`, `Z_perc`, `Z_distance`, `CM_ctgy`) VALUES
('KEDAH', 'Atas Gunung Jerai', 0, 'A', 2),
('KEDAH', 'Atas Gunung Jerai', 0, 'B', 2),
('KEDAH', 'Atas Gunung Jerai', 35, 'C', 2),
('KEDAH', 'Atas Gunung Jerai', 0, 'D', 2),
('KEDAH', 'Atas Gunung Jerai', 0, 'E', 2),
('KEDAH', 'Kota Setar', 3, 'A', 1),
('KEDAH', 'Kota Setar', 9, 'B', 1),
('KEDAH', 'Kubang Pasu', 15, 'A', 2),
('KEDAH', 'Kubang Pasu', 15, 'B', 2),
('KEDAH', 'Kubang Pasu', 15, 'C', 2),
('KEDAH', 'Kubang Pasu', 20, 'D', 2),
('KEDAH', 'Kubang Pasu', 20, 'E', 2),
('KEDAH', 'Pendang', 10, 'A', 2),
('KEDAH', 'Pendang', 12, 'B', 2),
('KEDAH', 'Pendang', 15, 'C', 2),
('KEDAH', 'Pendang', 18, 'D', 2),
('KEDAH', 'Pendang', 20, 'E', 2),
('KEDAH', 'Yan', 10, 'A', 2),
('KEDAH', 'Yan', 10, 'B', 2),
('KEDAH', 'Yan', 12, 'C', 2),
('KEDAH', 'Yan', 15, 'D', 2),
('KEDAH', 'Yan', 17, 'E', 2),
('P. PINANG', 'Barat Daya', 15, 'A', 2),
('P. PINANG', 'Barat Daya', 25, 'B', 2),
('P. PINANG', 'Barat Daya', 0, 'C', 2),
('P. PINANG', 'Barat Daya', 0, 'D', 2),
('P. PINANG', 'Barat Daya', 0, 'E', 2),
('P. PINANG', 'Pulau Aman (20km)', 0, 'A', 2),
('P. PINANG', 'Pulau Aman (20km)', 30, 'B', 2),
('P. PINANG', 'Pulau Aman (20km)', 0, 'C', 2),
('P. PINANG', 'Pulau Aman (20km)', 0, 'D', 2),
('P. PINANG', 'Pulau Aman (20km)', 0, 'E', 2),
('P. PINANG', 'Seberang Perai Selatan', 15, 'A', 2),
('P. PINANG', 'Seberang Perai Selatan', 20, 'B', 2),
('P. PINANG', 'Seberang Perai Selatan', 25, 'C', 2),
('P. PINANG', 'Seberang Perai Selatan', 30, 'D', 2),
('P. PINANG', 'Seberang Perai Selatan', 30, 'E', 2),
('P. PINANG', 'Seberang Perai Tengah', 15, 'A', 2),
('P. PINANG', 'Seberang Perai Tengah', 20, 'B', 2),
('P. PINANG', 'Seberang Perai Tengah', 25, 'C', 2),
('P. PINANG', 'Seberang Perai Tengah', 30, 'D', 2),
('P. PINANG', 'Seberang Perai Tengah', 30, 'E', 2),
('P. PINANG', 'Seberang Perai Utara', 15, 'A', 2),
('P. PINANG', 'Seberang Perai Utara', 19, 'B', 2),
('P. PINANG', 'Seberang Perai Utara', 23, 'C', 2),
('P. PINANG', 'Seberang Perai Utara', 27, 'D', 2),
('P. PINANG', 'Seberang Perai Utara', 27, 'E', 2),
('P. PINANG', 'Timur Laut', 15, 'A', 2),
('P. PINANG', 'Timur Laut', 20, 'B', 2),
('P. PINANG', 'Timur Laut', 25, 'C', 2),
('P. PINANG', 'Timur Laut', 32, 'D', 2),
('P. PINANG', 'Timur Laut', 32, 'E', 2),
('PERLIS', 'Kangar', 4, 'A', 1),
('PERLIS', 'Kangar', 9, 'B', 1),
('PERLIS', 'Kangar', 12, 'C', 1),
('PERLIS', 'Kangar', 30, 'D', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  ADD PRIMARY KEY (`email`,`expDate`);

--
-- Indexes for table `tb_adjustment`
--
ALTER TABLE `tb_adjustment`
  ADD PRIMARY KEY (`C_id`,`U_id`),
  ADD KEY `auid2` (`U_id`);

--
-- Indexes for table `tb_advertisement_adjustment`
--
ALTER TABLE `tb_advertisement_adjustment`
  ADD PRIMARY KEY (`U_id`,`AM_id`,`AMH_date`),
  ADD KEY `aaamid` (`AM_id`);

--
-- Indexes for table `tb_advertisement_material`
--
ALTER TABLE `tb_advertisement_material`
  ADD PRIMARY KEY (`AM_id`),
  ADD KEY `amtype` (`AM_type`);

--
-- Indexes for table `tb_advertisement_order`
--
ALTER TABLE `tb_advertisement_order`
  ADD PRIMARY KEY (`O_id`),
  ADD KEY `aocid` (`C_id`),
  ADD KEY `aopid` (`AO_payMethod`),
  ADD KEY `aotop` (`O_TOP`),
  ADD KEY `aostatus` (`O_status`),
  ADD KEY `qaostatus` (`O_quotationStatus`),
  ADD KEY `dostatus` (`AO_deliveryStatus`),
  ADD KEY `istatus` (`AO_invoiceStatus`),
  ADD KEY `pstatus` (`AO_paymentStatus`);

--
-- Indexes for table `tb_advertisement_quotation`
--
ALTER TABLE `tb_advertisement_quotation`
  ADD PRIMARY KEY (`AQ_id`),
  ADD KEY `O_id` (`O_id`),
  ADD KEY `AQ_status` (`AQ_status`);

--
-- Indexes for table `tb_agency_government`
--
ALTER TABLE `tb_agency_government`
  ADD PRIMARY KEY (`AG_name`),
  ADD KEY `agcid` (`C_id`);

--
-- Indexes for table `tb_ag_phone`
--
ALTER TABLE `tb_ag_phone`
  ADD PRIMARY KEY (`AG_phone`),
  ADD KEY `C_id` (`C_id`);

--
-- Indexes for table `tb_am_history`
--
ALTER TABLE `tb_am_history`
  ADD PRIMARY KEY (`AM_id`,`AMH_date`,`U_id`),
  ADD KEY `amhuid` (`U_id`);

--
-- Indexes for table `tb_am_type`
--
ALTER TABLE `tb_am_type`
  ADD PRIMARY KEY (`AM_type`);

--
-- Indexes for table `tb_ao_material`
--
ALTER TABLE `tb_ao_material`
  ADD PRIMARY KEY (`AM_id`,`O_id`),
  ADD KEY `aomoid` (`O_id`);

--
-- Indexes for table `tb_aq_generation`
--
ALTER TABLE `tb_aq_generation`
  ADD PRIMARY KEY (`AQ_id`,`D_Progress`),
  ADD KEY `D_Progress` (`D_Progress`),
  ADD KEY `uid2` (`U_id`);

--
-- Indexes for table `tb_cm_ctgy`
--
ALTER TABLE `tb_cm_ctgy`
  ADD PRIMARY KEY (`CM_ctgy`);

--
-- Indexes for table `tb_cm_type`
--
ALTER TABLE `tb_cm_type`
  ADD PRIMARY KEY (`CM_type`),
  ADD KEY `cmctgy2` (`CM_ctgy`);

--
-- Indexes for table `tb_construction_material`
--
ALTER TABLE `tb_construction_material`
  ADD PRIMARY KEY (`CM_type`,`CM_id`,`CM_variation`),
  ADD KEY `CM_variation` (`CM_variation`),
  ADD KEY `CM_id` (`CM_id`);

--
-- Indexes for table `tb_construction_order`
--
ALTER TABLE `tb_construction_order`
  ADD PRIMARY KEY (`O_id`),
  ADD KEY `coid` (`C_id`),
  ADD KEY `cotop` (`O_TOP`),
  ADD KEY `costatus` (`O_status`),
  ADD KEY `coqstatus` (`O_quotationStatus`);

--
-- Indexes for table `tb_construction_quotation`
--
ALTER TABLE `tb_construction_quotation`
  ADD PRIMARY KEY (`CQ_id`),
  ADD KEY `O_id` (`O_id`),
  ADD KEY `CQ_status` (`CQ_status`);

--
-- Indexes for table `tb_control`
--
ALTER TABLE `tb_control`
  ADD PRIMARY KEY (`U_id`,`CM_id`,`CM_type`,`CM_variation`,`CMH_date`),
  ADD KEY `controlprimary` (`CM_id`,`CM_type`,`CM_variation`);

--
-- Indexes for table `tb_co_material`
--
ALTER TABLE `tb_co_material`
  ADD PRIMARY KEY (`CM_id`,`CM_type`,`CM_variation`,`O_id`),
  ADD KEY `comcoid` (`O_id`),
  ADD KEY `comprimary` (`CM_type`,`CM_id`,`CM_variation`);

--
-- Indexes for table `tb_cq_generation`
--
ALTER TABLE `tb_cq_generation`
  ADD PRIMARY KEY (`CQ_id`,`D_Progress`),
  ADD KEY `D_Progress` (`D_Progress`),
  ADD KEY `uid2` (`U_id`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`C_id`),
  ADD KEY `ctype` (`C_type`);

--
-- Indexes for table `tb_customer_phone`
--
ALTER TABLE `tb_customer_phone`
  ADD PRIMARY KEY (`C_phone`),
  ADD KEY `C_id` (`C_id`);

--
-- Indexes for table `tb_customer_type`
--
ALTER TABLE `tb_customer_type`
  ADD PRIMARY KEY (`C_type`);

--
-- Indexes for table `tb_delivery_order`
--
ALTER TABLE `tb_delivery_order`
  ADD PRIMARY KEY (`DO_id`),
  ADD KEY `doid` (`O_id`);

--
-- Indexes for table `tb_do_generation`
--
ALTER TABLE `tb_do_generation`
  ADD PRIMARY KEY (`DO_id`,`D_Progress`),
  ADD KEY `DO_id` (`DO_id`),
  ADD KEY `U_id` (`U_id`),
  ADD KEY `D_Progress` (`D_Progress`);

--
-- Indexes for table `tb_import_log`
--
ALTER TABLE `tb_import_log`
  ADD PRIMARY KEY (`U_id`,`AK_name`,`AK_ctgy`),
  ADD KEY `importname` (`AK_name`),
  ADD KEY `AK_ctgy` (`AK_ctgy`);

--
-- Indexes for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`I_id`),
  ADD KEY `ioid` (`O_id`),
  ADD KEY `doiid` (`DO_id`);

--
-- Indexes for table `tb_invoice_generation`
--
ALTER TABLE `tb_invoice_generation`
  ADD PRIMARY KEY (`I_id`,`D_progress`),
  ADD KEY `I_id` (`I_id`),
  ADD KEY `D_progress` (`D_progress`),
  ADD KEY `U_id` (`U_id`);

--
-- Indexes for table `tb_order_rate`
--
ALTER TABLE `tb_order_rate`
  ADD PRIMARY KEY (`O_id`,`AK_name`,`AK_ctgy`,`AK_region`),
  ADD KEY `orrate` (`AK_name`,`AK_region`,`AK_ctgy`);

--
-- Indexes for table `tb_order_status`
--
ALTER TABLE `tb_order_status`
  ADD PRIMARY KEY (`O_status`);

--
-- Indexes for table `tb_order_zone`
--
ALTER TABLE `tb_order_zone`
  ADD PRIMARY KEY (`O_id`,`Z_state`,`Z_region`,`Z_distance`,`CM_ctgy`),
  ADD KEY `ozone` (`Z_state`,`Z_region`,`Z_distance`,`CM_ctgy`);

--
-- Indexes for table `tb_payment_ref`
--
ALTER TABLE `tb_payment_ref`
  ADD PRIMARY KEY (`P_id`),
  ADD KEY `puid` (`U_id`),
  ADD KEY `poid` (`O_id`);

--
-- Indexes for table `tb_paymethod`
--
ALTER TABLE `tb_paymethod`
  ADD PRIMARY KEY (`P_id`);

--
-- Indexes for table `tb_progress`
--
ALTER TABLE `tb_progress`
  ADD PRIMARY KEY (`D_progress`);

--
-- Indexes for table `tb_rate`
--
ALTER TABLE `tb_rate`
  ADD PRIMARY KEY (`AK_name`,`AK_region`,`AK_ctgy`);

--
-- Indexes for table `tb_signature`
--
ALTER TABLE `tb_signature`
  ADD PRIMARY KEY (`S_id`),
  ADD KEY `Suid` (`U_id`);

--
-- Indexes for table `tb_supervision`
--
ALTER TABLE `tb_supervision`
  ADD PRIMARY KEY (`U_id`);

--
-- Indexes for table `tb_terms_of_payment`
--
ALTER TABLE `tb_terms_of_payment`
  ADD PRIMARY KEY (`TOP_id`);

--
-- Indexes for table `tb_update_log`
--
ALTER TABLE `tb_update_log`
  ADD PRIMARY KEY (`U_id`,`Z_state`,`Z_region`,`Z_distance`,`Z_ctgy`),
  ADD KEY `Z_region` (`Z_region`,`Z_distance`),
  ADD KEY `Z_state` (`Z_state`,`Z_ctgy`),
  ADD KEY `zonectgy` (`Z_ctgy`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`U_id`),
  ADD KEY `U_email` (`U_email`);

--
-- Indexes for table `tb_zone`
--
ALTER TABLE `tb_zone`
  ADD PRIMARY KEY (`Z_state`,`Z_region`,`Z_distance`,`CM_ctgy`),
  ADD KEY `cmctgy` (`CM_ctgy`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_adjustment`
--
ALTER TABLE `tb_adjustment`
  ADD CONSTRAINT `acid` FOREIGN KEY (`C_id`) REFERENCES `tb_customer` (`C_id`),
  ADD CONSTRAINT `auid2` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_advertisement_adjustment`
--
ALTER TABLE `tb_advertisement_adjustment`
  ADD CONSTRAINT `aaamid` FOREIGN KEY (`AM_id`) REFERENCES `tb_advertisement_material` (`AM_id`),
  ADD CONSTRAINT `aauid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_advertisement_material`
--
ALTER TABLE `tb_advertisement_material`
  ADD CONSTRAINT `amtype` FOREIGN KEY (`AM_type`) REFERENCES `tb_am_type` (`AM_type`);

--
-- Constraints for table `tb_advertisement_order`
--
ALTER TABLE `tb_advertisement_order`
  ADD CONSTRAINT `aocid` FOREIGN KEY (`C_id`) REFERENCES `tb_customer` (`C_id`),
  ADD CONSTRAINT `aopid` FOREIGN KEY (`AO_payMethod`) REFERENCES `tb_paymethod` (`P_id`),
  ADD CONSTRAINT `aostatus` FOREIGN KEY (`O_status`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `aotop` FOREIGN KEY (`O_TOP`) REFERENCES `tb_terms_of_payment` (`TOP_id`),
  ADD CONSTRAINT `dostatus` FOREIGN KEY (`AO_deliveryStatus`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `istatus` FOREIGN KEY (`AO_invoiceStatus`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `pstatus` FOREIGN KEY (`AO_paymentStatus`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `qaostatus` FOREIGN KEY (`O_quotationStatus`) REFERENCES `tb_order_status` (`O_status`);

--
-- Constraints for table `tb_advertisement_quotation`
--
ALTER TABLE `tb_advertisement_quotation`
  ADD CONSTRAINT `aqoid` FOREIGN KEY (`O_id`) REFERENCES `tb_advertisement_order` (`O_id`),
  ADD CONSTRAINT `aqstatus` FOREIGN KEY (`AQ_status`) REFERENCES `tb_order_status` (`O_status`);

--
-- Constraints for table `tb_agency_government`
--
ALTER TABLE `tb_agency_government`
  ADD CONSTRAINT `agcid` FOREIGN KEY (`C_id`) REFERENCES `tb_customer` (`C_id`);

--
-- Constraints for table `tb_ag_phone`
--
ALTER TABLE `tb_ag_phone`
  ADD CONSTRAINT `agpcid` FOREIGN KEY (`C_id`) REFERENCES `tb_customer` (`C_id`);

--
-- Constraints for table `tb_am_history`
--
ALTER TABLE `tb_am_history`
  ADD CONSTRAINT `amhamid` FOREIGN KEY (`AM_id`) REFERENCES `tb_advertisement_material` (`AM_id`),
  ADD CONSTRAINT `amhuid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_ao_material`
--
ALTER TABLE `tb_ao_material`
  ADD CONSTRAINT `aomamid` FOREIGN KEY (`AM_id`) REFERENCES `tb_advertisement_material` (`AM_id`),
  ADD CONSTRAINT `aomoid` FOREIGN KEY (`O_id`) REFERENCES `tb_advertisement_order` (`O_id`);

--
-- Constraints for table `tb_aq_generation`
--
ALTER TABLE `tb_aq_generation`
  ADD CONSTRAINT `tb_aq_generation_ibfk_1` FOREIGN KEY (`AQ_id`) REFERENCES `tb_advertisement_quotation` (`AQ_id`),
  ADD CONSTRAINT `tb_aq_generation_ibfk_3` FOREIGN KEY (`D_Progress`) REFERENCES `tb_progress` (`D_progress`),
  ADD CONSTRAINT `uaqsupervision` FOREIGN KEY (`U_id`) REFERENCES `tb_supervision` (`U_id`),
  ADD CONSTRAINT `uid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_cm_type`
--
ALTER TABLE `tb_cm_type`
  ADD CONSTRAINT `cmctgy2` FOREIGN KEY (`CM_ctgy`) REFERENCES `tb_cm_ctgy` (`CM_ctgy`);

--
-- Constraints for table `tb_construction_material`
--
ALTER TABLE `tb_construction_material`
  ADD CONSTRAINT `cmtype` FOREIGN KEY (`CM_type`) REFERENCES `tb_cm_type` (`CM_type`);

--
-- Constraints for table `tb_construction_order`
--
ALTER TABLE `tb_construction_order`
  ADD CONSTRAINT `coid` FOREIGN KEY (`C_id`) REFERENCES `tb_customer` (`C_id`),
  ADD CONSTRAINT `coqstatus` FOREIGN KEY (`O_quotationStatus`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `costatus` FOREIGN KEY (`O_status`) REFERENCES `tb_order_status` (`O_status`),
  ADD CONSTRAINT `cotop` FOREIGN KEY (`O_TOP`) REFERENCES `tb_terms_of_payment` (`TOP_id`);

--
-- Constraints for table `tb_construction_quotation`
--
ALTER TABLE `tb_construction_quotation`
  ADD CONSTRAINT `cqoid` FOREIGN KEY (`O_id`) REFERENCES `tb_construction_order` (`O_id`),
  ADD CONSTRAINT `cqstatus` FOREIGN KEY (`CQ_status`) REFERENCES `tb_order_status` (`O_status`);

--
-- Constraints for table `tb_control`
--
ALTER TABLE `tb_control`
  ADD CONSTRAINT `controlprimary` FOREIGN KEY (`CM_id`,`CM_type`,`CM_variation`) REFERENCES `tb_construction_material` (`CM_id`, `CM_type`, `CM_variation`),
  ADD CONSTRAINT `cuid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_co_material`
--
ALTER TABLE `tb_co_material`
  ADD CONSTRAINT `comcoid` FOREIGN KEY (`O_id`) REFERENCES `tb_construction_order` (`O_id`),
  ADD CONSTRAINT `comprimary` FOREIGN KEY (`CM_type`,`CM_id`,`CM_variation`) REFERENCES `tb_construction_material` (`CM_type`, `CM_id`, `CM_variation`);

--
-- Constraints for table `tb_cq_generation`
--
ALTER TABLE `tb_cq_generation`
  ADD CONSTRAINT `cqid` FOREIGN KEY (`CQ_id`) REFERENCES `tb_construction_quotation` (`CQ_id`),
  ADD CONSTRAINT `cqprogress` FOREIGN KEY (`D_Progress`) REFERENCES `tb_progress` (`D_progress`),
  ADD CONSTRAINT `cquid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`),
  ADD CONSTRAINT `cqusupervision` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD CONSTRAINT `ctype` FOREIGN KEY (`C_type`) REFERENCES `tb_customer_type` (`C_type`);

--
-- Constraints for table `tb_delivery_order`
--
ALTER TABLE `tb_delivery_order`
  ADD CONSTRAINT `doid` FOREIGN KEY (`O_id`) REFERENCES `tb_advertisement_order` (`O_id`);

--
-- Constraints for table `tb_do_generation`
--
ALTER TABLE `tb_do_generation`
  ADD CONSTRAINT `dogsupervision` FOREIGN KEY (`U_id`) REFERENCES `tb_supervision` (`U_id`),
  ADD CONSTRAINT `tb_do_generation_ibfk_1` FOREIGN KEY (`DO_id`) REFERENCES `tb_delivery_order` (`DO_id`),
  ADD CONSTRAINT `tb_do_generation_ibfk_2` FOREIGN KEY (`D_Progress`) REFERENCES `tb_progress` (`D_progress`),
  ADD CONSTRAINT `tb_do_generation_ibfk_3` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_import_log`
--
ALTER TABLE `tb_import_log`
  ADD CONSTRAINT `importname` FOREIGN KEY (`AK_name`) REFERENCES `tb_rate` (`AK_name`),
  ADD CONSTRAINT `importuid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD CONSTRAINT `doiid` FOREIGN KEY (`DO_id`) REFERENCES `tb_delivery_order` (`DO_id`),
  ADD CONSTRAINT `ioid` FOREIGN KEY (`O_id`) REFERENCES `tb_advertisement_order` (`O_id`);

--
-- Constraints for table `tb_invoice_generation`
--
ALTER TABLE `tb_invoice_generation`
  ADD CONSTRAINT `Idprogress` FOREIGN KEY (`D_progress`) REFERENCES `tb_progress` (`D_progress`),
  ADD CONSTRAINT `invoiceid` FOREIGN KEY (`I_id`) REFERENCES `tb_invoice` (`I_id`),
  ADD CONSTRAINT `tb_invoice_generation_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`),
  ADD CONSTRAINT `tb_invoice_generation_ibfk_2` FOREIGN KEY (`U_id`) REFERENCES `tb_supervision` (`U_id`);

--
-- Constraints for table `tb_order_rate`
--
ALTER TABLE `tb_order_rate`
  ADD CONSTRAINT `orcoid` FOREIGN KEY (`O_id`) REFERENCES `tb_construction_order` (`O_id`),
  ADD CONSTRAINT `orrate` FOREIGN KEY (`AK_name`,`AK_region`,`AK_ctgy`) REFERENCES `tb_rate` (`AK_name`, `AK_region`, `AK_ctgy`);

--
-- Constraints for table `tb_order_zone`
--
ALTER TABLE `tb_order_zone`
  ADD CONSTRAINT `ozcoid` FOREIGN KEY (`O_id`) REFERENCES `tb_construction_order` (`O_id`),
  ADD CONSTRAINT `ozone` FOREIGN KEY (`Z_state`,`Z_region`,`Z_distance`,`CM_ctgy`) REFERENCES `tb_zone` (`Z_state`, `Z_region`, `Z_distance`, `CM_ctgy`);

--
-- Constraints for table `tb_payment_ref`
--
ALTER TABLE `tb_payment_ref`
  ADD CONSTRAINT `proid` FOREIGN KEY (`O_id`) REFERENCES `tb_advertisement_order` (`O_id`),
  ADD CONSTRAINT `pruid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_signature`
--
ALTER TABLE `tb_signature`
  ADD CONSTRAINT `Suid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_supervision`
--
ALTER TABLE `tb_supervision`
  ADD CONSTRAINT `Suid2` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`);

--
-- Constraints for table `tb_update_log`
--
ALTER TABLE `tb_update_log`
  ADD CONSTRAINT `uluid` FOREIGN KEY (`U_id`) REFERENCES `tb_user` (`U_id`),
  ADD CONSTRAINT `updatezone` FOREIGN KEY (`Z_state`) REFERENCES `tb_zone` (`Z_state`),
  ADD CONSTRAINT `zonectgy` FOREIGN KEY (`Z_ctgy`) REFERENCES `tb_zone` (`CM_ctgy`);

--
-- Constraints for table `tb_zone`
--
ALTER TABLE `tb_zone`
  ADD CONSTRAINT `cmctgy` FOREIGN KEY (`CM_ctgy`) REFERENCES `tb_cm_ctgy` (`CM_ctgy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
