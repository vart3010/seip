-- Adición de la Línea Estratégica a los Indicadores Estratégicos
CREATE TABLE seip_indicators_linestrategics (indicator_id INT NOT NULL, linestrategic_id INT NOT NULL, INDEX IDX_2B8E3F474402854A (indicator_id), INDEX IDX_2B8E3F477651D47C (linestrategic_id), PRIMARY KEY(indicator_id, linestrategic_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE seip_indicators_linestrategics ADD CONSTRAINT FK_2B8E3F474402854A FOREIGN KEY (indicator_id) REFERENCES seip_indicator (id) ON DELETE CASCADE;
ALTER TABLE seip_indicators_linestrategics ADD CONSTRAINT FK_2B8E3F477651D47C FOREIGN KEY (linestrategic_id) REFERENCES seip_c_line_strategic (id) ON DELETE CASCADE;
ALTER TABLE seip_c_line_strategic ADD deletedAt DATETIME DEFAULT NULL;
