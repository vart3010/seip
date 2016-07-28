<?php

namespace Pequiven\TrelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="trello_list")
 */

class Lists
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=25)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=175)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="closed", type="boolean")
     */
    private $closed;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="\Pequiven\TrelloBundle\Entity\Board", inversedBy="lists")
     * @ORM\JoinColumn(name="board", referencedColumnName="id")
     */
    private $board;

    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    public function getClosed()
    {
        return $this->closed;
    }

    public function setBoard(\Pequiven\TrelloBundle\Entity\Board $board) {
        $this->board = $board;

        return $this;
    }

    public function getBoard() {
        return $this->board;
    }
}