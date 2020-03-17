ALTER TABLE `#__formwx_formulario` ADD `recibo` TINYINT NULL AFTER `mail_from_auth`;

CREATE TABLE IF NOT EXISTS `#__formwx_registro_json` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `dados` text NOT NULL,
  `id_formulario` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
