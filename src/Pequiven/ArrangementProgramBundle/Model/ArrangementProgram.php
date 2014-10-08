<?php

namespace Pequiven\ArrangementProgramBundle\Model;

/**
 * Modelo del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ArrangementProgram
{
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
}
