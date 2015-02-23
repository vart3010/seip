ALTER TABLE ArrangementProgram ADD isAvailableInResult TINYINT(1) NOT NULL;
UPDATE ArrangementProgram SET isAvailableInResult=1 WHERE 1;

ALTER TABLE ArrangementProgram ADD deletedAt DATETIME DEFAULT NULL;
ALTER TABLE GoalDetails ADD deletedAt DATETIME DEFAULT NULL;
ALTER TABLE Goal ADD deletedAt DATETIME DEFAULT NULL;
ALTER TABLE Timeline ADD deletedAt DATETIME DEFAULT NULL;

CREATE TABLE GoalDetails_audit (id INT NOT NULL, rev INT NOT NULL, januaryPlanned DOUBLE PRECISION DEFAULT NULL, januaryReal DOUBLE PRECISION DEFAULT NULL, februaryPlanned DOUBLE PRECISION DEFAULT NULL, februaryReal DOUBLE PRECISION DEFAULT NULL, marchPlanned DOUBLE PRECISION DEFAULT NULL, marchReal DOUBLE PRECISION DEFAULT NULL, aprilPlanned DOUBLE PRECISION DEFAULT NULL, aprilReal DOUBLE PRECISION DEFAULT NULL, mayPlanned DOUBLE PRECISION DEFAULT NULL, mayReal DOUBLE PRECISION DEFAULT NULL, junePlanned DOUBLE PRECISION DEFAULT NULL, juneReal DOUBLE PRECISION DEFAULT NULL, julyPlanned DOUBLE PRECISION DEFAULT NULL, julyReal DOUBLE PRECISION DEFAULT NULL, augustPlanned DOUBLE PRECISION DEFAULT NULL, augustReal DOUBLE PRECISION DEFAULT NULL, septemberPlanned DOUBLE PRECISION DEFAULT NULL, septemberReal DOUBLE PRECISION DEFAULT NULL, octoberPlanned DOUBLE PRECISION DEFAULT NULL, octoberReal DOUBLE PRECISION DEFAULT NULL, novemberPlanned DOUBLE PRECISION DEFAULT NULL, novemberReal DOUBLE PRECISION DEFAULT NULL, decemberPlanned DOUBLE PRECISION DEFAULT NULL, decemberReal DOUBLE PRECISION DEFAULT NULL, status INT DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE ArrangementProgram_audit (id INT NOT NULL, rev INT NOT NULL, period_id INT DEFAULT NULL, tactical_objective_id INT DEFAULT NULL, operational_objective_id INT DEFAULT NULL, timeline_id INT DEFAULT NULL, details_id INT DEFAULT NULL, ref VARCHAR(100) DEFAULT NULL, process VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, totalAdvance DOUBLE PRECISION DEFAULT NULL, progressToDate DOUBLE PRECISION DEFAULT NULL, lastDateCalculateResult DATETIME DEFAULT NULL, isAvailableInResult TINYINT(1) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, type INT DEFAULT NULL, createdBy_id INT DEFAULT NULL, categoryArrangementProgram_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Goal_audit (id INT NOT NULL, rev INT NOT NULL, timeline_id INT DEFAULT NULL, period_id INT DEFAULT NULL, name LONGTEXT DEFAULT NULL, startDate DATETIME DEFAULT NULL, endDate DATETIME DEFAULT NULL, weight INT DEFAULT NULL, observations LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, typeGoal_id INT DEFAULT NULL, goalDetails_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Timeline_audit (id INT NOT NULL, rev INT NOT NULL, status INT DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Nuevas en admin
CREATE TABLE seip_gerencia_group_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, group_name VARCHAR(50) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_c_complejo_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, ref VARCHAR(50) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_c_gerencia_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, fk_complejo INT DEFAULT NULL, fk_direction INT DEFAULT NULL, configuration_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, ref VARCHAR(100) DEFAULT NULL, abbreviation VARCHAR(100) DEFAULT NULL, modular TINYINT(1) DEFAULT NULL, vinculante TINYINT(1) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, gerenciaGroup_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE seip_c_gerencia_second_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, fk_complejo INT DEFAULT NULL, fk_gerencia INT DEFAULT NULL, configuration_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, ref VARCHAR(100) DEFAULT NULL, abbreviation VARCHAR(100) DEFAULT NULL, modular TINYINT(1) DEFAULT NULL, vinculante TINYINT(1) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Nuevas audiciones
ALTER TABLE seip_indicator_value ADD deletedAt DATETIME DEFAULT NULL;
CREATE TABLE seip_indicator_value_audit (id INT NOT NULL, rev INT NOT NULL, indicator_id INT DEFAULT NULL, fk_formula INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, valueOfIndicator DOUBLE PRECISION DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, formulaParameters LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', createdBy_id INT DEFAULT NULL, updatedBy_id INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Tabla de la pre planificacion por usuario
CREATE TABLE PrePlanningUser (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, period_id INT NOT NULL, ref VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, levelPlanning INT NOT NULL, status INT NOT NULL, contentObjetive TINYINT(1) NOT NULL, contentIndicator TINYINT(1) NOT NULL, contentArrangementProgram TINYINT(1) NOT NULL, contentArrangementProgramGoal TINYINT(1) NOT NULL, prePlanningRoot_id INT NOT NULL, gerenciaFirst_id INT DEFAULT NULL, gerenciaSecond_id INT DEFAULT NULL, INDEX IDX_43E04A58A76ED395 (user_id), INDEX IDX_43E04A58EC8B7ADE (period_id), UNIQUE INDEX UNIQ_43E04A582D5CFCAF (prePlanningRoot_id), INDEX IDX_43E04A585BC1F178 (gerenciaFirst_id), INDEX IDX_43E04A585A2F2234 (gerenciaSecond_id), UNIQUE INDEX planning_idx (user_id, period_id, levelPlanning), UNIQUE INDEX planninguser_ref_idx (ref), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE PrePlanningUser ADD CONSTRAINT FK_43E04A58A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE PrePlanningUser ADD CONSTRAINT FK_43E04A58EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
ALTER TABLE PrePlanningUser ADD CONSTRAINT FK_43E04A582D5CFCAF FOREIGN KEY (prePlanningRoot_id) REFERENCES PrePlanning (id);
ALTER TABLE PrePlanningUser ADD CONSTRAINT FK_43E04A585BC1F178 FOREIGN KEY (gerenciaFirst_id) REFERENCES seip_c_gerencia (id);
ALTER TABLE PrePlanningUser ADD CONSTRAINT FK_43E04A585A2F2234 FOREIGN KEY (gerenciaSecond_id) REFERENCES seip_c_gerencia_second (id);
ALTER TABLE PrePlanning DROP FOREIGN KEY FK_BFBCFF4FA76ED395;
ALTER TABLE PrePlanning DROP FOREIGN KEY FK_BFBCFF4FEC8B7ADE;
DROP INDEX IDX_BFBCFF4FA76ED395 ON PrePlanning;
DROP INDEX IDX_BFBCFF4FEC8B7ADE ON PrePlanning;
ALTER TABLE PrePlanning DROP user_id, DROP period_id;

-- Resultado real arrojado por la fórmula de evaluación del indicador
ALTER TABLE seip_indicator ADD resultReal DOUBLE PRECISION NOT NULL;
ALTER TABLE seip_indicator_audit ADD resultReal DOUBLE PRECISION DEFAULT NULL;

-- Status del trabajador
ALTER TABLE seip_user ADD status_worker INT NOT NULL;
ALTER TABLE seip_user_audit ADD status_worker INT DEFAULT NULL;
UPDATE seip_user SET status_worker = 1;

-- Configuracion de lista de correos
INSERT INTO `Configuration` (`id`, `group_id`, `keyIndex`, `value`, `description`, `active`, `createdAt`, `updatedAt`) VALUES (NULL, '1', 'PRE_PLANNING_EMAIL_NOTIFY_TO_REVISION', '["rarias@pequiven.com","vescalona@pequiven.com"]', 'Lista de correos que recibiran las notificaciones cuando se envie una pre-planificacion a revision', '1', '2015-02-11 00:00:00', NULL);
-- Tabla audit de Rango de Gestión
CREATE TABLE seip_arrangement_range_audit (id INT NOT NULL, rev INT NOT NULL, fk_user_created_at INT DEFAULT NULL, fk_user_updated_at INT DEFAULT NULL, period_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, rankTopBasic DOUBLE PRECISION DEFAULT NULL, rankTopMixedTop DOUBLE PRECISION DEFAULT NULL, rankTopMixedBottom DOUBLE PRECISION DEFAULT NULL, rankMiddleTopBasic DOUBLE PRECISION DEFAULT NULL, rankMiddleTopMixedTop DOUBLE PRECISION DEFAULT NULL, rankMiddleTopMixedBottom DOUBLE PRECISION DEFAULT NULL, rankMiddleBottomBasic DOUBLE PRECISION DEFAULT NULL, rankMiddleBottomMixedTop DOUBLE PRECISION DEFAULT NULL, rankMiddleBottomMixedBottom DOUBLE PRECISION DEFAULT NULL, rankBottomBasic DOUBLE PRECISION DEFAULT NULL, rankBottomMixedTop DOUBLE PRECISION DEFAULT NULL, rankBottomMixedBottom DOUBLE PRECISION DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, typeRangeTop INT DEFAULT NULL, typeRangeMiddleTop INT DEFAULT NULL, typeRangeMiddleBottom INT DEFAULT NULL, typeRangeBottom INT DEFAULT NULL, op_rankTopBasic INT DEFAULT NULL, op_rankTopMixed_top INT DEFAULT NULL, op_rankTopMixed_bottom INT DEFAULT NULL, op_rankMiddleTopBasic INT DEFAULT NULL, op_rankMiddleTopMixed_top INT DEFAULT NULL, op_rankMiddleTopMixed_bottom INT DEFAULT NULL, op_rankMiddleBottomBasic INT DEFAULT NULL, op_rankMiddleBottomMixed_top INT DEFAULT NULL, op_rankMiddleBottomMixed_bottom INT DEFAULT NULL, op_rankBottomBasic INT DEFAULT NULL, op_rankBottomMixed_top INT DEFAULT NULL, op_rankBottomMixed_bottom INT DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE Goal ADD advance DOUBLE PRECISION NOT NULL;
ALTER TABLE Goal_audit ADD advance DOUBLE PRECISION DEFAULT NULL;

ALTER TABLE Period ADD dateStartPenalty DATE DEFAULT NULL, ADD dateEndPenalty DATE DEFAULT NULL;
ALTER TABLE Period_audit ADD dateStartPenalty DATE DEFAULT NULL, ADD dateEndPenalty DATE DEFAULT NULL;

ALTER TABLE seip_indicator ADD couldBePenalized TINYINT(1) NOT NULL, ADD forcePenalize TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD couldBePenalized TINYINT(1) DEFAULT NULL, ADD forcePenalize TINYINT(1) DEFAULT NULL;
ALTER TABLE ArrangementProgram ADD couldBePenalized TINYINT(1) NOT NULL, ADD forcePenalize TINYINT(1) NOT NULL;
ALTER TABLE ArrangementProgram_audit ADD couldBePenalized TINYINT(1) DEFAULT NULL, ADD forcePenalize TINYINT(1) DEFAULT NULL;

UPDATE seip_indicator SET couldBePenalized = 1;
UPDATE ArrangementProgram SET couldBePenalized = 1;

ALTER TABLE Period ADD amountPenalty DOUBLE PRECISION NOT NULL;
ALTER TABLE Period_audit ADD amountPenalty DOUBLE PRECISION DEFAULT NULL;
UPDATE Period SET amountPenalty = 15;

ALTER TABLE Period CHANGE amountpenalty percentagePenalty DOUBLE PRECISION NOT NULL;
ALTER TABLE Period_audit CHANGE amountpenalty percentagePenalty DOUBLE PRECISION DEFAULT NULL;

ALTER TABLE ArrangementProgram ADD resultReal DOUBLE PRECISION NOT NULL;
ALTER TABLE ArrangementProgram_audit ADD resultReal DOUBLE PRECISION DEFAULT NULL;
ALTER TABLE Goal ADD resultReal DOUBLE PRECISION NOT NULL;
ALTER TABLE Goal_audit ADD resultReal DOUBLE PRECISION DEFAULT NULL;

-- Agregando campo para evaluar si es requerido importar un item en la pre planificacion
ALTER TABLE PrePlanning ADD requiredToImport TINYINT(1) NOT NULL;
ALTER TABLE seip_objetive ADD requiredToImport TINYINT(1) NOT NULL;
ALTER TABLE seip_objetive_audit ADD requiredToImport TINYINT(1) DEFAULT NULL;
ALTER TABLE seip_indicator ADD requiredToImport TINYINT(1) NOT NULL;
ALTER TABLE seip_indicator_audit ADD requiredToImport TINYINT(1) DEFAULT NULL;

UPDATE `seip_objetive` o,`seip_objetive_level` ol SET o.`requiredToImport`= 1 WHERE o.fk_objetive_level = ol.id AND ol.level = 1;
UPDATE `seip_indicator` i,`seip_indicator_level` il SET i.`requiredToImport`=1 WHERE i.fk_indicator_level=il.id AND il.level = 1;

ALTER TABLE seip_monitor ADD period_id INT NOT NULL;
UPDATE `seip_monitor` SET period_id=1 WHERE 1;
ALTER TABLE seip_monitor ADD CONSTRAINT FK_24ACE4EFEC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_24ACE4EFEC8B7ADE ON seip_monitor (period_id);

-- Periodo para el usuario
ALTER TABLE seip_user ADD period_id INT DEFAULT NULL;
ALTER TABLE seip_user ADD CONSTRAINT FK_B4B410D9EC8B7ADE FOREIGN KEY (period_id) REFERENCES Period (id);
CREATE INDEX IDX_B4B410D9EC8B7ADE ON seip_user (period_id);
ALTER TABLE seip_user_audit ADD period_id INT DEFAULT NULL;