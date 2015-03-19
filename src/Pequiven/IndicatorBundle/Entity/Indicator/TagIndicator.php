<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\TagIndicator as Model;

/**
 * Etiquetas del indicador
 *
 * @ORM\Table(name="seip_indicator_tag")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class TagIndicator extends Model
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
     * Usuario que ingreso el valor
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Usuario que actualizo el valor original
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     */
    private $updatedBy;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300, nullable=true)
     */
    private $description;
    
    /**
     * Ecuación real con variables
     * @var string
     * @ORM\Column(name="equationReal", type="text")
     */
    private $equationReal;
    
    /**
     * Tipo de Etiqueta
     * @var integer
     *
     * @ORM\Column(name="typeTag", type="integer")
     */
    private $typeTag = self::TAG_TYPE_NUMERIC;
    
    /**
     * Tipo de Cálculo de la Etiqueta
     * @var integer
     *
     * @ORM\Column(name="typeCalculationTag", type="integer")
     */
    private $typeCalculationTag = self::TAG_VALUE_FROM_EQUATION;
    
    /**
     * Valor Numérico de la Etiqueta
     * 
     * @var decimal
     * @ORM\Column(name="valueOfTag", type="float",precision = 3)
     */
    private $valueOfTag = 0.0;
    
    /**
     * Valor en Texto de la Etiqueta
     * @var string
     * @ORM\Column(name="textOfTag", type="string", length=300, nullable=true)
     */
    private $textOfTag;
    
    /**
     * Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="tagsIndicator")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indicator;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="show", type="boolean")
     */
    private $show = true;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
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
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
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
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $updatedBy
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setUpdatedBy(\Pequiven\SEIPBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    /**
     * Set description
     * @param type $description
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set equationReal
     *
     * @param string $equationReal
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setEquationReal($equationReal)
    {
        $this->equationReal = $equationReal;

        return $this;
    }

    /**
     * Get equationReal
     *
     * @return string 
     */
    public function getEquationReal()
    {
        return $this->equationReal;
    }
    
    /**
     * Set typeTag
     *
     * @param integer $typeTag
     * @return TagIndicator
     */
    public function setTypeTag($typeTag)
    {
        $this->typeTag = $typeTag;

        return $this;
    }

    /**
     * Get typeTag
     *
     * @return integer 
     */
    public function getTypeTag()
    {
        return $this->typeTag;
    }
    
    /**
     * Set typeCalculationTag
     * @param type $typeCalculationTag
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setTypeCalculationTag($typeCalculationTag)
    {
        $this->typeCalculationTag = $typeCalculationTag;

        return $this;
    }

    /**
     * Get typeCalculationTag
     *
     * @return integer 
     */
    public function getTypeCalculationTag()
    {
        return $this->typeCalculationTag;
    }
    
    /**
     * Set valueOfTag
     * @param type $valueOfTag
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setValueOfTag($valueOfTag)
    {
        $this->valueOfTag = $valueOfTag;

        return $this;
    }

    /**
     * Get valueOfTag
     *
     * @return string 
     */
    public function getValueOfTag()
    {
        return $this->valueOfTag;
    }
    
    
    /**
     * Set textOfTag
     * @param type $textOfTag
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setTextOfTag($textOfTag)
    {
        $this->textOfTag = $textOfTag;

        return $this;
    }

    /**
     * Get textOfTag
     *
     * @return string 
     */
    public function getTextOfTag()
    {
        return $this->textOfTag;
    }
    
    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
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
     * Set show
     *
     * @param boolean $show
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
     */
    public function setShow($show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return boolean 
     */
    public function getShow()
    {
        return $this->show;
    }

    
    function getDeletedAt() 
    {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) 
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}