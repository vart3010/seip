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

/**
 * Interfaz de producto de reporte
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface ProductReportInterface 
{
    public function getProductPlannings();
    /**
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth Description
     */
    public function getProductDetailDailyMonthsSortByMonth();
    /**
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning Description
     */
    public function getRawMaterialConsumptionPlannings();
    
    /**
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProduction Description
     */
    public function getUnrealizedProductionsSortByMonth();
    
    /**
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Inventory\Inventory Description
     */
    public function getInventorySortByMonth();
}
