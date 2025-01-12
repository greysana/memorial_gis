-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 09:54 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gis`
--

-- --------------------------------------------------------

--
-- Table structure for table `deceased_info`
--

CREATE TABLE `deceased_info` (
  `deceased_id` int(11) NOT NULL,
  `deceased_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_death` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deceased_info`
--

INSERT INTO `deceased_info` (`deceased_id`, `deceased_name`, `date_of_birth`, `date_of_death`) VALUES
(11, 'Person One', '1988-02-22', '2022-10-10'),
(12, 'Person Two', '1988-10-11', '2022-09-16'),
(13, '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `tier` varchar(10) DEFAULT NULL,
  `service_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_renewable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `code`, `tier`, `service_type`, `description`, `amount`, `duration`, `notes`, `is_renewable`, `created_at`, `updated_at`, `service_id`) VALUES
(1, 'A1-BASIC-BUR', NULL, 'basic', 'Burial / Exhumation / Restus', '480.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:34:24', 4),
(2, 'A2-BASIC-ENT', NULL, 'basic', 'Entrance / Transfer', '600.00', NULL, 'For cemetery only', 1, '2024-12-27 06:04:30', '2024-12-30 08:34:43', 5),
(3, 'A1-N-APT', 'A-1', 'niches', 'Apartment, A1', '6000.00', 'for 5 years', NULL, 0, '2024-12-27 06:04:30', '2025-01-01 04:35:22', 8),
(4, 'B1-N-APT', 'B-1', 'niches', 'Apartment, B1', '4800.00', 'for 5 years', NULL, 0, '2024-12-27 06:04:30', '2025-01-01 04:35:30', 8),
(5, 'C1-N-APT', 'C-1', 'niches', 'Apartment, C1', '4200.00', 'for 5 years', NULL, 0, '2024-12-27 06:04:30', '2025-01-01 04:35:44', 8),
(6, 'A1-N-EXCL', 'A-1', 'niches', 'Exclusive Lot/Niches, A1', '6000.00', 'for 5 years', 'Annual Fee: 480.00 per sqm', 1, '2024-12-27 06:04:30', '2025-01-01 04:35:36', 9),
(7, 'A1-C-BONES', 'A-1', 'cremation', 'Cremation, Bones A1', '7200.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:38:10', 6),
(8, 'A2-C-BONES', 'A-2', 'cremation', 'Cremation, Bones A2', '19250.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:39:22', 6),
(9, 'B1-C-BONES', 'B-1', 'cremation', 'Cremation, Bones B1', '4800.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:39:22', 6),
(10, 'C1-C-BONES', 'C-1', 'cremation', 'Cremation, Bones C1', '2400.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:39:22', 6),
(11, 'D1-C-BONES', 'D-1', 'cremation', 'Cremation, Bones D1', '20000.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:39:22', 6),
(12, 'A1-C-APT', 'A-1', 'cremation', 'Cremation Apartment, A1', '12000.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(13, 'A1.1-C-APT', 'A-1.1', 'cremation', 'Cremation Apartment, A1.1', '5000.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(14, 'A2-C-APT', 'A-2', 'cremation', 'Cremation Apartment, A2', '35000.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(15, 'B1-C-APT', 'B-1', 'cremation', 'Cremation Apartment, B1', '8400.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(16, 'C1.1-C-APT', 'C-1.1', 'cremation', 'Cremation Apartment, C1.1', '1500.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(17, 'D1-C-APT', 'D-1', 'cremation', 'Cremation Apartment, D1', '25000.00', NULL, NULL, 1, '2024-12-27 06:04:30', '2024-12-30 08:41:20', 7),
(18, 'A1-COL', 'A-1', 'columbarium', '1,2,3,7,8,9', '1800.00', 'per year', 'Residents only, 1st-degree relatives', 1, '2024-12-27 06:04:30', '2025-01-01 04:25:27', 2),
(24, 'B-COL', 'B', 'columbarium', '1,2,3,7,8,9', '1500.00', 'per year', 'Residents only, 1st-degree relatives', 1, '2024-12-27 06:04:30', '2025-01-01 04:25:32', 2),
(25, 'C-COL', 'C', 'columbarium', '1,2,3,7,8,9', '1200.00', 'per year', 'Residents only, 1st-degree relatives', 1, '2024-12-27 06:04:30', '2025-01-01 04:25:45', 2),
(26, 'UNIFORM-COL', 'Regular', 'columbarium', '4,5,6', '2400.00', 'per year', 'Uniform rate', 1, '2024-12-27 06:04:30', '2025-01-01 04:25:54', 2),
(27, 'CHAPEL-1D', NULL, 'chapel', 'Chapel usage, 1 day', '1200.00', 'per 1 day', 'Maximum of 5 days', 0, '2024-12-27 06:04:30', '2025-01-01 04:35:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE `paymentmethods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paymentmethods`
--

INSERT INTO `paymentmethods` (`payment_method_id`, `payment_method_name`) VALUES
(1, 'GCASH'),
(2, 'Paymaya');

-- --------------------------------------------------------

--
-- Table structure for table `plots`
--

CREATE TABLE `plots` (
  `plot_id` int(11) NOT NULL,
  `row_number` int(11) NOT NULL,
  `column_number` int(11) NOT NULL,
  `plot_code` varchar(50) NOT NULL,
  `plot_type_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `deceased_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `tier` varchar(50) DEFAULT NULL,
  `geo_position` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plots`
--

INSERT INTO `plots` (`plot_id`, `row_number`, `column_number`, `plot_code`, `plot_type_id`, `service_type_id`, `availability`, `deceased_id`, `reservation_id`, `tier`, `geo_position`, `service_id`) VALUES
(1, 0, 0, 'Exclusive-001', 5, 5, 0, NULL, NULL, 'A-1', '[14.576920523870077, 121.02561636851838]', 9),
(2, 0, 0, 'Exclusive-002', 5, 5, 1, NULL, NULL, 'A-1', '[14.576882736827671, 121.02562566795633]', 9),
(3, 0, 0, 'Exclusive-003', 5, 5, 1, NULL, NULL, 'B-1', '[14.576909264919266, 121.02569506965937]', 9),
(4, 0, 0, 'Exclusive-004', 5, 5, 1, NULL, NULL, 'B-1', '[14.576913849896832, 121.02572793017144]', 9),
(5, 0, 0, 'Exclusive-005', 5, 5, 1, NULL, NULL, 'C-1', '[14.576897783066008, 121.02576002309683]', 9),
(6, 0, 0, 'Exclusive-006', 5, 5, 1, NULL, NULL, 'C-1', '[14.576916748438672, 121.02582036616307]', 9),
(7, 0, 0, 'Exclusive-007', 5, 5, 1, NULL, NULL, 'C-1', '[14.57688609100229, 121.02587642722562]', 9),
(8, 0, 0, 'Exclusive-008', 5, 5, 1, NULL, NULL, 'D-1', '[14.576899824165564, 121.02591749904536]', 9),
(9, 0, 0, 'Exclusive-009', 5, 5, 1, NULL, NULL, 'D-1', '[14.576885463882571, 121.02597010458737]', 9),
(10, 0, 0, 'Exclusive-010', 5, 5, 1, NULL, NULL, 'D-1', '[14.57690963442485, 121.02599993355132]', 9),
(11, 1, 1, 'Apartment_1-A1-R1-C1', 1, 5, 1, NULL, NULL, 'A-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(12, 1, 2, 'Apartment_1-A1-R1-C2', 1, 5, 1, NULL, NULL, 'A-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(13, 1, 3, 'Apartment_1-B1-R1-C3', 1, 5, 1, NULL, NULL, 'B-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(14, 1, 4, 'Apartment_1-C1-R1-C4', 1, 5, 1, NULL, NULL, 'C-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(15, 2, 1, 'Apartment_1-A1-R2-C1', 1, 5, 1, NULL, NULL, 'A-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(16, 2, 2, 'Apartment_1-B1-R2-C2', 1, 5, 1, NULL, NULL, 'B-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(17, 2, 3, 'Apartment_1-C1-R2-C3', 1, 5, 1, NULL, NULL, 'C-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(18, 2, 4, 'Apartment_1-D1-R2-C4', 1, 5, 1, NULL, NULL, 'D-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(19, 3, 1, 'Apartment_1-A1-R3-C1', 1, 5, 1, NULL, NULL, 'A-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(20, 3, 2, 'Apartment_1-B1-R3-C2', 1, 5, 1, NULL, NULL, 'B-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(21, 3, 3, 'Apartment_1-C1-R3-C3', 1, 5, 1, NULL, NULL, 'C-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(22, 3, 4, 'Apartment_1-D1-R3-C4', 1, 5, 1, NULL, NULL, 'D-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(23, 4, 1, 'Apartment_1-A1-R4-C1', 1, 5, 1, NULL, NULL, 'A-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(24, 4, 2, 'Apartment_1-B1-R4-C2', 1, 5, 1, NULL, NULL, 'B-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(25, 4, 3, 'Apartment_1-C1-R4-C3', 1, 5, 1, NULL, NULL, 'C-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(26, 4, 4, 'Apartment_1-D1-R4-C4', 1, 5, 1, NULL, NULL, 'D-1', '[[14.5775078, 121.0254534], [14.5772872, 121.0255499], [14.577308, 121.0256063], [14.57753, 121.0255076], [14.5775085, 121.0254542]]', 8),
(27, 1, 1, 'Apartment_2-A1-R1-C1', 2, 5, 1, NULL, NULL, 'A-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(28, 1, 2, 'Apartment_2-B1-R1-C2', 2, 5, 1, NULL, NULL, 'B-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(29, 1, 3, 'Apartment_2-C1-R1-C3', 2, 5, 1, NULL, NULL, 'C-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(30, 2, 1, 'Apartment_2-A1-R2-C1', 2, 5, 1, NULL, NULL, 'A-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(31, 2, 2, 'Apartment_2-B1-R2-C2', 2, 5, 1, NULL, NULL, 'B-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(32, 2, 3, 'Apartment_2-C1-R2-C3', 2, 5, 1, NULL, NULL, 'C-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(33, 3, 1, 'Apartment_2-A1-R3-C1', 2, 5, 1, NULL, NULL, 'A-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(34, 3, 2, 'Apartment_2-B1-R3-C2', 2, 5, 1, NULL, NULL, 'B-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(35, 3, 3, 'Apartment_2-C1-R3-C3', 2, 5, 1, NULL, NULL, 'C-1', '[[14.5775393, 121.0255231], [14.5773106, 121.0256224], [14.5773337, 121.0256605], [14.5775528, 121.0255703], [14.5775442, 121.0255151]]', 8),
(36, 1, 1, 'Columbarium_1-A1-R1-C1', 3, 2, 1, NULL, NULL, 'A-1', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(37, 1, 2, 'Columbarium_1-B-R1-C2', 3, 2, 1, NULL, NULL, 'B', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(38, 1, 3, 'Columbarium_1-C-R1-C3', 3, 2, 1, NULL, NULL, 'C', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(39, 4, 1, 'Columbarium_1-Uniform-R4-C1', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(40, 4, 2, 'Columbarium_1-Uniform-R4-C2', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(41, 4, 3, 'Columbarium_1-Uniform-R4-C3', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(42, 5, 1, 'Columbarium_1-Uniform-R5-C1', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(43, 5, 2, 'Columbarium_1-Uniform-R5-C2', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(44, 5, 3, 'Columbarium_1-Uniform-R5-C3', 3, 2, 1, NULL, NULL, 'Regular', '[[14.5783277, 121.02609], [14.5781756, 121.0261481], [14.5781893, 121.02618], [14.5783385, 121.0261201], [14.5783291, 121.0260887]]', 2),
(45, 1, 1, 'Columbarium_2-A1-R1-C1', 4, 2, 1, NULL, NULL, 'A-1', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(46, 1, 2, 'Columbarium_2-B-R1-C2', 4, 2, 1, NULL, NULL, 'B', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(47, 1, 3, 'Columbarium_2-C-R1-C3', 4, 2, 1, NULL, NULL, 'C', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(48, 4, 1, 'Columbarium_2-Uniform-R4-C1', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(49, 4, 2, 'Columbarium_2-Uniform-R4-C2', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(50, 4, 3, 'Columbarium_2-Uniform-R4-C3', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(51, 5, 1, 'Columbarium_2-Uniform-R5-C1', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(52, 5, 2, 'Columbarium_2-Uniform-R5-C2', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(53, 5, 3, 'Columbarium_2-Uniform-R5-C3', 4, 2, 1, NULL, NULL, 'Regular', '[[14.5782877, 121.0260207], [14.5781122, 121.0260786], [14.5781278, 121.0261245], [14.5783004, 121.0260614], [14.5782893, 121.0260183]]', 2),
(54, 0, 0, 'Exclusive-011', 5, 5, 1, NULL, NULL, 'A-1', '[14.5775209, 121.0264551]', 9),
(55, 0, 0, 'Exclusive-012', 5, 5, 1, NULL, NULL, 'A-1', '[14.5773666, 121.0265667]', 9),
(56, 0, 0, 'Exclusive-013', 5, 5, 1, NULL, NULL, 'A-1', '[14.5774915, 121.0268599]', 9),
(57, 0, 0, 'Exclusive-014', 5, 5, 1, NULL, NULL, 'A-1', '[14.5776811, 121.0267455]', 9),
(58, 0, 0, 'Exclusive-015', 5, 5, 1, NULL, NULL, 'A-1', '[14.5775364, 121.0264776]', 9),
(59, 0, 0, 'Exclusive-016', 5, 5, 1, NULL, NULL, 'A-1', '[14.5775332, 121.0265041]', 9),
(60, 0, 0, 'Exclusive-017', 5, 5, 1, NULL, NULL, 'A-1', '[14.5773582, 121.0265162]', 9),
(61, 0, 0, 'Exclusive-018', 5, 5, 1, NULL, NULL, 'A-1', '[14.5774318, 121.0268524]', 9),
(62, 0, 0, 'Exclusive-019', 5, 5, 1, NULL, NULL, 'A-1', '[14.5776846, 121.0267682]', 9),
(63, 0, 0, 'Exclusive-020', 5, 5, 1, NULL, NULL, 'A-1', '[14.5775396, 121.0266023]', 9);

-- --------------------------------------------------------

--
-- Table structure for table `plottypes`
--

CREATE TABLE `plottypes` (
  `plot_type_id` int(11) NOT NULL,
  `plot_type_name` varchar(50) NOT NULL,
  `geo_location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plottypes`
--

INSERT INTO `plottypes` (`plot_type_id`, `plot_type_name`, `geo_location`, `service_id`) VALUES
(1, 'Apartment_1', ' [\r\n      [\r\n        121.0254534,\r\n        14.5775078\r\n      ],\r\n      [\r\n        121.0255499,\r\n        14.5772872\r\n      ],\r\n      [\r\n        121.0256063,\r\n        14.577308\r\n      ],\r\n      [\r\n        121.0255076,\r\n        14.57753\r\n      ],\r\n      [\r\n        121.0254542,\r\n        14.5775085\r\n      ]\r\n    ]', 8),
(2, 'Apartment_2', '[\r\n      [\r\n        121.0255231,\r\n        14.5775393\r\n      ],\r\n      [\r\n        121.0256224,\r\n        14.5773106\r\n      ],\r\n      [\r\n        121.0256605,\r\n        14.5773337\r\n      ],\r\n      [\r\n        121.0255703,\r\n        14.5775528\r\n      ],\r\n      [\r\n        121.0255151,\r\n        14.5775442\r\n      ]\r\n    ]', 8),
(3, 'Columbarium_1', ' [\r\n      [\r\n        121.0260547,\r\n        14.5783398\r\n      ],\r\n      [\r\n        121.0261325,\r\n        14.5781478\r\n      ],\r\n      [\r\n        121.0261674,\r\n        14.5781582\r\n      ],\r\n      [\r\n        121.0260944,\r\n        14.5783575\r\n      ],\r\n      [\r\n        121.0260574,\r\n        14.578345\r\n      ]\r\n    ]', 2),
(4, 'Columbarium_2', ' [\r\n      [\r\n        121.0259421,\r\n        14.5782698\r\n      ],\r\n      [\r\n        121.0260199,\r\n        14.5780725\r\n      ],\r\n      [\r\n        121.0260521,\r\n        14.5780751\r\n      ],\r\n      [\r\n        121.025977,\r\n        14.5782724\r\n      ],\r\n      [\r\n        121.0259421,\r\n        14.5782724\r\n      ]\r\n    ]', 2),
(5, 'Exclusive Lot/Niches', '', 9);

-- --------------------------------------------------------

--
-- Table structure for table `renewals`
--

CREATE TABLE `renewals` (
  `renewal_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `fee_code` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_proof` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `renewals`
--

INSERT INTO `renewals` (`renewal_id`, `status_id`, `reservation_id`, `created_at`, `updated_at`, `user_id`, `fee_code`, `amount`, `payment_method_id`, `payment_proof`) VALUES
(3, 3, 35, '2025-01-01 10:43:01', '2025-01-01 11:53:07', 1, 'C1-N-APT', '4200.00', 1, 'mapPH.png');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plot_code` varchar(50) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deceased_id` int(11) DEFAULT NULL,
  `holder_name` varchar(50) NOT NULL,
  `holder_address` varchar(255) NOT NULL,
  `holder_phone` varchar(50) NOT NULL,
  `holder_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `plot_code`, `payment_method_id`, `payment_proof`, `status_id`, `created_at`, `deceased_id`, `holder_name`, `holder_address`, `holder_phone`, `holder_email`) VALUES
(35, 1, 'Apartment_1-C1-R2-C3', 1, '../uploads/mapPH1.png', 3, '2025-01-01 10:21:37', 11, 'Some One', 'Trial Address', '0123456789', 'user@email.com'),
(36, 1, 'Exclusive-015', 1, '../uploads/mapPH.png', 3, '2025-01-02 00:02:48', 12, 'Some Two', 'Trial Address', '0123456789', 'user@email.com'),
(37, 1, 'Apartment_1-A1-R2-C1', 1, '../uploads/p3.png', 1, '2025-01-03 05:28:02', 13, '', '', '', ''),
(38, 1, 'Apartment_1-B1-R1-C3', 1, '../uploads/mapPH1.png', 1, '2025-01-03 05:30:23', 13, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `reservationstatuses`
--

CREATE TABLE `reservationstatuses` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservationstatuses`
--

INSERT INTO `reservationstatuses` (`status_id`, `status_name`) VALUES
(1, 'new'),
(2, 'approved'),
(3, 'cancelled'),
(4, 'pending'),
(5, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_details`
--

CREATE TABLE `reservation_details` (
  `reservation_detail_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `fee_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation_details`
--

INSERT INTO `reservation_details` (`reservation_detail_id`, `reservation_id`, `service_id`, `amount`, `start_date`, `end_date`, `fee_code`) VALUES
(8, 35, 8, '0.00', '2022-10-15', NULL, 'C1-N-APT'),
(9, 36, 9, '0.00', '2022-09-20', NULL, 'A1-N-EXCL'),
(10, 37, 8, '0.00', '0000-00-00', NULL, 'A1-N-APT'),
(11, 38, 8, '0.00', '0000-00-00', NULL, 'B1-N-APT');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_type_id`) VALUES
(1, 'Chapel', 1),
(2, 'Columbarium', 2),
(4, 'Burial / Exhumation / Restus', 3),
(5, 'Entrance / Transfer', 3),
(6, 'Cremation, Bones', 4),
(7, 'Cremation Apartment', 4),
(8, 'Apartment Niches', 5),
(9, 'Exclusive Lot/Niches', 5);

-- --------------------------------------------------------

--
-- Table structure for table `servicetypes`
--

CREATE TABLE `servicetypes` (
  `service_type_id` int(11) NOT NULL,
  `service_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `servicetypes`
--

INSERT INTO `servicetypes` (`service_type_id`, `service_type_name`) VALUES
(5, 'Cemetery'),
(1, 'Chapel'),
(2, 'Columbarium'),
(4, 'Crematorium'),
(3, 'Funeral Service');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'User', 'Trial', 'user@email.com', '$2y$10$/KTDwWK83t8N3i99iTS9FuRU0RN.T5jiEVUNRPqbNUajWfyFTD4t6', 'active', '2024-12-23 09:44:56', '2024-12-23 09:44:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deceased_info`
--
ALTER TABLE `deceased_info`
  ADD PRIMARY KEY (`deceased_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`payment_method_id`),
  ADD UNIQUE KEY `payment_method_name` (`payment_method_name`);

--
-- Indexes for table `plots`
--
ALTER TABLE `plots`
  ADD PRIMARY KEY (`plot_id`),
  ADD UNIQUE KEY `plot_code` (`plot_code`),
  ADD KEY `plot_type_id` (`plot_type_id`),
  ADD KEY `service_type_id` (`service_type_id`),
  ADD KEY `deceased_id` (`deceased_id`),
  ADD KEY `plots_ibfk_5` (`service_id`),
  ADD KEY `plots_ibfk_6` (`reservation_id`);

--
-- Indexes for table `plottypes`
--
ALTER TABLE `plottypes`
  ADD PRIMARY KEY (`plot_type_id`);

--
-- Indexes for table `renewals`
--
ALTER TABLE `renewals`
  ADD PRIMARY KEY (`renewal_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `fk_deceased_id` (`deceased_id`);

--
-- Indexes for table `reservationstatuses`
--
ALTER TABLE `reservationstatuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `reservation_details`
--
ALTER TABLE `reservation_details`
  ADD PRIMARY KEY (`reservation_detail_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `service_type_id` (`service_type_id`);

--
-- Indexes for table `servicetypes`
--
ALTER TABLE `servicetypes`
  ADD PRIMARY KEY (`service_type_id`),
  ADD KEY `service_type_name` (`service_type_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deceased_info`
--
ALTER TABLE `deceased_info`
  MODIFY `deceased_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `plots`
--
ALTER TABLE `plots`
  MODIFY `plot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `plottypes`
--
ALTER TABLE `plottypes`
  MODIFY `plot_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `renewals`
--
ALTER TABLE `renewals`
  MODIFY `renewal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reservationstatuses`
--
ALTER TABLE `reservationstatuses`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservation_details`
--
ALTER TABLE `reservation_details`
  MODIFY `reservation_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `servicetypes`
--
ALTER TABLE `servicetypes`
  MODIFY `service_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plots`
--
ALTER TABLE `plots`
  ADD CONSTRAINT `plots_ibfk_1` FOREIGN KEY (`plot_type_id`) REFERENCES `plottypes` (`plot_type_id`),
  ADD CONSTRAINT `plots_ibfk_2` FOREIGN KEY (`service_type_id`) REFERENCES `servicetypes` (`service_type_id`),
  ADD CONSTRAINT `plots_ibfk_4` FOREIGN KEY (`deceased_id`) REFERENCES `deceased_info` (`deceased_id`),
  ADD CONSTRAINT `plots_ibfk_5` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `plots_ibfk_6` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`);

--
-- Constraints for table `renewals`
--
ALTER TABLE `renewals`
  ADD CONSTRAINT `renewals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `renewals_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `reservationstatuses` (`status_id`),
  ADD CONSTRAINT `renewals_ibfk_3` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_deceased_id` FOREIGN KEY (`deceased_id`) REFERENCES `deceased_info` (`deceased_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `paymentmethods` (`payment_method_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `reservationstatuses` (`status_id`);

--
-- Constraints for table `reservation_details`
--
ALTER TABLE `reservation_details`
  ADD CONSTRAINT `reservation_details_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`),
  ADD CONSTRAINT `reservation_details_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`service_type_id`) REFERENCES `servicetypes` (`service_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
