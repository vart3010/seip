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
}
