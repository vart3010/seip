CREATE TABLE user_supervised (user_id INT NOT NULL, supervised_user_id INT NOT NULL, INDEX IDX_E4CD09CFA76ED395 (user_id), INDEX IDX_E4CD09CF395EA82E (supervised_user_id), PRIMARY KEY(user_id, supervised_user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE user_supervised ADD CONSTRAINT FK_E4CD09CFA76ED395 FOREIGN KEY (user_id) REFERENCES seip_user (id);
ALTER TABLE user_supervised ADD CONSTRAINT FK_E4CD09CF395EA82E FOREIGN KEY (supervised_user_id) REFERENCES seip_user (id);

ALTER TABLE seip_indicator ADD parent_id INT DEFAULT NULL;
ALTER TABLE seip_indicator ADD CONSTRAINT FK_6092D6A6727ACA70 FOREIGN KEY (parent_id) REFERENCES seip_indicator (id);
CREATE INDEX IDX_6092D6A6727ACA70 ON seip_indicator (parent_id);