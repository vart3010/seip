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
 * Modelo de plantilla de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ReportTemplate extends BaseModel implements ReportTemplateInterface
{
    /**
     * Tipo: Produccion
     */
    const TYPE_REPORT_PRODUCTION = 0;
    /**
     * Tipo: Inventario
     */
    const TYPE_REPORT_INVENTORY = 1;
    /**
     * Tipo: Consumo de servicios
     */
    const TYPE_REPORT_CONSUMPTION_SERVICES = 2;
    /**
     * Tipo: Consumo de materia prima
     */
    const TYPE_REPORT_RAW_MATERIALS = 3;
    
    public static function getTypeReports()
    {
        return array(
            self::TYPE_REPORT_PRODUCTION => "pequiven_seip.report_template.type.production",
            self::TYPE_REPORT_INVENTORY => "pequiven_seip.report_template.type.inventory",
            self::TYPE_REPORT_CONSUMPTION_SERVICES => "pequiven_seip.report_template.type.consumption_services",
            self::TYPE_REPORT_RAW_MATERIALS => "pequiven_seip.report_template.type.raw_materials",
        );
    }
}
