ALTER TABLE `#__formwx_campo` ADD `tipo` VARCHAR(100) NULL AFTER `nome`;
ALTER TABLE `#__formwx_campo` ADD `options` TEXT NULL AFTER `tipo`;
CREATE TABLE IF NOT EXISTS `#__formwx_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_campo` int(11) NOT NULL,
  `valor` text NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
