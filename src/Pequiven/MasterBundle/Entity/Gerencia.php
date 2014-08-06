<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Gerencia as modelGerencia;

/**
 * Gerencia
 *
 * @ORM\Table(name="seip_c_gerencia")
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\GerenciaRepository")
 */
class Gerencia extends modelGerencia
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;
    
    /** Complejo
     * @var=\Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
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
}
