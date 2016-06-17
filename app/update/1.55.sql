-- QUERYS DEL RELEASE 1.55

-- ACTUALIZACIÓN DE OBJETOS DE GESTIÓN PARA ACOMODAR RELACIONES DE PERÍODOS DIFERENTES
UPDATE `seip_objetive` SET `period_id`='2' WHERE (`id`='1711');
DELETE FROM `seip_objetives_parents` WHERE (`children_id`='1652') AND (`parent_id`='2');
UPDATE `ArrangementProgram` SET `tactical_objective_id`='2915', `operational_objective_id`='2938' WHERE (`id`='5963');
UPDATE `ArrangementProgram` SET `tactical_objective_id`='2681', `operational_objective_id`='2692' WHERE (`id`='5522');
