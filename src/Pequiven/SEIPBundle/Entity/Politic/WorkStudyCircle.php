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
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia", inversedBy="workStudyCircles")
     */
    private $gerencias;

    /**
     * GerenciaSeconds
     * 
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond", inversedBy="workStudyCircles")
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
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User", mappedBy="workStudyCircle")
     **/
    private $userWorkerId;

    /**
     * Constructor
     */
    public function __construct() {
        $this->userWorkerId = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gerencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gerenciaSeconds = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->members = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ArrangementProgram
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

}
