BEGIN;

INSERT INTO `seip_cei_region` (`id`, `name`, `enabled`, `created_at`, `updated_at`, `deletedAt`) VALUES
(1, 'Centro', 1, '2015-05-06 17:46:22', '2015-05-06 17:46:22', NULL),
(2, 'Occidente', 1, '2015-05-06 17:47:31', '2015-05-06 17:47:31', NULL),
(3, 'Oriente', 1, '2015-05-06 17:47:39', '2015-05-06 17:47:39', NULL),
(4, 'Sede principal', 1, '2015-05-06 17:47:48', '2015-05-06 17:47:48', NULL);

ALTER TABLE `seip_cei_region` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

INSERT INTO `seip_cei_unit_measure` (`id`, `name`, `unit`, `enabled`, `created_at`, `updated_at`, `deletedAt`) VALUES
(1, 'Tonelada', 'TM', 1, '2015-05-07 08:28:06', '2015-05-07 08:28:06', NULL);

ALTER TABLE `seip_cei_unit_measure` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

COMMIT;