<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad;

use Pequiven\SEIPBundle\Model\BaseModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles en un solo valor los 31 dias
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\MappedSuperclass()
 */
abstract class DetailValue extends BaseModel 
{
    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",nullable=false)
     */
    protected $month;

    /**
     * Total
     * @var float
     * @ORM\Column(name="total",type="float")
     */
    protected $total = 0;

    /**
     * Dia 1 
     * @var float
     * @ORM\Column(name="day1",type="float")
     */
    protected $day1 = 0;

    /**
     * Dia 2 
     * @var float
     * @ORM\Column(name="day2",type="float")
     */
    protected $day2 = 0;

    /**
     * Dia 3 
     * @var float
     * @ORM\Column(name="day3",type="float")
     */
    protected $day3 = 0;

    /**
     * Dia 4 
     * @var float
     * @ORM\Column(name="day4",type="float")
     */
    protected $day4 = 0;

    /**
     * Dia 5 
     * @var float
     * @ORM\Column(name="day5",type="float")
     */
    protected $day5 = 0;

    /**
     * Dia 6 
     * @var float
     * @ORM\Column(name="day6",type="float")
     */
    protected $day6 = 0;

    /**
     * Dia 7 
     * @var float
     * @ORM\Column(name="day7",type="float")
     */
    protected $day7 = 0;

    /**
     * Dia 8 
     * @var float
     * @ORM\Column(name="day8",type="float")
     */
    protected $day8 = 0;

    /**
     * Dia 9 
     * @var float
     * @ORM\Column(name="day9",type="float")
     */
    protected $day9 = 0;

    /**
     * Dia 10 
     * @var float
     * @ORM\Column(name="day10",type="float")
     */
    protected $day10 = 0;

    /**
     * Dia 11 
     * @var float
     * @ORM\Column(name="day11",type="float")
     */
    protected $day11 = 0;

    /**
     * Dia 12 
     * @var float
     * @ORM\Column(name="day12",type="float")
     */
    protected $day12 = 0;

    /**
     * Dia 13 
     * @var float
     * @ORM\Column(name="day13",type="float")
     */
    protected $day13 = 0;

    /**
     * Dia 14 
     * @var float
     * @ORM\Column(name="day14",type="float")
     */
    protected $day14 = 0;

    /**
     * Dia 15 
     * @var float
     * @ORM\Column(name="day15",type="float")
     */
    protected $day15 = 0;

    /**
     * Dia 16 
     * @var float
     * @ORM\Column(name="day16",type="float")
     */
    protected $day16 = 0;

    /**
     * Dia 17 
     * @var float
     * @ORM\Column(name="day17",type="float")
     */
    protected $day17 = 0;

    /**
     * Dia 18 
     * @var float
     * @ORM\Column(name="day18",type="float")
     */
    protected $day18 = 0;

    /**
     * Dia 19 
     * @var float
     * @ORM\Column(name="day19",type="float")
     */
    protected $day19 = 0;

    /**
     * Dia 20 
     * @var float
     * @ORM\Column(name="day20",type="float")
     */
    protected $day20 = 0;

    /**
     * Dia 21 
     * @var float
     * @ORM\Column(name="day21",type="float")
     */
    protected $day21 = 0;

    /**
     * Dia 22 
     * @var float
     * @ORM\Column(name="day22",type="float")
     */
    protected $day22 = 0;

    /**
     * Dia 23 
     * @var float
     * @ORM\Column(name="day23",type="float")
     */
    protected $day23 = 0;

    /**
     * Dia 24 
     * @var float
     * @ORM\Column(name="day24",type="float")
     */
    protected $day24 = 0;

    /**
     * Dia 25 
     * @var float
     * @ORM\Column(name="day25",type="float")
     */
    protected $day25 = 0;

    /**
     * Dia 26 
     * @var float
     * @ORM\Column(name="day26",type="float")
     */
    protected $day26 = 0;

    /**
     * Dia 27 
     * @var float
     * @ORM\Column(name="day27",type="float")
     */
    protected $day27 = 0;

    /**
     * Dia 28 
     * @var float
     * @ORM\Column(name="day28",type="float")
     */
    protected $day28 = 0;

    /**
     * Dia 29 
     * @var float
     * @ORM\Column(name="day29",type="float")
     */
    protected $day29 = 0;

    /**
     * Dia 30 
     * @var float
     * @ORM\Column(name="day30",type="float")
     */
    protected $day30 = 0;

