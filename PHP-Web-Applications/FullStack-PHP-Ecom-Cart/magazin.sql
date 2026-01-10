-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 11:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazin`
--

-- --------------------------------------------------------

--
-- Table structure for table `clienti`
--

CREATE TABLE `clienti` (
  `client_id` int(11) NOT NULL,
  `client_username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_pass` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_str` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_oras` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_tara` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_codpost` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_nrcard` int(100) NOT NULL,
  `client_tipcard` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_dataexp` datetime NOT NULL,
  `acceptareemail` int(3) NOT NULL,
  `client_nrinregRC` int(100) NOT NULL,
  `client_nume` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cod_fiscal` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clienti`
--

INSERT INTO `clienti` (`client_id`, `client_username`, `client_pass`, `client_email`, `client_str`, `client_oras`, `client_tara`, `client_codpost`, `client_nrcard`, `client_tipcard`, `client_dataexp`, `acceptareemail`, `client_nrinregRC`, `client_nume`, `cod_fiscal`) VALUES
(1, 'ion.popescu', 'pass123', 'ion@test.com', 'Str. Lalelelor 1', 'Bucuresti', 'Romania', '010000', 12345678, 'Visa', '2025-01-01 00:00:00', 1, 1001, 'Popescu Ion', 5551),
(2, 'maria.ionescu', 'maria99', 'maria@test.com', 'Str. Rozelor 5', 'Cluj', 'Romania', '020000', 87654321, 'Mastercard', '2024-12-31 00:00:00', 1, 1002, 'Ionescu Maria', 5552),
(3, 'george.vasile', 'geo2023', 'geo@test.com', 'Str. Tei 2', 'Timisoara', 'Romania', '030000', 11223344, 'Visa', '2026-05-20 00:00:00', 0, 1003, 'Vasile George', 5553),
(4, 'elena.dumitru', 'elena!1', 'elena@test.com', 'Str. Pacii 10', 'Iasi', 'Romania', '040000', 99887766, 'Maestro', '2024-08-15 00:00:00', 1, 1004, 'Dumitru Elena', 5554),
(5, 'andrei.rad', 'andrei77', 'andrei@test.com', 'Str. Unirii 4', 'Brasov', 'Romania', '050000', 55667788, 'Visa', '2025-11-30 00:00:00', 0, 1005, 'Radu Andrei', 5555);

-- --------------------------------------------------------

--
-- Table structure for table `cos`
--

CREATE TABLE `cos` (
  `cos_id` int(11) NOT NULL,
  `cos_clientID` int(11) NOT NULL,
  `cos_produsID` int(11) NOT NULL,
  `cos_cantitate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cos`
--

INSERT INTO `cos` (`cos_id`, `cos_clientID`, `cos_produsID`, `cos_cantitate`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 2),
(3, 2, 1, 1),
(4, 3, 5, 1),
(5, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ordin`
--

