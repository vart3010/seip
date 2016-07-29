<?php

namespace Pequiven\TrelloBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

// SEIP Id: 5706b99076b26925412b1977

/**
 * @ORM\Entity
 * @ORM\Table(name="trello_board")
 */

class BoardTrello
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
     * @ORM\OneToMany(targetEntity="\Pequiven\TrelloBundle\Entity\ListTrello", mappedBy="boardTrello", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    private $listTrello;

    public function __construct()
    {
        $this->listTrello = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getListTrello()
    {
        return $this->listTrello;
    }

    public function addListTrello(\Pequiven\TrelloBundle\Entity\ListTrello $listTrello)
    {
        $this->listTrello[] = $listTrello;
        return $this;
    }

    public function removeListTrello(\Pequiven\TrelloBundle\Entity\ListTrello $listTrello)
    {
        $this->listTrello->removeElement($listTrello);
    }
}