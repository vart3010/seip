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
            WHERE
            Estado = "' . $estado . '"
            AND MUNICIPIO = "' . $municipio . '"
            AND Parroquia = "' . $parroquia . '" ';

        if ($tipo != "General") {
            $sql2 = ' AND Tipo="' . $tipo . '" ';
        } else {
            $sql2 = ' ';
        }

        if (isset($codigoCentro)) {
            $sql2 = ' AND CodigoCentro="' . $codigoCentro . '" ';
        } else {
            $sql2 = ' ';
        }

        $sql3 = ' GROUP BY centro ORDER BY Codigo';

        $sql = $sql1 . $sql2 . $sql3;

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
            Estado = "' . $estado . '"
            AND MUNICIPIO = "' . $municipio . '"
            AND Parroquia = "' . $parroquia . '" ';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

}
