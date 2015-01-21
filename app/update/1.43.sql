ALTER TABLE seip_objetive ADD arrangementRange_id INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD CONSTRAINT FK_C239594B9B33E358 FOREIGN KEY (arrangementRange_id) REFERENCES seip_arrangement_range (id);
CREATE UNIQUE INDEX UNIQ_C239594B9B33E358 ON seip_objetive (arrangementRange_id);

UPDATE `seip_objetive` o,seip_arrangement_range ar SET o.`arrangementRange_id` = ar.id WHERE o.id = ar.fk_objetive;

CREATE TABLE seip_user_location (id INT AUTO_INCREMENT NOT NULL, configuration_id INT NOT NULL, location_id INT NOT NULL, gerencia_id INT NOT NULL, rol_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, gerenciaSecond_id INT DEFAULT NULL, INDEX IDX_E120303273F32DD8 (configuration_id), INDEX IDX_E120303264D218E (location_id), INDEX IDX_E1203032B8A96BDB (gerencia_id), INDEX IDX_E12030325A2F2234 (gerenciaSecond_id), INDEX IDX_E12030324BAB96C (rol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_user_configuration (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_user_location ADD CONSTRAINT FK_E120303273F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_user_configuration (id);
ALTER TABLE seip_user_location ADD CONSTRAINT FK_E120303264D218E FOREIGN KEY (location_id) REFERENCES seip_c_complejo (id);
ALTER TABLE seip_user_location ADD CONSTRAINT FK_E1203032B8A96BDB FOREIGN KEY (gerencia_id) REFERENCES seip_c_gerencia (id);
ALTER TABLE seip_user_location ADD CONSTRAINT FK_E12030325A2F2234 FOREIGN KEY (gerenciaSecond_id) REFERENCES seip_c_gerencia_second (id);
ALTER TABLE seip_user_location ADD CONSTRAINT FK_E12030324BAB96C FOREIGN KEY (rol_id) REFERENCES seip_c_rol (id);
ALTER TABLE seip_user ADD configuration_id INT DEFAULT NULL;
ALTER TABLE seip_user ADD CONSTRAINT FK_B4B410D973F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_user_configuration (id);
CREATE UNIQUE INDEX UNIQ_B4B410D973F32DD8 ON seip_user (configuration_id);

ALTER TABLE seip_arrangement_range DROP FOREIGN KEY FK_845D408C5DB32BAE;
DROP INDEX UNIQ_845D408C5DB32BAE ON seip_arrangement_range;
ALTER TABLE seip_arrangement_range DROP fk_objetive;

-- NUEVO SQL
CREATE TABLE seip_gerencia_second_vinculant (gerencia_id INT NOT NULL, gerenciasecond_id INT NOT NULL, INDEX IDX_30E3A2EBB8A96BDB (gerencia_id), INDEX IDX_30E3A2EBD8DEA097 (gerenciasecond_id), PRIMARY KEY(gerencia_id, gerenciasecond_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_gerencia_second_vinculant ADD CONSTRAINT FK_30E3A2EBB8A96BDB FOREIGN KEY (gerencia_id) REFERENCES seip_c_gerencia (id) ON DELETE CASCADE;
ALTER TABLE seip_gerencia_second_vinculant ADD CONSTRAINT FK_30E3A2EBD8DEA097 FOREIGN KEY (gerenciasecond_id) REFERENCES seip_c_gerencia_second (id) ON DELETE CASCADE;

-- ACTUALIZAMOS LAS GERENCIAS DE LAS 3 GERENCIAS DE APROYO DE SHA
UPDATE `seip`.`seip_c_gerencia_second` SET `fk_gerencia` = '1' WHERE `seip_c_gerencia_second`.`id` = 136;
UPDATE `seip`.`seip_c_gerencia_second` SET `fk_gerencia` = '7' WHERE `seip_c_gerencia_second`.`id` = 137;
UPDATE `seip`.`seip_c_gerencia_second` SET `fk_gerencia` = '9' WHERE `seip_c_gerencia_second`.`id` = 138;

-- ACTUALIZAMOS LOS USUARIOS DE SHA (GERENCIAS REPETIDAS)
UPDATE `seip`.`seip_user` SET `fk_complejo` = '1',`fk_gerencia` = '1' WHERE `seip_user`.`fk_gerencia_second` = 136;
UPDATE `seip`.`seip_user` SET `fk_complejo` = '2',`fk_gerencia` = '7' WHERE `seip_user`.`fk_gerencia_second` = 137;
UPDATE `seip`.`seip_user` SET `fk_complejo` = '3',`fk_gerencia` = '9' WHERE `seip_user`.`fk_gerencia_second` = 138;


-- Soft deleteable para objetivo
ALTER TABLE seip_objetive ADD deletedAt DATETIME DEFAULT NULL;
UPDATE `seip_objetive` SET `deletedAt`=NOW() WHERE enabled=0;

-- Soft deleteable para rangos de objetivos
ALTER TABLE seip_arrangement_range ADD deletedAt DATETIME DEFAULT NULL;
UPDATE `seip_arrangement_range` SET `deletedAt`=NOW() WHERE enabled=0;

-- Soft deleteable para indicadores
ALTER TABLE seip_indicator ADD deletedAt DATETIME DEFAULT NULL;
UPDATE `seip_indicator` SET `deletedAt`=NOW() WHERE enabled=0;