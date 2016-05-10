-- BLOQUEO GENERAL
UPDATE seip_user AS u SET u.locked = 1;

-- DESBLOQUEO DE LOS USUARIOS QUE APRUEBAN PG OPERATIVOS
UPDATE seip_user AS u SET u.locked = 0 
WHERE u.id IN (SELECT user_id FROM Configuration_ArrangementProgram_Approve_Operative);

-- DESBLOQUEO DE LOS USUARIOS QUE APRUEBAN PG TÁCTICOS
UPDATE seip_user AS u SET u.locked = 0 WHERE u.id IN (SELECT user_id FROM Configuration_ArrangementProgram_Approve_Tactical);

-- DESBLOQUEO DE LOS USUARIOS QUE NOTIFICAN PG
UPDATE seip_user AS u SET u.locked = 0 
WHERE u.id IN (SELECT user_id FROM Configuration_ArrangementProgram_Notify);

-- DESBLOQUEO DE LOS USUARIOS QUE REVISAN PG
UPDATE seip_user AS u SET u.locked = 0 WHERE u.id IN (SELECT user_id FROM Configuration_ArrangementProgram_Reviser);

-- DESBLOQUEO DE LOS USUARIOS CON ROL ADMINISTRADOR, SUPERADMINISTRADOR Y AUXILIARES
UPDATE seip_user AS u SET u.locked = 0 
WHERE u.id IN (SELECT fu.user_id FROM fos_user_user_rol AS fu INNER JOIN seip_c_rol AS r ON (r.id = fu.rol_id) WHERE r.level >= 7000);

-- DESBLOQUEO DE LOS USUARIOS CON ROL MAYOR O IGUAL A SUPERVISOR EN LA GERENCIA DE PLANIFICACIÓN ESTRATÉGICA
UPDATE seip_user AS u SET u.locked = 0 
WHERE u.fk_gerencia = 14 AND u.id IN (SELECT fu.user_id FROM fos_user_user_rol AS fu INNER JOIN seip_c_rol AS r ON (r.id = fu.rol_id) WHERE r.level >= 2000);

-- DESBLOQUEO DE LOS USUARIOS CON ROL GERENTE 1RA LÍNEA Y GERENTE GENERAL COMPLEJO
UPDATE seip_user AS u SET u.locked = 0 
WHERE u.id IN (SELECT fu.user_id FROM fos_user_user_rol AS fu INNER JOIN seip_c_rol AS r ON (r.id = fu.rol_id) WHERE r.level >= 4000 AND r.level <= 5000);

-- DESBLOQUEO DE LOS USUARIOS CON CUALQUIER ROL DE LA GERENCIA DE CONTROL ESTADÍSTICO E INFORMACIÓN
UPDATE seip_user AS u SET u.locked = 0 WHERE u.fk_gerencia = 14 AND u.fk_gerencia_second = 50;