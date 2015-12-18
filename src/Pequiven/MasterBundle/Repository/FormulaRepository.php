<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
/**
 * Description of FormulaRepository
 *
 * @author matias
 */
class FormulaRepository extends EntityRepository {
    
    
    protected function getAlias() {
        return 'f';
    }
}
