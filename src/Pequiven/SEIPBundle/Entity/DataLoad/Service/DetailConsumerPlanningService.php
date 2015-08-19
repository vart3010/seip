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
 * @ORM\HasLifecycleCallbacks()
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranges = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set consumerPlanningService
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningService
     * @return DetailConsumerPlanningService
     */
    public function setConsumerPlanningService(\Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService $consumerPlanningService)
    {
        $this->consumerPlanningService = $consumerPlanningService;

        return $this;
    }

    /**
     * Get consumerPlanningService
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Service\ConsumerPlanningService
     */
    public function getConsumerPlanningService()
    {
        return $this->consumerPlanningService;
    }

    /**
     * Add ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges
     * @return DetailConsumerPlanningService
     */
    public function addRange(\Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges)
    {
        $ranges->setDetailConsumerPlanningService($this);
        $this->ranges->add($ranges);

        return $this;
    }

    /**
     * Remove ranges
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges
     */
    public function removeRange(\Pequiven\SEIPBundle\Entity\DataLoad\Service\Range $ranges)
    {
        $this->ranges->removeElement($ranges);
    }

    /**
     * Get ranges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function totalize()
    {
        parent::totalize();
    }
}
