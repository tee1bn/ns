



-- for isp compensation and new design --starts
-- update subscitpionplans table
ALTER TABLE `subscription_payment_orders` ADD `payment_breakdown` LONGTEXT NULL AFTER `payment_method`;
ALTER TABLE `orders` ADD `payment_proof` LONGTEXT NULL AFTER `additional_note`;


ALTER TABLE `settlement_tracker` ADD `setup_fee` DECIMAL(20,2) NULL AFTER `settled_license_fee`;


ALTER TABLE `users` ADD `binary_id` BIGINT NULL AFTER `introduced_by`, ADD `enrolment_position` LONGTEXT NULL AFTER `binary_id`, ADD `placement_position` LONGTEXT NULL AFTER `enrolment_position`, ADD `binary_position` LONGTEXT NULL AFTER `placement_position`, ADD `settings` LONGTEXT NULL AFTER `binary_position`;

-- add user_documents, admin_comment, customers support

ALTER TABLE `subscription_payment_orders` ADD `no_of_month` INT NULL AFTER `sent_email`;


ALTER TABLE `companies` CHANGE `rc_number` `vat_number` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'cac rc number';
ALTER TABLE `companies` ADD `rc_number` VARCHAR(255) NULL AFTER `pefcom_id`;

ALTER TABLE `users` CHANGE `address` `address` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `companies` CHANGE `office_email` `office_email` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `companies` ADD `legal_form` VARCHAR(255) NULL AFTER `vat_number`;

-- for isp compensation and new design --ends


ALTER TABLE `users_documents` ADD `label` VARCHAR(255) NULL AFTER `user_id`;
ALTER TABLE `users_documents` CHANGE `document_type` `document_type` INT(11) NULL;

ALTER TABLE `isp_wallet` CHANGE `earning_category` `earning_category` ENUM('bonus','package','disagio','gold','silber','license','silber2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;





ALTER TABLE `subscription_payment_orders` ADD `expires_at` DATETIME NULL AFTER `payment_details`, ADD `payment_state` ENUM('automatic','manual','cancelled') NULL AFTER `expires_at`;



ALTER TABLE `users` ADD `address` VARCHAR(255) NULL AFTER `country;
ALTER TABLE `users` ADD `title` INT NULL AFTER `placed`;
ALTER TABLE `companies` ADD `country` INT NULL AFTER `name`;


INSERT INTO `site_settings` (`id`, `name`, `criteria`, `settings`, `default_setting`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'Subscription Reminder Skip', 'reminder_tracker_skip', NULL, '', NULL, NULL, NULL);
