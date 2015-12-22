-- ACTUALIZAR EL PERÍODO DE LAS PARADAS DE PLANTA EXISTENTES
UPDATE seip_report_plant_stop_planning AS p SET p.period_id = 2;

-- CURSOR DE PARADAS DE PLANTA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE monthRPSP,totalStopsRPSP,totalHoursRPSP,idReportPlant INT;
  DECLARE curReportPlantStopPlanning CURSOR FOR SELECT r.`month`,r.total_stops,r.total_hours,r.plantReport_id FROM seip_report_plant_stop_planning AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportPlantStopPlanning;

  read_loop: LOOP
    FETCH curReportPlantStopPlanning INTO monthRPSP,totalStopsRPSP,totalHoursRPSP,idReportPlant;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_plant_stop_planning(`month`,total_stops,total_hours,enabled,created_at,updated_at,deletedAt,plantReport_id,period_id) 
VALUES(monthRPSP,totalStopsRPSP,totalHoursRPSP,1,NOW(),NOW(),null,idReportPlant,3);
        
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