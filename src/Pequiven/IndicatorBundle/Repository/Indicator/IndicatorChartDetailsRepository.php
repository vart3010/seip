<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository\Indicator;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of IndicatorChartDetailsRepository (pequiven.repository.indicatorchartdetails)
 *
 * @author matias
 */
class IndicatorChartDetailsRepository extends EntityRepository {
    
    protected function getAlias() {
        return 'icd';
    }
}
