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
use Pequiven\SEIPBundle\Model\CEI\Company as BaseModel;

/**
 * Empresa (Control estadistico de informacion)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Company")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\CompanyRepository")
 */
class Company extends BaseModel
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
     * @var string
     *
     * @ORM\Column(name="rif", type="string", length=12,nullable=false)
     */
    private $rif;
    
    /**
     * Nombre de la empresa
     * @var string
     * @ORM\Column(name="description",type="string",length=255,nullable=false) 
     */
    private $description;
    
    /**
     * Alias corto de la empresa
     * @var string
     * @ORM\Column(name="alias",type="string",length=20)
     */
    private $alias;

    /**
     * Tipo de empresa
     * @var integer
     * @ORM\Column(name="typeOfCompany",type="integer")
     */
    private $typeOfCompany = self::TYPE_OF_COMPANY_MATRIZ;
    
    /**
     * Filiales
     * @var Company
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinTable(name="company_affiliates")
     */
    private $affiliates;
    
    /**
     * Filiales
     * @var Company
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinTable(name="company_mixeds")
     */
    private $mixeds;
    
    /**
     * Region
     * @var \Pequiven\SEIPBundle\Entity\CEI\Region
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Region")
     */
    private $region;
    
    /**
     * Imagen codificada en Base64
     * @var string
     * @ORM\Column(type="text")
     */
    protected $base64image = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAN5QTFRFwsLCxMTExcXFxsbGx8fHyMjIycnJysrKy8vLzMzMzc3Nzc7Ozs7Oz8/P0NDQ0dHR0tLS09PT1NTU1dXV1dbW1tbW19fX2NjY2dnZ2tra2tvb29vb3Nzc3d3d3d7e3t7e3t/f39/f4ODg4OHh4eHh4uLi4+Pj5OTk5OXl5eXl5ebm5ubm5ufn5+fn5+jo6Ojo6enp6urq6+vr6+zs7Ozs7O3t7e3t7u7u7+/v8PDw8PHx8fHx8vLy8/Pz9PT09fX19vb29/f3+Pj4+fn5+vr6+/v7/Pz8/f39/v7+////obAPKgAAA/lJREFUWMOdl3l7okgQxlljEpMdJ8eMSu+QHWMU1zAOxyLHciPn9/9CW9WNxhgUyPuHj0q9v6e6moYqbqRYtu24ruf7AShsFEb5vue6jm1bpsRJYxX81A5XoxaiEEQ4tiWNOFOe6OBHexTFrYQMQABBniicacvEQj/at61EEUhQeM3kLNtRBAf81J60EEMAQSGGbXFYAPXJpf4kSVsIEUhQBQvKgAA/0GdBzOxZoxgijrVn16cArGCoz0P0Y0B+VgwBBG3mYR1tDlaABTAXEfrzFqIETQygDLARHK4AAFtTjNFfNIoSDDHCOvo7ABbQWm7b+CnBWIEjrgBQAkgACmBJ6T4oCY4VHxAMaZtCHSMoAgWEFJBl9joripJKJ8cS2YUSAIacZhQQHgFyIJRNgLIwFNyJPYBtAgKgAracs6jNaYCu4k4wAGzDe0BhKfl5QKFreXES4KriaLgQQdMPAAH/Fhf39//8l54AhC8YeHPJk5PirwbwOQ1rAYnAgs4Q+MsByyapA/zahQ2u+PN+QtZ1AIE0ECb9m31BagDRQWgtYdK/ffsRfAR4h8GDa0aYqxtVrPwXXw4CvAYAub6Gj01Ctz7fwOrG7/zNAP56MI93916ZzMe9IekEIPyfGji9zevGQcLNV9IRQCLNjNn9OA1TyRK6AuSyWO2qPv7pHx+OZgDU7+8rtu+j3ve8TDoCprB+uPNuqP+eQB3m3QAiPdH85S35Bn5YUCl/BkD4/qD38PazO4A8cANW0vK1G0DAGhDy+MdDH+/A7jUgYVlOyUPvG5yBIRG67wJ5Lcv4sTeip2joHdewzZ3oleHsL/b1Cb6TzgDBlNLSUUXVybO1LnQH3PWt/Wn0+nedAXe9MRFDag9lMu7ddQR8BX/1MqDZHxNqAOnh9eHF+CjnI0LNMzGdvV3+cjH58Ewd45k491ROrTd/f1LzVD8k1L4Xspfq6m2tn51rppfaN1OWiA2vthE9mYSs0lNv50jXdYH/d3NKv7+/6rqZvH+9H3Yo0L6YWlGe1laKsMfJsxMtTgHtwzk/JdQAqi4tyzNNa2r04mVEV3DQpe36ROi8VK25S4yWEUtg3ydWnSp0GLLWptMMl2GVwA7AtmG7ldR2vbIvBjSBqldm3TqMCyu1bbfuLYIqAezWbbaGUFTbzwvu3I+rFVAApOAv1C4Tiz3zWAIAsDAF71nuNjNZz25AE7BganNc+6fSdWrTnxyagMmZlm3+kLvPjRoduSyTM0ydX39mclV+mOA3OEPlpc/NzmveQIA8WllQSEQAw2eY06IhHo7ejr3iNUPnHpeGaeIADwiENAvjHDq6i2NF4xaabjAEMFDuWbEYG+2mYcxH8v/D6kHpgLvkXwAAAABJRU5ErkJggg==";
    
    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string")
     */
    private $ubicacion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->affiliates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mixeds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set rif
     *
     * @param string $rif
     * @return Company
     */
    public function setRif($rif)
    {
        $this->rif = $rif;

        return $this;
    }

    /**
     * Get rif
     *
     * @return string 
     */
    public function getRif()
    {
        return $this->rif;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Company
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
     * Set typeOfCompany
     *
     * @param integer $typeOfCompany
     * @return Company
     */
    public function setTypeOfCompany($typeOfCompany)
    {
        $this->typeOfCompany = $typeOfCompany;

        return $this;
    }

    /**
     * Get typeOfCompany
     *
     * @return integer 
     */
    public function getTypeOfCompany()
    {
        return $this->typeOfCompany;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Company
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
     * Add affiliates
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $affiliates
     * @return Company
     */
    public function addAffiliate(\Pequiven\SEIPBundle\Entity\CEI\Company $affiliates)
    {
        $this->affiliates->add($affiliates);

        return $this;
    }

    /**
     * Remove affiliates
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $affiliates
     */
    public function removeAffiliate(\Pequiven\SEIPBundle\Entity\CEI\Company $affiliates)
    {
        $this->affiliates->removeElement($affiliates);
    }

    /**
     * Get affiliates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffiliates()
    {
        return $this->affiliates;
    }

    /**
     * Add mixeds
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $mixeds
     * @return Company
     */
    public function addMixed(\Pequiven\SEIPBundle\Entity\CEI\Company $mixeds)
    {
        $this->mixeds->add($mixeds);

        return $this;
    }

    /**
     * Remove mixeds
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $mixeds
     */
    public function removeMixed(\Pequiven\SEIPBundle\Entity\CEI\Company $mixeds)
    {
        $this->mixeds->removeElement($mixeds);
    }

    /**
     * Get mixeds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMixeds()
    {
        return $this->mixeds;
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
    
    public function __toString() {
        return $this->getAlias()?:'-';
    }
    
    /**
     * Set image
     *
     * @param string $base64image
     * @return string
     */
    public function setBase64Image($encodedImage)
    {
        $this->base64image = $encodedImage;

        return $this;
    }
    
    /**
     *
     * @param string $ubicacion
     * @return string
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
        
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getBase64Image()
    {
        return $this->base64image;
    }
    
    /**
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }
}
