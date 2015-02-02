ALTER TABLE ArrangementProgram ADD isAvailableInResult TINYINT(1) NOT NULL;
UPDATE ArrangementProgram SET isAvailableInResult=1 WHERE 1;