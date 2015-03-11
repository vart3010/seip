<?php

namespace Pequiven\MasterBundle\Entity\Formula;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Formula\Variable as  Model;
/**
 * Variable
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Variable extends Model implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * Ecuacion para calcular el valor de la variable
     * 
     * @var string
     * @ORM\Column(name="equation", type="text", nullable=true)
     */
    private $equation;

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
     * Formulas que usan esta variable
     * 
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToMany(targetEntity="Pequiven\MasterBundle\Entity\Formula", mappedBy="variables")
     */
    protected $formulas;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * ¿La Variable es estática y no se acumula?
     * @var boolean
     * @ORM\Column(name="staticValue",type="boolean")
     */
    private $staticValue = false;
    
    /**
     * 
     * @return type
     */
    public function getStaticValue() {
        return $this->staticValue;
    }

    /**
     * 
     * @param type $staticValue
     */
    public function setStaticValue($staticValue) {
        $this->staticValue = $staticValue;
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
     * Set description
     *
     * @param string $description
     * @return Variable
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
     * Set name
     *
     * @param string $name
     * @return Variable
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Variable
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
     * @return Variable
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
     * Add formulas
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formulas
     * @return Variable
     */
    public function addFormula(\Pequiven\MasterBundle\Entity\Formula $formulas)
    {
        $this->formulas[] = $formulas;

        return $this;
    }

    /**
     * Remove formulas
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formulas
     */
    public function removeFormula(\Pequiven\MasterBundle\Entity\Formula $formulas)
    {
        $this->formulas->removeElement($formulas);
    }

    /**
     * Get formulas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormulas()
    {
        return $this->formulas;
    }
    
    public function __toString()
    {
        $toString = $this->getName();
        if($this->equation != ''){
            $toString .= ' (EQ)';
        }
        return $toString != '' ? $toString : '-';
    }
    
    function getPeriod() {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id > 0){
            $this->id = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->period = null;
        }
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formulas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set equation
     *
     * @param string $equation
     * @return Variable
     */
    public function setEquation($equation)
    {
        $this->equation = $equation;

        return $this;
    }

    /**
     * Get equation
     *
     * @return string 
     */
    public function getEquation()
    {
        return $this->equation;
    }
}
