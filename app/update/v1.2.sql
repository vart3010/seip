CREATE TABLE Historical (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event VARCHAR(200) NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, level INT NOT NULL, INDEX IDX_EA32CED3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_gerencia_configuration (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Configuration_Reviser (configuration_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A815A01273F32DD8 (configuration_id), INDEX IDX_A815A012A76ED395 (user_id), PRIMARY KEY(configuration_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Configuration_Approve_Tactical (configuration_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1806D2A73F32DD8 (configuration_id), INDEX IDX_1806D2AA76ED395 (user_id), PRIMARY KEY(configuration_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Configuration_Approve_Operative (configuration_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5CED875B73F32DD8 (configuration_id), INDEX IDX_5CED875BA76ED395 (user_id), PRIMARY KEY(configuration_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE arrangementprogram_user (arrangementprogram_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_54A6112E41899CD8 (arrangementprogram_id), INDEX IDX_54A6112EA76ED395 (user_id), PRIMARY KEY(arrangementprogram_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE arrangementprogram_historical (arrangementprogram_id INT NOT NULL, historical_id INT NOT NULL, INDEX IDX_AE06C00641899CD8 (arrangementprogram_id), INDEX IDX_AE06C006C75EAE06 (historical_id), PRIMARY KEY(arrangementprogram_id, historical_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE ArrangementProgramDetails (id INT AUTO_INCREMENT NOT NULL, revisionDate DATETIME DEFAULT NULL, approvalDate DATETIME DEFAULT NULL, sendToReviewDate DATETIME DEFAULT NULL, rejectedDate DATETIME DEFAULT NULL, reviewedBy_id INT DEFAULT NULL, approvedBy_id INT DEFAULT NULL, sendToReviewBy_id INT DEFAULT NULL, rejectedBy_id INT DEFAULT NULL, INDEX IDX_165E90D79C6A92E (reviewedBy_id), INDEX IDX_165E90D7FACFC38A (approvedBy_id), INDEX IDX_165E90D72DBCCBD9 (sendToReviewBy_id), INDEX IDX_165E90D74A8361C5 (rejectedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE Historical ADD CONSTRAINT FK_EA32CED3A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE Configuration_Reviser ADD CONSTRAINT FK_A815A01273F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
ALTER TABLE Configuration_Reviser ADD CONSTRAINT FK_A815A012A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE Configuration_Approve_Tactical ADD CONSTRAINT FK_1806D2A73F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
ALTER TABLE Configuration_Approve_Tactical ADD CONSTRAINT FK_1806D2AA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE Configuration_Approve_Operative ADD CONSTRAINT FK_5CED875B73F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
ALTER TABLE Configuration_Approve_Operative ADD CONSTRAINT FK_5CED875BA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE arrangementprogram_user ADD CONSTRAINT FK_54A6112E41899CD8 FOREIGN KEY (arrangementprogram_id) REFERENCES ArrangementProgram (id) ON DELETE CASCADE;
ALTER TABLE arrangementprogram_user ADD CONSTRAINT FK_54A6112EA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id) ON DELETE CASCADE;
ALTER TABLE arrangementprogram_historical ADD CONSTRAINT FK_AE06C00641899CD8 FOREIGN KEY (arrangementprogram_id) REFERENCES ArrangementProgram (id) ON DELETE CASCADE;
ALTER TABLE arrangementprogram_historical ADD CONSTRAINT FK_AE06C006C75EAE06 FOREIGN KEY (historical_id) REFERENCES Historical (id) ON DELETE CASCADE;
ALTER TABLE ArrangementProgramDetails ADD CONSTRAINT FK_165E90D79C6A92E FOREIGN KEY (reviewedBy_id) REFERENCES seip_user (id);
ALTER TABLE ArrangementProgramDetails ADD CONSTRAINT FK_165E90D7FACFC38A FOREIGN KEY (approvedBy_id) REFERENCES seip_user (id);
ALTER TABLE ArrangementProgramDetails ADD CONSTRAINT FK_165E90D72DBCCBD9 FOREIGN KEY (sendToReviewBy_id) REFERENCES seip_user (id);
ALTER TABLE ArrangementProgramDetails ADD CONSTRAINT FK_165E90D74A8361C5 FOREIGN KEY (rejectedBy_id) REFERENCES seip_user (id);
ALTER TABLE seip_monitor ADD type_group VARCHAR(4) DEFAULT NULL;
ALTER TABLE seip_c_gerencia ADD configuration_id INT DEFAULT NULL;
ALTER TABLE seip_c_gerencia ADD CONSTRAINT FK_12A7F17C73F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
CREATE UNIQUE INDEX UNIQ_12A7F17C73F32DD8 ON seip_c_gerencia (configuration_id);
ALTER TABLE seip_c_gerencia_second ADD configuration_id INT DEFAULT NULL;
ALTER TABLE seip_c_gerencia_second ADD CONSTRAINT FK_823D5A9B73F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_gerencia_configuration (id);
CREATE UNIQUE INDEX UNIQ_823D5A9B73F32DD8 ON seip_c_gerencia_second (configuration_id);
ALTER TABLE ArrangementProgram DROP FOREIGN KEY FK_7571028F9C6A92E;
ALTER TABLE ArrangementProgram DROP FOREIGN KEY FK_7571028FBAF0C4C;
ALTER TABLE ArrangementProgram DROP FOREIGN KEY FK_7571028FFACFC38A;
DROP INDEX IDX_7571028FBAF0C4C ON ArrangementProgram;
DROP INDEX IDX_7571028F9C6A92E ON ArrangementProgram;
DROP INDEX IDX_7571028FFACFC38A ON ArrangementProgram;
ALTER TABLE ArrangementProgram ADD ref VARCHAR(100) NOT NULL, ADD createdAt DATETIME NOT NULL, ADD updatedAt DATETIME NOT NULL, DROP revisionDate, DROP approvalDate, DROP reviewedBy_id, DROP approvedBy_id, CHANGE user_responsible_id details_id INT NOT NULL;
ALTER TABLE ArrangementProgram ADD CONSTRAINT FK_7571028FBB1A0722 FOREIGN KEY (details_id) REFERENCES ArrangementProgramDetails (id);
CREATE UNIQUE INDEX UNIQ_7571028FBB1A0722 ON ArrangementProgram (details_id);

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
