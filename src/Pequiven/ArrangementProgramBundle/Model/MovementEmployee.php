<?php

namespace Pequiven\ArrangementProgramBundle\Model;

abstract class MovementEmployee {

    /**
     * MAESTROS DE ENTRADA
     */
    const ASIGNACION = 1;
    const SUSTITUCION = 2;
    const REINTEGRO = 3;
    const TRANSFERENCIA = 4;
    const NUEVO_INGRESO = 5;

    /**
     * MAESTROS DE SALIDA
     */
    const TRANSFERENCIA = 11;
    const RETIRO = 12;
    const AUSENCIA_TEMPORAL = 13;
    const CULMINACION_DE_ASIGNACION = 14;
    const CULMINACION_DE_SUSTITUCION = 15;

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
            self::SUSTITUCION => 'Sustitución',
            self::REINTEGRO => 'Reincorporación',
            self::TRANSFERENCIA => 'Transferencia',
            self::NUEVO_INGRESO => 'Nuevo Ingreso'
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
            self::CULMINACION_DE_ASIGNACION => 'Culminación de Asignación',
            self::AUSENCIA_TEMPORAL => 'Ausencia Temporal',
            self::CULMINACION_DE_SUSTITUCION => 'Culminación de Sustitución',
            self::TRANSFERENCIA => 'Transferencia',
            self::RETIRO => 'Retiro de la Empresa'
        ];
        return $array;
    }

    static function getAllCauses() {
        static $array = [
            self::ASIGNACION => 'Asignación',
            self::SUSTITUCION => 'Sustitución',
            self::REINTEGRO => 'Reincorporación',
            self::TRANSFERENCIA => 'Transferencia',
            self::NUEVO_INGRESO => 'Nuevo Ingreso',
            self::CULMINACION_DE_ASIGNACION => 'Culminación de Asignación',
            self::AUSENCIA_TEMPORAL => 'Ausencia Temporal',
            self::CULMINACION_DE_SUSTITUCION => 'Culminación de Sustitución',
            self::TRANSFERENCIA => 'Transferencia',
            self::RETIRO => 'Retiro de la Empresa'
        ];
        return $array;
    }

}
