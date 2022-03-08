-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2022 at 04:39 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tip` int(11) DEFAULT NULL,
  `tipo` varchar(5) DEFAULT 'Cash',
  `date` datetime NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `cita` datetime NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `menssage` text,
  `userid` int(11) NOT NULL,
  `currentdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tiempoEstimado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `citas`
--
DELIMITER $$
CREATE TRIGGER `after_delete_citas` BEFORE DELETE ON `citas` FOR EACH ROW BEGIN
	 DECLARE NEGOCIO VARCHAR(50);
     SELECT business INTO NEGOCIO FROM users WHERE iduser = old.userid;
	INSERT INTO history(iduser,idregistro,tabla,cita,nombre,tel,mensaje,fecha,fechareserva,duracioncita,businesses)	VALUES(old.userid,old.id,"citas",old.cita,old.name,old.phone,old.menssage,now(),old.currentdate,old.tiempoEstimado,NEGOCIO);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `idhistory` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idregistro` int(11) NOT NULL,
  `tabla` varchar(50) NOT NULL,
  `cita` datetime NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechareserva` datetime NOT NULL,
  `duracioncita` int(11) NOT NULL,
  `businesses` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `idpolicy` int(11) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `dates` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `businesses` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Politicas de los negocios';

-- --------------------------------------------------------

--
-- Table structure for table `ratingclients`
--

CREATE TABLE `ratingclients` (
  `idrating` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `good` int(11) DEFAULT NULL,
  `bad` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idappt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `pass` mediumtext,
  `percent` int(2) NOT NULL DEFAULT '60',
  `business` varchar(50) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'enabled',
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL DEFAULT 'personal',
  `periodo` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `open` time NOT NULL DEFAULT '08:00:00',
  `close` time NOT NULL DEFAULT '20:00:00',
  `passcode` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `iduser` int(11) NOT NULL,
  `percent` int(3) NOT NULL DEFAULT '60',
  `business` varchar(50) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'enabled',
  `type` varchar(10) NOT NULL DEFAULT 'personal',
  `periodo` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `open` time NOT NULL DEFAULT '08:00:00',
  `close` time NOT NULL DEFAULT '20:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`userid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`idhistory`),
  ADD KEY `business` (`businesses`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`idpolicy`),
  ADD KEY `businesses` (`businesses`);

--
-- Indexes for table `ratingclients`
--
ALTER TABLE `ratingclients`
  ADD PRIMARY KEY (`idrating`),
  ADD UNIQUE KEY `idappt` (`idappt`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `user` (`user`,`email`,`phone`),
  ADD KEY `business` (`business`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD KEY `iduser` (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `idhistory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `idpolicy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ratingclients`
--
ALTER TABLE `ratingclients`
  MODIFY `idrating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `policies_ibfk_1` FOREIGN KEY (`businesses`) REFERENCES `users` (`business`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
