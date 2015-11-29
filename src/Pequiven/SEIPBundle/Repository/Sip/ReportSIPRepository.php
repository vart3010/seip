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

    public function getAsistHistory() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT Estado,    Municipio,    Parroquia,    eje,    Codigo,    Centro,    Cedula,    Nombre,    Telefono,
    Asist08112015,    Asist09112015,    Asist10112015,    Asist11112015,    Asist12112015,    Asist13112015,    Asist14112015,
    Asist15112015,    Asist16112015,    Asist17112015,    Asist18112015,    Asist19112015,    Asist20112015,    Asist21112015,    
    Asist22112015,    Asist23112015,    Asist24112015,    Asist25112015,    Asist26112015,    Asist27112015,    Asist28112015,
    Asist29112015,    Asist30112015,    Asist01122015,    Asist02122015,    Asist03122015,    Asist04122015,    Asist05122015,
    Asist06122015   FROM    Sip_Historico_Asist';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }
    
     public function getActiveHistory() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT     Estado,    Municipio,    Parroquia,    eje,    Codigo,    Centro,
    Status08112015,    Status09112015,    Status10112015,    Status11112015,    Status12112015,    Status13112015,
    Status14112015,    Status15112015,    Status16112015,    Status17112015,    Status18112015,    Status19112015,
    Status20112015,    Status21112015,    Status22112015,    Status23112015,    Status24112015,    Status25112015,
    Status26112015,    Status27112015,    Status28112015,    Status29112015,    Status30112015,    Status01122015,
    Status02122015,    Status03122015,    Status04122015,    Status05122015,    Status06122015
    FROM Sip_Historico_Asist GROUP BY Estado , Municipio , Parroquia , eje , Codigo , Centro';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    protected function getAlias() {
        return "Rep";
    }

}
