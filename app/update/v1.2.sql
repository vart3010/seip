UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =9;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =10;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =11;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =12;
UPDATE  `seip_c_rol` SET  `typeRol` =  '1' WHERE  `seip_c_rol`.`id` =13;

INSERT INTO `BaseGroup` (`id`, `name`, `description`, `active`) VALUES
(1, 'General', 'Tiene la configuracion general del sistema', 1),
(2, 'Programa de gestion', 'Contiene la configuracion global del programa de gestion', 1);

INSERT INTO `Configuration` (`id`, `group_id`, `keyIndex`, `value`, `description`, `active`, `createdAt`, `updatedAt`) VALUES
(1, 2, 'ARRANGEMENT_PROGRAM_ASSOCIATED_TO', '2', 'Valor de programa de gestion asociado a (Por defecto)', 1, '0000-00-00 00:00:00', NULL);

--
-- Datos de tabla para la tabla `seip_gerencia_group`
--
INSERT INTO `seip_gerencia_group` (`id`, `fk_user_created_at`, `fk_user_updated_at`, `created_at`, `updated_at`, `description`, `group_name`, `enabled`) VALUES
(1, NULL, NULL, '2014-10-28 12:34:50', '2014-10-28 12:34:50', 'Comercializadoras', 'COME', 1),
(3, NULL, NULL, '2014-10-28 12:35:31', '2014-10-28 12:35:31', 'Complejos', 'COMP', 1),
(4, NULL, NULL, '2014-10-28 12:37:19', '2014-10-28 12:37:19', 'Proyectos', 'PROY', 1),
(5, NULL, NULL, '2014-10-28 12:37:35', '2014-10-28 12:37:35', 'Sede Corporativa', 'CORP', 1);


--
-- Estructura de tabla para la tabla `seip_monitor`
--

