<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Model\Formula;

/**
 * Modelo de variable
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Variable implements VariableInterface
{
    /**
     * Nombre de la variable que se usara para calculos de equacion plan
     */
    const VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN = 'plan_from_equation';
    /**
     * Nombre de la variable que se usara para calculos de equacion real
     */
    const VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL = 'real_from_equation';
    
    /**
     * Retorna verdadero si la variable sera evaluada con una equacion
     * @return boolean
     */
    public function isFromEQ()
    {
        $r = false;
        if($this->getEquation() != ''){
            $r = true;
        }
        return $r;
    }
}
