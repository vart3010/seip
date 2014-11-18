<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Valor del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_indicator_value")
 * @ORM\Entity()
 */
class ValueIndicator
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
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Usuario que actualizo el valor original del valor
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     */
    private $updatedBy;
    
    /**
     * Valor del indicador
     * 
     * @var decimal
     * @ORM\Column(name="valueOfIndicator", type="decimal",precision = 3)
     */
    protected $valueOfIndicator;
    
    /**
     * Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="simpleValuesIndicator")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indicator;

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
     * @return IndicatorSimpleValue
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
     * @return IndicatorSimpleValue
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
     * @return IndicatorSimpleValue
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
     * @return IndicatorSimpleValue
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
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return IndicatorSimpleValue
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
     * Set valueOfIndicator
     *
     * @param string $valueOfIndicator
     * @return SimpleValueIndicator
     */
    public function setValueOfIndicator($valueOfIndicator)
    {
        $this->valueOfIndicator = $valueOfIndicator;

        return $this;
    }

    /**
     * Get valueOfIndicator
     *
     * @return string 
     */
    public function getValueOfIndicator()
    {
        return $this->valueOfIndicator;
    }
}
