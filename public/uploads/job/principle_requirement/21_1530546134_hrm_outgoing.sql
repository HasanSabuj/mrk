-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2018 at 09:28 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pioneer`
--

-- --------------------------------------------------------

--
-- Table structure for table `hrm_outgoing`
--

CREATE TABLE `hrm_outgoing` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `satelment` tinyint(4) NOT NULL COMMENT '1=yes,2=no',
  `pf_calculated` double NOT NULL,
  `pf_given` double NOT NULL,
  `bf_calculated` double NOT NULL,
  `bf_given` double NOT NULL,
  `gratuity_cla` double NOT NULL,
  `gratuity_given` double NOT NULL,
  `earn_leave_calculated` double NOT NULL,
  `earn_leave_given` double NOT NULL,
  `vehical_loan_calculated` double NOT NULL,
  `vehical_loan_given` double NOT NULL,
  `pf_loan_calculated` double NOT NULL,
  `pf_loan_given` double NOT NULL,
  `house_loan_calculated` double NOT NULL,
  `house_loan_given` double NOT NULL,
  `others_loan_calculated` double NOT NULL,
  `others_loan_given` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hrm_outgoing`
--
ALTER TABLE `hrm_outgoing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hrm_outgoing`
--
ALTER TABLE `hrm_outgoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
