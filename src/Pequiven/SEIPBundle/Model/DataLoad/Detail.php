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

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Detalles de plan y real
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\MappedSuperclass
 */
abstract class Detail extends BaseModel
{
    /**
     * Presupuesto de consumo del mes
     * @var float
     * @ORM\Column(name="month_budget",type="float")
     */
    protected $monthBudget = 0;
    
    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",nullable=false)
     */
    protected $month;
    
    /**
     * Total plan (Bruta)
     * @var float
     * @ORM\Column(name="totalPlan",type="float")
     */
    protected $totalPlan = 0;
    
    /**
     * Total real (Bruta)
     * @var float
     * @ORM\Column(name="totalReal",type="float")
     */
    protected $totalReal = 0;
    
    /**
     * Porcentaje de cumplimiento (Bruta)
     * @var float
     * @ORM\Column(name="percentage",type="float")
     */
    protected $percentage = 0;
    
    /**
     * Dia 1 (Plan)
     * @var float
     * @ORM\Column(name="day1Plan",type="float")
     */
    protected $day1Plan = 0;
    
    /**
     * Dia 1 (Real)
     * @var float
     * @ORM\Column(name="day1Real",type="float")
     */
    protected $day1Real = 0;
    
    /**
     * Dia 2 (Plan)
     * @var float
     * @ORM\Column(name="day2Plan",type="float")
     */
    protected $day2Plan = 0;
    
    /**
     * Dia 2 (Real)
     * @var float
     * @ORM\Column(name="day2Real",type="float")
     */
    protected $day2Real = 0;
    
    /**
     * Dia 3 (Plan)
     * @var float
     * @ORM\Column(name="day3Plan",type="float")
     */
    protected $day3Plan = 0;
    
    /**
     * Dia 3 (Real)
     * @var float
     * @ORM\Column(name="day3Real",type="float")
     */
    protected $day3Real = 0;
    
    /**
     * Dia 4 (Plan)
     * @var float
     * @ORM\Column(name="day4Plan",type="float")
     */
    protected $day4Plan = 0;
    
    /**
     * Dia 4 (Real)
     * @var float
     * @ORM\Column(name="day4Real",type="float")
     */
    protected $day4Real = 0;
    
    /**
     * Dia 5 (Plan)
     * @var float
     * @ORM\Column(name="day5Plan",type="float")
     */
    protected $day5Plan = 0;
    
    /**
     * Dia 5 (Real)
     * @var float
     * @ORM\Column(name="day5Real",type="float")
     */
    protected $day5Real = 0;
    
    /**
     * Dia 6 (Plan)
     * @var float
     * @ORM\Column(name="day6Plan",type="float")
     */
    protected $day6Plan = 0;
    
    /**
     * Dia 6 (Real)
     * @var float
     * @ORM\Column(name="day6Real",type="float")
     */
    protected $day6Real = 0;
    
    /**
     * Dia 7 (Plan)
     * @var float
     * @ORM\Column(name="day7Plan",type="float")
     */
    protected $day7Plan = 0;
    
    /**
     * Dia 7 (Real)
     * @var float
     * @ORM\Column(name="day7Real",type="float")
     */
    protected $day7Real = 0;
    
    /**
     * Dia 8 (Plan)
     * @var float
     * @ORM\Column(name="day8Plan",type="float")
     */
    protected $day8Plan = 0;
    
    /**
     * Dia 8 (Real)
     * @var float
     * @ORM\Column(name="day8Real",type="float")
     */
    protected $day8Real = 0;
    
    /**
     * Dia 9 (Plan)
     * @var float
     * @ORM\Column(name="day9Plan",type="float")
     */
    protected $day9Plan = 0;
    
    /**
     * Dia 9 (Real)
     * @var float
     * @ORM\Column(name="day9Real",type="float")
     */
    protected $day9Real = 0;
    
    /**
     * Dia 10 (Plan)
     * @var float
     * @ORM\Column(name="day10Plan",type="float")
     */
    protected $day10Plan = 0;
    
    /**
     * Dia 10 (Real)
     * @var float
     * @ORM\Column(name="day10Real",type="float")
     */
    protected $day10Real = 0;
    
    /**
     * Dia 11 (Plan)
     * @var float
     * @ORM\Column(name="day11Plan",type="float")
     */
    protected $day11Plan = 0;
    
    /**
     * Dia 11 (Real)
     * @var float
     * @ORM\Column(name="day11Real",type="float")
     */
    protected $day11Real = 0;
    
    /**
     * Dia 12 (Plan)
     * @var float
     * @ORM\Column(name="day12Plan",type="float")
     */
    protected $day12Plan = 0;
    
