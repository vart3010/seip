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

ALTER TABLE ArrangementProgram CHANGE process process VARCHAR(255) DEFAULT NULL;

CREATE TABLE ArrangementProgramObservation (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, createdAt DATETIME NOT NULL, createdBy_id INT NOT NULL, arrangementProgram_id INT NOT NULL, INDEX IDX_A06E0D313174800F (createdBy_id), INDEX IDX_A06E0D31ED49F08 (arrangementProgram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE ArrangementProgramObservation ADD CONSTRAINT FK_A06E0D313174800F FOREIGN KEY (createdBy_id) REFERENCES seip_user (id);
ALTER TABLE ArrangementProgramObservation ADD CONSTRAINT FK_A06E0D31ED49F08 FOREIGN KEY (arrangementProgram_id) REFERENCES ArrangementProgram (id);

CREATE TABLE Configuration_Notify (configuration_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CA0C9F6873F32DD8 (configuration_id), INDEX IDX_CA0C9F68A76ED395 (user_id), PRIMARY KEY(configuration_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE Configuration_Notify ADD CONSTRAINT FK_CA0C9F6873F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
ALTER TABLE Configuration_Notify ADD CONSTRAINT FK_CA0C9F68A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
