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
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Plan de consumo de servicios
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_planning")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\PlantReportRepository")
 */
class ConsumerPlanningService extends ModelBaseMaster
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
     *
     * @var DetailConsumerPlanningService
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\DetailConsumerPlanningService",mappedBy="consumerPlanningService")
     */
    private $detailConsumerPlanningServices;
}
