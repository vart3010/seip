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
 * Description of Entidad
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_entity")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\EntityRepository")
 */
class Entity extends BaseModel
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
     * Localidad
     * @var Company
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    
    /**
     * Nombre de la entidad
     * @var String 
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;
    
    /**
     * Alias corto de la entidad
     * @var string
     * @ORM\Column(name="alias",type="string",length=20)
     */
    private $alias;
    
    /**
     * Tipo de sede
     * @var \Pequiven\SEIPBundle\Entity\CEI\TypeLocation
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\TypeLocation")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeLocation;
    
    /**
     * Estado
     * @var \Tecnocreaciones\Vzla\EntityBundle\Entity\State
     * @ORM\ManyToOne(targetEntity="Tecnocreaciones\Vzla\EntityBundle\Entity\State")
     */
    private $state;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="canBeNetProductionGreaterThanGross", type="boolean")
     */
    private $canBeNetProductionGreaterThanGross = false;

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
     * @return Entity
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
     * Set alias
     *
     * @param string $alias
     * @return Entity
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return Entity
     */
    public function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location)
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
     * Set typeLocation
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\TypeLocation $typeLocation
     * @return Entity
     */
    public function setTypeLocation(\Pequiven\SEIPBundle\Entity\CEI\TypeLocation $typeLocation = null)
    {
        $this->typeLocation = $typeLocation;

        return $this;
    }

    /**
     * Get typeLocation
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\TypeLocation 
     */
    public function getTypeLocation()
    {
        return $this->typeLocation;
    }

    /**
     * Set state
     *
     * @param \Tecnocreaciones\Vzla\EntityBundle\Entity\State $state
     * @return Entity
     */
    public function setState(\Tecnocreaciones\Vzla\EntityBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Tecnocreaciones\Vzla\EntityBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Set canBeNetProductionGreaterThanGross
     *
     * @param boolean $canBeNetProductionGreaterThanGross
     * @return Entity
     */
    public function setCanBeNetProductionGreaterThanGross($canBeNetProductionGreaterThanGross) {
        $this->canBeNetProductionGreaterThanGross = $canBeNetProductionGreaterThanGross;

        return $this;
    }

    /**
     * Get canBeNetProductionGreaterThanGross
     *
     * @return boolean 
     */
    public function getCanBeNetProductionGreaterThanGross() {
        return $this->canBeNetProductionGreaterThanGross;
    }
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getId() > 0){
            if($this->getAlias() != ""){
                $_toString = $this->getAlias();
            }else{
                $_toString = $this->getName();
            }
        }
        return $_toString;
    }
}