CREATE TABLE `ordin` (
  `ordin_id` int(11) NOT NULL,
  `ordin_prodID` int(11) NOT NULL,
  `ordin_cantit` int(11) NOT NULL,
  `ordin_client_id` int(11) NOT NULL,
  `ordin_dataintr` datetime NOT NULL,
  `ordin_stare` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ordin_shipdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordin`
--

INSERT INTO `ordin` (`ordin_id`, `ordin_prodID`, `ordin_cantit`, `ordin_client_id`, `ordin_dataintr`, `ordin_stare`, `ordin_shipdate`) VALUES
(1, 1, 1, 1, '2023-11-01 10:00:00', 'Livrat', '2023-11-02 14:00:00'),
(2, 2, 2, 2, '2023-11-02 11:30:00', 'In procesare', '2023-11-05 09:00:00'),
(3, 3, 1, 3, '2023-11-03 09:15:00', 'Expediat', '2023-11-04 16:00:00'),
(4, 1, 1, 4, '2023-11-04 14:20:00', 'Anulat', '2023-11-04 15:00:00'),
(5, 5, 3, 5, '2023-11-05 08:45:00', 'Livrat', '2023-11-06 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `parola`
--

CREATE TABLE `parola` (
  `userid` int(11) NOT NULL,
  `pass` varchar(350) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parola`
--

INSERT INTO `parola` (`userid`, `pass`) VALUES
(1, 'a1b2c3d4'),
(2, 'x9y8z7'),
(3, 'parola_sigura'),
(4, 'admin1234'),
(5, 'guest_pass');

-- --------------------------------------------------------

--
-- Table structure for table `produse`
--

CREATE TABLE `produse` (
  `produs_id` int(11) NOT NULL,
  `produs_nume` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_pret` decimal(13,2) NOT NULL,
  `produs_img` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_categ` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_descriere` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_desccompl` varchar(1250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_stare` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `produs_oferta` int(2) NOT NULL,
  `produs_noutati` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produse`
--

INSERT INTO `produse` (`produs_id`, `produs_nume`, `produs_pret`, `produs_img`, `produs_categ`, `produs_descriere`, `produs_desccompl`, `produs_stare`, `produs_oferta`, `produs_noutati`) VALUES
(1, 'Laptop Gaming', 3500.00, 'img1.jpg', 'IT', 'Laptop performant', 'Descriere completa laptop...', 'Nou', 1, 1),
(2, 'Smartphone X', 2000.50, 'img2.jpg', 'Telefoane', 'Smartphone model nou', 'Descriere completa telefon...', 'Nou', 0, 1),
(3, 'Casti Wireless', 150.00, 'img3.jpg', 'Accesorii', 'Casti bluetooth', 'Baterie 20h...', 'Nou', 1, 0),
(4, 'Monitor LED', 800.00, 'img4.jpg', 'Periferice', 'Monitor 24 inch', 'Full HD...', 'Resigilat', 1, 0),
(5, 'Tastatura Mecanica', 250.00, 'img5.jpg', 'Periferice', 'Tastatura RGB', 'Switch-uri rosii...', 'Nou', 0, 0),
(6, 'Telefon Samsung', 2500.00, 'img1.jpg', 'Telefoane', 'Descriere scurta', 'Descriere lunga...', 'Nou', 1, 1),
(7, 'iPhone 13', 4000.00, 'img2.jpg', 'Telefoane', 'Descriere scurta', 'Descriere lunga...', 'Nou', 0, 1),
(8, 'Laptop HP', 3000.00, 'img3.jpg', 'Laptopuri', 'Descriere scurta', 'Descriere lunga...', 'Resigilat', 1, 0),
(9, 'Mouse Gaming', 150.00, 'img4.jpg', 'Periferice', 'Descriere scurta', 'Descriere lunga...', 'Nou', 0, 0),
(10, 'Tastatura', 200.00, 'img5.jpg', 'Periferice', 'Descriere scurta', 'Descriere lunga...', 'Nou', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `situatievizita`
--

CREATE TABLE `situatievizita` (
  `id` int(11) NOT NULL,
  `numepagviz` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `platforma` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `referrer` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` datetime NOT NULL,
  `host` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `situatievizita`
--

INSERT INTO `situatievizita` (`id`, `numepagviz`, `platforma`, `referrer`, `time`, `date`, `host`) VALUES
(1, 'index.php', 'Windows', 'google.com', '2025-12-18 23:55:39', '2023-11-01 10:00:00', 'localhost'),
(2, 'produse.php', 'Android', 'facebook.com', '2025-12-18 23:55:39', '2023-11-01 10:05:00', 'localhost'),
(3, 'contact.php', 'iOS', 'instagram.com', '2025-12-18 23:55:39', '2023-11-01 10:10:00', 'localhost'),
(4, 'cart.php', 'Windows', 'direct', '2025-12-18 23:55:39', '2023-11-01 10:15:00', 'localhost'),
(5, 'checkout.php', 'MacOS', 'google.com', '2025-12-18 23:55:39', '2023-11-01 10:20:00', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'admin123', 'admin@magazin.ro'),
(2, 'editor', 'edit123', 'editor@magazin.ro'),
(3, 'client1', 'pass1', 'client1@yahoo.com'),
(4, 'client2', 'pass2', 'client2@gmail.com'),
(5, 'test', 'test', 'test@test.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `cos`
--
ALTER TABLE `cos`
  ADD PRIMARY KEY (`cos_id`);

--
-- Indexes for table `ordin`
--
ALTER TABLE `ordin`
  ADD PRIMARY KEY (`ordin_id`);

--
-- Indexes for table `parola`
--
ALTER TABLE `parola`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `produse`
--
ALTER TABLE `produse`
  ADD PRIMARY KEY (`produs_id`);

--
-- Indexes for table `situatievizita`
--
ALTER TABLE `situatievizita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clienti`
--
ALTER TABLE `clienti`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cos`
--
ALTER TABLE `cos`
  MODIFY `cos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ordin`
--
ALTER TABLE `ordin`
  MODIFY `ordin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `parola`
--
ALTER TABLE `parola`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produse`
--
ALTER TABLE `produse`
  MODIFY `produs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `situatievizita`
--
ALTER TABLE `situatievizita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
