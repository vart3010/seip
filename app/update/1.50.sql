-- Agregando tipo de detalle del indicator
ALTER TABLE seip_indicator ADD typeDetailValue INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD typeDetailValue INT DEFAULT NULL;

-- Agregando campo resumen de la gerencia
ALTER TABLE seip_c_gerencia ADD resume VARCHAR(50) DEFAULT NULL;
ALTER TABLE seip_c_gerencia_audit ADD resume VARCHAR(50) DEFAULT NULL;
UPDATE seip_c_gerencia AS g SET g.resume = g.ref
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_ESTIMACION_COSTOS' WHERE `seip_c_gerencia`.`id` = 11;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA' WHERE `seip_c_gerencia`.`id` = 12;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_TRANSPORTE_AEREO' WHERE `seip_c_gerencia`.`id` = 13;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_PLANIFICACIÓN_ESTRATEGICA_NUEVOS_DESARROLLOS' WHERE `seip_c_gerencia`.`id` = 14;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY' WHERE `seip_c_gerencia`.`id` = 15;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_PROYECTOS_INTERNACIONALES' WHERE `seip_c_gerencia`.`id` = 16;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_RECURSOS_HUMANOS' WHERE `seip_c_gerencia`.`id` = 18;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_AUDITORIA_INTERNA' WHERE `seip_c_gerencia`.`id` = 19;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL' WHERE `seip_c_gerencia`.`id` = 20;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_CONTRATACIONES' WHERE `seip_c_gerencia`.`id` = 21;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_FINANZAS' WHERE `seip_c_gerencia`.`id` = 22;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES' WHERE `seip_c_gerencia`.`id` = 23;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS' WHERE `seip_c_gerencia`.`id` = 24;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_SALUD' WHERE `seip_c_gerencia`.`id` = 25;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_ADMINISTRACION_Y_SERVICIOS' WHERE `seip_c_gerencia`.`id` = 26;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_ASUNTOS_PUBLICOS' WHERE `seip_c_gerencia`.`id` = 27;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_DESARROLLO_SOCIAL' WHERE `seip_c_gerencia`.`id` = 28;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE' WHERE `seip_c_gerencia`.`id` = 29;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_SISTEMA_INTEGRADO_GESTION' WHERE `seip_c_gerencia`.`id` = 30;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_DIRECCION_PROYECTOS' WHERE `seip_c_gerencia`.`id` = 31;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_OFICINA_PRESIDENCIA' WHERE `seip_c_gerencia`.`id` = 32;
UPDATE `seip`.`seip_c_gerencia` SET `ref` = 'GERENCIA_PROYECTOS_REVOLUCION_PETROQUIMICA' WHERE `seip_c_gerencia`.`id` = 33;
UPDATE `seip`.`seip_c_gerencia` SET `resume` = 'Proy. RPS' WHERE `seip_c_gerencia`.`id` = 33;
INSERT INTO `seip`.`seip_gerencia_configuration` (`id`, `created_at`, `updated_at`) VALUES ('33', NOW(), NOW());
UPDATE `seip`.`seip_c_gerencia` SET `configuration_id` = '33' WHERE `seip_c_gerencia`.`id` = 33;
INSERT INTO `seip`.`seip_monitor` (`id`, `fk_gerencia`, `created_at`, `updated_at`, `objTacticOriginal`, `objTacticVinculante`, `indTacticOriginal`, `indTacticVinculante`, `objOperativeOriginal`, `objOperativeVinculante`, `indOperativeOriginal`, `indOperativeVinculante`, `arrangementProgramTactic`, `arrangementProgramOperative`, `objTacticOriginalReal`, `objTacticVinculanteReal`, `indTacticOriginalReal`, `indTacticVinculanteReal`, `objOperativeOriginalReal`, `objOperativeVinculanteReal`, `indOperativeOriginalReal`, `indOperativeVinculanteReal`, `arrangementProgramTacticReal`, `arrangementProgramOperativeReal`, `fk_type_group`, `period_id`) VALUES (NULL, '33', NOW(), NOW(), '1', '0', '1', '0', '1', '0', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '1');

-- Agregando metodo de calculo del indicador respecto a los hijos
ALTER TABLE seip_indicator ADD calculationMethod INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD calculationMethod INT DEFAULT NULL;

-- Agregando Etiquetas del Indicador
CREATE TABLE seip_indicator_tag (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(300) DEFAULT NULL, equationReal LONGTEXT NOT NULL, typeTag INT NOT NULL, typeCalculationTag INT NOT NULL, valueOfTag DOUBLE PRECISION NOT NULL, textOfTag VARCHAR(300) DEFAULT NULL, `show` TINYINT(1) NOT NULL, deletedAt DATETIME DEFAULT NULL, sourceResult INT NOT NULL, createdBy_id INT NOT NULL, updatedBy_id INT DEFAULT NULL, INDEX IDX_A12328E23174800F (createdBy_id), INDEX IDX_A12328E265FF1AEC (updatedBy_id), INDEX IDX_A12328E24402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_indicator_tag ADD CONSTRAINT FK_A12328E23174800F FOREIGN KEY (createdBy_id) REFERENCES seip_user (id);
ALTER TABLE seip_indicator_tag ADD CONSTRAINT FK_A12328E265FF1AEC FOREIGN KEY (updatedBy_id) REFERENCES seip_user (id);
ALTER TABLE seip_indicator_tag ADD CONSTRAINT FK_A12328E24402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id);

