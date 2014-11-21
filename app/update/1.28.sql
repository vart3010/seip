ALTER TABLE `seip_user` CHANGE `first_name` `firstname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `seip_user` CHANGE `last_name` `lastname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

UPDATE `seip_indicator` SET `period_id`= 1;
ALTER TABLE seip_indicator ADD typeOfCalculation INT NOT NULL;

-- Data de fecuencia de notificacion
INSERT INTO `seip_c_indicator_frequency_notification` (`id`, `created_at`, `updated_at`, `description`, `textAbbr`, `days`, `enabled`) VALUES
(1, '2014-11-21 09:20:01', '2014-11-21 09:20:01', 'Semanal', 'Semana', 7, 1),
(2, '2014-11-21 09:20:18', '2014-11-21 09:20:18', 'Quincenal', 'Quincena', 15, 1),
(3, '2014-11-21 09:20:29', '2014-11-21 09:20:29', 'Mensual', 'Mes', 30, 1),
(4, '2014-11-21 09:20:49', '2014-11-21 09:20:49', 'Anual', 'Año', 360, 1);