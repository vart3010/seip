<?php

namespace Pequiven\SEIPBundle\Repository\Delivery;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de report template despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class ReportTemplateDeliveryRepository extends SeipEntityRepository {

    function createPaginatorReportTemplateDelivery(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    /**
     * Retorna las plantillas a las cuales el usuario tiene acceso
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByUser(array $criteria = null, array $orderBy = null) {

        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();
        if (!$this->getSecurityContext()->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_DELIVERY_TEMPLATES_ALL'))) {
            $queryBuilder
                    ->innerJoin("rtd.users", 'rt_u')
                    ->andWhere("rt_u.id = :user")
                    ->setParameter("user", $user)
            ;
        }
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);


        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (($ref = $criteria->remove("rtd.ref"))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("rtd.ref", "'%" . $ref . "%'"));
        }
        if (($name = $criteria->remove("rtd.name"))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("rtd.name", "'%" . $name . "%'"));
        }
        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');

        parent::applyCriteria($queryBuilder, $criteria->toArray());

        if ($applyPeriodCriteria) {
            $this->applyPeriodCriteria($queryBuilder);
        }
    }

    protected function getAlias() {
        return "rtd";
    }

}
