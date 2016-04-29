<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Politic\WorkStudyCircle as ModelWorkStudyCircle;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Estudio de Círculo de Trabajo
 *
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Politic\WorkStudyCircleRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class WorkStudyCircle extends ModelWorkStudyCircle implements PeriodItemInterface {

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
     * @ORM\JoinColumn(nullable=true)
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
     * Referencia del círculo de estudio de trabajo
     * @var string
     * @ORM\Column(name="codigo",type="string",length=20,nullable=true)
     */
    private $codigo = null;

    /**
     * Nombre del círculo de estudio de trabajo
     * @var string
     * @ORM\Column(name="name",type="string",length=100,nullable=false)
     */
    private $name = null;

    /**
     * Region
     * @var \Pequiven\SEIPBundle\Entity\CEI\Region
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Region")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * Complejo
     * @var \Pequiven\MasterBundle\Entity\Complejo
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $complejo;

    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;

    /**
     * Gerencias
     * 
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia", inversedBy="workStudyCircles", cascade={"persist","remove"})
     */
    private $gerencias;

    /**
     * GerenciaSeconds
     * 
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond", inversedBy="workStudyCircles", cascade={"persist","remove"})
     */
    private $gerenciaSeconds;

    /**
     * superintendencia
     * @var string
     * @ORM\Column(name="superintendencia",type="string",length=100,nullable=true)
     */
    private $superintendencia;

    /**
     * supervision
     * @var string
     * @ORM\Column(name="supervision",type="string",length=100,nullable=true)
     */
    private $supervision;

    /**
     * departamento
     * @var string
     * @ORM\Column(name="departamento",type="string",length=100,nullable=true)
     */
    private $departamento;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User", mappedBy="workStudyCircle", cascade={"persist"})
     * */
    private $userWorkerId;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\Meeting", mappedBy="workStudyCircle")
     */
    private $meetings;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\Proposal", mappedBy="workStudyCircle")
     */
    private $proposals;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Miembros
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User", inversedBy="workStudyCircles", cascade={"persist","remove"})
     */
    private $members;
    
    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coordinator;
    
        
    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coordinatorDiscussion;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="phase", type="integer", nullable=true)
     */
    private $phase = self::PHASE_ONE;
    
    /**
     * CET al que pertenece este CET
     * 
     * @var \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle",inversedBy="childrens",cascade={"persist"})
     */
    protected $parent;

    /**
     * Círculos de Estudio de Trabajo que pertenecen a este CET
     * 
     * @var \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle",mappedBy="parent",cascade={"persist"}))
     */
    protected $childrens;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="houseSupplyGroup", type="integer", nullable=true)
     */

    private $houseSupplyGroup = 0;

    /**
     * Constructor
     */
    public function __construct() {
        $this->userWorkerId = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gerencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gerenciaSeconds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->meetings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->proposals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return WorkStudyCircle
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
     * @return WorkStudyCircle
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

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    /**
     * Get Name
     * @return type
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set Name
     * @param type $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set region
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Region $region
     * @return WorkStudyCircle
     */
    public function setRegion(\Pequiven\SEIPBundle\Entity\CEI\Region $region) {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Region 
     */
    public function getRegion() {
        return $this->region;
    }

    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo) {
        $this->complejo = $complejo;

        return $this;
    }

    public function getComplejo() {
        return $this->complejo;
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
     * @return WorkStudyCircle
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $members
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function addMembers(\Pequiven\SEIPBundle\Entity\User $members) {
        $this->members->add($members);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $members
     */
    public function removeMembers(\Pequiven\SEIPBundle\Entity\User $members) {
        $this->members->removeElement($members);
    }

    /**
     * 
     * @return type
     */
    public function getMembers() {
        return $this->members;
    }

    public function getSuperintendencia() {
        return $this->superintendencia;
    }

    public function setSuperintendencia($superintendencia) {
        $this->superintendencia = $superintendencia;
    }

    public function getSupervision() {
        return $this->supervision;
    }

    public function setSupervision($supervision) {
        $this->supervision = $supervision;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $userWorkerId
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function setUserWorkerId(\Pequiven\SEIPBundle\Entity\User $userWorkerId) {
        $this->userWorkerId = $userWorkerId;

        return $this;
    }

    public function getUserWorkerId() {
        return $this->userWorkerId;
    }

    /**
     * Add gerencias
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencias
     * @return WorkStudyCircle
     */
    public function addGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencias) {
        $this->gerencias[] = $gerencias;

        return $this;
    }

    /**
     * Remove gerencias
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencias
     */
    public function removeGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencias) {
        $this->gerencias->removeElement($gerencias);
    }

    /**
     * Get gerencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerencias() {
        return $this->gerencias;
    }

    /**
     * Add gerenciaSeconds
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSeconds
     * @return WorkStudyCircle
     */
    public function addGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSeconds) {
        $this->gerenciaSeconds[] = $gerenciaSeconds;

        return $this;
    }

    /**
     * Remove gerenciaSeconds
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSeconds
     */
    public function removeGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSeconds) {
        $this->gerenciaSeconds->removeElement($gerenciaSeconds);
    }

    /**
     * Get gerenciaSeconds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerenciaSeconds() {
        return $this->gerenciaSeconds;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Meeting $meeting
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function addMeeting(Meeting $meeting) {
        $this->meetings->add($meeting);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Meeting $meeting
     */
    public function removeMeeting(Meeting $meeting) {
        $this->meetings->removeElement($meeting);
    }

    /**
     * 
     * @return type
     */
    public function getMeeting() {
        return $this->meetings;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Proposal $proposal
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function addProposal(Proposal $proposal) {
        $this->proposals->add($proposal);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Proposal $proposal
     */
    public function removeProposal(Proposal $proposal) {
        $this->proposals->removeElement($proposal);
    }

    /**
     * 
     * @return type
     */
    public function getProposals() {
        return $this->proposals;
    }
    
    /**
     * Get Coordinator
     * @return type
     */
    function getCoordinator() {
        return $this->coordinator;
    }

    /**
     * Set Coordinator
     * @param \Pequiven\SEIPBundle\Entity\User $coordinator
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    function setCoordinator(\Pequiven\SEIPBundle\Entity\User $coordinator) {
        $this->coordinator = $coordinator;
        return $this;
    }
    
    /**
     * Get CoordinatorDiscussion
     * @return type
     */
    function getCoordinatorDiscussion() {
        return $this->coordinatorDiscussion;
    }

    /**
     * Set CoordinatorDiscussion
     * @param \Pequiven\SEIPBundle\Entity\User $coordinatorDiscussion
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    function setCoordinatorDiscussion(\Pequiven\SEIPBundle\Entity\User $coordinatorDiscussion) {
        $this->coordinatorDiscussion = $coordinatorDiscussion;
        return $this;
    }
    
    /**
     * Set Fase
     *
     * @param integer $phase
     * @return WorkStudyCircle
     */
    public function setPhase($phase) {
        $this->phase = $phase;

        return $this;
    }

    /**
     * Get Fase
     *
     * @return integer
     */
    public function getPhase() {
        return $this->phase;
    }
    
    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $parent
     * @return WorkStudyCircle
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $childrens
     * @return WorkStudyCircle
     */
    public function addChildren(\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $childrens) {
        $childrens->setParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $childrens
     */
    public function removeChildren(\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $childrens) {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens() {
        return $this->childrens;
    }
    
    /**
     * Retorna los miembros de un CET, sin contar al coordinador
     * @return type
     */
    public function obtainMembersWithoutCoordinator(){
        $members = array();
        if($this->id > 0){
            if($this->coordinator != null){
                foreach($this->members as $member){
                    if($this->getCoordinator()->getId() != $member->getId()){
                        array_push($members, $member);
                    }
                }
            } else{
                $members = $this->members;
            }
        }
            
        return $members;
    }
    
    public function getHouseSupplyGroup() {
        return $this->houseSupplyGroup;
    }

    public function setHouseSupplyGroup($houseSupplyGroup) {
        $this->houseSupplyGroup = $houseSupplyGroup;
    }

}
