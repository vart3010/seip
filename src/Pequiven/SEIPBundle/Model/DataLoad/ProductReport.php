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
    /**
     * Devuelve la planificacion de la produccion bruta
     * @return type
     */
    public function getProductPlanningsGross()
    {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_GROSS);
    }
    
    /**
     * Devuelve la planificacion de la produccion neta
     * @return type
     */
    public function getProductPlanningsNet()
    {
        return $this->getProductPlanningsByType(Production\ProductPlanning::TYPE_NET);
    }
    
    public function getProductPlanningsByType($type)
    {
        $productPlannings = $this->getProductPlannings();
        $result = array();
        foreach ($productPlannings as $productPlanning) {
            if($productPlanning->getType() === $type){
                $result[$productPlanning->getMonth()] = $productPlanning;
            }
        }
        ksort($result);
        return $result;
    }
}
