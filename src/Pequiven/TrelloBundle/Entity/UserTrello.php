<?php

namespace Pequiven\TrelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\TrelloBundle\Entity\Task;

/**
 * @ORM\Entity(repositoryClass="Pequiven\TrelloBundle\Repository\UserTrelloRepository")
 * @ORM\Table(name="trello_user")
 */

class UserTrello
{
    /**
     * @var type 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="trello_id", type="string", length=25)
     */
    private $trelloId;

    /**
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\OneToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $seipUser;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\TrelloBundle\Entity\TaskTrello")
     * @ORM\JoinTable(name="trello_user_tasks",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $trelloTasks;

    public function __construct()
    {
        $this->trelloTasks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    function getTrelloId()
    {
        return $this->trelloId;
    }

    function setTrelloId($trelloId)
    {
        $this->trelloId = $trelloId;
    }

    function getSeipUser()
    {
        return $this->seipUser;
    }

    function setSeipUser(User $seipUser)
    {
        $this->seipUser = $seipUser;
    }

    /**
     * Add task
     *
     * @param \Pequiven\TrelloBundle\Entity\TaskTrello $task
     * @return Task
     */
    public function addTaskTrello(TaskTrello $task) {
        $this->trelloTasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \Pequiven\TrelloBundle\Entity\TaskTrello $task
     */
    public function removeTaskTrello(TaskTrello $task) {
        $this->trelloTasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTaskTrello() {
        return $this->trelloTasks;
    }
}