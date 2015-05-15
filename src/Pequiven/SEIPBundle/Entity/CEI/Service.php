<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Servicios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_service")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\ServiceRepository")
 */
class Service extends BaseModel
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
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;
    
    /**
     * Unidad del servicio
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     */
    private $serviceUnit;
    
    /**
     * Plantas
     * @var Plant
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant",mappedBy="services")
     */
    private $plants;

    public function __construct() {
        $this->plants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Service
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
     * Set serviceUnit
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $serviceUnit
     * @return Service
     */
    public function setServiceUnit(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $serviceUnit = null)
    {
        $this->serviceUnit = $serviceUnit;

        return $this;
    }

    /**
     * Get serviceUnit
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure 
     */
    public function getServiceUnit()
    {
        return $this->serviceUnit;
    }
    
    public function __toString() 
    {
        return $this->getName()?:"-";
    }
}
