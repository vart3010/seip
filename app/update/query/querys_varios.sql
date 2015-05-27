-- Indicadores 2014 con padres 2015
SELECT i.id,i.ref,i.period_id,ip.id,ip.ref,ip.period_id
FROM seip_indicator AS i
INNER JOIN seip_indicator AS ip ON (ip.id = i.parent_id)
WHERE ip.period_id = 2 AND i.period_id = 1 AND i.deletedAt IS NULL 
LIMIT 300