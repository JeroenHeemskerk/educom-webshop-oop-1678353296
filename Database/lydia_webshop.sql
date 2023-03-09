-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 mrt 2023 om 10:14
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lydia_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(20) NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `filename_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `filename_img`) VALUES
(1, 'Featherwand', 'Cat Toys Feather Wand Kitten', '6', 'featherwand.jpg'),
(3, 'Scratching Post', 'Big Scratching Post', '150', 'scratchingpost.jpg'),
(4, 'Water fountain', 'Our favorite overall cat water fountain', '60', 'waterfountain.jpg'),
(5, 'Laser toy', 'For endless fun', '15', 'lasertoy.jpg'),
(6, 'Mouse toy', 'Make your cat feel like a real hunter', '2', 'mousetoy.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`) VALUES
(1, 'testmail@database.nl', 'Pooh', '123'),
(2, 'mier@adres.nl', 'Mina', 'test'),
(3, 'bo@burnham.nl', 'Bo', 'who'),
(4, 'pim@adres.nl', 'Pim', 'nieuw'),
(5, 'pom@adres.nl', 'Pom', 'test2'),
(6, 'ben@adres.nl', 'Ben', 'wow'),
(7, 'mies@adres.nl', 'Mies', '789'),
(10, 'hommel@debommel.nl', 'hommel', 'qwerty'),
(11, 'pien@fop.nl', 'pien', 'changed'),
(12, 'eduardkoops@mail.nl', 'eduard', 'zoem'),
(13, 'lvangammeren@yahoo.co.uk', 'Lydia van Gammeren', 'new'),
(14, 'tover@tv.nl', 'tover', 'nieuw'),
(15, 'uk@puk.eu', 'Uk', '123'),
(16, 'iemand@mail.com', 'Iemand', '123'),
(17, 'lenna@eigenmail.nl', 'Lenna', 'popje'),
(18, 'lvg@mail.eu', 'lvg', 'lvg'),
(19, 'banana@yellow.nl', 'banana', '456'),
(20, 'am@dummy.nl', 'AM', '1234');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
