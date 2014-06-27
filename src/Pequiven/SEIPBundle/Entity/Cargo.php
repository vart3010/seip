<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;

/**
 * Cargos
 *
 * @ORM\Table(name="seip_cargo")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Entity\CargoRepository")
 */
class Cargo
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_gerencia", type="integer", nullable=true)
     */
    private $fkGerencia;
    
    /** Gerencia
     * @var=\Pequiven\SEIPBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


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
     * @return Cargos
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
     * @return Cargos
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
     * @return Cargos
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
     * @return Cargo
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (Boolean) $enabled;

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
     * Set fkGerencia
     *
     * @param integer $fkGerencia
     * @return Cargo
     */
    public function setFkGerencia($fkGerencia)
    {
        $this->fkGerencia = $fkGerencia;

        return $this;
    }

    /**
     * Get fkGerencia
     *
     * @return integer 
     */
    public function getFkGerencia()
    {
        return $this->fkGerencia;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\SEIPBundle\Entity\Gerencia $gerencia
     * @return Cargo
     */
    public function setGerencia(\Pequiven\SEIPBundle\Entity\Gerencia $gerencia = null)
    {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\SEIPBundle\Entity\Gerencia 
     */
    public function getGerencia()
    {
        return $this->gerencia;
    }
}
