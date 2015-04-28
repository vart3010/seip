<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ProductReport extends BaseModel
{
    const UNIT_TM = "TM";
    public static function getProductUnits()
    {
        return array(
            self::UNIT_TM => "TM"
        );
    }
}
