<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Center\StatusCentro;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio Status de Centro
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class StatusCentroRepository extends EntityRepository {  

	protected function getAlias() {
        return "stc";
    }  
}