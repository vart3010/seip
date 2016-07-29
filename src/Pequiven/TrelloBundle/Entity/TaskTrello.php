<?php

namespace Pequiven\TrelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Pequiven\SEIPBundle\Entity\User;

use Pequiven\TrelloBundle\Entity\Trello;
use Pequiven\TrelloBundle\Model\TaskTrello as modelTask;

/**
 * @ORM\Entity(repositoryClass="Pequiven\TrelloBundle\Repository\TaskTrelloRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="trello_tasks")
 */

class TaskTrello extends modelTask
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var type 
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=45)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \Pequiven\TrelloBundle\Entity\CategoryTrello
     * @ORM\ManyToOne(targetEntity="\Pequiven\TrelloBundle\Entity\CategoryTrello")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $categoryTrello;

    /**
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var date
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var date
     * @ORM\Column(name="finishAt", type="datetime")
     */
    private $finishAt;

    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = self::STATUS_PENDING;

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
     * Set title
     *
     * @param string $title
     * @return title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set description
     *
     * @param string $description
     * @return description
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
     * Set CategoryTrello
     *
     * @param CategoryTrello $categoryTrello
     * @return CategoryTrello
     */
    public function setCategoryTrello(CategoryTrello $categoryTrello)
    {
        $this->categoryTrello = $categoryTrello;

        return $this;
    }

    /**
     * Get CategoryTrello
     *
     * @return CategoryTrello
     */
    public function getCategoryTrello()
    {
        return $this->categoryTrello;
    }

    /**
     * Set createdBy
     *
     * @param User $user
     * @return createdBy
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return User
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set finishAt
     *
     * @param \DateTime $finishAt
     * @return finishAt
     */
    public function setFinishAt($finishAt)
    {
        $this->finishAt = $finishAt;

        return $this;
    }

    /**
     * Get finishAt
     *
     * @return \DateTime 
     */
    public function getFinishAt()
    {
        return $this->finishAt;
    }
    
    /**
     * Set status
     *
     * @param boolean $status
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return status 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDefaultValues()
    {
        $this->setStatus(self::STATUS_PENDING);
        $this->setCreatedAt(new \DateTime("now"));
        $this->setFinishAt(new \DateTime("now")); //date('Y-m-d H:i:s')
    }
}