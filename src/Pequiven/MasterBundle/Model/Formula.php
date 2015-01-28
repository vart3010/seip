<?php

namespace Pequiven\MasterBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo de la formula
 *
 * @author matias
 */
abstract class Formula 
{
    /**
     * Tipo de calculo de la formula es promedio simple (No requiere variable)
     */
    const TYPE_CALCULATION_SIMPLE_AVERAGE = 0;
    
    /**
     * Tipo de calculo de la formula es por real y plan automatico (Requiere variables para obtener el plan y el real)
     */
    const TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC = 1;
    
    /**
     * Tipo de calculo de la formula es por real automatico (Requiere variables para obtener el real)
     */
    const TYPE_CALCULATION_REAL_AUTOMATIC = 2;
    
    /**
     * Tipo de calculo de la formula es acumulado de todos los resultados.
     */
    const TYPE_CALCULATION_ACCUMULATE = 3;
    
    /**
     * Tipo de calculo de la formula es por plan y real a partir de ecuacion.
     */
    const TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ = 4;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfCalculation", type="integer", nullable=false)
     */
    protected $typeOfCalculation = self::TYPE_CALCULATION_SIMPLE_AVERAGE;
    
    /**
     * Retorna los tipos de calculo disponible para la formula y sus etiquetas.
     * 
     * @staticvar array $typesOfCalculation
     * @return array
     */
    static function getTypesOfCalculation()
    {
        static $typesOfCalculation = array(
            self::TYPE_CALCULATION_SIMPLE_AVERAGE => 'pequiven_indicator.type_calculation.simple_average',
            self::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC => 'pequiven_indicator.type_calculation.real_and_plan_automatic',
            self::TYPE_CALCULATION_REAL_AUTOMATIC => 'pequiven_indicator.type_calculation.real_automatic',
            self::TYPE_CALCULATION_ACCUMULATE => 'pequiven_indicator.type_calculation.accumulate',
            self::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ => 'pequiven_indicator.type_calculation.real_and_plan_from_eq',
        );
        return $typesOfCalculation;
    }
    
    function getTypeOfCalculationLabel() {
        $typesOfCalculation = self::getTypesOfCalculation();
        if(isset($typesOfCalculation[$this->typeOfCalculation]) === false){
            throw new Exception(sprintf('The type of calculation "%s" dont exist',$this->typeOfCalculation));
        }
        return $typesOfCalculation[$this->typeOfCalculation];
    }
}
