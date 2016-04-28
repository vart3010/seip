<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Entity\Formula;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Detalle de formula para cada indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="formula_detail",uniqueConstraints={@ORM\UniqueConstraint(name="f_detail_idx", columns={"indicator_id", "variable_id"})})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class FormulaDetail 
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
     * Indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="formulaDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indicator;
    
    /**
     * Variable
     * @var \Pequiven\MasterBundle\Entity\Formula\Variable
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Formula\Variable")
     * @ORM\JoinColumn(nullable=false)
     */
    private $variable;
    
    /**
     * Descripcion de variable
     * @var string|null
     * @ORM\Column(name="variableDescription",type="string",length=50,nullable=true)
     */
    private $variableDescription;
    
    /**
     * Tipo de unidad
     * @var string
     * @ORM\Column(name="unitType",type="string",length=50)
     */
    private $unitType;
    
    /**
     * Unidad
     * @var string
     * @ORM\Column(name="unit",type="string",length=90)
     */
    private $unit;
    
    /**
     * Unidad concatenada
     * @var string
     * @ORM\Column(name="unitGroup",type="string",length=90)
     */
    private $unitGroup;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * Set variableDescription
     *
     * @param string $variableDescription
     * @return FormulaDetail
     */
    public function setVariableDescription($variableDescription)
    {
        $this->variableDescription = $variableDescription;

        return $this;
    }

    /**
     * Get variableDescription
     *
     * @return string 
     */
    public function getVariableDescription()
    {
        return $this->variableDescription;
    }

    /**
     * Set unitType
     *
     * @param string $unitType
     * @return FormulaDetail
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;

        return $this;
    }

    /**
     * Get unitType
     *
     * @return string 
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return FormulaDetail
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return FormulaDetail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return FormulaDetail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return FormulaDetail
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Set variable
     *
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variable
     * @return FormulaDetail
     */
    public function setVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variable)
    {
        $this->variable = $variable;

        return $this;
    }

    /**
     * Get variable
     *
     * @return \Pequiven\MasterBundle\Entity\Formula\Variable 
     */
    public function getVariable()
    {
        return $this->variable;
    }
    
    public function __toString() {
        $toString = '';
        $toString .= $this->getId() > 0 ? ($this->getIndicator().' - '.$this->getVariable()) : '-';
        
        return $toString;
    }

    /**
     * Set unitGroup
     *
     * @param string $unitGroup
     * @return FormulaDetail
     */
    public function setUnitGroup($unitGroup)
    {
        $this->unitGroup = $unitGroup;

        return $this;
    }

    /**
     * Get unitGroup
     *
     * @return string 
     */
    public function getUnitGroup()
    {
        return $this->unitGroup;
    }
    
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->updateValues();
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updateValues();
    }
    private function updateValues()
    {
        $unitGroup = json_decode($this->unitGroup);
        $this->unitType = $unitGroup->unitType;
        $this->unit = $unitGroup->unit;
    }
}
