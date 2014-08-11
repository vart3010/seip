<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;

/**
 * Description of IndicatorRepository
 *
 * @author matias
 */
class IndicatorRepository extends EntityRepository {
    //put your code here
    
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
}
