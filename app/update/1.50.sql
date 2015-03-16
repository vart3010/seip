-- Agregando tipo de detalle del indicator
ALTER TABLE seip_indicator ADD typeDetailValue INT NOT NULL;
ALTER TABLE seip_indicator_audit ADD typeDetailValue INT DEFAULT NULL;