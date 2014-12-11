ALTER TABLE seip_c_gerencia ADD gerenciaGroup_id INT DEFAULT NULL;
ALTER TABLE seip_c_gerencia ADD CONSTRAINT FK_12A7F17C4DD84A60 FOREIGN KEY (gerenciaGroup_id) REFERENCES seip_gerencia_group (id);
CREATE INDEX IDX_12A7F17C4DD84A60 ON seip_c_gerencia (gerenciaGroup_id);

UPDATE `seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 7;
UPDATE `seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 1;
UPDATE `seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 9;

-- GRUPO COMERCIALIZADORAS
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '1' WHERE `seip_c_gerencia`.`id` = 3;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '1' WHERE `seip_c_gerencia`.`id` = 2;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '1' WHERE `seip_c_gerencia`.`id` = 8;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '1' WHERE `seip_c_gerencia`.`id` = 6;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '1' WHERE `seip_c_gerencia`.`id` = 5;

-- GRUPO COMPLEJOS
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 7;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 1;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '3' WHERE `seip_c_gerencia`.`id` = 9;

-- GRUPO PROYECTOS
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '4' WHERE `seip_c_gerencia`.`id` = 4;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '4' WHERE `seip_c_gerencia`.`id` = 10;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '4' WHERE `seip_c_gerencia`.`id` = 17;

-- GRUPO SEDE CORPORATIVA
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 26;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 23;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 31;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 27;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 19;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 20;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 21;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 12;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 28;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 11;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 22;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 24;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 16;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 18;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 25;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 15;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 29;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 30;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 14;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 13;
UPDATE `seip`.`seip_c_gerencia` SET `gerenciaGroup_id` = '5' WHERE `seip_c_gerencia`.`id` = 32;
