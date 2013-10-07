-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 08 2013 г., 20:20
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
-- Структура таблицы `catalog_users`
--

DROP TABLE IF EXISTS `catalog_users`;
CREATE TABLE IF NOT EXISTS `catalog_users` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `cid` int(15) NOT NULL DEFAULT '0',
  `name` varchar(35) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `dateadd` date DEFAULT NULL,
  `dateedit` date DEFAULT NULL,
  `user` int(15) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `fatchname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `country` int(25) NOT NULL,
  `city` int(25) NOT NULL,
  `type` int(5) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `country` (`country`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `catalog_users`
--
ALTER TABLE `catalog_users`
  ADD CONSTRAINT `catalog_users_ibfk_2` FOREIGN KEY (`city`) REFERENCES `catalog_city` (`id`),
  ADD CONSTRAINT `catalog_users_ibfk_1` FOREIGN KEY (`country`) REFERENCES `catalog_country` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
