<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Centro
 *
 */
class ListRepository extends EntityRepository {

    function getGeneralVote($estado, $municipio, $parroquia, $tipo, $codigoCentro) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT     Estado,    Municipio,    Parroquia,    IdCentro,    Codigo,    Centro,
            SUM(VotoSI) AS Si,    SUM(VotoNO) AS No
            FROM    General_Votes
            WHERE ';


        if (($tipo != "General")and ( $tipo != "Circuito 5")) {
            $sql2 = 'Estado = "' . $estado . '"
            AND MUNICIPIO = "' . $municipio . '"
            AND Parroquia = "' . $parroquia . '" ';
            $sql3 = ' AND Tipo="' . $tipo . '" ';
        } else {
            if ($tipo == "Circuito 5") {
                $sql2 = 'Estado="EDO. CARABOBO" AND Parroquia IN ("PQ. SANTA ROSA","PQ. MIGUEL PEÑA", '
                        . '"PQ. RAFAEL URDANETA","PQ. U INDEPENDENCIA", "PQ. U TOCUYITO", "PQ. NEGRO PRIMERO")';
                $sql3 = '';
            } else {
                $sql2 = 'Estado = "' . $estado . '"
            AND MUNICIPIO = "' . $municipio . '"
            AND Parroquia = "' . $parroquia . '" ';
                $sql3 = ' ';
            }
        }

        if ((isset($codigoCentro)) and ( $codigoCentro != "Todos")) {
            $sql4 = ' AND Codigo="' . $codigoCentro . '" ';
        } else {
            $sql4 = '';
        }

        $sql3 = ' GROUP BY centro ORDER BY Codigo';

        $sql = $sql1 . $sql2 . $sql3 . $sql4;

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    function getCodes($estado, $municipio, $parroquia) {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT DISTINCT
    codigoEstado,    descriptionEstado,    
    codigoMunicipio,    descriptionMunicipio,    
    codigoParroquia,    descriptionParroquia
        FROM    sip_centro
            WHERE
            codigoEstado = "' . $estado . '"
            AND codigoMunicipio = "' . $municipio . '"
            AND codigoParroquia = "' . $parroquia . '" ';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

}
