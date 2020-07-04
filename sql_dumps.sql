


ALTER TABLE `users_withdrawals` ADD `payment_month` DATETIME NULL AFTER `completed_at`;





ALTER TABLE `users_withdrawals` ADD `identifier` VARCHAR(255) NULL AFTER `method_details`;