DROP TABLE IF EXISTS `seip_monitor`;
CREATE TABLE IF NOT EXISTS `seip_monitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_gerencia` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `objTacticOriginal` int(11) DEFAULT NULL,
  `objTacticVinculante` int(11) DEFAULT NULL,
  `indTacticOriginal` int(11) DEFAULT NULL,
  `indTacticVinculante` int(11) DEFAULT NULL,
  `objOperativeOriginal` int(11) DEFAULT NULL,
  `objOperativeVinculante` int(11) DEFAULT NULL,
  `indOperativeOriginal` int(11) DEFAULT NULL,
  `indOperativeVinculante` int(11) DEFAULT NULL,
  `arrangementProgramTactic` int(11) DEFAULT NULL,
  `arrangementProgramOperative` int(11) DEFAULT NULL,
  `objTacticOriginalReal` int(11) DEFAULT NULL,
  `objTacticVinculanteReal` int(11) DEFAULT NULL,
  `indTacticOriginalReal` int(11) DEFAULT NULL,
  `indTacticVinculanteReal` int(11) DEFAULT NULL,
  `objOperativeOriginalReal` int(11) DEFAULT NULL,
  `objOperativeVinculanteReal` int(11) DEFAULT NULL,
  `indOperativeOriginalReal` int(11) DEFAULT NULL,
  `indOperativeVinculanteReal` int(11) DEFAULT NULL,
  `arrangementProgramTacticReal` int(11) DEFAULT NULL,
  `arrangementProgramOperativeReal` int(11) DEFAULT NULL,
  `fk_type_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_24ACE4EF5C7076C9` (`fk_gerencia`),
  KEY `IDX_24ACE4EF93A209A1` (`fk_type_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `seip_monitor`
--

INSERT INTO `seip_monitor` (`id`, `fk_gerencia`, `created_at`, `updated_at`, `objTacticOriginal`, `objTacticVinculante`, `indTacticOriginal`, `indTacticVinculante`, `objOperativeOriginal`, `objOperativeVinculante`, `indOperativeOriginal`, `indOperativeVinculante`, `arrangementProgramTactic`, `arrangementProgramOperative`, `objTacticOriginalReal`, `objTacticVinculanteReal`, `indTacticOriginalReal`, `indTacticVinculanteReal`, `objOperativeOriginalReal`, `objOperativeVinculanteReal`, `indOperativeOriginalReal`, `indOperativeVinculanteReal`, `arrangementProgramTacticReal`, `arrangementProgramOperativeReal`, `fk_type_group`) VALUES
(1, 26, '2014-10-15 15:31:53', '2014-10-15 15:31:53', 2, 0, 2, 0, 10, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(2, 24, '2014-10-15 15:34:04', '2014-10-15 15:34:04', 7, 0, 7, 0, 12, 23, 15, 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(3, 19, '2014-10-15 15:34:39', '2014-10-15 15:34:39', 2, 0, 2, 0, 7, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(4, 25, '2014-10-15 15:35:10', '2014-10-15 15:35:10', 4, 0, 4, 0, 6, 24, 6, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(5, 20, '2014-10-15 15:35:37', '2014-10-15 15:35:37', 5, 1, 5, 1, 8, 23, 9, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(6, 22, '2014-10-15 15:36:05', '2014-10-15 15:36:05', 4, 0, 4, 0, 24, 56, 24, 56, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(7, 21, '2014-10-15 15:36:33', '2014-10-15 15:36:33', 4, 0, 4, 0, 4, 10, 4, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(8, 18, '2014-10-15 15:37:30', '2014-10-15 15:37:30', 8, 0, 7, 0, 45, 80, 45, 80, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 5),
(9, 27, '2014-10-15 15:38:24', '2014-10-15 15:38:24', 2, 0, 2, 0, 4, 16, 4, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(10, 23, '2014-10-15 15:38:53', '2014-10-15 15:38:53', 3, 0, 3, 0, 15, 24, 15, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(11, 11, '2014-10-15 15:39:33', '2014-10-15 15:39:33', 2, 3, 0, 3, 7, 18, 7, 18, 0, 0, 2, 0, 2, 0, 0, 2, 0, 2, 0, 0, 5),
(12, 29, '2014-10-15 15:40:02', '2014-10-15 15:40:02', 4, 6, 4, 6, 9, 30, 9, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(13, 15, '2014-10-15 15:40:25', '2014-10-15 15:40:25', 2, 0, 2, 0, 12, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(14, 12, '2014-10-15 15:40:49', '2014-10-15 15:40:49', 1, 0, 1, 0, 4, 0, 4, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 5),
(15, 30, '2014-10-15 15:41:17', '2014-10-15 15:41:17', 2, 0, 2, 0, 4, 11, 4, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(16, 16, '2014-10-15 15:41:40', '2014-10-15 15:41:40', 2, 0, 2, 0, 3, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(17, 28, '2014-10-15 15:42:03', '2014-10-15 15:42:03', 6, 0, 6, 0, 7, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(18, 31, '2014-10-15 15:42:45', '2014-10-15 15:42:45', 2, 0, 2, 0, 4, 11, 4, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(19, 4, '2014-10-15 15:43:20', '2014-10-15 15:43:20', 8, 0, 8, 0, 33, 0, 33, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4),
(20, 17, '2014-10-15 15:43:43', '2014-10-15 15:43:43', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4),
(21, 10, '2014-10-15 15:44:17', '2014-10-15 15:44:17', 11, 0, 11, 0, 46, 0, 46, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4),
(22, 3, '2014-10-15 15:44:36', '2014-10-15 15:44:36', 1, 0, 1, 0, 3, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(23, 2, '2014-10-15 15:44:58', '2014-10-15 15:44:58', 2, 0, 2, 0, 9, 0, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(24, 8, '2014-10-15 15:45:18', '2014-10-15 15:45:18', 3, 0, 3, 0, 7, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(25, 6, '2014-10-15 15:45:43', '2014-10-15 15:45:43', 2, 0, 2, 0, 6, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(26, 5, '2014-10-15 15:46:13', '2014-10-15 15:46:13', 2, 0, 2, 0, 5, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(27, 1, '2014-10-15 15:46:42', '2014-10-15 15:46:42', 9, 35, 9, 43, 41, 69, 74, 76, 0, 0, 1, 0, 1, 0, 2, 0, 2, 0, 0, 0, 3),
(28, 7, '2014-10-15 15:47:48', '2014-10-15 15:47:48', 10, 28, 10, 32, 58, 61, 75, 61, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3),
(29, 9, '2014-10-15 15:48:09', '2014-10-15 15:48:09', 4, 24, 11, 24, 14, 29, 23, 32, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3),
(30, 14, '2014-10-15 15:48:38', '2014-10-15 15:48:38', 5, 0, 5, 0, 19, 22, 22, 34, 0, 0, 2, 0, 3, 0, 4, 0, 2, 0, 0, 0, 5);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `seip_monitor`
--
ALTER TABLE `seip_monitor`
  ADD CONSTRAINT `FK_24ACE4EF5C7076C9` FOREIGN KEY (`fk_gerencia`) REFERENCES `seip_c_gerencia` (`id`),
  ADD CONSTRAINT `FK_24ACE4EF93A209A1` FOREIGN KEY (`fk_type_group`) REFERENCES `seip_gerencia_group` (`id`);

DELIMITER $$
--
-- Eventos
--
DROP EVENT `ObjTacticByGerencia`$$
CREATE DEFINER=`root`@`localhost` EVENT `ObjTacticByGerencia` ON SCHEDULE EVERY 10 MINUTE STARTS '2014-10-22 09:43:10' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
DECLARE gerencia  INT  UNSIGNED DEFAULT 1;
DECLARE maxGerencia INT UNSIGNED DEFAULT 32;

WHILE gerencia < maxGerencia DO
			IF gerencia != 13 THEN
						UPDATE seip_monitor as m SET objTacticOriginalReal = (SELECT count(o.id) FROM seip_objetive as o
LEFT JOIN seip_c_gerencia as g ON (o.fk_gerencia = g.id)
WHERE o.fk_objetive_level = 2 AND o.fk_gerencia  = gerencia AND o.enabled = 1
) WHERE m.fk_gerencia = gerencia;
			END IF;
			SET gerencia = gerencia + 1;
END WHILE;
END$$

DELIMITER ;

--
-- Actualización de la tabla seip_c_gerencia
--
UPDATE  `seip_c_gerencia` SET  `ref` =  '' WHERE  `seip_c_gerencia`.`id` =13;
