<?php

namespace Pequiven\SEIPBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Gerencia as modelGerencia;
use Pequiven\MasterBundle\Model\Evaluation\AuditableInterface;
use Pequiven\MasterBundle\Entity\GerenciaSecond;

/**
 * 
 *
 * @ORM\Table(name="seip_user_notification")
 * @ORM\Entity
 * @author Máximo Sojo <maxsojo13@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\User\NotificationRepository") 
 */
class Notification {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;    

    /**
     * @var text
     * @ORM\Column(name="description", type="text")
     */
    private $description;    

    /**
     * @var integer
     * @ORM\Column(name="type", type="integer")
     */
    private $type;    

    /**
     * @var boolean
     * @ORM\Column(name="readNotification", type="boolean")
     */
    private $readNotification = false;    
    
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
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(name="typeMessage", type="integer", nullable=true)
     */
    private $typeMessage = 1;

    /**
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    private $path;

    /** 
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="notification")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    public function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }
    
    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }
    
    function getUser() {
        return $this->user;
    }
    
    function setUser($user) {
        $this->user = $user;
    }

    function getReadNotification() {
        return $this->readNotification;
    }

    function setReadNotification($readNotification) {
        $this->readNotification = $readNotification;
    }

    function getTitle() {
        return $this->title;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getPath() {
        return $this->path;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function getTypeMessage() {
        return $this->typeMessage;
    }

    function setTypeMessage($typeMessage) {
        $this->typeMessage = $typeMessage;
    }
    
}
