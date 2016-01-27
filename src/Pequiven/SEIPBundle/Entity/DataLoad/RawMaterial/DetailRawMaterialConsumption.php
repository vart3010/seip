<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Detail;

/**
 * Materia Prima (Plan y Real)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_raw_material_consumption")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class DetailRawMaterialConsumption extends Detail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning",inversedBy="detailRawMaterialConsumptions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $rawMaterialConsumptionPlanning;

    /**
     * Rangos de distribucion
     * @var Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\Range",mappedBy="detailRawMaterialConsumption",cascade={"persist","remove"})
     */
    protected $ranges;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=true)
     */
    private $period;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranges = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set rawMaterialConsumptionPlanning
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlanning
     * @return DetailRawMaterialConsumption
     */
    public function setRawMaterialConsumptionPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning $rawMaterialConsumptionPlanning)
    {
        $this->rawMaterialConsumptionPlanning = $rawMaterialConsumptionPlanning;

        return $this;
    }

    /**
     * Get rawMaterialConsumptionPlanning
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning 
     */
    public function getRawMaterialConsumptionPlanning()
    {
        return $this->rawMaterialConsumptionPlanning;
    }

    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\Range $ranges
     * @return DetailRawMaterialConsumption
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\Range $ranges)
    {
        $ranges->setDetailRawMaterialConsumption($this);
        $this->ranges->add($ranges);

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\Range $ranges)
    {
        $this->ranges->removeElement($ranges);
    }

    /**
     * Get ranges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRanges()
    {
        return $this->ranges;
    }
    
    public function __toString() {
        $_toString = "";
        if($this->getId() > 0){
            $_toString = $this->getMonthLabel();
        }
        return $_toString;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function totalize()
    {
        parent::totalize();
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
        
    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $parent
     * @return DetailRawMaterialConsumption
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\DetailRawMaterialConsumption 
     */
    public function getParent() {
        return $this->parent;
    }
}
