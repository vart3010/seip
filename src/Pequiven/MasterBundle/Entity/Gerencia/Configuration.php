<?php

namespace Pequiven\MasterBundle\Entity\Gerencia;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Configuracion de la gerencia
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_gerencia_configuration")
 * @ORM\Entity()
 */
class Configuration 
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
     * Usuarios que revisa el programa de gestion
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="Configuration_Reviser",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramUserToRevisers;
    
    /**
     * Usuario que aprueba el programa de gestion tactico
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrangementProgramUserToApproveTactical;
    
    /**
     * Usuario que aprueba el programa de gestion operativo
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrangementProgramUserToApproveOperative;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arrangementProgramUserToRevisers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Configuration
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
     * @return Configuration
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
     * Add arrangementProgramUserToRevisers
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToRevisers
     * @return Configuration
     */
    public function addArrangementProgramUserToReviser(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToRevisers)
    {
        $this->arrangementProgramUserToRevisers->add($arrangementProgramUserToRevisers);

        return $this;
    }

    /**
     * Remove arrangementProgramUserToRevisers
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToRevisers
     */
    public function removeArrangementProgramUserToReviser(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToRevisers)
    {
        $this->arrangementProgramUserToRevisers->removeElement($arrangementProgramUserToRevisers);
    }

    /**
     * Get arrangementProgramUserToRevisers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramUserToRevisers()
    {
        return $this->arrangementProgramUserToRevisers;
    }

    /**
     * Set arrangementProgramUserToApproveTactical
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToApproveTactical
     * @return Configuration
     */
    public function setArrangementProgramUserToApproveTactical(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToApproveTactical)
    {
        $this->arrangementProgramUserToApproveTactical = $arrangementProgramUserToApproveTactical;

        return $this;
    }

    /**
     * Get arrangementProgramUserToApproveTactical
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getArrangementProgramUserToApproveTactical()
    {
        return $this->arrangementProgramUserToApproveTactical;
    }

    /**
     * Set arrangementProgramUserToApproveOperative
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToApproveOperative
     * @return Configuration
     */
    public function setArrangementProgramUserToApproveOperative(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUserToApproveOperative)
    {
        $this->arrangementProgramUserToApproveOperative = $arrangementProgramUserToApproveOperative;

        return $this;
    }

    /**
     * Get arrangementProgramUserToApproveOperative
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getArrangementProgramUserToApproveOperative()
    {
        return $this->arrangementProgramUserToApproveOperative;
    }
}
