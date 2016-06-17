<?php

namespace Pequiven\MasterBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

class CoordinacionRepository extends EntityRepository {

    public function getcoordinacionQueryBuilder($gerencia) {
        
        $qb = $this->getQueryBuilder();
        $qb
                ->select('coord')                
                ->innerJoin('coord.gerenciasecond', 'gerenciasecond')
                ->innerJoin('gerenciasecond.gerencia', 'gerencia')                
                ->andWhere('coord.enabled= :Enabled')
                ->andWhere('gerencia.id= :gerencia')
                ->setParameter('Enabled', 1)
                ->setParameter('gerencia', $gerencia);
        return $qb;
    }

    public function getcoordinacion($gerencia) {
        $qb = $this->getcoordinacionQueryBuilder($gerencia);
        return $qb->getQuery()->getResult();
    }

    function getAlias() {
        return 'coord';
    }

}
