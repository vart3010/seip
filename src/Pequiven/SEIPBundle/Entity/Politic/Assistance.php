<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Entity\Politic\Meeting;

/**
 * CONTROS DE ASISTENCIA DE REUNIONES
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Assistance {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\Meeting", inversedBy="assistances")
     * @ORM\JoinColumn(name="meeting_id", referencedColumnName="id")
     * */
    private $meeting;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="assistance", type="boolean")
     */
    private $assistance = false;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="string",length=255,nullable=true)
     */
    private $observation;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return \Pequiven\SEIPBundle\Entity\Politic\Assistance
     */
    function setUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Meeting $metting
     * @return \Pequiven\SEIPBundle\Entity\Politic\Assistance
     */
    function setMeeting(Meeting $metting) {
        $this->meeting = $metting;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getMeeting() {
        return $this->meeting;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * 
     * @return type
     */
    function getAssistance() {
        return $this->assistance;
    }

    /**
     * 
     * @param type $assistance
     */
    function setAssistance($assistance) {
        $this->assistance = $assistance;
    }

    /**
     * 
     * @return type
     */
    function getObservation() {
        return $this->observation;
    }

    /**
     * 
     * @param type $observation
     */
    function setObservation($observation) {
        $this->observation = $observation;
    }

}
