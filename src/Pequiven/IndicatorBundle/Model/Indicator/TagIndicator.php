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
 * Modelo de las etiquetas del indicador
 *
 */
abstract class TagIndicator
{
    /**
     * Etiqueta cuyo valor es numérico
     */
    const TAG_TYPE_NUMERIC = 1;
    
    /**
     * Etiqueta cuyo valor es un texto
     */
    const TAG_TYPE_TEXT = 2;
    
    /**
     * Valor calculado a partir de una ecuación
     */
    const TAG_VALUE_FROM_EQUATION = 1;
    
    /**
     * Valor ingresado por el usuario
     */
    const TAG_VALUE_FROM_INPUT = 2;
    
    /**
     * Origen de resultado (Acumulado de Todas las notificaciones)
     */
    const SOURCE_RESULT_ALL = 0;
    
    /**
     * Origen de resultado (Tomar la ultima notificación)
     */
    const SOURCE_RESULT_LAST = 1;
    
    /**
     * Retorna los tipos de etiquetas de indicador que hay.
     * 
     * @staticvar array $typesOfTag
     * @return array
     */
    static function getLabelTypesOfTag()
    {
        static $typesOfTag = array(
            self::TAG_TYPE_NUMERIC => 'pequiven_indicator.type_tag.tagNumeric',
            self::TAG_TYPE_TEXT => 'pequiven_indicator.type_tag.tagText',
        );
        return $typesOfTag;
    }
    
    /**
     * Tipo de entrada del valor de la etiqueta.
     * 
     * @staticvar array $typesOfValueInput
     * @return array
     */
    static function getLabelTypesOfValueInput()
    {
        static $typesOfValueInput = array(
            self::TAG_VALUE_FROM_EQUATION => 'pequiven_indicator.type_value_tag.fromEquation',
            self::TAG_VALUE_FROM_INPUT => 'pequiven_indicator.type_value_tag.fromInput',
        );
        return $typesOfValueInput;
    }
}
