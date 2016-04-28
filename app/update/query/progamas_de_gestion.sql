-- Buscar id de metas de un programa de gestion para agrgar personas.
SELECT ap.ref,g.id,g.name FROM `ArrangementProgram` ap INNER JOIN Timeline t ON t.id = ap.timeline_id INNER JOIN Goal g ON g.timeline_id = t.id WHERE ap.id = 2186;
-- Buscar el resultado de los programas de gestion
SELECT DISTINCT(ap.id),ap.ref,ap.progressToDate 
FROM `ArrangementProgram` ap 
INNER JOIN Timeline tl ON ap.timeline_id = tl.id 
INNER JOIN Goal g ON g.timeline_id = tl.id 
LEFT JOIN seip_objetiv
WHERE g.advance > 100 ORDER BY ap.progressToDate DESC;