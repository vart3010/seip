<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Linea de tiempo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\TimelineRepository")
 */
class Timeline
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
     * @var integer
     *
     * @ORM\Column(name="goals", type="integer")
     */
    private $goals;
    
    /**
     * Estatus
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * Programa de gestion
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     * 
     * @ORM\ManyToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram",inversedBy="timelines")
     */
    private $arrangementProgram;

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
     * Set goals
     *
     * @param integer $goals
     * @return Timeline
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals
     *
     * @return integer 
     */
    public function getGoals()
    {
        return $this->goals;
    }
}
