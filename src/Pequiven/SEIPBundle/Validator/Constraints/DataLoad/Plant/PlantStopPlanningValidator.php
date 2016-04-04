<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints\DataLoad\Plant;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validador de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantStopPlanningValidator extends ConstraintValidator
{
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint) 
    {
        $totalStops = $value->getTotalStops();
        
        if($totalStops > 0)
        {
            $dayStops = array();
                $ranges = $value->getRanges();
                if($ranges->count()){
                    foreach ($value->getRanges() as $range) {

                        $totalHours = 0;
                        if($range->getOtherTime() === true){
                            $totalHours = $range->getHours();
                        }else{
                            if($range->getStopTime()){
                                $totalHours = $range->getStopTime()->getHours();
                            }
                        }
                        $dateFrom = $range->getDateFrom();
                        $dateEnd = $range->getDateEnd();

                        $startDay = $dateFrom->format("d");
                        $endDay = $dateEnd->format("d");
                        
                        for($i = $startDay; $i <= $endDay; $i++){
                            $dayStop = new \Pequiven\SEIPBundle\Entity\DataLoad\Plant\DayStop();
                            $day = clone($dateFrom);
                            $day->setDate($day->format('Y'), $day->format('m'), $i);
                            $dayStop->setDay($day);
                            $dayStop->setOtherTime($range->getOtherTime());
                            $dayStop->setStopTime($range->getStopTime());
                            $dayStop->setHours($totalHours);
                            $dayStops[] = $dayStop;
                        }
                    }
                    $dayStopsByDay = $value->getDayStopsByDay();
//                    foreach ($dayStops as $dayStop) {
//                        if(!isset($dayStopsByDay[$dayStop->getNroDay()])){
//                            var_dump($dayStop->getNroDay());
//                            $value->addDayStop($dayStop);
//                        }
//                    }
                }
            $totalDaysStops = $value->getDayStops()->count();
            if($totalDaysStops > $totalStops){
                $this->context->addViolation("pequiven.validators.plant_stop_planning.total_number_stops_not_greater_than_indicated",array(
                    '%totalDaysStops%' => $totalDaysStops,
                    '%totalStops%' => $totalStops
                ));
            }
            //$this->context->addViolation("pequiven.validators.plant_stop_planning.total_number_stops_not_greater_than_indicated");
        }
    }
}
