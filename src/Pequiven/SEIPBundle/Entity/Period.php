<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Period as Base;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Periodo
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="name_idx", columns={"name"})})
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PeriodRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
    private $status = false;

    /**
     * Fecha inicio de notificación de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateStartNotificationArrangementProgram;

    /**
     * Fecha fin de notificación de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateEndNotificationArrangementProgram;

    /**
     * Fecha inicio de carga de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadArrangementProgram", type="date", nullable=true)
     */
    private $dateStartLoadArrangementProgram;

    /**
     * Fecha fin de carga de programas de gestión.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadArrangementProgram", type="date", nullable=true)
     */
    private $dateEndLoadArrangementProgram;

    /**
     * Fecha inicio de holgura de notificación de programas de gestion
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartClearanceNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateStartClearanceNotificationArrangementProgram;

    /**
     * Fecha fin de holgura de notificación de programas de gestion
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndClearanceNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateEndClearanceNotificationArrangementProgram;
    
    /**
     * Periodo anterior o padre
     * 
     * @var type 
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period",inversedBy="child")
     */
    private $parent;
    
    /**
     *
     * @var type 
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period",mappedBy="parent")
     */
    private $child;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
        return $this->getDescription()?:'-';
    }

    /**
     * Set dateStartNotificationArrangementProgram
     *
     * @param \DateTime $dateStartNotificationArrangementProgram
     * @return Period
     */
    public function setDateStartNotificationArrangementProgram($dateStartNotificationArrangementProgram)
    {
        $this->dateStartNotificationArrangementProgram = $dateStartNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartNotificationArrangementProgram()
    {
        return $this->dateStartNotificationArrangementProgram;
    }

    /**
     * Set dateEndNotificationArrangementProgram
     *
     * @param \DateTime $dateEndNotificationArrangementProgram
     * @return Period
     */
    public function setDateEndNotificationArrangementProgram($dateEndNotificationArrangementProgram)
    {
        $this->dateEndNotificationArrangementProgram = $dateEndNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndNotificationArrangementProgram()
    {
        return $this->dateEndNotificationArrangementProgram;
    }

    /**
     * Set dateStartLoadArrangementProgram
     *
     * @param \DateTime $dateStartLoadArrangementProgram
     * @return Period
     */
    public function setDateStartLoadArrangementProgram($dateStartLoadArrangementProgram)
    {
        $this->dateStartLoadArrangementProgram = $dateStartLoadArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartLoadArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartLoadArrangementProgram()
    {
        return $this->dateStartLoadArrangementProgram;
    }

    /**
     * Set dateEndLoadArrangementProgram
     *
     * @param \DateTime $dateEndLoadArrangementProgram
     * @return Period
     */
    public function setDateEndLoadArrangementProgram($dateEndLoadArrangementProgram)
    {
        $this->dateEndLoadArrangementProgram = $dateEndLoadArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndLoadArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndLoadArrangementProgram()
    {
        return $this->dateEndLoadArrangementProgram;
    }

    /**
     * Set dateStartClearanceNotificationArrangementProgram
     *
     * @param \DateTime $dateStartClearanceNotificationArrangementProgram
     * @return Period
     */
    public function setDateStartClearanceNotificationArrangementProgram($dateStartClearanceNotificationArrangementProgram)
    {
        $this->dateStartClearanceNotificationArrangementProgram = $dateStartClearanceNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartClearanceNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartClearanceNotificationArrangementProgram()
    {
        return $this->dateStartClearanceNotificationArrangementProgram;
    }

    /**
     * Set dateEndClearanceNotificationArrangementProgram
     *
     * @param \DateTime $dateEndClearanceNotificationArrangementProgram
     * @return Period
     */
    public function setDateEndClearanceNotificationArrangementProgram($dateEndClearanceNotificationArrangementProgram)
    {
        $this->dateEndClearanceNotificationArrangementProgram = $dateEndClearanceNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndClearanceNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndClearanceNotificationArrangementProgram()
    {
        return $this->dateEndClearanceNotificationArrangementProgram;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $parent
     * @return Period
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\Period $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set child
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $child
     * @return Period
     */
    public function setChild(\Pequiven\SEIPBundle\Entity\Period $child = null)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Period
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
