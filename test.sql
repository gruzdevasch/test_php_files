-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 23 2020 г., 03:34
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `directories`
--

DROP TABLE IF EXISTS `directories`;
CREATE TABLE `directories` (
  `id` mediumint(9) NOT NULL,
  `name` char(30) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `directories`
--

INSERT INTO `directories` (`id`, `name`, `creation_date`, `modification_date`, `description`, `parent_id`) VALUES
(1, 'dir1', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'main directory', NULL),
(2, 'dir2', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'second directory', NULL),
(3, 'dir3', '2020-03-22 08:28:21', '2020-03-22 11:22:44', 'inside directory2', 1),
(18, 'test2', '2020-03-22 10:35:44', '2020-03-22 11:22:28', '56722', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `elements`
--

DROP TABLE IF EXISTS `elements`;
CREATE TABLE `elements` (
  `id` mediumint(9) NOT NULL,
  `directory_id` int(11) DEFAULT NULL,
  `name` char(30) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `type` enum('News','Article','Review','Comment') NOT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `elements`
--

INSERT INTO `elements` (`id`, `directory_id`, `name`, `creation_date`, `modification_date`, `type`, `data`) VALUES
(1, NULL, 'el12', '2020-03-22 08:28:21', '2020-03-22 11:28:00', 'Article', 'lorum epsum'),
(2, 1, 'el2', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'Article', 'test'),
(3, 2, 'el3', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'Review', 'test'),
(4, 3, 'el4', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'Comment', 'Element 4 content'),
(5, 1, 'el5', '2020-03-22 08:28:21', '2020-03-22 08:28:21', 'Comment', 'Element 5 content'),
(31, NULL, '123', '2020-03-22 10:55:00', '2020-03-23 03:01:44', 'News', '444');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `directories`
--
ALTER TABLE `directories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `directories`
--
ALTER TABLE `directories`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `elements`
--
ALTER TABLE `elements`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
