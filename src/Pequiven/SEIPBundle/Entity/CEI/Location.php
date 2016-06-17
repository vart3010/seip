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
use Pequiven\SEIPBundle\Model\CEI\Location as Model;

/**
 * Localidad (Control estadistico de informacion)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Location")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\LocationRepository")
 */
class Location extends Model
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
     * Empresa
     * @var Company
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;
    
    /**
     * Nombre de la sede
     * @var String 
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;
    
    /**
     * Tipo de sede
     * @var \Pequiven\SEIPBundle\Entity\CEI\TypeLocation
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\TypeLocation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeLocation;
    
    /**
     * Alias corto de la sede
     * @var string
     * @ORM\Column(name="alias",type="string",length=20)
     */
    private $alias;
    
    /**
     * Region
     * @var \Pequiven\SEIPBundle\Entity\CEI\Region
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Region")
     */
    private $region;
    
    /**
     * Estado
     * @var \Tecnocreaciones\Vzla\EntityBundle\Entity\State
     * @ORM\ManyToOne(targetEntity="Tecnocreaciones\Vzla\EntityBundle\Entity\State")
     */
    private $state;

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
     * @return Location
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
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return Location
     */
    public function setCompany(\Pequiven\SEIPBundle\Entity\CEI\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set typeLocation
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\TypeLocation $typeLocation
     * @return Location
     */
    public function setTypeLocation(\Pequiven\SEIPBundle\Entity\CEI\TypeLocation $typeLocation)
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
     * Set alias
     *
     * @param string $alias
     * @return Location
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
     * Set region
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Region $region
     * @return ReportTemplate
     */
    public function setRegion(\Pequiven\SEIPBundle\Entity\CEI\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
    
    /**
     * Set state
     *
     * @param \Tecnocreaciones\Vzla\EntityBundle\Entity\State $state
     * @return Location
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
    
    public function __toString() 
    {
        $_toString = "-";
        if($this->getAlias() != ""){
            $_toString = $this->getAlias();
        }else{
            $_toString = $this->getName();
        }
        return $_toString;
    }
}
