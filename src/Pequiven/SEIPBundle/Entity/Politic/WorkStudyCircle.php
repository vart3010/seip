<?php

namespace Pequiven\SEIPBundle\Entity\Politic;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Politic\WorkStudyCircle as ModelWorkStudyCircle;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * Estudio de Círculo de Trabajo
 *
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Politic\WorkStudyCircleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class WorkStudyCircle extends ModelEvaluationDetails implements PeriodItemInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    //TODO:
    //SUM METAS-CANT.METAS-RES.METAS-SUM.PG-CANT.PG-RES.PG-SUM.OBJ-CANT.OBJ-RES.OBJ-RES.FINAL
    //(PROM METAS + PROM PG) * 60% + (PROM OBJ) * 40%
    
    
    /**
     * Constructor
     */
    public function __construct() {
        
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
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod() {
        return $this->period;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return ArrangementProgram
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }


    
}