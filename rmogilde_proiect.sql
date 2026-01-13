-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost:3306
-- Timp de generare: ian. 13, 2026 la 12:56 PM
-- Versiune server: 8.0.44
-- Versiune PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `rmogilde_proiect`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `donatii`
--

CREATE TABLE `donatii` (
  `id` int NOT NULL,
  `id_utilizator` int NOT NULL,
  `id_proiect` int NOT NULL,
  `suma` decimal(10,2) NOT NULL,
  `data_donatie` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `donatii`
--

INSERT INTO `donatii` (`id`, `id_utilizator`, `id_proiect`, `suma`, `data_donatie`) VALUES
(1, 2, 6, 100.00, '2026-01-12 10:39:37'),
(2, 2, 7, 400.00, '2026-01-12 10:39:43'),
(3, 6, 8, 60.00, '2026-01-12 10:40:11'),
(4, 7, 7, 670.00, '2026-01-12 10:41:08');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `proiecte`
--

CREATE TABLE `proiecte` (
  `id` int NOT NULL,
  `titlu` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descriere` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_inceput` date NOT NULL,
  `buget` decimal(10,2) NOT NULL,
  `data_crearii` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `proiecte`
--

INSERT INTO `proiecte` (`id`, `titlu`, `descriere`, `data_inceput`, `buget`, `data_crearii`) VALUES
(6, 'Plantare de copaci', 'Plantare de copaci în parcul IOR din București.', '2026-02-01', 300.00, '2026-01-12 10:33:33'),
(7, 'Salvează un câine din adăpost', 'Parteneriat cu asociația pentru animale ASPA pentru realizarea unui târg care are ca scop adopția de animale.', '2026-01-22', 2000.00, '2026-01-12 10:36:20'),
(8, 'Viitorul pe care îl merităm', 'Prin acest proiect se dorește implementarea Obiectivelor de Dezvoltare Durabilă din agenda Comisiei Europene', '2025-11-01', 300.00, '2026-01-12 10:39:02');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int NOT NULL,
  `nume_complet` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `parola` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'voluntar',
  `data_inregistrarii` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume_complet`, `email`, `parola`, `rol`, `data_inregistrarii`) VALUES
(2, 'Mogîldea', 'rmmog@rmogildea.daw.ssmr.ro', '$2y$10$aWPZ5zR3FPI6and841/1LudXruil0CfjOTjWy7UQIjZXLs8B9Amda', 'admin', '2025-12-10 17:19:57'),
(6, 'Raluca', 'mogildearalucamaria@gmail.com', '$2y$10$y4YVmDinJEVF6Dm8.Sn0j.K90bcLFMJcFiQ6hzbAb8UdjnsJZ/t/.', 'voluntar', '2026-01-12 10:22:28'),
(7, 'Maria', 'raluca@gmail.com', '$2y$10$xMjhx1Mdm5wsrCDYGvX5g./qsH7poaclAdmes9qSmch1DFZFoT/Cu', 'voluntar', '2026-01-12 10:40:30');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `donatii`
--
ALTER TABLE `donatii`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `proiecte`
--
ALTER TABLE `proiecte`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `donatii`
--
ALTER TABLE `donatii`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `proiecte`
--
ALTER TABLE `proiecte`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