    /**
     * Dia 12 (Real)
     * @var float
     * @ORM\Column(name="day12Real",type="float")
     */
    protected $day12Real = 0;
    
    /**
     * Dia 13 (Plan)
     * @var float
     * @ORM\Column(name="day13Plan",type="float")
     */
    protected $day13Plan = 0;
    
    /**
     * Dia 13 (Real)
     * @var float
     * @ORM\Column(name="day13Real",type="float")
     */
    protected $day13Real = 0;
    
    /**
     * Dia 14 (Plan)
     * @var float
     * @ORM\Column(name="day14Plan",type="float")
     */
    protected $day14Plan = 0;
    
    /**
     * Dia 14 (Real)
     * @var float
     * @ORM\Column(name="day14Real",type="float")
     */
    protected $day14Real = 0;
    
    /**
     * Dia 15 (Plan)
     * @var float
     * @ORM\Column(name="day15Plan",type="float")
     */
    protected $day15Plan = 0;
    
    /**
     * Dia 15 (Real)
     * @var float
     * @ORM\Column(name="day15Real",type="float")
     */
    protected $day15Real = 0;
    
    /**
     * Dia 16 (Plan)
     * @var float
     * @ORM\Column(name="day16Plan",type="float")
     */
    protected $day16Plan = 0;
    
    /**
     * Dia 16 (Real)
     * @var float
     * @ORM\Column(name="day16Real",type="float")
     */
    protected $day16Real = 0;
    
    /**
     * Dia 17 (Plan)
     * @var float
     * @ORM\Column(name="day17Plan",type="float")
     */
    protected $day17Plan = 0;
    
    /**
     * Dia 17 (Real)
     * @var float
     * @ORM\Column(name="day17Real",type="float")
     */
    protected $day17Real = 0;
    
    /**
     * Dia 18 (Plan)
     * @var float
     * @ORM\Column(name="day18Plan",type="float")
     */
    protected $day18Plan = 0;
    
    /**
     * Dia 18 (Real)
     * @var float
     * @ORM\Column(name="day18Real",type="float")
     */
    protected $day18Real = 0;
    
    /**
     * Dia 19 (Plan)
     * @var float
     * @ORM\Column(name="day19Plan",type="float")
     */
    protected $day19Plan = 0;
    
    /**
     * Dia 19 (Real)
     * @var float
     * @ORM\Column(name="day19Real",type="float")
     */
    protected $day19Real = 0;
    
    /**
     * Dia 20 (Plan)
     * @var float
     * @ORM\Column(name="day20Plan",type="float")
     */
    protected $day20Plan = 0;
    
    /**
     * Dia 20 (Real)
     * @var float
     * @ORM\Column(name="day20Real",type="float")
     */
    protected $day20Real = 0;
    
    /**
     * Dia 21 (Plan)
     * @var float
     * @ORM\Column(name="day21Plan",type="float")
     */
    protected $day21Plan = 0;
    
    /**
     * Dia 21 (Real)
     * @var float
     * @ORM\Column(name="day21Real",type="float")
     */
    protected $day21Real = 0;
    
    /**
     * Dia 22 (Plan)
     * @var float
     * @ORM\Column(name="day22Plan",type="float")
     */
    protected $day22Plan = 0;
    
    /**
     * Dia 22 (Real)
     * @var float
     * @ORM\Column(name="day22Real",type="float")
     */
    protected $day22Real = 0;
    
    /**
     * Dia 23 (Plan)
     * @var float
     * @ORM\Column(name="day23Plan",type="float")
     */
    protected $day23Plan = 0;
    
    /**
     * Dia 23 (Real)
     * @var float
     * @ORM\Column(name="day23Real",type="float")
     */
    protected $day23Real = 0;
    
    /**
     * Dia 24 (Plan)
     * @var float
     * @ORM\Column(name="day24Plan",type="float")
     */
    protected $day24Plan = 0;
    
    /**
     * Dia 24 (Real)
     * @var float
     * @ORM\Column(name="day24Real",type="float")
     */
    protected $day24Real = 0;
    
    /**
     * Dia 25 (Plan)
     * @var float
     * @ORM\Column(name="day25Plan",type="float")
     */
    protected $day25Plan = 0;
    
    /**
     * Dia 25 (Real)
     * @var float
     * @ORM\Column(name="day25Real",type="float")
     */
    protected $day25Real = 0;
    
    /**
     * Dia 26 (Plan)
     * @var float
     * @ORM\Column(name="day26Plan",type="float")
     */
    protected $day26Plan = 0;
    
