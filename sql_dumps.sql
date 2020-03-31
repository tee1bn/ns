



-- for isp compensation and new design --starts
-- update subscitpionplans table

ALTER TABLE `users` ADD `binary_id` BIGINT NULL AFTER `introduced_by`, ADD `enrolment_position` LONGTEXT NULL AFTER `binary_id`, ADD `placement_position` LONGTEXT NULL AFTER `enrolment_position`, ADD `binary_position` LONGTEXT NULL AFTER `placement_position`, ADD `settings` LONGTEXT NULL AFTER `binary_position`;

-- add user_documents, admin_comment, customers support



-- for isp compensation and new design --ends



ALTER TABLE `subscription_payment_orders` ADD `expires_at` DATETIME NULL AFTER `payment_details`, ADD `payment_state` ENUM('automatic','manual','cancelled') NULL AFTER `expires_at`;



ALTER TABLE `users` ADD `address` VARCHAR(255) NULL AFTER `country;
ALTER TABLE `users` ADD `title` INT NULL AFTER `placed`;
ALTER TABLE `companies` ADD `country` INT NULL AFTER `name`;


INSERT INTO `site_settings` (`id`, `name`, `criteria`, `settings`, `default_setting`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'Subscription Reminder Skip', 'reminder_tracker_skip', NULL, '', NULL, NULL, NULL);
