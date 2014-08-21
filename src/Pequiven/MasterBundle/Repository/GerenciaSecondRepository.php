<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository as baseEntityRepository;
/**
 * Description of GerenciaSecondRepository
 *
 * @author matias
 */
class GerenciaSecondRepository extends baseEntityRepository {
    //put your code here
    
     /**
     * Crea un paginador para las gerencias de 2da línea
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorGerenciaSecond(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();

        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->like('o.description', "'%".$description."%'"));
        }
//        if(isset($criteria['rif'])){
//            $rif = $criteria['rif'];
//            unset($criteria['rif']);
//            $queryBuilder->andWhere($queryBuilder->expr()->like('o.rif', "'%".$rif."%'"));
//        }

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
}
