<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Gerencia
 *
 * @ORM\Table(name="seip_gerencia")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Entity\GerenciaRepository")
 */
class Gerencia
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
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * 
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="fk_complejo", type="integer", nullable=true)
     */
    private $fkComplejo;

    /** Complejo
     * @var=\Pequiven\SEIPBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;

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
     * Set fkComplejo
     *
     * @param integer $fkComplejo
     * @return Gerencia
     */
    public function setFkComplejo($fkComplejo)
    {
        $this->fkComplejo = $fkComplejo;

        return $this;
    }

    /**
     * Get fkComplejo
     *
     * @return integer 
     */
    public function getFkComplejo()
    {
        return $this->fkComplejo;
    }
    
    /**
     * Set complejo
     *
     * @param \Pequiven\SEIPBundle\Entity\Complejo $complejo
     * @return Gerencia
     */
    public function setComplejo(\Pequiven\SEIPBundle\Entity\Complejo $complejo = null)
    {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get complejo
     *
     * @return \Pequiven\SEIPBundle\Entity\Complejo 
     */
    public function getComplejo()
    {
        return $this->complejo;
    }
}
