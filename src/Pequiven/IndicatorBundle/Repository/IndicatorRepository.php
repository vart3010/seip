<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository;

use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository as baseEntityRepository;

/**
 * Description of IndicatorRepository
 *
 * @author matias
 */
class IndicatorRepository extends baseEntityRepository {
    
    public function getByOptionRef($options = array()){
    
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('i')
                    ->from('\Pequiven\IndicatorBundle\Entity\Indicator', 'i')
            ;
        
        if(isset($options['lineStrategicId'])){
            $query->andWhere('i.lineStrategic = ' . $options['lineStrategicId']);
        }
        
        if($options['type'] === 'STRATEGIC'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_ESTRATEGICO);
        } elseif($options['type'] === 'TACTIC'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_TACTICO);
        } elseif($options['type'] === 'OPERATIVE'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_OPERATIVO);
        }
        
        $q = $query->getQuery();
        //var_dump($q->getSQL());
        //die();
        return $q->getResult();
    }
    
    /**
     * Función que devuelve la cantidad de indicadores que tiene un objetivo
     * @param type $options
     * @return type
     */
    public function getByOptionRefParent($options = array()){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('i')
                    ->from('\Pequiven\IndicatorBundle\Entity\Indicator', 'i')
                    ->andWhere('i.refParent = :refParentId')
                    ->setParameter('refParentId', $options['refParent'])
                ;
        
        if($options['type'] === 'STRATEGIC'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_ESTRATEGICO);
        } elseif($options['type'] === 'TACTIC'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_TACTICO);
        } elseif($options['type'] === 'OPERATIVE'){
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_OPERATIVO);
        }
        
        $q = $query->getQuery();

        return $q->getResult();
    }
    
    function getQueryChildrenLevel($level) {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->innerJoin('i.objetives', 'o_o')
                ->innerJoin('i.indicatorLevel', 'o_il')
                ->andWhere('i.enabled = 1')
                ->andWhere('o_o.enabled = 1')
                ->andWhere('i.tmp = 0')
                ->andWhere("o_il.level > :level")
                ->setParameter('level', $level)
                ;
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');
        
        return $queryBuilder;
    }
    
    /**
     * Crea un paginador para los indicadores de acuerdo al nivel del mismo
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevel(array $criteria = null, array $orderBy = null) {
//        $queryBuilder = $this->getQueryBuilder();
//        $queryBuilder
//                ->innerJoin('i.objetives', 'o_o')
//                ->andWhere('i.enabled = 1')
//                ->andWhere('o_o.enabled = 1')
//                ;
//        $queryBuilder->andWhere('i.tmp = 0');
//        
//        //Filtro por referencia o descripción
//        if(isset($criteria['description'])){
//            $description = $criteria['description'];
//            unset($criteria['description']);
//            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%".$description."%'"),$queryBuilder->expr()->like('i.ref', "'%".$description."%'")));
//        }
//        
//        //Filtro nivel del Indicador
//        if(isset($criteria['indicatorLevel'])){
//            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
//        }
//        
//        //Filtro Gerencia 1ra Línea
//        if(isset($criteria['gerenciaFirst'])){
//            if((int)$criteria['gerenciaFirst'] == 0){
//
//            } else{
//                $queryBuilder->andWhere('o_o.gerencia = ' . (int)$criteria['gerenciaFirst']);
//            }
//        }
//        
//        //Filtro Gerencia 2da Línea
//        if(isset($criteria['gerenciaSecond'])){
//            if((int)$criteria['gerenciaSecond'] > 0){
//                $queryBuilder->andWhere("o_o.gerenciaSecond = " . (int)$criteria['gerenciaSecond']);
//            } else{
//                unset($criteria['gerenciaSecond']);
//            }
//        }
//        
//        $queryBuilder->groupBy('i.ref');
//        $queryBuilder->orderBy('i.ref');
//
//        return $this->getPaginator($queryBuilder);
        return parent::createPaginator($criteria, $orderBy);
    }
    
    /**
     * Crea un paginador para los indicadores estratégicos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorStrategic(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%".$description."%'"),$queryBuilder->expr()->like('i.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los indicadores tácticos
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorTactic(array $criteria = null, array $orderBy = null) {
        $user = $this->getUser();
        $securityContext = $this->getSecurityContext();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%".$description."%'"),$queryBuilder->expr()->like('i.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX')) && !isset($criteria['gerencia'])){
            $queryBuilder->andWhere('ob.gerencia = '.$user->getGerencia()->getId());
        }
        
        //Si esta seteado el parámetro de gerencia de 1ra línea, lo anexamos al query
        if(isset($criteria['gerencia'])){
            if((int)$criteria['gerencia'] > 0){
                $queryBuilder->andWhere("ob.gerencia = " . (int)$criteria['gerencia']);
            } else{
                unset($criteria['gerencia']);
            }
        }
        
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los indicadores operativos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorOperative(array $criteria = null, array $orderBy = null) {
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled ');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%".$description."%'"),$queryBuilder->expr()->like('i.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            if(isset($criteria['gerenciaSecond'])){
                if((int)$criteria['gerenciaSecond'] == 0){//En el caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->andWhere('ob.gerencia = '.$user->getGerencia()->getId());;
                }
            } else{
                if($user->getGerencia()){
                    $queryBuilder->andWhere('ob.gerencia = '.$user->getGerencia()->getId());
                }
            }
        } elseif($securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $queryBuilder->andWhere('ob.gerenciaSecond = '. $user->getGerenciaSecond()->getId());
        } elseif($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
            if(isset($criteria['gerenciaSecond'])){
                if((int)$criteria['gerenciaSecond'] == 0){//En caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->leftJoin('ob.gerenciaSecond', 'gs');
                    $queryBuilder->andWhere('gs.complejo = '.$user->getComplejo()->getId());
                    $queryBuilder->andWhere('gs.modular =:modular');
                    $queryBuilder->setParameter('modular', true);
                }
            } else{
                $queryBuilder->leftJoin('ob.gerenciaSecond', 'gs');
                $queryBuilder->andWhere('gs.complejo = '.$user->getComplejo()->getId());
                $queryBuilder->andWhere('gs.modular =:modular');
                $queryBuilder->setParameter('modular', true);
            }
        }
        
        if(isset($criteria['gerenciaFirst'])){
            if((int)$criteria['gerenciaFirst'] == 0){

            } else{
                $queryBuilder->andWhere('ob.gerencia = ' . (int)$criteria['gerenciaFirst']);
            }
        }
        
        if(isset($criteria['gerenciaSecond'])){
            if((int)$criteria['gerenciaSecond'] > 0){
                $queryBuilder->andWhere("ob.gerenciaSecond = " . (int)$criteria['gerenciaSecond']);
            } else{
                unset($criteria['gerenciaSecond']);
            }
        }
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Indicadores de acuerdo a un objetivo
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return type
     */
    public function getByObjetiveTactic(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive){
        $qb = $this->getQueryBuilder();
        
        $qb->select('i.ref AS IndTacRef,i.description AS IndTac,i.goal AS IndTacGoal,i.weight AS IndTacPeso');
        $qb->addSelect('f.equation AS IndTacFormula');
        $qb->leftJoin('i.objetives', 'obj');
        $qb->leftJoin('i.formula', 'f');
        
        $qb->andWhere('i.enabled = :enabled');
        $qb->andWhere('obj.id = :idObjetive');
        
        $qb->setParameter('enabled', true);
        $qb->setParameter('idObjetive', $objetive->getId());
        
        $qb->orderBy('i.ref');
        
        return $qb->getQuery()->getResult();
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        
        //Vinculación con el objetivo al que esta vinculado el indicador
        $queryBuilder
                ->innerJoin('i.objetives', 'o')
                ->andWhere('i.enabled = 1')
                ->andWhere('o.enabled = 1')
                ->andWhere('i.tmp = 0')
                ;
        
        //Filtro por referencia o descripción
        if(($description = $criteria->remove('description')) !== null){
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%".$description."%'"),$queryBuilder->expr()->like('i.ref', "'%".$description."%'")));
        }
        
        //Filtro nivel del Indicador
        if(($level = $criteria->remove('indicatorLevel')) !== null){
            if($level > IndicatorLevel::LEVEL_ESTRATEGICO){
                $queryBuilder->innerJoin('o.gerencia', 'g');
            }
            $queryBuilder->andWhere("i.indicatorLevel = " . $level);
        }
        
        //Filtro Localidad
        if(($complejo =  $criteria->remove('complejo')) !== null){
            $queryBuilder->andWhere('g.complejo = ' . $complejo);
        }
        
        //Filtro Gerencia 1ra Línea
        if(($gerencia =  $criteria->remove('firstLineManagement')) !== null){
            $queryBuilder->andWhere('o.gerencia = ' . $gerencia);
        }
        
        //Filtro Gerencia 2da Línea
        if(($gerenciaSecond = $criteria->remove('secondLineManagement')) !== null){
            $queryBuilder->andWhere("o.gerenciaSecond = " . $gerenciaSecond);
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    
    protected function applySorting(\Doctrine\ORM\QueryBuilder $queryBuilder, array $sorting = null) {
        parent::applySorting($queryBuilder, $sorting);
    }
    
    protected function getAlias() {
        return 'i';
    }
}
