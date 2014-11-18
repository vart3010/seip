ALTER TABLE `seip_user` CHANGE `first_name` `firstname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `seip_user` CHANGE `last_name` `lastname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

UPDATE `seip_indicator` SET `period_id`= 1;
ALTER TABLE seip_indicator ADD typeOfCalculation INT NOT NULL;