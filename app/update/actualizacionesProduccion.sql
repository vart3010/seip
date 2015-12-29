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

-- ACTUALIZAR EL PERÍODO DEL DETALLE DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_product_detail_daily_month SET period_id = 2;

-- CURSOR DEL DETALLE DE LA PLANIFICACIÓN DEL PRODUCTO
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE monthRPDDM,idProductReport INT;
	DECLARE totalGrossPlanRPDDM,totalNetPlanRPDDM,day1GrossPlanRPDDM,day2GrossPlanRPDDM,day3GrossPlanRPDDM,day4GrossPlanRPDDM,day5GrossPlanRPDDM,day6GrossPlanRPDDM,day7GrossPlanRPDDM,day8GrossPlanRPDDM,day9GrossPlanRPDDM,day10GrossPlanRPDDM,day11GrossPlanRPDDM,day12GrossPlanRPDDM,day13GrossPlanRPDDM,day14GrossPlanRPDDM,day15GrossPlanRPDDM,day16GrossPlanRPDDM,day17GrossPlanRPDDM,day18GrossPlanRPDDM,day19GrossPlanRPDDM,day20GrossPlanRPDDM,day21GrossPlanRPDDM,day22GrossPlanRPDDM,day23GrossPlanRPDDM,day24GrossPlanRPDDM,day25GrossPlanRPDDM,day26GrossPlanRPDDM,day27GrossPlanRPDDM,day28GrossPlanRPDDM,day29GrossPlanRPDDM,day30GrossPlanRPDDM,day31GrossPlanRPDDM,day1NetPlanRPDDM,day2NetPlanRPDDM,day3NetPlanRPDDM,day4NetPlanRPDDM,day5NetPlanRPDDM,day6NetPlanRPDDM,day7NetPlanRPDDM,day8NetPlanRPDDM,day9NetPlanRPDDM,day10NetPlanRPDDM,day11NetPlanRPDDM,day12NetPlanRPDDM,day13NetPlanRPDDM,day14NetPlanRPDDM,day15NetPlanRPDDM,day16NetPlanRPDDM,day17NetPlanRPDDM,day18NetPlanRPDDM,day19NetPlanRPDDM,day20NetPlanRPDDM,day21NetPlanRPDDM,day22NetPlanRPDDM,day23NetPlanRPDDM,day24NetPlanRPDDM,day25NetPlanRPDDM,day26NetPlanRPDDM,day27NetPlanRPDDM,day28NetPlanRPDDM,day29NetPlanRPDDM,day30NetPlanRPDDM,day31NetPlanRPDDM FLOAT;
  DECLARE curReportProductDetailDailyMonth CURSOR FOR SELECT r.`month`,r.totalGrossPlan,r.totalNetPlan,r.day1GrossPlan,r.day2GrossPlan,r.day3GrossPlan,r.day4GrossPlan,r.day5GrossPlan,r.day6GrossPlan,r.day7GrossPlan,r.day8GrossPlan,r.day9GrossPlan,r.day10GrossPlan,r.day11GrossPlan,r.day12GrossPlan,r.day13GrossPlan,r.day14GrossPlan,r.day15GrossPlan,r.day16GrossPlan,r.day17GrossPlan,r.day18GrossPlan,r.day19GrossPlan,r.day20GrossPlan,r.day21GrossPlan,r.day22GrossPlan,r.day23GrossPlan,r.day24GrossPlan,r.day25GrossPlan,r.day26GrossPlan,r.day27GrossPlan,r.day28GrossPlan,r.day29GrossPlan,r.day30GrossPlan,r.day31GrossPlan,r.day1NetPlan,r.day2NetPlan,r.day3NetPlan,r.day4NetPlan,r.day5NetPlan,r.day6NetPlan,r.day7NetPlan,r.day8NetPlan,r.day9NetPlan,r.day10NetPlan,r.day11NetPlan,r.day12NetPlan,r.day13NetPlan,r.day14NetPlan,r.day15NetPlan,r.day16NetPlan,r.day17NetPlan,r.day18NetPlan,r.day19NetPlan,r.day20NetPlan,r.day21NetPlan,r.day22NetPlan,r.day23NetPlan,r.day24NetPlan,r.day25NetPlan,r.day26NetPlan,r.day27NetPlan,r.day28NetPlan,r.day29NetPlan,r.day30NetPlan,r.day31NetPlan ,r.productReport_id FROM seip_report_product_report_product_detail_daily_month AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductDetailDailyMonth;

  read_loop: LOOP
    FETCH curReportProductDetailDailyMonth INTO monthRPDDM,totalGrossPlanRPDDM,totalNetPlanRPDDM,day1GrossPlanRPDDM,day2GrossPlanRPDDM,day3GrossPlanRPDDM,day4GrossPlanRPDDM,day5GrossPlanRPDDM,day6GrossPlanRPDDM,day7GrossPlanRPDDM,day8GrossPlanRPDDM,day9GrossPlanRPDDM,day10GrossPlanRPDDM,day11GrossPlanRPDDM,day12GrossPlanRPDDM,day13GrossPlanRPDDM,day14GrossPlanRPDDM,day15GrossPlanRPDDM,day16GrossPlanRPDDM,day17GrossPlanRPDDM,day18GrossPlanRPDDM,day19GrossPlanRPDDM,day20GrossPlanRPDDM,day21GrossPlanRPDDM,day22GrossPlanRPDDM,day23GrossPlanRPDDM,day24GrossPlanRPDDM,day25GrossPlanRPDDM,day26GrossPlanRPDDM,day27GrossPlanRPDDM,day28GrossPlanRPDDM,day29GrossPlanRPDDM,day30GrossPlanRPDDM,day31GrossPlanRPDDM,day1NetPlanRPDDM,day2NetPlanRPDDM,day3NetPlanRPDDM,day4NetPlanRPDDM,day5NetPlanRPDDM,day6NetPlanRPDDM,day7NetPlanRPDDM,day8NetPlanRPDDM,day9NetPlanRPDDM,day10NetPlanRPDDM,day11NetPlanRPDDM,day12NetPlanRPDDM,day13NetPlanRPDDM,day14NetPlanRPDDM,day15NetPlanRPDDM,day16NetPlanRPDDM,day17NetPlanRPDDM,day18NetPlanRPDDM,day19NetPlanRPDDM,day20NetPlanRPDDM,day21NetPlanRPDDM,day22NetPlanRPDDM,day23NetPlanRPDDM,day24NetPlanRPDDM,day25NetPlanRPDDM,day26NetPlanRPDDM,day27NetPlanRPDDM,day28NetPlanRPDDM,day29NetPlanRPDDM,day30NetPlanRPDDM,day31NetPlanRPDDM,idProductReport;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_report_product_detail_daily_month(`month`,totalGrossPlan,totalGrossReal,grossPercentage,totalNetPlan,totalNetReal,netPercentage,day1GrossPlan,day1GrossReal,day2GrossPlan,day2GrossReal,day3GrossPlan,day3GrossReal,day4GrossPlan,day4GrossReal,day5GrossPlan,day5GrossReal,day6GrossPlan,day6GrossReal,day7GrossPlan,day7GrossReal,day8GrossPlan,day8GrossReal,day9GrossPlan,day9GrossReal,day10GrossPlan,day10GrossReal,day11GrossPlan,day11GrossReal,day12GrossPlan,day12GrossReal,day13GrossPlan,day13GrossReal,day14GrossPlan,day14GrossReal,day15GrossPlan,day15GrossReal,day16GrossPlan,day16GrossReal,day17GrossPlan,day17GrossReal,day18GrossPlan,day18GrossReal,day19GrossPlan,day19GrossReal,day20GrossPlan,day20GrossReal,day21GrossPlan,day21GrossReal,day22GrossPlan,day22GrossReal,day23GrossPlan,day23GrossReal,day24GrossPlan,day24GrossReal,day25GrossPlan,day25GrossReal,day26GrossPlan,day26GrossReal,day27GrossPlan,day27GrossReal,day28GrossPlan,day28GrossReal,day29GrossPlan,day29GrossReal,day30GrossPlan,day30GrossReal,day31GrossPlan,day31GrossReal,day1NetPlan,day1NetReal,day2NetPlan,day2NetReal,day3NetPlan,day3NetReal,day4NetPlan,day4NetReal,day5NetPlan,day5NetReal,day6NetPlan,day6NetReal,day7NetPlan,day7NetReal,day8NetPlan,day8NetReal,day9NetPlan,day9NetReal,day10NetPlan,day10NetReal,day11NetPlan,day11NetReal,day12NetPlan,day12NetReal,day13NetPlan,day13NetReal,day14NetPlan,day14NetReal,day15NetPlan,day15NetReal,day16NetPlan,day16NetReal,day17NetPlan,day17NetReal,day18NetPlan,day18NetReal,day19NetPlan,day19NetReal,day20NetPlan,day20NetReal,day21NetPlan,day21NetReal,day22NetPlan,day22NetReal,day23NetPlan,day23NetReal,day24NetPlan,day24NetReal,day25NetPlan,day25NetReal,day26NetPlan,day26NetReal,day27NetPlan,day27NetReal,day28NetPlan,day28NetReal,day29NetPlan,day29NetReal,day30NetPlan,day30NetReal,day31NetPlan,day31NetReal,enabled,createdAt,updatedAt,deletedAt,productReport_id,day1_observation,day2_observation,day3_observation,day4_observation,day5_observation,day6_observation,day7_observation,day8_observation,day9_observation,day10_observation,day11_observation,day12_observation,day13_observation,day14_observation,day15_observation,day16_observation,day17_observation,day18_observation,day19_observation,day20_observation,day21_observation,day22_observation,day23_observation,day24_observation,day25_observation,day26_observation,day27_observation,day28_observation,day29_observation,day30_observation,day31_observation,day1_status,day2_status,day3_status,day4_status,day5_status,day6_status,day7_status,day8_status,day9_status,day10_status,day11_status,day12_status,day13_status,day14_status,day15_status,day16_status,day17_status,day18_status,day19_status,day20_status,day21_status,day22_status,day23_status,day24_status,day25_status,day26_status,day27_status,day28_status,day29_status,day30_status,day31_status,period_id) 
