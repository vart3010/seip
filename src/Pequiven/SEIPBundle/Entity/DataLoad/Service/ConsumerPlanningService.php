<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Service;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Plan de consumo de servicios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_planning")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository")
 */
class ConsumerPlanningService extends BaseModel
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
     * Reporte de planta
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\PlantReport",inversedBy="consumerPlanningServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plantReport;
    
    /**
     * Servicio
     * @var \Pequiven\SEIPBundle\Entity\CEI\Service
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     *
     * @var DetailConsumerPlanningService
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService",mappedBy="consumerPlanningService")
     */
    private $detailConsumerPlanningServices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detailConsumerPlanningServices = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set plantReport
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport
     * @return ConsumerPlanningService
     */
    public function setPlantReport(\Pequiven\SEIPBundle\Entity\DataLoad\PlantReport $plantReport)
    {
        $this->plantReport = $plantReport;

        return $this;
    }

    /**
     * Get plantReport
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\PlantReport 
     */
    public function getPlantReport()
    {
        return $this->plantReport;
    }

    /**
     * Set service
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Service $service
     * @return ConsumerPlanningService
     */
    public function setService(\Pequiven\SEIPBundle\Entity\CEI\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Add detailConsumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices
     * @return ConsumerPlanningService
     */
    public function addDetailConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices)
    {
        $detailConsumerPlanningServices->setConsumerPlanningService($this);
        $this->detailConsumerPlanningServices[] = $detailConsumerPlanningServices;

        return $this;
    }

    /**
     * Remove detailConsumerPlanningServices
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices
     */
    public function removeDetailConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService $detailConsumerPlanningServices)
    {
        $this->detailConsumerPlanningServices->removeElement($detailConsumerPlanningServices);
    }

    /**
     * Get detailConsumerPlanningServices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailConsumerPlanningServices()
    {
        return $this->detailConsumerPlanningServices;
    }
}
