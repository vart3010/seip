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
 * Modelo de Tipo de sede
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class TypeLocation extends BaseModel
{
    /**
     * Planta de produccion
     */
    const CODE_PLANT_PRODUCTION = "plant_production";
    
    /**
     * Almacen
     */
    const CODE_WAREHOUSE = "warehouse";
    
    /**
     * Distribuidor
     */
    const CODE_DISTRIBUTOR = "distributor";
    
    /**
     * Oficina administrativa
     */
    const CODE_ADMINISTRATIVE_OFFICE = "administrative_office";
    
    /**
     * Comercializadora
     */
    const CODE_TRADING = "trading";
    
}
