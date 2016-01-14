<?php

namespace Pequiven\SEIPBundle\Model\CEI;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo del centro de acopio
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
abstract class SupplyCenter extends BaseModel {

    /**
     * Tipos de centro de acopio
     */
    const INTERNAL = 0;
    
    const EXTERNAL = 1;

    public static function getTypesSupplyCenter() {
        return array(
            self::INTERNAL => 'pequiven_master.company.type.matriz',
            self::EXTERNAL => 'pequiven_master.company.type.affiliated',
        );
    }

}
