-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 08 2013 г., 20:11
-- Версия сервера: 5.5.24-log
-- Версия PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii-news`
--

-- --------------------------------------------------------

--
-- Структура таблицы `catalog_city`
--

DROP TABLE IF EXISTS `catalog_city`;
CREATE TABLE IF NOT EXISTS `catalog_city` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  `select` int(1) NOT NULL DEFAULT '1',
  `dateadd` date DEFAULT NULL,
  `dateedit` date DEFAULT NULL,
  `pos` int(15) NOT NULL DEFAULT '0',
  `metaData` text,
  `user` int(15) NOT NULL DEFAULT '0',
  `lang_group` int(15) NOT NULL DEFAULT '0',
  `id_lang` int(15) NOT NULL DEFAULT '0',
  `country` int(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `catalog_city`
--
ALTER TABLE `catalog_city`
  ADD CONSTRAINT `catalog_city_ibfk_1` FOREIGN KEY (`country`) REFERENCES `catalog_country` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
