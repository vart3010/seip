<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\CEI;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Product extends BaseModel
{
    const TYPE_PRODUCT = 0;
    const TYPE_SERVICE = 1;
    
    static function getTypesLabel()
    {
        return array(
            self::TYPE_PRODUCT => 'pequiven_seip.product.type.product',
            self::TYPE_SERVICE => 'pequiven_seip.product.type.service',
        );
    }
}
