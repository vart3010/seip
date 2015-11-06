<?php

namespace Pequiven\ArrangementProgramBundle\Model;

abstract class MovementEmployee {

    /**
     * MAESTROS DE ENTRADA
     */
    const ASIGNACION = 1;
    const SUPLENCIA = 2;
    const REINTEGRO = 3;

    /**
     * MAESTROS DE SALIDA
     */
    const CAMBIO = 11;
    const RETIRO = 12;
    const REPOSO = 13;
    const FINAL_SUPLENCIA = 14;

    /**
     * @var integer
     *
     * @ORM\Column(name="causein", type="integer")
     */
    protected $causein;

    /**
     * @var integer
     *
     * @ORM\Column(name="causeout", type="integer")
     */
    protected $causeout;

    /**
     * 
     * @param type $causein
     */
    function setCausein($causein) {
        $this->causein = $causein;
    }

    /**
     * 
     * @param type $causeout
     */
    function setCauseout($causeout) {
        $this->causeout = $causeout;
    }

    /**
     * 
     * @staticvar array $array
     * @return string
     */
    static function getCausein() {
        static $array = [
            self::ASIGNACION => 'Asignación',
            self::SUPLENCIA => 'Suplencia',
            self::REINTEGRO => 'Reintegro por Reposo'
        ];
        return $array;
    }

    /**
     * 
     * @staticvar array $array
     * @return string
     */
    static function getCauseout() {
        static $array = [
            self::CAMBIO => 'Cambio',
            self::FINAL_SUPLENCIA => 'Culminación de Suplencia',
            self::REPOSO => 'Reposo',
            self::RETIRO => 'Retiro',
        ];
        return $array;
    }

    static function getAllCauses() {
        static $array = [
            self::ASIGNACION => 'Asignación',
            self::SUPLENCIA => 'Suplencia',
            self::REINTEGRO => 'Reintegro por Reposo',
            self::FINAL_SUPLENCIA => 'Culminación de Suplencia',
            self::CAMBIO => 'Cambio',
            self::RETIRO => 'Retiro',
            self::REPOSO => 'Reposo'
        ];
        return $array;
    }

}
