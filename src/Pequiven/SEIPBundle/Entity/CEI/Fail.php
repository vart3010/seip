<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\Fail as BaseModel;

/**
 * Falla o causa de PNR
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_fail")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\FailRepository")
 */
class Fail extends BaseModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Nombre de la causa
     * @var string
     * @ORM\Column(name="name",type="string")
     */
    private $name;
    
    /**
     * Tipo de falla
     * @var integer
     * @ORM\Column(name="type_fail",type="integer")
     */
    private $typeFail;

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
     * Set name
     *
     * @param string $name
     * @return Fail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set typeFail
     *
     * @param integer $typeFail
     * @return Fail
     */
    public function setTypeFail($typeFail)
    {
        $this->typeFail = $typeFail;

        return $this;
    }

    /**
     * Get typeFail
     *
     * @return integer 
     */
    public function getTypeFail()
    {
        return $this->typeFail;
    }

    public function __toString() {
        return $this->getName() ?:"-";
    }
}
