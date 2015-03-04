<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Model\Indicator;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del valor de indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ValueIndicator
{
    /**
     * Parametros que se usaron en las variables de las formulas
     * @var array
     * @ORM\Column(name="formulaParameters",type="array",nullable=false)
     */
    protected $formulaParameters;
    
    function setParameter($key,$value)
    {
        $this->formulaParameters[$key] = $value;
    }
    
    function getParameter($key,$default = null)
    {
        if(isset($this->formulaParameters[$key])){
            $default = $this->formulaParameters[$key];
        }
        return $default;
    }
}
