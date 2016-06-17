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
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\Production\UnrealizedProductionRepository")
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
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day1Details;

    /**
     * Dia 2 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day2Details;

    /**
     * Dia 3 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day3Details;

    /**
     * Dia 4 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day4Details;

    /**
     * Dia 5 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day5Details;

    /**
     * Dia 6 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day6Details;

    /**
     * Dia 7 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day7Details;

    /**
     * Dia 8 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day8Details;

    /**
     * Dia 9 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day9Details;

    /**
     * Dia 10 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day10Details;

    /**
     * Dia 11 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day11Details;

    /**
     * Dia 12 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day12Details;

    /**
     * Dia 13 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day13Details;

    /**
     * Dia 14 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day14Details;

    /**
     * Dia 15 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day15Details;

    /**
     * Dia 16 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day16Details;

    /**
     * Dia 17 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day17Details;

    /**
     * Dia 18 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day18Details;

    /**
     * Dia 19 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day19Details;

    /**
     * Dia 20 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day20Details;

    /**
     * Dia 21 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day21Details;

    /**
     * Dia 22 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day22Details;

    /**
     * Dia 23 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day23Details;

    /**
     * Dia 24 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day24Details;

    /**
     * Dia 25 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day25Details;

    /**
     * Dia 26 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day26Details;

    /**
     * Dia 27 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day27Details;

    /**
     * Dia 28 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day28Details;

    /**
     * Dia 29 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day29Details;

    /**
     * Dia 30 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
     */
    protected $day30Details;

    /**
     * Dia 31 (Detalles de PNR)
     * @var UnrealizedProductionDay
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay",cascade={"persist","remove"})
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
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set day1Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day1Details
     * @return UnrealizedProduction
     */
    public function setDay1Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day1Details = null) {
        $this->day1Details = $day1Details;

        return $this;
    }

    /**
     * Get day1Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay1Details() {
        return $this->day1Details;
    }

    /**
     * Set day2Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day2Details
     * @return UnrealizedProduction
     */
    public function setDay2Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day2Details = null) {
        $this->day2Details = $day2Details;

        return $this;
    }

    /**
     * Get day2Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay2Details() {
        return $this->day2Details;
    }

    /**
     * Set day3Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day3Details
     * @return UnrealizedProduction
     */
    public function setDay3Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day3Details = null) {
        $this->day3Details = $day3Details;

        return $this;
    }

    /**
     * Get day3Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay3Details() {
        return $this->day3Details;
    }

    /**
     * Set day4Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day4Details
     * @return UnrealizedProduction
     */
    public function setDay4Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day4Details = null) {
        $this->day4Details = $day4Details;

        return $this;
    }

    /**
     * Get day4Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay4Details() {
        return $this->day4Details;
    }

    /**
     * Set day5Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day5Details
     * @return UnrealizedProduction
     */
    public function setDay5Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day5Details = null) {
        $this->day5Details = $day5Details;

        return $this;
    }

    /**
     * Get day5Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay5Details() {
        return $this->day5Details;
    }

    /**
     * Set day6Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day6Details
     * @return UnrealizedProduction
     */
    public function setDay6Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day6Details = null) {
        $this->day6Details = $day6Details;

        return $this;
    }

    /**
     * Get day6Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay6Details() {
        return $this->day6Details;
    }

    /**
     * Set day7Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day7Details
     * @return UnrealizedProduction
     */
    public function setDay7Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day7Details = null) {
        $this->day7Details = $day7Details;

        return $this;
    }

    /**
     * Get day7Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay7Details() {
        return $this->day7Details;
    }

    /**
     * Set day8Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day8Details
     * @return UnrealizedProduction
     */
    public function setDay8Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day8Details = null) {
        $this->day8Details = $day8Details;

        return $this;
    }

    /**
     * Get day8Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay8Details() {
        return $this->day8Details;
    }

    /**
     * Set day9Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day9Details
     * @return UnrealizedProduction
     */
    public function setDay9Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day9Details = null) {
        $this->day9Details = $day9Details;

        return $this;
    }

    /**
     * Get day9Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay9Details() {
        return $this->day9Details;
    }

    /**
     * Set day10Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day10Details
     * @return UnrealizedProduction
     */
    public function setDay10Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day10Details = null) {
        $this->day10Details = $day10Details;

        return $this;
    }

    /**
     * Get day10Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay10Details() {
        return $this->day10Details;
    }

    /**
     * Set day11Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day11Details
     * @return UnrealizedProduction
     */
    public function setDay11Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day11Details = null) {
        $this->day11Details = $day11Details;

        return $this;
    }

    /**
     * Get day11Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay11Details() {
        return $this->day11Details;
    }

    /**
     * Set day12Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day12Details
     * @return UnrealizedProduction
     */
    public function setDay12Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day12Details = null) {
        $this->day12Details = $day12Details;

        return $this;
    }

    /**
     * Get day12Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay12Details() {
        return $this->day12Details;
    }

    /**
     * Set day13Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day13Details
     * @return UnrealizedProduction
     */
    public function setDay13Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day13Details = null) {
        $this->day13Details = $day13Details;

        return $this;
    }

    /**
     * Get day13Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay13Details() {
        return $this->day13Details;
    }

    /**
     * Set day14Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day14Details
     * @return UnrealizedProduction
     */
    public function setDay14Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day14Details = null) {
        $this->day14Details = $day14Details;

        return $this;
    }

    /**
     * Get day14Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay14Details() {
        return $this->day14Details;
    }

    /**
     * Set day15Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day15Details
     * @return UnrealizedProduction
     */
    public function setDay15Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day15Details = null) {
        $this->day15Details = $day15Details;

        return $this;
    }

    /**
     * Get day15Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay15Details() {
        return $this->day15Details;
    }

    /**
     * Set day16Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day16Details
     * @return UnrealizedProduction
     */
    public function setDay16Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day16Details = null) {
        $this->day16Details = $day16Details;

        return $this;
    }

    /**
     * Get day16Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay16Details() {
        return $this->day16Details;
    }

    /**
     * Set day17Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day17Details
     * @return UnrealizedProduction
     */
    public function setDay17Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day17Details = null) {
        $this->day17Details = $day17Details;

        return $this;
    }

    /**
     * Get day17Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay17Details() {
        return $this->day17Details;
    }

    /**
     * Set day18Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day18Details
     * @return UnrealizedProduction
     */
    public function setDay18Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day18Details = null) {
        $this->day18Details = $day18Details;

        return $this;
    }

    /**
     * Get day18Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay18Details() {
        return $this->day18Details;
    }

    /**
     * Set day19Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day19Details
     * @return UnrealizedProduction
     */
    public function setDay19Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day19Details = null) {
        $this->day19Details = $day19Details;

        return $this;
    }

    /**
     * Get day19Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay19Details() {
        return $this->day19Details;
    }

    /**
     * Set day20Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day20Details
     * @return UnrealizedProduction
     */
    public function setDay20Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day20Details = null) {
        $this->day20Details = $day20Details;

        return $this;
    }

    /**
     * Get day20Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay20Details() {
        return $this->day20Details;
    }

    /**
     * Set day21Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day21Details
     * @return UnrealizedProduction
     */
    public function setDay21Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day21Details = null) {
        $this->day21Details = $day21Details;

        return $this;
    }

    /**
     * Get day21Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay21Details() {
        return $this->day21Details;
    }

    /**
     * Set day22Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day22Details
     * @return UnrealizedProduction
     */
    public function setDay22Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day22Details = null) {
        $this->day22Details = $day22Details;

        return $this;
    }

    /**
     * Get day22Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay22Details() {
        return $this->day22Details;
    }

    /**
     * Set day23Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day23Details
     * @return UnrealizedProduction
     */
    public function setDay23Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day23Details = null) {
        $this->day23Details = $day23Details;

        return $this;
    }

    /**
     * Get day23Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay23Details() {
        return $this->day23Details;
    }

    /**
     * Set day24Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day24Details
     * @return UnrealizedProduction
     */
    public function setDay24Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day24Details = null) {
        $this->day24Details = $day24Details;

        return $this;
    }

    /**
     * Get day24Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay24Details() {
        return $this->day24Details;
    }

    /**
     * Set day25Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day25Details
     * @return UnrealizedProduction
     */
    public function setDay25Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day25Details = null) {
        $this->day25Details = $day25Details;

        return $this;
    }

    /**
     * Get day25Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay25Details() {
        return $this->day25Details;
    }

    /**
     * Set day26Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day26Details
     * @return UnrealizedProduction
     */
    public function setDay26Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day26Details = null) {
        $this->day26Details = $day26Details;

        return $this;
    }

    /**
     * Get day26Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay26Details() {
        return $this->day26Details;
    }

    /**
     * Set day27Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day27Details
     * @return UnrealizedProduction
     */
    public function setDay27Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day27Details = null) {
        $this->day27Details = $day27Details;

        return $this;
    }

    /**
     * Get day27Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay27Details() {
        return $this->day27Details;
    }

    /**
     * Set day28Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day28Details
     * @return UnrealizedProduction
     */
    public function setDay28Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day28Details = null) {
        $this->day28Details = $day28Details;

        return $this;
    }

    /**
     * Get day28Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay28Details() {
        return $this->day28Details;
    }

    /**
     * Set day29Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day29Details
     * @return UnrealizedProduction
     */
    public function setDay29Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day29Details = null) {
        $this->day29Details = $day29Details;

        return $this;
    }

    /**
     * Get day29Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay29Details() {
        return $this->day29Details;
    }

    /**
     * Set day30Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day30Details
     * @return UnrealizedProduction
     */
    public function setDay30Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day30Details = null) {
        $this->day30Details = $day30Details;

        return $this;
    }

    /**
     * Get day30Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay30Details() {
        return $this->day30Details;
    }

    /**
     * Set day31Details
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day31Details
     * @return UnrealizedProduction
     */
    public function setDay31Details(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay $day31Details = null) {
        $this->day31Details = $day31Details;

        return $this;
    }

    /**
     * Get day31Details
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay 
     */
    public function getDay31Details() {
        return $this->day31Details;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate() {
        parent::calculate();
    }

    /**
     * 
     * @param type $options
     */
    public function getCauseFail($options = array()) {
        $reflection = new \ReflectionClass($this);
        $methods = $reflection->getMethods();
        
        
        if ($options["paramDay"] != "") {
            $Match = "getDay".$options["paramDay"]."Details";
            $nameMatch = "/^".$Match."+$/";
        } else {
            $nameMatch = '/^getDay\d+Details+$/';
        }
        
        if($options["typeCause"]=="InternalCauses") {
            $methodGetType = "getInternalCauses";
        } else if($options["typeCause"]=="ExternalCauses") {
            $methodGetType = "getExternalCauses";
        }


        $rs = array();
        $cont = 0;
        $mounts = array();
        $days = $this->getDaysPerMonth($this->getMonth());

        foreach ($methods as $m) {

            $methodName = $m->getName();

            if (preg_match($nameMatch, $methodName)) {

                $metodsDetails = $this->$methodName();
                if ($metodsDetails != "") {
                    foreach ($metodsDetails->$methodGetType() as $md) {
                        array_push($mounts, $md->getMount());
                    }
                }
                else {
                    array_push($mounts, "0");
                }
                $cont++;
                if ($cont == $days) {
                    break;
                }
            }
        }
        return $mounts;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Objetive
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period = null)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }

}
