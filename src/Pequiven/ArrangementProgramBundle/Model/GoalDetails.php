<?php

namespace Pequiven\ArrangementProgramBundle\Model;

/**
 * Modelo de detalle de meta
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class GoalDetails {
    const JANUARY_PLANNED = 'januaryPlanned';
    const JANUARY_REAL = 'januaryReal';
    
    const FEBRUARY_PLANNED = 'februaryPlanned';
    const FEBRUARY_REAL = 'februaryReal';
    
    const MARCH_PLANNED = 'marchPlanned';
    const MARCH_REAL = 'marchReal';
    
    const APRIL_PLANNED = 'aprilPlanned';
    const APRIL_REAL = 'aprilReal';
    
    const MAY_PLANNED = 'mayPlanned';
    const MAY_REAL = 'mayReal';
    
    const JUNE_PLANNED = 'junePlanned';
    const JUNE_REAL = 'juneReal';
    
    const JULY_PLANNED = 'julyPlanned';
    const JULY_REAL = 'julyReal';
    
    const AUGUST_PLANNED = 'augustPlanned';
    const AUGUST_REAL = 'augustReal';
    
    const SEPTEMBER_PLANNED = 'septemberPlanned';
    const SEPTEMBER_REAL = 'septemberReal';
    
    const OCTOBER_PLANNED = 'octoberPlanned';
    const OCTOBER_REAL = 'octoberReal';
    
    const NOVEMBER_PLANNED = 'novemberPlanned';
    const NOVEMBER_REAL = 'novemberReal';
    
    const DECEMBER_PLANNED = 'decemberPlanned';
    const DECEMBER_REAL = 'decemberReal';
    
    /**
     * Retorna el numero del mes que equivale el string
     * @staticvar array $months
     * @param type $real
     * @return int
     * @throws Exception
     */
    static function getMonthOfReal($real) {
        $months = self::getMonthsReal();
        if(!isset($months[$real])){
            throw new Exception(sprintf('month %s not defined',$real));
        }
        return $months[$real];
    }
    
    static function getMonthOfRealByMonth($monthNumber) {
        $months = self::getMonthsReal();
        $key = array_search($monthNumber, $months);
        if($key === false){
            throw new Exception(sprintf('month number "%s" not defined',$monthNumber));
        }
        return $key;
    }
    
    static function getMonthsReal(){
        static $months = array(
            self::JANUARY_REAL => 1,
            self::FEBRUARY_REAL => 2,
            self::MARCH_REAL => 3,
            self::APRIL_REAL => 4,
            self::MAY_REAL => 5,
            self::JUNE_REAL => 6,
            self::JULY_REAL => 7,
            self::AUGUST_REAL => 8,
            self::SEPTEMBER_REAL => 9,
            self::OCTOBER_REAL => 10,
            self::NOVEMBER_REAL => 11,
            self::DECEMBER_REAL => 12,
        );
        return $months;
    }
    
    /**
     * Devuele el mes planeado en numero
     * @param type $planned
     * @return type
     * @throws Exception
     */
    static function getMonthOfPlanned($planned) {
        $months = self::getMonthsPlanned();
        if(!isset($months[$planned])){
            throw new Exception(sprintf('month planned %s not defined',$planned));
        }
        return $months[$planned];
    }
    
    /**
     * Devuelve el equivalente de los meses planeados
     * @staticvar array $months
     * @return int
     */
    static function getMonthsPlanned(){
        static $months = array(
            self::JANUARY_PLANNED => 1,
            self::FEBRUARY_PLANNED => 2,
            self::MARCH_PLANNED => 3,
            self::APRIL_PLANNED => 4,
            self::MAY_PLANNED => 5,
            self::JUNE_PLANNED => 6,
            self::JULY_PLANNED => 7,
            self::AUGUST_PLANNED => 8,
            self::SEPTEMBER_PLANNED => 9,
            self::OCTOBER_PLANNED => 10,
            self::NOVEMBER_PLANNED => 11,
            self::DECEMBER_PLANNED => 12,
        );
        return $months;
    }
}
