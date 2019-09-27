ALTER TABLE `subscription_payment_orders` ADD `payment_method` VARCHAR(255) NULL AFTER `plan_id`, ADD `payment_detail` LONGTEXT NULL AFTER `payment_method`;

ALTER TABLE `site_settings` ADD `description` LONGTEXT NULL AFTER `default_setting`;

ALTER TABLE `site_settings` ADD `name` VARCHAR(255) NULL AFTER `id`;

