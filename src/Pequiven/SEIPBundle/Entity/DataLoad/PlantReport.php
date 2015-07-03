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
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlantReport extends ModelBaseMaster
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
     * Reporte de plantilla
     * @var ReportTemplate
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate",inversedBy="plantReports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportTemplate;
    
    /**
     * Empresa
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
     * Entidad donde esta el producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Entity
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Entity")
     */
    private $entity;
    
    /**
     * Planta que hace el producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plant;

    /**
     * Productos del reporte
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",mappedBy="plantReport",cascade={"remove"})
     */
    private $productsReport;
    
    /**
     * Planificacion de paradas
     * @var Plant\PlantStopPlanning
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning",mappedBy="plantReport",cascade={"remove"})
     */
    private $plantStopPlannings;
    
    /**
     * Planificacion de consumo de servicios
     * @var Service\ConsumerPlanningService
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService",mappedBy="plantReport",cascade={"remove"})
     */
    private $consumerPlanningServices;
    
    /**
     * Porcentaje de la capacidad actual
     * @var float
     * @ORM\Column(name="currentCapacity",type="float")
     */
    private $currentCapacity;
    
    /**
     * Porcentaje de capacidad actual
     * @var float
     * @ORM\Column(name="percentageCurrentCapacity",type="float")
     */
    private $percentageCurrentCapacity;
    
    /**
     * Usuarios
     * @var type 
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="plantReports")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productsReport = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plantStopPlannings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consumerPlanningServices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set reportTemplate
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate
     * @return PlantReport
     */
    public function setReportTemplate(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate)
    {
        $this->reportTemplate = $reportTemplate;
        
        return $this;
    }
    
    /**
     * Get reportTemplate
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate 
     */
    public function getReportTemplate()
    {
        return $this->reportTemplate;
    }

    /**
     * Add productsReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport
     * @return PlantReport
     */
    public function addProductsReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productsReport)
    {
        $this->productsReport[] = $productsReport;

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
     * Set company
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Company $company
     * @return PlantReport
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
     * @return PlantReport
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
     * Set entity
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Entity $entity
     * @return PlantReport
     */
    public function setEntity(\Pequiven\SEIPBundle\Entity\CEI\Entity $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Entity 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set plant
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plant
     * @return PlantReport
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
    
    /**
     * Add plantStopPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlannings
     * @return PlantReport
     */
    public function addPlantStopPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlannings)
    {
        $plantStopPlannings->setPlantReport($this);
        
        $this->plantStopPlannings->add($plantStopPlannings);

        return $this;
    }

    /**
     * Remove plantStopPlannings
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlannings
     */
    public function removePlantStopPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Plant\PlantStopPlanning $plantStopPlannings)
    {
        $this->plantStopPlannings->removeElement($plantStopPlannings);
    }

    /**
     * Get plantStopPlannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlantStopPlannings()
    {
        return $this->plantStopPlannings;
    }
    
    /**
     * Add consumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningServices
     * @return PlantReport
     */
    public function addConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningServices)
    {
        $this->consumerPlanningServices[] = $consumerPlanningServices;

        return $this;
    }

    /**
     * Remove consumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningServices
     */
    public function removeConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningServices)
    {
        $this->consumerPlanningServices->removeElement($consumerPlanningServices);
    }

    /**
     * Get consumerPlanningServices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsumerPlanningServices()
    {
        return $this->consumerPlanningServices;
    }
    
    function getCurrentCapacity() {
        return $this->currentCapacity;
    }

    function setCurrentCapacity($currentCapacity) {
        $this->currentCapacity = $currentCapacity;
        
        return $this;
    }
    
    function getPercentageCurrentCapacity() {
        return $this->percentageCurrentCapacity;
    }

    function setPercentageCurrentCapacity($percentageCurrentCapacity) {
        $this->percentageCurrentCapacity = $percentageCurrentCapacity;
    }

    public function __toString() 
    {
        $_toString = "-";
        if($this->getPlant()){
            $_toString = (string)$this->getPlant();
        }
        return $_toString;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculate()
    {
        $designCapacity = $this->getPlant()->getDesignCapacity();
        $percentageCurrentCapacity = 0;
        if($designCapacity > 0){
            $percentageCurrentCapacity = ($this->currentCapacity * 100) / $designCapacity;
        }
        
        $this->percentageCurrentCapacity = $percentageCurrentCapacity;
    }
    
    public function init(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate)
    {
        $this->setReportTemplate($reportTemplate);
        $this->setCompany($reportTemplate->getCompany());
        $this->setLocation($reportTemplate->getLocation());
    }
    
    /**
     * Obtiene las paradas de plantas por mes
     * @return type
     */
    public function getPlantStopPlanningSortByMonth()
    {
        $plantStopPlannings = $this->getPlantStopPlannings();
        $sorted = array();
        foreach ($plantStopPlannings as $plantStopPlanning){
            $sorted[$plantStopPlanning->getMonth()] = $plantStopPlanning;
        }
        ksort($sorted);
        return $sorted;
    }
    
    public function getReportTemplateWithName()
    {
        $full = sprintf("%s (%s)",$this->reportTemplate->getName(),$this->reportTemplate->getRef());
        return $full;
    }
}
