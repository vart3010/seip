<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\ReportTemplate as BaseModel;

/**
 * Reporte plantilla
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_template")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\ReportTemplateRepository")
 */
class ReportTemplate extends BaseModel
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
     * Referencia
     * @var string
     * @ORM\Column(name="ref",nullable=false)
     */
    private $ref;
    
    /**
     * Nombre del reporte
     * @var string
     * @ORM\Column(name="name")
     */
    private $name;
    
    /**
     * Tipo de reporte
     * @var integer
     * @ORM\Column(name="type_report",type="integer")
     */
    private $typeReport;

    /**
     * Productos del reporte
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",mappedBy="reportTemplate",cascade={"remove"})
     */
    private $productsReport;
    
    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Empresa.
     * @var \Pequiven\SEIPBundle\Entity\CEI\Company
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;
    
    /**
     * Localizacion (complejo).
     * @var \Pequiven\SEIPBundle\Entity\CEI\Location
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    
    /**
     * Planta.
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productsReport = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ReportTemplate
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
     * Set typeReport
     *
     * @param integer $typeReport
     * @return ReportTemplate
     */
    public function setTypeReport($typeReport)
    {
        $this->typeReport = $typeReport;

        return $this;
    }

    /**
     * Get typeReport
     *
     * @return integer 
     */
    public function getTypeReport()
    {
        return $this->typeReport;
    }

    /**
     * Add productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     * @return ReportTemplate
     */
    public function addProductsReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport)
    {
        $this->productsReport->add($productsReport);

        return $this;
    }

    /**
     * Remove productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     */
    public function removeProductsReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport)
    {
        $this->productsReport->removeElement($productsReport);
    }

    /**
     * Get productsReport
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductsReport()
    {
        return $this->productsReport;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return ReportTemplate
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ReportTemplate
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return ReportTemplate
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
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return ReportTemplate
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
     * Set plant
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plant
     * @return ReportTemplate
     */
    public function setPlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plant)
    {
        $this->plant = $plant;

        return $this;
    }

    /**
     * Get plant
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant 
     */
    public function getPlant()
    {
        return $this->plant;
    }
    
    public function __toString() 
    {
        return $this->getRef() ?: "-";
    }
}
