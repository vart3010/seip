<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\GerenciaSecond as modelGerenciaSecond;
use Pequiven\MasterBundle\Model\Evaluation\AuditableInterface;
use Pequiven\MasterBundle\Entity\Coordinacion;

/**
 * Gerencia de segunda linea
 *
 * @ORM\Table(name="seip_c_gerencia_second",uniqueConstraints={@ORM\UniqueConstraint(name="abbreviation_second_idx", columns={"abbreviation"})})
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\GerenciaSecondRepository")
 * @author matias
 */
class GerenciaSecond extends modelGerenciaSecond {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    protected $description;

    /** Complejo
     * @var=\Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;

    /** Gerencia
     * @var=\Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=100, nullable=true)
     */
    private $ref;

    /**
     * Abreviatura
     * @var string
     *
     * @ORM\Column(name="abbreviation", type="string", length=100, nullable=true)
     */
    private $abbreviation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modular", type="boolean", nullable=true)
     */
    private $modular = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vinculante", type="boolean", nullable=true)
     */
    private $vinculante = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * Configuracion de la gerencia
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia\Configuration 
     * @ORM\OneToOne(targetEntity="Pequiven\MasterBundle\Entity\Gerencia\Configuration")
     */
    protected $configuration;

    /**
     * Objetivos operativos de la gerencia de segunda linea
     * 
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     * @ORM\OneToMany(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive",mappedBy="gerenciaSecond")
     */
    private $operationalObjectives;

    /**
     * Gerencia Vinculante
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia", mappedBy="gerenciaSecondVinculants")
     */
    private $gerenciaVinculants;

    /**
     * Gerencia Apoyo
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia", mappedBy="gerenciaSecondSupports")
     */
    private $gerenciaSupports;

    /**
     * @var \Pequiven\MasterBundle\Entity\Coordinacion
     * @ORM\OneToMany(targetEntity="\Pequiven\MasterBundle\Entity\Coordinacion", mappedBy="gerenciasecond",cascade={"persist","remove"})
     */
    private $coordinaciones;

    /**
     * Es valida la uditoria para ser evaluado
     * @var boolean
     * @ORM\Column(name="validAudit",type="boolean")
     */
    private $validAudit = true;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", mappedBy="gerenciaSeconds")
     */
    private $workStudyCircles;

    /**
     * @var \Pequiven\SEIPBundle\Entity\User\FeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User\FeeStructure", mappedBy="gerenciasecond",cascade={"persist","remove"})
     */
    private $feeStructure;

    public function __construct() {
        parent::__construct();
        $this->operationalObjectives = new ArrayCollection();
        $this->gerenciaVinculants = new ArrayCollection();
        $this->gerenciaSupports = new ArrayCollection();
        $this->workStudyCircles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->coordinaciones = new ArrayCollection();
        $this->feeStructure = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * Set description
     *
     * @param string $description
     * @return GerenciaSecond
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return GerenciaSecond
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return GerenciaSecond
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null) {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt() {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return GerenciaSecond
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null) {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt() {
        return $this->userUpdatedAt;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return GerenciaSecond
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null) {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia() {
        return $this->gerencia;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return GerenciaSecond
     */
    public function setRef($ref) {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * Set complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return GerenciaSecond
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null) {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo() {
        return $this->complejo;
    }

    /**
     * Set modular
     *
     * @param boolean $modular
     * @return GerenciaSecond
     */
    public function setModular($modular) {
        $this->modular = $modular;

        return $this;
    }

    /**
     * Get modular
     *
     * @return boolean 
     */
    public function getModular() {
        return $this->modular;
    }

    /**
     * Set vinculante
     *
     * @param boolean $vinculante
     * @return GerenciaSecond
     */
    public function setVinculante($vinculante) {
        $this->vinculante = $vinculante;

        return $this;
    }

    /**
     * Get vinculante
     *
     * @return boolean 
     */
    public function getVinculante() {
        return $this->vinculante;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     * @return GerenciaSecond
     */
    public function setAbbreviation($abbreviation) {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string 
     */
    public function getAbbreviation() {
        return $this->abbreviation;
    }

    /**
     * Set configuration
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia\Configuration $configuration
     * @return GerenciaSecond
     */
    public function setConfiguration(\Pequiven\MasterBundle\Entity\Gerencia\Configuration $configuration = null) {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia\Configuration 
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * Add operationalObjectives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjectives
     * @return GerenciaSecond
     */
    public function addOperationalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjectives) {
        $this->operationalObjectives->add($operationalObjectives);

        return $this;
    }

    /**
     * Remove operationalObjectives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjectives
     */
    public function removeOperationalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $operationalObjectives) {
        $this->operationalObjectives->removeElement($operationalObjectives);
    }

    /**
     * Get operationalObjectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperationalObjectives() {
        return $this->operationalObjectives;
    }

    /**
     * Add gerenciaVinculants
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerenciaVinculants
     * @return GerenciaSecond
     */
    public function addGerenciaVinculant(\Pequiven\MasterBundle\Entity\Gerencia $gerenciaVinculants) {
        $gerenciaVinculants->addGerenciaSecond($this);
        $this->gerenciaVinculants[] = $gerenciaVinculants;

        return $this;
    }

    /**
     * Remove gerenciaVinculants
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerenciaVinculants
     */
    public function removeGerenciaVinculant(\Pequiven\MasterBundle\Entity\Gerencia $gerenciaVinculants) {
        $this->gerenciaVinculants->removeElement($gerenciaVinculants);
    }

    /**
     * Get gerenciaVinculants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerenciaVinculants() {
        return $this->gerenciaVinculants;
    }

    /**
     * Add gerenciaSupports
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerenciaSupports
     * @return GerenciaSecond
     */
    public function addGerenciaSupport(\Pequiven\MasterBundle\Entity\Gerencia $gerenciaSupports) {
        $gerenciaSupports->addGerenciaSecond($this);
        $this->gerenciaSupports[] = $gerenciaSupports;

        return $this;
    }

    /**
     * Remove gerenciaSupports
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerenciaSupports
     */
    public function removeGerenciaSupport(\Pequiven\MasterBundle\Entity\Gerencia $gerenciaSupports) {
        $this->gerenciaSupports->removeElement($gerenciaSupports);
    }

    /**
     * Get gerenciaSupports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerenciaSupports() {
        return $this->gerenciaSupports;
    }

    /**
     * Set validAudit
     *
     * @param boolean $validAudit
     * @return GerenciaSecond
     */
    public function setValidAudit($validAudit) {
        $this->validAudit = $validAudit;

        return $this;
    }

    /**
     * Get validAudit
     *
     * @return boolean 
     */
    public function getValidAudit() {
        return $this->validAudit;
    }

    /**
     * Is validAudit
     *
     * @return boolean 
     */
    public function isValidAudit() {
        return $this->validAudit;
    }

    /**
     * 
     * @return type
     */
    function getCoordinaciones() {
        return $this->coordinaciones;
    }

    /**
     * 
     * @param Coordinacion $coordinaciones
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond
     */
    function addCoordinaciones(Coordinacion $coordinaciones) {
        $this->coordinaciones->add($coordinaciones);
        return $this;
    }

    /**
     * 
     * @param Coordinacion $coordinaciones
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond
     */
    function removeCoordinaciones(Coordinacion $coordinaciones) {
        $this->coordinaciones->removeElement($coordinaciones);
        return $this;
    }

    public function getgerenciaPrimera() {
        $full = sprintf("%s", $this->getGerencia()->getDescription());
        return $full;
    }

}
