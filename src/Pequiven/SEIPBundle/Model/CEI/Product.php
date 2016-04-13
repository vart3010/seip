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
    /**
     * Tipo: Producto final
     */
    const TYPE_PRODUCT_FINAL = 0;
    /**
     * Tipo: Sub-producto
     */
    const TYPE_PRODUCT_BYPRODUCT = 1;
    
    /**
     * Retorna los tipos de productos
     * @return string
     */
    public static function getTypeProductLabels()
    {
        return array(
            self::TYPE_PRODUCT_FINAL => "pequiven_seip.product_report.type.final",
            self::TYPE_PRODUCT_BYPRODUCT => "pequiven_seip.product_report.type.byproduct",
        );
    }
    
    /**
     * Retorna la etiqueta del tipo de producto
     * @return string
     */
    public function getTypeProductLabel()
    {
        $typeProduct = $this->getTypeProduct();
        $typeProductLabels = $this->getTypeProductLabels();
        $label = "";
        if(isset($typeProductLabels[$typeProduct])){
            $label = $typeProductLabels[$typeProduct];
        }
        return $label;
    }
}
