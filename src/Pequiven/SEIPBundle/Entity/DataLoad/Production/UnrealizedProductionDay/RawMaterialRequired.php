<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materia prima requerida
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production_raw_material_required")
 * @ORM\Entity()
 */
class RawMaterialRequired
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
     * Materia prima (Producto que son materia prima)
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rawMaterial;
    
    /**
     * Cantidad requerida
     * @var float
     * @ORM\Column(name="required_amount",type="float")
     */
    private $requiredAmount;
    
    /**
     * Cantidad no disponible
     * @var float
     * @ORM\Column(name="amount_not_available",type="float")
     */
    private $amountNotAvailable;
    
    /**
     * Unidad de medida del requerimiento
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unitMeasure;
    
    /**
     * Cantidad
     * @var float
     * @ORM\Column(name="mount",type="float")
     */
    private $mount;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set requiredAmount
     *
     * @param float $requiredAmount
     * @return RawMaterialRequired
     */
    public function setRequiredAmount($requiredAmount)
    {
        $this->requiredAmount = $requiredAmount;

        return $this;
    }

    /**
     * Get requiredAmount
     *
     * @return float 
     */
    public function getRequiredAmount()
    {
        return $this->requiredAmount;
    }

    /**
     * Set amountNotAvailable
     *
     * @param float $amountNotAvailable
     * @return RawMaterialRequired
     */
    public function setAmountNotAvailable($amountNotAvailable)
    {
        $this->amountNotAvailable = $amountNotAvailable;

        return $this;
    }

    /**
     * Get amountNotAvailable
     *
     * @return float 
     */
    public function getAmountNotAvailable()
    {
        return $this->amountNotAvailable;
    }

    /**
     * Set rawMaterial
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $rawMaterial
     * @return RawMaterialRequired
     */
    public function setRawMaterial(\Pequiven\SEIPBundle\Entity\CEI\Product $rawMaterial)
    {
        $this->rawMaterial = $rawMaterial;

        return $this;
    }

    /**
     * Get rawMaterial
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Product 
     */
    public function getRawMaterial()
    {
        return $this->rawMaterial;
    }

    /**
     * Set unitMeasure
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure
     * @return RawMaterialRequired
     */
    public function setUnitMeasure(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure)
    {
        $this->unitMeasure = $unitMeasure;

        return $this;
    }

    /**
     * Get unitMeasure
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure 
     */
    public function getUnitMeasure()
    {
        return $this->unitMeasure;
    }
    
    /**
     * Set mount
     *
     * @param float $mount
     * @return CauseFail
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get mount
     *
     * @return float 
     */
    public function getMount()
    {
        return $this->mount;
    }
    
    public function __toString() {
        $toString = "0";
        return $toString;
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
