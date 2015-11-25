<?php

namespace Pequiven\SEIPBundle\Model\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Cargo ubch
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class Ubch {

    /**
     * Categorias
     *
     */
    const JEFE = 1;
    const PATRULLERO = 2;
    const PROPAGANDA = 3;
    const MOVIMIENTOS_SOCIALES = 4;
    const ARTICULACION_JUVENTUD = 5;
    const APOYO_GOBIERNO_CALLE = 6;
    const SEGURIDAD_DEFENSA = 7;
    const LOGISTICA = 8;
    const MUJERES = 9;
    const FORMACION_IDEOLOGICA = 10;
    const MOVILIZACION = 11;
    
    static function getCargoUbch() {
        static $LabelsUbch = [
            self::JEFE => 'Jefe',
            self::PATRULLERO => 'Patrullero',
            self::PROPAGANDA => 'Propaganda',
            self::MOVIMIENTOS_SOCIALES => 'Movimientos Sociales',
            self::ARTICULACION_JUVENTUD => 'Articulación con la Juventud',
            self::APOYO_GOBIERNO_CALLE => 'Apoyo al Gobierno de Calle',
            self::SEGURIDAD_DEFENSA => 'Seguridad y Defensa',
            self::LOGISTICA => 'Logistica',
            self::MUJERES => 'Mujeres',            
            self::FORMACION_IDEOLOGICA => 'Formación Ideológica',
            self::MOVILIZACION => 'Movilización',
        ];
        return $LabelsUbch;
    }

}
