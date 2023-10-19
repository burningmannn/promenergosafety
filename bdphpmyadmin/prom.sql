-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 16 2023 г., 15:14
-- Версия сервера: 5.6.51
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `nameCategory` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id_category`, `nameCategory`) VALUES
(24, 'Антенна'),
(20, 'ИБП'),
(25, 'Коммутатор'),
(28, 'Маршрутизатор'),
(26, 'Монитор'),
(27, 'МФУ'),
(29, 'Ноутбук'),
(1, 'ПК'),
(40, 'ПК ПЕКАКОВ'),
(39, 'Планшет'),
(23, 'Принтер'),
(2, 'Сервер');

-- --------------------------------------------------------

--
-- Структура таблицы `departament`
--

CREATE TABLE `departament` (
  `id_departament` int(11) NOT NULL,
  `nameDepartament` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `departament`
--

INSERT INTO `departament` (`id_departament`, `nameDepartament`) VALUES
(9, 'Информационно-аналитический отдел'),
(2, 'Отдел защиты информации'),
(1, 'Отдел информационных ресурсов и технологий'),
(10, 'Отдел отделов');

-- --------------------------------------------------------

--
-- Структура таблицы `technic`
--

CREATE TABLE `technic` (
  `id` int(11) UNSIGNED NOT NULL,
  `departament` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `inventory` int(11) UNSIGNED NOT NULL,
  `title` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `technic`
--

INSERT INTO `technic` (`id`, `departament`, `category`, `inventory`, `title`) VALUES
(1, 1, 1, 174, 'GEG Prestige 41240A'),
(2, 2, 1, 175, 'GEG Prestige 41240A'),
(3, 2, 1, 176, 'GEG Prestige 41240A	'),
(4, 2, 2, 336, 'GEG Express 200L 155E'),
(5, 1, 24, 418, 'Hengshanlao 1500VA'),
(6, 9, 28, 791, 'CISCO 1760'),
(7, 9, 20, 316, 'BLACK UPS 1500VA'),
(8, 1, 23, 207, 'AUTONOMIC MB 4016'),
(9, 2, 20, 317, 'BLACK UPS 1500VA'),
(10, 1, 25, 796, 'Catalyst'),
(11, 9, 27, 108, 'Xerox Workcentre Pro 128'),
(12, 9, 2, 517, 'IBM x3650 Rack mount 2 U'),
(13, 1, 2, 615, 'IBM x3650 Rack mount 2 U'),
(14, 1, 23, 588, 'Xerox Workcentre Pro 128'),
(15, 1, 23, 589, 'Xerox PHASER'),
(16, 1, 23, 590, 'Xerox PHASER'),
(17, 2, 2, 337, 'IBM System x3650 M2'),
(18, 2, 2, 338, 'IBM System x3650 M2'),
(19, 9, 25, 4813, 'HP StorageWorks 416 SAN'),
(20, 9, 25, 4814, 'HP StorageWorks 416 SAN'),
(21, 9, 1, 244, 'DEPO Neos 430'),
(22, 9, 1, 245, 'DEPO Neos 430'),
(23, 9, 1, 246, 'DEPO Neos 430'),
(24, 1, 1, 335, 'DEPO Neos 430'),
(25, 2, 26, 339, 'DEPO Neos 430'),
(26, 2, 26, 500, 'Acer V193Abm'),
(27, 2, 26, 503, 'Acer V193Abm'),
(28, 1, 1, 504, 'Acer V193Abm'),
(29, 1, 26, 507, 'Acer V193Abm'),
(30, 2, 29, 6242, 'Aquarius Cmp NS735'),
(31, 2, 29, 6250, 'Aquarius Cmp NS735'),
(32, 2, 29, 6255, 'Aquarius Cmp NS735'),
(33, 9, 39, 5961, 'Samsung Galaxy'),
(34, 9, 39, 5959, 'Samsung Galaxy'),
(35, 1, 24, 409, 'Hengshanlao 1500VA'),
(36, 1, 23, 109, 'Xerox Workcentre Pro 128'),
(37, 9, 25, 4815, 'HP StorageWorks 416 SAN'),
(38, 9, 25, 800, 'Catalyst'),
(39, 9, 24, 410, 'Hengshanlao 1500VA');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `login` varchar(25) NOT NULL,
  `pass` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `pass`) VALUES
(1, 'adminpanel', 'adminpanel', 'promenergo2022');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `nameCategory` (`nameCategory`);

--
-- Индексы таблицы `departament`
--
ALTER TABLE `departament`
  ADD PRIMARY KEY (`id_departament`),
  ADD UNIQUE KEY `nameDepartament` (`nameDepartament`);

--
-- Индексы таблицы `technic`
--
ALTER TABLE `technic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory` (`inventory`),
  ADD KEY `departament` (`departament`),
  ADD KEY `category` (`category`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `departament`
--
ALTER TABLE `departament`
  MODIFY `id_departament` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `technic`
--
ALTER TABLE `technic`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `technic`
--
ALTER TABLE `technic`
  ADD CONSTRAINT `technic_ibfk_1` FOREIGN KEY (`departament`) REFERENCES `departament` (`id_departament`),
  ADD CONSTRAINT `technic_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
