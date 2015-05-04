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
abstract class ProductReport extends BaseModel implements ProductReportInterface
{
    /**
     * Tipo: Producto final
     */
    const TYPE_PRODUCT_FINAL = 0;
    /**
     * Tipo: Sub-producto
     */
    const TYPE_PRODUCT_BYPRODUCT = 1;

    const UNIT_TM = "TM";
    public static function getProductUnits()
    {
        return array(
            self::UNIT_TM => "TM"
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
}
