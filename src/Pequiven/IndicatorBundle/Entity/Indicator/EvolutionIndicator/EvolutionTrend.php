<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionTrend as Model;

/**
 * Analisis de la tendencia del informe de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_report_evolution_trend")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EvolutionTrend extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", inversedBy="indicatorTrend")
     * @ORM\JoinColumn(name="indicator_id", referencedColumnName="id", nullable=true)
     */
    private $indicator;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
     */
    private $description;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime",  nullable=true)
     */
    private $updatedAt;

    /**
     * Usuario que creo la causa
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdBy;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeObject", type="integer")
     */
    private $typeObject;   

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram", inversedBy="arrangementProgramTrend")
     * @ORM\JoinColumn(name="arrangementProgram_id", referencedColumnName="id", nullable=true)
     */
    private $arrangementProgram; 


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
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return Indicator
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator) {
        
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return Pequiven\IndicatorBundle\Entity\Indicator
     */
    public function getIndicator() {
        return $this->indicator;
    }

    /**
     * Set arrangementProgram
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram
     * @return arrangementProgram
     */
    public function setArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram) {
        
        $this->arrangementProgram = $arrangementProgram;

        return $this;
    }

    /**
     * Get arrangementProgram
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     */
    public function getArrangementProgram() {
        return $this->arrangementProgram;
    }

    /**
     * 
     * @param type $description
     * @return type
     */
    public function setDescription($description) {
        $this->description = $description;
        return $description;
    }

    /**
     * 
     * @return type
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param type $month
     * @return type
     */
    public function setMonth($month) {
        $this->month = $month;
        return $month;
    }

    /**
     * 
     * @return type
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * 
     * @param type $typeObject
     * @return type
     */
    public function setTypeObject($typeObject) {
        $this->typeObject = $typeObject;
        return $typeObject;
    }

    /**
     * 
     * @return type
     */
    public function getTypeObject() {
        return $this->typeObject;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Indicator
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
     * @return IndicatorSimpleValue
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
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return IndicatorSimpleValue
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ManagementSystem
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }  
    
}
