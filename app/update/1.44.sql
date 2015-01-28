CREATE TABLE AccessToken (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B39617F55F37A13B (token), INDEX IDX_B39617F519EB6921 (client_id), INDEX IDX_B39617F5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE AuthCode (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F1D7D1775F37A13B (token), INDEX IDX_F1D7D17719EB6921 (client_id), INDEX IDX_F1D7D177A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE Client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT '(DC2Type:array)', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT '(DC2Type:array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE RefreshToken (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7142379E5F37A13B (token), INDEX IDX_7142379E19EB6921 (client_id), INDEX IDX_7142379EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE AccessToken ADD CONSTRAINT FK_B39617F519EB6921 FOREIGN KEY (client_id) REFERENCES Client (id);
ALTER TABLE AccessToken ADD CONSTRAINT FK_B39617F5A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE AuthCode ADD CONSTRAINT FK_F1D7D17719EB6921 FOREIGN KEY (client_id) REFERENCES Client (id);
ALTER TABLE AuthCode ADD CONSTRAINT FK_F1D7D177A76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE RefreshToken ADD CONSTRAINT FK_7142379E19EB6921 FOREIGN KEY (client_id) REFERENCES Client (id);
ALTER TABLE RefreshToken ADD CONSTRAINT FK_7142379EA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);


-- app/console fos:oauth-server:client:create --grant-type="password"

-- Agregar fuente de equacion real y plan
ALTER TABLE seip_c_formula ADD sourceEquationReal LONGTEXT DEFAULT NULL, ADD sourceEquationPlan LONGTEXT DEFAULT NULL;
-- Agregar campo descripcion a el periodo
ALTER TABLE Period ADD description VARCHAR(255) NOT NULL;
UPDATE `Period` SET `description`=`name` WHERE `id`=1;
UPDATE `Period` SET `name`=2014 WHERE `id`=1;
CREATE UNIQUE INDEX name_idx ON Period (name);

-- Agregar campos de fechas para inicio y fin de carga y notificacion de programas de gestion.
ALTER TABLE Period ADD dateStartNotificationArrangementProgram DATE DEFAULT NULL, ADD dateEndNotificationArrangementProgram DATE DEFAULT NULL, ADD dateStartLoadArrangementProgram DATE DEFAULT NULL, ADD dateEndLoadArrangementProgram DATE DEFAULT NULL;
UPDATE `Period` SET `dateStartNotificationArrangementProgram` = '2014-01-01' WHERE `Period`.`id` = 1;
UPDATE `Period` SET `dateStartLoadArrangementProgram` = '2014-01-01' WHERE `Period`.`id` = 1;
UPDATE `Period` SET `dateEndNotificationArrangementProgram` = '2014-01-30' WHERE `Period`.`id` = 1;
UPDATE `Period` SET `dateEndLoadArrangementProgram` = '2015-01-30' WHERE `Period`.`id` = 1;

UPDATE `seip_objetive` SET period_id=1 WHERE period_id is null;
ALTER TABLE seip_objetive CHANGE period_id period_id INT NOT NULL;