<?php

namespace Pequiven\SEIPBundle\Repository\Politic;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de FILES DE WORKSTUDYCIRCLE
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class WorkStudyCircleFileRepository extends SeipEntityRepository {

    function createPaginatorWorkStudyCircleFile(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    protected function getAlias() {
        return 'wscf';
    }

}
