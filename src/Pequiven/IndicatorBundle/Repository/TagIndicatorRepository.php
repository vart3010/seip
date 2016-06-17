<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of TagIndicatorRepository (pequiven.repository.tagindicator)
 *
 * @author matias
 */
class TagIndicatorRepository extends EntityRepository {
    //put your code here
    
    protected function getAlias() {
        return 'ti';
    }
}
