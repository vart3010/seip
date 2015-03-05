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
 * Sub sector
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_SubSector")
 * @ORM\Entity()
 */
class SubSector extends BaseModel
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
     * Sector
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Sector 
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Sector")
     * @ORM\Joincolumn(nullable=false)
     */
    private $sector;
    
    /**
     * Nombre
     * 
     * @var String 
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;
    
    /**
     * Descripcion
     * 
     * @var String 
     * @ORM\Column(name="description",type="text")
     */
    private $description;

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
     * @return SubSector
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
     * Set description
     *
     * @param string $description
     * @return SubSector
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
     * Set sector
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Sector $sector
     * @return SubSector
     */
    public function setSector(\Pequiven\SEIPBundle\Entity\CEI\Sector $sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Sector 
     */
    public function getSector()
    {
        return $this->sector;
    }
    
    public function __toString() 
    {
        return $this->getName()?:'-';
    }
}
