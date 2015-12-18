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

    public function getDailyRequirements($fecha) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT     "' . $fecha . '" AS Fecha,    cent.descriptionEstado AS Estado,    cent.descriptionMunicipio AS Municipio,
    cent.descriptionParroquia AS Parroquia,    cent.eje AS Eje,    cent.codigoCentro AS Codigo,    cent.description AS Centro,
    cent.direccion AS Direccion,    UPPER(obs.observations) AS Observaciones,
    CASE
        WHEN obs.categoria = 1 THEN "Propaganda"                  WHEN obs.categoria = 2 THEN "Transporte"
        WHEN obs.categoria = 3 THEN "Hidratación"                  WHEN obs.categoria IN (4 , 12, 13) THEN "Logística"
        WHEN obs.categoria = 5 THEN "Asistencia"                  WHEN obs.categoria = 6 THEN "Telefonía"
        WHEN obs.categoria = 7 THEN "Otros"                       WHEN obs.categoria = 8 THEN "Serv. de Luz"
        WHEN obs.categoria = 9 THEN "Serv. de Agua"               WHEN obs.categoria = 10 THEN "Serv. de Aseo"
        WHEN obs.categoria = 11 THEN "Material de Oficina"        WHEN obs.categoria = 14 THEN "CNE"
        WHEN obs.categoria = 15 THEN "Comida"                     WHEN obs.categoria = 16 THEN "Ayuda Social"
        WHEN obs.categoria = 17 THEN "Infraestructura"            WHEN obs.categoria = 18 THEN "Serv. Médicos"
        ELSE "Sin Categoria"    END AS Categoria,
    CASE
        WHEN obs.status = 1 THEN "Abierto"            WHEN obs.status = 2 THEN "Pendiente"
        WHEN obs.status = 3 THEN "Seguimiento"        WHEN obs.status = 4 THEN "Cerrado"
        WHEN obs.status = 5 THEN "Rechazado"          ELSE "Sin Status"
    END AS Status
FROM
    sip_centro_observations AS obs
        INNER JOIN    sip_centro AS cent ON (obs.codigocentro = cent.codigoCentro)
        INNER JOIN    sip_parroquia AS parroq ON (cent.codigoParroquia = parroq.id)
        INNER JOIN    sip_municipio AS municip ON (cent.codigoMunicipio = municip.id)
        INNER JOIN    sip_estado AS estado ON (cent.codigoEstado = estado.id)
