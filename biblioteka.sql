-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Sty 2021, 23:20
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `biblioteka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ksiazki`
--

CREATE TABLE `ksiazki` (
  `nr_inw` int(10) UNSIGNED NOT NULL,
  `autor` varchar(28) COLLATE utf8_bin NOT NULL,
  `tytul` varchar(90) COLLATE utf8_bin NOT NULL,
  `dzial` varchar(40) COLLATE utf8_bin NOT NULL,
  `data_wlaczenia` date DEFAULT NULL,
  `dostepna` set('Tak','Nie') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `ksiazki`
--

INSERT INTO `ksiazki` (`nr_inw`, `autor`, `tytul`, `dzial`, `data_wlaczenia`, `dostepna`) VALUES
(1, 'Henryk Sienkiewicz', 'Krzyżacy', 'lektury', '2010-08-18', 'Tak'),
(2, 'Stanisław wyspiański', 'Wesele', 'lektury', '2010-08-18', 'Nie'),
(3, 'Andrzej Sapkowski', 'Ostatnie życzenie', 'fantastyka', '0000-00-00', 'Tak'),
(4, 'Bracia Grim', 'Bajki', 'Bajki', '2020-01-15', 'Tak'),
(6, 'Jan Brzechwa', 'Akademia Pana Kleksa', 'lektury', '2020-01-15', 'Nie'),
(7, 'J.R.R Tolkien', 'Hobbit, czyli tam i spowrotem', 'fantastyka', '2020-01-15', 'Nie'),
(8, 'J.R.R Tolkien', 'Hobbit, czyli tam i spowrotem', 'fantastyka', '2020-01-15', 'Nie'),
(9, 'Henryk Sienkiewicz', 'Quo Vadis', 'powieści', '2020-01-16', 'Nie'),
(10, 'J.K. Rownling', 'Harry Potter', 'fantastyka', '2020-01-17', 'Nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `id_nauczyciel` int(10) UNSIGNED NOT NULL,
  `haslo` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `imie` varchar(13) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PESEL` int(12) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Zrzut danych tabeli `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciel`, `haslo`, `imie`, `nazwisko`, `PESEL`) VALUES
(4, '$2y$10$ZlxOcfD.Gg59FAvW0LDUvuJI.CJe.AX69zil3.4KZ72aAGjZ4hO.G', 'Małgorzata', 'Mazur', 4294967295),
(5, '$2y$10$6pRSMURhTqKrJ22gtlebjuwO1TjKJKZqn.fuE3DId8v0Qx0HS1Q2G', 'Dorota', 'Kupis', 4294967295),
(6, '$2y$10$UBBl29GtNHoUClH9AMhYHe6lSIGzgKXVPFgA8eWSsMjsjGkZJiSJq', 'Katarzyna', 'Popiel', 4294967295);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

CREATE TABLE `uczniowie` (
  `id_ucz` varchar(5) COLLATE utf8_bin NOT NULL,
  `haslo` varchar(100) COLLATE utf8_bin NOT NULL,
  `imie` varchar(12) COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(20) COLLATE utf8_bin NOT NULL,
  `klasa` varchar(5) COLLATE utf8_bin NOT NULL,
  `ilosc_ksiazek` int(11) NOT NULL DEFAULT 0,
  `data_ur` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `uczniowie`
--

INSERT INTO `uczniowie` (`id_ucz`, `haslo`, `imie`, `nazwisko`, `klasa`, `ilosc_ksiazek`, `data_ur`) VALUES
('112', '$2y$10$W72vDOBRXD8rljmZjZHE8uXb1MMABxey6abtB9hblgUKCPnKbRITS', 'Adaś', 'Niezgódka', 'IIb', 1, '2012-09-09'),
('15', 'hasla3', 'Damian', 'Itestovsky', '2T', 0, NULL),
('210', '$2y$10$2eJZvszinJL6MilVJTwFPOURzY1lA5/zQ6cOHRrSyp6w9k14abpEG', 'Kamil', 'Adamiec', 'II', 0, '2010-12-31'),
('413a', '$2y$10$J8zXQha4RKocbxZHGN/C2.SQ6nK2BImgd0NJYviNeRfVDfOHDW36e', 'Agata', 'Kupis', 'IVa', 0, '2008-05-21'),
('432', '$2y$10$4yCpTMUJ.odAVLV7mEGaTeWUmUBry2HNT3cbqObksJ/XNb8DjeFmG', 'Marzena', 'Szewczyk', 'VIII', 0, '0000-00-00'),
('450', '$2y$10$ISw665aR1Aj7k4MBAPMZd.riZ3V1Sw0/cy2fUNCRD.f8ckFTpqVs6', 'Anna', 'Zawodnik', 'VI', 0, '2005-11-23'),
('513', '$2y$10$XEvHMAYIFQAJsAqo06TV4ug/B1fqhEb9nyg9zQVyqaTDSkrGMrSAC', 'Agata', 'Rogala', 'VI', 0, '2009-09-06'),
('611', '$2y$10$gfnmY2XHErzt6xfG0kV9C.Rx7qHAEOvRrVAlKNrlIy36OJ8ZgEZju', 'Marcin', 'Kramek', 'VIa', 0, '2009-05-06'),
('621', '$2y$10$WoBWY5igiYbCr/tkRzV8buhLfCemSkGUyOxQhNxnCNKpBjjP4IAtK', 'Adrianna', 'Opalska', 'VI', 0, '2008-03-03'),
('666', '$2y$10$3MAtv8GEMYXOWvC.bfEX/u6OI46NkEaCFiF.8t3/MWB3o1FNOaT4e', 'Adrian', 'Kultys', 'VI', 2, '2008-05-21'),
('677', '$2y$10$9tX36iGaSh6ePM81IbeifexGIPDJxBbg0U9nvMnm8oiHOQNdcvdn.', 'Sebastian', 'Mazisz', 'V', 4, '2008-12-31'),
('733', '$2y$10$hWV8vKdERlicq9CnsQvlhuaA4kNwnfg/fs5DeZJpVVIXBojr3OCvm', 'test', 'test', 'YII', 0, '2001-10-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `id_wypozyczenia` int(10) NOT NULL,
  `id_ucz` varchar(5) COLLATE utf8_bin NOT NULL,
  `id_inw` int(10) UNSIGNED NOT NULL,
  `data_wypozyczenia` date NOT NULL,
  `data_zwrotu` date DEFAULT NULL,
  `id_nauczyciela` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `wypozyczenia`
--

INSERT INTO `wypozyczenia` (`id_wypozyczenia`, `id_ucz`, `id_inw`, `data_wypozyczenia`, `data_zwrotu`, `id_nauczyciela`) VALUES
(1, '513', 1, '2020-01-14', '2020-01-15', 1),
(2, '513', 2, '2020-01-14', '2020-01-16', 1),
(6, '666', 2, '2020-01-16', NULL, 4),
(7, '666', 1, '2020-01-16', '2020-01-16', 4),
(8, '289', 4, '2020-01-16', '2020-01-16', 4),
(9, '677', 4, '2020-01-16', NULL, 4),
(10, '413a', 7, '2020-01-16', NULL, 4),
(11, '677', 8, '2020-01-16', NULL, 4),
(12, '112', 9, '2020-01-16', NULL, 4),
(13, '314', 6, '2020-01-16', NULL, 4),
(14, '677', 10, '2020-01-17', NULL, 4);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  ADD PRIMARY KEY (`nr_inw`);

--
-- Indeksy dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`id_nauczyciel`);

--
-- Indeksy dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD PRIMARY KEY (`id_ucz`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`id_wypozyczenia`),
  ADD KEY `id_ucz` (`id_ucz`),
  ADD KEY `id_nauczyciela` (`id_nauczyciela`),
  ADD KEY `id_inw` (`id_inw`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  MODIFY `nr_inw` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciel` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `id_wypozyczenia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
