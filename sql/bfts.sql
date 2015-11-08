USE bfts;

DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC))
ENGINE = InnoDB;

INSERT INTO `users` (`email`, `password`) VALUES ( 'mojemejly@centrum.cz', 'karel123' );

DROP TABLE IF EXISTS `user_sessions` ;

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `session_token` CHAR(50) NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `session_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_expires` TIMESTAMP NOT NULL,
  PRIMARY KEY (`session_token`),
  CONSTRAINT `session_user_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `vouchers` ;

CREATE TABLE IF NOT EXISTS `vouchers` (
  `voucher_code` CHAR(4) NOT NULL,
  `customer_email` VARCHAR(255) NULL,
  `voucher_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voucher_used` TIMESTAMP NULL,
  PRIMARY KEY (`voucher_code`) 
) ENGINE = InnoDB;


