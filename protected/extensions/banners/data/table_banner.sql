DROP TABLE IF EXISTS `b_keys`;

DROP TABLE IF EXISTS `b_category`;
CREATE TABLE IF NOT EXISTS `b_category` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `pos` int(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `b_category` (`id`, `name`, `pos`) VALUES(555, 'null', 0);
UPDATE `b_category` SET `id` = '0' WHERE `b_category`.`id` =555;
INSERT INTO `b_category` ( `id` ,`name` ,`pos`)  VALUES (1 , 'Верхние', '1');

DROP TABLE IF EXISTS `b_banners`;
CREATE TABLE IF NOT EXISTS `b_banners` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `image` varchar(50) NOT NULL DEFAULT '',
  `href` varchar(50) DEFAULT '',
  `category` int(15) NOT NULL,
  `default` int(1) DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `del` int(1) NOT NULL DEFAULT '0',
  `width` int(25) DEFAULT NULL,
  `height` int(25) DEFAULT NULL,
  `through` varchar(25) DEFAULT NULL,
  `count_show` int(25) DEFAULT NULL,
  `inner_page` int(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `start_date` varchar(10) DEFAULT NULL,
  `finish_date` varchar(10) DEFAULT NULL,
  `finish_count_show` int(25) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `b_banners`
  ADD CONSTRAINT `b_banners_ibfk_3` FOREIGN KEY (`category`) REFERENCES `b_category` (`id`);

INSERT INTO `b_banners` (`id`, `name`, `image`, `href`, `category`, `default`, `type`, `del`, `width`, `height`, `through`, `count_show`, `inner_page`, `email`, `start_date`, `finish_date`, `finish_count_show`, `active`) VALUES(1, '11', 'f/b_banners/870smiles.swf', 0, 1, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);