<?php

namespace Pequiven\SEIPBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Localizacion
 *
 * @author inhack20
 * @ORM\Entity()
 * @ORM\Table(name="seip_user_location")
 */
class Localization
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer 
     */
    protected $id;
    
    /**
     * Configuracion del usuario
     * 
     * @var \Pequiven\SEIPBundle\Entity\User\Configuration
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User\Configuration",inversedBy="localizations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $configuration;
    
    /** 
     * Localidad
     * 
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    
    /**
     * Gerencia de primera linea
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gerencia;
    
    /**
     * Gerencia de segunda linea
     * 
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond")
     */
    private $gerenciaSecond;
    
    /**
     * Rol en la localizacion
     * 
     * @var \Pequiven\MasterBundle\Entity\Rol
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Rol")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $rol;
    
    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * Set configuration
     *
     * @param \Pequiven\SEIPBundle\Entity\User\Configuration $configuration
     * @return Localization
     */
    public function setConfiguration(\Pequiven\SEIPBundle\Entity\User\Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Pequiven\SEIPBundle\Entity\User\Configuration 
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Set location
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $location
     * @return Localization
     */
    public function setLocation(\Pequiven\MasterBundle\Entity\Complejo $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return Localization
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia)
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
     * Set gerenciaSecond
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond
     * @return Localization
     */
    public function setGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond = null)
    {
        $this->gerenciaSecond = $gerenciaSecond;

        return $this;
    }

    /**
     * Get gerenciaSecond
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond 
     */
    public function getGerenciaSecond()
    {
        return $this->gerenciaSecond;
    }

    /**
     * Set rol
     *
     * @param \Pequiven\MasterBundle\Entity\Rol $rol
     * @return Localization
     */
    public function setRol(\Pequiven\MasterBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \Pequiven\MasterBundle\Entity\Rol 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Localization
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
     * @return Localization
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
}
