<?php

namespace Pequiven\ObjetiveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\ObjetiveBundle\Model\Objetive as modelObjetive;

/**
 * Objetive
 * 
 * @ORM\Entity(repositoryClass="Pequiven\ObjetiveBundle\Repository\ObjetiveRepository")
 * @ORM\Table(name="seip_objetive")
 */
class Objetive extends modelObjetive {

    //Texto a mostrar en los select
    protected $descriptionSelect;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=15, nullable=true)
     */
    private $ref;

    /**
     * @var float
     * 
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;

    /**
     * @var float
     * 
     * @ORM\Column(name="goal", type="float", nullable=true)
     */
    private $goal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_objetive", type="boolean")
     */
    private $evalObjetive = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_indicator", type="boolean")
     */
    private $evalIndicator = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_arrangement_program", type="boolean")
     */
    private $evalArrangementProgram = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_simple_average", type="boolean")
     */
    private $evalSimpleAverage = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="eval_weighted_average", type="boolean")
     */
    private $evalWeightedAverage = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * ObjetiveLevel
     * @var \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel")
     * @ORM\JoinColumn(name="fk_objetive_level", referencedColumnName="id")
     */
    private $objetiveLevel;

    /**
     * LineStrategic
     * @var \Pequiven\MasterBundle\Entity\LineStrategic
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\LineStrategic")
     * @ORM\JoinColumn(name="fk_line_strategic", referencedColumnName="id")
     */
    private $lineStrategic;

    /**
     * Complejo
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;

    /**
     * Gerencia
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     * GerenciaSecond
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond")
     * @ORM\JoinColumn(name="fk_gerencia_second", referencedColumnName="id")
     */
    private $gerenciaSecond;

    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\ObjetiveBundle\Entity\Objetive", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", inversedBy="objetives")
     * @ORM\JoinTable(name="seip_objetives_indicators")
     */
    private $indicators;
    
    /**
     * @ORM\OneToOne(targetEntity="\Pequiven\ArrangementBundle\Entity\ArrangementRange", mappedBy="objetive")
     */
    private $arrangementRange;
    

    /**
     * Constructor
     */
    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Objetive
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Objetive
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Objetive
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Objetive
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Objetive
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null) {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt() {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Objetive
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null) {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt() {
        return $this->userUpdatedAt;
    }

    /**
     * Set objetiveLevel
     *
     * @param \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel
     * @return Objetive
     */
    public function setObjetiveLevel(\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel = null) {
        $this->objetiveLevel = $objetiveLevel;

        return $this;
    }

    /**
     * Get objetiveLevel
     *
     * @return \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel 
     */
    public function getObjetiveLevel() {
        return $this->objetiveLevel;
    }

    /**
     * Set complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return Objetive
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null) {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo() {
        return $this->complejo;
    }

    /**
     * Set gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return Objetive
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null) {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia() {
        return $this->gerencia;
    }

    /**
     * Add children
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $children
     * @return Objetive
     */
    public function addChild(\Pequiven\ObjetiveBundle\Entity\Objetive $children) {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $children
     */
    public function removeChild(\Pequiven\ObjetiveBundle\Entity\Objetive $children) {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $parent
     * @return Objetive
     */
    public function setParent(\Pequiven\ObjetiveBundle\Entity\Objetive $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\ObjetiveBundle\Entity\Objetive 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set lineStrategic
     *
     * @param \Pequiven\MasterBundle\Entity\LineStrategic $lineStrategic
     * @return Objetive
     */
    public function setLineStrategic(\Pequiven\MasterBundle\Entity\LineStrategic $lineStrategic = null) {
        $this->lineStrategic = $lineStrategic;

        return $this;
    }

    /**
     * Get lineStrategic
     *
     * @return \Pequiven\MasterBundle\Entity\LineStrategic 
     */
    public function getLineStrategic() {
        return $this->lineStrategic;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return Objetive
     */
    public function setWeight($weight) {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * Set goal
     *
     * @param float $goal
     * @return Objetive
     */
    public function setGoal($goal) {
        $this->goal = $goal;

        return $this;
    }

    /**
     * Get goal
     *
     * @return float 
     */
    public function getGoal() {
        return $this->goal;
    }

    /**
     * Set evalObjetive
     *
     * @param boolean $evalObjetive
     * @return Objetive
     */
    public function setEvalObjetive($evalObjetive) {
        $this->evalObjetive = $evalObjetive;

        return $this;
    }

    /**
     * Get evalObjetive
     *
     * @return boolean 
     */
    public function getEvalObjetive() {
        return $this->evalObjetive;
    }

    /**
     * Set evalIndicator
     *
     * @param boolean $evalIndicator
     * @return Objetive
     */
    public function setEvalIndicator($evalIndicator) {
        $this->evalIndicator = $evalIndicator;

        return $this;
    }

    /**
     * Get evalIndicator
     *
     * @return boolean 
     */
    public function getEvalIndicator() {
        return $this->evalIndicator;
    }

    /**
     * Set evalArrangementProgram
     *
     * @param boolean $evalArrangementProgram
     * @return Objetive
     */
    public function setEvalArrangementProgram($evalArrangementProgram) {
        $this->evalArrangementProgram = $evalArrangementProgram;

        return $this;
    }

    /**
     * Get evalArrangementProgram
     *
     * @return boolean 
     */
    public function getEvalArrangementProgram() {
        return $this->evalArrangementProgram;
    }

    /**
     * Set evalSimpleAverage
     *
     * @param boolean $evalSimpleAverage
     * @return Objetive
     */
    public function setEvalSimpleAverage($evalSimpleAverage) {
        $this->evalSimpleAverage = $evalSimpleAverage;

        return $this;
    }

    /**
     * Get evalSimpleAverage
     *
     * @return boolean 
     */
    public function getEvalSimpleAverage() {
        return $this->evalSimpleAverage;
    }

    /**
     * Set evalWeightedAverage
     *
     * @param boolean $evalWeightedAverage
     * @return Objetive
     */
    public function setEvalWeightedAverage($evalWeightedAverage) {
        $this->evalWeightedAverage = $evalWeightedAverage;

        return $this;
    }

    /**
     * Get evalWeightedAverage
     *
     * @return boolean 
     */
    public function getEvalWeightedAverage() {
        return $this->evalWeightedAverage;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Objetive
     */
    public function setRef($ref) {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * Get descriptionSelect
     * 
     * @return string
     */
    public function getDescriptionSelect() {
        $this->descriptionSelect = $this->getRef() . ' ' . $this->getDescription();
        return $this->getDescriptionSelect();
    }

    /**
     * Devuelve el valor referencial del objetivo
     * <b> x.x. Estratégico </b>
     * <b> x.x.x. Táctico </b>
     * <b> x.x.x.x. Operativo </b>
     * @param type $options
     * @return boolean
     */
    public function setNewRef($options = array()) {
        $container = \Pequiven\ObjetiveBundle\PequivenObjetiveBundle::getContainer();
        $securityContext = $container->get('security.context');
        $em = $container->get('doctrine')->getManager();

        if ($options['type'] == 'STRATEGIC') {
            $lineStrategic = $em->getRepository('PequivenMasterBundle:LineStrategic')->findOneBy(array('id' => $options['lineStrategicId']));
            $options['type'] = null;
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getRefNewObjetive($options);
            $refLineStrategic = $lineStrategic->getRef();
            $total = count($results);            
            if (is_array($results) && $total > 0) {
                $ref = $refLineStrategic . ($total + 1) . '.';
            } else {
                $ref = $refLineStrategic . '1.';
            }
        } elseif ($options['type'] == 'TACTIC') {
            $objetiveStrategic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $options['objetiveStrategicId']));
            $refObjetiveStrategic = $objetiveStrategic->getRef();
            $options['refParent'] = $refObjetiveStrategic;
            $options['type'] = null;
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getRefNewObjetive($options);
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refObjetiveStrategic . ($total + 1) . '.';
            } else {
                $ref = $refObjetiveStrategic . '1.';
            }
        } elseif ($options['type'] == 'OPERATIVE') {
            $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $options['objetiveTacticId']));
            $refObjetiveTactic = $objetiveTactic->getRef();
            $options['refParent'] = $refObjetiveTactic;
            $options['type'] = null;
            $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->getRefNewObjetive($options);
            $total = count($results);
            if (is_array($results) && $total > 0) {
                $ref = $refObjetiveTactic . ($total + 1) . '.';
            } else {
                $ref = $refObjetiveTactic . '1.';
            }
        }

        return $ref;
    }


    /**
     * Set gerenciaSecond
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond
     * @return Objetive
     */
    public function setGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond = null)
    {
        $this->gerenciaSecond = $gerenciaSecond;

        return $this;
    }

    /**
     * Get gerenciaSecond
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond 
     */
    public function getGerenciaSecond()
    {
        return $this->gerenciaSecond;
    }

    /**
     * Add indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     * @return Objetive
     */
    public function addIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $indicators->addObjetive($this);
        $this->indicators[] = $indicators;

        return $this;
    }

    /**
     * Remove indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     */
    public function removeIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators->removeElement($indicators);
    }

    /**
     * Get indicators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicators()
    {
        return $this->indicators;
    }

    /**
     * Set arrangementRange
     *
     * @param \Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange
     * @return Objetive
     */
    public function setArrangementRange(\Pequiven\ArrangementBundle\Entity\ArrangementRange $arrangementRange = null)
    {
        $this->arrangementRange = $arrangementRange;

        return $this;
    }

    /**
     * Get arrangementRange
     *
     * @return \Pequiven\ArrangementBundle\Entity\ArrangementRange 
     */
    public function getArrangementRange()
    {
        return $this->arrangementRange;
    }
}
