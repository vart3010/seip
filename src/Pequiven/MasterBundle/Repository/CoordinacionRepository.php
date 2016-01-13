<?php

namespace Pequiven\MasterBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

class CoordinacionRepository extends EntityRepository {

    public function getcoordinacionQueryBuilder() {
        $qb = $this->getQueryBuilder();
        $qb
                ->select('coord')
                ->andWhere('coord.enabled= :Enabled')
                ->setParameter('Enabled', 1);
        return $qb;
    }

    public function getcoordinacion() {
        $qb = $this->getcoordinacionQueryBuilder();
        return $qb->getQuery()->getResult();
    }

    function getAlias() {
        return 'coord';
    }

}
