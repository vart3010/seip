<?php

namespace Pequiven\SEIPBundle\Model\CEI;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo del centro de acopio
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
abstract class SupplyCenter extends BaseModel {

    /**
     * Tipos de centro de acopio
     */
    const PRIVADO = 0;
    const PUBLICO = 1;
    const COMERCIALES = 2;

    public static function getTypesSupplyCenter() {
        return array(
            self::PRIVADO => 'pequiven_master.company.type.matriz',
            self::PUBLICO => 'pequiven_master.company.type.affiliated',
            self::COMERCIALES => 'pequiven_master.company.type.affiliated',
        );
    }

}
