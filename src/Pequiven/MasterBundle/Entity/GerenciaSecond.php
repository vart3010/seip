<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\GerenciaSecond as modelGerenciaSecond;

/**
 * Gerencia de segunda linea
 *
 * @ORM\Table(name="seip_c_gerencia_second",uniqueConstraints={@ORM\UniqueConstraint(name="abbreviation_idx", columns={"abbreviation"})})
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
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return GerenciaSecond
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null)
    {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia()
    {
        return $this->gerencia;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return GerenciaSecond
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
     * Set complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return GerenciaSecond
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null)
    {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo()
    {
        return $this->complejo;
    }

    /**
     * Set modular
     *
     * @param boolean $modular
     * @return GerenciaSecond
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
     * @return GerenciaSecond
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
     * Set abbreviation
     *
     * @param string $abbreviation
     * @return GerenciaSecond
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
     * Set configuration
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia\Configuration $configuration
     * @return GerenciaSecond
     */
    public function setConfiguration(\Pequiven\MasterBundle\Entity\Gerencia\Configuration $configuration = null)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia\Configuration 
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
