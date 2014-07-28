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
            if($options['type'] === 'TACTIC_ZIV'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId']);
            } elseif($options['type'] === 'TACTIC'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId'])
                      ->andWhere('o.complejo = ' . $options['complejoId']);
            }
        } else{//Para el campo referencia
            if(isset($options['lineStrategicId'])){
                $query->where('o.lineStrategic = ' . $options['lineStrategicId']);
            } elseif($options['type_ref'] === 'TACTIC_REF'){
                $query->andWhere('o.parent = ' . $options['objetiveStrategicId']);
            }
        }
        
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
