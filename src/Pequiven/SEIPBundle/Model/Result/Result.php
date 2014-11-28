<?php

namespace Pequiven\SEIPBundle\Model\Result;

/**
 * Modelo del resultado
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
abstract class Result
{
    /**
     * Resultado de tipo indicador (Se calcula a partir de los indicadores)
     */
    const TYPE_RESULT_INDICATOR = 1;
    /**
     * Resultado de tipo programa de gestion (Se calcula a partir de los programas de gestion)
     */
    const TYPE_RESULT_ARRANGEMENT_PROGRAM = 2;
    /**
     * Resultados tipo objetivo (Se calcula a partir del valor del objetivo)
     */
    const TYPE_RESULT_OBJECTIVE = 3;
    
    /**
     * Tipo de calculo (Promedio simple)
     */
    const TYPE_CALCULATION_SIMPLE_AVERAGE = 1;
    
    /**
     * Tipo de calculo (Promedio ponderado)
     */
    const TYPE_CALCULATION_WEIGHTED_AVERAGE = 2;
    
    /**
     * Retorna los tipos de resultados
     * 
     * @staticvar array $results
     * @return string
     */
    static function getTypeResults()
    {
        static $results = array(
            self::TYPE_RESULT_INDICATOR => 'pequiven_seip.results.type_result.indicator',
            self::TYPE_RESULT_ARRANGEMENT_PROGRAM => 'pequiven_seip.results.type_result.arrangement_program',
            self::TYPE_RESULT_OBJECTIVE => 'pequiven_seip.results.type_result.objective',
        );
        return $results;
    }
    
    /**
     * Retorna los tipos de calculos
     * 
     * @staticvar array $typeCalculation
     * @return string
     */
    static function getTypeCalculations()
    {
        static $typeCalculation = array(
            self::TYPE_CALCULATION_SIMPLE_AVERAGE => 'pequiven_seip.results.type_calculation.simple_average',
            self::TYPE_CALCULATION_WEIGHTED_AVERAGE => 'pequiven_seip.results.type_calculation.weighted_average',
        );
        return $typeCalculation;
    }
}
