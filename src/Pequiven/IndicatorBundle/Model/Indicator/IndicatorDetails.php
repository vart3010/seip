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

/**
 * Description of IndicatorDetails
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class IndicatorDetails 
{
    /**
     * Origen de resultado (Todas las notificaciones)
     */
    const SOURCE_RESULT_ALL = 0;
    
    /**
     * Origen de resultado (Tomar la ultima notificacion con valores)
     */
    const SOURCE_RESULT_LAST_VALID = 1;
    
    /**
     * Origen de resultado (Tomar la ultima notificacion con o sin valores)
     */
    const SOURCE_RESULT_LAST = 2;
    
    public function getSourceResultLabel()
    {
        
    }
    
    public static function getSourceResultLabels()
    {
        return array(
            self::SOURCE_RESULT_ALL => 'pequiven_indicator.indicator_details.source_result_all',
            self::SOURCE_RESULT_LAST_VALID => 'pequiven_indicator.indicator_details.source_result_last_valid',
            self::SOURCE_RESULT_LAST => 'pequiven_indicator.indicator_details.source_result_last',
        );
    }
}
