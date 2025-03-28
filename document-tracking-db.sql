-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2024 at 07:19 PM
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
-- Database: `document-tracking-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_action_taken`
--

CREATE TABLE `tbl_action_taken` (
  `id` bigint(250) NOT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `action_taken` varchar(250) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_action_taken`
--

INSERT INTO `tbl_action_taken` (`id`, `docu_id`, `action_taken`, `timestamp`) VALUES
(1, 94, 'actiontaken 1', '2024-01-25 11:54:31'),
(2, 94, 'SIGNED ASDHJASGDAS', '2024-01-25 12:02:20'),
(3, 93, 'complete na', '2024-01-25 12:08:20'),
(4, 66, 'COMPLETED NA', '2024-01-25 12:09:01'),
(5, 116, 'SIGNED ASDHJASGDAS', '2024-02-25 21:19:02'),
(6, 119, 'SIGNED ASDHJASGDAS', '2024-02-25 23:40:16'),
(7, 122, 'For appropirate action', '2024-03-05 06:15:07'),
(8, 118, 'qweqwe', '2024-03-05 06:52:18'),
(9, 124, 'SIGNED ASDHJASGDAS', '2024-03-05 06:59:35'),
(10, 127, 'qweqwe', '2024-03-05 07:05:26'),
(11, 131, 'SIGNED ASDHJASGDAS', '2024-03-06 06:27:03'),
(12, 134, 'SIGNED ASDHJASGDAS', '2024-03-06 06:40:16'),
(13, 135, 'For information/reference/file', '2024-03-06 07:36:59'),
(14, 135, 'SIGNED ASDHJASGDAS', '2024-03-06 07:37:30'),
(15, 134, 'Please see me', '2024-03-06 09:04:25'),
(16, 138, 'For comments/recommendation', '2024-03-06 09:26:59'),
(17, 138, 'Please follow-up and report action taken', '2024-03-06 09:31:03'),
(18, 138, 'For information/reference/file', '2024-03-06 09:34:58'),
(19, 138, 'For information/reference/file', '2024-03-06 09:35:28'),
(20, 143, 'For appropirate action', '2024-03-10 21:19:29'),
(21, 143, 'For initial/signature', '2024-03-10 21:21:10'),
(22, 152, 'For information/reference/file', '2024-03-10 22:19:53'),
(23, 152, 'For comments/recommendation', '2024-03-10 22:22:37'),
(24, 154, 'Please follow-up and report action taken', '2024-03-16 14:14:58'),
(25, 154, 'For appropirate action', '2024-03-16 14:15:29'),
(26, 154, 'For comments/recommendation', '2024-03-16 14:36:25'),
(27, 159, 'For appropirate action', '2024-03-16 16:42:07'),
(28, 159, 'For comments/recommendation', '2024-03-16 16:44:35'),
(29, 159, 'Please follow-up and report action taken', '2024-03-16 16:45:04'),
(30, 159, 'Please see me', '2024-03-16 16:50:24'),
(31, 159, 'For compliance', '2024-03-16 17:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins_incoming`
--

CREATE TABLE `tbl_admins_incoming` (
  `id` bigint(250) NOT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `receive_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_conversation`
--

CREATE TABLE `tbl_conversation` (
  `id` bigint(250) NOT NULL,
  `conversation_id` bigint(250) DEFAULT NULL,
  `user_id` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_conversation`
--

INSERT INTO `tbl_conversation` (`id`, `conversation_id`, `user_id`) VALUES
(7, 658, '11'),
(8, 658, '2'),
(9, 6580000, '20'),
(10, 6580000, '2'),
(11, 310002, '22'),
(12, 310002, '2'),
(13, 59346, '27'),
(14, 59346, 'recordoffice'),
(15, 87163, '41'),
(16, 87163, 'recordoffice'),
(17, 702558, '42'),
(18, 702558, 'recordoffice');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_tracking`
--

CREATE TABLE `tbl_document_tracking` (
  `id` bigint(250) NOT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `action_taken` varchar(250) DEFAULT 'pending',
  `person` varchar(250) DEFAULT NULL,
  `office` varchar(250) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_document_tracking`
--

INSERT INTO `tbl_document_tracking` (`id`, `docu_id`, `action_taken`, `person`, `office`, `timestamp`) VALUES
(349, 148, 'Document code created:  2024-03-11-0880', 'Records Office', 'ASR', '2024-03-10 21:39:14'),
(350, 149, 'Document code created:  2024-03-11-6588', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 21:42:00'),
(351, 150, 'Document code created:  2024-03-11-7245', 'Records Office', 'ASR', '2024-03-10 21:51:37'),
(352, 151, 'Document code created:  2024-03-11-8022', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 21:53:26'),
(353, 150, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 21:59:59'),
(354, 150, 'complete', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 22:00:13'),
(355, 150, 'Transaction Complete', 'asdasdasdasqzA asdasd', NULL, '2024-03-10 22:00:14'),
(356, 152, 'Document code created:  2024-03-11-1805', 'Records Office', 'ASR', '2024-03-10 22:19:10'),
(357, 152, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 22:19:38'),
(358, 152, 'For information/reference/file.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-10 22:19:53'),
(359, 152, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-10 22:20:42'),
(360, 152, 'For comments/recommendation.', 'Records Office', 'ASR', '2024-03-10 22:22:37'),
(361, 153, 'Document code created:  2024-03-16-1370', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 14:07:35'),
(362, 154, 'Document code created:  2024-03-16-8738', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 14:09:41'),
(363, 154, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-16 14:10:51'),
(364, 154, 'Please follow-up and report action taken.', 'Records Office', 'ASR', '2024-03-16 14:14:58'),
(365, 154, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 14:15:20'),
(366, 154, 'For appropirate action.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 14:15:29'),
(367, 155, 'Document code created:  2024-03-16-9559', 'Records Office', 'ASR', '2024-03-16 14:22:36'),
(368, 154, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-16 14:35:50'),
(369, 154, 'For comments/recommendation.', 'Records Office', 'ASR', '2024-03-16 14:36:25'),
(370, 157, 'Document code created:  2024-03-16-6152', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 15:07:19'),
(371, 158, 'Document code created:  2024-03-16-5959', 'Records Office', 'ASR', '2024-03-16 15:09:40'),
(372, 159, 'Document code created:  2024-03-17-9110', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 16:35:43'),
(373, 159, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-16 16:40:53'),
(374, 159, 'For appropirate action.', 'Records Office', 'ASR', '2024-03-16 16:42:07'),
(375, 159, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 16:43:23'),
(376, 159, 'For comments/recommendation.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 16:44:35'),
(377, 159, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-16 16:44:49'),
(378, 159, 'Please follow-up and report action taken.', 'Records Office', 'ASR', '2024-03-16 16:45:04'),
(379, 159, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 16:50:06'),
(380, 159, 'Please see me.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 16:50:24'),
(381, 159, 'Administrative Section Records received the document.', 'Records Office', 'ASR', '2024-03-16 17:02:19'),
(382, 159, 'For compliance.', 'Records Office', 'ASR', '2024-03-16 17:02:28'),
(383, 159, 'Office of The Regional Irrigation Manager received the document.', 'asdasdasdasqzA asdasd', 'RIM', '2024-03-16 17:02:55'),
(384, 160, 'Document code created: 2024-03-17-7033.', 'Records Office', 'ASR', '2024-03-16 17:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_type`
--

CREATE TABLE `tbl_document_type` (
  `id` bigint(250) NOT NULL,
  `document_type` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_document_type`
--

INSERT INTO `tbl_document_type` (`id`, `document_type`, `created_at`) VALUES
(74, 'Letter', '2024-01-06 04:17:14'),
(75, 'Travel Order', '2024-01-06 04:18:15'),
(76, 'Transmittal Letter', '2024-01-06 04:18:23'),
(77, 'Indorsement&nbsp; Letter', '2024-01-06 04:18:28'),
(78, 'Acknowledge Receipt for Equipment (ARE)', '2024-01-06 04:20:28'),
(79, 'Program of work', '2024-01-06 04:20:33'),
(80, 'Plans', '2024-01-06 04:20:39'),
(81, 'Fax Message', '2024-01-06 04:20:44'),
(82, 'Memorandum Circulars', '2024-01-06 04:20:50'),
(83, 'Office Memorandums', '2024-01-06 04:20:55'),
(84, 'Unnumbered Memorandums', '2024-01-06 04:21:00'),
(85, 'Physical and Financial Reports', '2024-01-06 04:21:06'),
(86, 'Financial Reports', '2024-01-06 04:21:10'),
(87, 'Report of Check/Cash Disbursement', '2024-01-06 04:21:14'),
(88, 'Report of ISF Collection', '2024-01-06 04:21:19'),
(89, 'Request for Release of Funds (Advise from EOD)', '2024-01-06 04:21:24'),
(90, 'MOA (NIA-IA)', '2024-01-06 04:21:29'),
(91, 'Certificate of Irrigation Coverage', '2024-01-06 04:21:36'),
(92, 'Field Verification Report', '2024-01-06 04:21:42'),
(93, 'Report', '2024-01-06 04:21:48'),
(94, 'ASA Received from CO', '2024-01-06 04:21:58'),
(95, 'ADA Received from CO', '2024-01-06 04:22:03'),
(96, 'Computed Equipment Rental Report', '2024-01-06 04:22:10'),
(97, 'Monthly Electric Consumption Report', '2024-01-06 04:22:15'),
(98, 'Voucher', '2024-01-06 04:22:19'),
(99, 'Purchase Request', '2024-01-06 04:22:24'),
(100, 'Invitation to Bid', '2024-01-06 04:22:29'),
(101, 'NWRB', '2024-01-06 04:22:40'),
(102, 'Budget Utilization Request', '2024-01-06 04:22:44'),
(103, 'Disbursement Voucher', '2024-01-06 04:22:50'),
(104, 'Liquidation Report', '2024-01-06 04:22:55'),
(105, 'Monthly Progress Report', '2024-01-06 04:23:00'),
(106, 'Aging of Cash Advances', '2024-01-06 04:23:04'),
(107, 'Schedule of Cash advance and Liquidation report&nbsp;', '2024-01-06 04:23:09'),
(108, 'Statutory Liabilities', '2024-01-06 04:23:13'),
(109, 'Statement of Obligation, Liquidation and Balances&nbsp;', '2024-01-06 04:23:18'),
(110, 'ASA releases to IMOs', '2024-01-06 04:23:22'),
(111, 'Statement of Balances&nbsp;', '2024-01-06 04:23:27'),
(112, 'Statement of Funds receive', '2024-01-06 04:23:31'),
(113, 'Income and Expense', '2024-01-06 04:23:36'),
(114, 'Request for Release of Funds (Terminal Leave)', '2024-01-06 04:23:57'),
(115, 'Application for Terminal Leave', '2024-01-06 04:24:03'),
(116, 'Advice of check issued', '2024-01-06 04:24:07'),
(117, 'List of Due and Demandable Accounts Payable', '2024-01-06 04:24:12'),
(118, 'Application Letter', '2024-01-06 04:24:16'),
(119, 'Regional Clearance', '2024-01-06 04:24:21'),
(120, 'Report of Farming Activities', '2024-01-06 04:24:27'),
(121, 'List of Deputized Bill Collectors', '2024-01-06 04:24:31'),
(122, 'List of Temporary Bill Collectors', '2024-01-06 04:24:35'),
(123, 'Bank Reconciliation Statement&nbsp;', '2024-01-06 04:24:40'),
(124, 'CSR and SOE', '2024-01-06 04:24:44'),
(125, 'Statement of Allotment, Obligations and Balances', '2024-01-06 04:24:48'),
(126, 'Monitoring of Monthly Report of Disbursement&nbsp;', '2024-01-06 04:24:53'),
(127, 'Payroll Register', '2024-01-06 04:24:58'),
(128, 'Authority to Debit Account (ADA)', '2024-01-06 04:25:03'),
(129, 'Cash Flow', '2024-01-06 04:25:07'),
(130, 'Financial Statement&nbsp;', '2024-01-06 04:25:12'),
(131, 'Permit', '2024-01-06 04:25:16'),
(132, 'IPCR', '2024-01-06 04:25:21'),
(133, 'Issue Custodian Slip (ICS)', '2024-01-06 04:25:25'),
(134, 'DPCR', '2024-01-06 04:25:33'),
(135, 'Annual Procurement Plan (APP)', '2024-01-06 04:25:38'),
(136, 'Abstract', '2024-01-06 04:25:44'),
(137, 'Canvass', '2024-01-06 04:25:48'),
(138, 'Fuel Slip', '2024-01-06 04:25:53'),
(139, 'Gate Pass', '2024-01-06 04:25:57'),
(140, 'Inspection and Acceptance', '2024-01-06 04:26:02'),
(142, 'TESTING', '2024-01-07 12:09:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_handler_document`
--

CREATE TABLE `tbl_handler_document` (
  `id` bigint(250) NOT NULL,
  `user_id` bigint(250) DEFAULT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT 'pending',
  `receive_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_handler_incoming`
--

CREATE TABLE `tbl_handler_incoming` (
  `id` bigint(250) NOT NULL,
  `user_id` bigint(250) DEFAULT NULL,
  `office_name` varchar(250) DEFAULT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT 'notyetreceive',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receive_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_handler_incoming`
--

INSERT INTO `tbl_handler_incoming` (`id`, `user_id`, `office_name`, `docu_id`, `status`, `updated_at`, `receive_at`) VALUES
(290, 25, 'Office of The Regional Irrigation Manager', 152, 'notyetreceive', '2024-03-10 22:22:37', '2024-03-10 22:22:37'),
(291, 28, 'Office of The Regional Irrigation Manager', 152, 'notyetreceive', '2024-03-10 22:22:37', '2024-03-10 22:22:37'),
(292, 33, 'Office of The Regional Irrigation Manager', 152, 'notyetreceive', '2024-03-10 22:22:37', '2024-03-10 22:22:37'),
(293, 30, 'Administrative Section Records', 153, 'notyetreceive', '2024-03-16 14:07:35', '2024-03-16 14:07:35'),
(294, 35, 'Administrative Section Records', 153, 'notyetreceive', '2024-03-16 14:07:35', '2024-03-16 14:07:35'),
(302, 25, 'Office of The Regional Irrigation Manager', 155, 'notyetreceive', '2024-03-16 14:22:36', '2024-03-16 14:22:36'),
(303, 28, 'Office of The Regional Irrigation Manager', 155, 'notyetreceive', '2024-03-16 14:22:36', '2024-03-16 14:22:36'),
(304, 33, 'Office of The Regional Irrigation Manager', 155, 'notyetreceive', '2024-03-16 14:22:36', '2024-03-16 14:22:36'),
(305, 25, 'Office of The Regional Irrigation Manager', 154, 'notyetreceive', '2024-03-16 14:36:25', '2024-03-16 14:36:25'),
(306, 28, 'Office of The Regional Irrigation Manager', 154, 'notyetreceive', '2024-03-16 14:36:25', '2024-03-16 14:36:25'),
(307, 33, 'Office of The Regional Irrigation Manager', 154, 'notyetreceive', '2024-03-16 14:36:25', '2024-03-16 14:36:25'),
(308, 30, 'Administrative Section Records', 157, 'notyetreceive', '2024-03-16 15:07:19', '2024-03-16 15:07:19'),
(309, 35, 'Administrative Section Records', 157, 'notyetreceive', '2024-03-16 15:07:19', '2024-03-16 15:07:19'),
(328, 30, 'Administrative Section Records', 160, 'pending', '2024-03-16 17:54:00', '2024-03-16 17:54:00'),
(329, 35, 'Administrative Section Records', 160, 'pending', '2024-03-16 17:54:00', '2024-03-16 17:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_handler_outgoing`
--

CREATE TABLE `tbl_handler_outgoing` (
  `id` bigint(250) NOT NULL,
  `office_name` varchar(250) DEFAULT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receive_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_handler_outgoing`
--

INSERT INTO `tbl_handler_outgoing` (`id`, `office_name`, `docu_id`, `updated_at`, `receive_at`) VALUES
(69, 'Administrative Section Records', 152, '2024-03-10 22:22:37', '2024-03-10 22:22:37'),
(70, 'Office of The Regional Irrigation Manager', 153, '2024-03-16 14:07:35', '2024-03-16 14:07:35'),
(74, 'Administrative Section Records', 155, '2024-03-16 14:22:36', '2024-03-16 14:22:36'),
(75, 'Administrative Section Records', 154, '2024-03-16 14:36:25', '2024-03-16 14:36:25'),
(76, 'Office of The Regional Irrigation Manager', 157, '2024-03-16 15:07:19', '2024-03-16 15:07:19'),
(77, 'Administrative Section Records', 158, '2024-03-16 15:09:40', '2024-03-16 15:09:40'),
(82, 'Office of The Regional Irrigation Manager', 159, '2024-03-16 16:50:24', '2024-03-16 16:50:24'),
(83, 'Administrative Section Records', 159, '2024-03-16 17:02:28', '2024-03-16 17:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_account`
--

CREATE TABLE `tbl_login_account` (
  `id` bigint(100) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login_account`
--

INSERT INTO `tbl_login_account` (`id`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(2, 'admin', '$2y$10$HRF94PkEYcBBhuEfdOqjF.cL.pmHJJhy/OViypTMqw0YNN.jEuKTq', 'admin', 'active', '2023-12-09 03:41:01'),
(3, 'handler', '$2y$10$cKw.BGO4TxJ4X.7bV7vTBeqnnk/FgLrKhNdu4DXhI2MM/JJSdHNSG', 'handler', 'archived', '2023-12-09 03:41:21'),
(10, 'testing', '$2y$10$9caN6BESSBuNFMghmsLPcOfLnHx8.ndZb/iFtqRgSimb34rYILtHq', 'guest', 'archived', '2023-12-11 16:12:24'),
(11, 'guestaccount', '$2y$10$vchNKlb9m5arE0DcE2Ck/OORxXqWGBXE5P2PdZggDc482TK04eFya', 'guest', 'active', '2023-12-16 02:45:42'),
(13, 'handler1', '$2y$10$MWVvILoUQd/uYzgKsog5guc3a3K.dTKgao5TwbEUmP/UAFAm9Mkea', 'handler', 'archived', '2023-12-16 03:06:00'),
(18, 'handler2', '$2y$10$QOAK5ZM0r5FTo7EyJE/JHeIp49iSWMxSoaSY8Mhmfh84awXvx.G2S', 'handler', 'archived', '2023-12-18 07:38:05'),
(19, 'angelo1', '$2y$10$mXamfGKOuC6Y/DfHHQfkMOm/XCob/2u3NE.cj6Hhb2HyE5OHbZGay', 'guest', 'archived', '2023-12-18 07:40:14'),
(20, 'testingguest', '$2y$10$IKx3ZVETyfKjvGioNM80iuxxYFN.gXmB.8xVWuqPKWekDA9Ugpsb.', 'guest', 'active', '2023-12-29 04:27:16'),
(21, 'qweqwe', '$2y$10$r3oMzehZqRtG3HKo7ypj6uW6xge2DnCYxGcP/NsxQ6zGNAtetJwM6', 'handler', 'archived', '2023-12-30 11:12:35'),
(22, 'trylangs', '$2y$10$X7NAMEP7C7De/Y0p9rjvSuKQJhliacygumnKx2URulzZ2tLzCh6Xm', 'guest', 'active', '2023-12-31 06:08:41'),
(25, 'newhandler', '$2y$10$aXIEskiPCSf4HcZb2cc7g.K2hMFiyfk1KNkc3yEA.IaTjDFYv79vm', 'handler', 'active', '2024-01-06 06:57:25'),
(27, 'newguest', '$2y$10$PjyHkL37TFwWcvfbZb5zt.UY3/yDsVoyEF8Y9sBUnoeU3LNqsUtyW', 'guest', 'active', '2024-01-06 07:00:13'),
(28, 'newhandler1', '$2y$10$R/DtmqCnuY/r7VC1wV8cRu8/uwNSB7S6BfAXOjYpyS0Afnw/MRj7i', 'handler', 'active', '2024-01-06 07:22:20'),
(29, 'newguest1', '$2y$10$fQ8OpGCSYKgqPO6PB9.Wa.lCT2sN7OhltEPxAfBsUS9SeyiMv/zoC', 'guest', 'active', '2024-01-06 07:25:14'),
(30, 'recordoffice', '$2y$10$RbZ8TJyZjdlXsxgB7ZT6Pugkv7kLZIrg34VELgn0TwU0mDE2pXV5K', 'handler', 'active', '2024-01-06 07:43:04'),
(31, 'qwe', '$2y$10$9WOqyIZhFa/2dTjmoN8TbeRHjzIdyDe8BtYCph7IFVRdex0OCXs3u', 'handler', 'active', '2024-01-07 03:00:32'),
(32, 'qwe1', '$2y$10$K/f0kwg7s.3LcH81RnQJVepo9ODvtsDnTEBoDe5RWYn.GrFI1TseG', 'handler', 'active', '2024-01-07 03:00:52'),
(33, 'rim', '$2y$10$5Qf8XqHmr.blt31WfeTKiePtadCfle0vPW55sU2Gd/bsHImrIbB4W', 'handler', 'active', '2024-01-07 08:52:09'),
(34, 'rimhealth', '$2y$10$LvUniUqeBXVZ0NCsILtsgu4SXgvxG2/YruSGfgeiebHtfNp3LELNO', 'handler', 'active', '2024-01-07 08:52:48'),
(35, 'record', '$2y$10$Pe2jjsmayyRgbqCM8HIWJuQd3P3jA6kwGPhrUie.C6w/zVuf8o6Gq', 'handler', 'active', '2024-01-20 02:26:01'),
(36, 'asdasd123', '$2y$10$7U/T6iFp6tylhy5VRSMn9OZ/D1LSE8eVHi0WQTlbM22Yo3u/bDuAS', 'guest', 'active', '2024-02-17 15:24:51'),
(37, 'guestaccount1', '$2y$10$lkGZw8Z9TKPh0/EO8NVUtuG9BGj25m4SXpMw9MFedzDP9.zmJlDT6', 'guest', 'active', '2024-02-27 01:31:49'),
(38, 'guest123', '$2y$10$ikbh.FEWxI0xzt6VWdJrtOU/Ev4egjN6vt/vAmVCEdwXU0kpsOqgq', 'guest', 'decline', '2024-03-05 05:04:07'),
(39, 'asdasdsadasdwqe', '$2y$10$BSjr54lVss6QWVxK/tqYTuqVtg9c9n2WIHW0rdBZh63CaMFGSMRUq', 'guest', 'pending', '2024-03-05 05:12:30'),
(40, 'asdqweqwe', '$2y$10$.wRv0ehs.bzIp7t9B2O3zeKjaDZ7nd6eEFdutSHR5.klu5OYD0rfy', 'guest', 'active', '2024-03-05 05:13:42'),
(41, 'newguest123', '$2y$10$zlFvHHMCSelEIVfeMpuoFeJuj.lyngUgQz3UJJHSwOkqoCDKXCHfa', 'guest', 'active', '2024-03-05 07:55:15'),
(42, '0123123', '$2y$10$B7yRWnz9MkQRhQTXQVOIHOWRP1rPQlqv8FEjWPgbbs60S8n0cf//y', 'guest', 'active', '2024-03-10 22:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id` bigint(250) NOT NULL,
  `conversation_id` bigint(250) DEFAULT NULL,
  `user_id` varchar(250) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(250) DEFAULT 'unread',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `conversation_id`, `user_id`, `message`, `status`, `timestamp`) VALUES
(153, 658, '2', 'TESTING ADMIN SEND MESSAGE', 'read', '2023-12-28 10:44:11'),
(154, 658, '11', 'TESTING GUEST SEND MESSAGE', 'read', '2023-12-28 10:44:23'),
(155, 658, '11', 'TESTINGGG', 'read', '2023-12-28 10:44:35'),
(156, 6580000, '20', 'GUEST 2', 'unread', '2023-12-29 04:27:41'),
(157, 6580000, '2', 'asdasdsad', 'unread', '2023-12-29 04:28:01'),
(158, 6580000, '2', 'zxczxc', 'unread', '2023-12-30 09:06:20'),
(159, 658, '2', '123', 'read', '2023-12-30 09:06:25'),
(160, 310002, '22', 'TESTING', 'unread', '2023-12-31 06:09:49'),
(161, 310002, '2', 'qweasd', 'unread', '2023-12-31 06:10:01'),
(162, 59346, '27', 'Testing message\r\n', 'unread', '2024-01-07 09:13:47'),
(163, 59346, 'recordoffice', 'qwe', 'unread', '2024-01-07 09:14:42'),
(164, 59346, '27', 'Hi', 'unread', '2024-01-07 10:42:17'),
(165, 59346, 'recordoffice', 'Hello', 'unread', '2024-01-07 10:42:23'),
(166, 59346, '27', 'TESTING MESSAGE', 'unread', '2024-01-07 10:42:39'),
(167, 59346, 'recordoffice', 'zxcasd', 'unread', '2024-01-25 11:34:29'),
(168, 59346, 'recordoffice', 'asdqwe23', 'unread', '2024-01-30 06:54:52'),
(169, 658, '11', '123', 'read', '2024-01-30 06:55:28'),
(170, 87163, '41', 'asdasd', 'unread', '2024-03-05 07:57:40'),
(171, 702558, '42', 'asdqweqwe', 'unread', '2024-03-10 22:30:23'),
(172, 702558, '42', 'asdasd', 'unread', '2024-03-10 22:30:25'),
(173, 702558, '42', '213123', 'unread', '2024-03-10 22:30:27'),
(174, 87163, 'recordoffice', 'asd', 'unread', '2024-03-16 00:54:06'),
(175, 87163, 'recordoffice', 'asdasd', 'unread', '2024-03-16 00:56:43'),
(176, 658, '11', 'asdasd', 'unread', '2024-03-16 17:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` bigint(250) NOT NULL,
  `user_id` bigint(250) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'unread',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `user_id`, `content`, `status`, `timestamp`) VALUES
(41, 21, 'New document sent to you with document code: 2024-01-06-8843', 'unread', '2024-01-06 11:39:14'),
(42, 25, 'New document sent to you with document code: 2024-01-06-0656', 'unread', '2024-01-06 12:14:23'),
(43, 25, 'New document sent to you with document code: 2024-01-06-0709', 'unread', '2024-01-06 12:16:07'),
(44, 13, 'New document sent to you with document code: 2024-01-06-9429', 'unread', '2024-01-06 12:24:15'),
(45, 25, 'New document sent to you with document code: 2024-01-06-2703', 'unread', '2024-01-06 12:26:50'),
(46, 25, 'New document sent to you with document code: 2024-01-06-1728', 'unread', '2024-01-06 12:27:51'),
(47, 25, 'New document sent to you with document code: 2024-01-06-4078', 'unread', '2024-01-06 12:40:08'),
(56, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3154. Transferred by Records Office.', 'unread', '2024-01-07 02:51:47'),
(57, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3154. Transferred by Records Office.', 'unread', '2024-01-07 02:51:51'),
(58, 27, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-07-3154. Transferred by Records Office.', 'unread', '2024-01-07 02:51:55'),
(59, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3552. Transferred by Records Office.', 'unread', '2024-01-07 02:58:35'),
(60, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3552. Transferred by Records Office.', 'unread', '2024-01-07 02:58:39'),
(61, 27, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-07-3552. Transferred by Records Office.', 'unread', '2024-01-07 02:58:43'),
(62, 27, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 03:52:16'),
(63, 32, 'We are transferring a new document with Document Tracking Code: 2024-01-07-8055. Transferred by Records Office.', 'unread', '2024-01-07 03:59:10'),
(64, 27, 'Transferred to Office of the Regional Manager - IT with Document Tracking Code: 2024-01-07-8055. Transferred by Records Office.', 'unread', '2024-01-07 03:59:17'),
(65, 27, 'Office of the Regional Manager - IT received your document. Received by qw qwe.', 'unread', '2024-01-07 03:59:52'),
(70, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7630. Transferred by Records Office.', 'unread', '2024-01-07 04:13:20'),
(71, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7630. Transferred by Records Office.', 'unread', '2024-01-07 04:13:25'),
(72, 32, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 04:16:03'),
(73, 27, 'Office of the Regional Manager - IT @#!@#SADADXCSAD. Completed by qw qwe.', 'unread', '2024-01-07 05:03:21'),
(74, 27, 'Office of The Regional Irrigation Manager ACTIONSDASD. Completed by New Document Handler.', 'unread', '2024-01-07 05:12:03'),
(75, 32, NULL, 'unread', '2024-01-07 07:08:39'),
(76, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7630. Transferred by New Document Handler.', 'unread', '2024-01-07 07:08:39'),
(77, 32, 'Office of the Regional Manager - Health Services received your document. Received by qwe qwe.', 'unread', '2024-01-07 07:11:15'),
(81, 32, 'SIGNED ASDHJASGDAS. Transferred to Office of The Regional Irrigation Manager. Transferred by qwe qwe.', 'unread', '2024-01-07 07:13:02'),
(82, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7630. Transferred by qwe qwe.', 'unread', '2024-01-07 07:13:06'),
(83, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7630. Transferred by qwe qwe.', 'unread', '2024-01-07 07:13:09'),
(84, 32, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 07:13:45'),
(85, 32, 'Office of The Regional Irrigation Manager 123123123. Completed by New Document Handler.', 'unread', '2024-01-07 07:13:57'),
(86, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-4955. Transferred by Records Office.', 'unread', '2024-01-07 07:15:31'),
(87, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-4955. Transferred by Records Office.', 'unread', '2024-01-07 07:15:34'),
(88, 32, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3911. Transferred by Records Office.', 'unread', '2024-01-07 07:17:30'),
(89, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-5755. Transferred by Records Office.', 'unread', '2024-01-07 07:20:13'),
(90, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-5755. Transferred by Records Office.', 'unread', '2024-01-07 07:20:16'),
(91, 27, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-07-5755. Transferred by Records Office.', 'unread', '2024-01-07 07:20:20'),
(92, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7157. Transferred by Records Office.', 'unread', '2024-01-07 07:47:10'),
(93, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7157. Transferred by Records Office.', 'unread', '2024-01-07 07:47:15'),
(94, 27, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-07-7157. Transferred by Records Office.', 'unread', '2024-01-07 07:47:19'),
(95, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3956. Transferred by Records Office.', 'unread', '2024-01-07 08:54:05'),
(96, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3956. Transferred by Records Office.', 'unread', '2024-01-07 08:54:09'),
(97, 27, 'Transferred to Office of the Regional Manager - Health Services with Document Tracking Code: 2024-01-07-3956. Transferred by Records Office.', 'unread', '2024-01-07 08:54:13'),
(98, 27, 'Office of the Regional Manager - Health Services received your document. Received by asd asdasd.', 'unread', '2024-01-07 08:55:21'),
(99, 27, 'ASDWQEWEXZXasd. Transferred to Office of The Regional Irrigation Manager. Transferred by asd asdasd.', 'unread', '2024-01-07 08:55:54'),
(100, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3956. Transferred by asd asdasd.', 'unread', '2024-01-07 08:55:57'),
(101, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3956. Transferred by asd asdasd.', 'unread', '2024-01-07 08:56:01'),
(102, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-3956. Transferred by asd asdasd.', 'read', '2024-01-30 04:09:17'),
(103, 27, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 08:56:35'),
(104, 27, 'Office of The Regional Irrigation Manager ASGDHGASJHDGHJASD. Completed by New Document Handler.', 'unread', '2024-01-07 08:56:49'),
(105, 27, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 10:17:24'),
(106, 27, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 10:18:59'),
(107, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-8956. Transferred by Records Office.', 'unread', '2024-01-07 12:12:48'),
(108, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-8956. Transferred by Records Office.', 'unread', '2024-01-07 12:12:53'),
(109, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-8956. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(110, NULL, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 12:15:12'),
(111, 31, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 12:15:26'),
(112, NULL, 'Office of The Regional Irrigation Manager TSADASWQEQWE. Completed by New Document Handler.', 'unread', '2024-01-07 12:15:53'),
(113, NULL, 'Office of The Regional Irrigation Manager aSADASDAS. Completed by New Document Handler.', 'unread', '2024-01-07 12:16:18'),
(114, 27, 'Office of The Regional Irrigation Manager SADASDASDASD. Completed by New Document Handler.', 'unread', '2024-01-07 12:20:37'),
(115, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0188. Transferred by Records Office.', 'unread', '2024-01-07 12:22:57'),
(116, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0188. Transferred by Records Office.', 'unread', '2024-01-07 12:23:01'),
(117, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0188. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(118, 27, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-07-0188. Transferred by Records Office.', 'unread', '2024-01-07 12:23:09'),
(119, 27, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 12:24:09'),
(120, 27, 'SIGNED ASDHJASGDAS. Transferred to Office of the Regional Manager - IT. Transferred by New Document Handler.', 'unread', '2024-01-07 12:24:55'),
(121, 32, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0188. Transferred by New Document Handler.', 'unread', '2024-01-07 12:24:59'),
(122, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-1430. Transferred by Records Office.', 'unread', '2024-01-07 12:29:08'),
(123, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-1430. Transferred by Records Office.', 'unread', '2024-01-07 12:29:12'),
(124, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-1430. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(125, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0399. Transferred by Records Office.', 'unread', '2024-01-07 12:29:58'),
(126, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0399. Transferred by Records Office.', 'unread', '2024-01-07 12:30:02'),
(127, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-0399. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(128, NULL, 'Office of The Regional Irrigation Manager received your document. Received by New Document Handler.', 'unread', '2024-01-07 12:31:05'),
(129, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-6606. Transferred by Records Office.', 'unread', '2024-01-07 12:32:27'),
(130, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-6606. Transferred by Records Office.', 'unread', '2024-01-07 12:32:33'),
(131, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2780. Transferred by Records Office.', 'unread', '2024-01-07 12:33:05'),
(132, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2780. Transferred by Records Office.', 'unread', '2024-01-07 12:33:09'),
(133, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2780. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(134, NULL, 'Office of The Regional Irrigation Manager asdasdasd. Completed by New Document Handler.', 'unread', '2024-01-07 12:34:02'),
(135, NULL, 'SIGNED ASDHJASGDAS. Transferred to Office of the Regional Manager - Health Services. Transferred by New Document Handler.', 'unread', '2024-01-07 12:34:37'),
(136, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2780. Transferred by New Document Handler.', 'unread', '2024-01-07 12:34:37'),
(137, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2780. Transferred by New Document Handler.', 'unread', '2024-01-07 12:34:42'),
(138, 27, 'SIGNED ASDHJASGDAS. Transferred to Office of the Regional Manager - Health Services. Transferred by New Document Handler.', 'unread', '2024-01-07 12:35:46'),
(139, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-5755. Transferred by New Document Handler.', 'unread', '2024-01-07 12:35:50'),
(140, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-5755. Transferred by New Document Handler.', 'unread', '2024-01-07 12:36:15'),
(141, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by Records Office.', 'unread', '2024-01-07 12:36:57'),
(142, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by Records Office.', 'unread', '2024-01-07 12:37:01'),
(143, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(144, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2077. Transferred by Records Office.', 'unread', '2024-01-07 12:37:32'),
(145, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2077. Transferred by Records Office.', 'unread', '2024-01-07 12:37:37'),
(146, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2077. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(147, 25, 'We are sending a new document with Document Tracking Code: 2024-01-20-1507. Send by record record.', 'unread', '2024-01-20 02:53:26'),
(148, 28, 'We are sending a new document with Document Tracking Code: 2024-01-20-1507. Send by record record.', 'unread', '2024-01-20 02:53:26'),
(149, 33, 'We are sending a new document with Document Tracking Code: 2024-01-20-1507. Send by record record.', 'read', '2024-01-30 04:09:17'),
(150, 25, 'We are sending a new document with Document Tracking Code: 2024-01-20-3675. Send by record record.', 'unread', '2024-01-20 02:58:29'),
(151, 28, 'We are sending a new document with Document Tracking Code: 2024-01-20-3675. Send by record record.', 'unread', '2024-01-20 02:58:29'),
(152, 33, 'We are sending a new document with Document Tracking Code: 2024-01-20-3675. Send by record record.', 'read', '2024-01-30 04:09:17'),
(153, 25, 'We are sending a new document with Document Tracking Code: 2024-01-20-0454. Send by record record.', 'unread', '2024-01-20 02:59:36'),
(154, 28, 'We are sending a new document with Document Tracking Code: 2024-01-20-0454. Send by record record.', 'unread', '2024-01-20 02:59:36'),
(155, 33, 'We are sending a new document with Document Tracking Code: 2024-01-20-0454. Send by record record.', 'read', '2024-01-30 04:09:17'),
(156, 28, 'Office of The Regional Irrigation Manager received your document. Received by asdasdasd asdasd.', 'unread', '2024-01-20 03:41:48'),
(157, 28, 'asdqweqwe. Transferred to Office of the Regional Manager - Health Services.', 'unread', '2024-01-20 10:22:38'),
(158, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:22:42'),
(159, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:22:45'),
(160, 28, 'asdqweqwe. Transferred to Office of the Regional Manager - Health Services.', 'unread', '2024-01-20 10:22:49'),
(161, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:22:53'),
(162, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:22:56'),
(163, 28, '123123. Transferred to Office of the Regional Manager - Health Services.', 'unread', '2024-01-20 10:24:20'),
(164, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:24:24'),
(165, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-20-3675. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:24:27'),
(166, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:01'),
(167, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:01'),
(168, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2077. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:24'),
(169, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-2077. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:24'),
(170, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:34'),
(171, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by asdasdasd asdasd.', 'unread', '2024-01-20 10:25:34'),
(172, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by asd asdasd.', 'unread', '2024-01-20 10:27:00'),
(173, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by asd asdasd.', 'unread', '2024-01-20 10:27:00'),
(174, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-07-7127. Transferred by asd asdasd.', 'read', '2024-01-30 04:09:17'),
(175, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-22-7690. Transferred by Records Office.', 'unread', '2024-01-22 00:46:23'),
(176, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-22-7690. Transferred by Records Office.', 'unread', '2024-01-22 00:46:23'),
(177, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-22-7690. Transferred by Records Office.', 'read', '2024-01-30 04:09:17'),
(178, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-22-7690. Transferred by Records Office.', 'read', '2024-01-30 04:27:17'),
(179, 11, 'Office of The Regional Irrigation Manager received your document. Received by asdasdasd asdasd.', 'read', '2024-01-30 04:27:17'),
(180, 11, 'qweqwe.', 'read', '2024-01-30 04:27:17'),
(181, 32, 'We are transferring a new document with Document Tracking Code: 2024-01-22-7690. Transferred by asdasdasd asdasd.', 'unread', '2024-01-22 01:12:59'),
(182, 31, 'Transaction completed. Mark this by: asdasdasd asdasd - RIM', 'unread', '2024-01-23 09:24:02'),
(183, 25, 'Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-01-24 11:10:15'),
(184, 25, 'Transaction completed. Mark this by: asdasdasdasqzA asdasd - RIM', 'unread', '2024-01-24 11:11:18'),
(185, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asd asdasd.', 'unread', '2024-01-25 11:54:31'),
(186, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asd asdasd.', 'unread', '2024-01-25 11:54:31'),
(187, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asd asdasd.', 'read', '2024-01-30 04:16:03'),
(188, 31, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-01-25 12:02:20'),
(189, 34, 'We are transferring a new document with Document Tracking Code: 2024-01-20-0454. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-01-25 12:02:20'),
(190, 28, 'Office of the Regional Manager - Health Services received your document. Received by asd asdasd.', 'unread', '2024-01-25 12:06:45'),
(191, 28, 'Transaction completed. Mark this by: asd asdasd', 'unread', '2024-01-25 12:08:20'),
(192, 27, 'Office of the Regional Manager - Health Services received your document. Received by asd asdasd.', 'unread', '2024-01-25 12:08:46'),
(193, 27, 'Transaction completed. Mark this by: asd asdasd', 'unread', '2024-01-25 12:09:01'),
(194, 30, 'Guest Guest uploaded new document.', 'read', '2024-01-30 05:09:32'),
(195, 35, 'Guest Guest uploaded new document.', 'unread', '2024-01-30 04:40:49'),
(196, 30, 'Guest Guest uploaded new document.', 'read', '2024-01-30 05:09:32'),
(197, 35, 'Guest Guest uploaded new document.', 'unread', '2024-01-30 04:42:13'),
(198, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-30-1548. Transferred by Records Office.', 'unread', '2024-01-30 05:23:38'),
(199, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-30-1548. Transferred by Records Office.', 'unread', '2024-01-30 05:23:38'),
(200, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-30-1548. Transferred by Records Office.', 'read', '2024-01-30 08:01:10'),
(201, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-30-1548. Transferred by Records Office.', 'read', '2024-01-30 05:25:25'),
(202, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 06:24:25'),
(203, 35, 'Guest Guest uploaded new document.', 'unread', '2024-01-30 06:39:42'),
(204, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-02-25 17:59:29'),
(205, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-02-25 06:24:25'),
(206, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-01-30 08:00:12'),
(207, 25, 'We are sending a new document with Document Tracking Code: 2024-01-30-1177. Send by Records Office.', 'unread', '2024-01-30 08:38:51'),
(208, 28, 'We are sending a new document with Document Tracking Code: 2024-01-30-1177. Send by Records Office.', 'unread', '2024-01-30 08:38:51'),
(209, 33, 'We are sending a new document with Document Tracking Code: 2024-01-30-1177. Send by Records Office.', 'read', '2024-02-24 19:51:33'),
(210, 25, 'We are transferring a new document with Document Tracking Code: 2024-01-30-7641. Transferred by Records Office.', 'unread', '2024-01-30 08:40:41'),
(211, 28, 'We are transferring a new document with Document Tracking Code: 2024-01-30-7641. Transferred by Records Office.', 'unread', '2024-01-30 08:40:41'),
(212, 33, 'We are transferring a new document with Document Tracking Code: 2024-01-30-7641. Transferred by Records Office.', 'read', '2024-02-24 19:51:33'),
(213, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-01-30-7641. Transferred by Records Office.', 'read', '2024-02-25 17:59:29'),
(214, 25, 'We are sending a new document with Document Tracking Code: 2024-01-30-2554. Send by Records Office.', 'unread', '2024-01-30 08:41:00'),
(215, 28, 'We are sending a new document with Document Tracking Code: 2024-01-30-2554. Send by Records Office.', 'unread', '2024-01-30 08:41:00'),
(216, 33, 'We are sending a new document with Document Tracking Code: 2024-01-30-2554. Send by Records Office.', 'read', '2024-02-24 19:51:33'),
(217, 25, 'We are sending a new document with Document Tracking Code: 2024-01-30-4266. Send by Records Office.', 'unread', '2024-01-30 08:41:34'),
(218, 28, 'We are sending a new document with Document Tracking Code: 2024-01-30-4266. Send by Records Office.', 'unread', '2024-01-30 08:41:34'),
(219, 33, 'We are sending a new document with Document Tracking Code: 2024-01-30-4266. Send by Records Office.', 'read', '2024-02-24 19:51:33'),
(220, 28, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-01-30 08:46:11'),
(221, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-02-25 06:24:25'),
(222, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-01-30 08:46:11'),
(223, 25, 'We are sending a new document with Document Tracking Code: 2024-02-19-9112. Send by Records Office.', 'unread', '2024-02-18 17:07:31'),
(224, 28, 'We are sending a new document with Document Tracking Code: 2024-02-19-9112. Send by Records Office.', 'unread', '2024-02-18 17:07:31'),
(225, 33, 'We are sending a new document with Document Tracking Code: 2024-02-19-9112. Send by Records Office.', 'read', '2024-02-24 19:51:33'),
(226, 25, 'We are sending a new document with Document Tracking Code: 2024-02-19-3595. Send by Records Office.', 'unread', '2024-02-18 17:08:13'),
(227, 28, 'We are sending a new document with Document Tracking Code: 2024-02-19-3595. Send by Records Office.', 'unread', '2024-02-18 17:08:13'),
(228, 33, 'We are sending a new document with Document Tracking Code: 2024-02-19-3595. Send by Records Office.', 'read', '2024-02-24 19:51:33'),
(229, 31, 'We are sending a new document with Document Tracking Code: 2024-02-19-9732. Send by Records Office.', 'unread', '2024-02-18 17:09:52'),
(230, 34, 'We are sending a new document with Document Tracking Code: 2024-02-19-9732. Send by Records Office.', 'unread', '2024-02-18 17:09:52'),
(231, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 06:24:25'),
(232, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-18 17:11:22'),
(233, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-19-7323. Transferred by Records Office.', 'unread', '2024-02-18 17:34:10'),
(234, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-19-7323. Transferred by Records Office.', 'unread', '2024-02-18 17:34:10'),
(235, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-19-7323. Transferred by Records Office.', 'read', '2024-02-24 19:51:33'),
(236, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-19-7323. Transferred by Records Office.', 'read', '2024-02-25 17:59:29'),
(237, 11, 'Office of The Regional Irrigation Manager scanned your document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 17:59:29'),
(238, 30, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 06:24:25'),
(239, 35, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-02-18 18:43:58'),
(240, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 06:24:25'),
(241, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-20 10:24:54'),
(242, 11, 'Your document has been decline.', 'read', '2024-02-25 17:59:29'),
(243, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 06:24:25'),
(244, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 06:22:17'),
(245, 11, 'Your document has been decline.', 'read', '2024-02-25 17:59:29'),
(246, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 16:56:49'),
(247, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 07:20:38'),
(248, 30, 'asdasdasdasqzA asdasd uploaded new document.', 'read', '2024-02-25 20:35:08'),
(249, 35, 'asdasdasdasqzA asdasd uploaded new document.', 'unread', '2024-02-25 17:06:43'),
(250, 30, 'asdasdasdasqzA asdasd uploaded new document.', 'read', '2024-02-25 20:35:08'),
(251, 35, 'asdasdasdasqzA asdasd uploaded new document.', 'unread', '2024-02-25 17:08:48'),
(252, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 20:35:08'),
(253, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 17:59:26'),
(254, 33, 'Your document has been decline.', 'read', '2024-02-25 18:57:10'),
(255, 30, 'asdasdasdasqzA asdasd uploaded new document.', 'read', '2024-02-25 20:35:08'),
(256, 35, 'asdasdasdasqzA asdasd uploaded new document.', 'unread', '2024-02-25 18:27:41'),
(257, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 20:35:08'),
(258, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 18:28:11'),
(259, 33, 'Your document has been decline.', 'read', '2024-02-25 18:57:10'),
(260, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7866. Transferred by Records Office.', 'unread', '2024-02-25 18:58:14'),
(261, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7866. Transferred by Records Office.', 'unread', '2024-02-25 18:58:14'),
(262, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7866. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(263, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-26-7866. Transferred by Records Office.', 'read', '2024-02-25 22:58:11'),
(264, 11, 'Office of The Regional Irrigation Manager scanned your document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 22:58:11'),
(265, 30, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 20:35:08'),
(266, 35, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-02-25 19:27:11'),
(267, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-02-25 22:58:11'),
(268, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-02-25 20:35:08'),
(269, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-02-25 19:27:32'),
(270, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-26-0397. Transferred by Records Office.', 'unread', '2024-02-25 19:28:34'),
(271, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-26-0397. Transferred by Records Office.', 'unread', '2024-02-25 19:28:34'),
(272, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-26-0397. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(273, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-26-0397. Transferred by Records Office.', 'read', '2024-02-25 22:58:11'),
(274, 11, 'Your document has been decline.', 'read', '2024-02-25 22:58:11'),
(275, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 20:35:08'),
(276, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 19:46:21'),
(277, 11, 'Your document has been decline.', 'read', '2024-02-25 22:58:11'),
(278, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 20:35:08'),
(279, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 19:47:53'),
(280, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-26-4213. Transferred by Records Office.', 'unread', '2024-02-25 19:48:16'),
(281, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-26-4213. Transferred by Records Office.', 'unread', '2024-02-25 19:48:16'),
(282, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-26-4213. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(283, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-26-4213. Transferred by Records Office.', 'read', '2024-02-25 22:58:11'),
(284, 11, 'Your document has been decline.', 'read', '2024-02-25 22:58:11'),
(285, 11, 'Transaction completed. Mark this by: asdasdasdasqzA asdasd', 'read', '2024-02-25 22:58:11'),
(286, 31, 'We are transferring a new document with Document Tracking Code: 2024-02-26-3826. Transferred by Records Office.', 'unread', '2024-02-25 20:27:26'),
(287, 34, 'We are transferring a new document with Document Tracking Code: 2024-02-26-3826. Transferred by Records Office.', 'unread', '2024-02-25 20:27:26'),
(288, 33, 'Transferred to Office of the Regional Manager - Health Services with Document Tracking Code: 2024-02-26-3826. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(289, 30, 'Guest Guest uploaded new document.', 'read', '2024-02-25 21:35:21'),
(290, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 21:10:34'),
(291, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6906. Transferred by Records Office.', 'unread', '2024-02-25 21:10:52'),
(292, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6906. Transferred by Records Office.', 'unread', '2024-02-25 21:10:52'),
(293, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6906. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(294, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-26-6906. Transferred by Records Office.', 'read', '2024-02-25 22:58:11'),
(295, 11, 'Office of The Regional Irrigation Manager scanned your document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 22:58:11'),
(296, 30, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-02-25 21:35:21'),
(297, 35, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-02-25 21:15:17'),
(298, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-02-25 22:58:11'),
(299, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-02-25 21:35:21'),
(300, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-02-25 21:15:33'),
(301, 11, 'SIGNED ASDHJASGDAS.', 'read', '2024-02-25 22:58:11'),
(302, 30, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6906. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-02-25 21:35:21'),
(303, 35, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6906. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-02-25 21:19:02'),
(304, 11, 'Administrative Section Records scanned your document. Scanned by Records Office.', 'read', '2024-02-25 22:58:11'),
(305, 30, 'Administrative Section Records scanned the document. Scanned by Records Office.', 'read', '2024-02-25 21:35:21'),
(306, 35, 'Administrative Section Records scanned the document. Scanned by Records Office.', 'unread', '2024-02-25 21:19:43'),
(307, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-02-25 22:58:11'),
(308, 30, 'Administrative Section Records received the document.', 'read', '2024-02-25 21:35:21'),
(309, 35, 'Administrative Section Records received the document.', 'unread', '2024-02-25 21:30:55'),
(310, 11, 'Transaction completed. Mark this by: Records Office', 'read', '2024-02-25 22:58:11'),
(311, 30, 'asdasdasdasqzA asdasd uploaded new document.', 'read', '2024-03-05 05:41:56'),
(312, 35, 'asdasdasdasqzA asdasd uploaded new document.', 'unread', '2024-02-25 22:17:55'),
(313, 31, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6720. Transferred by Records Office.', 'unread', '2024-02-25 22:52:57'),
(314, 34, 'We are transferring a new document with Document Tracking Code: 2024-02-26-6720. Transferred by Records Office.', 'unread', '2024-02-25 22:52:57'),
(315, 33, 'Transferred to Office of the Regional Manager - Health Services with Document Tracking Code: 2024-02-26-6720. Transferred by Records Office.', 'read', '2024-02-25 23:01:43'),
(316, 25, 'We are sending a new document with Document Tracking Code: 2024-02-26-4163. Send by Records Office.', 'unread', '2024-02-25 22:56:36'),
(317, 28, 'We are sending a new document with Document Tracking Code: 2024-02-26-4163. Send by Records Office.', 'unread', '2024-02-25 22:56:36'),
(318, 33, 'We are sending a new document with Document Tracking Code: 2024-02-26-4163. Send by Records Office.', 'read', '2024-02-25 23:01:43'),
(319, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-05 05:41:56'),
(320, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 22:57:10'),
(321, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-05 05:41:56'),
(322, 35, 'Guest Guest uploaded new document.', 'unread', '2024-02-25 22:58:06'),
(323, 30, 'asdasdasdasqzA asdasd uploaded new document.', 'read', '2024-03-05 05:41:56'),
(324, 35, 'asdasdasdasqzA asdasd uploaded new document.', 'unread', '2024-02-25 23:00:38'),
(325, 25, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7130. Transferred by Records Office.', 'unread', '2024-02-25 23:35:44'),
(326, 28, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7130. Transferred by Records Office.', 'unread', '2024-02-25 23:35:44'),
(327, 33, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7130. Transferred by Records Office.', 'read', '2024-02-25 23:36:09'),
(328, 11, 'Transferred to Office of The Regional Irrigation Manager with Document Tracking Code: 2024-02-26-7130. Transferred by Records Office.', 'read', '2024-03-10 20:24:20'),
(329, 11, 'Office of The Regional Irrigation Manager scanned your document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(330, 30, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-03-05 05:41:56'),
(331, 35, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-02-25 23:36:20'),
(332, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(333, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 05:41:56'),
(334, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-02-25 23:40:04'),
(335, 11, 'SIGNED ASDHJASGDAS.', 'read', '2024-03-10 20:24:20'),
(336, 30, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7130. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-05 05:41:56'),
(337, 35, 'We are transferring a new document with Document Tracking Code: 2024-02-26-7130. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-02-25 23:40:16'),
(338, 11, 'Administrative Section Records scanned your document. Scanned by Records Office.', 'read', '2024-03-10 20:24:20'),
(339, 30, 'Administrative Section Records scanned the document. Scanned by Records Office.', 'read', '2024-03-05 05:41:56'),
(340, 35, 'Administrative Section Records scanned the document. Scanned by Records Office.', 'unread', '2024-02-25 23:40:52'),
(341, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(342, 30, 'Administrative Section Records received the document.', 'read', '2024-03-05 05:41:56'),
(343, 35, 'Administrative Section Records received the document.', 'unread', '2024-02-25 23:40:58'),
(344, 2, 'New user registered.', 'read', '2024-03-05 05:15:29'),
(345, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(346, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-05 07:10:25'),
(347, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-05 06:09:38'),
(348, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(349, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(350, 30, 'Administrative Section Records received the document.', 'read', '2024-03-05 07:10:25'),
(351, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-05 06:11:35'),
(352, 11, 'For appropirate action.', 'read', '2024-03-10 20:24:20'),
(353, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-05-5919. Transferred by Records Office.', 'unread', '2024-03-05 06:15:07'),
(354, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-05-5919. Transferred by Records Office.', 'unread', '2024-03-05 06:15:07'),
(355, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-05-5919. Transferred by Records Office.', 'read', '2024-03-06 09:47:01'),
(356, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(357, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(358, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 06:28:12'),
(359, 25, 'Office of The Regional Irrigation Manager scanned your document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:31:16'),
(360, 30, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(361, 35, 'Office of The Regional Irrigation Manager scanned the document. Scanned by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:31:16'),
(362, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(363, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(364, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 06:34:13'),
(365, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(366, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(367, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 06:42:20'),
(368, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-3750. Send by Records Office.', 'unread', '2024-03-05 06:43:10'),
(369, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-3750. Send by Records Office.', 'unread', '2024-03-05 06:43:10'),
(370, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-3750. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(371, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(372, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:43:29'),
(373, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-5535. Send by Records Office.', 'unread', '2024-03-05 06:44:19'),
(374, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-5535. Send by Records Office.', 'unread', '2024-03-05 06:44:19'),
(375, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-5535. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(376, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(377, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:44:49'),
(378, 25, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:51:52'),
(379, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(380, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 06:51:52'),
(381, 25, 'qweqwe.', 'unread', '2024-03-05 06:52:18'),
(382, 30, 'We are transferring a new document with Document Tracking Code: 2024-02-26-4163. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(383, 35, 'We are transferring a new document with Document Tracking Code: 2024-02-26-4163. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:52:18'),
(384, 25, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'unread', '2024-03-05 06:57:19'),
(385, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-05 07:10:25'),
(386, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-05 06:57:19'),
(387, 25, 'The Administrative Section Records received your document. Received by Records Office.', 'unread', '2024-03-05 06:57:52'),
(388, 30, 'Administrative Section Records received the document.', 'read', '2024-03-05 07:10:25'),
(389, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-05 06:57:52'),
(390, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(391, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 06:59:25'),
(392, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-05-5535. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(393, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-05-5535. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 06:59:35'),
(394, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-2836. Send by Records Office.', 'unread', '2024-03-05 07:01:10'),
(395, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-2836. Send by Records Office.', 'unread', '2024-03-05 07:01:10'),
(396, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-2836. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(397, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-0886. Send by Records Office.', 'unread', '2024-03-05 07:03:54'),
(398, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-0886. Send by Records Office.', 'unread', '2024-03-05 07:03:54'),
(399, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-0886. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(400, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-3041. Send by Records Office.', 'unread', '2024-03-05 07:04:44'),
(401, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-3041. Send by Records Office.', 'unread', '2024-03-05 07:04:44'),
(402, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-3041. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(403, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(404, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 07:05:08'),
(405, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-05 07:10:25'),
(406, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-05 07:05:16'),
(407, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-05-3041. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:10:25'),
(408, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-05-3041. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 07:05:26'),
(409, 25, 'We are sending a new document with Document Tracking Code: 2024-03-05-3994. Send by Records Office.', 'unread', '2024-03-05 07:09:37'),
(410, 28, 'We are sending a new document with Document Tracking Code: 2024-03-05-3994. Send by Records Office.', 'unread', '2024-03-05 07:09:37'),
(411, 33, 'We are sending a new document with Document Tracking Code: 2024-03-05-3994. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(412, 30, 'We are sending a new document with Document Tracking Code: 2024-03-05-9838. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:44:19'),
(413, 35, 'We are sending a new document with Document Tracking Code: 2024-03-05-9838. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 07:40:20'),
(414, 30, 'We are sending a new document with Document Tracking Code: 2024-03-05-1305. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-05 07:44:19'),
(415, 35, 'We are sending a new document with Document Tracking Code: 2024-03-05-1305. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-05 07:40:55'),
(416, 33, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'read', '2024-03-06 09:47:01'),
(417, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-05 07:44:19'),
(418, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-05 07:43:44'),
(419, 33, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-06 09:47:01'),
(420, 30, 'Administrative Section Records received the document.', 'read', '2024-03-05 07:44:19'),
(421, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-05 07:43:50'),
(422, 33, 'Transaction completed. Mark this by: Records Office', 'read', '2024-03-06 09:47:01'),
(423, 2, 'New user registered.', 'read', '2024-03-06 09:53:48'),
(424, 25, 'We are sending a new document with Document Tracking Code: 2024-03-06-1353. Send by Records Office.', 'unread', '2024-03-06 06:26:06'),
(425, 28, 'We are sending a new document with Document Tracking Code: 2024-03-06-1353. Send by Records Office.', 'unread', '2024-03-06 06:26:06'),
(426, 33, 'We are sending a new document with Document Tracking Code: 2024-03-06-1353. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(427, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15');
INSERT INTO `tbl_notification` (`id`, `user_id`, `content`, `status`, `timestamp`) VALUES
(428, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 06:26:36'),
(429, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-06 09:01:15'),
(430, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-06 06:26:43'),
(431, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1353. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15'),
(432, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1353. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 06:27:03'),
(433, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:01:15'),
(434, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 06:28:52'),
(435, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(436, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:01:15'),
(437, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 06:31:33'),
(438, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(439, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:01:15'),
(440, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 06:33:55'),
(441, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(442, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:01:15'),
(443, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 06:39:01'),
(444, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(445, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:01:15'),
(446, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 06:39:12'),
(447, 25, 'We are sending a new document with Document Tracking Code: 2024-03-06-5343. Send by Records Office.', 'unread', '2024-03-06 06:39:48'),
(448, 28, 'We are sending a new document with Document Tracking Code: 2024-03-06-5343. Send by Records Office.', 'unread', '2024-03-06 06:39:48'),
(449, 33, 'We are sending a new document with Document Tracking Code: 2024-03-06-5343. Send by Records Office.', 'read', '2024-03-06 09:47:01'),
(450, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15'),
(451, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 06:40:03'),
(452, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-06 09:01:15'),
(453, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-06 06:40:08'),
(454, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-06-5343. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15'),
(455, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-06-5343. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 06:40:16'),
(456, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:01:15'),
(457, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 06:41:02'),
(458, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(459, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(460, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:01:15'),
(461, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 07:36:46'),
(462, 11, 'For information/reference/file.', 'read', '2024-03-10 20:24:20'),
(463, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1966. Transferred by Records Office.', 'unread', '2024-03-06 07:36:59'),
(464, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1966. Transferred by Records Office.', 'unread', '2024-03-06 07:36:59'),
(465, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1966. Transferred by Records Office.', 'read', '2024-03-06 09:47:01'),
(466, 11, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(467, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15'),
(468, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 07:37:15'),
(469, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(470, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-06 09:01:15'),
(471, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-06 07:37:22'),
(472, 11, 'SIGNED ASDHJASGDAS.', 'read', '2024-03-10 20:24:20'),
(473, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1966. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:01:15'),
(474, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-06-1966. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 07:37:30'),
(475, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(476, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:03:57'),
(477, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-06-5343. Transferred by Records Office.', 'unread', '2024-03-06 09:04:25'),
(478, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-06-5343. Transferred by Records Office.', 'unread', '2024-03-06 09:04:25'),
(479, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-06-5343. Transferred by Records Office.', 'read', '2024-03-06 09:47:01'),
(480, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:36:05'),
(481, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 09:05:13'),
(482, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:36:05'),
(483, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 09:08:57'),
(484, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(485, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(486, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(487, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:11:39'),
(488, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(489, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(490, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(491, 11, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'read', '2024-03-10 20:24:20'),
(492, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-06 09:36:05'),
(493, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-06 09:22:35'),
(494, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:36:05'),
(495, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 09:23:19'),
(496, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(497, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(498, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(499, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:24:23'),
(500, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-06 09:36:05'),
(501, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-06 09:25:39'),
(502, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'read', '2024-03-10 20:24:20'),
(503, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(504, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(505, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:26:00'),
(506, 11, 'For comments/recommendation.', 'read', '2024-03-10 20:24:20'),
(507, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'unread', '2024-03-06 09:26:59'),
(508, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'unread', '2024-03-06 09:26:59'),
(509, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'read', '2024-03-06 09:47:01'),
(510, 11, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(511, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:36:05'),
(512, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 09:30:01'),
(513, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(514, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-06 09:36:05'),
(515, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-06 09:30:07'),
(516, 11, 'Please follow-up and report action taken.', 'read', '2024-03-10 20:24:20'),
(517, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:36:05'),
(518, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 09:31:03'),
(519, 11, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'read', '2024-03-10 20:24:20'),
(520, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-06 09:36:05'),
(521, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-06 09:31:28'),
(522, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(523, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(524, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:31:38'),
(525, 11, 'For information/reference/file.', 'read', '2024-03-10 20:24:20'),
(526, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'unread', '2024-03-06 09:34:58'),
(527, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'unread', '2024-03-06 09:34:58'),
(528, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by Records Office.', 'read', '2024-03-06 09:47:01'),
(529, 11, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(530, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:36:05'),
(531, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 09:35:13'),
(532, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-10 20:24:20'),
(533, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-06 09:36:05'),
(534, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-06 09:35:19'),
(535, 11, 'For information/reference/file.', 'read', '2024-03-10 20:24:20'),
(536, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-06 09:36:05'),
(537, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-06-6399. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-06 09:35:28'),
(538, 11, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'read', '2024-03-10 20:24:20'),
(539, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-06 09:36:05'),
(540, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-06 09:35:40'),
(541, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-10 20:24:20'),
(542, 30, 'Administrative Section Records received the document.', 'read', '2024-03-06 09:36:05'),
(543, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-06 09:35:46'),
(544, 11, 'Transaction completed. Mark this by: Records Office', 'read', '2024-03-10 20:24:20'),
(545, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-8911. Send by Records Office.', 'unread', '2024-03-10 18:55:21'),
(546, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-8911. Send by Records Office.', 'unread', '2024-03-10 18:55:21'),
(547, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-8911. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(548, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-0287. Send by Records Office.', 'unread', '2024-03-10 18:59:57'),
(549, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-0287. Send by Records Office.', 'unread', '2024-03-10 18:59:57'),
(550, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-0287. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(551, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-2517. Send by Records Office.', 'unread', '2024-03-10 19:00:12'),
(552, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-2517. Send by Records Office.', 'unread', '2024-03-10 19:00:12'),
(553, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-2517. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(554, 31, 'We are sending a new document with Document Tracking Code: 2024-03-11-3813. Send by Records Office.', 'unread', '2024-03-10 19:00:31'),
(555, 34, 'We are sending a new document with Document Tracking Code: 2024-03-11-3813. Send by Records Office.', 'unread', '2024-03-10 19:00:31'),
(556, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-16 15:10:16'),
(557, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-10 20:24:17'),
(558, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'unread', '2024-03-10 20:28:24'),
(559, 11, 'The Administrative Section Records received your document. Received by Records Office.', 'unread', '2024-03-10 20:28:49'),
(560, 30, 'Administrative Section Records received the document.', 'read', '2024-03-16 15:10:16'),
(561, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-10 20:28:49'),
(562, 11, 'For appropirate action.', 'unread', '2024-03-10 21:19:29'),
(563, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-11-8620. Transferred by Records Office.', 'unread', '2024-03-10 21:19:29'),
(564, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-11-8620. Transferred by Records Office.', 'unread', '2024-03-10 21:19:29'),
(565, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-11-8620. Transferred by Records Office.', 'read', '2024-03-10 21:59:23'),
(566, 11, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:20:00'),
(567, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(568, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:20:00'),
(569, 11, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:20:32'),
(570, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-16 15:10:16'),
(571, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-10 21:20:32'),
(572, 30, 'Your document has been decline.', 'read', '2024-03-16 15:10:16'),
(573, 11, 'For initial/signature.', 'unread', '2024-03-10 21:21:10'),
(574, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-11-8620. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(575, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-11-8620. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:21:10'),
(576, 11, 'Your document has been decline.', 'unread', '2024-03-10 21:21:24'),
(577, 11, 'Your document has been decline.', 'unread', '2024-03-10 21:21:46'),
(578, 11, 'Your document has been decline.', 'unread', '2024-03-10 21:21:56'),
(579, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-16 15:10:16'),
(580, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-10 21:23:19'),
(581, 11, 'Your document has been decline.', 'unread', '2024-03-10 21:23:35'),
(582, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-9349. Send by Records Office.', 'unread', '2024-03-10 21:24:02'),
(583, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-9349. Send by Records Office.', 'unread', '2024-03-10 21:24:02'),
(584, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-9349. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(585, 30, 'Your document has been decline.', 'read', '2024-03-16 15:10:16'),
(586, 30, 'We are sending a new document with Document Tracking Code: 2024-03-11-7582. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(587, 35, 'We are sending a new document with Document Tracking Code: 2024-03-11-7582. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:26:30'),
(588, 33, 'Your document has been decline.', 'read', '2024-03-10 21:59:23'),
(589, 33, 'Your document has been decline.', 'read', '2024-03-10 21:59:23'),
(590, 33, 'Your document has been decline.', 'read', '2024-03-10 21:59:23'),
(591, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-2246. Send by Records Office.', 'unread', '2024-03-10 21:36:36'),
(592, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-2246. Send by Records Office.', 'unread', '2024-03-10 21:36:36'),
(593, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-2246. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(594, 30, 'Your document has been decline.', 'read', '2024-03-16 15:10:16'),
(595, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-0880. Send by Records Office.', 'unread', '2024-03-10 21:39:14'),
(596, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-0880. Send by Records Office.', 'unread', '2024-03-10 21:39:14'),
(597, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-0880. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(598, 30, 'Your document has been decline.', 'read', '2024-03-16 15:10:16'),
(599, 30, 'We are sending a new document with Document Tracking Code: 2024-03-11-6588. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(600, 35, 'We are sending a new document with Document Tracking Code: 2024-03-11-6588. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:42:00'),
(601, 33, 'Your document has been decline.', 'read', '2024-03-10 21:59:23'),
(602, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-7245. Send by Records Office.', 'unread', '2024-03-10 21:51:37'),
(603, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-7245. Send by Records Office.', 'unread', '2024-03-10 21:51:37'),
(604, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-7245. Send by Records Office.', 'read', '2024-03-10 21:59:23'),
(605, 30, 'We are sending a new document with Document Tracking Code: 2024-03-11-8022. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(606, 35, 'We are sending a new document with Document Tracking Code: 2024-03-11-8022. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:53:26'),
(607, 33, 'Your document has been decline.', 'read', '2024-03-10 21:59:23'),
(608, 30, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(609, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(610, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 21:59:53'),
(611, 30, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(612, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-16 15:10:16'),
(613, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-10 21:59:59'),
(614, 30, 'Transaction completed. Mark this by: asdasdasdasqzA asdasd', 'read', '2024-03-16 15:10:16'),
(615, 25, 'We are sending a new document with Document Tracking Code: 2024-03-11-1805. Send by Records Office.', 'unread', '2024-03-10 22:19:10'),
(616, 28, 'We are sending a new document with Document Tracking Code: 2024-03-11-1805. Send by Records Office.', 'unread', '2024-03-10 22:19:10'),
(617, 33, 'We are sending a new document with Document Tracking Code: 2024-03-11-1805. Send by Records Office.', 'unread', '2024-03-10 22:19:10'),
(618, 30, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(619, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(620, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 22:19:28'),
(621, 30, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(622, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-16 15:10:16'),
(623, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-10 22:19:38'),
(624, 30, 'For information/reference/file.', 'read', '2024-03-16 15:10:16'),
(625, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-11-1805. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(626, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-11-1805. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-10 22:19:53'),
(627, 30, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'read', '2024-03-16 15:10:16'),
(628, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-16 15:10:16'),
(629, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-10 22:20:37'),
(630, 30, 'The Administrative Section Records received your document. Received by Records Office.', 'read', '2024-03-16 15:10:16'),
(631, 30, 'Administrative Section Records received the document.', 'read', '2024-03-16 15:10:16'),
(632, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-10 22:20:42'),
(633, 30, 'For comments/recommendation.', 'read', '2024-03-16 15:10:16'),
(634, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-11-1805. Transferred by Records Office.', 'unread', '2024-03-10 22:22:37'),
(635, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-11-1805. Transferred by Records Office.', 'unread', '2024-03-10 22:22:37'),
(636, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-11-1805. Transferred by Records Office.', 'unread', '2024-03-10 22:22:37'),
(637, 2, 'New user registered.', 'read', '2024-03-16 15:35:03'),
(638, 30, 'We are sending a new document with Document Tracking Code: 2024-03-16-1370. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(639, 35, 'We are sending a new document with Document Tracking Code: 2024-03-16-1370. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:07:35'),
(640, 30, 'We are sending a new document with Document Tracking Code: 2024-03-16-8738. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(641, 35, 'We are sending a new document with Document Tracking Code: 2024-03-16-8738. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:09:41'),
(642, 33, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'unread', '2024-03-16 14:10:18'),
(643, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-16 15:10:16'),
(644, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-16 14:10:18'),
(645, 33, 'The Administrative Section Records received your document. Received by Records Office.', 'unread', '2024-03-16 14:10:51'),
(646, 30, 'Administrative Section Records received the document.', 'read', '2024-03-16 15:10:16'),
(647, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-16 14:10:51'),
(648, 33, 'Please follow-up and report action taken.', 'unread', '2024-03-16 14:14:58'),
(649, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:14:58'),
(650, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:14:58'),
(651, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:14:58'),
(652, 33, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:15:13'),
(653, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(654, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:15:13'),
(655, 33, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:15:20'),
(656, 30, 'Office of The Regional Irrigation Manager received the document.', 'read', '2024-03-16 15:10:16'),
(657, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-16 14:15:20'),
(658, 33, 'For appropirate action.', 'unread', '2024-03-16 14:15:29'),
(659, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(660, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 14:15:29'),
(661, 33, 'The Administrative Section Records accepted your document. Accept by Records Office.', 'unread', '2024-03-16 14:19:36'),
(662, 30, 'Administrative Section Records accepted the document. Accept by Records Office.', 'read', '2024-03-16 15:10:16'),
(663, 35, 'Administrative Section Records accepted the document. Accept by Records Office.', 'unread', '2024-03-16 14:19:36'),
(664, 25, 'We are sending a new document with Document Tracking Code: 2024-03-16-9559. Send by Records Office.', 'unread', '2024-03-16 14:22:36'),
(665, 28, 'We are sending a new document with Document Tracking Code: 2024-03-16-9559. Send by Records Office.', 'unread', '2024-03-16 14:22:36'),
(666, 33, 'We are sending a new document with Document Tracking Code: 2024-03-16-9559. Send by Records Office.', 'unread', '2024-03-16 14:22:36'),
(667, 30, 'Guest Guest uploaded new document.', 'read', '2024-03-16 15:10:16'),
(668, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-16 14:31:39'),
(669, 33, 'The Administrative Section Records received your document. Received by Records Office.', 'unread', '2024-03-16 14:35:50'),
(670, 30, 'Administrative Section Records received the document.', 'read', '2024-03-16 15:10:16'),
(671, 35, 'Administrative Section Records received the document.', 'unread', '2024-03-16 14:35:50'),
(672, 33, 'For comments/recommendation.', 'unread', '2024-03-16 14:36:25'),
(673, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:36:25'),
(674, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:36:25'),
(675, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-16-8738. Transferred by Records Office.', 'unread', '2024-03-16 14:36:25'),
(676, 30, 'We are sending a new document with Document Tracking Code: 2024-03-16-6152. Send by asdasdasdasqzA asdasd.', 'read', '2024-03-16 15:10:16'),
(677, 35, 'We are sending a new document with Document Tracking Code: 2024-03-16-6152. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 15:07:19'),
(678, 25, 'We are sending a new document with Document Tracking Code: 2024-03-16-5959. Send by Records Office.', 'unread', '2024-03-16 15:09:40'),
(679, 28, 'We are sending a new document with Document Tracking Code: 2024-03-16-5959. Send by Records Office.', 'unread', '2024-03-16 15:09:40'),
(680, 33, 'We are sending a new document with Document Tracking Code: 2024-03-16-5959. Send by Records Office.', 'unread', '2024-03-16 15:09:40'),
(681, 30, 'We are sending a new document with Document Tracking Code: 2024-03-17-9110. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:35:43'),
(682, 35, 'We are sending a new document with Document Tracking Code: 2024-03-17-9110. Send by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:35:43'),
(683, 33, NULL, 'unread', '2024-03-16 16:40:53'),
(684, 30, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 16:40:53'),
(685, 35, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 16:40:53'),
(686, 33, 'For appropirate action.', 'unread', '2024-03-16 16:42:07'),
(687, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:42:07'),
(688, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:42:07'),
(689, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:42:07'),
(690, 33, NULL, 'unread', '2024-03-16 16:43:23'),
(691, 30, 'Office of The Regional Irrigation Manager received the document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:43:23'),
(692, 35, 'Office of The Regional Irrigation Manager received the document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:43:23'),
(693, 33, 'For comments/recommendation.', 'unread', '2024-03-16 16:44:35'),
(694, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:44:35'),
(695, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:44:35'),
(696, 33, 'Administrative Section Records received the document.', 'unread', '2024-03-16 16:44:49'),
(697, 30, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 16:44:49'),
(698, 35, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 16:44:49'),
(699, 33, 'Please follow-up and report action taken.', 'unread', '2024-03-16 16:45:04'),
(700, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:45:04'),
(701, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:45:04'),
(702, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 16:45:04'),
(703, 33, 'The Office of The Regional Irrigation Manager accepted your document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:49:57'),
(704, 30, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:49:57'),
(705, 35, 'Office of The Regional Irrigation Manager accepted the document. Accept by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:49:57'),
(706, 33, 'The Office of The Regional Irrigation Manager received your document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:50:06'),
(707, 30, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-16 16:50:06'),
(708, 35, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-16 16:50:06'),
(709, 33, 'Please see me.', 'unread', '2024-03-16 16:50:24'),
(710, 30, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:50:24'),
(711, 35, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 16:50:24'),
(712, 33, 'Administrative Section Records scanned your document.', 'unread', '2024-03-16 16:55:37'),
(713, 33, 'Administrative Section Records scanned your document.', 'unread', '2024-03-16 17:00:56'),
(714, 33, 'Administrative Section Records scanned your document.', 'unread', '2024-03-16 17:01:18'),
(715, 33, 'Administrative Section Records scanned your document.', 'unread', '2024-03-16 17:01:25'),
(716, 33, 'Administrative Section Records scanned your document.', 'unread', '2024-03-16 17:02:17'),
(717, 33, 'Administrative Section Records received the document.', 'unread', '2024-03-16 17:02:19'),
(718, 30, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 17:02:19'),
(719, 35, 'Administrative Section Records received the document. Received by Records Office.', 'unread', '2024-03-16 17:02:19'),
(720, 33, 'For compliance.', 'unread', '2024-03-16 17:02:28'),
(721, 25, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 17:02:28'),
(722, 28, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 17:02:28'),
(723, 33, 'We are transferring a new document with Document Tracking Code: 2024-03-17-9110. Transferred by Records Office.', 'unread', '2024-03-16 17:02:28'),
(724, 33, 'Office of The Regional Irrigation Manager scanned your document.', 'unread', '2024-03-16 17:02:44'),
(725, 33, 'Office of The Regional Irrigation Manager received the document.', 'unread', '2024-03-16 17:02:55'),
(726, 30, 'Office of The Regional Irrigation Manager received the document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 17:02:55'),
(727, 35, 'Office of The Regional Irrigation Manager received the document. Received by asdasdasdasqzA asdasd.', 'unread', '2024-03-16 17:02:55'),
(728, 30, 'Guest Guest uploaded new document.', 'unread', '2024-03-16 17:53:45'),
(729, 35, 'Guest Guest uploaded new document.', 'unread', '2024-03-16 17:53:45'),
(730, 11, 'Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept byRecords Office.', 'unread', '2024-03-16 17:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offices`
--

CREATE TABLE `tbl_offices` (
  `id` bigint(250) NOT NULL,
  `office_code` varchar(250) NOT NULL,
  `office_name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_offices`
--

INSERT INTO `tbl_offices` (`id`, `office_code`, `office_name`, `created_at`) VALUES
(1, 'RIM', 'Office of The Regional Irrigation Manager', '2024-01-06 04:54:28'),
(2, 'ORM-HS', 'Office of the Regional Manager - Health Services', '2024-01-06 05:13:55'),
(3, 'ORM-IT', 'Office of the Regional Manager - IT', '2024-01-06 05:15:28'),
(4, 'EOD', 'Engineering and Operations Division', '2024-01-06 05:15:50'),
(5, 'EOD-OS', 'Engineering Section', '2024-01-06 05:15:59'),
(6, 'ES', 'Equipment Section', '2024-01-06 05:16:48'),
(7, 'OPS', 'Operation Section', '2024-01-06 05:17:08'),
(8, 'AFD', 'Administrative and Finance Division', '2024-01-06 05:17:26'),
(9, 'ASR', 'Administrative Section Records', '2024-01-06 05:17:33'),
(10, 'FS', 'Finance Section', '2024-01-06 05:17:44'),
(11, 'PU', 'Property Unit', '2024-01-06 05:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office_document`
--

CREATE TABLE `tbl_office_document` (
  `id` bigint(250) NOT NULL,
  `office_name` varchar(250) DEFAULT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_office_document`
--

INSERT INTO `tbl_office_document` (`id`, `office_name`, `docu_id`, `status`) VALUES
(61, 'Office of The Regional Irrigation Manager', 150, 'completed'),
(72, 'Office of The Regional Irrigation Manager', 159, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_office_incoming`
--

CREATE TABLE `tbl_office_incoming` (
  `id` bigint(250) NOT NULL,
  `office_id` bigint(250) DEFAULT NULL,
  `docu_id` bigint(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT 'pending',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` bigint(100) NOT NULL,
  `user_id` bigint(100) DEFAULT NULL,
  `response` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uploaded_document`
--

CREATE TABLE `tbl_uploaded_document` (
  `id` bigint(250) NOT NULL,
  `qr_filename` text DEFAULT NULL,
  `pdf_filename` text DEFAULT NULL,
  `document_code` varchar(250) DEFAULT NULL,
  `document_type` varchar(250) DEFAULT NULL,
  `document_size` text DEFAULT NULL,
  `sender_id` bigint(250) DEFAULT NULL,
  `sender` varchar(250) DEFAULT NULL,
  `from_office` varchar(250) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `data_source` varchar(250) DEFAULT NULL,
  `required_action` varchar(250) DEFAULT NULL,
  `status` text DEFAULT NULL,
  `completed` varchar(250) DEFAULT 'no',
  `prev_office` varchar(250) DEFAULT NULL,
  `cur_office` varchar(250) DEFAULT NULL,
  `action_requested` varchar(250) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_uploaded_document`
--

INSERT INTO `tbl_uploaded_document` (`id`, `qr_filename`, `pdf_filename`, `document_code`, `document_type`, `document_size`, `sender_id`, `sender`, `from_office`, `subject`, `description`, `data_source`, `required_action`, `status`, `completed`, `prev_office`, `cur_office`, `action_requested`, `document_date`, `uploaded_at`, `updated_at`) VALUES
(148, '2024-03-11-0880.png', '2024-03-11-0880.pdf', '2024-03-11-0880', 'Indorsement&nbsp; Letter', '29.65kb', 30, 'Records Office', NULL, '123123', '123123213', 'internal', 'For appropirate action', 'Decline by : Office of The Regional Irrigation Manager - asdasdasdasqzA asdasd', 'decline', 'No previous office.', 'No current office.', NULL, '2024-03-07', '2024-03-10 21:39:14', '2024-03-10 21:39:14'),
(149, '2024-03-11-6588.png', '2024-03-11-6588.pdf', '2024-03-11-6588', 'Indorsement&nbsp; Letter', '29.65kb', 33, 'Office of The Regional Irrigation Manager', NULL, '213123213', '1232313', 'internal', 'For appropirate action', 'Decline by : Administrative Section Records - Records Office', 'decline', 'No previous office.', 'No current office.', NULL, '2024-03-05', '2024-03-10 21:42:00', '2024-03-10 21:42:00'),
(150, '2024-03-11-7245.png', '2024-03-11-7245.pdf', '2024-03-11-7245', 'Transmittal Letter', '29.65kb', 30, 'Records Office', 'Administrative Section Records', 'qweqwe', 'qweqweqwe', 'internal', 'For appropirate action', 'Document code created:  2024-03-11-7245, Office of The Regional Irrigation Manager received the document., Transaction completed. Mark this by: asdasdasdasqzA asdasd', 'complete', 'No current office.', 'Office of The Regional Irrigation Manager', NULL, '2024-03-11', '2024-03-10 21:51:37', '2024-03-10 22:00:13'),
(151, '2024-03-11-8022.png', '2024-03-11-8022.pdf', '2024-03-11-8022', 'Transmittal Letter', '29.65kb', 33, 'asdasdasdasqzA asdasd', 'Office of The Regional Irrigation Manager', 'qweqwe', 'qweqweqwe', 'internal', 'For appropirate action', 'Decline by : Administrative Section Records - Records Office', 'decline', 'No previous office.', 'No current office.', NULL, '2024-03-11', '2024-03-10 21:53:26', '2024-03-10 21:53:26'),
(152, '2024-03-11-1805.png', '2024-03-11-1805.pdf', '2024-03-11-1805', 'Acknowledge Receipt for Equipment (ARE)', '29.65kb', 30, 'Records Office', 'Administrative Section Records', 'asdasd', 'asdwqe', 'internal', 'For comments/recommendation', 'pulled', 'pulled', 'No previous office.', 'No current office.', NULL, '2024-03-06', '2024-03-10 22:19:10', '2024-03-16 14:30:58'),
(153, '2024-03-16-1370.png', '2024-03-16-1370.pdf', '2024-03-16-1370', 'Travel Order', '29.65kb', 33, 'asdasdasdasqzA asdasd', 'Office of The Regional Irrigation Manager', 'testing', '123123', 'internal', 'For appropirate action', 'pulled', 'pulled', 'No previous office.', 'No current office.', NULL, '2024-03-16', '2024-03-16 14:07:35', '2024-03-16 14:39:07'),
(154, '2024-03-16-8738.png', '2024-03-16-8738.pdf', '2024-03-16-8738', 'Indorsement&nbsp; Letter', '29.65kb', 33, 'asdasdasdasqzA asdasd', 'Office of The Regional Irrigation Manager', '213123123213', '123123123', 'internal', 'For comments/recommendation', 'Document code created:  2024-03-16-8738, Administrative Section Records received the document., Please follow-up and report action taken., Office of The Regional Irrigation Manager received the document., For appropirate action., Administrative Section Records received the document., For comments/recommendation.', 'ongoing', 'No previous office.', 'No current office.', NULL, '2024-03-16', '2024-03-16 14:09:41', '2024-03-16 14:36:25'),
(155, '2024-03-16-9559.png', '2024-03-16-9559.pdf', '2024-03-16-9559', 'Acknowledge Receipt for Equipment (ARE)', '29.65kb', 30, 'Records Office', 'Administrative Section Records', 'qweqweqwe', 'qweqweqwe', 'internal', 'For appropirate action', 'pulled', 'pulled', 'No previous office.', 'No current office.', NULL, '2024-03-16', '2024-03-16 14:22:36', '2024-03-16 14:35:39'),
(156, NULL, '1710599499.pdf', NULL, 'Acknowledge Receipt for Equipment (ARE)', '29.65kb', 11, 'Guest Guest', NULL, '123123', '123123123', 'guest', 'For appropirate action', 'pulled', 'pulled', NULL, NULL, NULL, '2024-03-16', '2024-03-16 14:31:39', '2024-03-16 14:31:43'),
(157, '2024-03-16-6152.png', '2024-03-16-6152.pdf', '2024-03-16-6152', 'Acknowledge Receipt for Equipment (ARE)', '29.65kb', 33, 'asdasdasdasqzA asdasd', 'Office of The Regional Irrigation Manager', 'qweqe2', 'wqewqeqwe', 'internal', 'For appropirate action', 'pulled', 'pulled', 'No previous office.', 'No current office.', NULL, '2024-03-16', '2024-03-16 15:07:19', '2024-03-16 15:09:05'),
(158, '2024-03-16-5959.png', '2024-03-16-5959.pdf', '2024-03-16-5959', 'Transmittal Letter', '29.65kb', 30, 'Records Office', 'Administrative Section Records', 'editr', '213213123213', 'internal', 'For appropirate action', 'pulled', 'pulled', 'No previous office.', 'No current office.', NULL, '2024-03-09', '2024-03-16 15:09:40', '2024-03-16 15:41:08'),
(159, '2024-03-17-9110.png', '2024-03-17-9110.pdf', '2024-03-17-9110', 'Indorsement&nbsp; Letter', '29.65kb', 33, 'asdasdasdasqzA asdasd', 'Office of The Regional Irrigation Manager', 'qweqwewq', 'wqeqweqwe', 'internal', 'For compliance', 'Document code created:  2024-03-17-9110, , For appropirate action., Office of The Regional Irrigation Manager received the document., For comments/recommendation., Administrative Section Records received the document., Please follow-up and report action taken., Office of The Regional Irrigation Manager received the document., Please see me., Administrative Section Records received the document., For compliance., Office of The Regional Irrigation Manager received the document.', 'ongoing', 'No previous office.', 'Office of The Regional Irrigation Manager', NULL, '2024-03-07', '2024-03-16 16:35:43', '2024-03-16 17:02:55'),
(160, '2024-03-17-7033.png', '1710611625.pdf', '2024-03-17-7033', 'Acknowledge Receipt for Equipment (ARE)', '29.65kb', 11, 'Guest Guest', NULL, 'sadas', 'qweqweqw', 'guest', 'For comments/recommendation', 'Document code created: 2024-03-17-7033.', 'ongoing', 'No previous office.', 'Administrative Section Records', 'Document accepted', '2024-03-14', '2024-03-16 17:53:45', '2024-03-16 17:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userinformation`
--

CREATE TABLE `tbl_userinformation` (
  `id` bigint(100) NOT NULL,
  `user_profile` varchar(250) DEFAULT 'user-default.jpg',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `office` varchar(250) DEFAULT NULL,
  `office_code` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_userinformation`
--

INSERT INTO `tbl_userinformation` (`id`, `user_profile`, `firstname`, `lastname`, `contact`, `position`, `office`, `office_code`, `email`, `role`, `status`, `created_at`) VALUES
(2, '1703999162_123.png', 'Admin', 'Admin', '9123123123', 'ADMINASDASDASD', 'ADMIN OFFICE', NULL, 'asdasd@asdasd.com', 'admin', 'active', '2023-12-09 06:33:00'),
(3, 'user-default.jpg', 'Handler 1', 'Handler 1', '123', '123', 'Handler Office 1', NULL, 'metag70052@vasteron.com', 'handler', 'archived', '2023-12-09 06:33:17'),
(10, 'user-default.jpg', 'asdasd', 'asdasd', '9123123123', 'asdasd', 'asdasdads', NULL, 'xekani2857@hupoi.com', 'guest', 'archived', '2023-12-11 16:12:24'),
(11, '1703999658_user-default.jpg', 'Guest', 'Guest', '9123123123', 'EDITEDasd', 'asdqweasd', NULL, 'fonej95623@arensus.com', 'guest', 'active', '2023-12-16 02:45:42'),
(13, 'user-default.jpg', 'Hander 2', 'Hander 2', '9123123123', '123123123', 'Handler Office 2', NULL, 'tomas49870@aseall.com', 'handler', 'archived', '2023-12-16 03:06:00'),
(18, 'user-default.jpg', 'Hander 3', 'Hander 3', '09123123123', 'asdasd', 'Hanler Office 3', NULL, 'antdev0101@gmail.com', 'handler', 'archived', '2023-12-18 07:38:05'),
(19, 'user-default.jpg', '123y78123', 'trovela', '09123123123', 'asdasd', 'asdqweqwe', NULL, 'antdev01011@gmail.com', 'guest', 'archived', '2023-12-18 07:40:14'),
(20, 'user-default.jpg', 'asdasdasd', 'asdasdasd', '9123123123', 'asdasdasdasd', 'asdasdqweqweqwe', NULL, 'metag70052@vasteron.com', 'guest', 'active', '2023-12-29 04:27:16'),
(21, 'user-default.jpg', 'aqweqwe', 'qweqwe', '9123123123', 'qwe123', 'qweqweqwe', NULL, 'asdqweqwe@asdasd.com', 'handler', 'archived', '2023-12-30 11:12:35'),
(22, '1704003022_123.png', 'TESTING', 'TESTING', '9123123123', 'SADQWEQWEQWE', NULL, NULL, 'vedopac922@vasteron.com', 'guest', 'active', '2023-12-31 06:08:41'),
(25, 'user-default.jpg', 'New Document12', 'Handler', '9123123123', 'ASDWEQEWQEQWE', 'Office of The Regional Irrigation Manager', 'RIM', 'tefoj69800@regapts.com', 'handler', 'active', '2024-01-06 06:57:25'),
(27, 'user-default.jpg', 'Newasd', 'Guest', '9123123123', '', '', NULL, 'boyav37316@pursip.com', 'guest', 'active', '2024-01-06 07:00:13'),
(28, 'user-default.jpg', 'Added by', 'Admin', '9123123123', 'ASDWQEWQEQWEQWE', 'Office of The Regional Irrigation Manager', 'RIM', 'katey51351@talmetry.com', 'handler', 'active', '2024-01-06 07:22:20'),
(29, 'user-default.jpg', 'Added by', 'admin guest', '9123123123', NULL, NULL, NULL, 'dihaboc490@regapts.com', 'guest', 'active', '2024-01-06 07:25:14'),
(30, 'user-default.jpg', 'Records', 'Office', '9123123123', 'asdqweqwe', 'Administrative Section Records', 'ASR', 'hogopij761@pursip.com', 'handler', 'active', '2024-01-06 07:43:04'),
(31, 'user-default.jpg', 'qwe', 'qwe', '9123123123', '123123123', 'Office of the Regional Manager - Health Services', 'ORM-HS', 'qwe@aqweqw.com', 'handler', 'active', '2024-01-07 03:00:32'),
(32, 'user-default.jpg', 'qw', 'qwe', '9123123123', 'qweqweqwe', 'Office of the Regional Manager - IT', 'ORM-IT', 'qweqwewe@weqweqw.com', 'handler', 'active', '2024-01-07 03:00:52'),
(33, 'user-default.jpg', 'asdasdasdasqzA', 'asdasd', '9123123123', '1231231232', 'Office of The Regional Irrigation Manager', 'RIM', 'asdasasdd@asdasd.com', 'handler', 'active', '2024-01-07 08:52:09'),
(34, 'user-default.jpg', 'asd', 'asdasd', '9123123123', 'sadasdqwe', 'Office of the Regional Manager - Health Services', 'ORM-HS', 'asdasdasdasd@asdasdsa.com', 'handler', 'active', '2024-01-07 08:52:48'),
(35, 'user-default.jpg', 'record', 'record', '9123123123', 'qweqweqwe', 'Administrative Section Records', 'ASR', 'asdasd@asdasdasd.com', 'handler', 'active', '2024-01-20 02:26:01'),
(36, 'user-default.jpg', 'Testing', 'LNagsasd', '9123123123', NULL, NULL, NULL, 'kixiji8671@tospage.com', 'guest', 'active', '2024-02-17 15:24:51'),
(37, 'user-default.jpg', 'asdasd', 'asdasdasd', '9123123123', NULL, NULL, NULL, 'fejokal467@huizk.com', 'guest', 'active', '2024-02-27 01:31:49'),
(38, 'user-default.jpg', 'asdqweqwe', 'qweqwdasdas', '9123123123', NULL, NULL, NULL, 'yamevif531@artgulin.com', 'guest', 'decline', '2024-03-05 05:04:07'),
(40, 'user-default.jpg', 'qweqwe', 'qweqwe', '9123123123', NULL, NULL, NULL, 'yagib59657@bizatop.com', 'guest', 'active', '2024-03-05 05:13:42'),
(41, 'user-default.jpg', 'newguest', 'newguest', '9123123123', NULL, NULL, NULL, 'wanadet919@artgulin.com', 'guest', 'active', '2024-03-05 07:55:15'),
(42, 'user-default.jpg', 'qweqweqwe', 'qweqweqwe', '09123123123', NULL, NULL, NULL, 'micopar463@bizatop.com', 'guest', 'active', '2024-03-10 22:29:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_action_taken`
--
ALTER TABLE `tbl_action_taken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admins_incoming`
--
ALTER TABLE `tbl_admins_incoming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`);

--
-- Indexes for table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_document_tracking`
--
ALTER TABLE `tbl_document_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`);

--
-- Indexes for table `tbl_document_type`
--
ALTER TABLE `tbl_document_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_handler_document`
--
ALTER TABLE `tbl_handler_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_handler_incoming`
--
ALTER TABLE `tbl_handler_incoming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`);

--
-- Indexes for table `tbl_handler_outgoing`
--
ALTER TABLE `tbl_handler_outgoing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`);

--
-- Indexes for table `tbl_login_account`
--
ALTER TABLE `tbl_login_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_offices`
--
ALTER TABLE `tbl_offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_office_document`
--
ALTER TABLE `tbl_office_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`);

--
-- Indexes for table `tbl_office_incoming`
--
ALTER TABLE `tbl_office_incoming`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docu_id` (`docu_id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_uploaded_document`
--
ALTER TABLE `tbl_uploaded_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_userinformation`
--
ALTER TABLE `tbl_userinformation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_action_taken`
--
ALTER TABLE `tbl_action_taken`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_admins_incoming`
--
ALTER TABLE `tbl_admins_incoming`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_conversation`
--
ALTER TABLE `tbl_conversation`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_document_tracking`
--
ALTER TABLE `tbl_document_tracking`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT for table `tbl_document_type`
--
ALTER TABLE `tbl_document_type`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `tbl_handler_document`
--
ALTER TABLE `tbl_handler_document`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_handler_incoming`
--
ALTER TABLE `tbl_handler_incoming`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `tbl_handler_outgoing`
--
ALTER TABLE `tbl_handler_outgoing`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_login_account`
--
ALTER TABLE `tbl_login_account`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=731;

--
-- AUTO_INCREMENT for table `tbl_offices`
--
ALTER TABLE `tbl_offices`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_office_document`
--
ALTER TABLE `tbl_office_document`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_office_incoming`
--
ALTER TABLE `tbl_office_incoming`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_uploaded_document`
--
ALTER TABLE `tbl_uploaded_document`
  MODIFY `id` bigint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `tbl_userinformation`
--
ALTER TABLE `tbl_userinformation`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admins_incoming`
--
ALTER TABLE `tbl_admins_incoming`
  ADD CONSTRAINT `tbl_admins_incoming_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_document_tracking`
--
ALTER TABLE `tbl_document_tracking`
  ADD CONSTRAINT `tbl_document_tracking_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_handler_document`
--
ALTER TABLE `tbl_handler_document`
  ADD CONSTRAINT `tbl_handler_document_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_handler_document_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_userinformation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_handler_incoming`
--
ALTER TABLE `tbl_handler_incoming`
  ADD CONSTRAINT `tbl_handler_incoming_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_handler_outgoing`
--
ALTER TABLE `tbl_handler_outgoing`
  ADD CONSTRAINT `tbl_handler_outgoing_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD CONSTRAINT `tbl_notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_userinformation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_office_document`
--
ALTER TABLE `tbl_office_document`
  ADD CONSTRAINT `tbl_office_document_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_office_incoming`
--
ALTER TABLE `tbl_office_incoming`
  ADD CONSTRAINT `tbl_office_incoming_ibfk_1` FOREIGN KEY (`docu_id`) REFERENCES `tbl_uploaded_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_office_incoming_ibfk_2` FOREIGN KEY (`office_id`) REFERENCES `tbl_login_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_userinformation`
--
ALTER TABLE `tbl_userinformation`
  ADD CONSTRAINT `tbl_userinformation_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tbl_login_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
