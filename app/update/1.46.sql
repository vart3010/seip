CREATE TABLE seip_user_configuration_pre_planning (id INT AUTO_INCREMENT NOT NULL, configuration_id INT NOT NULL, gerencia_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, gerenciaSecond_id INT DEFAULT NULL, INDEX IDX_AAFDA11473F32DD8 (configuration_id), INDEX IDX_AAFDA114B8A96BDB (gerencia_id), INDEX IDX_AAFDA1145A2F2234 (gerenciaSecond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA11473F32DD8 FOREIGN KEY (configuration_id) REFERENCES seip_user_configuration (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA114B8A96BDB FOREIGN KEY (gerencia_id) REFERENCES seip_c_gerencia (id);
ALTER TABLE seip_user_configuration_pre_planning ADD CONSTRAINT FK_AAFDA1145A2F2234 FOREIGN KEY (gerenciaSecond_id) REFERENCES seip_c_gerencia_second (id);

ALTER TABLE seip_user_configuration_pre_planning DROP INDEX IDX_AAFDA11473F32DD8, ADD UNIQUE INDEX UNIQ_AAFDA11473F32DD8 (configuration_id);
ALTER TABLE seip_objetive ADD sourceImported_id INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD CONSTRAINT FK_C239594B93DEE346 FOREIGN KEY (sourceImported_id) REFERENCES seip_objetive (id);
CREATE UNIQUE INDEX UNIQ_C239594B93DEE346 ON seip_objetive (sourceImported_id);
ALTER TABLE seip_objetive_audit ADD sourceImported_id INT DEFAULT NULL;


-- Agregando periodo a resultado
ALTER TABLE seip_result ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_result ADD CONSTRAINT FK_102C15ABEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_102C15ABEC8B7ADE ON seip_result (period_id);
ALTER TABLE seip_result_audit ADD period_id INT DEFAULT NULL;

UPDATE seip_result SET period_id = 1 WHERE period_id IS NULL;
ALTER TABLE seip_result CHANGE period_id period_id INT NOT NULL;

-- Renombrando tablas
ALTER TABLE PrePlanning CHANGE idobject idSourceObject INT DEFAULT NULL;
ALTER TABLE PrePlanningItem CHANGE idobject idSourceObject INT DEFAULT NULL;

-- Result tiene periodo, ACTUALIZAR ADMIN.