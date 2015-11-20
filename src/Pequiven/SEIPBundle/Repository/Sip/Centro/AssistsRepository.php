<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Centro\Assists;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio asistencia
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class AssistsRepository extends EntityRepository {    
   
    protected function getAlias() {
        return "ast";
    }  
}
