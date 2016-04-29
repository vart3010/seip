<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints\DataLoad;

use Symfony\Component\Validator\Constraint;

/**
 * Validacion de produccion diaria
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductDetailDailyMonth extends Constraint
{
    public $service = 'pequiven.orm.validator.product_detail_daily_month';
    
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