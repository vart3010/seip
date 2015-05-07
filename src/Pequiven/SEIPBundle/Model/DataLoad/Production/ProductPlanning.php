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
 * Modelo  de Planificacion de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ProductPlanning extends BaseModel implements ProductPlanningInterface
{
    /**
     * Tipo bruta
     */
    const TYPE_GROSS = 0;
    /**
     * Tipo neta
     */
    const TYPE_NET = 1;
    
    public function getMonthLabel()
    {
        $month = $this->getMonth();
        $monthsLabels = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
        $label = "";
        if(isset($monthsLabels[$month])){
            $label = $monthsLabels[$month];
        }
        return $label;
    }
    
    /**
     * Retorna los tipos de posibles
     * @return type
     */
    public static function getTypeLabels() 
    {
        return array(
            self::TYPE_GROSS => "pequiven_seip.gross",
            self::TYPE_NET => "pequiven_seip.net",
        );
    }
}
