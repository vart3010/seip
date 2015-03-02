CREATE TABLE formula_detail (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, variable_id INT NOT NULL, variableDescription VARCHAR(50) NOT NULL, unitType VARCHAR(50) NOT NULL, unit VARCHAR(90) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2339AD404402854A (indicator_id), INDEX IDX_2339AD40F3037E8E (variable_id), UNIQUE INDEX f_detail_idx (indicator_id, variable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE formula_detail_audit (id INT NOT NULL, rev INT NOT NULL, indicator_id INT DEFAULT NULL, variable_id INT DEFAULT NULL, variableDescription VARCHAR(50) DEFAULT NULL, unitType VARCHAR(50) DEFAULT NULL, unit VARCHAR(90) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD404402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id);
ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD40F3037E8E FOREIGN KEY (variable_id) REFERENCES Variable (id);

-- Adición de la Línea Estratégica a los Indicadores Estratégicos
CREATE TABLE seip_indicators_linestrategics (indicator_id INT NOT NULL, linestrategic_id INT NOT NULL, INDEX IDX_2B8E3F474402854A (indicator_id), INDEX IDX_2B8E3F477651D47C (linestrategic_id), PRIMARY KEY(indicator_id, linestrategic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_indicators_linestrategics ADD CONSTRAINT FK_2B8E3F474402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id) ON DELETE CASCADE;
ALTER TABLE seip_indicators_linestrategics ADD CONSTRAINT FK_2B8E3F477651D47C FOREIGN KEY (linestrategic_id) REFERENCES seip_c_line_strategic (id) ON DELETE CASCADE;
ALTER TABLE seip_c_line_strategic ADD deletedAt DATETIME DEFAULT NULL;

-- Adición del campo para indicar que el indicador es medido "al revés"
ALTER TABLE seip_indicator ADD backward TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD backward TINYINT(1) DEFAULT NULL;

-- Unidades de las variables en los indicadores
CREATE TABLE IndicatorDetails_audit (id INT NOT NULL, rev INT NOT NULL, previusValue DOUBLE PRECISION DEFAULT NULL, lastNotificationAt DATETIME DEFAULT NULL, lastNotificationParameters LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', resultManagementUnitType VARCHAR(50) DEFAULT NULL, resultManagementUnit VARCHAR(90) DEFAULT NULL, resultManagementUnitGroup VARCHAR(90) DEFAULT NULL, resultPlanUnitType VARCHAR(50) DEFAULT NULL, resultPlanUnit VARCHAR(90) DEFAULT NULL, resultPlanUnitGroup VARCHAR(90) DEFAULT NULL, resultRealUnitType VARCHAR(50) DEFAULT NULL, resultRealUnit VARCHAR(90) DEFAULT NULL, resultRealUnitGroup VARCHAR(90) DEFAULT NULL, lastNotificationBy_id INT DEFAULT NULL, lastFormulaUsed_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE formula_detail ADD unitGroup VARCHAR(90) NOT NULL, CHANGE variableDescription variableDescription VARCHAR(50) DEFAULT NULL;
ALTER TABLE formula_detail_audit ADD unitGroup VARCHAR(90) DEFAULT NULL;
ALTER TABLE IndicatorDetails ADD resultManagementUnitType VARCHAR(50) NOT NULL, ADD resultManagementUnit VARCHAR(90) NOT NULL, ADD resultManagementUnitGroup VARCHAR(90) NOT NULL, ADD resultPlanUnitType VARCHAR(50) NOT NULL, ADD resultPlanUnit VARCHAR(90) NOT NULL, ADD resultPlanUnitGroup VARCHAR(90) NOT NULL, ADD resultRealUnitType VARCHAR(50) NOT NULL, ADD resultRealUnit VARCHAR(90) NOT NULL, ADD resultRealUnitGroup VARCHAR(90) NOT NULL;

-- Nullable para campos nuevo
ALTER TABLE IndicatorDetails CHANGE resultManagementUnitType resultManagementUnitType VARCHAR(50) DEFAULT NULL, CHANGE resultManagementUnit resultManagementUnit VARCHAR(90) DEFAULT NULL, CHANGE resultManagementUnitGroup resultManagementUnitGroup VARCHAR(90) DEFAULT NULL, CHANGE resultPlanUnitType resultPlanUnitType VARCHAR(50) DEFAULT NULL, CHANGE resultPlanUnit resultPlanUnit VARCHAR(90) DEFAULT NULL, CHANGE resultPlanUnitGroup resultPlanUnitGroup VARCHAR(90) DEFAULT NULL, CHANGE resultRealUnitType resultRealUnitType VARCHAR(50) DEFAULT NULL, CHANGE resultRealUnit resultRealUnit VARCHAR(90) DEFAULT NULL, CHANGE resultRealUnitGroup resultRealUnitGroup VARCHAR(90) DEFAULT NULL;

-- Agregando bandera para marcar a los objetivos cuando impactan al SIG
ALTER TABLE seip_objetive ADD impactToSIG TINYINT(1) NOT NULL;
ALTER TABLE seip_objetive_audit ADD impactToSIG TINYINT(1) DEFAULT NULL;

-- Origen del calculo
ALTER TABLE IndicatorDetails ADD sourceResult INT NOT NULL;
ALTER TABLE IndicatorDetails_audit ADD sourceResult INT DEFAULT NULL;