<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * category file
 *
 * @ORM\Table(name="seip_c_categoryFile")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Politic\CategoryFileRepository")
 */
class CategoryFile {

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
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

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
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\MeetingFile", mappedBy="categoryFile", cascade={"persist","remove"})
     * @ORM\JoinTable(name="seip_meeting_category_file")
     */
    private $meetingFile;

    public function __construct() {
        $this->meetingFile= new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addMeetingFile(MeetingFile $meetingFile) {
        //$meetingFile->add($this);
        $this->meetingFile->add($meetingFile);

        return $this;
    }

    public function removeMeetingFile(MeetingFile $meetingFile) {
        $this->meetingFile->removeElement($meetingFile);
    }

    public function getMeetingFile() {
        return $this->meetingFile;
    }

    function getId() {
        return $this->id;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getUserCreatedAt() {
        return $this->userCreatedAt;
    }

    function getUserUpdatedAt() {
        return $this->userUpdatedAt;
    }

    function getDescription() {
        return $this->description;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt) {
        $this->userCreatedAt = $userCreatedAt;
    }

    function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt) {
        $this->userUpdatedAt = $userUpdatedAt;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
