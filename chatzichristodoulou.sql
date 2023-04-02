-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 29 Μαρ 2023 στις 22:47:17
-- Έκδοση διακομιστή: 10.4.27-MariaDB
-- Έκδοση PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `chatzichristodoulou`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `dimos`
--

CREATE TABLE `dimos` (
  `iddimos` int(5) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `idnomos` int(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `dimos`
--

INSERT INTO `dimos` (`iddimos`, `name`, `idnomos`) VALUES
(1, 'ΚΑΤΕΡΙΝΗΣ', 1),
(4, 'ΘΕΣΣΑΛΟΝΙΚΗΣ', 2),
(6, 'ΔΙΟΥ ΟΛΥΜΠΟΥ', 1),
(7, 'ΠΥΔΝΑΣ ΚΟΛΙΝΔΡΟΥ', 1),
(8, 'ΒΕΡΟΙΑΣ', 5),
(9, 'ΚΑΒΑΛΑΣ', 6),
(10, 'ΝΕΣΤΟΥ', 6),
(11, 'ΚΑΛΑΜΑΡΙΑΣ', 2),
(12, 'ΩΡΑΙΟΚΑΣΤΡΟΥ', 2),
(13, 'ΝΑΟΥΣΑΣ', 5),
(14, 'ΑΛΕΞΑΝΔΡΕΙΑΣ', 5);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `dimos`
--
ALTER TABLE `dimos`
  ADD PRIMARY KEY (`iddimos`),
  ADD KEY `iddimos` (`iddimos`),
  ADD KEY `idnomos` (`idnomos`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `dimos`
--
ALTER TABLE `dimos`
  MODIFY `iddimos` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `dimos`
--
ALTER TABLE `dimos`
  ADD CONSTRAINT `dimos_ibfk_1` FOREIGN KEY (`idnomos`) REFERENCES `nomos` (`idnomos`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
