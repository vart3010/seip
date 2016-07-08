<?php

namespace Pequiven\SIGBundle\Repository\Tracing;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * 
 *
 */
class StandardizationRepository extends SeipEntityRepository{

	/**
     * Crea un paginador para los sistemas de la calidad para la matriz
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorStandardization(array $criteria = null, array $orderBy = null) {        
        $criteria['for_view_standardization'] = true;
        $orderBy['ss.id'] = 'ASC';
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);                
        if(($forviewmanagement = $criteria->remove('for_view_standardization')) != null){            
            $queryBuilder                
                ->andWhere('ss.deletedAt IS NULL')                
                ->andWhere('ss.relationObject =:idManagementSystems')            
            	->setParameter('idManagementSystems', $criteria->remove('idManagemenSystems'))
            ;        	
        }
        
        if (isset($criteria['code'])) {
            $code = $criteria['code'];
            unset($criteria['code']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('ss.code', "'%" . $code . "%'")));
        } 
        parent::applyCriteria($queryBuilder, $criteria->toArray());        
    }

    protected function getAlias() {
        return 'ss';
    }    
}
