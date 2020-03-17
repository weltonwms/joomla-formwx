ALTER TABLE `#__formwx_formulario` ADD `mail_from_auth` TINYINT NULL AFTER `outras_informacoes`,
ADD `feedback_message` TEXT NULL AFTER `mail_from_auth`, 
ADD `info_after_form` TEXT NULL AFTER `feedback_message`;
