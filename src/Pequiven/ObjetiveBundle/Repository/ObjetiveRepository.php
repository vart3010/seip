<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ObjetiveRepository
 *
 * @author matias
 */
class ObjetiveRepository extends EntityRepository {
    //put your code here
    public function getByUser(){
        
    }
    
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
        //var_dump($q->getSQL());
        //die();
        return $q->getResult();
    }
    
    /**
     * Devuelve un grupo de resultados del objetivo para cuando se va a calcular el número de referencia para un objetivo operativo
     */
    public function getToCalculateRefFromObjetiveOperative($options = array()){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->groupBy('o.ref');
        $query->andWhere($query);
        
        
        $q = $query->getQuery();
        //var_dump($q->getSQL());
        //die();
        return $q->getResult();
    }
    
    /**
     * 
     * @param type $lineStrategicId
     * @return type
     */
    public function getByLineStrategicGroupComplejo($lineStrategicId){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->where('o.lineStrategic = ' . $lineStrategicId)
                    ->groupBy('o.complejo')
                    ->getQuery();
        return $query->getResult();
    }

}
