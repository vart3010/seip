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

-- ACTUALIZAR EL PERÍODO DEL DETALLE DE LOS SERVICIOS DE LA PLANTA
UPDATE seip_report_plant_service_detail_consumer SET period_id = 2;

-- CURSOR DEL DETALLE DE LOS SERVICIOS DE LA PLANTA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idReportPlantServiceDetailConsumer,monthSDC,idConsumerPlanningService INT;
  DECLARE monthBudgetSDC,totalPlanSDC,day1PlanSDC,day2PlanSDC,day3PlanSDC,day4PlanSDC,day5PlanSDC,day6PlanSDC,day7PlanSDC,day8PlanSDC,day9PlanSDC,day10PlanSDC,day11PlanSDC,day12PlanSDC,day13PlanSDC,day14PlanSDC,day15PlanSDC,day16PlanSDC,day17PlanSDC,day18PlanSDC,day19PlanSDC,day20PlanSDC,day21PlanSDC,day22PlanSDC,day23PlanSDC,day24PlanSDC,day25PlanSDC,day26PlanSDC,day27PlanSDC,day28PlanSDC,day29PlanSDC,day30PlanSDC,day31PlanSDC FLOAT;
  DECLARE curReportPlantServiceDetailConsumer CURSOR FOR SELECT r.id,r.`month`,r.month_budget,r.totalPlan,r.day1Plan,r.day2Plan,r.day3Plan,r.day4Plan,r.day5Plan,r.day6Plan,r.day7Plan,r.day8Plan,r.day9Plan,r.day10Plan,r.day11Plan,r.day12Plan,r.day13Plan,r.day14Plan,r.day15Plan,r.day16Plan,r.day17Plan,r.day18Plan,r.day19Plan,r.day20Plan,r.day21Plan,r.day22Plan,r.day23Plan,r.day24Plan,r.day25Plan,r.day26Plan,r.day27Plan,r.day28Plan,r.day29Plan,r.day30Plan,r.day31Plan,r.consumerPlanningService_id FROM seip_report_plant_service_detail_consumer AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportPlantServiceDetailConsumer;

  read_loop: LOOP
    FETCH curReportPlantServiceDetailConsumer INTO idReportPlantServiceDetailConsumer,monthSDC,monthBudgetSDC,totalPlanSDC,day1PlanSDC,day2PlanSDC,day3PlanSDC,day4PlanSDC,day5PlanSDC,day6PlanSDC,day7PlanSDC,day8PlanSDC,day9PlanSDC,day10PlanSDC,day11PlanSDC,day12PlanSDC,day13PlanSDC,day14PlanSDC,day15PlanSDC,day16PlanSDC,day17PlanSDC,day18PlanSDC,day19PlanSDC,day20PlanSDC,day21PlanSDC,day22PlanSDC,day23PlanSDC,day24PlanSDC,day25PlanSDC,day26PlanSDC,day27PlanSDC,day28PlanSDC,day29PlanSDC,day30PlanSDC,day31PlanSDC,idConsumerPlanningService;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_plant_service_detail_consumer(month_budget,`month`,totalPlan,totalReal,percentage,day1Plan,day1Real,day2Plan,day2Real,day3Plan,day3Real,day4Plan,day4Real,day5Plan,day5Real,day6Plan,day6Real,day7Plan,day7Real,day8Plan,day8Real,day9Plan,day9Real,day10Plan,day10Real,day11Plan,day11Real,day12Plan,day12Real,day13Plan,day13Real,day14Plan,day14Real,day15Plan,day15Real,day16Plan,day16Real,day17Plan,day17Real,day18Plan,day18Real,day19Plan,day19Real,day20Plan,day20Real,day21Plan,day21Real,day22Plan,day22Real,day23Plan,day23Real,day24Plan,day24Real,day25Plan,day25Real,day26Plan,day26Real,day27Plan,day27Real,day28Plan,day28Real,day29Plan,day29Real,day30Plan,day30Real,day31Plan,day31Real,enabled,createdAt,updatedAt,deletedAt,consumerPlanningService_id,parent_id,period_id) 
