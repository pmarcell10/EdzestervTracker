-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Ápr 19. 19:11
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `edzes`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `berlet`
--

CREATE TABLE `berlet` (
  `berletid` varchar(100) NOT NULL,
  `tipus` varchar(250) NOT NULL,
  `vasarlas` varchar(250) NOT NULL,
  `alkalmak` varchar(100) NOT NULL,
  `ervenyes` varchar(250) NOT NULL,
  `utolso_nap` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `berlet`
--

INSERT INTO `berlet` (`berletid`, `tipus`, `vasarlas`, `alkalmak`, `ervenyes`, `utolso_nap`) VALUES
('bevt76', '\r\nDi&aacute;k fitness havi tags&aacute;gi\r\n				', '\r\n2021.04.06. - 17:41\r\n				', '5', '\r\n2021.04.06. - 2021.05.03.\r\n				', '2020-05-25');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `edzesek`
--

CREATE TABLE `edzesek` (
  `id` int(11) NOT NULL,
  `nev` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `edzesek`
--

INSERT INTO `edzesek` (`id`, `nev`) VALUES
(0, '-'),
(1, 'Váll'),
(2, 'Tricepsz'),
(3, 'Bicepsz'),
(4, 'Hát'),
(5, 'Mell'),
(6, 'Láb'),
(7, 'Has'),
(8, 'Vádli'),
(9, 'Kardió'),
(10, 'Pihenő'),
(11, 'Pingpong');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `s_edzesek`
--

CREATE TABLE `s_edzesek` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `nev` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `s_edzesek`
--

INSERT INTO `s_edzesek` (`id`, `userid`, `nev`) VALUES
(32, 20, 'küzdősport');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tervek`
--

CREATE TABLE `tervek` (
  `userid` int(11) NOT NULL,
  `terv` varchar(500) NOT NULL,
  `start` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `tervek`
--

INSERT INTO `tervek` (`userid`, `terv`, `start`) VALUES
(20, '-,Kardió,-|Tricepsz,-,-|Bicepsz,-,-|Pihenő,-,-|Pihenő,-,-|Pihenő,-,-|Pihenő,-,-|', 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `berletid` varchar(64) NOT NULL,
  `last_alkalom` int(11) NOT NULL,
  `felosztas` int(11) NOT NULL,
  `permission` int(10) NOT NULL,
  `terv_set` int(1) NOT NULL,
  `rotation` int(1) NOT NULL,
  `utolso_nap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fname`, `lname`, `berletid`, `last_alkalom`, `felosztas`, `permission`, `terv_set`, `rotation`, `utolso_nap`) VALUES
(20, 'pmarcell50@gmail.com', 'Ab12345', 'Pásztor', 'Marcell', 'bevt76', 8, 7, 0, 1, 1, '2020-05-28');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `berlet`
--
ALTER TABLE `berlet`
  ADD PRIMARY KEY (`berletid`);

--
-- A tábla indexei `edzesek`
--
ALTER TABLE `edzesek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `s_edzesek`
--
ALTER TABLE `s_edzesek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tervek`
--
ALTER TABLE `tervek`
  ADD PRIMARY KEY (`userid`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `s_edzesek`
--
ALTER TABLE `s_edzesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