    /**
     * Dia 26 (Real)
     * @var float
     * @ORM\Column(name="day26Real",type="float")
     */
    protected $day26Real = 0;
    
    /**
     * Dia 27 (Plan)
     * @var float
     * @ORM\Column(name="day27Plan",type="float")
     */
    protected $day27Plan = 0;
    
    /**
     * Dia 27 (Real)
     * @var float
     * @ORM\Column(name="day27Real",type="float")
     */
    protected $day27Real = 0;
    
    /**
     * Dia 28 (Plan)
     * @var float
     * @ORM\Column(name="day28Plan",type="float")
     */
    protected $day28Plan = 0;
    
    /**
     * Dia 28 (Real)
     * @var float
     * @ORM\Column(name="day28Real",type="float")
     */
    protected $day28Real = 0;
    
    /**
     * Dia 29 (Plan)
     * @var float
     * @ORM\Column(name="day29Plan",type="float")
     */
    protected $day29Plan = 0;
    
    /**
     * Dia 29 (Real)
     * @var float
     * @ORM\Column(name="day29Real",type="float")
     */
    protected $day29Real = 0;
    
    /**
     * Dia 30 (Plan)
     * @var float
     * @ORM\Column(name="day30Plan",type="float")
     */
    protected $day30Plan = 0;
    
    /**
     * Dia 30 (Real)
     * @var float
     * @ORM\Column(name="day30Real",type="float")
     */
    protected $day30Real = 0;
    
    /**
     * Dia 31 (Plan)
     * @var float
     * @ORM\Column(name="day31Plan",type="float")
     */
    protected $day31Plan = 0;
    
    /**
     * Dia 31 (Real)
     * @var float
     * @ORM\Column(name="day31Real",type="float")
     */
    protected $day31Real = 0;
    
    /**
     * Set type
     *
     * @param integer $type
     * @return RawMaterial
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set month
     *
     * @param integer $month
     * @return RawMaterial
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set totalPlan
     *
     * @param float $totalPlan
     * @return RawMaterial
     */
    public function setTotalPlan($totalPlan)
    {
        $this->totalPlan = $totalPlan;

        return $this;
    }

    /**
     * Get totalPlan
     *
     * @return float 
     */
    public function getTotalPlan()
    {
        return $this->totalPlan;
    }

    /**
     * Set totalReal
     *
     * @param float $totalReal
     * @return RawMaterial
     */
    public function setTotalReal($totalReal)
    {
        $this->totalReal = $totalReal;

        return $this;
    }

