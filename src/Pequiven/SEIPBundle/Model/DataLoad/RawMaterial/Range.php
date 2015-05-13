<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad\RawMaterial;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Description of Range
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Range extends BaseModel 
{
    /**
     * Tipo: Valor fijo
     */
    const TYPE_FIXED_VALUE = 0;
    /**
     * Tipo: Factor de capacidad
     */
    const TYPE_PERCENTAGE_BUDGET = 1;
    
    /**
     * Devuelve los tipos de rangos
     * @return integer
     */
    public static function getTypeLabels()
    {
        return array(
            self::TYPE_FIXED_VALUE => "pequiven_seip.range.type.fixed_value",
            self::TYPE_PERCENTAGE_BUDGET => "pequiven_seip.range.type.percentage_budget",
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
            $valueUnit = $this->getDetailRawMaterialConsumption()->getRawMaterialConsumptionPlanning()->getProduct()->getProductUnit();
        }else if($type == self::TYPE_PERCENTAGE_BUDGET){
            $valueUnit = "%";
        }
        return $valueUnit;
    }
}
