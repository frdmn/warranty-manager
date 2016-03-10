-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2016 at 12:23 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wrnty`
--

-- --------------------------------------------------------

--
-- Table structure for table `warranties`
--

CREATE TABLE IF NOT EXISTS `warranties` (
  `id` int(11) NOT NULL,
  `inventoryNo` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `serialNo` varchar(50) NOT NULL,
  `expiration` date NOT NULL,
  `customerId` int(11) NOT NULL,
  `information` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warranties`
--

INSERT INTO `warranties` (`id`, `inventoryNo`, `label`, `serialNo`, `expiration`, `customerId`, `information`) VALUES
(1, '20533', 'DELL PowerEdge R710', 'DSVC746', '2016-03-29', 0, 'web-prod4'),
(2, '20734', 'DELL Power Vault MD1000', 'DSVC746b', '2017-01-22', 1, 'storage-prod2'),
(3, '21629', 'Apple Thunderbolt Display 27"', 'SC02NW0V61337', '2017-01-28', 2, 'User: frdmn'),
(4, '21630', 'Apple iMac 21,5"', 'SDGKPD0MB1337', '2018-01-19', 3, 'User: example'),
(5, '21631', 'Apple iMac 21,5"', 'SDGKPD0M71337', '2018-01-19', 3, 'User: example2'),
(6, '21621', 'Apple MacBook Pro 15"', 'SC02P25381337', '2018-01-19', 3, 'User: example'),
(7, '21622', 'Apple MacBook Pro 13"', 'SC02P25391337', '2017-01-19', 4, 'User: example2'),
(8, '14647', 'DELL PowerEdge 2950 ', 'DSVC746c', '2016-03-12', 4, 'storage-dev1'),
(9, '14292', 'Lexmark Optra W840n', '0551337', '2016-04-01', 5, 'User: example'),
(10, '20679', 'DELL PowerEdge R410', 'DSVC746d', '2017-05-12', 5, 'hosting.customer.tld');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `warranties`
--
ALTER TABLE `warranties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `warranties`
--
ALTER TABLE `warranties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
