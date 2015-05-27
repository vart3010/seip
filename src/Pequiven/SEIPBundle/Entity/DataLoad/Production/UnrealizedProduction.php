<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\DetailValue;

/**
 * Produccion no realizada (PNR)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class UnrealizedProduction extends DetailValue
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
     * Dia 1 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day1Details;
    
    /**
     * Dia 2 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day2Details;
    
    /**
     * Dia 3 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day3Details;
    
    /**
     * Dia 4 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day4Details;
    
    /**
     * Dia 5 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day5Details;
    
    /**
     * Dia 6 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day6Details;
        
    /**
     * Dia 7 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day7Details;
    
    /**
     * Dia 8 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day8Details;
    
    /**
     * Dia 9 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day9Details;
    
    /**
     * Dia 10 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day10Details;
    
    /**
     * Dia 11 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day11Details;
    
    /**
     * Dia 12 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day12Details;
    
    /**
     * Dia 13 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day13Details;
    
    /**
     * Dia 14 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day14Details;
    
    /**
     * Dia 15 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day15Details;
    
    /**
     * Dia 16 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day16Details;
    
    /**
     * Dia 17 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day17Details;
    
    /**
     * Dia 18 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day18Details;
    
    /**
     * Dia 19 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day19Details;
    
    /**
     * Dia 20 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day20Details;
    
    /**
     * Dia 21 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day21Details;
    
    /**
     * Dia 22 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day22Details;
    
    /**
     * Dia 23 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day23Details;
    
    /**
     * Dia 24 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day24Details;
    
    /**
     * Dia 25 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day25Details;
    
    /**
     * Dia 26 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day26Details;
    
    /**
     * Dia 27 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day27Details;
    
    /**
     * Dia 28 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day28Details;
    
    /**
     * Dia 29 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day29Details;
    
    /**
     * Dia 30 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day30Details;
    
    /**
     * Dia 31 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay")
     */
    protected $day31Details;
    
    /**
     * Reporte de planta
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="unrealizedProductions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $productReport;

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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate()
    {
        parent::calculate();
    }
}
