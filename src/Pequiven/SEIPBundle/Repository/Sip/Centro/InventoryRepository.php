<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Center\Inventory;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio asistencia
 *
 */
class InventoryRepository extends EntityRepository {    
   
    protected function getAlias() {
        return "inv";
    }  
}