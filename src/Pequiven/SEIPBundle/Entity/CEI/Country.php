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
 * Pais
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Country",uniqueConstraints={@ORM\UniqueConstraint(name="alphaCode_idx",columns={"alphaCode"}),@ORM\UniqueConstraint(name="numericalCode_idx",columns={"numericalCode"}) } )
 * @ORM\Entity()
 */
class Country extends BaseModel
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
     * Nombre ISO
     * 
     * @var String 
     * @ORM\Column(name="nameISO",type="string",nullable=false)
     */
    private $nameISO;
    
    /**
     * Codigo alfa
     * 
     * @var string
     * @ORM\Column(name="alphaCode",type="string",length=3)
     */
    private $alphaCode;
    
    /**
     * Codigo numerico
     * 
     * @var string
     * @ORM\Column(name="numericalCode",type="integer")
     */
    private $numericalCode;

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
     * @return Country
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
     * Set nameISO
     *
     * @param string $nameISO
     * @return Country
     */
    public function setNameISO($nameISO)
    {
        $this->nameISO = $nameISO;

        return $this;
    }

    /**
     * Get nameISO
     *
     * @return string 
     */
    public function getNameISO()
    {
        return $this->nameISO;
    }

    /**
     * Set alphaCode
     *
     * @param string $alphaCode
     * @return Country
     */
    public function setAlphaCode($alphaCode)
    {
        $this->alphaCode = $alphaCode;

        return $this;
    }

    /**
     * Get alphaCode
     *
     * @return string 
     */
    public function getAlphaCode()
    {
        return $this->alphaCode;
    }

    /**
     * Set numericalCode
     *
     * @param integer $numericalCode
     * @return Country
     */
    public function setNumericalCode($numericalCode)
    {
        $this->numericalCode = $numericalCode;

        return $this;
    }

    /**
     * Get numericalCode
     *
     * @return integer 
     */
    public function getNumericalCode()
    {
        return $this->numericalCode;
    }
    
    public function __toString() {
        return $this->getName()?:'-';
    }
}
