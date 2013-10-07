-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 29 2013 г., 10:26
-- Версия сервера: 5.5.29-log
-- Версия PHP: 5.3.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii_greenlegacy`
--

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `type_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `date` int(15) NOT NULL DEFAULT '0',
  `del` int(1) NOT NULL DEFAULT '0',
  `action_id` int(15) DEFAULT NULL,
  `item_id` int(15) DEFAULT NULL,
  `catalog` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_id` (`type_id`),
  KEY `user_id` (`user_id`),
  KEY `action_id` (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `type_id`, `user_id`, `date`, `del`, `action_id`, `item_id`, `catalog`) VALUES
(11, 5, 13, 1369819537, 0, 6, 42, 'plantrequest'),
(12, 5, 14, 1369819537, 0, 7, 42, 'plantrequest');

-- --------------------------------------------------------

--
-- Структура таблицы `notifications_actions`
--

DROP TABLE IF EXISTS `notifications_actions`;
CREATE TABLE IF NOT EXISTS `notifications_actions` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `type_id` int(15) NOT NULL,
  `key_word` varchar(25) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `mesage` text NOT NULL,
  `template` varchar(25) DEFAULT '',
  `copy_sender` varchar(25) DEFAULT '',
  `del` int(1) NOT NULL DEFAULT '0',
  `send_from` varchar(25) NOT NULL DEFAULT '',
  `to_user` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`key_word`),
  KEY `notification_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `notifications_actions`
--

INSERT INTO `notifications_actions` (`id`, `type_id`, `key_word`, `subject`, `mesage`, `template`, `copy_sender`, `del`, `send_from`, `to_user`) VALUES
(1, 2, 'mail', 'Регистраци прошла', 'тут будет текст', '', '', 0, '', NULL),
(2, 2, 'info', 'Поздравляем с регистраций', 'тут будет текст уведоблен', '', '', 0, '', NULL),
(3, 1, 'mail', 'Подтвережение регистраиции', 'Тут будет текст и ссылка ', '', '', 0, '', NULL),
(4, 3, 'mail', 'Запрос на востановление пароля', 'Тут будет текст о востановления пароля и тут будет ссылка', '', '', 0, '', NULL),
(5, 4, 'mail', 'Пароль успешно сохранен', 'Новый пароль успешно сохранен', '', '', 0, '', NULL),
(6, 5, 'info', 'Ваш заказ успешно сохранен', 'На сайт добавили новый заказ.', '', '', 0, '', NULL),
(7, 5, 'info', 'Добавление нового заказа', 'Уведимоление, на сайт поступил новый заказ', '', '', 0, '', 'shiga_2004@mail.ru'),
(9, 5, 'mail', 'Добавление нового заказа', 'Уведимоление, на сайт поступил новый заказ', '', '', 0, '', 'shiga_2004@mail.ru'),
(10, 5, 'mail', 'Ваш заказ успешно сохранен', 'На сайт добавили новый заказ.', '', '', 0, '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications_type`
--

DROP TABLE IF EXISTS `notifications_type`;
CREATE TABLE IF NOT EXISTS `notifications_type` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `key` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `del` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `notifications_type`
--

INSERT INTO `notifications_type` (`id`, `key`, `name`, `del`) VALUES
(1, 'registration_confirm', 'Подтвержедение регистраци', 0),
(2, 'registration_successfully', 'Успешная регистрация', 0),
(3, 'lostpassword_request', 'Запрос на восстановление ', 0),
(4, 'lostpassword_save', 'Сохранение смены пароля', 0),
(5, 'add_order', 'Добавление заказа', 0),
(6, 'pay_order', 'Оплата заказа', 0),
(7, 'finish_order', 'Отработка заказа', 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `catalog_users` (`id`),
  ADD CONSTRAINT `notifications_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `notifications_type` (`id`),
  ADD CONSTRAINT `notifications_ibfk_5` FOREIGN KEY (`action_id`) REFERENCES `notifications_actions` (`id`);

--
-- Ограничения внешнего ключа таблицы `notifications_actions`
--
ALTER TABLE `notifications_actions`
  ADD CONSTRAINT `notifications_actions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `notifications_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
