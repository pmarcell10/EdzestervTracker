-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Máj 14. 09:25
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
-- Adatbázis: `d5yzpu`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `completed_orders`
--

CREATE TABLE `completed_orders` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `completed_orders`
--

INSERT INTO `completed_orders` (`id`, `itemid`, `userid`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `cpu` varchar(250) NOT NULL,
  `gpu` varchar(250) NOT NULL,
  `ram` int(16) NOT NULL,
  `ssd` int(16) NOT NULL,
  `price` int(128) NOT NULL,
  `os` tinyint(1) NOT NULL,
  `userid` int(11) NOT NULL,
  `descr` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `items`
--

INSERT INTO `items` (`id`, `cpu`, `gpu`, `ram`, `ssd`, `price`, `os`, `userid`, `descr`) VALUES
(1, 'Intel i9 9900k', 'RTX 2080 ti', 16, 500, 450000, 1, 0, 'Legerősebb PC a kínálatunkban.'),
(2, 'Ryzen 7 3700x', 'GTX 1660ti', 16, 256, 300000, 0, 0, 'Ryzen build gaming-re.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `permission` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fname`, `lname`, `permission`) VALUES
(1, 'admin@pcshop.com', '7af2d10b73ab7cd8f603937f7697cb5fe432c7ff', 'Admin', 'Admin', 2),
(2, 'elado@pcshop.com', '742505eeebdd0083dd290cecea174623a060700a', 'Elado', 'Elado', 1),
(3, 'user@pcshop.com', 'cd027069371cdb4f80c68dcfb37e6f4a1bdb0222', 'User', 'User', 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `completed_orders`
--
ALTER TABLE `completed_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
