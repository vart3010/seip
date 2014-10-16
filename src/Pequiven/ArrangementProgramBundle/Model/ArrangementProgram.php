<?php

namespace Pequiven\ArrangementProgramBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
abstract class ArrangementProgram
{
    const TYPE_ARRANGEMENT_PROGRAM_TACTIC = 1;
    const TYPE_ARRANGEMENT_PROGRAM_OPERATIVE = 2;
    const TYPE_ARRANGEMENT_PROGRAM_OTHER = 3;
    
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    /**
     * Estatus revisado
     */
    const STATUS_REVISED = 1;
    
    /**
     * Estatus aprobado
     */
    const STATUS_APPROVED = 2;
    
    /**
     * Tipo de programa de gestion
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    protected $type;
    
    /**
     * Responsables del programa
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="arrangementPrograms")
     */
    protected $responsibles;
    
    /**
     * Linea de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     *
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",mappedBy="arrangementProgram",cascade={"persist","remove"})
     */
    protected $timeline;
    
    /**
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = self::STATUS_DRAFT;
    
    function getTypeLabel() {
        
        $labels = array(
            self::TYPE_ARRANGEMENT_PROGRAM_TACTIC => 'pequiven.arrangement_program.type.tactic',
            self::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE => 'pequiven.arrangement_program.type.operative',
        );
        if(isset($labels[$this->type])){
            return $labels[$this->type];
        }
    }
    
    /**
     * Set status
     *
     * @param integer $status
     * @return ArrangementProgram
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
    
    /**
     * Set timeline
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline
     * @return ArrangementProgram
     */
    public function setTimeline(\Pequiven\ArrangementProgramBundle\Entity\Timeline $timeline = null)
    {
        $timeline->setArrangementProgram($this);
        $this->timeline = $timeline;

        return $this;
    }

    /**
     * Get timeline
     *
     * @return \Pequiven\ArrangementProgramBundle\Entity\Timeline 
     */
    public function getTimeline()
    {
        return $this->timeline;
    }
    
    /**
     * Add responsibles
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsibles
     * @return ArrangementProgram
     */
    public function addResponsible(\Pequiven\SEIPBundle\Entity\User $responsibles)
    {
        $this->responsibles->add($responsibles);

        return $this;
    }

    /**
     * Remove responsibles
     *
     * @param \Pequiven\SEIPBundle\Entity\User $responsibles
     */
    public function removeResponsible(\Pequiven\SEIPBundle\Entity\User $responsibles)
    {
        $this->responsibles->removeElement($responsibles);
    }

    /**
     * Get responsibles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsibles()
    {
        return $this->responsibles;
    }
    
    /**
     * Valida el total del peso de la linea de tiempo
     * @return boolean
     */
    function isValidTimeLine()
    {
        $timeline = $this->getTimeline();
        //Sino se asigno ninguna meta al crear el programa de gestion
        if(!$timeline){
            return ;
        }
        $weight = 0;
        foreach ($timeline->getGoals() as $goal) {
            $weight+= $goal->getWeight();
        }
        if($weight > 100){
            return false;
        }
        return true;
    }
    
    function isValidResponsibles()
    {
        $responsibles = $this->getResponsibles();
        if($responsibles  != null && $responsibles->count() > 0){
            return true;
        }
        return false;
    }
    
    /**
     * Retorna las etiquetas definidas para los estatus del programa de gestion
     * @staticvar array $labelsStatus
     * @return string
     */
    function getLabelsStatus()
    {
        static $labelsStatus = array(
            self::STATUS_DRAFT => 'pequiven.arrangement_program.status.draft',
            self::STATUS_REVISED => 'pequiven.arrangement_program.status.revised',
            self::STATUS_APPROVED => 'pequiven.arrangement_program.status.approved',
        );
        return $labelsStatus;
    }
    
    function getLabelStatus()
    {
        $labels = $this->getLabelsStatus();
        if(isset($labels[$this->status])){
            return $labels[$this->status];
        }
    }
    
    /**
     * Retorna el porcentaje de avance del programa de gestion
     */
    function getSummary()
    {
        $summary = array(
            'weight' => 0,
            'advances' => 0,
        );
        $totalWeight = 0;
        $advances = 0;
        $timeline = $this->getTimeline();
        if($timeline){
            $propertyAccessor = new \Symfony\Component\PropertyAccess\PropertyAccessor();
            foreach ($timeline->getGoals() as $goal) {
                $goalDetails = $goal->getGoalDetails();
                $weight = $goalDetails->getGoal()->getWeight();
                $totalWeight += $weight;
                $reflection = new \ReflectionClass($goalDetails);
                $nameMatch = '^get\w+Real$';
                foreach ($reflection->getMethods() as $method) {
                    $methodName = $method->getName();
                    if(preg_match('/'.$nameMatch.'/i', $methodName)){
                        $class = $method->getDeclaringClass();
                        if(!strpos($class, 'Pequiven\ArrangementProgramBundle\Entity\GoalDetails')){
                            continue;
                        }
                        $real = $goalDetails->$methodName();
                        $advances +=  ($weight/100) * $real;
                    }
                }
                
            }
        }
        $summary['advances'] = $advances;
        $summary['weight'] = $totalWeight;
        return $summary;
    }
    
    protected function calculateAverageRowReal(){
        
    }
    
    
}
