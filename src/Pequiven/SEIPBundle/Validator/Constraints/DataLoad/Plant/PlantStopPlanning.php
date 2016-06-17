<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints\DataLoad\Plant;

use Symfony\Component\Validator\Constraint;

/**
 * Validador de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantStopPlanning extends Constraint 
{
    public $message = '';
    public function getTargets() 
    {
        return self::CLASS_CONSTRAINT;
    }
}
