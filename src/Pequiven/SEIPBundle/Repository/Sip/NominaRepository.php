<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of NominaRepository
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class NominaRepository extends EntityRepository {

    protected function getAlias() {
        return "n";
    }

}
