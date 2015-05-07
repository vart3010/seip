-- Agregando tipo de detalle del indicator
ALTER TABLE seip_indicator ADD typeDetailValue INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD typeDetailValue INT DEFAULT NULL;

-- Valor de indicador configuracion
CREATE TABLE ValueIndicatorConfig (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, UNIQUE INDEX UNIQ_6C71834402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE valueindicatorconfig_product (valueindicatorconfig_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_B6A1A4B72A403326 (valueindicatorconfig_id), INDEX IDX_B6A1A4B74584665A (product_id), PRIMARY KEY(valueindicatorconfig_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE ValueIndicatorConfig ADD CONSTRAINT FK_6C71834402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id);
ALTER TABLE valueindicatorconfig_product ADD CONSTRAINT FK_B6A1A4B72A403326 FOREIGN KEY (valueindicatorconfig_id) REFERENCES ValueIndicatorConfig (id) ON DELETE CASCADE;
ALTER TABLE valueindicatorconfig_product ADD CONSTRAINT FK_B6A1A4B74584665A FOREIGN KEY (product_id) REFERENCES seip_cei_Product (id) ON DELETE CASCADE;
ALTER TABLE seip_indicator ADD typeDetailValue INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD typeDetailValue INT DEFAULT NULL;

-- Detalles de los valores de indicadores
CREATE TABLE ValueIndicatorDetail (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, valueIndicator_id INT NOT NULL, UNIQUE INDEX UNIQ_FAE0216CC07B546F (valueIndicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE valueindicatordetail_product (valueindicatordetail_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_A472E692D64B361E (valueindicatordetail_id), INDEX IDX_A472E6924584665A (product_id), PRIMARY KEY(valueindicatordetail_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE ValueIndicatorDetail ADD CONSTRAINT FK_FAE0216CC07B546F FOREIGN KEY (valueIndicator_id) REFERENCES seip_indicator_value (id);
ALTER TABLE valueindicatordetail_product ADD CONSTRAINT FK_A472E692D64B361E FOREIGN KEY (valueindicatordetail_id) REFERENCES ValueIndicatorDetail (id) ON DELETE CASCADE;
ALTER TABLE valueindicatordetail_product ADD CONSTRAINT FK_A472E6924584665A FOREIGN KEY (product_id) REFERENCES seip_cei_Product (id) ON DELETE CASCADE;

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

ALTER TABLE seip_indicator ADD orderShowFromParent INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD orderShowFromParent INT DEFAULT NULL;
UPDATE seip_indicator SET orderShowFromParent = 1;

-- Periodo para tag indicador
ALTER TABLE seip_indicator_tag ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_indicator_tag ADD CONSTRAINT FK_A12328E2EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_A12328E2EC8B7ADE ON seip_indicator_tag (period_id);
ALTER TABLE seip_indicator_tag_audit ADD period_id INT DEFAULT NULL;
UPDATE seip_indicator_tag SET period_id = 1;
ALTER TABLE seip_indicator_tag CHANGE period_id period_id INT NOT NULL;

CREATE TABLE product_product (product_source INT NOT NULL, product_target INT NOT NULL, INDEX IDX_2931F1D3DF63ED7 (product_source), INDEX IDX_2931F1D24136E58 (product_target), PRIMARY KEY(product_source, product_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE company_affiliates (company_source INT NOT NULL, company_target INT NOT NULL, INDEX IDX_AD02831962151B06 (company_source), INDEX IDX_AD0283197BF04B89 (company_target), PRIMARY KEY(company_source, company_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE company_mixeds (company_source INT NOT NULL, company_target INT NOT NULL, INDEX IDX_841FC3F362151B06 (company_source), INDEX IDX_841FC3F37BF04B89 (company_target), PRIMARY KEY(company_source, company_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_objetive_details (id INT AUTO_INCREMENT NOT NULL, approvalDate DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, approvedBy_id INT DEFAULT NULL, INDEX IDX_747475F6FACFC38A (approvedBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE ProductDetailDailyMonth (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, parent_id INT DEFAULT NULL, month INT NOT NULL, totalPlan DOUBLE PRECISION NOT NULL, totalReal DOUBLE PRECISION NOT NULL, percentage DOUBLE PRECISION NOT NULL, day1Plan DOUBLE PRECISION NOT NULL, day1Real DOUBLE PRECISION NOT NULL, day2Plan DOUBLE PRECISION NOT NULL, day2Real DOUBLE PRECISION NOT NULL, day3Plan DOUBLE PRECISION NOT NULL, day3Real DOUBLE PRECISION NOT NULL, day4Plan DOUBLE PRECISION NOT NULL, day4Real DOUBLE PRECISION NOT NULL, day5Plan DOUBLE PRECISION NOT NULL, day5Real DOUBLE PRECISION NOT NULL, day6Plan DOUBLE PRECISION NOT NULL, day6Real DOUBLE PRECISION NOT NULL, day7Plan DOUBLE PRECISION NOT NULL, day7Real DOUBLE PRECISION NOT NULL, day8Plan DOUBLE PRECISION NOT NULL, day8Real DOUBLE PRECISION NOT NULL, day9Plan DOUBLE PRECISION NOT NULL, day9Real DOUBLE PRECISION NOT NULL, day10Plan DOUBLE PRECISION NOT NULL, day10Real DOUBLE PRECISION NOT NULL, day11Plan DOUBLE PRECISION NOT NULL, day11Real DOUBLE PRECISION NOT NULL, day12Plan DOUBLE PRECISION NOT NULL, day12Real DOUBLE PRECISION NOT NULL, day13Plan DOUBLE PRECISION NOT NULL, day13Real DOUBLE PRECISION NOT NULL, day14Plan DOUBLE PRECISION NOT NULL, day14Real DOUBLE PRECISION NOT NULL, day15Plan DOUBLE PRECISION NOT NULL, day15Real DOUBLE PRECISION NOT NULL, day16Plan DOUBLE PRECISION NOT NULL, day16Real DOUBLE PRECISION NOT NULL, day17Plan DOUBLE PRECISION NOT NULL, day17Real DOUBLE PRECISION NOT NULL, day18Plan DOUBLE PRECISION NOT NULL, day18Real DOUBLE PRECISION NOT NULL, day19Plan DOUBLE PRECISION NOT NULL, day19Real DOUBLE PRECISION NOT NULL, day20Plan DOUBLE PRECISION NOT NULL, day20Real DOUBLE PRECISION NOT NULL, day21Plan DOUBLE PRECISION NOT NULL, day21Real DOUBLE PRECISION NOT NULL, day22Plan DOUBLE PRECISION NOT NULL, day22Real DOUBLE PRECISION NOT NULL, day23Plan DOUBLE PRECISION NOT NULL, day23Real DOUBLE PRECISION NOT NULL, day24Plan DOUBLE PRECISION NOT NULL, day24Real DOUBLE PRECISION NOT NULL, day25Plan DOUBLE PRECISION NOT NULL, day25Real DOUBLE PRECISION NOT NULL, day26Plan DOUBLE PRECISION NOT NULL, day26Real DOUBLE PRECISION NOT NULL, day27Plan DOUBLE PRECISION NOT NULL, day27Real DOUBLE PRECISION NOT NULL, day28Plan DOUBLE PRECISION NOT NULL, day28Real DOUBLE PRECISION NOT NULL, day29Plan DOUBLE PRECISION NOT NULL, day29Real DOUBLE PRECISION NOT NULL, day30Plan DOUBLE PRECISION NOT NULL, day30Real DOUBLE PRECISION NOT NULL, day31Plan DOUBLE PRECISION NOT NULL, day31Real DOUBLE PRECISION NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, valueIndicatorDetail_id INT DEFAULT NULL, INDEX IDX_1FE8B2609FC0C8D (valueIndicatorDetail_id), INDEX IDX_1FE8B2604584665A (product_id), INDEX IDX_1FE8B260727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE ValueIndicatorDetail (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D3DF63ED7 FOREIGN KEY (product_source) REFERENCES seip_cei_Product (id) ON DELETE CASCADE;
ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D24136E58 FOREIGN KEY (product_target) REFERENCES seip_cei_Product (id) ON DELETE CASCADE;
ALTER TABLE company_affiliates ADD CONSTRAINT FK_AD02831962151B06 FOREIGN KEY (company_source) REFERENCES seip_cei_Company (id) ON DELETE CASCADE;
ALTER TABLE company_affiliates ADD CONSTRAINT FK_AD0283197BF04B89 FOREIGN KEY (company_target) REFERENCES seip_cei_Company (id) ON DELETE CASCADE;
ALTER TABLE company_mixeds ADD CONSTRAINT FK_841FC3F362151B06 FOREIGN KEY (company_source) REFERENCES seip_cei_Company (id) ON DELETE CASCADE;
ALTER TABLE company_mixeds ADD CONSTRAINT FK_841FC3F37BF04B89 FOREIGN KEY (company_target) REFERENCES seip_cei_Company (id) ON DELETE CASCADE;
ALTER TABLE seip_objetive_details ADD CONSTRAINT FK_747475F6FACFC38A FOREIGN KEY (approvedBy_id) REFERENCES seip_user (id);
ALTER TABLE ProductDetailDailyMonth ADD CONSTRAINT FK_1FE8B2609FC0C8D FOREIGN KEY (valueIndicatorDetail_id) REFERENCES ValueIndicatorDetail (id);
ALTER TABLE ProductDetailDailyMonth ADD CONSTRAINT FK_1FE8B2604584665A FOREIGN KEY (product_id) REFERENCES seip_cei_Product (id);
ALTER TABLE ProductDetailDailyMonth ADD CONSTRAINT FK_1FE8B260727ACA70 FOREIGN KEY (parent_id) REFERENCES ProductDetailDailyMonth (id);
ALTER TABLE seip_cei_Location ADD alias VARCHAR(10) NOT NULL;
ALTER TABLE seip_cei_Location_audit ADD alias VARCHAR(10) DEFAULT NULL;
ALTER TABLE seip_cei_Plant ADD location_id INT DEFAULT NULL;
ALTER TABLE seip_cei_Plant ADD CONSTRAINT FK_E55C2A7A64D218E FOREIGN KEY (location_id) REFERENCES seip_cei_Location (id);
CREATE INDEX IDX_E55C2A7A64D218E ON seip_cei_Plant (location_id);
ALTER TABLE seip_cei_Plant_audit ADD location_id INT DEFAULT NULL;
ALTER TABLE seip_cei_Product ADD typeOf INT NOT NULL;
ALTER TABLE seip_cei_Product_audit ADD typeOf INT DEFAULT NULL;
ALTER TABLE seip_cei_Company ADD alias VARCHAR(20) NOT NULL, ADD typeOfCompany INT NOT NULL;
ALTER TABLE seip_cei_Company_audit ADD alias VARCHAR(20) DEFAULT NULL, ADD typeOfCompany INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD details_id INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD CONSTRAINT FK_C239594BBB1A0722 FOREIGN KEY (details_id) REFERENCES seip_objetive_details (id);
CREATE UNIQUE INDEX UNIQ_C239594BBB1A0722 ON seip_objetive (details_id);
ALTER TABLE seip_objetive_audit ADD details_id INT DEFAULT NULL;
ALTER TABLE seip_indicator ADD status INT NOT NULL, ADD valueIndicatorConfig_id INT DEFAULT NULL;
ALTER TABLE seip_indicator ADD CONSTRAINT FK_6092D6A6F5F709B5 FOREIGN KEY (valueIndicatorConfig_id) REFERENCES ValueIndicatorConfig (id);
CREATE UNIQUE INDEX UNIQ_6092D6A6F5F709B5 ON seip_indicator (valueIndicatorConfig_id);
ALTER TABLE seip_indicator_audit ADD status INT DEFAULT NULL, ADD valueIndicatorConfig_id INT DEFAULT NULL;
ALTER TABLE ValueIndicatorConfig DROP FOREIGN KEY FK_6C71834402854A;
DROP INDEX UNIQ_6C71834402854A ON ValueIndicatorConfig;
ALTER TABLE ValueIndicatorConfig DROP indicator_id;
ALTER TABLE seip_indicator_value ADD valueIndicatorDetail_id INT DEFAULT NULL;
ALTER TABLE seip_indicator_value ADD CONSTRAINT FK_1212EAD9FC0C8D FOREIGN KEY (valueIndicatorDetail_id) REFERENCES ValueIndicatorDetail (id);
CREATE UNIQUE INDEX UNIQ_1212EAD9FC0C8D ON seip_indicator_value (valueIndicatorDetail_id);
ALTER TABLE seip_indicator_value_audit ADD valueIndicatorDetail_id INT DEFAULT NULL;
ALTER TABLE IndicatorDetails ADD approvalDate DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL, ADD approvedBy_id INT DEFAULT NULL;
ALTER TABLE IndicatorDetails ADD CONSTRAINT FK_D088D971FACFC38A FOREIGN KEY (approvedBy_id) REFERENCES seip_user (id);
CREATE INDEX IDX_D088D971FACFC38A ON IndicatorDetails (approvedBy_id);
ALTER TABLE IndicatorDetails_audit ADD approvalDate DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL, ADD approvedBy_id INT DEFAULT NULL;

ALTER TABLE Period ADD opened TINYINT(1) NOT NULL;
ALTER TABLE Period_audit ADD opened TINYINT(1) DEFAULT NULL;

-- Sección Gráficos del Indicador
CREATE TABLE seip_chart (id INT AUTO_INCREMENT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, period_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT NOT NULL, name VARCHAR(50) NOT NULL, alias VARCHAR(25) NOT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_15609EA8F54A16F1 (fk_user_created_at), INDEX IDX_15609EA83DA6CF46 (fk_user_updated_at), INDEX IDX_15609EA8EC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_chart_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, period_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(50) DEFAULT NULL, alias VARCHAR(25) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_indicators_charts (indicator_id INT NOT NULL, chart_id INT NOT NULL, INDEX IDX_8E5F39614402854A (indicator_id), INDEX IDX_8E5F3961BEF83E0A (chart_id), PRIMARY KEY(indicator_id, chart_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_chart ADD CONSTRAINT FK_15609EA8F54A16F1 FOREIGN KEY (fk_user_created_at) REFERENCES seip_user (id);
ALTER TABLE seip_chart ADD CONSTRAINT FK_15609EA83DA6CF46 FOREIGN KEY (fk_user_updated_at) REFERENCES seip_user (id);
ALTER TABLE seip_chart ADD CONSTRAINT FK_15609EA8EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
ALTER TABLE seip_indicators_charts ADD CONSTRAINT FK_8E5F39614402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id) ON DELETE CASCADE;
ALTER TABLE seip_indicators_charts ADD CONSTRAINT FK_8E5F3961BEF83E0A FOREIGN KEY (chart_id) REFERENCES seip_chart (id) ON DELETE CASCADE;

-- Nuevos indices
DROP INDEX planning_idx ON PrePlanningUser;
CREATE UNIQUE INDEX planning_gf_idx ON PrePlanningUser (user_id, period_id, levelPlanning, gerenciaFirst_id);
CREATE UNIQUE INDEX planning_gs_idx ON PrePlanningUser (user_id, period_id, levelPlanning, gerenciaSecond_id);

-- Sistemas de Gestión SIG
CREATE TABLE ManagementSystem (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(150) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE ManagementSystem_audit (id INT NOT NULL, rev INT NOT NULL, description VARCHAR(150) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_objetive ADD managementSystem_id INT DEFAULT NULL;
ALTER TABLE seip_objetive ADD CONSTRAINT FK_C239594B4ADC25A2 FOREIGN KEY (managementSystem_id) REFERENCES ManagementSystem (id);
CREATE INDEX IDX_C239594B4ADC25A2 ON seip_objetive (managementSystem_id);
ALTER TABLE seip_objetive_audit ADD managementSystem_id INT DEFAULT NULL;

-- Eliminación de Relación entre Objetivos y Sistemas de Calidad
ALTER TABLE seip_objetive DROP FOREIGN KEY FK_C239594B68C46012;
-- DROP INDEX IDX_C239594B68C46012 ON seip_objetive;
ALTER TABLE seip_objetive DROP qualitySystem_id;
ALTER TABLE seip_objetive_audit DROP qualitySystem_id;

-- Políticas de Sistemas de Gestión SIG
CREATE TABLE PoliticManagementSystem (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(50) NOT NULL, descriptionBody LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE PoliticManagementSystem_audit (id INT NOT NULL, rev INT NOT NULL, description VARCHAR(50) DEFAULT NULL, descriptionBody LONGTEXT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE ManagementSystem ADD politicManagementSystem_id INT DEFAULT NULL;
ALTER TABLE ManagementSystem ADD CONSTRAINT FK_49A8BFF6763F1C FOREIGN KEY (politicManagementSystem_id) REFERENCES PoliticManagementSystem (id);
CREATE INDEX IDX_49A8BFF6763F1C ON ManagementSystem (politicManagementSystem_id);
ALTER TABLE ManagementSystem_audit ADD politicManagementSystem_id INT DEFAULT NULL;
