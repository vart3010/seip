<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;
use Tpg\ExtjsBundle\Annotation as Extjs;

/**
 * Detalles del producto en cada dia del mes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 * @Extjs\Model()
 * @Extjs\ModelProxy("/api/indicator-value/product-detail-daily-month")
 * @ORM\HasLifecycleCallbacks()
 * @deprecated since version number
 */
class ProductDetailDailyMonth extends BaseModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Detalle de valor del indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail",inversedBy="productsDetailDailyMonth")
     * @ORM\JoinColumn(nullable=true)
     */
    private $valueIndicatorDetail;

    /**
     * Producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * Componentes del producto
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth",cascade={"persist","remove"},mappedBy="parent")
     */
    private $components;
    
    /**
     * Producto padre
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth",inversedBy="components")
     */
    private $parent;

    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",nullable=false)
     */
    private $month;
    
    /**
     * Total plan
     * @var float
     * @ORM\Column(name="totalPlan",type="float")
     */
    private $totalPlan = 0;
    
    /**
     * Total real
     * @var float
     * @ORM\Column(name="totalReal",type="float")
     */
    private $totalReal = 0;
    
    /**
     * Porcentaje de cumplimiento
     * @var float
     * @ORM\Column(name="percentage",type="float")
     */
    private $percentage = 0;
    
    /**
     * Dia 1 (Plan)
     * @var float
     * @ORM\Column(name="day1Plan",type="float")
     */
    private $day1Plan = 0;
    
    /**
     * Dia 1 (Real)
     * @var float
     * @ORM\Column(name="day1Real",type="float")
     */
    private $day1Real = 0;
    
    /**
     * Dia 2 (Plan)
     * @var float
     * @ORM\Column(name="day2Plan",type="float")
     */
    private $day2Plan = 0;
    
    /**
     * Dia 2 (Real)
     * @var float
     * @ORM\Column(name="day2Real",type="float")
     */
    private $day2Real = 0;
    
    /**
     * Dia 3 (Plan)
     * @var float
     * @ORM\Column(name="day3Plan",type="float")
     */
    private $day3Plan = 0;
    
    /**
     * Dia 3 (Real)
     * @var float
     * @ORM\Column(name="day3Real",type="float")
     */
    private $day3Real = 0;
    
    /**
     * Dia 4 (Plan)
     * @var float
     * @ORM\Column(name="day4Plan",type="float")
     */
    private $day4Plan = 0;
    
    /**
     * Dia 4 (Real)
     * @var float
     * @ORM\Column(name="day4Real",type="float")
     */
    private $day4Real = 0;
    
    /**
     * Dia 5 (Plan)
     * @var float
     * @ORM\Column(name="day5Plan",type="float")
     */
    private $day5Plan = 0;
    
    /**
     * Dia 5 (Real)
     * @var float
     * @ORM\Column(name="day5Real",type="float")
     */
    private $day5Real = 0;
    
    /**
     * Dia 6 (Plan)
     * @var float
     * @ORM\Column(name="day6Plan",type="float")
     */
    private $day6Plan = 0;
    
    /**
     * Dia 6 (Real)
     * @var float
     * @ORM\Column(name="day6Real",type="float")
     */
    private $day6Real = 0;
    
    /**
     * Dia 7 (Plan)
     * @var float
     * @ORM\Column(name="day7Plan",type="float")
     */
    private $day7Plan = 0;
    
    /**
     * Dia 7 (Real)
     * @var float
     * @ORM\Column(name="day7Real",type="float")
     */
    private $day7Real = 0;
    
    /**
     * Dia 8 (Plan)
     * @var float
     * @ORM\Column(name="day8Plan",type="float")
     */
    private $day8Plan = 0;
    
    /**
     * Dia 8 (Real)
     * @var float
     * @ORM\Column(name="day8Real",type="float")
     */
    private $day8Real = 0;
    
    /**
     * Dia 9 (Plan)
     * @var float
     * @ORM\Column(name="day9Plan",type="float")
     */
    private $day9Plan = 0;
    
    /**
     * Dia 9 (Real)
     * @var float
     * @ORM\Column(name="day9Real",type="float")
     */
    private $day9Real = 0;
    
    /**
     * Dia 10 (Plan)
     * @var float
     * @ORM\Column(name="day10Plan",type="float")
     */
    private $day10Plan = 0;
    
    /**
     * Dia 10 (Real)
     * @var float
     * @ORM\Column(name="day10Real",type="float")
     */
    private $day10Real = 0;
    
    /**
     * Dia 11 (Plan)
     * @var float
     * @ORM\Column(name="day11Plan",type="float")
     */
    private $day11Plan = 0;
    
    /**
     * Dia 11 (Real)
     * @var float
     * @ORM\Column(name="day11Real",type="float")
     */
    private $day11Real = 0;
    
    /**
     * Dia 12 (Plan)
     * @var float
     * @ORM\Column(name="day12Plan",type="float")
     */
    private $day12Plan = 0;
    
    /**
     * Dia 12 (Real)
     * @var float
     * @ORM\Column(name="day12Real",type="float")
     */
    private $day12Real = 0;
    
    /**
     * Dia 13 (Plan)
     * @var float
     * @ORM\Column(name="day13Plan",type="float")
     */
    private $day13Plan = 0;
    
    /**
     * Dia 13 (Real)
     * @var float
     * @ORM\Column(name="day13Real",type="float")
     */
    private $day13Real = 0;
    
    /**
     * Dia 14 (Plan)
     * @var float
     * @ORM\Column(name="day14Plan",type="float")
     */
    private $day14Plan = 0;
    
    /**
     * Dia 14 (Real)
     * @var float
     * @ORM\Column(name="day14Real",type="float")
     */
    private $day14Real = 0;
    
    /**
     * Dia 15 (Plan)
     * @var float
     * @ORM\Column(name="day15Plan",type="float")
     */
    private $day15Plan = 0;
    
    /**
     * Dia 15 (Real)
     * @var float
     * @ORM\Column(name="day15Real",type="float")
     */
    private $day15Real = 0;
    
    /**
     * Dia 16 (Plan)
     * @var float
     * @ORM\Column(name="day16Plan",type="float")
     */
    private $day16Plan = 0;
    
    /**
     * Dia 16 (Real)
     * @var float
     * @ORM\Column(name="day16Real",type="float")
     */
    private $day16Real = 0;
    
    /**
     * Dia 17 (Plan)
     * @var float
     * @ORM\Column(name="day17Plan",type="float")
     */
    private $day17Plan = 0;
    
    /**
     * Dia 17 (Real)
     * @var float
     * @ORM\Column(name="day17Real",type="float")
     */
    private $day17Real = 0;
    
    /**
     * Dia 18 (Plan)
     * @var float
     * @ORM\Column(name="day18Plan",type="float")
     */
    private $day18Plan = 0;
    
    /**
     * Dia 18 (Real)
     * @var float
     * @ORM\Column(name="day18Real",type="float")
     */
    private $day18Real = 0;
    
    /**
     * Dia 19 (Plan)
     * @var float
     * @ORM\Column(name="day19Plan",type="float")
     */
    private $day19Plan = 0;
    
    /**
     * Dia 19 (Real)
     * @var float
     * @ORM\Column(name="day19Real",type="float")
     */
    private $day19Real = 0;
    
    /**
     * Dia 20 (Plan)
     * @var float
     * @ORM\Column(name="day20Plan",type="float")
     */
    private $day20Plan = 0;
    
    /**
     * Dia 20 (Real)
     * @var float
     * @ORM\Column(name="day20Real",type="float")
     */
    private $day20Real = 0;
    
    /**
     * Dia 21 (Plan)
     * @var float
     * @ORM\Column(name="day21Plan",type="float")
     */
    private $day21Plan = 0;
    
    /**
     * Dia 21 (Real)
     * @var float
     * @ORM\Column(name="day21Real",type="float")
     */
    private $day21Real = 0;
    
    /**
     * Dia 22 (Plan)
     * @var float
     * @ORM\Column(name="day22Plan",type="float")
     */
    private $day22Plan = 0;
    
    /**
     * Dia 22 (Real)
     * @var float
     * @ORM\Column(name="day22Real",type="float")
     */
    private $day22Real = 0;
    
    /**
     * Dia 23 (Plan)
     * @var float
     * @ORM\Column(name="day23Plan",type="float")
     */
    private $day23Plan = 0;
    
    /**
     * Dia 23 (Real)
     * @var float
     * @ORM\Column(name="day23Real",type="float")
     */
    private $day23Real = 0;
    
    /**
     * Dia 24 (Plan)
     * @var float
     * @ORM\Column(name="day24Plan",type="float")
     */
    private $day24Plan = 0;
    
    /**
     * Dia 24 (Real)
     * @var float
     * @ORM\Column(name="day24Real",type="float")
     */
    private $day24Real = 0;
    
    /**
     * Dia 25 (Plan)
     * @var float
     * @ORM\Column(name="day25Plan",type="float")
     */
    private $day25Plan = 0;
    
    /**
     * Dia 25 (Real)
     * @var float
     * @ORM\Column(name="day25Real",type="float")
     */
    private $day25Real = 0;
    
    /**
     * Dia 26 (Plan)
     * @var float
     * @ORM\Column(name="day26Plan",type="float")
     */
    private $day26Plan = 0;
    
    /**
     * Dia 26 (Real)
     * @var float
     * @ORM\Column(name="day26Real",type="float")
     */
    private $day26Real = 0;
    
    /**
     * Dia 27 (Plan)
     * @var float
     * @ORM\Column(name="day27Plan",type="float")
     */
    private $day27Plan = 0;
    
    /**
     * Dia 27 (Real)
     * @var float
     * @ORM\Column(name="day27Real",type="float")
     */
    private $day27Real = 0;
    
    /**
     * Dia 28 (Plan)
     * @var float
     * @ORM\Column(name="day28Plan",type="float")
     */
    private $day28Plan = 0;
    
    /**
     * Dia 28 (Real)
     * @var float
     * @ORM\Column(name="day28Real",type="float")
     */
    private $day28Real = 0;
    
    /**
     * Dia 29 (Plan)
     * @var float
     * @ORM\Column(name="day29Plan",type="float")
     */
    private $day29Plan = 0;
    
    /**
     * Dia 29 (Real)
     * @var float
     * @ORM\Column(name="day29Real",type="float")
     */
    private $day29Real = 0;
    
    /**
     * Dia 30 (Plan)
     * @var float
     * @ORM\Column(name="day30Plan",type="float")
     */
    private $day30Plan = 0;
    
    /**
     * Dia 30 (Real)
     * @var float
     * @ORM\Column(name="day30Real",type="float")
     */
    private $day30Real = 0;
    
    /**
     * Dia 31 (Plan)
     * @var float
     * @ORM\Column(name="day31Plan",type="float")
     */
    private $day31Plan = 0;
    
    /**
     * Dia 31 (Real)
     * @var float
     * @ORM\Column(name="day31Real",type="float")
     */
    private $day31Real = 0;
    
    /**
     * Nombre del producto
     * @var type 
     * @Extjs\Model\Field(type="string",mapping="product.name")
     */
    private $productName;

    /**
     * Tipo de producto
     * @var type 
     * @Extjs\Model\Field(type="string",mapping="product.typeOf")
     */
    private $productTypeOf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->components = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set month
     *
     * @param integer $month
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * @return ProductDetailDailyMonth
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
     * Set product
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $product
     * @return ProductDetailDailyMonth
     */
    public function setProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set valueIndicatorDetail
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail $valueIndicatorDetail
     * @return ProductDetailDailyMonth
     */
    public function setValueIndicatorDetail(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail $valueIndicatorDetail)
    {
        $this->valueIndicatorDetail = $valueIndicatorDetail;

        return $this;
    }

    /**
     * Get valueIndicatorDetail
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail 
     */
    public function getValueIndicatorDetail()
    {
        return $this->valueIndicatorDetail;
    }

    /**
     * Add components
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $components
     * @return ProductDetailDailyMonth
     */
    public function addComponent(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $components)
    {
        $components->setParent($this);
        $this->components->add($components);

        return $this;
    }

    /**
     * Remove components
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $components
     */
    public function removeComponent(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $components)
    {
        $this->components->removeElement($components);
    }

    /**
     * Get components
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponents()
    {
        return $this->components;
    }
    
    /**
     * 
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth
     */
    function getParent() 
    {
        return $this->parent;
    }
    
    /**
     * 
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $parent
     */
    function setParent(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $parent) 
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    /**
     * Metodo que se ejecuta antes de actualizar la entidad
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        
        $nameMatchReal = '^getDay\w+Real$';
        $nameMatchPlan = '^getDay\w+Plan$';
        
        $totalReal = $totalPlan = 0.0;
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $class = $method->getDeclaringClass();
            if(!strpos($class, 'Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth')){
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
        $this->setTotalPlan($totalPlan);
        $this->setTotalReal($totalReal);
        $percentage = 0;
        if($totalPlan != 0){
            $percentage = ($totalReal * 100) / $totalPlan;
        }
        if($this->getComponents()->count()  == 0){
            $this->setPercentage($percentage);
        }
    }
    
    public function updateParentTotals()
    {
        $components = $this->getComponents();
        $quantity = count($components);
        $totalPlan = $totalReal = $totalPercentage = 0.0;
        $reflection = new \ReflectionClass(new self());
        $properties = $reflection->getProperties();

        $nameMatchReal = '^day\w+Real$';
        $nameMatchPlan = '^day\w+Plan$';
        $totalsChilds = array();
        
        $propertyAccessor = \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor();
        foreach ($components as $component) {
            $totalPlan += $component->getTotalPlan();
            $totalReal += $component->getTotalReal();
            $totalPercentage += $component->getPercentage();
            
            foreach ($properties as $property) {
                $propertyName = $property->getName();
//                print_r($propertyName);
                $class = $property->getDeclaringClass();
                if(!strpos($class, 'Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth')){
                    continue;
                }
                if(preg_match('/'.$nameMatchReal.'/i', $propertyName) == false && preg_match('/'.$nameMatchPlan.'/i', $propertyName) == false){
                    continue;
                }
                
                if(!isset($totalsChilds[$propertyName])){
                    $totalsChilds[$propertyName] = 0.0;
                }
                $value = (float)$propertyAccessor->getValue($component, $propertyName);
                
                $propertyTotal = $totalsChilds[$propertyName] + $value;
                $totalsChilds[$propertyName] = $propertyTotal;
            }
        }
        foreach ($totalsChilds as $property => $value) {
            $propertyAccessor->setValue($this, $property, $value);
        }
//        $this->setTotalPlan($totalPlan);
//        $this->setTotalReal($totalReal);
        $this->setPercentage($totalPercentage / $quantity);
    }
}
