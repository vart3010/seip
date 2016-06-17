<?php

namespace Pequiven\SEIPBundle\Entity\Result;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Result\Result as ModelResult;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Resultado
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_result")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Result\ResultRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Result extends ModelResult implements ResultItemInterface,PeriodItemInterface
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Peso
     * 
     * @var float 
     * @ORM\Column(name="weight",type="float")
     */
    private $weight = 0;

    /**
     * Tipo de resultado
     * 
     * @var integer
     * @ORM\Column(name="typeResult",type="integer",nullable=false)
     */
    private $typeResult;
    
    /**
     * Tipo de calculo
     * 
     * @var integer
     * @ORM\Column(name="typeCalculation",type="integer",nullable=false)
     */
    private $typeCalculation;
    
    /**
     * Resultados asociados
     * 
     * @var \Pequiven\SEIPBundle\Entity\Result\Result Description
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Result\Result", mappedBy="parent", cascade={"persist"})
     */
    private $childrens;
    
    /**
     * Resultado que impacta
     * 
     * @var \Pequiven\SEIPBundle\Entity\Result\Result
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Result\Result", inversedBy="childrens")
     */
    private $parent;
    
    /**
     * Objetivos que impacta TODO: PILA AQUI CON EL PERSIST
     * 
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive Objetivo
     * @ORM\ManyToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", inversedBy="results")
     */
    private $objetive;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="lastDateCalculateResult", type="datetime",nullable=true)
     */
    private $lastDateCalculateResult;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    private $descriptionText = '';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Result
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Result
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set typeResult
     *
     * @param integer $typeResult
     * @return Result
     */
    public function setTypeResult($typeResult)
    {
        $this->typeResult = $typeResult;

        return $this;
    }

    /**
     * Get typeResult
     *
     * @return integer 
     */
    public function getTypeResult()
    {
        return $this->typeResult;
    }

    /**
     * Set typeCalculation
     *
     * @param integer $typeCalculation
     * @return Result
     */
    public function setTypeCalculation($typeCalculation)
    {
        $this->typeCalculation = $typeCalculation;

        return $this;
    }

    /**
     * Get typeCalculation
     *
     * @return integer 
     */
    public function getTypeCalculation()
    {
        return $this->typeCalculation;
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $childrens
     * @return Result
     */
    public function addChildren(\Pequiven\SEIPBundle\Entity\Result\Result $childrens)
    {
        $childrens->setParent($this);
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $childrens
     */
    public function removeChildren(\Pequiven\ObjetiveBundle\Entity\Objetive $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $parent
     * @return Result
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\Result\Result $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if($this->resultDetails == null){
            $this->resultDetails = new ResultDetails();
        }
    }

    /**
     * Set resultDetails
     *
     * @param \Pequiven\SEIPBundle\Entity\Result\ResultDetails $resultDetails
     * @return Result
     */
    public function setResultDetails(\Pequiven\SEIPBundle\Entity\Result\ResultDetails $resultDetails = null)
    {
        $this->resultDetails = $resultDetails;

        return $this;
    }

    /**
     * Get resultDetails
     *
     * @return \Pequiven\SEIPBundle\Entity\Result\ResultDetails 
     */
    public function getResultDetails()
    {
        return $this->resultDetails;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Result
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
     * Set weight
     *
     * @param float $weight
     * @return Result
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    public function __toString() {
        return $this->getDescription() ? $this->getDescription() : '-';
    }
    
    public function getDescriptionText() {
        $this->descriptionText = $this->getPeriod()->getDescription().' '.$this->getDescription();
        return $this->descriptionText;
    }
    
    public function getResult() {
        $resultDetails = $this->getResultDetails();
        $result = 0;
        if($resultDetails){
            $result = $resultDetails->getGlobalResult();
        }
        return $result;
    }

    public function getResultWithWeight() {
        $result = ( $this->getResult() * $this->getWeight()) / 100;
        return $result;
    }

    /**
     * Set objetive
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return Result
     */
    public function setObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive = null)
    {
        $this->objetive = $objetive;

        return $this;
    }

    /**
     * Get objetive
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getObjetive()
    {
        return $this->objetive;
    }
    
    public function updateLastDateCalculateResult() 
    {
        $this->lastDateCalculateResult = new \DateTime();
    }
    
    public function clearLastDateCalculateResult() {
        $this->lastDateCalculateResult = null;
    }
    
    public function isAvailableInResult() 
    {
        return true;
    }
    
    function setChildrens($childrens) 
    {
        $this->childrens = $childrens;
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
    
    function isCouldBePenalized() 
    {
        return false;
    }

    function isForcePenalize() 
    {
        return false;
    }
    
    public function setResultReal($resultReal) {}
    public function setResult($result) {}
    
    public function getStatus() {}

    public function setStatus($status) {}
    
    public function __clone() {
        if($this->id > 0){
            $this->id = null;
            
            $this->createdAt = null;
            $this->updatedAt = null;
            
            $this->resultDetails = new ResultDetails();
            $this->lastDateCalculateResult = null;
            
            $this->period = null;
        }
    }
}
