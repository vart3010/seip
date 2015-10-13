<?php

namespace Pequiven\SIGBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de sistema de gestión (pequiven.repository.sig_management_system)
 *
 */
class ManagementSystemRepository extends SeipEntityRepository
{   
    /**
     * Retorna solo los sistemas de la calidad activos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function getManagementSystemsActives() {
        
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->select('ms')
                ->andWhere('ms.enabled = 1')
                ->andWhere('ms.deletedAt IS NULL')                
            ;

        return $queryBuilder;
    }

	/**
     * Crea un paginador para los sistemas de la calidad para la matriz
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorManagementSystems(array $criteria = null, array $orderBy = null) {
        
        $criteria['for_view_management'] = true;
        $orderBy['ms.id'] = 'ASC';

        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        
        //Visualización Sistemas de la Calidad
        if(($forviewmanagement = $criteria->remove('for_view_management')) != null){
            
            $queryBuilder
                ->andWhere('ms.enabled = 1')
                ->andWhere('ms.deletedAt IS NULL')                
            ;
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
        
    }

    protected function getAlias() {
        return 'ms';
    }
}
