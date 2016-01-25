-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2016 at 11:13 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `crt`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int(11) NOT NULL,
  `hostname` varchar(50) NOT NULL,
  `expiration` date NOT NULL,
  `customer` int(11) NOT NULL,
  `usage` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `hostname`, `expiration`, `customer`, `usage`) VALUES
(1, 'webmail.company.com', '2016-01-29', 0, 'Exchange OWA'),
(2, 'tls.startup.ru', '2017-01-22', 1, 'Postfix'),
(3, 'mail.exchange-system.co.uk', '2017-01-28', 2, 'Exchange ETS'),
(4, 'www.bank-of-wuerzburg.de', '2018-01-19', 3, 'Nginx'),
(5, 'bank-of-wuerzburg.de', '2018-01-19', 3, 'Nginx'),
(6, 'crm.bank-of-wuerzburg.de', '2018-01-19', 3, 'Nginx'),
(7, 'international-company.eu', '2017-01-19', 4, 'Nginx'),
(8, 'mail.international-company.eu', '2016-03-12', 4, 'Nginx'),
(9, 'international.hosting', '2015-01-01', 5, 'Apache'),
(10, 'www.bank-of-frankfurt.de', '2017-05-12', 5, 'Nginx');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
