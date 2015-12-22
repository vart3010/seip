-- ACTUALIZAR EL PERÍODO DE LAS PARADAS DE PLANTA EXISTENTES
UPDATE seip_report_plant_stop_planning AS p SET p.period_id = 2;

-- CURSOR DE PARADAS DE PLANTA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idRPSP,monthRPSP,totalStopsRPSP,totalHoursRPSP,idReportPlant INT;
  DECLARE curReportPlantStopPlanning CURSOR FOR SELECT r.id,r.`month`,r.total_stops,r.total_hours,r.plantReport_id FROM seip_report_plant_stop_planning AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportPlantStopPlanning;

  read_loop: LOOP
    FETCH curReportPlantStopPlanning INTO idRPSP,monthRPSP,totalStopsRPSP,totalHoursRPSP,idReportPlant;
    IF flag THEN
      LEAVE read_loop;
    END IF;
			INSERT INTO seip_report_plant_stop_planning(`month`,total_stops,total_hours,enabled,created_at,updated_at,deletedAt,plantReport_id,period_id,parent_id) 
VALUES(monthRPSP,totalStopsRPSP,totalHoursRPSP,1,NOW(),NOW(),null,idReportPlant,3,idRPSP);
        
  END LOOP;

  CLOSE curReportPlantStopPlanning;
END

-- EJECUTAR CURSOR DE PARADAS DE PLANTA
CALL CursorReportPlantStopPlanning();

-- ACTUALIZAR IDREPORTPLANT EN PARADAS DE PLANTA
UPDATE seip_report_plant_stop_planning AS r SET r.plantReport_id = 
(SELECT p.id FROM seip_report_plant AS p 
WHERE p.parent_id = r.plantReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DE LOS DÍAS DE PARADAS DE PLANTA EXISTENTES
UPDATE seip_report_product_report_day_stop SET period_id = 2;

-- CURSOR DE DÍAS DE PARADAS DE PLANTA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE dayRPRDS VARCHAR(20);
  DECLARE hoursRPRDS,idPlantStopPlanning,otherTimeRPRDS,idStopTime INT;
  DECLARE curReportProductReportDayStop CURSOR FOR SELECT r.`day`,r.hours,r.plantStopPlanning_id,r.other_time,r.stopTime_id FROM seip_report_product_report_day_stop AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductReportDayStop;

  read_loop: LOOP
    FETCH curReportProductReportDayStop INTO dayRPRDS,hoursRPRDS,idPlantStopPlanning,otherTimeRPRDS,idStopTime;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_report_day_stop(`day`,hours,enabled,createdAt,updatedAt,deletedAt,plantStopPlanning_id,other_time,stopTime_id,period_id) 
VALUES(dayRPRDS,hoursRPRDS,1,NOW(),NOW(),null,idPlantStopPlanning,otherTimeRPRDS,idStopTime,3);
        
  END LOOP;

  CLOSE curReportProductReportDayStop;
END

-- EJECUTAR CURSOR DE DÍAS DE PARADAS DE PLANTA
CALL CursorReportProductReportDayStop();

-- ACTUALIZAR IDPLANTSTOPPLANNING EN LOS DÍAS DE PARADAS DE PLANTA
UPDATE seip_report_product_report_day_stop AS r SET r.plantStopPlanning_id = 
(SELECT p.id FROM seip_report_plant_stop_planning AS p 
WHERE p.parent_id = r.plantStopPlanning_id)
WHERE r.period_id = 3;

-- ACTUALIZAR LA FECHA DE LOS DÍAS DE PARADAS DE PLANTA CREADOS
UPDATE seip_report_product_report_day_stop SET `day` = CONCAT('2016',DATE_FORMAT(`day`,'-%c-%d %H:%i:%S')) WHERE period_id = 3;

-- ACTUALIZAR EL PERÍODO DE LOS SERVICIOS DE LA PLANTA
UPDATE seip_report_plant_service_planning SET period_id = 2;

-- CURSOR DE LOS SERVICIOS DE LA PLANTA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idReportPlantServicePlanning,idService,idPlantReport INT;
  DECLARE aliquotRPSP FLOAT;
  DECLARE curReportPlantServicePlanning CURSOR FOR SELECT r.id,r.service_id,r.plantReport_id,aliquot FROM seip_report_plant_service_planning AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportPlantServicePlanning;

  read_loop: LOOP
    FETCH curReportPlantServicePlanning INTO idReportPlantServicePlanning,idService,idPlantReport,aliquotRPSP;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_plant_service_planning(service_id,enabled,createdAt,updatedAt,deletedAt,plantReport_id,aliquot,parent_id,period_id) 
VALUES(idService,1,NOW(),NOW(),null,idPlantReport,aliquotRPSP,idReportPlantServicePlanning,3);
        
  END LOOP;

  CLOSE curReportPlantServicePlanning;
END

-- EJECUTAR CURSOR DE LOS SERVICIOS DE LA PLANTA
CALL CursorReportPlantServicePlanning();

-- ACTUALIZAR IDPLANTREPORT EN LOS SERVICIOS DE LA PLANTA
UPDATE seip_report_plant_service_planning AS r SET r.plantReport_id = 
(SELECT p.id FROM seip_report_plant AS p 
WHERE p.parent_id = r.plantReport_id)
WHERE r.period_id = 3;