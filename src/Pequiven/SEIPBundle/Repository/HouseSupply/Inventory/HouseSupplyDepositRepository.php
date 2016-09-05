<?php

namespace Pequiven\SEIPBundle\Repository\HouseSupply\Inventory;

use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de MOVIMIENTO DE EMPLEADOS
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HouseSupplyDepositRepository extends EntityRepository {

    function getAlias() {
        return 'dep';
    }

}