<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Plant")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\PlantRepository")
 */
class Plant extends BaseModel
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
     * Nombre
     * 
     * @var String 
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;
    
    /**
     * Capacidad de diseño
     * 
     * @var float
     * @ORM\Column(name="design_capacity",type="float")
     */
    private $designCapacity;

    /**
     * Unidad de medida
     * @var UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     */
    protected $unitMeasure;

    /**
     * Localizacion o empresa
     * @var Location
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     */
    protected $location;
    
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
     * Set name
     *
     * @param string $name
     * @return Plant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return Plant
     */
    public function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * Set designCapacity
     *
     * @param float $designCapacity
     * @return Plant
     */
    public function setDesignCapacity($designCapacity)
    {
        $this->designCapacity = $designCapacity;

        return $this;
    }

    /**
     * Get designCapacity
     *
     * @return float 
     */
    public function getDesignCapacity()
    {
        return $this->designCapacity;
    }
    
    /**
     * Set unitMeasure
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure
     * @return Plant
     */
    public function setUnitMeasure(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $unitMeasure = null)
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
    
    public function __toString() 
    {
        return $this->getName()?:'-';
    }
}
