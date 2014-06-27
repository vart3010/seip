<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

/**
 * Personal
 *
 * @ORM\Table(name="seip_personal")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Model\PersonalRepository")
 * 
 */
class Personal
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
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer")
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_personal", type="string", length=100)
     */
    private $nomPersonal;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_personal", type="integer")
     */
    private $numPersonal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="fk_cargo", type="integer", nullable=true)
     */
    private $fkCargo;
    
    /** Cargo
     * @var=\Pequiven\SEIPBundle\Entity\Cargo
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Cargo")
     * @ORM\JoinColumn(name="fk_cargo", referencedColumnName="id")
     */
    private $cargo;


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
     * @return Personal
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
     * @return Personal
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
     * Set cedula
     *
     * @param integer $cedula
     * @return Personal
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return integer 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set nomPersonal
     *
     * @param string $nomPersonal
     * @return Personal
     */
    public function setNomPersonal($nomPersonal)
    {
        $this->nomPersonal = $nomPersonal;

        return $this;
    }

    /**
     * Get nomPersonal
     *
     * @return string 
     */
    public function getNomPersonal()
    {
        return $this->nomPersonal;
    }

    /**
     * Set numPersonal
     *
     * @param integer $numPersonal
     * @return Personal
     */
    public function setNumPersonal($numPersonal)
    {
        $this->numPersonal = $numPersonal;

        return $this;
    }

    /**
     * Get numPersonal
     *
     * @return integer 
     */
    public function getNumPersonal()
    {
        return $this->numPersonal;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Personal
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
     * Set fkCargo
     *
     * @param integer $fkCargo
     * @return Personal
     */
    public function setFkCargo($fkCargo)
    {
        $this->fkCargo = $fkCargo;

        return $this;
    }

    /**
     * Get fkCargo
     *
     * @return integer 
     */
    public function getFkCargo()
    {
        return $this->fkCargo;
    }

    /**
     * Set cargo
     *
     * @param \Pequiven\SEIPBundle\Entity\Cargo $cargo
     * @return Personal
     */
    public function setCargo(\Pequiven\SEIPBundle\Entity\Cargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \Pequiven\SEIPBundle\Entity\Cargo 
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}