VALUES(monthRPDDM,totalGrossPlanRPDDM,0,0,totalNetPlanRPDDM,0,0,day1GrossPlanRPDDM,0,day2GrossPlanRPDDM,0,day3GrossPlanRPDDM,0,day4GrossPlanRPDDM,0,day5GrossPlanRPDDM,0,day6GrossPlanRPDDM,0,day7GrossPlanRPDDM,0,day8GrossPlanRPDDM,0,day9GrossPlanRPDDM,0,day10GrossPlanRPDDM,0,day11GrossPlanRPDDM,0,day12GrossPlanRPDDM,0,day13GrossPlanRPDDM,0,day14GrossPlanRPDDM,0,day15GrossPlanRPDDM,0,day16GrossPlanRPDDM,0,day17GrossPlanRPDDM,0,day18GrossPlanRPDDM,0,day19GrossPlanRPDDM,0,day20GrossPlanRPDDM,0,day21GrossPlanRPDDM,0,day22GrossPlanRPDDM,0,day23GrossPlanRPDDM,0,day24GrossPlanRPDDM,0,day25GrossPlanRPDDM,0,day26GrossPlanRPDDM,0,day27GrossPlanRPDDM,0,day28GrossPlanRPDDM,0,day29GrossPlanRPDDM,0,day30GrossPlanRPDDM,0,day31GrossPlanRPDDM,0,day1NetPlanRPDDM,0,day2NetPlanRPDDM,0,day3NetPlanRPDDM,0,day4NetPlanRPDDM,0,day5NetPlanRPDDM,0,day6NetPlanRPDDM,0,day7NetPlanRPDDM,0,day8NetPlanRPDDM,0,day9NetPlanRPDDM,0,day10NetPlanRPDDM,0,day11NetPlanRPDDM,0,day12NetPlanRPDDM,0,day13NetPlanRPDDM,0,day14NetPlanRPDDM,0,day15NetPlanRPDDM,0,day16NetPlanRPDDM,0,day17NetPlanRPDDM,0,day18NetPlanRPDDM,0,day19NetPlanRPDDM,0,day20NetPlanRPDDM,0,day21NetPlanRPDDM,0,day22NetPlanRPDDM,0,day23NetPlanRPDDM,0,day24NetPlanRPDDM,0,day25NetPlanRPDDM,0,day26NetPlanRPDDM,0,day27NetPlanRPDDM,0,day28NetPlanRPDDM,0,day29NetPlanRPDDM,0,day30NetPlanRPDDM,0,day31NetPlanRPDDM,0,1,NOW(),NOW(),null,idProductReport,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3);
        
  END LOOP;

  CLOSE curReportProductDetailDailyMonth;
