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

        $sql = 'SELECT * FROM sip_centro';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $pagerfanta = new \Tecnocreaciones\Bundle\ResourceBundle\Model\Paginator\Paginator(new \Pagerfanta\Adapter\ArrayAdapter($result));
        $pagerfanta->setContainer($this->container);
        return $pagerfanta;

    }

}
