<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\Common;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of CommonObject
 *
 * @author matias
 */
class CommonObject implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {
    /* NIVELES ESTRUCTURA ORGANIZACIONAL */

    /**
     * Nivel Complejo
     */
    const LEVEL_COMPLEJO = 1;

    /**
     * Nivel Gerencia 1ra Línea
     */
    const LEVEL_GERENCIA = 2;

    /**
     * Nivel Gerencia 2da Línea
     */
    const LEVEL_GERENCIA_SECOND = 3;

    /* STATUS TRABAJADORES */

    /**
     * Trabajador Activo
     */
    const STATUS_WORKER_ACTIVE = 1;

    /**
     * Trabajador Asignado
     */
    const STATUS_WORKER_ASSIGNED = 2;

    /**
     * Trabajador Supernumerario
     */
    const STATUS_WORKER_SUPERNUMERARY = 3;

    /**
     * Trabajador Fuera de la Compañía
     */
    const STATUS_WORKER_OUTSIDE_COMPANY = 4;

    /**
     * Trabajador con Reposo indefinido
     */
    const STATUS_WORKER_INDEFINITE_BREAK = 5;

    /**
     * Trabajador con Reposo indefinido
     */
    const STATUS_WORKER_SPECIAL_RESERVE = 6;

    /**
     * Aprendíz
     */
    const STATUS_WORKER_APPRENTICE = 7;

    /**
     * Pasante
     */
    const STATUS_WORKER_PASANTE = 8;
    
    /**
     * Honorarios Profesionales
     */
    const STATUS_WORKER_OUTSOURCING = 9;

    /* TIPOS DE RESULTADOS */

    /**
     * Resultado para la evaluación
     */
    const TYPE_RESULT_EVALUATION = 'EVALUATION';

    /**
     * Resultado para la Gestión
     */
    const TYPE_RESULT_ARRANGEMENT = 'ARRANGEMENT';

    /* TIPOS DE RANGOS DE GESTIÓN (PARA LOS SEMÁFOROS) */

    /**
     * Rango Bueno (Verde)
     */
    const TYPE_RANGE_GOOD = 'GOOD';

    /**
     * Rango Medio (Amarillo)
     */
    const TYPE_RANGE_MIDDLE = 'MIDDLE';

    /**
     * Rango Malo (Rojo)
     */
    const TYPE_RANGE_BAD = 'BAD';

    /* TIPO DE ABERTURA DE LAS URL */
    const OPEN_URL_OTHER_WINDOW = 0;
    const OPEN_URL_SAME_WINDOW = 1;

    /* TIPOS DE HOLGURA PARA MOSTRAR EL RANGO DE GESTIÓN EN FORMA GRÁFICA */

    /**
     * Rango de Gestión con holgura en los extremos
     */
    const ARRANGEMENT_RANGE_WITH_CLEARANCE = 0;

    /**
     * Rango de Gestión sin holgura en los extremos
     */
    const ARRANGEMENT_RANGE_WITHOUT_CLEARANCE = 1;

    /* TIPO DE NIVELES PARA LOS USUARIOS */

    /**
     * Roles del usuario sólo del tipo propietario
     */
    const TYPE_LEVEL_USER_ONLY_OWNER = 0;

    /**
     * Roles del usuario sin importar el tipo de rol
     */
    const TYPE_LEVEL_USER_ALL = 1;

    protected $months = array();
    protected $em;
    protected $class;
    protected $repository;
    protected $container;

    public function __construct() {
        $this->CommonObject();
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function CommonObject() {
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * Retorna las etiquetas definidas para los tipos de resumen
     * 
     * @staticvar array $labelsStatus
     * @return string
     */
    static function getLabelsStatusWorker() {
        static $labelsStatusWorker = array(
            self::STATUS_WORKER_ACTIVE => 'Trabajador Activo',
            self::STATUS_WORKER_ASSIGNED => 'Asignado',
            self::STATUS_WORKER_APPRENTICE => 'Aprendíz',
            self::STATUS_WORKER_PASANTE => 'Pasante',
            self::STATUS_WORKER_OUTSOURCING => 'OutSourcing/HP',
            self::STATUS_WORKER_SUPERNUMERARY => 'Supernumerario',
            self::STATUS_WORKER_SPECIAL_RESERVE => 'Reserva Especial',
            self::STATUS_WORKER_INDEFINITE_BREAK => 'Reposo indefinido',
            self::STATUS_WORKER_OUTSIDE_COMPANY => 'Fuera de la Compañía',
        );
        return $labelsStatusWorker;
    }

    /**
     * Retorna las etiquetas de los meses
     * @staticvar array $labelsMonths
     * @return string
     */
    static function getLabelsMonths() {
        static $labelsMonths = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        );

        return $labelsMonths;
    }

    /**
     * Retorna las etiquetas de los períodos Bimensuales
     * @staticvar array $labelsBimonthly
     * @return string
     */
    static function getLabelsBimonthly() {
        static $labelsBimonthly = array(
            1 => 'Ene-Feb',
            2 => 'Mar-Abr',
            3 => 'May-Jun',
            4 => 'Jul-Ago',
            5 => 'Sep-Oct',
            6 => 'Nov-Dic',
        );

        return $labelsBimonthly;
    }

    /**
     * Retorna las etiquetas de los períodos trimestrales
     * @staticvar array $labelsTrimonthly
     * @return string
     */
    static function getLabelsTrimonthly() {
        static $labelsTrimonthly = array(
            1 => 'Ene-Mar',
            2 => 'Abr-Jun',
            3 => 'Jul-Sep',
            4 => 'Oct-Dic',
        );

        return $labelsTrimonthly;
    }

    /**
     * Retorna las etiquetas de los períodos cuatrimestrales
     * @staticvar array $labelsFourmonthly
     * @return string
     */
    static function getLabelsFourmonthly() {
        static $labelsFourmonthly = array(
            1 => 'Ene-Abr',
            2 => 'May-Ago',
            3 => 'Sep-Dic',
        );

        return $labelsFourmonthly;
    }

    /**
     * Retorna las etiquetas de los períodos semestrales
     * @staticvar array $labelsSixmonthly
     * @return string
     */
    static function getLabelsSixmonthly() {
        static $labelsSixmonthly = array(
            1 => 'Ene-Jun',
            2 => 'Jul-Dic',
        );

        return $labelsSixmonthly;
    }

    /**
     * Retorna la cantidad de dias de un mes basado en un calendario (CAL_GREGORIAN) 
     * @param type $mes
     * @param type $ano
     * @return type
     */
    static function getDaysPerMonth($mes = "", $ano = "") {
        if ($ano == "") {
            $ano = date("Y");
        }
        return cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    }

    /**
     * LLENA EL VECTOR CON 12 POSICIONES QUE CORRESPONDEN A LOS MESES CON 0
     * @param int $array
     * @return int
     */
    static function fillArrayMonth($array, $value = 0) {
        for ($i = 1; $i <= 12; $i++) {
            $array[$i] = $value;
        }
        return $array;
    }

    /**
     * VALIDA SI EXISTE $FIND EN UN ARREGLO QUE TIENE UNA KEY [ID]
     * @param type $find
     * @param type $array
     * @return boolean
     */
    static function validIdExist($find, $array) {
        $band = false;
        foreach ($array as $value) {
            if ($value["id"] == $find) {
                $band = true;
                break;
            }
        }
        return $band;
    }

}
