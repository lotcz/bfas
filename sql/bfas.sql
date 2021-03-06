DROP TABLE IF EXISTS `user_sessions` ;
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `user_password_hash` VARCHAR(255) NOT NULL,
  `user_failed_attempts` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `users_email_unique` (`user_email` ASC),
  UNIQUE INDEX `users_login_unique` (`user_login` ASC))
ENGINE = InnoDB;

DROP TABLE IF EXISTS `user_sessions` ;

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `user_session_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_token_hash` VARCHAR(255) NOT NULL,
  `user_session_user_id` INT(10) UNSIGNED NOT NULL,
  `user_session_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_session_expires` TIMESTAMP NOT NULL,
  PRIMARY KEY (`user_session_id`),
  CONSTRAINT `user_session_user_fk`
    FOREIGN KEY (`user_session_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `vouchers` ;

CREATE TABLE IF NOT EXISTS `vouchers` (
  `voucher_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `voucher_code` CHAR(4) NOT NULL,
  `voucher_customer_email` VARCHAR(255) NULL,
  `voucher_customer_name` VARCHAR(255) NULL,
  `voucher_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voucher_used` TIMESTAMP NULL,
  PRIMARY KEY (`voucher_id`),
  UNIQUE INDEX `voucher_code_unique` (`voucher_code` ASC)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `claim_attempts` ;

CREATE TABLE IF NOT EXISTS `claim_attempts` (
  `claim_attempt_ip` VARCHAR(15),
  `claim_attempt_count` INT NOT NULL DEFAULT 1,
  `claim_attempt_first` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `claim_attempt_last` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`claim_attempt_ip`),
  INDEX `claim_attempt_last_index` (`claim_attempt_last` DESC)
) ENGINE = InnoDB;