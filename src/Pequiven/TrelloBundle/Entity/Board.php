<?php

namespace Pequiven\TrelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

// SEIP Id: 5706b99076b26925412b1977

/**
 * @ORM\Entity
 * @ORM\Table(name="trello_board")
 */

class Board
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=25)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=125)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="url_short", type="string", length=175)
     */
    private $shortUrl;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\TrelloBundle\Entity\List", mappedBy="board", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $lists;

    public function __construct()
    {
        $this->lists = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
    
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }
    
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function getgetShortUrl()
    {
        return $this->shortUrl;
    }

    public function getLists()
    {
        return $this->lists;
    }

    public function addLists(\Pequiven\TrelloBundle\Entity\Lists $list)
    {
        $this->lists[] = $list;
        return $this;
    }

    public function removeLists(\Pequiven\TrelloBundle\Entity\Lists $list)
    {
        $this->lists->removeElement($list);
    }
}