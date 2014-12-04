<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository;

use Doctrine\ORM\EntityRepository;
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
                ->innerJoin('o.objetives', 'o_o')
                ->innerJoin('o.indicatorLevel', 'o_il')
                ->andWhere('o.enabled = 1')
                ->andWhere('o_o.enabled = 1')
                ->andWhere('o.tmp = 0')
                ->andWhere("o_il.level > :level")
                ->setParameter('level', $level)
                ;
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
        
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
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->innerJoin('o.objetives', 'o_o')
                ->andWhere('o.enabled = 1')
                ->andWhere('o_o.enabled = 1')
                ;
        $queryBuilder->andWhere('o.tmp = 0');
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->like('o.description', "'%".$description."%'"));
            $queryBuilder->andWhere($queryBuilder->expr()->like('o.ref', "'%".$description."%'"));
        }
        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("o.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        return $this->getPaginator($queryBuilder);
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
        $queryBuilder->andWhere('o.enabled =:enabled');
        $queryBuilder->innerJoin('o.objetives', 'ob');
        $queryBuilder->andWhere('o.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("o.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

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
        $queryBuilder->andWhere('o.enabled =:enabled');
        $queryBuilder->innerJoin('o.objetives', 'ob');
        $queryBuilder->andWhere('o.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("o.indicatorLevel = " . $criteria['indicatorLevel']);
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
        
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

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
        $queryBuilder->andWhere('o.enabled =:enabled');
        $queryBuilder->innerJoin('o.objetives', 'ob');
        $queryBuilder->andWhere('o.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled ');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }

        if(isset($criteria['indicatorLevel'])){
            $queryBuilder->andWhere("o.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            if(isset($criteria['gerenciaSecond'])){
                if((int)$criteria['gerenciaSecond'] == 0){//En el caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->andWhere('ob.gerencia = '.$user->getGerencia()->getId());;
                }
            } else{
                $queryBuilder->andWhere('ob.gerencia = '.$user->getGerencia()->getId());
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
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

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
        
        $qb->select('o.ref AS IndTacRef,o.description AS IndTac,o.goal AS IndTacGoal,o.weight AS IndTacPeso');
        $qb->addSelect('f.equation AS IndTacFormula');
        $qb->leftJoin('o.objetives', 'obj');
        $qb->leftJoin('o.formula', 'f');
        
        $qb->andWhere('o.enabled = :enabled');
        $qb->andWhere('obj.id = :idObjetive');
        
        $qb->setParameter('enabled', true);
        $qb->setParameter('idObjetive', $objetive->getId());
        
        $qb->orderBy('o.ref');
        
        return $qb->getQuery()->getResult();
    }
}
