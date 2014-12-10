ALTER TABLE seip_c_gerencia ADD gerenciaGroup_id INT DEFAULT NULL;
ALTER TABLE seip_c_gerencia ADD CONSTRAINT FK_12A7F17C4DD84A60 FOREIGN KEY (gerenciaGroup_id) REFERENCES seip_gerencia_group (id);
CREATE INDEX IDX_12A7F17C4DD84A60 ON seip_c_gerencia (gerenciaGroup_id);

UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 7;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 1;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 9;