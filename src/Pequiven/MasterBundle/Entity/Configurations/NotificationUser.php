<?php

namespace Pequiven\MasterBundle\Entity\Configurations;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Usuarios 
 *
 * @author Máximo Sojo<maxsojo13@gmail.com>
 * @ORM\Table(name="seip_general_configurations_notifications_users")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class NotificationUser{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="action", type="integer")
     */
    private $action; 

    /**
     * Usuario
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * 
     * @var \Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification")
     * @ORM\JoinColumn(nullable=false)
     */    
    private $idObject;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;    
    
    /**
     * Constructor
     */
    public function __construct(){        
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
     * Set action
     *
     * @param $action
     * @return action
     */
    public function setAction($action) {
        
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return action
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Set idObject
     *
     * @param $idObject
     * @return idObject
     */
    public function setIdObject(\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification $idObject) {
        $this->idObject = $idObject;
        return $this;
    }

    /**
     * Get idObject
     *
     * @return idObject
     */
    public function getIdObject() {
        return $this->idObject;
    }

    /**
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return IndicatorSimpleValue
     */
    public function setUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ManagementSystem
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
}
