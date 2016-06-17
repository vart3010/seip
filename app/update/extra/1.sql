begin;

CREATE TABLE seip_cei_fail (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type_fail INT NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_cei_fail_audit (id INT NOT NULL, rev INT NOT NULL, name VARCHAR(255) DEFAULT NULL, type_fail INT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_report_product_report (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, plant_id INT DEFAULT NULL, is_raw_material TINYINT(1) NOT NULL, is_final_product TINYINT(1) NOT NULL, product_unit VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, productionLine_id INT DEFAULT NULL, reportTemplate_id INT NOT NULL, INDEX IDX_6C5430524584665A (product_id), INDEX IDX_6C543052B4553F00 (productionLine_id), INDEX IDX_6C5430521D935652 (plant_id), INDEX IDX_6C543052F34F5C2C (reportTemplate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_report_template (id INT AUTO_INCREMENT NOT NULL, period_id INT NOT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type_report INT NOT NULL, enabled TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_47A4AE70EC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_report_template_audit (id INT NOT NULL, rev INT NOT NULL, period_id INT DEFAULT NULL, ref VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type_report INT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_report_product_report ADD CONSTRAINT FK_6C5430524584665A FOREIGN KEY (product_id) REFERENCES seip_cei_Product (id);
ALTER TABLE seip_report_product_report ADD CONSTRAINT FK_6C543052B4553F00 FOREIGN KEY (productionLine_id) REFERENCES seip_cei_ProductionLine (id);
ALTER TABLE seip_report_product_report ADD CONSTRAINT FK_6C5430521D935652 FOREIGN KEY (plant_id) REFERENCES seip_cei_Plant (id);
ALTER TABLE seip_report_product_report ADD CONSTRAINT FK_6C543052F34F5C2C FOREIGN KEY (reportTemplate_id) REFERENCES seip_report_template (id);
ALTER TABLE seip_report_template ADD CONSTRAINT FK_47A4AE70EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);

-- Data de tipo de falla
INSERT INTO `seip_cei_fail` (`id`, `name`, `type_fail`, `enabled`, `createdAt`, `updatedAt`, `deletedAt`) VALUES
(1, 'Equipos', 0, 1, '2015-04-27 14:30:23', '2015-04-27 14:30:23', NULL),
(2, 'Proceso', 0, 1, '2015-04-27 14:31:33', '2015-04-27 14:31:33', NULL),
(3, 'Operación', 0, 1, '2015-04-27 14:31:56', '2015-04-27 14:31:56', NULL),
(4, 'Otros', 0, 1, '2015-04-27 14:32:05', '2015-04-27 14:32:05', NULL),
(5, 'Agua', 1, 1, '2015-04-27 14:34:07', '2015-04-27 14:34:07', NULL),
(6, 'Energia', 1, 1, '2015-04-27 14:34:19', '2015-04-27 14:34:19', NULL),
(7, 'Materia Prima (MP)', 1, 1, '2015-04-27 14:34:57', '2015-04-27 14:34:57', NULL),
(8, 'Tipo de Materia Prima', 1, 1, '2015-04-27 14:36:34', '2015-04-27 14:37:07', NULL);

commit;