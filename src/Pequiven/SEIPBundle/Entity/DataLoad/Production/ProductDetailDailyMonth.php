<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Production\ProductDetailDailyMonth as BaseModel;
use Tpg\ExtjsBundle\Annotation as Extjs;

/**
 * Detalles del producto en cada dia del mes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_report_product_detail_daily_month")
 * @ORM\Entity()
 * @Extjs\Model()
 * @Extjs\ModelProxy("/api/report/product-detail-daily-month")
 * @ORM\HasLifecycleCallbacks()
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
     * Producto de reporte
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="productDetailDailyMonths")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReport;
    
    /**
     * Mes
     * @var integer
     * @ORM\Column(name="month",type="integer",nullable=false)
     */
    private $month;
    
    /**
     * Total plan (Bruta)
     * @var float
     * @ORM\Column(name="totalGrossPlan",type="float")
     */
    private $totalGrossPlan = 0;
    
    /**
     * Total real (Bruta)
     * @var float
     * @ORM\Column(name="totalGrossReal",type="float")
     */
    private $totalGrossReal = 0;
    
    /**
     * Porcentaje de cumplimiento (Bruta)
     * @var float
     * @ORM\Column(name="grossPercentage",type="float")
     */
    private $grossPercentage = 0;
    
    /**
     * Total plan (Neta)
     * @var float
     * @ORM\Column(name="totalNetPlan",type="float")
     */
    private $totalNetPlan = 0;
    
    /**
     * Total real (Neta)
     * @var float
     * @ORM\Column(name="totalNetReal",type="float")
     */
    private $totalNetReal = 0;
    
    /**
     * Porcentaje de cumplimiento (Neta)
     * @var float
     * @ORM\Column(name="netPercentage",type="float")
     */
    private $netPercentage = 0;
    
    //Bruta
    /**
     * Dia 1 (GrossPlan)
     * @var float
     * @ORM\Column(name="day1GrossPlan",type="float")
     */
    private $day1GrossPlan = 0;
    
    /**
     * Dia 1 (GrossReal)
     * @var float
     * @ORM\Column(name="day1GrossReal",type="float")
     */
    private $day1GrossReal = 0;
    
    /**
     * Dia 2 (GrossPlan)
     * @var float
     * @ORM\Column(name="day2GrossPlan",type="float")
     */
    private $day2GrossPlan = 0;
    
    /**
     * Dia 2 (GrossReal)
     * @var float
     * @ORM\Column(name="day2GrossReal",type="float")
     */
    private $day2GrossReal = 0;
    
    /**
     * Dia 3 (GrossPlan)
     * @var float
     * @ORM\Column(name="day3GrossPlan",type="float")
     */
    private $day3GrossPlan = 0;
    
    /**
     * Dia 3 (GrossReal)
     * @var float
     * @ORM\Column(name="day3GrossReal",type="float")
     */
    private $day3GrossReal = 0;
    
    /**
     * Dia 4 (GrossPlan)
     * @var float
     * @ORM\Column(name="day4GrossPlan",type="float")
     */
    private $day4GrossPlan = 0;
    
    /**
     * Dia 4 (GrossReal)
     * @var float
     * @ORM\Column(name="day4GrossReal",type="float")
     */
    private $day4GrossReal = 0;
    
    /**
     * Dia 5 (GrossPlan)
     * @var float
     * @ORM\Column(name="day5GrossPlan",type="float")
     */
    private $day5GrossPlan = 0;
    
    /**
     * Dia 5 (GrossReal)
     * @var float
     * @ORM\Column(name="day5GrossReal",type="float")
     */
    private $day5GrossReal = 0;
    
    /**
     * Dia 6 (GrossPlan)
     * @var float
     * @ORM\Column(name="day6GrossPlan",type="float")
     */
    private $day6GrossPlan = 0;
    
    /**
     * Dia 6 (GrossReal)
     * @var float
     * @ORM\Column(name="day6GrossReal",type="float")
     */
    private $day6GrossReal = 0;
    
    /**
     * Dia 7 (GrossPlan)
     * @var float
     * @ORM\Column(name="day7GrossPlan",type="float")
     */
    private $day7GrossPlan = 0;
    
    /**
     * Dia 7 (GrossReal)
     * @var float
     * @ORM\Column(name="day7GrossReal",type="float")
     */
    private $day7GrossReal = 0;
    
    /**
     * Dia 8 (GrossPlan)
     * @var float
     * @ORM\Column(name="day8GrossPlan",type="float")
     */
    private $day8GrossPlan = 0;
    
    /**
     * Dia 8 (GrossReal)
     * @var float
     * @ORM\Column(name="day8GrossReal",type="float")
     */
    private $day8GrossReal = 0;
    
    /**
     * Dia 9 (GrossPlan)
     * @var float
     * @ORM\Column(name="day9GrossPlan",type="float")
     */
    private $day9GrossPlan = 0;
    
    /**
     * Dia 9 (GrossReal)
     * @var float
     * @ORM\Column(name="day9GrossReal",type="float")
     */
    private $day9GrossReal = 0;
    
    /**
     * Dia 10 (GrossPlan)
     * @var float
     * @ORM\Column(name="day10GrossPlan",type="float")
     */
    private $day10GrossPlan = 0;
    
    /**
     * Dia 10 (GrossReal)
     * @var float
     * @ORM\Column(name="day10GrossReal",type="float")
     */
    private $day10GrossReal = 0;
    
    /**
     * Dia 11 (GrossPlan)
     * @var float
     * @ORM\Column(name="day11GrossPlan",type="float")
     */
    private $day11GrossPlan = 0;
    
    /**
     * Dia 11 (GrossReal)
     * @var float
     * @ORM\Column(name="day11GrossReal",type="float")
     */
    private $day11GrossReal = 0;
    
    /**
     * Dia 12 (GrossPlan)
     * @var float
     * @ORM\Column(name="day12GrossPlan",type="float")
     */
    private $day12GrossPlan = 0;
    
    /**
     * Dia 12 (GrossReal)
     * @var float
     * @ORM\Column(name="day12GrossReal",type="float")
     */
    private $day12GrossReal = 0;
    
    /**
     * Dia 13 (GrossPlan)
     * @var float
     * @ORM\Column(name="day13GrossPlan",type="float")
     */
    private $day13GrossPlan = 0;
    
    /**
     * Dia 13 (GrossReal)
     * @var float
     * @ORM\Column(name="day13GrossReal",type="float")
     */
    private $day13GrossReal = 0;
    
    /**
     * Dia 14 (GrossPlan)
     * @var float
     * @ORM\Column(name="day14GrossPlan",type="float")
     */
    private $day14GrossPlan = 0;
    
    /**
     * Dia 14 (GrossReal)
     * @var float
     * @ORM\Column(name="day14GrossReal",type="float")
     */
    private $day14GrossReal = 0;
    
    /**
     * Dia 15 (GrossPlan)
     * @var float
     * @ORM\Column(name="day15GrossPlan",type="float")
     */
    private $day15GrossPlan = 0;
    
    /**
     * Dia 15 (GrossReal)
     * @var float
     * @ORM\Column(name="day15GrossReal",type="float")
     */
    private $day15GrossReal = 0;
    
    /**
     * Dia 16 (GrossPlan)
     * @var float
     * @ORM\Column(name="day16GrossPlan",type="float")
     */
    private $day16GrossPlan = 0;
    
    /**
     * Dia 16 (GrossReal)
     * @var float
     * @ORM\Column(name="day16GrossReal",type="float")
     */
    private $day16GrossReal = 0;
    
    /**
     * Dia 17 (GrossPlan)
     * @var float
     * @ORM\Column(name="day17GrossPlan",type="float")
     */
    private $day17GrossPlan = 0;
    
    /**
     * Dia 17 (GrossReal)
     * @var float
     * @ORM\Column(name="day17GrossReal",type="float")
     */
    private $day17GrossReal = 0;
    
    /**
     * Dia 18 (GrossPlan)
     * @var float
     * @ORM\Column(name="day18GrossPlan",type="float")
     */
    private $day18GrossPlan = 0;
    
    /**
     * Dia 18 (GrossReal)
     * @var float
     * @ORM\Column(name="day18GrossReal",type="float")
     */
    private $day18GrossReal = 0;
    
    /**
     * Dia 19 (GrossPlan)
     * @var float
     * @ORM\Column(name="day19GrossPlan",type="float")
     */
    private $day19GrossPlan = 0;
    
    /**
     * Dia 19 (GrossReal)
     * @var float
     * @ORM\Column(name="day19GrossReal",type="float")
     */
    private $day19GrossReal = 0;
    
    /**
     * Dia 20 (GrossPlan)
     * @var float
     * @ORM\Column(name="day20GrossPlan",type="float")
     */
    private $day20GrossPlan = 0;
    
    /**
     * Dia 20 (GrossReal)
     * @var float
     * @ORM\Column(name="day20GrossReal",type="float")
     */
    private $day20GrossReal = 0;
    
    /**
     * Dia 21 (GrossPlan)
     * @var float
     * @ORM\Column(name="day21GrossPlan",type="float")
     */
    private $day21GrossPlan = 0;
    
    /**
     * Dia 21 (GrossReal)
     * @var float
     * @ORM\Column(name="day21GrossReal",type="float")
     */
    private $day21GrossReal = 0;
    
    /**
     * Dia 22 (GrossPlan)
     * @var float
     * @ORM\Column(name="day22GrossPlan",type="float")
     */
    private $day22GrossPlan = 0;
    
    /**
     * Dia 22 (GrossReal)
     * @var float
     * @ORM\Column(name="day22GrossReal",type="float")
     */
    private $day22GrossReal = 0;
    
    /**
     * Dia 23 (GrossPlan)
     * @var float
     * @ORM\Column(name="day23GrossPlan",type="float")
     */
    private $day23GrossPlan = 0;
    
    /**
     * Dia 23 (GrossReal)
     * @var float
     * @ORM\Column(name="day23GrossReal",type="float")
     */
    private $day23GrossReal = 0;
    
    /**
     * Dia 24 (GrossPlan)
     * @var float
     * @ORM\Column(name="day24GrossPlan",type="float")
     */
    private $day24GrossPlan = 0;
    
    /**
     * Dia 24 (GrossReal)
     * @var float
     * @ORM\Column(name="day24GrossReal",type="float")
     */
    private $day24GrossReal = 0;
    
    /**
     * Dia 25 (GrossPlan)
     * @var float
     * @ORM\Column(name="day25GrossPlan",type="float")
     */
    private $day25GrossPlan = 0;
    
    /**
     * Dia 25 (GrossReal)
     * @var float
     * @ORM\Column(name="day25GrossReal",type="float")
     */
    private $day25GrossReal = 0;
    
    /**
     * Dia 26 (GrossPlan)
     * @var float
     * @ORM\Column(name="day26GrossPlan",type="float")
     */
    private $day26GrossPlan = 0;
    
    /**
     * Dia 26 (GrossReal)
     * @var float
     * @ORM\Column(name="day26GrossReal",type="float")
     */
    private $day26GrossReal = 0;
    
    /**
     * Dia 27 (GrossPlan)
     * @var float
     * @ORM\Column(name="day27GrossPlan",type="float")
     */
    private $day27GrossPlan = 0;
    
    /**
     * Dia 27 (GrossReal)
     * @var float
     * @ORM\Column(name="day27GrossReal",type="float")
     */
    private $day27GrossReal = 0;
    
    /**
     * Dia 28 (GrossPlan)
     * @var float
     * @ORM\Column(name="day28GrossPlan",type="float")
     */
    private $day28GrossPlan = 0;
    
    /**
     * Dia 28 (GrossReal)
     * @var float
     * @ORM\Column(name="day28GrossReal",type="float")
     */
    private $day28GrossReal = 0;
    
    /**
     * Dia 29 (GrossPlan)
     * @var float
     * @ORM\Column(name="day29GrossPlan",type="float")
     */
    private $day29GrossPlan = 0;
    
    /**
     * Dia 29 (GrossReal)
     * @var float
     * @ORM\Column(name="day29GrossReal",type="float")
     */
    private $day29GrossReal = 0;
    
    /**
     * Dia 30 (GrossPlan)
     * @var float
     * @ORM\Column(name="day30GrossPlan",type="float")
     */
    private $day30GrossPlan = 0;
    
    /**
     * Dia 30 (GrossReal)
     * @var float
     * @ORM\Column(name="day30GrossReal",type="float")
     */
    private $day30GrossReal = 0;
    
    /**
     * Dia 31 (GrossPlan)
     * @var float
     * @ORM\Column(name="day31GrossPlan",type="float")
     */
    private $day31GrossPlan = 0;
    
    /**
     * Dia 31 (GrossReal)
     * @var float
     * @ORM\Column(name="day31GrossReal",type="float")
     */
    private $day31GrossReal = 0;
    
    //Neta
    /**
     * Dia 1 (NetPlan)
     * @var float
     * @ORM\Column(name="day1NetPlan",type="float")
     */
    private $day1NetPlan = 0;
    
    /**
     * Dia 1 (NetReal)
     * @var float
     * @ORM\Column(name="day1NetReal",type="float")
     */
    private $day1NetReal = 0;
    
    /**
     * Dia 2 (NetPlan)
     * @var float
     * @ORM\Column(name="day2NetPlan",type="float")
     */
    private $day2NetPlan = 0;
    
    /**
     * Dia 2 (NetReal)
     * @var float
     * @ORM\Column(name="day2NetReal",type="float")
     */
    private $day2NetReal = 0;
    
    /**
     * Dia 3 (NetPlan)
     * @var float
     * @ORM\Column(name="day3NetPlan",type="float")
     */
    private $day3NetPlan = 0;
    
    /**
     * Dia 3 (NetReal)
     * @var float
     * @ORM\Column(name="day3NetReal",type="float")
     */
    private $day3NetReal = 0;
    
    /**
     * Dia 4 (NetPlan)
     * @var float
     * @ORM\Column(name="day4NetPlan",type="float")
     */
    private $day4NetPlan = 0;
    
    /**
     * Dia 4 (NetReal)
     * @var float
     * @ORM\Column(name="day4NetReal",type="float")
     */
    private $day4NetReal = 0;
    
    /**
     * Dia 5 (NetPlan)
     * @var float
     * @ORM\Column(name="day5NetPlan",type="float")
     */
    private $day5NetPlan = 0;
    
    /**
     * Dia 5 (NetReal)
     * @var float
     * @ORM\Column(name="day5NetReal",type="float")
     */
    private $day5NetReal = 0;
    
    /**
     * Dia 6 (NetPlan)
     * @var float
     * @ORM\Column(name="day6NetPlan",type="float")
     */
    private $day6NetPlan = 0;
    
    /**
     * Dia 6 (NetReal)
     * @var float
     * @ORM\Column(name="day6NetReal",type="float")
     */
    private $day6NetReal = 0;
    
    /**
     * Dia 7 (NetPlan)
     * @var float
     * @ORM\Column(name="day7NetPlan",type="float")
     */
    private $day7NetPlan = 0;
    
    /**
     * Dia 7 (NetReal)
     * @var float
     * @ORM\Column(name="day7NetReal",type="float")
     */
    private $day7NetReal = 0;
    
    /**
     * Dia 8 (NetPlan)
     * @var float
     * @ORM\Column(name="day8NetPlan",type="float")
     */
    private $day8NetPlan = 0;
    
    /**
     * Dia 8 (NetReal)
     * @var float
     * @ORM\Column(name="day8NetReal",type="float")
     */
    private $day8NetReal = 0;
    
    /**
     * Dia 9 (NetPlan)
     * @var float
     * @ORM\Column(name="day9NetPlan",type="float")
     */
    private $day9NetPlan = 0;
    
    /**
     * Dia 9 (NetReal)
     * @var float
     * @ORM\Column(name="day9NetReal",type="float")
     */
    private $day9NetReal = 0;
    
    /**
     * Dia 10 (NetPlan)
     * @var float
     * @ORM\Column(name="day10NetPlan",type="float")
     */
    private $day10NetPlan = 0;
    
    /**
     * Dia 10 (NetReal)
     * @var float
     * @ORM\Column(name="day10NetReal",type="float")
     */
    private $day10NetReal = 0;
    
    /**
     * Dia 11 (NetPlan)
     * @var float
     * @ORM\Column(name="day11NetPlan",type="float")
     */
    private $day11NetPlan = 0;
    
    /**
     * Dia 11 (NetReal)
     * @var float
     * @ORM\Column(name="day11NetReal",type="float")
     */
    private $day11NetReal = 0;
    
    /**
     * Dia 12 (NetPlan)
     * @var float
     * @ORM\Column(name="day12NetPlan",type="float")
     */
    private $day12NetPlan = 0;
    
    /**
     * Dia 12 (NetReal)
     * @var float
     * @ORM\Column(name="day12NetReal",type="float")
     */
    private $day12NetReal = 0;
    
    /**
     * Dia 13 (NetPlan)
     * @var float
     * @ORM\Column(name="day13NetPlan",type="float")
     */
    private $day13NetPlan = 0;
    
    /**
     * Dia 13 (NetReal)
     * @var float
     * @ORM\Column(name="day13NetReal",type="float")
     */
    private $day13NetReal = 0;
    
    /**
     * Dia 14 (NetPlan)
     * @var float
     * @ORM\Column(name="day14NetPlan",type="float")
     */
    private $day14NetPlan = 0;
    
    /**
     * Dia 14 (NetReal)
     * @var float
     * @ORM\Column(name="day14NetReal",type="float")
     */
    private $day14NetReal = 0;
    
    /**
     * Dia 15 (NetPlan)
     * @var float
     * @ORM\Column(name="day15NetPlan",type="float")
     */
    private $day15NetPlan = 0;
    
    /**
     * Dia 15 (NetReal)
     * @var float
     * @ORM\Column(name="day15NetReal",type="float")
     */
    private $day15NetReal = 0;
    
    /**
     * Dia 16 (NetPlan)
     * @var float
     * @ORM\Column(name="day16NetPlan",type="float")
     */
    private $day16NetPlan = 0;
    
    /**
     * Dia 16 (NetReal)
     * @var float
     * @ORM\Column(name="day16NetReal",type="float")
     */
    private $day16NetReal = 0;
    
    /**
     * Dia 17 (NetPlan)
     * @var float
     * @ORM\Column(name="day17NetPlan",type="float")
     */
    private $day17NetPlan = 0;
    
    /**
     * Dia 17 (NetReal)
     * @var float
     * @ORM\Column(name="day17NetReal",type="float")
     */
    private $day17NetReal = 0;
    
    /**
     * Dia 18 (NetPlan)
     * @var float
     * @ORM\Column(name="day18NetPlan",type="float")
     */
    private $day18NetPlan = 0;
    
    /**
     * Dia 18 (NetReal)
     * @var float
     * @ORM\Column(name="day18NetReal",type="float")
     */
    private $day18NetReal = 0;
    
    /**
     * Dia 19 (NetPlan)
     * @var float
     * @ORM\Column(name="day19NetPlan",type="float")
     */
    private $day19NetPlan = 0;
    
    /**
     * Dia 19 (NetReal)
     * @var float
     * @ORM\Column(name="day19NetReal",type="float")
     */
    private $day19NetReal = 0;
    
    /**
     * Dia 20 (NetPlan)
     * @var float
     * @ORM\Column(name="day20NetPlan",type="float")
     */
    private $day20NetPlan = 0;
    
    /**
     * Dia 20 (NetReal)
     * @var float
     * @ORM\Column(name="day20NetReal",type="float")
     */
    private $day20NetReal = 0;
    
    /**
     * Dia 21 (NetPlan)
     * @var float
     * @ORM\Column(name="day21NetPlan",type="float")
     */
    private $day21NetPlan = 0;
    
    /**
     * Dia 21 (NetReal)
     * @var float
     * @ORM\Column(name="day21NetReal",type="float")
     */
    private $day21NetReal = 0;
    
    /**
     * Dia 22 (NetPlan)
     * @var float
     * @ORM\Column(name="day22NetPlan",type="float")
     */
    private $day22NetPlan = 0;
    
    /**
     * Dia 22 (NetReal)
     * @var float
     * @ORM\Column(name="day22NetReal",type="float")
     */
    private $day22NetReal = 0;
    
    /**
     * Dia 23 (NetPlan)
     * @var float
     * @ORM\Column(name="day23NetPlan",type="float")
     */
    private $day23NetPlan = 0;
    
    /**
     * Dia 23 (NetReal)
     * @var float
     * @ORM\Column(name="day23NetReal",type="float")
     */
    private $day23NetReal = 0;
    
    /**
     * Dia 24 (NetPlan)
     * @var float
     * @ORM\Column(name="day24NetPlan",type="float")
     */
    private $day24NetPlan = 0;
    
    /**
     * Dia 24 (NetReal)
     * @var float
     * @ORM\Column(name="day24NetReal",type="float")
     */
    private $day24NetReal = 0;
    
    /**
     * Dia 25 (NetPlan)
     * @var float
     * @ORM\Column(name="day25NetPlan",type="float")
     */
    private $day25NetPlan = 0;
    
    /**
     * Dia 25 (NetReal)
     * @var float
     * @ORM\Column(name="day25NetReal",type="float")
     */
    private $day25NetReal = 0;
    
    /**
     * Dia 26 (NetPlan)
     * @var float
     * @ORM\Column(name="day26NetPlan",type="float")
     */
    private $day26NetPlan = 0;
    
    /**
     * Dia 26 (NetReal)
     * @var float
     * @ORM\Column(name="day26NetReal",type="float")
     */
    private $day26NetReal = 0;
    
    /**
     * Dia 27 (NetPlan)
     * @var float
     * @ORM\Column(name="day27NetPlan",type="float")
     */
    private $day27NetPlan = 0;
    
    /**
     * Dia 27 (NetReal)
     * @var float
     * @ORM\Column(name="day27NetReal",type="float")
     */
    private $day27NetReal = 0;
    
    /**
     * Dia 28 (NetPlan)
     * @var float
     * @ORM\Column(name="day28NetPlan",type="float")
     */
    private $day28NetPlan = 0;
    
    /**
     * Dia 28 (NetReal)
     * @var float
     * @ORM\Column(name="day28NetReal",type="float")
     */
    private $day28NetReal = 0;
    
    /**
     * Dia 29 (NetPlan)
     * @var float
     * @ORM\Column(name="day29NetPlan",type="float")
     */
    private $day29NetPlan = 0;
    
    /**
     * Dia 29 (NetReal)
     * @var float
     * @ORM\Column(name="day29NetReal",type="float")
     */
    private $day29NetReal = 0;
    
    /**
     * Dia 30 (NetPlan)
     * @var float
     * @ORM\Column(name="day30NetPlan",type="float")
     */
    private $day30NetPlan = 0;
    
    /**
     * Dia 30 (NetReal)
     * @var float
     * @ORM\Column(name="day30NetReal",type="float")
     */
    private $day30NetReal = 0;
    
    /**
     * Dia 31 (NetPlan)
     * @var float
     * @ORM\Column(name="day31NetPlan",type="float")
     */
    private $day31NetPlan = 0;
    
    /**
     * Dia 31 (NetReal)
     * @var float
     * @ORM\Column(name="day31NetReal",type="float")
     */
    private $day31NetReal = 0;
    
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
     * Set productReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport
     * @return ProductDetailDailyMonth
     */
    public function setProductReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport)
    {
        $this->productReport = $productReport;

        return $this;
    }

    /**
     * Get productReport
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport 
     */
    public function getProductReport()
    {
        return $this->productReport;
    }
    
    /**
     * Set totalGrossPlan
     *
     * @param float $totalGrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setTotalGrossPlan($totalGrossPlan)
    {
        $this->totalGrossPlan = $totalGrossPlan;

        return $this;
    }

    /**
     * Get totalGrossPlan
     *
     * @return float 
     */
    public function getTotalGrossPlan()
    {
        return $this->totalGrossPlan;
    }

    /**
     * Set totalGrossReal
     *
     * @param float $totalGrossReal
     * @return ProductDetailDailyMonth
     */
    public function setTotalGrossReal($totalGrossReal)
    {
        $this->totalGrossReal = $totalGrossReal;

        return $this;
    }

    /**
     * Get totalGrossReal
     *
     * @return float 
     */
    public function getTotalGrossReal()
    {
        return $this->totalGrossReal;
    }

    /**
     * Set grossPercentage
     *
     * @param float $grossPercentage
     * @return ProductDetailDailyMonth
     */
    public function setGrossPercentage($grossPercentage)
    {
        $this->grossPercentage = $grossPercentage;

        return $this;
    }

    /**
     * Get grossPercentage
     *
     * @return float 
     */
    public function getGrossPercentage()
    {
        return $this->grossPercentage;
    }

    /**
     * Set totalNetPlan
     *
     * @param float $totalNetPlan
     * @return ProductDetailDailyMonth
     */
    public function setTotalNetPlan($totalNetPlan)
    {
        $this->totalNetPlan = $totalNetPlan;

        return $this;
    }

    /**
     * Get totalNetPlan
     *
     * @return float 
     */
    public function getTotalNetPlan()
    {
        return $this->totalNetPlan;
    }

    /**
     * Set totalNetReal
     *
     * @param float $totalNetReal
     * @return ProductDetailDailyMonth
     */
    public function setTotalNetReal($totalNetReal)
    {
        $this->totalNetReal = $totalNetReal;

        return $this;
    }

    /**
     * Get totalNetReal
     *
     * @return float 
     */
    public function getTotalNetReal()
    {
        return $this->totalNetReal;
    }

    /**
     * Set netPercentage
     *
     * @param float $netPercentage
     * @return ProductDetailDailyMonth
     */
    public function setNetPercentage($netPercentage)
    {
        $this->netPercentage = $netPercentage;

        return $this;
    }

    /**
     * Get netPercentage
     *
     * @return float 
     */
    public function getNetPercentage()
    {
        return $this->netPercentage;
    }

    /**
     * Set day1GrossPlan
     *
     * @param float $day1GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay1GrossPlan($day1GrossPlan)
    {
        $this->day1GrossPlan = $day1GrossPlan;

        return $this;
    }

    /**
     * Get day1GrossPlan
     *
     * @return float 
     */
    public function getDay1GrossPlan()
    {
        return $this->day1GrossPlan;
    }

    /**
     * Set day1GrossReal
     *
     * @param float $day1GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay1GrossReal($day1GrossReal)
    {
        $this->day1GrossReal = $day1GrossReal;

        return $this;
    }

    /**
     * Get day1GrossReal
     *
     * @return float 
     */
    public function getDay1GrossReal()
    {
        return $this->day1GrossReal;
    }

    /**
     * Set day2GrossPlan
     *
     * @param float $day2GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay2GrossPlan($day2GrossPlan)
    {
        $this->day2GrossPlan = $day2GrossPlan;

        return $this;
    }

    /**
     * Get day2GrossPlan
     *
     * @return float 
     */
    public function getDay2GrossPlan()
    {
        return $this->day2GrossPlan;
    }

    /**
     * Set day2GrossReal
     *
     * @param float $day2GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay2GrossReal($day2GrossReal)
    {
        $this->day2GrossReal = $day2GrossReal;

        return $this;
    }

    /**
     * Get day2GrossReal
     *
     * @return float 
     */
    public function getDay2GrossReal()
    {
        return $this->day2GrossReal;
    }

    /**
     * Set day3GrossPlan
     *
     * @param float $day3GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay3GrossPlan($day3GrossPlan)
    {
        $this->day3GrossPlan = $day3GrossPlan;

        return $this;
    }

    /**
     * Get day3GrossPlan
     *
     * @return float 
     */
    public function getDay3GrossPlan()
    {
        return $this->day3GrossPlan;
    }

    /**
     * Set day3GrossReal
     *
     * @param float $day3GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay3GrossReal($day3GrossReal)
    {
        $this->day3GrossReal = $day3GrossReal;

        return $this;
    }

    /**
     * Get day3GrossReal
     *
     * @return float 
     */
    public function getDay3GrossReal()
    {
        return $this->day3GrossReal;
    }

    /**
     * Set day4GrossPlan
     *
     * @param float $day4GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay4GrossPlan($day4GrossPlan)
    {
        $this->day4GrossPlan = $day4GrossPlan;

        return $this;
    }

    /**
     * Get day4GrossPlan
     *
     * @return float 
     */
    public function getDay4GrossPlan()
    {
        return $this->day4GrossPlan;
    }

    /**
     * Set day4GrossReal
     *
     * @param float $day4GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay4GrossReal($day4GrossReal)
    {
        $this->day4GrossReal = $day4GrossReal;

        return $this;
    }

    /**
     * Get day4GrossReal
     *
     * @return float 
     */
    public function getDay4GrossReal()
    {
        return $this->day4GrossReal;
    }

    /**
     * Set day5GrossPlan
     *
     * @param float $day5GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay5GrossPlan($day5GrossPlan)
    {
        $this->day5GrossPlan = $day5GrossPlan;

        return $this;
    }

    /**
     * Get day5GrossPlan
     *
     * @return float 
     */
    public function getDay5GrossPlan()
    {
        return $this->day5GrossPlan;
    }

    /**
     * Set day5GrossReal
     *
     * @param float $day5GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay5GrossReal($day5GrossReal)
    {
        $this->day5GrossReal = $day5GrossReal;

        return $this;
    }

    /**
     * Get day5GrossReal
     *
     * @return float 
     */
    public function getDay5GrossReal()
    {
        return $this->day5GrossReal;
    }

    /**
     * Set day6GrossPlan
     *
     * @param float $day6GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay6GrossPlan($day6GrossPlan)
    {
        $this->day6GrossPlan = $day6GrossPlan;

        return $this;
    }

    /**
     * Get day6GrossPlan
     *
     * @return float 
     */
    public function getDay6GrossPlan()
    {
        return $this->day6GrossPlan;
    }

    /**
     * Set day6GrossReal
     *
     * @param float $day6GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay6GrossReal($day6GrossReal)
    {
        $this->day6GrossReal = $day6GrossReal;

        return $this;
    }

    /**
     * Get day6GrossReal
     *
     * @return float 
     */
    public function getDay6GrossReal()
    {
        return $this->day6GrossReal;
    }

    /**
     * Set day7GrossPlan
     *
     * @param float $day7GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay7GrossPlan($day7GrossPlan)
    {
        $this->day7GrossPlan = $day7GrossPlan;

        return $this;
    }

    /**
     * Get day7GrossPlan
     *
     * @return float 
     */
    public function getDay7GrossPlan()
    {
        return $this->day7GrossPlan;
    }

    /**
     * Set day7GrossReal
     *
     * @param float $day7GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay7GrossReal($day7GrossReal)
    {
        $this->day7GrossReal = $day7GrossReal;

        return $this;
    }

    /**
     * Get day7GrossReal
     *
     * @return float 
     */
    public function getDay7GrossReal()
    {
        return $this->day7GrossReal;
    }

    /**
     * Set day8GrossPlan
     *
     * @param float $day8GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay8GrossPlan($day8GrossPlan)
    {
        $this->day8GrossPlan = $day8GrossPlan;

        return $this;
    }

    /**
     * Get day8GrossPlan
     *
     * @return float 
     */
    public function getDay8GrossPlan()
    {
        return $this->day8GrossPlan;
    }

    /**
     * Set day8GrossReal
     *
     * @param float $day8GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay8GrossReal($day8GrossReal)
    {
        $this->day8GrossReal = $day8GrossReal;

        return $this;
    }

    /**
     * Get day8GrossReal
     *
     * @return float 
     */
    public function getDay8GrossReal()
    {
        return $this->day8GrossReal;
    }

    /**
     * Set day9GrossPlan
     *
     * @param float $day9GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay9GrossPlan($day9GrossPlan)
    {
        $this->day9GrossPlan = $day9GrossPlan;

        return $this;
    }

    /**
     * Get day9GrossPlan
     *
     * @return float 
     */
    public function getDay9GrossPlan()
    {
        return $this->day9GrossPlan;
    }

    /**
     * Set day9GrossReal
     *
     * @param float $day9GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay9GrossReal($day9GrossReal)
    {
        $this->day9GrossReal = $day9GrossReal;

        return $this;
    }

    /**
     * Get day9GrossReal
     *
     * @return float 
     */
    public function getDay9GrossReal()
    {
        return $this->day9GrossReal;
    }

    /**
     * Set day10GrossPlan
     *
     * @param float $day10GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay10GrossPlan($day10GrossPlan)
    {
        $this->day10GrossPlan = $day10GrossPlan;

        return $this;
    }

    /**
     * Get day10GrossPlan
     *
     * @return float 
     */
    public function getDay10GrossPlan()
    {
        return $this->day10GrossPlan;
    }

    /**
     * Set day10GrossReal
     *
     * @param float $day10GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay10GrossReal($day10GrossReal)
    {
        $this->day10GrossReal = $day10GrossReal;

        return $this;
    }

    /**
     * Get day10GrossReal
     *
     * @return float 
     */
    public function getDay10GrossReal()
    {
        return $this->day10GrossReal;
    }

    /**
     * Set day11GrossPlan
     *
     * @param float $day11GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay11GrossPlan($day11GrossPlan)
    {
        $this->day11GrossPlan = $day11GrossPlan;

        return $this;
    }

    /**
     * Get day11GrossPlan
     *
     * @return float 
     */
    public function getDay11GrossPlan()
    {
        return $this->day11GrossPlan;
    }

    /**
     * Set day11GrossReal
     *
     * @param float $day11GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay11GrossReal($day11GrossReal)
    {
        $this->day11GrossReal = $day11GrossReal;

        return $this;
    }

    /**
     * Get day11GrossReal
     *
     * @return float 
     */
    public function getDay11GrossReal()
    {
        return $this->day11GrossReal;
    }

    /**
     * Set day12GrossPlan
     *
     * @param float $day12GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay12GrossPlan($day12GrossPlan)
    {
        $this->day12GrossPlan = $day12GrossPlan;

        return $this;
    }

    /**
     * Get day12GrossPlan
     *
     * @return float 
     */
    public function getDay12GrossPlan()
    {
        return $this->day12GrossPlan;
    }

    /**
     * Set day12GrossReal
     *
     * @param float $day12GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay12GrossReal($day12GrossReal)
    {
        $this->day12GrossReal = $day12GrossReal;

        return $this;
    }

    /**
     * Get day12GrossReal
     *
     * @return float 
     */
    public function getDay12GrossReal()
    {
        return $this->day12GrossReal;
    }

    /**
     * Set day13GrossPlan
     *
     * @param float $day13GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay13GrossPlan($day13GrossPlan)
    {
        $this->day13GrossPlan = $day13GrossPlan;

        return $this;
    }

    /**
     * Get day13GrossPlan
     *
     * @return float 
     */
    public function getDay13GrossPlan()
    {
        return $this->day13GrossPlan;
    }

    /**
     * Set day13GrossReal
     *
     * @param float $day13GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay13GrossReal($day13GrossReal)
    {
        $this->day13GrossReal = $day13GrossReal;

        return $this;
    }

    /**
     * Get day13GrossReal
     *
     * @return float 
     */
    public function getDay13GrossReal()
    {
        return $this->day13GrossReal;
    }

    /**
     * Set day14GrossPlan
     *
     * @param float $day14GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay14GrossPlan($day14GrossPlan)
    {
        $this->day14GrossPlan = $day14GrossPlan;

        return $this;
    }

    /**
     * Get day14GrossPlan
     *
     * @return float 
     */
    public function getDay14GrossPlan()
    {
        return $this->day14GrossPlan;
    }

    /**
     * Set day14GrossReal
     *
     * @param float $day14GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay14GrossReal($day14GrossReal)
    {
        $this->day14GrossReal = $day14GrossReal;

        return $this;
    }

    /**
     * Get day14GrossReal
     *
     * @return float 
     */
    public function getDay14GrossReal()
    {
        return $this->day14GrossReal;
    }

    /**
     * Set day15GrossPlan
     *
     * @param float $day15GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay15GrossPlan($day15GrossPlan)
    {
        $this->day15GrossPlan = $day15GrossPlan;

        return $this;
    }

    /**
     * Get day15GrossPlan
     *
     * @return float 
     */
    public function getDay15GrossPlan()
    {
        return $this->day15GrossPlan;
    }

    /**
     * Set day15GrossReal
     *
     * @param float $day15GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay15GrossReal($day15GrossReal)
    {
        $this->day15GrossReal = $day15GrossReal;

        return $this;
    }

    /**
     * Get day15GrossReal
     *
     * @return float 
     */
    public function getDay15GrossReal()
    {
        return $this->day15GrossReal;
    }

    /**
     * Set day16GrossPlan
     *
     * @param float $day16GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay16GrossPlan($day16GrossPlan)
    {
        $this->day16GrossPlan = $day16GrossPlan;

        return $this;
    }

    /**
     * Get day16GrossPlan
     *
     * @return float 
     */
    public function getDay16GrossPlan()
    {
        return $this->day16GrossPlan;
    }

    /**
     * Set day16GrossReal
     *
     * @param float $day16GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay16GrossReal($day16GrossReal)
    {
        $this->day16GrossReal = $day16GrossReal;

        return $this;
    }

    /**
     * Get day16GrossReal
     *
     * @return float 
     */
    public function getDay16GrossReal()
    {
        return $this->day16GrossReal;
    }

    /**
     * Set day17GrossPlan
     *
     * @param float $day17GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay17GrossPlan($day17GrossPlan)
    {
        $this->day17GrossPlan = $day17GrossPlan;

        return $this;
    }

    /**
     * Get day17GrossPlan
     *
     * @return float 
     */
    public function getDay17GrossPlan()
    {
        return $this->day17GrossPlan;
    }

    /**
     * Set day17GrossReal
     *
     * @param float $day17GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay17GrossReal($day17GrossReal)
    {
        $this->day17GrossReal = $day17GrossReal;

        return $this;
    }

    /**
     * Get day17GrossReal
     *
     * @return float 
     */
    public function getDay17GrossReal()
    {
        return $this->day17GrossReal;
    }

    /**
     * Set day18GrossPlan
     *
     * @param float $day18GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay18GrossPlan($day18GrossPlan)
    {
        $this->day18GrossPlan = $day18GrossPlan;

        return $this;
    }

    /**
     * Get day18GrossPlan
     *
     * @return float 
     */
    public function getDay18GrossPlan()
    {
        return $this->day18GrossPlan;
    }

    /**
     * Set day18GrossReal
     *
     * @param float $day18GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay18GrossReal($day18GrossReal)
    {
        $this->day18GrossReal = $day18GrossReal;

        return $this;
    }

    /**
     * Get day18GrossReal
     *
     * @return float 
     */
    public function getDay18GrossReal()
    {
        return $this->day18GrossReal;
    }

    /**
     * Set day19GrossPlan
     *
     * @param float $day19GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay19GrossPlan($day19GrossPlan)
    {
        $this->day19GrossPlan = $day19GrossPlan;

        return $this;
    }

    /**
     * Get day19GrossPlan
     *
     * @return float 
     */
    public function getDay19GrossPlan()
    {
        return $this->day19GrossPlan;
    }

    /**
     * Set day19GrossReal
     *
     * @param float $day19GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay19GrossReal($day19GrossReal)
    {
        $this->day19GrossReal = $day19GrossReal;

        return $this;
    }

    /**
     * Get day19GrossReal
     *
     * @return float 
     */
    public function getDay19GrossReal()
    {
        return $this->day19GrossReal;
    }

    /**
     * Set day20GrossPlan
     *
     * @param float $day20GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay20GrossPlan($day20GrossPlan)
    {
        $this->day20GrossPlan = $day20GrossPlan;

        return $this;
    }

    /**
     * Get day20GrossPlan
     *
     * @return float 
     */
    public function getDay20GrossPlan()
    {
        return $this->day20GrossPlan;
    }

    /**
     * Set day20GrossReal
     *
     * @param float $day20GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay20GrossReal($day20GrossReal)
    {
        $this->day20GrossReal = $day20GrossReal;

        return $this;
    }

    /**
     * Get day20GrossReal
     *
     * @return float 
     */
    public function getDay20GrossReal()
    {
        return $this->day20GrossReal;
    }

    /**
     * Set day21GrossPlan
     *
     * @param float $day21GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay21GrossPlan($day21GrossPlan)
    {
        $this->day21GrossPlan = $day21GrossPlan;

        return $this;
    }

    /**
     * Get day21GrossPlan
     *
     * @return float 
     */
    public function getDay21GrossPlan()
    {
        return $this->day21GrossPlan;
    }

    /**
     * Set day21GrossReal
     *
     * @param float $day21GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay21GrossReal($day21GrossReal)
    {
        $this->day21GrossReal = $day21GrossReal;

        return $this;
    }

    /**
     * Get day21GrossReal
     *
     * @return float 
     */
    public function getDay21GrossReal()
    {
        return $this->day21GrossReal;
    }

    /**
     * Set day22GrossPlan
     *
     * @param float $day22GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay22GrossPlan($day22GrossPlan)
    {
        $this->day22GrossPlan = $day22GrossPlan;

        return $this;
    }

    /**
     * Get day22GrossPlan
     *
     * @return float 
     */
    public function getDay22GrossPlan()
    {
        return $this->day22GrossPlan;
    }

    /**
     * Set day22GrossReal
     *
     * @param float $day22GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay22GrossReal($day22GrossReal)
    {
        $this->day22GrossReal = $day22GrossReal;

        return $this;
    }

    /**
     * Get day22GrossReal
     *
     * @return float 
     */
    public function getDay22GrossReal()
    {
        return $this->day22GrossReal;
    }

    /**
     * Set day23GrossPlan
     *
     * @param float $day23GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay23GrossPlan($day23GrossPlan)
    {
        $this->day23GrossPlan = $day23GrossPlan;

        return $this;
    }

    /**
     * Get day23GrossPlan
     *
     * @return float 
     */
    public function getDay23GrossPlan()
    {
        return $this->day23GrossPlan;
    }

    /**
     * Set day23GrossReal
     *
     * @param float $day23GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay23GrossReal($day23GrossReal)
    {
        $this->day23GrossReal = $day23GrossReal;

        return $this;
    }

    /**
     * Get day23GrossReal
     *
     * @return float 
     */
    public function getDay23GrossReal()
    {
        return $this->day23GrossReal;
    }

    /**
     * Set day24GrossPlan
     *
     * @param float $day24GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay24GrossPlan($day24GrossPlan)
    {
        $this->day24GrossPlan = $day24GrossPlan;

        return $this;
    }

    /**
     * Get day24GrossPlan
     *
     * @return float 
     */
    public function getDay24GrossPlan()
    {
        return $this->day24GrossPlan;
    }

    /**
     * Set day24GrossReal
     *
     * @param float $day24GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay24GrossReal($day24GrossReal)
    {
        $this->day24GrossReal = $day24GrossReal;

        return $this;
    }

    /**
     * Get day24GrossReal
     *
     * @return float 
     */
    public function getDay24GrossReal()
    {
        return $this->day24GrossReal;
    }

    /**
     * Set day25GrossPlan
     *
     * @param float $day25GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay25GrossPlan($day25GrossPlan)
    {
        $this->day25GrossPlan = $day25GrossPlan;

        return $this;
    }

    /**
     * Get day25GrossPlan
     *
     * @return float 
     */
    public function getDay25GrossPlan()
    {
        return $this->day25GrossPlan;
    }

    /**
     * Set day25GrossReal
     *
     * @param float $day25GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay25GrossReal($day25GrossReal)
    {
        $this->day25GrossReal = $day25GrossReal;

        return $this;
    }

    /**
     * Get day25GrossReal
     *
     * @return float 
     */
    public function getDay25GrossReal()
    {
        return $this->day25GrossReal;
    }

    /**
     * Set day26GrossPlan
     *
     * @param float $day26GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay26GrossPlan($day26GrossPlan)
    {
        $this->day26GrossPlan = $day26GrossPlan;

        return $this;
    }

    /**
     * Get day26GrossPlan
     *
     * @return float 
     */
    public function getDay26GrossPlan()
    {
        return $this->day26GrossPlan;
    }

    /**
     * Set day26GrossReal
     *
     * @param float $day26GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay26GrossReal($day26GrossReal)
    {
        $this->day26GrossReal = $day26GrossReal;

        return $this;
    }

    /**
     * Get day26GrossReal
     *
     * @return float 
     */
    public function getDay26GrossReal()
    {
        return $this->day26GrossReal;
    }

    /**
     * Set day27GrossPlan
     *
     * @param float $day27GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay27GrossPlan($day27GrossPlan)
    {
        $this->day27GrossPlan = $day27GrossPlan;

        return $this;
    }

    /**
     * Get day27GrossPlan
     *
     * @return float 
     */
    public function getDay27GrossPlan()
    {
        return $this->day27GrossPlan;
    }

    /**
     * Set day27GrossReal
     *
     * @param float $day27GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay27GrossReal($day27GrossReal)
    {
        $this->day27GrossReal = $day27GrossReal;

        return $this;
    }

    /**
     * Get day27GrossReal
     *
     * @return float 
     */
    public function getDay27GrossReal()
    {
        return $this->day27GrossReal;
    }

    /**
     * Set day28GrossPlan
     *
     * @param float $day28GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay28GrossPlan($day28GrossPlan)
    {
        $this->day28GrossPlan = $day28GrossPlan;

        return $this;
    }

    /**
     * Get day28GrossPlan
     *
     * @return float 
     */
    public function getDay28GrossPlan()
    {
        return $this->day28GrossPlan;
    }

    /**
     * Set day28GrossReal
     *
     * @param float $day28GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay28GrossReal($day28GrossReal)
    {
        $this->day28GrossReal = $day28GrossReal;

        return $this;
    }

    /**
     * Get day28GrossReal
     *
     * @return float 
     */
    public function getDay28GrossReal()
    {
        return $this->day28GrossReal;
    }

    /**
     * Set day29GrossPlan
     *
     * @param float $day29GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay29GrossPlan($day29GrossPlan)
    {
        $this->day29GrossPlan = $day29GrossPlan;

        return $this;
    }

    /**
     * Get day29GrossPlan
     *
     * @return float 
     */
    public function getDay29GrossPlan()
    {
        return $this->day29GrossPlan;
    }

    /**
     * Set day29GrossReal
     *
     * @param float $day29GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay29GrossReal($day29GrossReal)
    {
        $this->day29GrossReal = $day29GrossReal;

        return $this;
    }

    /**
     * Get day29GrossReal
     *
     * @return float 
     */
    public function getDay29GrossReal()
    {
        return $this->day29GrossReal;
    }

    /**
     * Set day30GrossPlan
     *
     * @param float $day30GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay30GrossPlan($day30GrossPlan)
    {
        $this->day30GrossPlan = $day30GrossPlan;

        return $this;
    }

    /**
     * Get day30GrossPlan
     *
     * @return float 
     */
    public function getDay30GrossPlan()
    {
        return $this->day30GrossPlan;
    }

    /**
     * Set day30GrossReal
     *
     * @param float $day30GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay30GrossReal($day30GrossReal)
    {
        $this->day30GrossReal = $day30GrossReal;

        return $this;
    }

    /**
     * Get day30GrossReal
     *
     * @return float 
     */
    public function getDay30GrossReal()
    {
        return $this->day30GrossReal;
    }

    /**
     * Set day31GrossPlan
     *
     * @param float $day31GrossPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay31GrossPlan($day31GrossPlan)
    {
        $this->day31GrossPlan = $day31GrossPlan;

        return $this;
    }

    /**
     * Get day31GrossPlan
     *
     * @return float 
     */
    public function getDay31GrossPlan()
    {
        return $this->day31GrossPlan;
    }

    /**
     * Set day31GrossReal
     *
     * @param float $day31GrossReal
     * @return ProductDetailDailyMonth
     */
    public function setDay31GrossReal($day31GrossReal)
    {
        $this->day31GrossReal = $day31GrossReal;

        return $this;
    }

    /**
     * Get day31GrossReal
     *
     * @return float 
     */
    public function getDay31GrossReal()
    {
        return $this->day31GrossReal;
    }

    /**
     * Set day1NetPlan
     *
     * @param float $day1NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay1NetPlan($day1NetPlan)
    {
        $this->day1NetPlan = $day1NetPlan;

        return $this;
    }

    /**
     * Get day1NetPlan
     *
     * @return float 
     */
    public function getDay1NetPlan()
    {
        return $this->day1NetPlan;
    }

    /**
     * Set day1NetReal
     *
     * @param float $day1NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay1NetReal($day1NetReal)
    {
        $this->day1NetReal = $day1NetReal;

        return $this;
    }

    /**
     * Get day1NetReal
     *
     * @return float 
     */
    public function getDay1NetReal()
    {
        return $this->day1NetReal;
    }

    /**
     * Set day2NetPlan
     *
     * @param float $day2NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay2NetPlan($day2NetPlan)
    {
        $this->day2NetPlan = $day2NetPlan;

        return $this;
    }

    /**
     * Get day2NetPlan
     *
     * @return float 
     */
    public function getDay2NetPlan()
    {
        return $this->day2NetPlan;
    }

    /**
     * Set day2NetReal
     *
     * @param float $day2NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay2NetReal($day2NetReal)
    {
        $this->day2NetReal = $day2NetReal;

        return $this;
    }

    /**
     * Get day2NetReal
     *
     * @return float 
     */
    public function getDay2NetReal()
    {
        return $this->day2NetReal;
    }

    /**
     * Set day3NetPlan
     *
     * @param float $day3NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay3NetPlan($day3NetPlan)
    {
        $this->day3NetPlan = $day3NetPlan;

        return $this;
    }

    /**
     * Get day3NetPlan
     *
     * @return float 
     */
    public function getDay3NetPlan()
    {
        return $this->day3NetPlan;
    }

    /**
     * Set day3NetReal
     *
     * @param float $day3NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay3NetReal($day3NetReal)
    {
        $this->day3NetReal = $day3NetReal;

        return $this;
    }

    /**
     * Get day3NetReal
     *
     * @return float 
     */
    public function getDay3NetReal()
    {
        return $this->day3NetReal;
    }

    /**
     * Set day4NetPlan
     *
     * @param float $day4NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay4NetPlan($day4NetPlan)
    {
        $this->day4NetPlan = $day4NetPlan;

        return $this;
    }

    /**
     * Get day4NetPlan
     *
     * @return float 
     */
    public function getDay4NetPlan()
    {
        return $this->day4NetPlan;
    }

    /**
     * Set day4NetReal
     *
     * @param float $day4NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay4NetReal($day4NetReal)
    {
        $this->day4NetReal = $day4NetReal;

        return $this;
    }

    /**
     * Get day4NetReal
     *
     * @return float 
     */
    public function getDay4NetReal()
    {
        return $this->day4NetReal;
    }

    /**
     * Set day5NetPlan
     *
     * @param float $day5NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay5NetPlan($day5NetPlan)
    {
        $this->day5NetPlan = $day5NetPlan;

        return $this;
    }

    /**
     * Get day5NetPlan
     *
     * @return float 
     */
    public function getDay5NetPlan()
    {
        return $this->day5NetPlan;
    }

    /**
     * Set day5NetReal
     *
     * @param float $day5NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay5NetReal($day5NetReal)
    {
        $this->day5NetReal = $day5NetReal;

        return $this;
    }

    /**
     * Get day5NetReal
     *
     * @return float 
     */
    public function getDay5NetReal()
    {
        return $this->day5NetReal;
    }

    /**
     * Set day6NetPlan
     *
     * @param float $day6NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay6NetPlan($day6NetPlan)
    {
        $this->day6NetPlan = $day6NetPlan;

        return $this;
    }

    /**
     * Get day6NetPlan
     *
     * @return float 
     */
    public function getDay6NetPlan()
    {
        return $this->day6NetPlan;
    }

    /**
     * Set day6NetReal
     *
     * @param float $day6NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay6NetReal($day6NetReal)
    {
        $this->day6NetReal = $day6NetReal;

        return $this;
    }

    /**
     * Get day6NetReal
     *
     * @return float 
     */
    public function getDay6NetReal()
    {
        return $this->day6NetReal;
    }

    /**
     * Set day7NetPlan
     *
     * @param float $day7NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay7NetPlan($day7NetPlan)
    {
        $this->day7NetPlan = $day7NetPlan;

        return $this;
    }

    /**
     * Get day7NetPlan
     *
     * @return float 
     */
    public function getDay7NetPlan()
    {
        return $this->day7NetPlan;
    }

    /**
     * Set day7NetReal
     *
     * @param float $day7NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay7NetReal($day7NetReal)
    {
        $this->day7NetReal = $day7NetReal;

        return $this;
    }

    /**
     * Get day7NetReal
     *
     * @return float 
     */
    public function getDay7NetReal()
    {
        return $this->day7NetReal;
    }

    /**
     * Set day8NetPlan
     *
     * @param float $day8NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay8NetPlan($day8NetPlan)
    {
        $this->day8NetPlan = $day8NetPlan;

        return $this;
    }

    /**
     * Get day8NetPlan
     *
     * @return float 
     */
    public function getDay8NetPlan()
    {
        return $this->day8NetPlan;
    }

    /**
     * Set day8NetReal
     *
     * @param float $day8NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay8NetReal($day8NetReal)
    {
        $this->day8NetReal = $day8NetReal;

        return $this;
    }

    /**
     * Get day8NetReal
     *
     * @return float 
     */
    public function getDay8NetReal()
    {
        return $this->day8NetReal;
    }

    /**
     * Set day9NetPlan
     *
     * @param float $day9NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay9NetPlan($day9NetPlan)
    {
        $this->day9NetPlan = $day9NetPlan;

        return $this;
    }

    /**
     * Get day9NetPlan
     *
     * @return float 
     */
    public function getDay9NetPlan()
    {
        return $this->day9NetPlan;
    }

    /**
     * Set day9NetReal
     *
     * @param float $day9NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay9NetReal($day9NetReal)
    {
        $this->day9NetReal = $day9NetReal;

        return $this;
    }

    /**
     * Get day9NetReal
     *
     * @return float 
     */
    public function getDay9NetReal()
    {
        return $this->day9NetReal;
    }

    /**
     * Set day10NetPlan
     *
     * @param float $day10NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay10NetPlan($day10NetPlan)
    {
        $this->day10NetPlan = $day10NetPlan;

        return $this;
    }

    /**
     * Get day10NetPlan
     *
     * @return float 
     */
    public function getDay10NetPlan()
    {
        return $this->day10NetPlan;
    }

    /**
     * Set day10NetReal
     *
     * @param float $day10NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay10NetReal($day10NetReal)
    {
        $this->day10NetReal = $day10NetReal;

        return $this;
    }

    /**
     * Get day10NetReal
     *
     * @return float 
     */
    public function getDay10NetReal()
    {
        return $this->day10NetReal;
    }

    /**
     * Set day11NetPlan
     *
     * @param float $day11NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay11NetPlan($day11NetPlan)
    {
        $this->day11NetPlan = $day11NetPlan;

        return $this;
    }

    /**
     * Get day11NetPlan
     *
     * @return float 
     */
    public function getDay11NetPlan()
    {
        return $this->day11NetPlan;
    }

    /**
     * Set day11NetReal
     *
     * @param float $day11NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay11NetReal($day11NetReal)
    {
        $this->day11NetReal = $day11NetReal;

        return $this;
    }

    /**
     * Get day11NetReal
     *
     * @return float 
     */
    public function getDay11NetReal()
    {
        return $this->day11NetReal;
    }

    /**
     * Set day12NetPlan
     *
     * @param float $day12NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay12NetPlan($day12NetPlan)
    {
        $this->day12NetPlan = $day12NetPlan;

        return $this;
    }

    /**
     * Get day12NetPlan
     *
     * @return float 
     */
    public function getDay12NetPlan()
    {
        return $this->day12NetPlan;
    }

    /**
     * Set day12NetReal
     *
     * @param float $day12NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay12NetReal($day12NetReal)
    {
        $this->day12NetReal = $day12NetReal;

        return $this;
    }

    /**
     * Get day12NetReal
     *
     * @return float 
     */
    public function getDay12NetReal()
    {
        return $this->day12NetReal;
    }

    /**
     * Set day13NetPlan
     *
     * @param float $day13NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay13NetPlan($day13NetPlan)
    {
        $this->day13NetPlan = $day13NetPlan;

        return $this;
    }

    /**
     * Get day13NetPlan
     *
     * @return float 
     */
    public function getDay13NetPlan()
    {
        return $this->day13NetPlan;
    }

    /**
     * Set day13NetReal
     *
     * @param float $day13NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay13NetReal($day13NetReal)
    {
        $this->day13NetReal = $day13NetReal;

        return $this;
    }

    /**
     * Get day13NetReal
     *
     * @return float 
     */
    public function getDay13NetReal()
    {
        return $this->day13NetReal;
    }

    /**
     * Set day14NetPlan
     *
     * @param float $day14NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay14NetPlan($day14NetPlan)
    {
        $this->day14NetPlan = $day14NetPlan;

        return $this;
    }

    /**
     * Get day14NetPlan
     *
     * @return float 
     */
    public function getDay14NetPlan()
    {
        return $this->day14NetPlan;
    }

    /**
     * Set day14NetReal
     *
     * @param float $day14NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay14NetReal($day14NetReal)
    {
        $this->day14NetReal = $day14NetReal;

        return $this;
    }

    /**
     * Get day14NetReal
     *
     * @return float 
     */
    public function getDay14NetReal()
    {
        return $this->day14NetReal;
    }

    /**
     * Set day15NetPlan
     *
     * @param float $day15NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay15NetPlan($day15NetPlan)
    {
        $this->day15NetPlan = $day15NetPlan;

        return $this;
    }

    /**
     * Get day15NetPlan
     *
     * @return float 
     */
    public function getDay15NetPlan()
    {
        return $this->day15NetPlan;
    }

    /**
     * Set day15NetReal
     *
     * @param float $day15NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay15NetReal($day15NetReal)
    {
        $this->day15NetReal = $day15NetReal;

        return $this;
    }

    /**
     * Get day15NetReal
     *
     * @return float 
     */
    public function getDay15NetReal()
    {
        return $this->day15NetReal;
    }

    /**
     * Set day16NetPlan
     *
     * @param float $day16NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay16NetPlan($day16NetPlan)
    {
        $this->day16NetPlan = $day16NetPlan;

        return $this;
    }

    /**
     * Get day16NetPlan
     *
     * @return float 
     */
    public function getDay16NetPlan()
    {
        return $this->day16NetPlan;
    }

    /**
     * Set day16NetReal
     *
     * @param float $day16NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay16NetReal($day16NetReal)
    {
        $this->day16NetReal = $day16NetReal;

        return $this;
    }

    /**
     * Get day16NetReal
     *
     * @return float 
     */
    public function getDay16NetReal()
    {
        return $this->day16NetReal;
    }

    /**
     * Set day17NetPlan
     *
     * @param float $day17NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay17NetPlan($day17NetPlan)
    {
        $this->day17NetPlan = $day17NetPlan;

        return $this;
    }

    /**
     * Get day17NetPlan
     *
     * @return float 
     */
    public function getDay17NetPlan()
    {
        return $this->day17NetPlan;
    }

    /**
     * Set day17NetReal
     *
     * @param float $day17NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay17NetReal($day17NetReal)
    {
        $this->day17NetReal = $day17NetReal;

        return $this;
    }

    /**
     * Get day17NetReal
     *
     * @return float 
     */
    public function getDay17NetReal()
    {
        return $this->day17NetReal;
    }

    /**
     * Set day18NetPlan
     *
     * @param float $day18NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay18NetPlan($day18NetPlan)
    {
        $this->day18NetPlan = $day18NetPlan;

        return $this;
    }

    /**
     * Get day18NetPlan
     *
     * @return float 
     */
    public function getDay18NetPlan()
    {
        return $this->day18NetPlan;
    }

    /**
     * Set day18NetReal
     *
     * @param float $day18NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay18NetReal($day18NetReal)
    {
        $this->day18NetReal = $day18NetReal;

        return $this;
    }

    /**
     * Get day18NetReal
     *
     * @return float 
     */
    public function getDay18NetReal()
    {
        return $this->day18NetReal;
    }

    /**
     * Set day19NetPlan
     *
     * @param float $day19NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay19NetPlan($day19NetPlan)
    {
        $this->day19NetPlan = $day19NetPlan;

        return $this;
    }

    /**
     * Get day19NetPlan
     *
     * @return float 
     */
    public function getDay19NetPlan()
    {
        return $this->day19NetPlan;
    }

    /**
     * Set day19NetReal
     *
     * @param float $day19NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay19NetReal($day19NetReal)
    {
        $this->day19NetReal = $day19NetReal;

        return $this;
    }

    /**
     * Get day19NetReal
     *
     * @return float 
     */
    public function getDay19NetReal()
    {
        return $this->day19NetReal;
    }

    /**
     * Set day20NetPlan
     *
     * @param float $day20NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay20NetPlan($day20NetPlan)
    {
        $this->day20NetPlan = $day20NetPlan;

        return $this;
    }

    /**
     * Get day20NetPlan
     *
     * @return float 
     */
    public function getDay20NetPlan()
    {
        return $this->day20NetPlan;
    }

    /**
     * Set day20NetReal
     *
     * @param float $day20NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay20NetReal($day20NetReal)
    {
        $this->day20NetReal = $day20NetReal;

        return $this;
    }

    /**
     * Get day20NetReal
     *
     * @return float 
     */
    public function getDay20NetReal()
    {
        return $this->day20NetReal;
    }

    /**
     * Set day21NetPlan
     *
     * @param float $day21NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay21NetPlan($day21NetPlan)
    {
        $this->day21NetPlan = $day21NetPlan;

        return $this;
    }

    /**
     * Get day21NetPlan
     *
     * @return float 
     */
    public function getDay21NetPlan()
    {
        return $this->day21NetPlan;
    }

    /**
     * Set day21NetReal
     *
     * @param float $day21NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay21NetReal($day21NetReal)
    {
        $this->day21NetReal = $day21NetReal;

        return $this;
    }

    /**
     * Get day21NetReal
     *
     * @return float 
     */
    public function getDay21NetReal()
    {
        return $this->day21NetReal;
    }

    /**
     * Set day22NetPlan
     *
     * @param float $day22NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay22NetPlan($day22NetPlan)
    {
        $this->day22NetPlan = $day22NetPlan;

        return $this;
    }

    /**
     * Get day22NetPlan
     *
     * @return float 
     */
    public function getDay22NetPlan()
    {
        return $this->day22NetPlan;
    }

    /**
     * Set day22NetReal
     *
     * @param float $day22NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay22NetReal($day22NetReal)
    {
        $this->day22NetReal = $day22NetReal;

        return $this;
    }

    /**
     * Get day22NetReal
     *
     * @return float 
     */
    public function getDay22NetReal()
    {
        return $this->day22NetReal;
    }

    /**
     * Set day23NetPlan
     *
     * @param float $day23NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay23NetPlan($day23NetPlan)
    {
        $this->day23NetPlan = $day23NetPlan;

        return $this;
    }

    /**
     * Get day23NetPlan
     *
     * @return float 
     */
    public function getDay23NetPlan()
    {
        return $this->day23NetPlan;
    }

    /**
     * Set day23NetReal
     *
     * @param float $day23NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay23NetReal($day23NetReal)
    {
        $this->day23NetReal = $day23NetReal;

        return $this;
    }

    /**
     * Get day23NetReal
     *
     * @return float 
     */
    public function getDay23NetReal()
    {
        return $this->day23NetReal;
    }

    /**
     * Set day24NetPlan
     *
     * @param float $day24NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay24NetPlan($day24NetPlan)
    {
        $this->day24NetPlan = $day24NetPlan;

        return $this;
    }

    /**
     * Get day24NetPlan
     *
     * @return float 
     */
    public function getDay24NetPlan()
    {
        return $this->day24NetPlan;
    }

    /**
     * Set day24NetReal
     *
     * @param float $day24NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay24NetReal($day24NetReal)
    {
        $this->day24NetReal = $day24NetReal;

        return $this;
    }

    /**
     * Get day24NetReal
     *
     * @return float 
     */
    public function getDay24NetReal()
    {
        return $this->day24NetReal;
    }

    /**
     * Set day25NetPlan
     *
     * @param float $day25NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay25NetPlan($day25NetPlan)
    {
        $this->day25NetPlan = $day25NetPlan;

        return $this;
    }

    /**
     * Get day25NetPlan
     *
     * @return float 
     */
    public function getDay25NetPlan()
    {
        return $this->day25NetPlan;
    }

    /**
     * Set day25NetReal
     *
     * @param float $day25NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay25NetReal($day25NetReal)
    {
        $this->day25NetReal = $day25NetReal;

        return $this;
    }

    /**
     * Get day25NetReal
     *
     * @return float 
     */
    public function getDay25NetReal()
    {
        return $this->day25NetReal;
    }

    /**
     * Set day26NetPlan
     *
     * @param float $day26NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay26NetPlan($day26NetPlan)
    {
        $this->day26NetPlan = $day26NetPlan;

        return $this;
    }

    /**
     * Get day26NetPlan
     *
     * @return float 
     */
    public function getDay26NetPlan()
    {
        return $this->day26NetPlan;
    }

    /**
     * Set day26NetReal
     *
     * @param float $day26NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay26NetReal($day26NetReal)
    {
        $this->day26NetReal = $day26NetReal;

        return $this;
    }

    /**
     * Get day26NetReal
     *
     * @return float 
     */
    public function getDay26NetReal()
    {
        return $this->day26NetReal;
    }

    /**
     * Set day27NetPlan
     *
     * @param float $day27NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay27NetPlan($day27NetPlan)
    {
        $this->day27NetPlan = $day27NetPlan;

        return $this;
    }

    /**
     * Get day27NetPlan
     *
     * @return float 
     */
    public function getDay27NetPlan()
    {
        return $this->day27NetPlan;
    }

    /**
     * Set day27NetReal
     *
     * @param float $day27NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay27NetReal($day27NetReal)
    {
        $this->day27NetReal = $day27NetReal;

        return $this;
    }

    /**
     * Get day27NetReal
     *
     * @return float 
     */
    public function getDay27NetReal()
    {
        return $this->day27NetReal;
    }

    /**
     * Set day28NetPlan
     *
     * @param float $day28NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay28NetPlan($day28NetPlan)
    {
        $this->day28NetPlan = $day28NetPlan;

        return $this;
    }

    /**
     * Get day28NetPlan
     *
     * @return float 
     */
    public function getDay28NetPlan()
    {
        return $this->day28NetPlan;
    }

    /**
     * Set day28NetReal
     *
     * @param float $day28NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay28NetReal($day28NetReal)
    {
        $this->day28NetReal = $day28NetReal;

        return $this;
    }

    /**
     * Get day28NetReal
     *
     * @return float 
     */
    public function getDay28NetReal()
    {
        return $this->day28NetReal;
    }

    /**
     * Set day29NetPlan
     *
     * @param float $day29NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay29NetPlan($day29NetPlan)
    {
        $this->day29NetPlan = $day29NetPlan;

        return $this;
    }

    /**
     * Get day29NetPlan
     *
     * @return float 
     */
    public function getDay29NetPlan()
    {
        return $this->day29NetPlan;
    }

    /**
     * Set day29NetReal
     *
     * @param float $day29NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay29NetReal($day29NetReal)
    {
        $this->day29NetReal = $day29NetReal;

        return $this;
    }

    /**
     * Get day29NetReal
     *
     * @return float 
     */
    public function getDay29NetReal()
    {
        return $this->day29NetReal;
    }

    /**
     * Set day30NetPlan
     *
     * @param float $day30NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay30NetPlan($day30NetPlan)
    {
        $this->day30NetPlan = $day30NetPlan;

        return $this;
    }

    /**
     * Get day30NetPlan
     *
     * @return float 
     */
    public function getDay30NetPlan()
    {
        return $this->day30NetPlan;
    }

    /**
     * Set day30NetReal
     *
     * @param float $day30NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay30NetReal($day30NetReal)
    {
        $this->day30NetReal = $day30NetReal;

        return $this;
    }

    /**
     * Get day30NetReal
     *
     * @return float 
     */
    public function getDay30NetReal()
    {
        return $this->day30NetReal;
    }

    /**
     * Set day31NetPlan
     *
     * @param float $day31NetPlan
     * @return ProductDetailDailyMonth
     */
    public function setDay31NetPlan($day31NetPlan)
    {
        $this->day31NetPlan = $day31NetPlan;

        return $this;
    }

    /**
     * Get day31NetPlan
     *
     * @return float 
     */
    public function getDay31NetPlan()
    {
        return $this->day31NetPlan;
    }

    /**
     * Set day31NetReal
     *
     * @param float $day31NetReal
     * @return ProductDetailDailyMonth
     */
    public function setDay31NetReal($day31NetReal)
    {
        $this->day31NetReal = $day31NetReal;

        return $this;
    }

    /**
     * Get day31NetReal
     *
     * @return float 
     */
    public function getDay31NetReal()
    {
        return $this->day31NetReal;
    }

    /**
     * Metodo que se ejecuta antes de actualizar la entidad
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function preUpdate()
    {
        $this->totalizeByType("Gross");
        $this->totalizeByType("Net");
//        die;
    }
    
    private function totalizeByType($prefix) 
    {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        
        $nameMatchReal = '^getDay\w+'.$prefix.'Real$';
        $nameMatchPlan = '^getDay\w+'.$prefix.'Plan$';
        
        $totalReal = $totalPlan = 0.0;
        foreach ($methods as $method) {
            $methodName = $method->getName();
            $class = $method->getDeclaringClass();
            if(!strpos($class, 'Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth')){
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
        
        $methodTotalPlan = "setTotal".$prefix."Plan";
        $methodTotalReal = "setTotal".$prefix."Real";
        $methodPercentage = "set".$prefix."Percentage";
        
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
    }
    
    public function __toString() {
        $_toString = "";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
    }
}
