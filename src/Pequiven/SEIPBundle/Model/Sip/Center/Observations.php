<?php

namespace Pequiven\SEIPBundle\Model\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Categorias de las Observaciones
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class Observations {

    /**
     * Categorias
     *
     */
    const PROPAGANDA = 1;
    const TRANSPORTE = 2;
    const HIDRATACIÓN = 3;
    const LOGISTICA = 4;
    //const ASISTENCIA = 5;
    const TELEFONIA = 6;
    const OTROS = 7;
    const SERVICIO_LUZ = 8;
    const SERVICIO_AGUA = 9;
    const SERVICIO_ASEO = 10;
    const MATERIAL_OFICINA = 11;
    //const CAVA = 12;
    //const TERMO_AGUA = 13;
    const CNE = 14;
    const COMIDA = 15;
    const AYUDA_SOCIAL = 16;
    const INFRAESTRUCTURA = 17;
    //const SERVICIOS_MEDICOS = 18;

    /**
     * Status
     *
     */
    const ABIERTO = 1;
    const PENDIENTE = 2;
    const SEGUIMIENTO = 3;
    const CERRADO = 4;
    const RECHAZADO = 5;

    
    static function getCategoriasObservations() {
        static $levelProcessArray = [
            self::PROPAGANDA => 'Propaganda',
            self::TRANSPORTE => 'Transporte',
            self::HIDRATACIÓN => 'Hidratación',
            self::LOGISTICA => 'Logistica',
            //self::ASISTENCIA => 'Asistencia',
            self::TELEFONIA => 'Telefonia',
            self::OTROS => 'Otros...',
            self::SERVICIO_LUZ => 'Servicios de Luz',
            self::SERVICIO_AGUA => 'Servicios de Agua',
            self::SERVICIO_ASEO => 'Servicios de Aseo',
            self::MATERIAL_OFICINA => 'Material de Oficina',
            //self::CAVA => 'Cava',
            //self::TERMO_AGUA => 'Termo De Agua',
            self::CNE => 'CNE',
            self::COMIDA => 'Comida',
            self::AYUDA_SOCIAL => 'Ayuda Social',
            self::INFRAESTRUCTURA => 'Infraestructura',
            //self::SERVICIOS_MEDICOS => 'Servicios Médicos',
        ];
        return $levelProcessArray;
    }

    static function getStatusObservations() {
        static $status = [
            self::ABIERTO => 'Abierto',
            self::PENDIENTE => 'Pendiente',
            self::SEGUIMIENTO => 'Seguimiento',
            self::CERRADO => 'Cerrado',
            self::RECHAZADO => 'Rechazado',
        ];
        return $status;
    }

}
