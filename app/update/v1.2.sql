UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =9;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =10;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =11;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =12;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =13;

INSERT INTO `BaseGroup` (`id`, `name`, `description`, `active`) VALUES
(1, 'General', 'Tiene la configuracion general del sistema', 1),
(2, 'Programa de gestion', 'Contiene la configuracion global del programa de gestion', 1);

INSERT INTO `Configuration` (`id`, `group_id`, `keyIndex`, `value`, `description`, `active`, `createdAt`, `updatedAt`) VALUES
(1, 2, 'ARRANGEMENT_PROGRAM_ASSOCIATED_TO', '2', 'Valor de programa de gestion asociado a (Por defecto)', 1, '0000-00-00 00:00:00', NULL);
