<?php

namespace Pequiven\SEIPBundle\Repository\Delivery;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

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

        $this->applyCriteria($queryBuilder, $criteria);
        $user = $this->getUser();

        if (!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_DELIVERY_TEMPLATES_ALL'))) {
            $queryBuilder
                    ->innerJoin("dp.users", 'dp_u')
                    ->andWhere("dp_u.id = :user")
                    ->setParameter("user", $user)
            ;
        }

        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (($description = $criteria->remove("dp.description"))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("dp.descripcion", "'%" . $description . "%'"));
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
