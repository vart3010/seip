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
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = self::STATUS_DRAFT;
    
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
     * Linea de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     */
    protected $timeline;
    
    /**
     * Valida el total del peso de la linea de tiempo
     * @return boolean
     */
    function isValidTimeLine()
    {
        $timeline = $this->getTimeline();
        $weight = 0;
        foreach ($timeline->getGoals() as $goal) {
            $weight+= $goal->getWeight();
        }
        if($weight > 100){
            return false;
        }
        return true;
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
}