WHERE
    obs.deletedAt IS NULL        AND DATE_FORMAT(obs.fecha, \'%d/%m/%Y\') = "' . $fecha . '"
ORDER BY fecha';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getEarringsRequirements() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT 
    DATE_FORMAT(obs.fecha, \'%d/%m/%Y\') AS Fecha,    cent.descriptionEstado AS Estado,
    cent.descriptionMunicipio AS Municipio,    cent.descriptionParroquia AS Parroquia,    cent.eje AS Eje,
    cent.codigoCentro AS Codigo,    cent.description AS Centro,    cent.direccion AS Direccion,
    UPPER(obs.observations) AS Observaciones,
    CASE
        WHEN obs.categoria = 1 THEN "Propaganda"            WHEN obs.categoria = 2 THEN "Transporte"
        WHEN obs.categoria = 3 THEN "Hidratación"           WHEN obs.categoria IN (4 , 12, 13) THEN "Logística"
        WHEN obs.categoria = 5 THEN "Asistencia"            WHEN obs.categoria = 6 THEN "Telefonía"
        WHEN obs.categoria = 7 THEN "Otros"                 WHEN obs.categoria = 8 THEN "Serv. de Luz"
        WHEN obs.categoria = 9 THEN "Serv. de Agua"         WHEN obs.categoria = 10 THEN "Serv. de Aseo"
        WHEN obs.categoria = 11 THEN "Material de Oficina"  WHEN obs.categoria = 14 THEN "CNE"
        WHEN obs.categoria = 15 THEN "Comida"               WHEN obs.categoria = 16 THEN "Ayuda Social"
        WHEN obs.categoria = 17 THEN "Infraestructura"      WHEN obs.categoria = 18 THEN "Serv. Médicos"
        ELSE "Sin Categoria"    END AS Categoria,
    CASE
        WHEN obs.status = 1 THEN "Abierto"        WHEN obs.status = 2 THEN "Pendiente"
        WHEN obs.status = 3 THEN "Seguimiento"    WHEN obs.status = 4 THEN "Cerrado"
        WHEN obs.status = 5 THEN "Rechazado"      ELSE "Sin Status"
    END AS Status
FROM
    sip_centro_observations AS obs
        INNER JOIN    sip_centro AS cent ON (obs.codigocentro = cent.codigoCentro)
        INNER JOIN    sip_parroquia AS parroq ON (cent.codigoParroquia = parroq.id)
        INNER JOIN    sip_municipio AS municip ON (cent.codigoMunicipio = municip.id)
        INNER JOIN    sip_estado AS estado ON (cent.codigoEstado = estado.id)
WHERE
    obs.deletedAt IS NULL        AND obs.status IN (1 , 2)
ORDER BY fecha';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getInventory() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT 
    DATE_FORMAT(inv.fecha, \'%d/%m/%Y\') AS Fecha,    cent.descriptionEstado AS Estado,
    cent.descriptionMunicipio AS Municipio,    cent.descriptionParroquia AS Parroquia,    cent.eje AS Eje,
    cent.codigoCentro AS Codigo,    cent.description AS Centro,    cent.direccion AS Direccion,
    inv.cantidad AS Cant,    mat.material AS Material,    UPPER(inv.observations) AS Observaciones
FROM
    sip_centro_inventory AS inv
        INNER JOIN    sip_centro AS cent ON (inv.codigocentro = cent.codigoCentro)
        INNER JOIN    sip_centro_material AS mat ON (inv.material_id = mat.id)
WHERE    inv.deletedAt IS NULL
ORDER BY fecha';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOnePerTen() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = '  
    SELECT 
    user.identification AS CedulaOne,
    CASE
        WHEN user.lastname IS NULL THEN user.firstname
        ELSE CONCAT(user.firstname, " ", user.lastname)
    END AS NombreOne,
    user.cellphone AS TelefonoOne,    ten.cedula AS Cedula,    ten.Nombre AS Nombre,    ten.Telefono,
    ten.nombreEstado AS Estado,    ten.nombreMunicipio AS Municipio,    ten.nombreParroquia AS Parroquia,
    ten.nombreCentro AS Centro
FROM
    sip_onePerTenMembers AS ten
        INNER JOIN    sip_onePerTen AS ones ON (ones.id = ten.one_id)
        INNER JOIN    seip_user AS user ON (ones.user_id = user.id)
WHERE    ten.deletedAt IS NULL';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    function getSegVoto($localidad, $gprimera, $gsegunda, $tipo, $c5, $voto) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT Tipo,  ComplejoCET,    cet_codigo,    GerenciaFirst,    GerenciaSecond,    EsCoord,    Coordinador,
            TelefCoord, Estado, Municipio, Parroquia, Codigo,	 Cedula, Nombre, Telefono, 	CASE WHEN ((Voto=0)OR(Voto IS NULL)) THEN "No" ELSE "Si" END as Voto,
            RespUnoxDiez
            FROM    General_VotesbyGerencia
            WHERE ';


        if (($tipo != "General")) {
            $sql2 = ' Tipo="' . $tipo . '" ';
        } else {
            $sql2 = ' Tipo IS NOT NULL ';
        }

        if ($localidad != "") {
            $sql3 = ' AND complejo_id="' . $localidad . '" ';
        } else {
            $sql3 = '';
        }

//        if ($gprimera != "") {
//            $sql4 = ' AND gerencia_id="' . $gprimera . '" ';
//        } else {
//            $sql4 = '';
//        }

        if ($gsegunda != "") {
            $sql5 = ' AND gerenciaSecond_id="' . $gsegunda . '" ';
        } else {
            $sql5 = '';
        }

        if ($voto == 1) {
            $sql6 = ' AND Voto="1" ';
        } else {
            $sql6 = ' AND (Voto=0 or Voto is null) ';
        }


        if ($c5 == 1) {
            $sql7 = ' AND Estado="EDO. CARABOBO" AND Parroquia IN ("PQ. SANTA ROSA","PQ. MIGUEL PEÑA", '
                    . '"PQ. RAFAEL URDANETA","PQ. U INDEPENDENCIA", "PQ. U TOCUYITO", "PQ. NEGRO PRIMERO") ';
        } else {
            $sql7 = ' ';
        }


        $sql = $sql1 . $sql2 . $sql3 . $sql5 . $sql6 . $sql7;

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    protected function getAlias() {
        return "Rep";
    }

}
