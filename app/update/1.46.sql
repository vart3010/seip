CREATE TABLE seip_user_configuration_pre_planning (id INT AUTO_INCREMENT NOT NULL, configuration_id INT NOT NULL, gerencia_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, gerenciaSecond_id INT DEFAULT NULL, INDEX IDX_AAFDA11473F32DD8 (configuration_id), INDEX IDX_AAFDA114B8A96BDB (gerencia_id), INDEX IDX_AAFDA1145A2F2234 (gerenciaSecond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA11473F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_user_configuration (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA114B8A96BDB FOREIGN KEY (gerencia_id) REFERENCES seip_c_gerencia (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA1145A2F2234 FOREIGN KEY (gerenciaSecond_id) REFERENCES seip_c_gerencia_second (id);

ALTER TABLE seip_user_configuration_pre_planning DROP INDEX IDX_AAFDA11473F32DD8, ADD UNIQUE INDEX UNIQ_AAFDA11473F32DD8 (configuration_id);
ALTER TABLE seip_objetive ADD sourceImported_id INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD CONSTRAINT FK_C239594B93DEE346 FOREIGN KEY (sourceImported_id) REFERENCES seip_objetive (id);
CREATE UNIQUE INDEX UNIQ_C239594B93DEE346 ON seip_objetive (sourceImported_id);
ALTER TABLE seip_objetive_audit ADD sourceImported_id INT DEFAULT NULL;


-- ACTUALIZAR PLANIFICACION DESDE ACA

CREATE TABLE PrePlanningItemClone (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, period_id INT NOT NULL, typeObject INT NOT NULL, idCloneObject INT NOT NULL, idSourceObjec INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_11613ADBA76ED395 (user_id), INDEX IDX_11613ADBEC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Agregando periodo a resultado
ALTER TABLE seip_result ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_result ADD CONSTRAINT FK_102C15ABEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_102C15ABEC8B7ADE ON seip_result (period_id);
ALTER TABLE seip_result_audit ADD period_id INT DEFAULT NULL;

UPDATE seip_result SET period_id = 1 WHERE 1;
ALTER TABLE seip_result CHANGE period_id period_id INT NOT NULL;

-- Renombrando tablas
ALTER TABLE PrePlanning CHANGE idobject idSourceObject INT DEFAULT NULL;
ALTER TABLE PrePlanningItem CHANGE idobject idSourceObject INT DEFAULT NULL;

-- Result tiene periodo, ACTUALIZAR ADMIN.

ALTER TABLE PrePlanning CHANGE period_id period_id INT DEFAULT NULL;
ALTER TABLE PrePlanningItemClone CHANGE period_id period_id INT DEFAULT NULL;

ALTER TABLE seip_c_tendency ADD period_id INT DEFAULT NULL;
ALTER TABLE Variable ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_formula_level ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_c_formula ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_objetive_level ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_indicator CHANGE period_id period_id INT DEFAULT NULL;
ALTER TABLE seip_c_indicator_frequency_notification ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_arrangement_range ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_indicator_level ADD period_id INT DEFAULT NULL;
ALTER TABLE Goal ADD period_id INT DEFAULT NULL;

UPDATE PrePlanning SET period_id = 1 WHERE 1;
UPDATE PrePlanningItemClone SET period_id = 1 WHERE 1;
UPDATE seip_c_tendency SET period_id = 1 WHERE 1;
UPDATE Variable SET period_id = 1 WHERE 1;
UPDATE seip_formula_level SET period_id = 1 WHERE 1;
UPDATE seip_c_formula SET period_id = 1 WHERE 1;
UPDATE seip_objetive_level SET period_id = 1 WHERE 1;
UPDATE seip_indicator SET period_id = 1 WHERE 1;
UPDATE seip_c_indicator_frequency_notification SET period_id = 1 WHERE 1;
UPDATE seip_arrangement_range SET period_id = 1 WHERE 1;
UPDATE seip_indicator_level SET period_id = 1 WHERE 1;
UPDATE Goal SET period_id = 1 WHERE 1;


ALTER TABLE seip_c_tendency ADD CONSTRAINT FK_9FBD486AEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_9FBD486AEC8B7ADE ON seip_c_tendency (period_id);
ALTER TABLE Variable ADD CONSTRAINT FK_353BE5DBEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_353BE5DBEC8B7ADE ON Variable (period_id);
ALTER TABLE Variable_audit ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_formula_level ADD CONSTRAINT FK_97617C60EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_97617C60EC8B7ADE ON seip_formula_level (period_id);
ALTER TABLE seip_c_formula ADD CONSTRAINT FK_441A844FEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_441A844FEC8B7ADE ON seip_c_formula (period_id);
ALTER TABLE seip_c_formula_audit ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_objetive_level ADD CONSTRAINT FK_5F46829FEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_5F46829FEC8B7ADE ON seip_objetive_level (period_id);
ALTER TABLE seip_c_indicator_frequency_notification ADD CONSTRAINT FK_5D4F23D6EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_5D4F23D6EC8B7ADE ON seip_c_indicator_frequency_notification (period_id);
ALTER TABLE seip_c_indicator_frequency_notification_audit ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_arrangement_range ADD CONSTRAINT FK_845D408CEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_845D408CEC8B7ADE ON seip_arrangement_range (period_id);
ALTER TABLE seip_indicator_level ADD CONSTRAINT FK_86BCBA8AEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_86BCBA8AEC8B7ADE ON seip_indicator_level (period_id);
ALTER TABLE Goal CHANGE period_id period_id INT NOT NULL;
ALTER TABLE Goal ADD CONSTRAINT FK_5CEE4410EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_5CEE4410EC8B7ADE ON Goal (period_id);

CREATE TABLE seip_user_configuration_pre_planning (id INT AUTO_INCREMENT NOT NULL, configuration_id INT NOT NULL, gerencia_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, gerenciaSecond_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AAFDA11473F32DD8 (configuration_id), INDEX IDX_AAFDA114B8A96BDB (gerencia_id), INDEX IDX_AAFDA1145A2F2234 (gerenciaSecond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA11473F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_user_configuration (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA114B8A96BDB FOREIGN KEY (gerencia_id) REFERENCES seip_c_gerencia (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA1145A2F2234 FOREIGN KEY (gerenciaSecond_id) REFERENCES seip_c_gerencia_second (id);
ALTER TABLE PrePlanning CHANGE period_id period_id INT NOT NULL;
ALTER TABLE PrePlanningItemClone CHANGE period_id period_id INT NOT NULL;
ALTER TABLE PrePlanningItemClone ADD CONSTRAINT FK_11613ADBA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE PrePlanningItemClone ADD CONSTRAINT FK_11613ADBEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
ALTER TABLE seip_c_tendency CHANGE period_id period_id INT NOT NULL;
ALTER TABLE Variable CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_formula_level CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_c_formula CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_objetives_parents DROP PRIMARY KEY;
ALTER TABLE seip_objetives_parents ADD PRIMARY KEY (parent_id, children_id);
ALTER TABLE seip_objetive_level CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_indicator_level CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_indicator CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_c_indicator_frequency_notification CHANGE period_id period_id INT NOT NULL;
ALTER TABLE seip_arrangement_range CHANGE period_id period_id INT NOT NULL;

ALTER TABLE PrePlanning ADD levelPlanning INT NOT NULL;
ALTER TABLE ArrangementProgram ADD description LONGTEXT DEFAULT NULL;

ALTER TABLE PrePlanningItemClone CHANGE idsourceobjec idSourceObject INT NOT NULL;
CREATE UNIQUE INDEX entity_idx ON PrePlanningItemClone (typeObject, period_id, idSourceObject);

ALTER TABLE PrePlanning CHANGE name name VARCHAR(255) NOT NULL;