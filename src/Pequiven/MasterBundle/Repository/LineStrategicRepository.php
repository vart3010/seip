<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of LineStrategicRepository (pequiven.repository.linestrategic)
 *
 * @author matias
 */
class LineStrategicRepository extends EntityRepository {
    //put your code here
    
    protected function getAlias() {
        return 'ls';
    }
}
