<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\ValueIndicatorAction as Model;

/**
 * Plan de Acción y Seguimiento del Indicador
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_indicator_value_action")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ValueIndicatorAction extends Model {

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
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="type_action", type="string", length=5, nullable=true)
     */
    private $type_action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $start_date;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $end_date;
    /**
     * @var integer
     * 
     * @ORM\Column(name="advance", type="integer") 
     */
    private $advance;

    /**
     * @var string
     * 
     * @ORM\Column(name="observations", type="string", length=255)
     */
    private $observations;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * ValueIndicator
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator",mappedBy="valueIndicatorAction")
     */
    private $valueIndicator;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param type $action
     * @return type
     */
    public function setAction($action) {
        $this->action = $action;
        return $action;
    }

    /**
     * 
     * @return type
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * 
     * @param type $type_action
     * @return type
     */
    public function setType_action($type_action) {
        $this->type_action = $type_action;
        return $type_action;
    }

    /**
     * 
     * @return type
     */
    public function getType_action() {
        return $this->type_action;
    }

    /**
     * 
     * @param type $start_date
     * @return type
     */
    public function setStart_date($strat_date) {
        $this->strat_date = $strat_date;
        return $strat_date;
    }

    /**
     * 
     * @return type
     */
    public function getStart_date() {
        return $this->start_date;
    }

    /**
     * 
     * @param type $end_date
     * @return type
     */
    public function setEnd_date($end_date) {
        $this->end_date = $end_date;
        return $end_date;
    }

    /**
     * 
     * @return type
     */
    public function getEnd_date() {
        return $this->end_date;
    }

    /**
     * 
     * @param type $advance
     * @return type
     */
    public function setAdvance($advance) {
        $this->advance = $advance;
        return $advance;
    }

    /**
     * 
     * @return type
     */
    public function getAdvance() {
        return $this->advance;
    }
    

    /**
     * 
     * @param type $observations
     * @return type
     */
    public function setObservations($observations) {
        $this->observations = $observations;
        return $observations;
    }

    /**
     * 
     * @return type
     */
    public function getObservations() {
        return $this->observations;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ManagementSystem
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

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator
     * @return IndicatorConfigDetailValue
     */
    public function setValueIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator) {
        $valueIndicator->setValueIndicatorAction($this);
        $this->valueIndicator = $valueIndicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
     */
    public function getValueIndicator() {
        return $this->valueIndicator;
    }
        
}
