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
}
