<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Period as Base;
/**
 * Periodo
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="name_idx", columns={"name"})})
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PeriodRepository")
 */
class Period extends Base
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
     * Nombre del periodo
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * Description del periodo
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * Fecha de inicio
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date", nullable=false)
     */
    private $dateStart;

    /**
     * Fecha fin
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date", nullable=false)
     */
    private $dateEnd;

    /**
     * Estatus del periodo
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = true;


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
     * @return Period
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Period
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Period
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Period
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param type $description
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    function setDescription($description) {
        $this->description = $description;
        
        return $this;
    }

    public function __toString() {
        return $this->description;
    }
}
