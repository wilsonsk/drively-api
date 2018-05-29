CREATE TABLE `companies`(
	`id` int(11) unsigned not null auto_increment,
	`name` varchar(150) not null,
	`code` text not null,
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` VARCHAR(70) NOT NULL,
  `last_update` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` VARCHAR(70) NOT NULL,
	PRIMARY KEY(`id`),
	INDEX `list_idx` (`name`),
	UNIQUE KEY (`name`)
)ENGINE=InnoDB;

CREATE TABLE `drivers`(
	`id` int(11) unsigned not null auto_increment,
	`username` varchar(150) not null,
	`passwd` varchar(15) not null,
	`company_fk` INT(11) NOT NULL,
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_by` VARCHAR(70) NOT NULL,
  `last_update` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` VARCHAR(70) NOT NULL,
	PRIMARY KEY(`id`),
	INDEX `list_idx` (`username`),
	UNIQUE KEY (`username`, `passwd`, `company_fk`)
)ENGINE=InnoDB;
