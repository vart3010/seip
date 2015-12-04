<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Centro
 *
 */
class ListRepository extends EntityRepository {

    function getGeneralVote() {

        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'SELECT 
    Estado,
    Municipio,
    Parroquia,
    IdCentro,
    Codigo,
    Centro,
    SUM(VotoSI) AS Si,
    SUM(VotoNO) AS No
FROM
    General_Votes
WHERE
    estado = "EDO. CARABOBO"
        AND parroquia = "PQ. RAFAEL URDANETA"
GROUP BY centro
ORDER BY Codigo';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

}
