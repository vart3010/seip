<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Gerencia as modelGerencia;
use Pequiven\MasterBundle\Model\Evaluation\AuditableInterface;

/**
 * Gerencia de primera linea
 *
 * @ORM\Table(name="seip_c_gerencia",uniqueConstraints={@ORM\UniqueConstraint(name="abbreviation_idx", columns={"abbreviation"})})
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\GerenciaRepository")
 * @author matias
 */
class Gerencia extends modelGerencia implements AuditableInterface
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
     * Descripción
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    protected $description;
    
    /** 
     * Complejo
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo",inversedBy="gerencias")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;
    
    /** 
     * Dirección
     * @var \Pequiven\MasterBundle\Entity\Direction
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Direction")
     * @ORM\JoinColumn(name="fk_direction", referencedColumnName="id")
     */
    private $direction;
    
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
     * @ORM\OneToOne(targetEntity="Pequiven\MasterBundle\Entity\Gerencia\Configuration",cascade={"persist","remove"})
     */
    protected $configuration;

    /**
     * Objetivos operativos de la gerencia de primera linea
     * 
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     * @ORM\OneToMany(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive",mappedBy="gerencia")
     */
    private $tacticalObjectives;
    
    /**
     * Grupo de la gerencia
     * 
     * @var \Pequiven\MasterBundle\Entity\GerenciaGroup
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaGroup")
     */
    private $gerenciaGroup;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond", inversedBy="gerenciaVinculants")
     * @ORM\JoinTable(name="seip_gerencia_second_vinculant")
     */
    private $gerenciaSecondVinculants;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond", inversedBy="gerenciaSupports")
     * @ORM\JoinTable(name="seip_gerencia_second_support")
     */
    private $gerenciaSecondSupports;
    
    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=50, nullable=true)
     */
    private $resume;
    
    /**
     * Es válida la auditoria para ser evaluado
     * @var boolean
     * @ORM\Column(name="validAudit",type="boolean")
     */
    private $validAudit = true;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", mappedBy="gerencias")
     */
    private $workStudyCircles;
    
    /**
     * @var \Pequiven\SEIPBundle\Entity\User\FeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User\FeeStructure", mappedBy="gerencia",cascade={"persist","remove"})
     */
    private $feeStructure;

    /**
     * @var string
     *
     * @ORM\Column(name="normalizedManagement", type="boolean", nullable=true)
     */
    private $normalizedManagement = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gerenciaSecondVinculants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gerenciaSecondSupports = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tacticalObjectives = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workStudyCircles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feeStructure = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Gerencia
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Gerencia
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Gerencia
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Gerencia
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Gerencia
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null)
    {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt()
    {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Gerencia
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null)
    {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt()
    {
        return $this->userUpdatedAt;
    }

    /**
     * Set Complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return Gerencia
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null)
    {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get Complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo()
    {
        return $this->complejo;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Gerencia
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set modular
     *
     * @param boolean $modular
     * @return Gerencia
     */
    public function setModular($modular)
    {
        $this->modular = $modular;

        return $this;
    }

    /**
     * Get modular
     *
     * @return boolean 
     */
    public function getModular()
    {
        return $this->modular;
    }

    /**
     * Set vinculante
     *
     * @param boolean $vinculante
     * @return Gerencia
     */
    public function setVinculante($vinculante)
    {
        $this->vinculante = $vinculante;

        return $this;
    }

    /**
     * Get vinculante
     *
     * @return boolean 
     */
    public function getVinculante()
    {
        return $this->vinculante;
    }

    /**
     * Set direction
     *
     * @param \Pequiven\MasterBundle\Entity\Direction $direction
     * @return Gerencia
     */
    public function setDirection(\Pequiven\MasterBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Pequiven\MasterBundle\Entity\Direction 
     */
    public function getDirection()
    {
        return $this->direction;
    }
    
    function getConfiguration() {
        return $this->configuration;
    }

    function setConfiguration(\Pequiven\MasterBundle\Entity\Gerencia\Configuration $configuration) {
        $this->configuration = $configuration;
        
        return $this;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     * @return Gerencia
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string 
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Add tacticalObjectives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjectives
     * @return Gerencia
     */
    public function addTacticalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjectives)
    {
        $this->tacticalObjectives->add($tacticalObjectives);

        return $this;
    }

    /**
     * Remove tacticalObjectives
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjectives
     */
    public function removeTacticalObjective(\Pequiven\ObjetiveBundle\Entity\Objetive $tacticalObjectives)
    {
        $this->tacticalObjectives->removeElement($tacticalObjectives);
    }

    /**
     * Get tacticalObjectives
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTacticalObjectives()
    {
        return $this->tacticalObjectives;
    }

    /**
     * Set gerenciaGroup
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaGroup $gerenciaGroup
     * @return Gerencia
     */
    public function setGerenciaGroup(\Pequiven\MasterBundle\Entity\GerenciaGroup $gerenciaGroup = null)
    {
        $this->gerenciaGroup = $gerenciaGroup;

        return $this;
    }

    /**
     * Get gerenciaGroup
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaGroup 
     */
    public function getGerenciaGroup()
    {
        return $this->gerenciaGroup;
    }


    /**
     * Add gerenciaSecondVinculants
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondVinculants
     * @return Gerencia
     */
    public function addGerenciaSecondVinculant(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondVinculants)
    {
        $this->gerenciaSecondVinculants[] = $gerenciaSecondVinculants;

        return $this;
    }

    /**
     * Remove gerenciaSecondVinculants
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondVinculants
     */
    public function removeGerenciaSecondVinculant(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondVinculants)
    {
        $this->gerenciaSecondVinculants->removeElement($gerenciaSecondVinculants);
    }

    /**
     * Get gerenciaSecondVinculants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerenciaSecondVinculants()
    {
        return $this->gerenciaSecondVinculants;
    }

    /**
     * Add gerenciaSecondSupports
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondSupports
     * @return Gerencia
     */
    public function addGerenciaSecondSupport(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondSupports)
    {
        $this->gerenciaSecondSupports[] = $gerenciaSecondSupports;

        return $this;
    }

    /**
     * Remove gerenciaSecondSupports
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondSupports
     */
    public function removeGerenciaSecondSupport(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecondSupports)
    {
        $this->gerenciaSecondSupports->removeElement($gerenciaSecondSupports);
    }

    /**
     * Get gerenciaSecondSupports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerenciaSecondSupports()
    {
        return $this->gerenciaSecondSupports;
    }
    
    /**
     * Get Resume
     * @return type
     */
    function getResume() {
        return $this->resume;
    }

    /**
     * Set Resume
     * @param type $resume
     */
    function setResume($resume) {
        $this->resume = $resume;
    }
    

    /**
     * Set validAudit
     *
     * @param boolean $validAudit
     * @return Gerencia
     */
    public function setValidAudit($validAudit)
    {
        $this->validAudit = $validAudit;

        return $this;
    }

    /**
     * Get validAudit
     *
     * @return boolean 
     */
    public function getValidAudit()
    {
        return $this->validAudit;
    }

    /**
     * Is validAudit
     *
     * @return boolean 
     */
    public function isValidAudit()
    {
        return $this->validAudit;
    }
    
    function getFeeStructure() {
        return $this->feeStructure;
    }

    function setFeeStructure(\Pequiven\SEIPBundle\Entity\User\FeeStructure $feeStructure) {
        $this->feeStructure = $feeStructure;
    }

    /**
     * Set normalizedManagement
     *
     * @param \DateTime $normalizedManagement
     * @return Gerencia
     */
    public function setNormalizedManagement($normalizedManagement)
    {
        $this->normalizedManagement = $normalizedManagement;

        return $this;
    }

    /**
     * Get normalizedManagement
     *
     * @return \DateTime 
     */
    public function getNormalizedManagement()
    {
        return $this->normalizedManagement;
    }

}

