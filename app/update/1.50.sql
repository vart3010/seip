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
