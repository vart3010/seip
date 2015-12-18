<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionActionValue as Model;

/**
 * Valores del Plan de Acción y Seguimiento del informe de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="seip_report_evolution_action_value")
 * @ORM\Entity()
 * 
 */
class EvolutionActionValue extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction", inversedBy="relactionValue")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     */
    private $actionValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var integer
     * 
     * @ORM\Column(name="advance", type="integer") 
     */
    private $advance;

    /**
     * @var string
     * 
     * @ORM\Column(name="observations", type="string", length=255, nullable=true)
     */
    private $observations;

    /**
     * Constructor
     */
    public function __construct()
    {

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
     * Set actionValue
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $actionValue
     * @return Indicator
     */
    public function setActionValue(\Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction $actionValue) {
        
        $this->actionValue = $actionValue;

        return $this;
    }

    /**
     * Get actionValue
     *
     * @return Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction
     */
    public function getActionValue() {
        return $this->actionValue;
    }

    /**
     * 
     * @param type $month
     * @return type
     */
    public function setMonth($month) {
        $this->month = $month;
        return $month;
    }

    /**
     * 
     * @return type
     */
    public function getMonth() {
        return $this->month;
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
    
}
