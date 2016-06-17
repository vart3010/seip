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
 * Modelo de la empresa
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class Company extends BaseModel
{
    /**
     * Tipo de compañia matriz
     */
    const TYPE_OF_COMPANY_MATRIZ = 0;
    
    /**
     * Tipo de compañia filial
     */
    const TYPE_OF_COMPANY_AFFILIATED = 1;
    
    /**
     * Tipo de compañia mixta
     */
    const TYPE_OF_COMPANY_MIXTA = 2;
    
    /**
     * Tipo de compañia mixta o filial
     */
    const TYPE_OF_COMPANY_AFFILIATED_MIXTA = 3;
    
    /**
     * Proceso de produccion
     */
    const TYPE_PROCESS_PRODUCTION = 0;
    
    public static function getTypesOfCompanies()
    {
        return array(
            self::TYPE_OF_COMPANY_MATRIZ => 'pequiven_master.company.type.matriz',
            self::TYPE_OF_COMPANY_AFFILIATED => 'pequiven_master.company.type.affiliated',
            self::TYPE_OF_COMPANY_MIXTA => 'pequiven_master.company.type.mixta',
        );
    }
    
    /**
     * Retorna todos los tipos de procesos
     * @return type
     */
    public static function getTypesProcess()
    {
        return array(
            self::TYPE_PROCESS_PRODUCTION => 'pequiven_master.company.process.production',
        );
    }
    
    /**
     * Retorna los tipos de procesos disponibles
     * @return type
     */
    public static function getTypesProcessAvailable()
    {
        return array(
            self::TYPE_PROCESS_PRODUCTION => 'pequiven_master.company.process.production',
        );
    }
}
