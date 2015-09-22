<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Politic\Proposal as ModelProposal;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Propuestas de Círculo de Estudio de Trabajo
 *
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Politic\ProposalRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Proposal extends ModelProposal implements PeriodItemInterface {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * LineStrategic
     * 
     * @var \Pequiven\MasterBundle\Entity\LineStrategic
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\LineStrategic")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lineStrategic;
    
    /**
     * Descripción de la Propuesta
     * @var string
     * @ORM\Column(name="description",type="text",nullable=true)
     */
    private $description = null;
    
    /**
     * WorkStudyCircle
     * 
     * @var \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", inversedBy="proposals")
     * @ORM\JoinColumn(name="workStudyCircle_id", referencedColumnName="id")
     */
    private $workStudyCircle;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Constructor
     */
    public function __construct() {
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get CreatedBy
     * @return type
     */
    function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set CreatedBy
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }
    
    /**
     * Get LineStrategic
     *
     * @return \Pequiven\MasterBundle\Entity\LineStrategic
     */
    public function getLineStrategic() {
        return $this->lineStrategic;
    }

    /**
     * Set LineStrategic
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategic
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    public function setLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategic) {
        $this->lineStrategic = $lineStrategic;
    }
    
    /**
     * Get Description
     * @return type
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set Description
     * @param type $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }
    
    /**
     * Get WorkStudyCircle
     *
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function getWorkStudyCircle() {
        return $this->workStudyCircle;
    }

    /**
     * Set WorkStudyCircle
     *
     * @param \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $workStudyCircle
     * @return \Pequiven\SEIPBundle\Entity\Politic\Proposal
     */
    public function setWorkStudyCircle(\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $workStudyCircle) {
        $this->workStudyCircle = $workStudyCircle;
    }
    
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    
    public function getDescriptionTruncate(){
        return \Pequiven\SEIPBundle\Service\ToolService::truncate($this->getDescription(), array('limit' => 50));
    }
}