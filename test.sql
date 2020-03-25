-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 25 2020 г., 06:30
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

CREATE TABLE `directories` (
  `id` mediumint(9) NOT NULL,
  `name` char(30) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `directories`
--

INSERT INTO `directories` (`id`, `name`, `creation_date`, `modification_date`, `description`, `parent_id`) VALUES
(1, 'dir1', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'main directory', NULL),
(2, 'dir2', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'second directory', NULL),
(3, 'dir3', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'inside directory', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `elements`
--

CREATE TABLE `elements` (
  `id` mediumint(9) NOT NULL,
  `directory_id` mediumint(9) DEFAULT NULL,
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
(1, NULL, 'el1', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'News', 'lorum epsum'),
(2, 1, 'el2', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'Article', 'test'),
(3, 2, 'el3', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'Review', 'test'),
(4, 3, 'el4', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'Comment', 'Element 4 content'),
(5, 1, 'el5', '2020-03-25 03:01:31', '2020-03-25 03:01:31', 'Comment', 'Element 5 content');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `directories`
--
ALTER TABLE `directories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `directory_id` (`directory_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `directories`
--
ALTER TABLE `directories`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `elements`
--
ALTER TABLE `elements`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `directories`
--
ALTER TABLE `directories`
  ADD CONSTRAINT `directories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `directories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `elements`
--
ALTER TABLE `elements`
  ADD CONSTRAINT `elements_ibfk_1` FOREIGN KEY (`directory_id`) REFERENCES `directories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
