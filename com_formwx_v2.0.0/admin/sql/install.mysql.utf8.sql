

CREATE TABLE IF NOT EXISTS `#__formwx_formulario` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(45) NOT NULL,
	`imagem` VARCHAR(45) NULL,
        `email_to` VARCHAR(100) NULL,
	`informacoes`   mediumtext NULL,
        `outras_informacoes` varchar(255) DEFAULT NULL,
        `mail_from_auth` TINYINT NULL,
	`recibo` TINYINT NULL,
        `feedback_message` TEXT NULL,
        `button_text` VARCHAR(100) NULL,
        `info_after_form` TEXT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	DEFAULT CHARSET =utf8;




CREATE TABLE IF NOT EXISTS `#__formwx_campo` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(45) NOT NULL,
	`tipo` VARCHAR(100) NULL,
        `options` text  DEFAULT NULL,
	`rotulo` VARCHAR(45) NOT NULL,
        `descricao` varchar(100) DEFAULT NULL,
	`requerido` tinyint(3) NOT NULL DEFAULT 0,
       	`id_formulario`   int(11) NOT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	DEFAULT CHARSET =utf8;

CREATE TABLE IF NOT EXISTS `#__formwx_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_campo` int(11) NOT NULL,
  `valor` text NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `#__formwx_registro_json` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `dados` text NOT NULL,
  `id_formulario` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


