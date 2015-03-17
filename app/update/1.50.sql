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