    /**
     * Get totalReal
     *
     * @return float 
     */
    public function getTotalReal()
    {
        return $this->totalReal;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     * @return RawMaterial
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float 
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set day1Plan
     *
     * @param float $day1Plan
     * @return RawMaterial
     */
    public function setDay1Plan($day1Plan)
    {
        $this->day1Plan = $day1Plan;

        return $this;
    }

    /**
     * Get day1Plan
     *
     * @return float 
     */
    public function getDay1Plan()
    {
        return $this->day1Plan;
    }

    /**
     * Set day1Real
     *
     * @param float $day1Real
     * @return RawMaterial
     */
    public function setDay1Real($day1Real)
    {
        $this->day1Real = $day1Real;

        return $this;
    }

    /**
     * Get day1Real
     *
     * @return float 
     */
    public function getDay1Real()
    {
        return $this->day1Real;
    }

    /**
     * Set day2Plan
     *
     * @param float $day2Plan
     * @return RawMaterial
     */
    public function setDay2Plan($day2Plan)
    {
        $this->day2Plan = $day2Plan;

        return $this;
    }

    /**
     * Get day2Plan
     *
     * @return float 
     */
    public function getDay2Plan()
    {
        return $this->day2Plan;
    }

    /**
     * Set day2Real
     *
     * @param float $day2Real
     * @return RawMaterial
     */
    public function setDay2Real($day2Real)
    {
        $this->day2Real = $day2Real;

        return $this;
    }

    /**
     * Get day2Real
     *
     * @return float 
     */
    public function getDay2Real()
    {
        return $this->day2Real;
    }

    /**
     * Set day3Plan
     *
     * @param float $day3Plan
     * @return RawMaterial
     */
    public function setDay3Plan($day3Plan)
    {
        $this->day3Plan = $day3Plan;

        return $this;
    }

    /**
     * Get day3Plan
     *
     * @return float 
     */
    public function getDay3Plan()
    {
        return $this->day3Plan;
    }

    /**
     * Set day3Real
     *
     * @param float $day3Real
     * @return RawMaterial
     */
    public function setDay3Real($day3Real)
    {
        $this->day3Real = $day3Real;

        return $this;
    }

    /**
     * Get day3Real
     *
     * @return float 
     */
    public function getDay3Real()
    {
        return $this->day3Real;
    }

    /**
     * Set day4Plan
     *
     * @param float $day4Plan
     * @return RawMaterial
     */
    public function setDay4Plan($day4Plan)
    {
        $this->day4Plan = $day4Plan;

        return $this;
    }

    /**
     * Get day4Plan
     *
     * @return float 
     */
    public function getDay4Plan()
    {
        return $this->day4Plan;
    }

    /**
     * Set day4Real
     *
     * @param float $day4Real
     * @return RawMaterial
     */
    public function setDay4Real($day4Real)
    {
        $this->day4Real = $day4Real;

        return $this;
    }

    /**
     * Get day4Real
     *
     * @return float 
     */
    public function getDay4Real()
    {
        return $this->day4Real;
    }

    /**
     * Set day5Plan
     *
     * @param float $day5Plan
     * @return RawMaterial
     */
    public function setDay5Plan($day5Plan)
    {
        $this->day5Plan = $day5Plan;

        return $this;
    }

    /**
     * Get day5Plan
     *
     * @return float 
     */
    public function getDay5Plan()
    {
        return $this->day5Plan;
    }

    /**
     * Set day5Real
     *
     * @param float $day5Real
     * @return RawMaterial
     */
    public function setDay5Real($day5Real)
    {
        $this->day5Real = $day5Real;

        return $this;
    }

    /**
     * Get day5Real
     *
     * @return float 
     */
    public function getDay5Real()
    {
        return $this->day5Real;
    }

    /**
     * Set day6Plan
     *
     * @param float $day6Plan
     * @return RawMaterial
     */
    public function setDay6Plan($day6Plan)
    {
        $this->day6Plan = $day6Plan;

        return $this;
    }

    /**
     * Get day6Plan
     *
     * @return float 
     */
    public function getDay6Plan()
    {
        return $this->day6Plan;
    }

    /**
     * Set day6Real
     *
     * @param float $day6Real
     * @return RawMaterial
     */
    public function setDay6Real($day6Real)
    {
        $this->day6Real = $day6Real;

        return $this;
    }

    /**
     * Get day6Real
     *
     * @return float 
     */
    public function getDay6Real()
    {
        return $this->day6Real;
    }

    /**
     * Set day7Plan
     *
     * @param float $day7Plan
     * @return RawMaterial
     */
    public function setDay7Plan($day7Plan)
    {
        $this->day7Plan = $day7Plan;

        return $this;
    }

    /**
     * Get day7Plan
     *
     * @return float 
     */
    public function getDay7Plan()
    {
        return $this->day7Plan;
    }

    /**
     * Set day7Real
     *
     * @param float $day7Real
     * @return RawMaterial
     */
    public function setDay7Real($day7Real)
    {
        $this->day7Real = $day7Real;

        return $this;
    }

    /**
     * Get day7Real
     *
     * @return float 
     */
    public function getDay7Real()
    {
        return $this->day7Real;
    }

    /**
     * Set day8Plan
     *
     * @param float $day8Plan
     * @return RawMaterial
     */
    public function setDay8Plan($day8Plan)
    {
        $this->day8Plan = $day8Plan;

        return $this;
    }

    /**
     * Get day8Plan
     *
     * @return float 
     */
    public function getDay8Plan()
    {
        return $this->day8Plan;
    }

    /**
     * Set day8Real
     *
     * @param float $day8Real
     * @return RawMaterial
     */
    public function setDay8Real($day8Real)
    {
        $this->day8Real = $day8Real;

        return $this;
    }

    /**
     * Get day8Real
     *
     * @return float 
     */
    public function getDay8Real()
    {
        return $this->day8Real;
    }

    /**
     * Set day9Plan
     *
     * @param float $day9Plan
     * @return RawMaterial
     */
    public function setDay9Plan($day9Plan)
    {
        $this->day9Plan = $day9Plan;

        return $this;
    }

    /**
     * Get day9Plan
     *
     * @return float 
     */
    public function getDay9Plan()
    {
        return $this->day9Plan;
    }

    /**
     * Set day9Real
     *
     * @param float $day9Real
     * @return RawMaterial
     */
    public function setDay9Real($day9Real)
    {
        $this->day9Real = $day9Real;

        return $this;
    }

    /**
     * Get day9Real
     *
     * @return float 
     */
    public function getDay9Real()
    {
        return $this->day9Real;
    }

    /**
     * Set day10Plan
     *
     * @param float $day10Plan
     * @return RawMaterial
     */
    public function setDay10Plan($day10Plan)
    {
        $this->day10Plan = $day10Plan;

        return $this;
    }

    /**
     * Get day10Plan
     *
     * @return float 
     */
    public function getDay10Plan()
    {
        return $this->day10Plan;
    }

    /**
     * Set day10Real
     *
     * @param float $day10Real
     * @return RawMaterial
     */
    public function setDay10Real($day10Real)
    {
        $this->day10Real = $day10Real;

        return $this;
    }

    /**
     * Get day10Real
     *
     * @return float 
     */
    public function getDay10Real()
    {
        return $this->day10Real;
    }

    /**
     * Set day11Plan
     *
     * @param float $day11Plan
     * @return RawMaterial
     */
    public function setDay11Plan($day11Plan)
    {
        $this->day11Plan = $day11Plan;

        return $this;
    }

    /**
     * Get day11Plan
     *
     * @return float 
     */
    public function getDay11Plan()
    {
        return $this->day11Plan;
    }

    /**
     * Set day11Real
     *
     * @param float $day11Real
     * @return RawMaterial
     */
    public function setDay11Real($day11Real)
    {
        $this->day11Real = $day11Real;

        return $this;
    }

    /**
     * Get day11Real
     *
     * @return float 
     */
    public function getDay11Real()
    {
        return $this->day11Real;
    }

    /**
     * Set day12Plan
     *
     * @param float $day12Plan
     * @return RawMaterial
     */
    public function setDay12Plan($day12Plan)
    {
        $this->day12Plan = $day12Plan;

        return $this;
    }

    /**
     * Get day12Plan
     *
     * @return float 
     */
    public function getDay12Plan()
    {
        return $this->day12Plan;
    }

    /**
     * Set day12Real
     *
     * @param float $day12Real
     * @return RawMaterial
     */
    public function setDay12Real($day12Real)
    {
        $this->day12Real = $day12Real;

        return $this;
    }

    /**
     * Get day12Real
     *
     * @return float 
     */
    public function getDay12Real()
    {
        return $this->day12Real;
    }

    /**
     * Set day13Plan
     *
     * @param float $day13Plan
     * @return RawMaterial
     */
    public function setDay13Plan($day13Plan)
    {
        $this->day13Plan = $day13Plan;

        return $this;
    }

    /**
     * Get day13Plan
     *
     * @return float 
     */
    public function getDay13Plan()
    {
        return $this->day13Plan;
    }

    /**
     * Set day13Real
     *
     * @param float $day13Real
     * @return RawMaterial
     */
    public function setDay13Real($day13Real)
    {
        $this->day13Real = $day13Real;

        return $this;
    }

    /**
     * Get day13Real
     *
     * @return float 
     */
    public function getDay13Real()
    {
        return $this->day13Real;
    }

    /**
     * Set day14Plan
     *
     * @param float $day14Plan
     * @return RawMaterial
     */
    public function setDay14Plan($day14Plan)
    {
        $this->day14Plan = $day14Plan;

        return $this;
    }

    /**
     * Get day14Plan
     *
     * @return float 
     */
    public function getDay14Plan()
    {
        return $this->day14Plan;
    }

    /**
     * Set day14Real
     *
     * @param float $day14Real
     * @return RawMaterial
     */
    public function setDay14Real($day14Real)
    {
        $this->day14Real = $day14Real;

        return $this;
    }

    /**
     * Get day14Real
     *
     * @return float 
     */
    public function getDay14Real()
    {
        return $this->day14Real;
    }

    /**
     * Set day15Plan
     *
     * @param float $day15Plan
     * @return RawMaterial
     */
    public function setDay15Plan($day15Plan)
    {
        $this->day15Plan = $day15Plan;

        return $this;
    }

    /**
     * Get day15Plan
     *
     * @return float 
     */
    public function getDay15Plan()
    {
        return $this->day15Plan;
    }

    /**
     * Set day15Real
     *
     * @param float $day15Real
     * @return RawMaterial
     */
    public function setDay15Real($day15Real)
    {
        $this->day15Real = $day15Real;

        return $this;
    }

    /**
     * Get day15Real
     *
     * @return float 
     */
    public function getDay15Real()
    {
        return $this->day15Real;
    }

    /**
     * Set day16Plan
     *
     * @param float $day16Plan
     * @return RawMaterial
     */
    public function setDay16Plan($day16Plan)
    {
        $this->day16Plan = $day16Plan;

        return $this;
    }

    /**
     * Get day16Plan
     *
     * @return float 
     */
    public function getDay16Plan()
    {
        return $this->day16Plan;
    }

    /**
     * Set day16Real
     *
     * @param float $day16Real
     * @return RawMaterial
     */
    public function setDay16Real($day16Real)
    {
        $this->day16Real = $day16Real;

        return $this;
    }

    /**
     * Get day16Real
     *
     * @return float 
     */
    public function getDay16Real()
    {
        return $this->day16Real;
    }

    /**
     * Set day17Plan
     *
     * @param float $day17Plan
     * @return RawMaterial
     */
    public function setDay17Plan($day17Plan)
    {
        $this->day17Plan = $day17Plan;

        return $this;
    }

    /**
     * Get day17Plan
     *
     * @return float 
     */
    public function getDay17Plan()
    {
        return $this->day17Plan;
    }

    /**
     * Set day17Real
     *
     * @param float $day17Real
     * @return RawMaterial
     */
    public function setDay17Real($day17Real)
    {
        $this->day17Real = $day17Real;

        return $this;
    }

    /**
     * Get day17Real
     *
     * @return float 
     */
    public function getDay17Real()
    {
        return $this->day17Real;
    }

    /**
     * Set day18Plan
     *
     * @param float $day18Plan
     * @return RawMaterial
     */
    public function setDay18Plan($day18Plan)
    {
        $this->day18Plan = $day18Plan;

        return $this;
    }

    /**
     * Get day18Plan
     *
     * @return float 
     */
    public function getDay18Plan()
    {
        return $this->day18Plan;
    }

    /**
     * Set day18Real
     *
     * @param float $day18Real
     * @return RawMaterial
     */
    public function setDay18Real($day18Real)
    {
        $this->day18Real = $day18Real;

        return $this;
    }

    /**
     * Get day18Real
     *
     * @return float 
     */
    public function getDay18Real()
    {
        return $this->day18Real;
    }

    /**
     * Set day19Plan
     *
     * @param float $day19Plan
     * @return RawMaterial
     */
    public function setDay19Plan($day19Plan)
    {
        $this->day19Plan = $day19Plan;

        return $this;
    }

    /**
     * Get day19Plan
     *
     * @return float 
     */
    public function getDay19Plan()
    {
        return $this->day19Plan;
    }

    /**
     * Set day19Real
     *
     * @param float $day19Real
     * @return RawMaterial
     */
    public function setDay19Real($day19Real)
    {
        $this->day19Real = $day19Real;

        return $this;
    }

    /**
     * Get day19Real
     *
     * @return float 
     */
    public function getDay19Real()
    {
        return $this->day19Real;
    }

    /**
     * Set day20Plan
     *
     * @param float $day20Plan
     * @return RawMaterial
     */
    public function setDay20Plan($day20Plan)
    {
        $this->day20Plan = $day20Plan;

        return $this;
    }

    /**
     * Get day20Plan
     *
     * @return float 
     */
    public function getDay20Plan()
    {
        return $this->day20Plan;
    }

    /**
     * Set day20Real
     *
     * @param float $day20Real
     * @return RawMaterial
     */
    public function setDay20Real($day20Real)
    {
        $this->day20Real = $day20Real;

        return $this;
    }

    /**
     * Get day20Real
     *
     * @return float 
     */
    public function getDay20Real()
    {
        return $this->day20Real;
    }

    /**
     * Set day21Plan
     *
     * @param float $day21Plan
     * @return RawMaterial
     */
    public function setDay21Plan($day21Plan)
    {
        $this->day21Plan = $day21Plan;

        return $this;
    }

    /**
     * Get day21Plan
     *
     * @return float 
     */
    public function getDay21Plan()
    {
        return $this->day21Plan;
    }

    /**
     * Set day21Real
     *
     * @param float $day21Real
     * @return RawMaterial
     */
    public function setDay21Real($day21Real)
    {
        $this->day21Real = $day21Real;

        return $this;
    }

    /**
     * Get day21Real
     *
     * @return float 
     */
    public function getDay21Real()
    {
        return $this->day21Real;
    }

    /**
     * Set day22Plan
     *
     * @param float $day22Plan
     * @return RawMaterial
     */
    public function setDay22Plan($day22Plan)
    {
        $this->day22Plan = $day22Plan;

        return $this;
    }

    /**
     * Get day22Plan
     *
     * @return float 
     */
    public function getDay22Plan()
    {
        return $this->day22Plan;
    }

    /**
     * Set day22Real
     *
     * @param float $day22Real
     * @return RawMaterial
     */
    public function setDay22Real($day22Real)
    {
        $this->day22Real = $day22Real;

        return $this;
    }

    /**
     * Get day22Real
     *
     * @return float 
     */
    public function getDay22Real()
    {
        return $this->day22Real;
    }

    /**
     * Set day23Plan
     *
     * @param float $day23Plan
     * @return RawMaterial
     */
    public function setDay23Plan($day23Plan)
    {
        $this->day23Plan = $day23Plan;

        return $this;
    }

    /**
     * Get day23Plan
     *
     * @return float 
     */
    public function getDay23Plan()
    {
        return $this->day23Plan;
    }

    /**
     * Set day23Real
     *
     * @param float $day23Real
     * @return RawMaterial
     */
    public function setDay23Real($day23Real)
    {
        $this->day23Real = $day23Real;

        return $this;
    }

    /**
     * Get day23Real
     *
     * @return float 
     */
    public function getDay23Real()
    {
        return $this->day23Real;
    }

    /**
     * Set day24Plan
     *
     * @param float $day24Plan
     * @return RawMaterial
     */
    public function setDay24Plan($day24Plan)
    {
        $this->day24Plan = $day24Plan;

        return $this;
    }

    /**
     * Get day24Plan
     *
     * @return float 
     */
    public function getDay24Plan()
    {
        return $this->day24Plan;
    }

    /**
     * Set day24Real
     *
     * @param float $day24Real
     * @return RawMaterial
     */
    public function setDay24Real($day24Real)
    {
        $this->day24Real = $day24Real;

        return $this;
    }

    /**
     * Get day24Real
     *
     * @return float 
     */
    public function getDay24Real()
    {
        return $this->day24Real;
    }

    /**
     * Set day25Plan
     *
     * @param float $day25Plan
     * @return RawMaterial
     */
    public function setDay25Plan($day25Plan)
    {
        $this->day25Plan = $day25Plan;

        return $this;
    }

    /**
     * Get day25Plan
     *
     * @return float 
     */
    public function getDay25Plan()
    {
        return $this->day25Plan;
    }

    /**
     * Set day25Real
     *
     * @param float $day25Real
     * @return RawMaterial
     */
    public function setDay25Real($day25Real)
    {
        $this->day25Real = $day25Real;

        return $this;
    }

    /**
     * Get day25Real
     *
     * @return float 
     */
    public function getDay25Real()
    {
        return $this->day25Real;
    }

    /**
     * Set day26Plan
     *
     * @param float $day26Plan
     * @return RawMaterial
     */
    public function setDay26Plan($day26Plan)
    {
        $this->day26Plan = $day26Plan;

        return $this;
    }

    /**
     * Get day26Plan
     *
     * @return float 
     */
    public function getDay26Plan()
    {
        return $this->day26Plan;
    }

    /**
     * Set day26Real
     *
     * @param float $day26Real
     * @return RawMaterial
     */
    public function setDay26Real($day26Real)
    {
        $this->day26Real = $day26Real;

        return $this;
    }

    /**
     * Get day26Real
     *
     * @return float 
     */
    public function getDay26Real()
    {
        return $this->day26Real;
    }

    /**
     * Set day27Plan
     *
     * @param float $day27Plan
     * @return RawMaterial
     */
    public function setDay27Plan($day27Plan)
    {
        $this->day27Plan = $day27Plan;

        return $this;
    }

    /**
     * Get day27Plan
     *
     * @return float 
     */
    public function getDay27Plan()
    {
        return $this->day27Plan;
    }

    /**
     * Set day27Real
     *
     * @param float $day27Real
     * @return RawMaterial
     */
    public function setDay27Real($day27Real)
    {
        $this->day27Real = $day27Real;

        return $this;
    }

    /**
     * Get day27Real
     *
     * @return float 
     */
    public function getDay27Real()
    {
        return $this->day27Real;
    }

    /**
     * Set day28Plan
     *
     * @param float $day28Plan
     * @return RawMaterial
     */
    public function setDay28Plan($day28Plan)
    {
        $this->day28Plan = $day28Plan;

        return $this;
    }

    /**
     * Get day28Plan
     *
     * @return float 
     */
    public function getDay28Plan()
    {
        return $this->day28Plan;
    }

    /**
     * Set day28Real
     *
     * @param float $day28Real
     * @return RawMaterial
     */
    public function setDay28Real($day28Real)
    {
        $this->day28Real = $day28Real;

        return $this;
    }

    /**
     * Get day28Real
     *
     * @return float 
     */
    public function getDay28Real()
    {
        return $this->day28Real;
    }

    /**
     * Set day29Plan
     *
     * @param float $day29Plan
     * @return RawMaterial
     */
    public function setDay29Plan($day29Plan)
    {
        $this->day29Plan = $day29Plan;

        return $this;
    }

    /**
     * Get day29Plan
     *
     * @return float 
     */
    public function getDay29Plan()
    {
        return $this->day29Plan;
    }

    /**
     * Set day29Real
     *
     * @param float $day29Real
     * @return RawMaterial
     */
    public function setDay29Real($day29Real)
    {
        $this->day29Real = $day29Real;

        return $this;
    }

    /**
     * Get day29Real
     *
     * @return float 
     */
    public function getDay29Real()
    {
        return $this->day29Real;
    }

    /**
     * Set day30Plan
     *
     * @param float $day30Plan
     * @return RawMaterial
     */
    public function setDay30Plan($day30Plan)
    {
        $this->day30Plan = $day30Plan;

        return $this;
    }

    /**
     * Get day30Plan
     *
     * @return float 
     */
    public function getDay30Plan()
    {
        return $this->day30Plan;
    }

    /**
     * Set day30Real
     *
     * @param float $day30Real
     * @return RawMaterial
     */
    public function setDay30Real($day30Real)
    {
        $this->day30Real = $day30Real;

        return $this;
    }

    /**
     * Get day30Real
     *
     * @return float 
     */
    public function getDay30Real()
    {
        return $this->day30Real;
    }

    /**
     * Set day31Plan
     *
     * @param float $day31Plan
     * @return RawMaterial
     */
    public function setDay31Plan($day31Plan)
    {
        $this->day31Plan = $day31Plan;

        return $this;
    }

    /**
     * Get day31Plan
     *
     * @return float 
     */
    public function getDay31Plan()
    {
        return $this->day31Plan;
    }

    /**
     * Set day31Real
     *
     * @param float $day31Real
     * @return RawMaterial
     */
    public function setDay31Real($day31Real)
    {
        $this->day31Real = $day31Real;

        return $this;
    }

    /**
     * Get day31Real
     *
     * @return float 
     */
    public function getDay31Real()
    {
        return $this->day31Real;
    }

    /**
     * Set monthBudget
     *
     * @param float $monthBudget
     * @return DetailRawMaterialConsumption
     */
    public function setMonthBudget($monthBudget)
    {
        $this->monthBudget = $monthBudget;

        return $this;
    }

    /**
     * Get monthBudget
     *
     * @return float 
     */
    public function getMonthBudget()
    {
        return $this->monthBudget;
    }
    
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
    
    public function totalize() 
    {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        
        $nameMatchReal = '^getDay\w+Real$';
        $nameMatchPlan = '^getDay\w+Plan$';
        
        $totalReal = $totalPlan = 0.0;
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $class = $method->getDeclaringClass();
            if(!strpos($class, 'Pequiven\SEIPBundle\Model\DataLoad\Detail')){
                continue;
            }
            $value = 0.0;
            if(preg_match('/'.$nameMatchReal.'/i', $methodName) || preg_match('/'.$nameMatchPlan.'/i', $methodName)){
                $value = $this->$methodName();
            }
            if(preg_match('/'.$nameMatchReal.'/i', $methodName)){
                $totalReal +=  $value;
            }
            if(preg_match('/'.$nameMatchPlan.'/i', $methodName)){
                $totalPlan +=  $value;
            }
        }
        
        $methodTotalPlan = "setTotalPlan";
        $methodTotalReal = "setTotalReal";
        $methodPercentage = "setPercentage";
        
        $this->$methodTotalPlan($totalPlan);
        $this->$methodTotalReal($totalReal);
        $percentage = 0;
        if($totalPlan != 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }
        $this->$methodPercentage($percentage);
//        var_dump($methodTotalPlan);
//        var_dump($methodTotalReal);
//        var_dump($methodPercentage);
//        
//        var_dump($totalPlan);
//        var_dump($totalReal);
//        var_dump($percentage);
//        die;
    }
    
    /**
     * Retorna el total del avance de un dia
     * @param type $day
     * @param type $prefix
     * @return int
     */
    public function getTotalPercentajeOf($day) 
    {
        $nameReal = 'getDay'.$day.'Real';
        $namePlan = 'getDay'.$day.'Plan';
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
     * Retorna el total del avance de un dia
     * @param type $day
     * @param type $prefix
     * @return int
     */
    public function getTotalToDay($day) 
    {
        $plan = $real = 0.0;
        for($i=1; $i <= $day; $i++){
            $nameReal = 'getDay'.$i.'Real';
            $namePlan = 'getDay'.$i.'Plan';
            $plan = $plan + $this->$namePlan();
            $real = $real + $this->$nameReal();
        }
        
        return [
            'tp' => $plan,
            'tr' => $real,
        ];
    }
    
    public function __toString() {
        $_toString = "";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
    }
}
