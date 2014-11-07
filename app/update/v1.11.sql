ALTER TABLE Timeline DROP FOREIGN KEY FK_BF88A430ED49F08;
DROP INDEX UNIQ_BF88A430ED49F08 ON Timeline;

CREATE TABLE ArrangementProgramTemplate (id INT AUTO_INCREMENT NOT NULL, timeline_id INT NOT NULL, description VARCHAR(200) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, type INT NOT NULL, createdBy_id INT NOT NULL, categoryArrangementProgram_id INT NOT NULL, INDEX IDX_82DE4A513174800F (createdBy_id), UNIQUE INDEX UNIQ_82DE4A51EDBEDD37 (timeline_id), INDEX IDX_82DE4A517B53EF07 (categoryArrangementProgram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE ArrangementProgramTemplate ADD CONSTRAINT FK_82DE4A513174800F FOREIGN KEY (createdBy_id) REFERENCES seip_user (id);
ALTER TABLE ArrangementProgramTemplate ADD CONSTRAINT FK_82DE4A51EDBEDD37 FOREIGN KEY (timeline_id) REFERENCES Timeline (id);
ALTER TABLE ArrangementProgramTemplate ADD CONSTRAINT FK_82DE4A517B53EF07 FOREIGN KEY (categoryArrangementProgram_id) REFERENCES seip_c_category_arrangement_program (id);
ALTER TABLE ArrangementProgram ADD timeline_id INT NOT NULL;

UPDATE ArrangementProgram ap ,Timeline t SET ap.timeline_id = t.id WHERE t.arrangementProgram_id = ap.id;

ALTER TABLE ArrangementProgram ADD CONSTRAINT FK_7571028FEDBEDD37 FOREIGN KEY (timeline_id) REFERENCES Timeline (id);
CREATE UNIQUE INDEX UNIQ_7571028FEDBEDD37 ON ArrangementProgram (timeline_id);

ALTER TABLE Timeline DROP arrangementProgram_id;