ALTER TABLE Variable ADD usedOnlyByTag TINYINT(1) NOT NULL;
ALTER TABLE Variable_audit ADD usedOnlyByTag TINYINT(1) DEFAULT NULL;

ALTER TABLE seip_indicator ADD resultInPercentage TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD resultInPercentage TINYINT(1) DEFAULT NULL;
UPDATE seip_indicator SET resultInPercentage = 1;

CREATE TABLE seip_indicator_tag_audit (id INT NOT NULL, rev INT NOT NULL, indicator_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(300) DEFAULT NULL, equationReal LONGTEXT DEFAULT NULL, typeTag INT DEFAULT NULL, typeCalculationTag INT DEFAULT NULL, valueOfTag DOUBLE PRECISION DEFAULT NULL, textOfTag VARCHAR(300) DEFAULT NULL, `show` TINYINT(1) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, sourceResult INT DEFAULT NULL, createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_indicator_tag CHANGE indicator_id indicator_id INT DEFAULT NULL;
ALTER TABLE seip_indicator_tag CHANGE equationReal equationReal LONGTEXT DEFAULT NULL;
ALTER TABLE seip_indicator_tag CHANGE createdBy_id createdBy_id INT DEFAULT NULL;

ALTER TABLE seip_indicator_tag CHANGE `show` showTag TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_tag_audit CHANGE `show` showTag TINYINT(1) DEFAULT NULL;
ALTER TABLE seip_indicator_tag CHANGE indicator_id indicator_id INT NOT NULL;

ALTER TABLE seip_indicator ADD showTagInResult TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD showTagInResult TINYINT(1) DEFAULT NULL;
ALTER TABLE seip_indicator_tag ADD showInIndicatorResult TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_tag_audit ADD showInIndicatorResult TINYINT(1) DEFAULT NULL;

ALTER TABLE seip_indicator ADD summary LONGTEXT NOT NULL;
ALTER TABLE seip_indicator_audit ADD summary LONGTEXT DEFAULT NULL;
UPDATE seip_indicator SET summary = description;

ALTER TABLE seip_indicator ADD indicatorWeight DOUBLE PRECISION DEFAULT NULL;
ALTER TABLE seip_indicator_audit ADD indicatorWeight DOUBLE PRECISION DEFAULT NULL;

ALTER TABLE seip_indicator ADD showRealValue TINYINT(1) NOT NULL, ADD showPlanValue TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD showRealValue TINYINT(1) DEFAULT NULL, ADD showPlanValue TINYINT(1) DEFAULT NULL;
UPDATE `seip_indicator` SET showRealValue = 1,showPlanValue = 1 WHERE 1;

ALTER TABLE seip_indicator_tag ADD unitResult VARCHAR(90) DEFAULT NULL;
ALTER TABLE seip_indicator_tag_audit ADD unitResult VARCHAR(90) DEFAULT NULL;

-- Agregando campo para permitir evaluar dependiendo de la auditoria
ALTER TABLE seip_c_gerencia ADD validAudit TINYINT(1) NOT NULL;
ALTER TABLE seip_c_gerencia_audit ADD validAudit TINYINT(1) DEFAULT NULL;
ALTER TABLE seip_c_gerencia_second ADD validAudit TINYINT(1) NOT NULL;
ALTER TABLE seip_c_gerencia_second_audit ADD validAudit TINYINT(1) DEFAULT NULL;
UPDATE `seip_c_gerencia` SET validAudit = 1 WHERE 1;
UPDATE `seip_c_gerencia_second` SET validAudit = 1 WHERE 1;
-- Snippet en indicador
ALTER TABLE seip_indicator ADD snippetPlan LONGTEXT DEFAULT NULL, ADD snippetReal LONGTEXT DEFAULT NULL;
ALTER TABLE seip_indicator_audit ADD snippetPlan LONGTEXT DEFAULT NULL, ADD snippetReal LONGTEXT DEFAULT NULL;

ALTER TABLE seip_indicator_tag ADD orderShow INT NOT NULL;
ALTER TABLE seip_indicator_tag_audit ADD orderShow INT DEFAULT NULL;
UPDATE seip_indicator_tag SET orderShow = 1;

-- Mostrar resultados en indicador
ALTER TABLE seip_indicator ADD showResults TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD showResults TINYINT(1) DEFAULT NULL;
UPDATE seip_indicator SET showResults = 1;
ALTER TABLE seip_indicator ADD showFeatures TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD showFeatures TINYINT(1) DEFAULT NULL;
UPDATE seip_indicator SET showResults = 0,showFeatures = 1 WHERE fk_indicator_level = 1;

CREATE TABLE seip_c_type_feature_indicator (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(20) NOT NULL, priority INT NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE FeatureIndicator (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, typeFeatureIndicator_id INT NOT NULL, INDEX IDX_13D78E323BBE3A71 (typeFeatureIndicator_id), INDEX IDX_13D78E324402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE FeatureIndicator ADD CONSTRAINT FK_13D78E323BBE3A71 FOREIGN KEY (typeFeatureIndicator_id) REFERENCES seip_c_type_feature_indicator (id);
ALTER TABLE FeatureIndicator ADD CONSTRAINT FK_13D78E324402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id);

ALTER TABLE seip_indicator ADD evaluetaInPeriod TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD evaluetaInPeriod TINYINT(1) DEFAULT NULL;
UPDATE seip_indicator SET evaluetaInPeriod = 1;