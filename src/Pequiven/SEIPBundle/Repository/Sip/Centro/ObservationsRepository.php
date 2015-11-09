<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro\Observations;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio observaciones
 */
class ObservationsRepository extends EntityRepository {    
   
    protected function getAlias() {
        return "obs";
    }  
}