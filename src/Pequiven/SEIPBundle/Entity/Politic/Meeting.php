<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * REUNIONES CIRCULOS DE TRABAJO
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\HasLifecycleCallbacks()
 */
class Meeting {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

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
     * @ORM\Column(name="name",type="string",length=255,nullable=false)
     */
    private $place;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="subject",type="string",length=255,nullable=false)
     */
    private $subject;

    /**
     * @OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Politic\Assistance", mappedBy="meeting")
     */
    private $assistances;

    public function __construct() {
        $this->assistances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Assistance $assistance
     * @return \Pequiven\SEIPBundle\Entity\Politic\Meeting
     */
    public function addAssistances(Assistance $assistance) {
        $this->assistances[] = $assistance;

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\Assistance $assistence
     */
    public function removeAssistances(Assistance $assistence) {
        $this->assistances->removeElement($assistence);
    }

    /**
     * 
     * @return type
     */
    public function getAssistances() {
        return $this->assistances;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get CreatedBy
     * @return type
     */
    function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set CreatedBy
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle
     */
    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return WorkStudyCircle
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return WorkStudyCircle
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * 
     * @param type $place
     * @return \Pequiven\SEIPBundle\Entity\Politic\Meetings
     */
    public function setPlace($place) {
        $this->place = $place;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getPlace() {
        return $this->place;
    }

    /**
     * 
     * @return type
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * 
     * @param type $subject
     * @return \Pequiven\SEIPBundle\Entity\Politic\Meetings
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getSubject() {
        return $this->subject;
    }

}
