<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Validacion de presupuesto de produccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ValidProductPlanning extends Constraint 
{
    public $service = 'pequiven.orm.validator.valid_product_planning';
    
    public $message = 'pequiven.validators.valid_product_planning.test';
    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return $this->service;
    }
    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
