ALTER TABLE Period ADD dateStartPlanningReport DATE DEFAULT NULL, ADD dateEndPlanningReport DATE DEFAULT NULL, ADD isPlanningReportEnabled TINYINT(1) DEFAULT NULL;
ALTER TABLE Period_audit ADD dateStartPlanningReport DATE DEFAULT NULL, ADD dateEndPlanningReport DATE DEFAULT NULL, ADD isPlanningReportEnabled TINYINT(1) DEFAULT NULL;

UPDATE `Period` SET `dateStartPlanningReport` = '2015-01-01',dateEndPlanningReport = '2015-12-31', isPlanningReportEnabled = '1' WHERE `Period`.`id` = 2;