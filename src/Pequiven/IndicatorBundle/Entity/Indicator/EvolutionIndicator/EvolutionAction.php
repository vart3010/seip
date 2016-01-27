<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionAction as Model;

/**
 * Plan de Acción y Seguimiento del informe de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_report_evolution_action")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\Indicator\EvolutionIndicator\EvolutionActionRepository") 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class EvolutionAction extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause", inversedBy="indicatorAction")
     * @ORM\JoinColumn(name="cause_id", referencedColumnName="id")
     */
    private $evolutionCause;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeObject", type="integer")
     */
    private $typeObject; 

    /**
     * @var string
     *
     * @ORM\Column(name="ref" , type="string", length=50)
     */
    private $ref;
    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    private $action;

    /**
     * @var integer
     *
     *  @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dateEnd", type="datetime", nullable=true)
     */
    private $dateEnd;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
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
     * @ORM\ManyToOne(targetEntity="\Pequiven\SIGBundle\Entity\TypeActionManagementSystem", inversedBy="typeAction")
     * @ORM\JoinColumn(name="typeAction_id", referencedColumnName="id")
     */
    private $indicatorAction;

    /**
     * Relacion de la Verificación con el Plan de Acción 
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification",mappedBy="actionPlan",cascade={"persist","remove"})
     */
    protected $verificationRel;

    /**
     * Valores y Observación de las Acciones
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue",mappedBy="actionValue",cascade={"persist","remove"})
     */
    protected $relactionValue;

    /**
     * Responsables
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="responsible_id", referencedColumnName="id")
     */
    private $responsibles;

    /**
     * Responsables
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User",inversedBy="evolutionAction", cascade={"persist","remove"})     
     * @ORM\JoinTable(name="seip_report_evolution_action_responsibles")    
     */
    private $responsible;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->verificationRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relactionValue = new \Doctrine\Common\Collections\ArrayCollection();        
        $this->responsible = new \Doctrine\Common\Collections\ArrayCollection();        
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
     * Set evolutionCause
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause $evolutionCause
     * @return Indicator
     */
    public function setEvolutionCause(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause $evolutionCause) {
        
        $this->evolutionCause = $evolutionCause;

        return $this;
    }

    /**
     * Get evolutionCause
     *
     * @return Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause
     */
    public function getEvolutionCause() {
        return $this->evolutionCause;
    }

    /**
     * 
     * @param type $ref
     * @return type
     */
    public function setRef($ref) {
        $this->ref = $ref;
        return $ref;
    }

    /**
     * 
     * @return type
     */
    public function getRef() {
        return $this->ref;
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
     * @param type $status
     * @return type
     */
    public function setStatus($status) {
        $this->status = $status;
        return $status;
    }

    /**
     * 
     * @return type
     */
    public function getStatus() {
        return $this->status;
    }

    
    /**
     * 
     * @param type $action
     * @return type
     */
    public function setAction($action) {
        $this->action = $action;
        return $action;
    }

    /**
     * 
     * @return type
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * 
     * @param type $dateStart
     * @return type
     */
    public function setDateStart($dateStart) {
        $this->dateStart = $dateStart;
        return $dateStart;
    }

    /**
     * 
     * @return type
     */
    public function getDateStart() {
        return $this->dateStart;
    }

    /**
     * 
     * @param type $dateEnd
     * @return type
     */
    public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;
        return $dateEnd;
    }

    /**
     * 
     * @return type
     */
    public function getDateEnd() {
        return $this->dateEnd;
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
     * Set indicatorAction
     *
     * @param \Pequiven\SIGBundle\Entity\TypeActionManagementSystem $indicatorAction
     */
    public function setIndicatorAction(\Pequiven\SIGBundle\Entity\TypeActionManagementSystem $indicatorAction) {
        
        $this->indicatorAction = $indicatorAction;

        return $this;
    }

    /**
     * Get indicatorAction
     *
     * @return Pequiven\SIGBundle\Entity\TypeActionManagementSystem
     */
    public function getIndicatorAction() {
        return $this->indicatorAction;
    }

    //
    /**
     * Add verificationRel
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationRel
     */
    public function addVerificationRel(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationRel) {

        $this->verificationRel->add($verificationRel);

        return $this;
    }

    /**
     * Remove verificationRel
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $verificationRel
     */
    public function removeVerificationRel(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification $verificationRel) {
        $this->verificationRel->removeElement($verificationRel);
    }

    /**
     * Get verificationRel
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVerificationRel() {
        return $this->verificationRel;
    }

    /**
     * Add relactionValue
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue $relactionValue
     * @return Indicator
     */
    public function addRelactionValue(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue $relactionValue) {

        $this->relactionValue->add($relactionValue);

        return $this;
    }

    /**
     * Remove relactionValue
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue $relactionValue
     */
    public function removeReclationValue(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue $relactionValue) {
        $this->relactionValue->removeElement($relactionValue);
    }

    /**
     * Get relactionValue
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelactionValue() {
        return $this->relactionValue;
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
     * Get responsibles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsibles() {
        return $this->responsibles;
    }

    /**
     * 
     * @param type $responsibles
     * @return type
     */
    public function setResponsibles($responsibles) {
        $this->responsibles = $responsibles;
        return $responsibles;
    }

    //responsable
    /**
     * Add responsible
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsible
     * @return Indicator
     */
    public function addResponsible(\Pequiven\SEIPBundle\Entity\User $responsible) {
        $this->responsible[] = $responsible;

        return $this;
    }

    /**
     * Remove responsible
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsible
     */
    public function removeResponsible(\Pequiven\SEIPBundle\Entity\User $responsible) {
        $this->responsible->removeElement($responsible);
    }

    /**
     * Get responsible
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsible() {
        return $this->responsible;
    }
    
}
