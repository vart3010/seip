<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of Chart(pequiven.repository.chart)
 *
 * @author victor tortolero
 */
class ChartRepository extends EntityRepository 
{
    
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $this->applyPeriodCriteria($queryBuilder);
        return parent::applyCriteria($queryBuilder, $criteria);
    }
}
