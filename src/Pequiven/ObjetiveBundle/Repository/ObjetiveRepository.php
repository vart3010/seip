<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository as silyusEntityRepository;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository as baseEntityRepository;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of ObjetiveRepository
 *
 * @author matias
 */
class ObjetiveRepository extends baseEntityRepository {
    
    /**
     * Devuelve un grupo de resultados de acuerdo al campo pasado en $options y agrupado por la referencia
     * @param type $options
     * @return type
     */
    public function getByOptionGroupRef($options = array()){
        
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->andWhere('o.enabled = 1')
                    ->groupBy('o.ref');
        if(isset($options['type'])){//Para los select
            if($options['type'] === 'TACTIC_ZIV' || $options['type'] === 'OPERATIVE_ZIV'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId']);
            } elseif($options['type'] === 'TACTIC' || $options['type'] === 'OPERATIVE'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId'])
                      ->andWhere('o.complejo = ' . $options['complejoId']);
            }
        } else{//Para el campo referencia
            if(isset($options['lineStrategicId'])){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId']);
                $query->andWhere('o.objetiveLevel = ' . \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO);
            } elseif($options['type_ref'] === 'TACTIC_REF'){
                if(isset($options['type_directive'])){
                    $query->andWhere("o.parent IN (" . $options['array_parent'] . ")");
                } else{
                    $query->andWhere('o.parent = ' . $options['objetiveStrategicId']);
                }
            } elseif($options['type_ref'] === 'OPERATIVE_REF'){
                $query->andWhere('o.parent = ' . $options['objetiveTacticId']);
            }
        }
        
        $q = $query->getQuery();
//        var_dump($q->getSQL());
//        die();
        return $q->getResult();
    }
    
    /**
     * Función que devuelve los resultados necesarios para obtener la referencia del objetivo que se este creando
     * @param type $options
     * @return type
     */
    public function getRefNewObjetive($options = array()){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->andWhere('o.enabled = 1')
                    ->groupBy('o.ref');
        
        if($options['type_ref'] === 'STRATEGIC_REF'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId']);
                $query->andWhere('o.objetiveLevel = ' . \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO);
            } elseif($options['type_ref'] === 'TACTIC_REF'){
                $query->andWhere("o.ref LIKE '".$options['refParent']."%'");
                $query->andWhere('o.objetiveLevel = ' . \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO);
            } elseif($options['type_ref'] === 'OPERATIVE_REF'){
                $query->andWhere("o.ref LIKE '".$options['refParent']."%'");
                $query->andWhere('o.objetiveLevel = ' . \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO);
            }
        
        $q = $query->getQuery();
//        var_dump($q->getSQL());
//        die();
        return $q->getResult();
    }
    
    /**
     * Función que devuelve los objetivos estratégicos de acuerdo a las líneas estratégicas
     * @param type $lineStrategicsArray
     * @return type
     */
    public function getByLineStrategic($lineStrategicsArray){
        //$em = $this->getEntityManager();
        $query = $this->createQueryBuilder('o');
        $query
            ->select('o')
            ->innerJoin('o.lineStrategics', 'ls')
            ->andWhere($query->expr()->in('ls.id', $lineStrategicsArray))
                ;
        return $query->getQuery()->getResult();
    }
    
    /**
     * Función que devuelve los objetivos hijos de un objetivo
     * @param type $objetiveParentsArray
     * @return type
     */
    public function getByParent($objetiveParentsArray){
        $securityContext = $this->getSecurityContext();
        
        $query = $this->createQueryBuilder('o');
        $query
                ->select('o')
                ->innerJoin('o.parents', 'p')
                ->andWhere($query->expr()->in('p.id', $objetiveParentsArray))
                ;
        
        if($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $query->andWhere("o.gerencia = " . $securityContext->getToken()->getUser()->getGerencia()->getId());
        }

        return $query->getQuery()->getResult();
    }
    
    /**
     * Función que devuelve los objetivos padres de un objetivo
     * @param type $objetiveChildrensArray
     * @return type
     */
    public function getByChildren($objetiveChildrensArray){
        $query = $this->createQueryBuilder('o');
        $query
                ->select('o')
                ->innerJoin('o.childrens', 'c')
                ->andWhere($query->expr()->in('c.id', $objetiveChildrensArray))
                ;

        return $query->getQuery()->getResult();
    }
    
    /**
     * Crea un paginador para los objetivos de acuerdo al nivel del mismo
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevel(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('o.enabled = 1');
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->like('o.description', "'%".$description."%'"));
            $queryBuilder->andWhere($queryBuilder->expr()->like('o.ref', "'%".$description."%'"));
        }
//        if(isset($criteria['rif'])){
//            $rif = $criteria['rif'];
//            unset($criteria['rif']);
//            $queryBuilder->andWhere($queryBuilder->expr()->like('o.rif', "'%".$rif."%'"));
//        }
        if(isset($criteria['objetiveLevel'])){
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }

}
