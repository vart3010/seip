<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionCause as Model;

/**
 * Causas de Desviacion del Indicador
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_indicator_evolution_causes")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EvolutionCause extends Model {

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
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", inversedBy="indicatorCause")
     * @ORM\JoinColumn(name="indicator_id", referencedColumnName="id")
     */
    private $indicator;

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=255)
     */
    private $causes;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueOfCauses", type="integer")
     */
    private $valueOfCauses;

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
     * Acciones del indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction",mappedBy="evolutionCause",cascade={"persist","remove"})
     */
    protected $indicatorAction;

    /**
     * Constructor
     */
    public function __construct() {

        $this->indicatorAction = new \Doctrine\Common\Collections\ArrayCollection();
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
     * 
     * @param type $causes
     * @return type
     */
    public function setCauses($causes) {
        $this->causes = $causes;
        return $causes;
    }

    /**
     * 
     * @return type
     */
    public function getCauses() {
        return $this->causes;
    }

    /**
     * 
     * @param type $valueOfCauses
     * @return type
     */
    public function setValueOfCauses($valueOfCauses) {
        $this->valueOfCauses = $valueOfCauses;
        return $valueOfCauses;
    }

    /**
     * 
     * @return type
     */
    public function getValueOfCauses() {
        return $this->valueOfCauses;
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


    /**
     * Add indicatorAction
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $indicatorAction
     * @return Indicator
     */
    public function addAndicatorAction(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $indicatorAction) {

        $this->indicatorAction->add($indicatorAction);

        return $this;
    }

    /**
     * Remove indicatorAction
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $indicatorAction
     */
    public function removeIndicatorAction(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $indicatorAction) {
        $this->indicatorAction->removeElement($indicatorAction);
    }

    /**
     * Get indicatorAction
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorAction() {
        return $this->indicatorAction;
    }      
}
