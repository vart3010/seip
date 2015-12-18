<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad\Production;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de detalle de produccion diaria
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ProductDetailDailyMonth extends BaseModel implements ProductDetailDailyMonthInterface
{
    const STATUS_SAVE_PENDING = 1;
    const STATUS_SAVE = 2;
    
    public function getMonthLabel()
    {
        $month = $this->getMonth();
        $monthsLabels = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
        $label = "";
        if(isset($monthsLabels[$month])){
            $label = $monthsLabels[$month];
        }
        return $label;
    }
    
    /**
     * Retorna el total del avance de un dia
     * @param type $day
     * @param type $prefix
     * @return int
     */
    public function getTotalPercentajeOf($day,$prefix) 
    {
        $nameReal = 'getDay'.$day.$prefix.'Real';
        $namePlan = 'getDay'.$day.$prefix.'Plan';
        $plan = $this->$namePlan();
        $real = $this->$nameReal();
        if($plan != 0){
            $total = ($real * 100 / $plan);
        }else{
            $total = 0;
        }
        return $total;
    }
    
    /**
     * Retorna el valor de la produccion bruta de un dia
     * @param type $day
     * @return type
     */
    public function getValueGrossByDay($day)
    {
        //Real de la bruta
        $nameRealGross = 'getDay'.$day.'GrossReal';
        return $this->$nameRealGross();
    }
    
    /**
     * Retorna el plan de la produccion bruta de un dia
     * @param type $day
     * @return type
     */
    public function getPlanGrossByDay($day)
    {
        //Plan de la bruta
        $namePlanGross = 'getDay'.$day.'GrossPlan';
        return $this->$namePlanGross();
    }
    
    /**
     * Retorna el valor de la produccion neta de un dia
     * @param type $day
     * @return type
     */
    public function getValueNetByDay($day)
    {
        //Real de la neta
        $nameRealNet = 'getDay'.$day.'NetReal';
        return $this->$nameRealNet();
    }
    
    /**
     * Retorna el plan de la produccion neta de un dia
     * @param type $day
     * @return type
     */
    public function getPlanNetByDay($day)
    {
        //Plan de la neta
        $namePlanNet = 'getDay'.$day.'NetPlan';
        return $this->$namePlanNet();
    }
    
    /**
     * Retorna el status de notificación de un día
     * @param type $day
     * @return type
     */
    public function getStatusByDay($day)
    {
        //Status de notificación del día
        $nameStatus = 'getDay'.$day.'Status';
        return $this->$nameStatus();
    }
    
    /**
     * Retorna la observación de un día
     * @param type $day
     * @return type
     */
    public function getObservationByDay($day)
    {
        //Observación de notificación del día
        $nameObservation = 'getDay'.$day.'Observation';
        return $this->$nameObservation();
    }
    
    /**
     * Valida que el valor de la produccion neta no sea mayor a la bruta
     * @param type $day
     * @return boolean
     */
    public function isValidNet($day)
    {
        $realGross = $this->getValueGrossByDay($day);
        $realNet = $this->getValueNetByDay($day);
        
        if($realNet > $realGross){
            return false;
        }
        return true;
    }
}