VALUES(monthBudgetSDC,monthSDC,totalPlanSDC,0,0,day1PlanSDC,0,day2PlanSDC,0,day3PlanSDC,0,day4PlanSDC,0,day5PlanSDC,0,day6PlanSDC,0,day7PlanSDC,0,day8PlanSDC,0,day9PlanSDC,0,day10PlanSDC,0,day11PlanSDC,0,day12PlanSDC,0,day13PlanSDC,0,day14PlanSDC,0,day15PlanSDC,0,day16PlanSDC,0,day17PlanSDC,0,day18PlanSDC,0,day19PlanSDC,0,day20PlanSDC,0,day21PlanSDC,0,day22PlanSDC,0,day23PlanSDC,0,day24PlanSDC,0,day25PlanSDC,0,day26PlanSDC,0,day27PlanSDC,0,day28PlanSDC,0,day29PlanSDC,0,day30PlanSDC,0,day31PlanSDC,0,1,NOW(),NOW(),null,idConsumerPlanningService,idReportPlantServiceDetailConsumer,3);
        
  END LOOP;

  CLOSE curReportPlantServiceDetailConsumer;
END

-- EJECUTAR CURSOR DEL DETALLE DE LOS SERVICIOS DE LA PLANTA
CALL CursorReportPlantServiceDetailConsumer();

-- ACTUALIZAR IDREPORTPLANTSERVICEPLANNING DEL DETALLE DE LOS SERVICIOS DE LA PLANTA
UPDATE seip_report_plant_service_detail_consumer AS r SET r.consumerPlanningService_id = 
(SELECT p.id FROM seip_report_plant_service_planning AS p 
WHERE p.parent_id = r.consumerPlanningService_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_product_planning SET period_id = 2;

-- CURSOR DE LA PLANIFICACIÓN DEL PRODUCTO
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idRPPP,idProductReport,monthRPPP,typeRPPP INT;
	DECLARE totalMonthRPPP,dailyProductionCapacityRPPP,netProductionPercentageRPPP FLOAT;
  DECLARE curReportProductPlanningProduct CURSOR FOR SELECT r.id,r.`month`,r.type,r.total_month,r.daily_production_capacity,r.productReport_id,r.net_production_percentage FROM seip_report_product_report_product_planning AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductPlanningProduct;

  read_loop: LOOP
    FETCH curReportProductPlanningProduct INTO idRPPP,monthRPPP,typeRPPP,totalMonthRPPP,dailyProductionCapacityRPPP,idProductReport,netProductionPercentageRPPP;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_report_product_planning(`month`,type,total_month,daily_production_capacity,enabled,createdAt,updatedAt,deletedAt,productReport_id,net_production_percentage,period_id,parent_id) 
VALUES(monthRPPP,typeRPPP,totalMonthRPPP,dailyProductionCapacityRPPP,1,NOW(),NOW(),null,idProductReport,netProductionPercentageRPPP,3,idRPPP);
        
  END LOOP;

  CLOSE curReportProductPlanningProduct;
END

-- EJECUTAR CURSOR DE LA PLANIFICACIÓN DEL PRODUCTO
CALL CursorReportProductPlanningProduct();

-- ACTUALIZAR IDPRODUCTREPORT DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_product_planning AS r SET r.productReport_id = 
(SELECT p.id FROM seip_report_product_report AS p 
WHERE p.parent_id = r.productReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_range SET period_id = 2;

-- CURSOR DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE dateFromRPRR,dateEndRPRR VARCHAR(20);
  DECLARE idPlanningProduct,typeRPRR INT;
	DECLARE valueRPRR FLOAT;
  DECLARE curReportProductReportRange CURSOR FOR SELECT r.date_from,r.date_end,r.type,r.`value`,r.productPlanning_id FROM seip_report_product_report_range AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductReportRange;

  read_loop: LOOP
    FETCH curReportProductReportRange INTO dateFromRPRR,dateEndRPRR,typeRPRR,valueRPRR,idPlanningProduct;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_report_range(date_from,date_end,type,`value`,enabled,createdAt,updatedAt,deletedAt,productPlanning_id,period_id) 
VALUES(dateFromRPRR,dateEndRPRR,typeRPRR,valueRPRR,1,NOW(),NOW(),null,idPlanningProduct,3);
        
  END LOOP;

  CLOSE curReportProductReportRange;
END

-- EJECUTAR CURSOR DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
CALL CursorReportProductReportRange();

-- ACTUALIZAR IDPLANNINGPRODUCT DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_range AS r SET r.productPlanning_id = 
(SELECT p.id FROM seip_report_product_report_product_planning AS p 
WHERE p.parent_id = r.productPlanning_id)
WHERE r.period_id = 3;

-- ACTUALIZAR LA FECHA DE LOS DÍAS DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_range SET `date_from` = CONCAT('2016',DATE_FORMAT(`date_from`,'-%c-%d %H:%i:%S')) WHERE period_id = 3;
UPDATE seip_report_product_report_range SET `date_end` = CONCAT('2016',DATE_FORMAT(`date_end`,'-%c-%d %H:%i:%S')) WHERE period_id = 3;