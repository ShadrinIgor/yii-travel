-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 25 2014 г., 07:48
-- Версия сервера: 5.6.14-log
-- Версия PHP: 5.3.27

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii_travel`
--
CREATE DATABASE IF NOT EXISTS `yii_travel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yii_travel`;

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding`
--

DROP TABLE IF EXISTS `ex_winding`;
CREATE TABLE IF NOT EXISTS `ex_winding` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL COMMENT 'Базовый адрес сайта',
  `del` int(1) NOT NULL DEFAULT '0',
  `pos` int(1) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `pageCountMax` int(10) NOT NULL DEFAULT '5' COMMENT 'максимальное количество посещений страниц с одного IP',
  `listStartPage` text NOT NULL COMMENT 'список разделов сайта, с которых поочередно будет начинаться рассылка',
  `listReferalPage` text NOT NULL COMMENT 'список рефиральных сайтов которые будут имитироваться',
  `directСalls` int(1) NOT NULL DEFAULT '25' COMMENT 'процент прямых заходом на сайт, т.е. без реферала',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ex_winding`
--

INSERT INTO `ex_winding` (`id`, `name`, `url`, `del`, `pos`, `active`, `pageCountMax`, `listStartPage`, `listReferalPage`, `directСalls`) VALUES
(1, 'world-travel.uz', 'http://world-travel.uz', 0, 0, 0, 3, 'http://world-travel.uz/sales;\r\nhttp://world-travel.uz/Country;\r\nhttp://world-travel.uz/tours;\r\nhttp://world-travel.uz/hotels;\r\nhttp://world-travel.uz/resorts;\r\nhttp://world-travel.uz/touristInfo', 'http://www.odnoklassniki.ru/; http://www.vk.com/; http://www.facebook.com/; http://www.moikrug.ru/', 25);

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding_proxi`
--

DROP TABLE IF EXISTS `ex_winding_proxi`;
CREATE TABLE IF NOT EXISTS `ex_winding_proxi` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `del` int(1) DEFAULT '0',
  `pos` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding_session`
--

DROP TABLE IF EXISTS `ex_winding_session`;
CREATE TABLE IF NOT EXISTS `ex_winding_session` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `winding_id` int(15) NOT NULL,
  `useragents_id` int(15) NOT NULL,
  `date` int(10) NOT NULL,
  `date_next` int(10) NOT NULL COMMENT 'Дата следующего шага',
  `del` int(1) DEFAULT '0',
  `pos` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `useragents_id` (`useragents_id`),
  KEY `ex_winding_session_ibfk_1` (`winding_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding_stat`
--

DROP TABLE IF EXISTS `ex_winding_stat`;
CREATE TABLE IF NOT EXISTS `ex_winding_stat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `winding_id` int(15) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(10) NOT NULL,
  `del` int(1) DEFAULT '0',
  `pos` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ex_winding_stat_ibfk_1` (`winding_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding_timetable`
--

DROP TABLE IF EXISTS `ex_winding_timetable`;
CREATE TABLE IF NOT EXISTS `ex_winding_timetable` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` int(15) NOT NULL,
  `count_item` int(15) NOT NULL,
  `del` int(1) DEFAULT '0',
  `pos` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ex_winding_useragents`
--

DROP TABLE IF EXISTS `ex_winding_useragents`;
CREATE TABLE IF NOT EXISTS `ex_winding_useragents` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `del` int(1) DEFAULT '0',
  `pos` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ex_winding_session`
--
ALTER TABLE `ex_winding_session`
  ADD CONSTRAINT `ex_winding_session_ibfk_1` FOREIGN KEY (`winding_id`) REFERENCES `ex_winding` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ex_winding_session_ibfk_2` FOREIGN KEY (`useragents_id`) REFERENCES `ex_winding_useragents` (`id`);

--
-- Ограничения внешнего ключа таблицы `ex_winding_stat`
--
ALTER TABLE `ex_winding_stat`
  ADD CONSTRAINT `ex_winding_stat_ibfk_1` FOREIGN KEY (`winding_id`) REFERENCES `ex_winding` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
