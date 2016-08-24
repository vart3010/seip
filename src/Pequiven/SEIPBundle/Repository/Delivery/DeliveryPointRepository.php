<?php

namespace Pequiven\SEIPBundle\Repository\Delivery;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repositorio de report template despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class DeliveryPointRepository extends SeipEntityRepository {

    function createPaginatorDeliveryPoint(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    public function createPaginatorByUser(array $criteria = null, array $orderBy = null) {

        $queryBuilder = $this->getCollectionQueryBuilder();


        $user = $this->getUser();

        if (!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_DELIVERY_TEMPLATES_ALL'))) {
            $queryBuilder
                    ->innerJoin("dp.users", 'dp_u')
                    ->andWhere("dp_u.id = :user")
                    ->setParameter("user", $user)
            ;
        }

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new ArrayCollection($criteria);
        #$queryBuilder->leftJoin("rt.plantReports","rt_pr");

        if (($ref = $criteria->remove("dp.ref"))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("dp.ref", "'%" . $ref . "%'"));
        }
        if (($descripcion = $criteria->remove("dp.descripcion"))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("dp.descripcion", "'%" . $descripcion . "%'"));
        }
        $warehouse = $criteria->remove("dp.warehouse");
        if ($warehouse != null) {
            $queryBuilder
                    ->innerJoin('dp.warehouse', 'dp_w')
                    ->andWhere($queryBuilder->expr()->like("dp_w.descripcion", $queryBuilder->expr()->literal("%" . $warehouse . "%")))
            ;
        }
        $period = $criteria->remove("dp.period");
        if ($period != null) {
            $queryBuilder
                    ->innerJoin('dp.period', 'dp_p')
                    ->andWhere($queryBuilder->expr()->like("dp_p.name", $queryBuilder->expr()->literal("%" . $period . "%")))
            ;
        }

        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');

        parent::applyCriteria($queryBuilder, $criteria->toArray());

        if ($applyPeriodCriteria) {
            $this->applyPeriodCriteria($queryBuilder);
        }
    }

    protected function getAlias() {
        return "dp";
    }

}
