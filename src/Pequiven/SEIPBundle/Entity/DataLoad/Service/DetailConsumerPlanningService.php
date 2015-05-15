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
use Pequiven\SEIPBundle\Model\DataLoad\Detail;

/**
 * Detalle de consumo de servicios (Plan y Real)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_plant_service_detail_consumer")
 * @ORM\Entity()
 */
class DetailConsumerPlanningService extends Detail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService",inversedBy="detailConsumerPlanningServices")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $consumerPlanningService;
    
    /**
     * Rangos de distribucion
     * @var Range
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Service\Range",mappedBy="detailConsumerPlanningService",cascade={"persist","remove"})
     */
    protected $ranges;
}
