<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de 1x10
 * @author Victor Tortolero vart10.30@gmail.com
 */
class OnePerTenRepository extends EntityRepository {

    public function createPaginatorByOnePerTen(array $criteria = null, array $orderBy = null) {


        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        $queryBuilder
                ->innerJoin('opt.user', 'u')
                ->innerJoin('opt.ten', 't')
        ;


        if (($description = $criteria->remove('userName')) != null) {
            if (isset($criteria['userName'])) {
                $description = $criteria['userName'];
                $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('u.firstname', "'%" . $description . "%'"), $queryBuilder->expr()->like('u.lastname', "'%" . $description . "%'")));
            }
        }

        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

//    public function getValidUsers() {
//
//        $query = $this->getQueryBuilder();
//
//        $query->select("u.cedula")
//                ->from("seip_user", "u")
//                ->innerJoin('i.indicatorLevel', 'o_il')
//                ->andWhere('i.enabled = 1');
//
//        $q = $query->getQuery();
//
//        return $q->getResult();
//    }

    protected function getAlias() {
        return 'opt';
    }

}
