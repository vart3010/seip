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
     * Usuarios que revisan el programa de gestion
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="Configuration_ArrangementProgram_Reviser",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramUserToRevisers;
    
    /**
     * Usuarios que aprueban el programa de gestion tactico
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="Configuration_ArrangementProgram_Approve_Tactical",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramUsersToApproveTactical;
    
    /**
     * Usuarios que aprueban el programa de gestion operativo
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="Configuration_ArrangementProgram_Approve_Operative",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramUsersToApproveOperative;
    
    /**
     * Usuarios que notifican los avances en el programa de gestion
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="Configuration_ArrangementProgram_Notify",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramUsersToNotify;
    
    /**
     * Usuarios que revisan el programa de gestión de Hallazgos SIG
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="ConfigurationSIG_ArrangementProgram_Reviser",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramSigUsersToReviser;
    
    /**
     * Usuarios que aprueban el programa de gestión de Hallazgos SIG
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="ConfigurationSIG_ArrangementProgram_Approve",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramSigUsersToApprove;
    
    /**
     * Usuarios que notifican los avances en el programa de gestión de Hallazgos SIG
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinTable(name="ConfigurationSIG_ArrangementProgram_Notify",
     *      joinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $arrangementProgramSigUsersToNotify;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arrangementProgramUserToRevisers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arrangementProgramUsersToApproveTactical = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arrangementProgramUsersToApproveOperative = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arrangementProgramUsersToNotify = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add arrangementProgramUsersToApproveTactical
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveTactical
     * @return Configuration
     */
    public function addArrangementProgramUsersToApproveTactical(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveTactical)
    {
        $this->arrangementProgramUsersToApproveTactical->add($arrangementProgramUsersToApproveTactical);

        return $this;
    }

    /**
     * Remove arrangementProgramUsersToApproveTactical
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveTactical
     */
    public function removeArrangementProgramUsersToApproveTactical(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveTactical)
    {
        $this->arrangementProgramUsersToApproveTactical->removeElement($arrangementProgramUsersToApproveTactical);
    }

    /**
     * Get arrangementProgramUsersToApproveTactical
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramUsersToApproveTactical()
    {
        return $this->arrangementProgramUsersToApproveTactical;
    }

    /**
     * Add arrangementProgramUsersToApproveOperative
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveOperative
     * @return Configuration
     */
    public function addArrangementProgramUsersToApproveOperative(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveOperative)
    {
        $this->arrangementProgramUsersToApproveOperative->add($arrangementProgramUsersToApproveOperative);

        return $this;
    }

    /**
     * Remove arrangementProgramUsersToApproveOperative
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveOperative
     */
    public function removeArrangementProgramUsersToApproveOperative(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToApproveOperative)
    {
        $this->arrangementProgramUsersToApproveOperative->removeElement($arrangementProgramUsersToApproveOperative);
    }

    /**
     * Get arrangementProgramUsersToApproveOperative
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramUsersToApproveOperative()
    {
        return $this->arrangementProgramUsersToApproveOperative;
    }

    /**
     * Add arrangementProgramUsersToNotify
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToNotify
     * @return Configuration
     */
    public function addArrangementProgramUsersToNotify(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToNotify)
    {
        $this->arrangementProgramUsersToNotify->add($arrangementProgramUsersToNotify);

        return $this;
    }

    /**
     * Remove arrangementProgramUsersToNotify
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToNotify
     */
    public function removeArrangementProgramUsersToNotify(\Pequiven\SEIPBundle\Entity\User $arrangementProgramUsersToNotify)
    {
        $this->arrangementProgramUsersToNotify->removeElement($arrangementProgramUsersToNotify);
    }

    /**
     * Get arrangementProgramUsersToNotify
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramUsersToNotify()
    {
        return $this->arrangementProgramUsersToNotify;
    }
    
    /**
     * Add arrangementProgramSigUsersToReviser
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToReviser
     * @return Configuration
     */
    public function addArrangementProgramSigUsersToReviser(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToReviser)
    {
        $this->arrangementProgramSigUsersToReviser->add($arrangementProgramSigUsersToReviser);

        return $this;
    }

    /**
     * Remove arrangementProgramSigUsersToReviser
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToReviser
     */
    public function removeArrangementProgramSigUsersToReviser(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToReviser)
    {
        $this->arrangementProgramSigUsersToReviser->removeElement($arrangementProgramSigUsersToReviser);
    }

    /**
     * Get arrangementProgramSigUsersToReviser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramSigUsersToReviser()
    {
        return $this->arrangementProgramSigUsersToReviser;
    }
    
        /**
     * Add arrangementProgramSigUsersToApprove
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToApprove
     * @return Configuration
     */
    public function addArrangementProgramSigUsersToApprove(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToApprove)
    {
        $this->arrangementProgramSigUsersToApprove->add($arrangementProgramSigUsersToApprove);

        return $this;
    }

    /**
     * Remove arrangementProgramSigUsersToApprove
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToApprove
     */
    public function removeArrangementProgramSigUsersToApprove(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToApprove)
    {
        $this->arrangementProgramSigUsersToApprove->removeElement($arrangementProgramSigUsersToApprove);
    }

    /**
     * Get arrangementProgramSigUsersToApprove
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramSigUsersToApprove()
    {
        return $this->arrangementProgramSigUsersToApprove;
    }
    
    /**
     * Add arrangementProgramSigUsersToNotify
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToNotify
     * @return Configuration
     */
    public function addArrangementProgramSigUsersToNotify(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToNotify)
    {
        $this->arrangementProgramSigUsersToNotify->add($arrangementProgramSigUsersToNotify);

        return $this;
    }

    /**
     * Remove arrangementProgramSigUsersToNotify
     *
     * @param \Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToNotify
     */
    public function removeArrangementProgramSigUsersToNotify(\Pequiven\SEIPBundle\Entity\User $arrangementProgramSigUsersToNotify)
    {
        $this->arrangementProgramSigUsersToNotify->removeElement($arrangementProgramSigUsersToNotify);
    }

    /**
     * Get arrangementProgramSigUsersToNotify
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementProgramSigUsersToNotify()
    {
        return $this->arrangementProgramSigUsersToNotify;
    }
}
