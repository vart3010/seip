<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programa de gestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository")
 */
class ArrangementProgram
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
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     */
    private $period;
    
    /**
     * Programa de gestión asociada.
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram")
     */
    private $categoryArrangementProgramt;

    /**
     * Objetivo táctico
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive")
     * @ORM\JoinColumn(name="tactical_objective_id")
     */
    private $tacticalObjective;

    /**
     * Objetivo operativo.
     * @var \Pequiven\ObjetiveBundle\Entity\Objetive
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\ObjetiveBundle\Entity\Objetive")
     * @ORM\JoinColumn(name="operational_objective_id")
     */
    private $operationalObjective;

    /**
     * Indicador operativo
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator")
     */
    private $operatingIndicator;

    /**
     * Localidad
     * @var \Pequiven\MasterBundle\Entity\Complejo
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Complejo")
     */
    private $location;

    /**
     * Proceso
     * @var string
     *
     * @ORM\Column(name="process", type="string", length=255)
     */
    private $process;

    /**
     * Responsable
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="user_responsible_id")
     */
    private $responsible;

    /**
     * Lineas de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     *
     * @ORM\Column(name="timelines", type="integer")
     * @ORM\OneToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",mappedBy="arrangementProgram")
     */
    private $timelines;

    /**
     * Revisado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $reviewedBy;

    /**
     * Fecha de revision
     * @var \DateTime
     *
     * @ORM\Column(name="revisionDate", type="datetime")
     */
    private $revisionDate;

    /**
     * Aprobado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $approvedBy;

    /**
     * Fecha de aprobacion
     * @var \DateTime
     *
     * @ORM\Column(name="approvalDate", type="datetime")
     */
    private $approvalDate;

    /**
     * Estatus del programa de gestion
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
}