    /**
     * Dia 31 
     * @var float
     * @ORM\Column(name="day31",type="float")
     */
    protected $day31 = 0;

    /**
     * Set month
     *
     * @param integer $month
     * @return Inventory
     */
    public function setMonth($month) {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Inventory
     */
    public function setTotal($total) {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set day1
     *
     * @param float $day1
     * @return Inventory
     */
    public function setDay1($day1) {
        $this->day1 = $day1;

        return $this;
    }

    /**
     * Get day1
     *
     * @return float 
     */
    public function getDay1() {
        return $this->day1;
    }

    /**
     * Set day2
     *
     * @param float $day2
     * @return Inventory
     */
    public function setDay2($day2) {
        $this->day2 = $day2;

        return $this;
    }

    /**
     * Get day2
     *
     * @return float 
     */
    public function getDay2() {
        return $this->day2;
    }

    /**
     * Set day3
     *
     * @param float $day3
     * @return Inventory
     */
    public function setDay3($day3) {
        $this->day3 = $day3;

        return $this;
    }

    /**
     * Get day3
     *
     * @return float 
     */
    public function getDay3() {
        return $this->day3;
    }

    /**
     * Set day4
     *
     * @param float $day4
     * @return Inventory
     */
    public function setDay4($day4) {
        $this->day4 = $day4;

        return $this;
    }

    /**
     * Get day4
     *
     * @return float 
     */
    public function getDay4() {
        return $this->day4;
    }

    /**
     * Set day5
     *
     * @param float $day5
     * @return Inventory
     */
    public function setDay5($day5) {
        $this->day5 = $day5;

        return $this;
    }

    /**
     * Get day5
     *
     * @return float 
     */
    public function getDay5() {
        return $this->day5;
    }

    /**
     * Set day6
     *
     * @param float $day6
     * @return Inventory
     */
    public function setDay6($day6) {
        $this->day6 = $day6;

        return $this;
    }

    /**
     * Get day6
     *
     * @return float 
     */
    public function getDay6() {
        return $this->day6;
    }

    /**
     * Set day7
     *
     * @param float $day7
     * @return Inventory
     */
    public function setDay7($day7) {
        $this->day7 = $day7;

        return $this;
    }

    /**
     * Get day7
     *
     * @return float 
     */
    public function getDay7() {
        return $this->day7;
    }

    /**
     * Set day8
     *
     * @param float $day8
     * @return Inventory
     */
    public function setDay8($day8) {
        $this->day8 = $day8;

        return $this;
    }

    /**
     * Get day8
     *
     * @return float 
     */
    public function getDay8() {
        return $this->day8;
    }

    /**
     * Set day9
     *
     * @param float $day9
     * @return Inventory
     */
    public function setDay9($day9) {
        $this->day9 = $day9;

        return $this;
    }

    /**
     * Get day9
     *
     * @return float 
     */
    public function getDay9() {
        return $this->day9;
    }

    /**
     * Set day10
     *
     * @param float $day10
     * @return Inventory
     */
    public function setDay10($day10) {
        $this->day10 = $day10;

        return $this;
    }

    /**
     * Get day10
     *
     * @return float 
     */
    public function getDay10() {
        return $this->day10;
    }

    /**
     * Set day11
     *
     * @param float $day11
     * @return Inventory
     */
    public function setDay11($day11) {
        $this->day11 = $day11;

        return $this;
    }

    /**
     * Get day11
     *
     * @return float 
     */
    public function getDay11() {
        return $this->day11;
    }

    /**
     * Set day12
     *
     * @param float $day12
     * @return Inventory
     */
    public function setDay12($day12) {
        $this->day12 = $day12;

        return $this;
    }

    /**
     * Get day12
     *
     * @return float 
     */
    public function getDay12() {
        return $this->day12;
    }

    /**
     * Set day13
     *
     * @param float $day13
     * @return Inventory
     */
    public function setDay13($day13) {
        $this->day13 = $day13;

        return $this;
    }

    /**
     * Get day13
     *
     * @return float 
     */
    public function getDay13() {
        return $this->day13;
    }

    /**
     * Set day14
     *
     * @param float $day14
     * @return Inventory
     */
    public function setDay14($day14) {
        $this->day14 = $day14;

        return $this;
    }

    /**
     * Get day14
     *
     * @return float 
     */
    public function getDay14() {
        return $this->day14;
    }

    /**
     * Set day15
     *
     * @param float $day15
     * @return Inventory
     */
    public function setDay15($day15) {
        $this->day15 = $day15;

        return $this;
    }

    /**
     * Get day15
     *
     * @return float 
     */
    public function getDay15() {
        return $this->day15;
    }

    /**
     * Set day16
     *
     * @param float $day16
     * @return Inventory
     */
    public function setDay16($day16) {
        $this->day16 = $day16;

        return $this;
    }

    /**
     * Get day16
     *
     * @return float 
     */
    public function getDay16() {
        return $this->day16;
    }

    /**
     * Set day17
     *
     * @param float $day17
     * @return Inventory
     */
    public function setDay17($day17) {
        $this->day17 = $day17;

        return $this;
    }

    /**
     * Get day17
     *
     * @return float 
     */
    public function getDay17() {
        return $this->day17;
    }

    /**
     * Set day18
     *
     * @param float $day18
     * @return Inventory
     */
    public function setDay18($day18) {
        $this->day18 = $day18;

        return $this;
    }

    /**
     * Get day18
     *
     * @return float 
     */
    public function getDay18() {
        return $this->day18;
    }

    /**
     * Set day19
     *
     * @param float $day19
     * @return Inventory
     */
    public function setDay19($day19) {
        $this->day19 = $day19;

        return $this;
    }

    /**
     * Get day19
     *
     * @return float 
     */
    public function getDay19() {
        return $this->day19;
    }

    /**
     * Set day20
     *
     * @param float $day20
     * @return Inventory
     */
    public function setDay20($day20) {
        $this->day20 = $day20;

        return $this;
    }

    /**
     * Get day20
     *
     * @return float 
     */
    public function getDay20() {
        return $this->day20;
    }

    /**
     * Set day21
     *
     * @param float $day21
     * @return Inventory
     */
    public function setDay21($day21) {
        $this->day21 = $day21;

        return $this;
    }

    /**
     * Get day21
     *
     * @return float 
     */
    public function getDay21() {
        return $this->day21;
    }

    /**
     * Set day22
     *
     * @param float $day22
     * @return Inventory
     */
    public function setDay22($day22) {
        $this->day22 = $day22;

        return $this;
    }

    /**
     * Get day22
     *
     * @return float 
     */
    public function getDay22() {
        return $this->day22;
    }

    /**
     * Set day23
     *
     * @param float $day23
     * @return Inventory
     */
    public function setDay23($day23) {
        $this->day23 = $day23;

        return $this;
    }

    /**
     * Get day23
     *
     * @return float 
     */
    public function getDay23() {
        return $this->day23;
    }

    /**
     * Set day24
     *
     * @param float $day24
     * @return Inventory
     */
    public function setDay24($day24) {
        $this->day24 = $day24;

        return $this;
    }

    /**
     * Get day24
     *
     * @return float 
     */
    public function getDay24() {
        return $this->day24;
    }

    /**
     * Set day25
     *
     * @param float $day25
     * @return Inventory
     */
    public function setDay25($day25) {
        $this->day25 = $day25;

        return $this;
    }

    /**
     * Get day25
     *
     * @return float 
     */
    public function getDay25() {
        return $this->day25;
    }

    /**
     * Set day26
     *
     * @param float $day26
     * @return Inventory
     */
    public function setDay26($day26) {
        $this->day26 = $day26;

        return $this;
    }

    /**
     * Get day26
     *
     * @return float 
     */
    public function getDay26() {
        return $this->day26;
    }

    /**
     * Set day27
     *
     * @param float $day27
     * @return Inventory
     */
    public function setDay27($day27) {
        $this->day27 = $day27;

        return $this;
    }

    /**
     * Get day27
     *
     * @return float 
     */
    public function getDay27() {
        return $this->day27;
    }

    /**
     * Set day28
     *
     * @param float $day28
     * @return Inventory
     */
    public function setDay28($day28) {
        $this->day28 = $day28;

        return $this;
    }

    /**
     * Get day28
     *
     * @return float 
     */
    public function getDay28() {
        return $this->day28;
    }

    /**
     * Set day29
     *
     * @param float $day29
     * @return Inventory
     */
    public function setDay29($day29) {
        $this->day29 = $day29;

        return $this;
    }

    /**
     * Get day29
     *
     * @return float 
     */
    public function getDay29() {
        return $this->day29;
    }

    /**
     * Set day30
     *
     * @param float $day30
     * @return Inventory
     */
    public function setDay30($day30) {
        $this->day30 = $day30;

        return $this;
    }

    /**
     * Get day30
     *
     * @return float 
     */
    public function getDay30() {
        return $this->day30;
    }

    /**
     * Set day31
     *
     * @param float $day31
     * @return Inventory
     */
    public function setDay31($day31) {
        $this->day31 = $day31;

        return $this;
    }

    /**
     * Get day31
     *
     * @return float 
     */
    public function getDay31() {
        return $this->day31;
    }

    function getProductReport() {
        return $this->productReport;
    }

    function setProductReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport) {
        $this->productReport = $productReport;
        return $this;
    }

    public function __toString() {
        $_toString = "-";
        if ($this->getId() > 0) {
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
    }

    public function getMonthLabel() {
        $month = $this->getMonth();
        $monthsLabels = \Pequiven\SEIPBundle\Service\ToolService::getMonthsLabels();
        $label = "";
        if (isset($monthsLabels[$month])) {
            $label = $monthsLabels[$month];
        }
        return $label;
    }

    public function calculate() {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();

        $nameMatch = '^getDay\d+$';

        $total = $totalPlan = 0.0;
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $class = $method->getDeclaringClass();
            if (!strpos($class, 'Pequiven\SEIPBundle\Model\DataLoad\DetailValue')) {
                continue;
            }
            if (preg_match('/' . $nameMatch . '/i', $methodName)) {
                $value = $this->$methodName();
                $total += $value;
            }
        }

        $methodTotalPlan = "setTotal";

        $this->$methodTotalPlan($total);
    }

    /**
     * Funcion que retorna cantidad de paradas por dia del mes 
     * @return array 
     * 
     */
    public function getListMonth() {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        $nameMatch = '/^getDay\d+$/';

        $rs = array();
        $cont = 0;
        
        $days = $this->getDaysPerMonth($this->getMonth());
        
        foreach ($methods as $m) {
            
            $methodName = $m->getName();
            
            if (preg_match($nameMatch, $methodName)) {
                array_push($rs, $this->$methodName());
                $cont++;
                if($cont == $days) {
                    break;
                }
            }
        }
        
        
        return $rs;
    }
    
    public function getTotalToDay($day) 
    {
        $real = 0.0;
        for($i=1; $i <= $day; $i++){
            $nameReal = 'getDay'.$i;
            $real = $real + $this->$nameReal();
        }
        return $real;
    }
    
    /**
     * Obtiene el ultimo del dia del mes
     * @return type
     */
    public function getLastDay() 
    {
        $year = $this->getCreatedAt()->format('Y');
        $i = $this->getDaysPerMonth($this->getMonth(), $year);
        $nameReal = 'getDay'.$i;
        $real = $this->$nameReal();
        return $real;
    }
    
    /**
     * Retorna el valor de ayer
     * @return type
     */
    public function getYesterDay() 
    {
        $now = new \DateTime();
        $day = (int)$now->format("d");
        if($day > 1){
            $day--;
        }
        $nameReal = 'getDay'.$day;
        $real = $this->$nameReal();
        return $real;
    }
    
    /**
     * Retorna el valor de ayer EN BASE A UNA FECHA
     * @return type
     */
    public function getYesterDayDate($date) 
    {
        //$now = new \DateTime();
        $day = (int)$date->format("d");
        if($day > 1){
            $day--;
        }
        $nameReal = 'getDay'.$day;
        $real = $this->$nameReal();
        return $real;
    }
    
    /**
     * Retorna el dia actual o total
     * @staticvar type $day
     * @staticvar type $currentMonth
     * @return type
     */
    public function getTotalInventory() 
    {
        static $day = null;
        static $currentMonth = null;
        $month = $this->getMonth();
        if($day === null){
            $now = new \DateTime();
            $day = (int)$now->format("d");
            $currentMonth = (int)$now->format("m");
        }
        
        $total = 0.0;
        if($month == $currentMonth){
            $total = $this->getYesterDay();
        }else{
            $total = $this->getLastDay();
        }
        return $total;
    }
    
    /**
     * Retorna la cantidad de dias de un mes basado en un calendario (CAL_GREGORIAN) 
     * @param type $mes
     * @param type $ano
     * @return type
     */
    public function getDaysPerMonth($mes = "", $ano = "") 
    {
        if ($ano == "") {
            $ano = date("Y");
        }
        return cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    }
}