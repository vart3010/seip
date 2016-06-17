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
            self::PUBLICO => 'pequiven_seip.supply_center.public',
            self::PRIVADO => 'pequiven_seip.supply_center.private',
            self::COMERCIALES => 'pequiven_seip.supply_center.trade',
        );
    }

}
