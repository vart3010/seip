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
    const JEFE_UBCH = 1;
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
    const JEFE_PATRULLERO = 12;
    const JEFE_PROPAGANDA = 13;
    const JEFE_MOVIMIENTOS_SOCIALES = 14;
    const JEFE_ARTICULACION_JUVENTUD = 15;
    const JEFE_APOYO_GOBIERNO_CALLE = 16;
    const JEFE_SEGURIDAD_DEFENSA = 17;
    const JEFE_LOGISTICA = 18;
    const JEFE_MUJERES = 19;
    const JEFE_FORMACION_IDEOLOGICA = 20;
    const JEFE_MOVILIZACION = 21;
    
    static function getCargoUbch() {
        static $LabelsUbch = [
            self::JEFE_UBCH => 'Jefe de UBCH',
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
            self::JEFE_PATRULLERO => 'Jefe Patrullero',
            self::JEFE_PROPAGANDA => 'Jefe Propaganda',
            self::JEFE_MOVIMIENTOS_SOCIALES => 'Jefe Movimientos Sociales',
            self::JEFE_ARTICULACION_JUVENTUD => 'Jefe Articulación con la Juventud',
            self::JEFE_APOYO_GOBIERNO_CALLE => 'Jefe Apoyo al Gobierno de Calle',
            self::JEFE_SEGURIDAD_DEFENSA => 'Jefe Seguridad y Defensa',
            self::JEFE_LOGISTICA => 'Jefe Logistica',
            self::JEFE_MUJERES => 'Jefe Mujeres',            
            self::JEFE_FORMACION_IDEOLOGICA => 'Jefe Formación Ideológica',
            self::JEFE_MOVILIZACION => 'Jefe Movilización',
        ];
        return $LabelsUbch;
    }

}
