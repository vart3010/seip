<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Plantilla de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ReportTemplate extends BaseModel 
{
    /**
     * Tipo de reporte de produccion
     */
    const TYPE_PRODUCTION = 1;
    
    /**
     * Tipo de reporte de inventario
     */
    const TYPE_SERVICE_CONSUMPTION = 2;
    
    /**
     * Tipo consumo de materia prima
     */
    const TYPE_RAW_MATERIAL_CONSUMPTION = 3;
    
    public static function getReportTemplateTypesLabel()
    {
        return array(
            self::TYPE_PRODUCTION => "pequiven_seip.report_template.type.production",
            self::TYPE_SERVICE_CONSUMPTION => "pequiven_seip.report_template.type.service_consumption",
            self::TYPE_RAW_MATERIAL_CONSUMPTION => "pequiven_seip.report_template.type.raw_material_consumption",
        );
    }
}
