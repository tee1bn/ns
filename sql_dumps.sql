ALTER TABLE `subscription_payment_orders` ADD `expires_at` DATETIME NULL AFTER `payment_details`, ADD `payment_state` ENUM('automatic','manual','cancelled') NULL AFTER `expires_at`;
