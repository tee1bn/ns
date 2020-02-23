ALTER TABLE `subscription_payment_orders` ADD `expires_at` DATETIME NULL AFTER `payment_details`, ADD `payment_state` ENUM('automatic','manual','cancelled') NULL AFTER `expires_at`;



ALTER TABLE `users` ADD `address` VARCHAR(255) NULL AFTER `country;
ALTER TABLE `users` ADD `title` INT NULL AFTER `placed`;
ALTER TABLE `companies` ADD `country` INT NULL AFTER `name`;
