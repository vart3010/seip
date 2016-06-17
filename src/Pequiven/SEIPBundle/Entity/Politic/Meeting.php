<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * REUNIONES CIRCULOS DE TRABAJO
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Politic\MeetingRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="place",type="string",length=255,nullable=false)
     */
    private $place;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="observation",type="text",nullable=true)
     */
    private $observation;

    /**
     * @var string
     *
     * @ORM\Column(name="subject",type="string",length=255,nullable=false)
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\Assistance", mappedBy="meeting")
     */
    private $assistances;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle", inversedBy="meetings")
     * @ORM\JoinColumn(name="workStudyCircle_id", referencedColumnName="id")
     * */
    private $workStudyCircle;

    /**
     * @var time
     *
     * @ORM\Column(name="duration",type="time",nullable=false)
     */
    private $duration;
    
    
    /**
     * Relacion archivos asociados a meeting
     * 
     * @var Pequiven\SEIPBundle\Entity\Politic\MeetingFile
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Politic\MeetingFile",mappedBy="meeting")
     */
    private $meetingFile;
    

    public function __construct() {
        $this->assistances = new \Doctrine\Common\Collections\ArrayCollection();
        $this->meetingFile = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    public function addMeetingFile(MeetingFile $meetingFile) {
        $this->meetingFile->add($meetingFile);
        return $this;
    }
    
    public function removeMeetingFile(MeetingFile $meetingFile) {
        $this->meetingFile->removeElement($meetingFile);
    }
    /**
     * 
     * @return type
     */
    public function getMeetingFile() {
        return $this->meetingFile;
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

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
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
     * @param \DateTime $date
     * @return \Pequiven\SEIPBundle\Entity\Politic\Meeting
     */
    public function setDate(\DateTime $date) {
        $this->date = $date;
        return $this;
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

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle $workStudyCircle
     * @return \Pequiven\SEIPBundle\Entity\Politic\Meeting
     */
    public function setWorkStudyCircle(WorkStudyCircle $workStudyCircle) {
        $this->workStudyCircle = $workStudyCircle;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getWorkStudyCircle() {
        return $this->workStudyCircle;
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

    /**
     * 
     * @return type
     */
    function getDuration() {
        return $this->duration;
    }

    /**
     * 
     * @param type $duration
     */
    function setDuration($duration) {
        $this->duration = $duration;
    }

}
