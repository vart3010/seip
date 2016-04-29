<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Tipo de punto de atencion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_c_type_feature_indicator")
 * @ORM\Entity()
 */
class TypeFeatureIndicator extends ModelBaseMaster
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
     * Descripcion
     * @var string
     * @ORM\Column(name="description",type="string",nullable=false)
     */
    private $description;
    
    /**
     * Color del texto
     * @var string
     * @ORM\Column(name="color",type="string",length=20) 
     */
    private $color;
    
    /**
     * Prioridad para visualizar el punto de atencion
     * @var integer
     * @ORM\Column(name="priority",type="integer")
     */
    private $priority = 0;
    
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
     * @return TypeFeatureIndicator
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
     * Set color
     *
     * @param string $color
     * @return TypeFeatureIndicator
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return TypeFeatureIndicator
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    public function __toString() {
        return $this->getDescription()?:"-";
    }
}
