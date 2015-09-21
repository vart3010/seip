<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of LineStrategicRepository (pequiven.repository.linestrategic)
 *
 * @author matias
 */
class LineStrategicRepository extends EntityRepository {
    
    /**
     * 
     * @return type
     */
    public function findIndicatorsByOrderToShow($idLineStrategic){
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('ls.indicators','i')
                ->andWhere("ls.id = :idLineStrategic")
                ->andWhere("i.deletedAt IS NULL")
                ->setParameter('idLineStrategic', $idLineStrategic)
                ->orderBy('i.orderShowFromParent','ASC')
        ;
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * 
     * @param array $criteria
     * @return type
     */
    function findLineStrategic(array $criteria = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        return $queryBuilder->getQuery()->getResult();
    }
    
//    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
//        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
//        
//        parent::applyCriteria($queryBuilder, $criteria->toArray());
//        
//        $this->applyPeriodCriteria($queryBuilder);
//    }
//    
//    protected function applySorting(\Doctrine\ORM\QueryBuilder $queryBuilder, array $sorting = null) {
//        
//        parent::applySorting($queryBuilder, $sorting);
//    }
    
    protected function getAlias() {
        return 'ls';
    }
}
