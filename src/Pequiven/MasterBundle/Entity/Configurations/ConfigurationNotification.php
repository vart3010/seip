<?php

namespace Pequiven\MasterBundle\Entity\Configurations;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Configurations\ConfigurationNotification as Model;
/**
 * Configuracion de la General de Configuraciones
 *
 * @author Máximo Sojo<maxsojo13@gmail.com>
 * @ORM\Table(name="seip_general_configurations_notifications")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ConfigurationNotification extends Model{
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
     * @var integer
     *
     * @ORM\Column(name="typeObject", type="integer")
     */
    private $typeObject; 

    /**
     * @var integer
     *
     * @ORM\Column(name="idObject", type="integer")
     */    
    private $idObject;     

    /**
     * @var integer
     *
     * @ORM\Column(name="levelObject", type="integer")
     */    
    private $levelObject; 

    /**
     * Usuario
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
     * Usuario que creo la causa
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdBy;

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
    public function setIdObject($idObject) {
        
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
     * 
     * @param type $typeObject
     * @return type
     */
    public function setTypeObject($typeObject) {
        $this->typeObject = $typeObject;
        return $typeObject;
    }

    /**
     * 
     * @return type
     */
    public function getTypeObject() {
        return $this->typeObject;
    }


    /**
     * 
     * @param type $levelObject
     * @return type
     */
    public function setLevelObject($levelObject) {
        $this->levelObject = $levelObject;
        return $levelObject;
    }

    /**
     * 
     * @return type
     */
    public function getLevelObject() {
        return $this->levelObject;
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
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return IndicatorSimpleValue
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
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
