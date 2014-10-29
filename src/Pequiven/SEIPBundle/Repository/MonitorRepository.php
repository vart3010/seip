<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
/**
 * Description of MonitorRepository
 *
 * @author matias
 */
class MonitorRepository extends EntityRepository {
    
    /**
     * Crea un paginador para los objetivos tácticos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorTypeGroup(array $criteria = null, array $orderBy = null) {
        
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
//        $queryBuilder = $this->createQueryBuilder('o');
//        $queryBuilder->innerJoin('o.gerencia', 'g');
        $queryBuilder->select('o.typeGroup');
        $queryBuilder->addSelect('SUM(o.objTacticOriginal) AS PlanObjTactic');
        $queryBuilder->addSelect('SUM(o.objTacticOriginalReal) AS RealObjTactic');
        $queryBuilder->groupBy('o.typeGroup');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getScalarPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los objetivos tácticos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorTactic(array $criteria = null, array $orderBy = null) {
        
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->innerJoin('o.gerencia', 'g');

        //Filtro Objetivo Táctico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }
        
        $queryBuilder->orderBy('g.description');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
//        echo $queryBuilder->getQuery()->getSQL();
        //echo count($queryBuilder->getQuery()->getResult());
//        die();
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Función que retorna el total de Objetivos Tácticos por grupos de Gerencia de 1ra Línea
     * @return type
     */
    public function getTotalObjetivesTacticByGerenciaGroup($options = array()){
        $queryBuilder = $this->getCollectionQueryBuilder();
        
        if(!isset($options['typeGroup'])){
            $queryBuilder->select('gg.description AS Descripcion,gg.groupName AS Grupo');
            $queryBuilder->addSelect('SUM(o.objTacticOriginal) AS PlanObjTactic');
            $queryBuilder->addSelect('SUM(o.objTacticOriginalReal) AS RealObjTactic');
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->groupBy('o.typeGroup');
        } else{
            $queryBuilder->select('o.objTacticOriginal AS PlanObjTactic,o.objTacticOriginalReal AS RealObjTactic,g.description AS Gerencia,g.ref AS Ref,gg.groupName AS Grupo');
            $queryBuilder->andWhere("gg.groupName = '" . $options['typeGroup'] . "'");
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->innerJoin('o.gerencia', 'g');
        }
        
        $q = $queryBuilder->getQuery();

        return $q->getResult();
    }
    
    /**
     * Función que retorna el total de Objetivos Operativos por grupos de Gerencia de 1ra Línea
     * @return type
     */
    public function getTotalObjetivesOperativeByGerenciaGroup($options = array()){
        $queryBuilder = $this->getCollectionQueryBuilder();
        
        if(!isset($options['typeGroup'])){
            $queryBuilder->select('gg.description AS Descripcion,gg.groupName AS Grupo');
            $queryBuilder->addSelect('SUM(o.objOperativeOriginal) AS PlanObjOperative');
            $queryBuilder->addSelect('SUM(o.objOperativeOriginalReal) AS RealObjOperative');
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->groupBy('o.typeGroup');
        } else{
            $queryBuilder->select('o.objOperativeOriginal AS PlanObjOperative,o.objOperativeOriginalReal AS RealObjOperative,g.description AS Gerencia,g.ref AS Ref,gg.groupName AS Grupo');
            $queryBuilder->andWhere("gg.groupName = '" . $options['typeGroup'] . "'");
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->innerJoin('o.gerencia', 'g');
        }
        
        $q = $queryBuilder->getQuery();

        return $q->getResult();
    }
    
    /**
     * Función que retorna el total de Indicadores Tácticos por grupos de Gerencia de 1ra Línea
     * @return type
     */
    public function getTotalIndicatorTacticByGerenciaGroup($options = array()){
        $queryBuilder = $this->getCollectionQueryBuilder();
        
        if(!isset($options['typeGroup'])){
            $queryBuilder->select('gg.description AS Descripcion,gg.groupName AS Grupo');
            $queryBuilder->addSelect('SUM(o.indTacticOriginal) AS PlanIndTactic');
            $queryBuilder->addSelect('SUM(o.indTacticOriginalReal) AS RealIndTactic');
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->groupBy('o.typeGroup');
        } else{
            $queryBuilder->select('o.indTacticOriginal AS PlanIndTactic,o.indTacticOriginalReal AS RealIndTactic,g.description AS Gerencia,g.ref AS Ref,gg.groupName AS Grupo');
            $queryBuilder->andWhere("gg.groupName = '" . $options['typeGroup'] . "'");
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->innerJoin('o.gerencia', 'g');
        }
        
        $q = $queryBuilder->getQuery();
        
        return $q->getResult();
    }
    
    /**
     * Función que retorna el total de Indicadores Operativos por grupos de Gerencia de 1ra Línea
     * @return type
     */
    public function getTotalIndicatorOperativeByGerenciaGroup($options = array()){
        $queryBuilder = $this->getCollectionQueryBuilder();
        
        if(!isset($options['typeGroup'])){
            $queryBuilder->select('gg.description AS Descripcion,gg.groupName AS Grupo');
            $queryBuilder->addSelect('SUM(o.indOperativeOriginal) AS PlanIndOperative');
            $queryBuilder->addSelect('SUM(o.indOperativeOriginalReal) AS RealIndOperative');
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->groupBy('o.typeGroup');
        } else{
            $queryBuilder->select('o.indOperativeOriginal AS PlanIndOperative,o.indOperativeOriginalReal AS RealIndOperative,g.description AS Gerencia,g.ref AS Ref,gg.groupName AS Grupo');
            $queryBuilder->andWhere("gg.groupName = '" . $options['typeGroup'] . "'");
            $queryBuilder->innerJoin('o.typeGroup', 'gg');
            $queryBuilder->innerJoin('o.gerencia', 'g');
        }
        
        $q = $queryBuilder->getQuery();

        return $q->getResult();
    }
}
