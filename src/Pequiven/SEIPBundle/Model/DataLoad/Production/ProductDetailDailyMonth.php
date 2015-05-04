<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad\Production;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de detalle de produccion diaria
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ProductDetailDailyMonth extends BaseModel implements ProductDetailDailyMonthInterface
{
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
}