END

-- EJECUTAR CURSOR DEL DETALLE DE LA PLANIFICACIÓN DEL PRODUCTO
CALL CursorReportProductDetailDailyMonth();

-- ACTUALIZAR IDPRODUCTREPORT DEL DETALLE DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_product_report_product_detail_daily_month AS r SET r.productReport_id = 
(SELECT p.id FROM seip_report_product_report AS p 
WHERE p.parent_id = r.productReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DE LA PLANIFICACIÓN DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_product_raw_material_consumption_planning SET period_id = 2;

-- CURSOR DE LA PLANIFICACIÓN DEL CONSUMO DE MATERIA PRIMA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idRPRMCP,idProduct,typeRPRMCP,idProductReport,automaticCalculationPlanRPRMCP INT;
  DECLARE totalPlanRPRMCP,aliquotRPRMCP FLOAT;
  DECLARE curReportProductRawMaterialConsumptionPlanning CURSOR FOR SELECT r.id,r.product_id,r.type,r.productReport_id,r.automaticCalculationPlan,r.totalPlan,r.aliquot FROM seip_report_product_raw_material_consumption_planning AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductRawMaterialConsumptionPlanning;

  read_loop: LOOP
    FETCH curReportProductRawMaterialConsumptionPlanning INTO idRPRMCP,idProduct,typeRPRMCP,idProductReport,automaticCalculationPlanRPRMCP,totalPlanRPRMCP,aliquotRPRMCP;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_raw_material_consumption_planning(product_id,type,totalPlan,totalReal,percentage,enabled,createdAt,updatedAt,deletedAt,productReport_id,aliquot,automaticCalculationPlan,period_id,parent_id) 
VALUES(idProduct,typeRPRMCP,totalPlanRPRMCP,0,0,1,NOW(),NOW(),null,idProductReport,aliquotRPRMCP,automaticCalculationPlanRPRMCP,3,idRPRMCP);
        
  END LOOP;

  CLOSE curReportProductRawMaterialConsumptionPlanning;
END

-- EJECUTAR CURSOR DE LA PLANIFICACIÓN DEL CONSUMO DE MATERIA PRIMA
CALL CursorReportProductRawMaterialConsumptionPlanning(); 

-- ACTUALIZAR IDPRODUCTREPORT DE LA PLANFICIACIÓN DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_product_raw_material_consumption_planning AS r SET r.productReport_id = 
(SELECT p.id FROM seip_report_product_report AS p 
WHERE p.parent_id = r.productReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_product_raw_material_consumption SET period_id = 2;

-- CURSOR DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE idRPDRMC,monthRPDRMC,idRawMaterialConsumptionPlanning INT;
  DECLARE monthBudgetRPDRMC,totalPlanRPDRMC,day1PlanRPDRMC,day2PlanRPDRMC,day3PlanRPDRMC,day4PlanRPDRMC,day5PlanRPDRMC,day6PlanRPDRMC,day7PlanRPDRMC,day8PlanRPDRMC,day9PlanRPDRMC,day10PlanRPDRMC,day11PlanRPDRMC,day12PlanRPDRMC,day13PlanRPDRMC,day14PlanRPDRMC,day15PlanRPDRMC,day16PlanRPDRMC,day17PlanRPDRMC,day18PlanRPDRMC,day19PlanRPDRMC,day20PlanRPDRMC,day21PlanRPDRMC,day22PlanRPDRMC,day23PlanRPDRMC,day24PlanRPDRMC,day25PlanRPDRMC,day26PlanRPDRMC,day27PlanRPDRMC,day28PlanRPDRMC,day29PlanRPDRMC,day30PlanRPDRMC,day31PlanRPDRMC FLOAT;
  DECLARE curReportProductDetailRawMaterialConsumption CURSOR FOR SELECT r.id,r.`month`,r.rawMaterialConsumptionPlanning_id,r.month_budget,r.totalPlan,r.day1Plan,r.day2Plan,r.day3Plan,r.day4Plan,r.day5Plan,r.day6Plan,r.day7Plan,r.day8Plan,r.day9Plan,r.day10Plan,r.day11Plan,r.day12Plan,r.day13Plan,r.day14Plan,r.day15Plan,r.day16Plan,r.day17Plan,r.day18Plan,r.day19Plan,r.day20Plan,r.day21Plan,r.day22Plan,r.day23Plan,r.day24Plan,r.day25Plan,r.day26Plan,r.day27Plan,r.day28Plan,r.day29Plan,r.day30Plan,r.day31Plan FROM seip_report_product_raw_material_consumption AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductDetailRawMaterialConsumption;

  read_loop: LOOP
    FETCH curReportProductDetailRawMaterialConsumption INTO idRPDRMC,monthRPDRMC,idRawMaterialConsumptionPlanning,monthBudgetRPDRMC,totalPlanRPDRMC,day1PlanRPDRMC,day2PlanRPDRMC,day3PlanRPDRMC,day4PlanRPDRMC,day5PlanRPDRMC,day6PlanRPDRMC,day7PlanRPDRMC,day8PlanRPDRMC,day9PlanRPDRMC,day10PlanRPDRMC,day11PlanRPDRMC,day12PlanRPDRMC,day13PlanRPDRMC,day14PlanRPDRMC,day15PlanRPDRMC,day16PlanRPDRMC,day17PlanRPDRMC,day18PlanRPDRMC,day19PlanRPDRMC,day20PlanRPDRMC,day21PlanRPDRMC,day22PlanRPDRMC,day23PlanRPDRMC,day24PlanRPDRMC,day25PlanRPDRMC,day26PlanRPDRMC,day27PlanRPDRMC,day28PlanRPDRMC,day29PlanRPDRMC,day30PlanRPDRMC,day31PlanRPDRMC;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_raw_material_consumption(month_budget,`month`,totalPlan,totalReal,percentage,day1Plan,day1Real,day2Plan,day2Real,day3Plan,day3Real,day4Plan,day4Real,day5Plan,day5Real,day6Plan,day6Real,day7Plan,day7Real,day8Plan,day8Real,day9Plan,day9Real,day10Plan,day10Real,day11Plan,day11Real,day12Plan,day12Real,day13Plan,day13Real,day14Plan,day14Real,day15Plan,day15Real,day16Plan,day16Real,day17Plan,day17Real,day18Plan,day18Real,day19Plan,day19Real,day20Plan,day20Real,day21Plan,day21Real,day22Plan,day22Real,day23Plan,day23Real,day24Plan,day24Real,day25Plan,day25Real,day26Plan,day26Real,day27Plan,day27Real,day28Plan,day28Real,day29Plan,day29Real,day30Plan,day30Real,day31Plan,day31Real,enabled,createdAt,updatedAt,deletedAt,rawMaterialConsumptionPlanning_id,period_id,parent_id) 
VALUES(monthBudgetRPDRMC,monthRPDRMC,totalPlanRPDRMC,0,0,day1PlanRPDRMC,0,day2PlanRPDRMC,0,day3PlanRPDRMC,0,day4PlanRPDRMC,0,day5PlanRPDRMC,0,day6PlanRPDRMC,0,day7PlanRPDRMC,0,day8PlanRPDRMC,0,day9PlanRPDRMC,0,day10PlanRPDRMC,0,day11PlanRPDRMC,0,day12PlanRPDRMC,0,day13PlanRPDRMC,0,day14PlanRPDRMC,0,day15PlanRPDRMC,0,day16PlanRPDRMC,0,day17PlanRPDRMC,0,day18PlanRPDRMC,0,day19PlanRPDRMC,0,day20PlanRPDRMC,0,day21PlanRPDRMC,0,day22PlanRPDRMC,0,day23PlanRPDRMC,0,day24PlanRPDRMC,0,day25PlanRPDRMC,0,day26PlanRPDRMC,0,day27PlanRPDRMC,0,day28PlanRPDRMC,0,day29PlanRPDRMC,0,day30PlanRPDRMC,0,day31PlanRPDRMC,0,1,NOW(),NOW(),null,idRawMaterialConsumptionPlanning,3,idRPDRMC);
        
  END LOOP;

  CLOSE curReportProductDetailRawMaterialConsumption;
END

-- EJECUTAR CURSOR DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
CALL CursorReportProductDetailRawMaterialConsumption();

-- ACTUALIZAR IDRAWMATERIALCONSUMPTIONPLANNING DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_product_raw_material_consumption AS r SET r.rawMaterialConsumptionPlanning_id = 
(SELECT p.id FROM seip_report_product_raw_material_consumption_planning AS p 
WHERE p.parent_id = r.rawMaterialConsumptionPlanning_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DEL RANGO DE DISTRIBUCIÓN DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_raw_material_consumption_report_range SET period_id = 2;

-- CURSOR DEL RANGO DE DISTRIBUCIÓN DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE dateFromRRMCRR,dateEndRRMCRR VARCHAR(20);
  DECLARE typeRRMCRR,idDetailRawMaterialConsumption INT;
  DECLARE valueRRMCRR FLOAT;
  DECLARE curReportRawMaterialConsumptionReportRange CURSOR FOR SELECT r.date_from,r.date_end,r.type,r.detailRawMaterialConsumption_id,r.`value` FROM seip_report_raw_material_consumption_report_range AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportRawMaterialConsumptionReportRange;

  read_loop: LOOP
    FETCH curReportRawMaterialConsumptionReportRange INTO dateFromRRMCRR,dateEndRRMCRR,typeRRMCRR,idDetailRawMaterialConsumption,valueRRMCRR;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_raw_material_consumption_report_range(date_from,date_end,type,`value`,enabled,createdAt,updatedAt,deletedAt,detailRawMaterialConsumption_id,period_id) 
VALUES(dateFromRRMCRR,dateEndRRMCRR,typeRRMCRR,valueRRMCRR,1,NOW(),NOW(),null,idDetailRawMaterialConsumption,3);
        
  END LOOP;

  CLOSE curReportRawMaterialConsumptionReportRange;
END

-- EJECUTAR EL CURSOR DEL RANGO DE DISTRIBUCIÓN DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
CALL CursorReportRawMaterialConsumptionReportRange();

-- ACTUALIZAR IDDETAILRAWMATERIALCONSUMPTION DEL RANGO DE DISTRIBUCIÓN DEL DETALLE DEL CONSUMO DE MATERIA PRIMA
UPDATE seip_report_raw_material_consumption_report_range AS r SET r.detailRawMaterialConsumption_id = 
(SELECT p.id FROM seip_report_product_raw_material_consumption AS p 
WHERE p.parent_id = r.detailRawMaterialConsumption_id)
WHERE r.period_id = 3;

-- ACTUALIZAR LA FECHA DE LOS DÍAS DEL RANGO DE LA PLANIFICACIÓN DEL PRODUCTO
UPDATE seip_report_raw_material_consumption_report_range SET `date_from` = CONCAT('2016',DATE_FORMAT(`date_from`,'-%c-%d %H:%i:%S')) WHERE period_id = 3;
UPDATE seip_report_raw_material_consumption_report_range SET `date_end` = CONCAT('2016',DATE_FORMAT(`date_end`,'-%c-%d %H:%i:%S')) WHERE period_id = 3;

-- ACTUALIZAR EL PERÍODO DEL INVENTARIO DEL PRODUCTO
UPDATE seip_report_product_inventory SET period_id = 2;

-- CURSOR DEL INVENTARIO DEL PRODUCTO
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE monthRPI,idProductReport INT;
  DECLARE curReportProductInventory CURSOR FOR SELECT r.`month`,r.productReport_id FROM seip_report_product_inventory AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductInventory;

  read_loop: LOOP
    FETCH curReportProductInventory INTO monthRPI,idProductReport;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_inventory(`month`,total,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,enabled,createdAt,updatedAt,deletedAt,productReport_id,period_id) 
VALUES(monthRPI,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,NOW(),NOW(),null,idProductReport,3);
        
  END LOOP;

  CLOSE curReportProductInventory;
END

-- EJECUTAR CURSOR DEL INVENTARIO DEL PRODUCTO
CALL CursorReportProductInventory();

-- ACTUALIZAR IDPRODUCTREPORT DEL INVENTARIO DEL PRODUCTO
UPDATE seip_report_product_inventory AS r SET r.productReport_id = 
(SELECT p.id FROM seip_report_product_report AS p 
WHERE p.parent_id = r.productReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR EL PERÍODO DE LA PNR DEL PRODUCTO
UPDATE seip_report_product_unrealized_production SET period_id = 2;

-- CURSOR DE LA PNR DEL PRODUCTO
BEGIN
  DECLARE flag INT DEFAULT FALSE;
  DECLARE monthRPUP,idProductReport INT;
  DECLARE curReportProductUnrealizedProduction CURSOR FOR SELECT r.`month`,r.productReport_id FROM seip_report_product_unrealized_production AS r;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = TRUE;

  OPEN curReportProductUnrealizedProduction;

  read_loop: LOOP
    FETCH curReportProductUnrealizedProduction INTO monthRPUP,idProductReport;
    IF flag THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO seip_report_product_unrealized_production(`month`,total,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,enabled,createdAt,updatedAt,deletedAt,productReport_id,day1Details_id,day2Details_id,day3Details_id,day4Details_id,day5Details_id,day6Details_id,day7Details_id,day8Details_id,day9Details_id,day10Details_id,day11Details_id,day12Details_id,day13Details_id,day14Details_id,day15Details_id,day16Details_id,day17Details_id,day18Details_id,day19Details_id,day20Details_id,day21Details_id,day22Details_id,day23Details_id,day24Details_id,day25Details_id,day26Details_id,day27Details_id,day28Details_id,day29Details_id,day30Details_id,day31Details_id,period_id) 
VALUES(monthRPUP,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,NOW(),NOW(),null,idProductReport,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,3);
        
  END LOOP;

  CLOSE curReportProductUnrealizedProduction;
END

-- EJECUTAR CURSOR DE LA PNR DEL PRODUCTO
CALL CursorReportProductUnrealizedProduct();

-- ACTUALIZAR IDPRODUCTREPORT DE LA PNR DEL PRODUCTO
UPDATE seip_report_product_unrealized_production AS r SET r.productReport_id = 
(SELECT p.id FROM seip_report_product_report AS p 
WHERE p.parent_id = r.productReport_id)
WHERE r.period_id = 3;

-- ACTUALIZAR OTRAS TABLAS DE PNR
UPDATE seip_report_product_unrealized_production_raw_material_required SET period_id = 2;