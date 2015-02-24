CREATE TABLE formula_detail (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, variable_id INT NOT NULL, variableDescription VARCHAR(50) NOT NULL, unitType VARCHAR(50) NOT NULL, unit VARCHAR(90) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2339AD404402854A (indicator_id), INDEX IDX_2339AD40F3037E8E (variable_id), UNIQUE INDEX f_detail_idx (indicator_id, variable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE formula_detail_audit (id INT NOT NULL, rev INT NOT NULL, indicator_id INT DEFAULT NULL, variable_id INT DEFAULT NULL, variableDescription VARCHAR(50) DEFAULT NULL, unitType VARCHAR(50) DEFAULT NULL, unit VARCHAR(90) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD404402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id);
ALTER TABLE formula_detail ADD CONSTRAINT FK_2339AD40F3037E8E FOREIGN KEY (variable_id) REFERENCES Variable (id);