<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Reportes SIP
 *
 * @author Gilbert C.
 */
class reportSIPRepository extends EntityRepository {

    public function getAsist($fecha) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '
select "' . $fecha . '" as Fecha, centro.descriptionEstado as Estado, centro.descriptionMunicipio as Municipio, 
centro.descriptionParroquia as Parroquia, centro.eje as Eje,
centro.codigocentro as Codigo, centro.description as Centro,
cutl.cedula as Cedula, 

case when ((cutl.nombre is null)or(cutl.cedula=0)) then 
"SIN CUTL ASIGNADO" else cutl.nombre end as Nombre, cutl.telefonoSeip as Telefono,

(SELECT CASE 
when SUM(asist.assists)>=1 then "Presente"
else "Ausente" end from sip_centro_assists as asist where 
(asist.codigoCentro=centro.codigoCentro and asist.cedula=cutl.Cedula
and asist.deletedAt is null and date_format(asist.fecha,\'%d/%m/%Y\')="' . $fecha . '")) as Asistencia, 

(SELECT GROUP_CONCAT(asist.observations) from sip_centro_assists as asist where 
(asist.codigoCentro=centro.codigoCentro and asist.cedula=cutl.Cedula
and asist.deletedAt is null and date_format(asist.fecha,\'%d/%m/%Y\')="' . $fecha . '")
and asist.observations is not null) as Observaciones,

(SELECT CASE 
when SUM(estatus.status)>=1 then "Activo"
else "Inactivo" end from sip_centro_status as estatus where 
(estatus.codigoCentro=centro.codigoCentro
and estatus.deletedAt is null and date_format(estatus.fecha,\'%d/%m/%Y\')="' . $fecha . '")) as StatusAct,

(SELECT GROUP_CONCAT(estatus.observations) from sip_centro_status as estatus where 
(estatus.codigoCentro=centro.codigoCentro
and estatus.deletedAt is null and date_format(estatus.fecha,\'%d/%m/%Y\')="' . $fecha . '")
and estatus.observations is not null) as ObservacionesStatus

from sip_centro as centro
left outer join sip_cutl as cutl on (cutl.codigoCentro=centro.codigoCentro)
where (centro.codigoEstado=7 and centro.circuito=5
 and centro.codigocentro not in (select `Código Centro` from data.BaseMisiones))
order by centro,Fecha';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    protected function getAlias() {
        return "Rep";
    }

}
