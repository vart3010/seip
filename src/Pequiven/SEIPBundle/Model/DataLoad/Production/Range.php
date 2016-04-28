<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad\Production;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de rango
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Range extends BaseModel implements RangeInterface
{
    /**
     * Tipo: Valor fijo
     */
    const TYPE_FIXED_VALUE = 0;
    /**
     * Tipo: Factor de capacidad
     */
    const TYPE_CAPACITY_FACTOR = 1;
    
    /**
     * Devuelve los tipos de rangos
     * @return integer
     */
    public static function getTypeLabels()
    {
        return array(
            self::TYPE_FIXED_VALUE => "pequiven_seip.range.type.fixed_value",
            self::TYPE_CAPACITY_FACTOR => "pequiven_seip.range.type.capacity_factor",
        );
    }
    
    /**
     * Retorna la etiqueta del tipo de rango
     * @return string
     */
    public function getTypeLabel()
    {
        $type = $this->getType();
        $typeLabels = $this->getTypeLabels();
        $label = "";
        if(isset($typeLabels[$type])){
            $label = $typeLabels[$type];
        }
        return $label;
    }
    
    /**
     * Retorna la unidad dependiendo del valor
     * @return string
     */
    public function getValueUnit()
    {
        $type = $this->getType();
        $valueUnit = "";
        if($type == self::TYPE_FIXED_VALUE){
            $valueUnit = $this->getProductPlanning()->getProductReport()->getProduct()->getProductUnit();
        }else if($type == self::TYPE_CAPACITY_FACTOR){
            $valueUnit = "%";
        }
        return $valueUnit;
    }
}
