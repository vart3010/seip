<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBase;

/**
 * Punto de atencion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 */
class FeatureIndicator extends ModelBase
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
     * Descripcion del punto de atencion
     * @var string
     * @ORM\Column(name="description",type="text",nullable=false)
     */
    private $description;
    
    /**
     * Tipo de punto de atencion
     * @var \Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $typeFeatureIndicator;
    
    /**
     * Indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="featuresIndicator")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $indicator;
    
    /**
     * Usuario que creo el punto de atencion
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id")
     */
    private $createdBy;

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
     * Set description
     *
     * @param string $description
     * @return FeatureIndicator
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
     * Set typeFeatureIndicator
     *
     * @param \Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator $typeFeatureIndicator
     * @return FeatureIndicator
     */
    public function setTypeFeatureIndicator(\Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator $typeFeatureIndicator)
    {
        $this->typeFeatureIndicator = $typeFeatureIndicator;

        return $this;
    }

    /**
     * Get typeFeatureIndicator
     *
     * @return \Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator 
     */
    public function getTypeFeatureIndicator()
    {
        return $this->typeFeatureIndicator;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return FeatureIndicator
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
    
    function getCreatedBy() {
        return $this->createdBy;
    }

    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        
        return $this;
    }
}
