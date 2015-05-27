<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\PrePlanning;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningUser as Model;

/**
 * Pre-Planificacion de usuario
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="planning_gf_idx", columns={"user_id", "period_id","levelPlanning","gerenciaFirst_id"}),@ORM\UniqueConstraint(name="planning_gs_idx", columns={"user_id", "period_id","levelPlanning","gerenciaSecond_id"}), @ORM\UniqueConstraint(name="planninguser_ref_idx", columns={"ref"})})
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PrePlanning\PrePlanningUserRepository")
 */
class PrePlanningUser extends Model
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
     * Referencia de la planificacion
     * @var string
     * @ORM\Column(name="ref",type="string",length=30,nullable=false)
     */
    private $ref;

    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Usuario dueño del arbol
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Raiz del arbol de la prePlafinicacion del usuario
     * 
     * @var PrePlanning
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning",inversedBy="prePlanningUser",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $prePlanningRoot;
    
    /**
     * Gerencia de primera linea a planificar
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia 
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Gerencia")
     */
    private $gerenciaFirst;
    
    /**
     * Gerencia de segunda linea a planificar
     * 
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\GerenciaSecond")
     */
    private $gerenciaSecond;
    
    /**
     * Nivel de la planificacion
     * 
     * @var integer
     * @ORM\Column(name="levelPlanning",type="integer",nullable=false)
     */
    private $levelPlanning;

    /**
     * Estatus de la plafinicacion
     * 
     * @var integer
     * @ORM\Column(name="status",type="integer")
     */
    private $status = self::STATUS_DRAFT;
    
    /**
     * ¿Contiene objetivos?
     * 
     * @var boolean
     * @ORM\Column(name="contentObjetive",type="boolean")
     */
    private $contentObjetive = false;
    
    /**
     * ¿Contiene indicadores?
     * 
     * @var boolean
     * @ORM\Column(name="contentIndicator",type="boolean")
     */
    private $contentIndicator = false;
    /**
     * ¿Contiene Programas de gestion?
     * 
     * @var boolean
     * @ORM\Column(name="contentArrangementProgram",type="boolean")
     */
    private $contentArrangementProgram = false;
    /**
     * ¿Contiene Metas Programas de gestion?
     * 
     * @var boolean
     * @ORM\Column(name="contentArrangementProgramGoal",type="boolean")
     */
    private $contentArrangementProgramGoal = false;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PrePlanningUser
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
     * @return PrePlanningUser
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
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return PrePlanningUser
     */
    public function setUser(\Pequiven\SEIPBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return PrePlanningUser
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set prePlanningRoot
     *
     * @param \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $prePlanningRoot
     * @return PrePlanningUser
     */
    public function setPrePlanningRoot(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $prePlanningRoot = null)
    {
        $this->prePlanningRoot = $prePlanningRoot;

        return $this;
    }

    /**
     * Get prePlanningRoot
     *
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning 
     */
    public function getPrePlanningRoot()
    {
        return $this->prePlanningRoot;
    }

    /**
     * Set gerenciaFirst
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerenciaFirst
     * @return PrePlanningUser
     */
    public function setGerenciaFirst(\Pequiven\MasterBundle\Entity\Gerencia $gerenciaFirst = null)
    {
        $this->gerenciaFirst = $gerenciaFirst;

        return $this;
    }

    /**
     * Get gerenciaFirst
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerenciaFirst()
    {
        return $this->gerenciaFirst;
    }

    /**
     * Set levelPlanning
     *
     * @param integer $levelPlanning
     * @return PrePlanningUser
     */
    public function setLevelPlanning($levelPlanning)
    {
        $this->levelPlanning = $levelPlanning;

        return $this;
    }

    /**
     * Get levelPlanning
     *
     * @return integer 
     */
    public function getLevelPlanning()
    {
        return $this->levelPlanning;
    }

    /**
     * Set gerenciaSecond
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond
     * @return PrePlanningUser
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
     * Set status
     *
     * @param integer $status
     * @return PrePlanningUser
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
     * Set ref
     *
     * @param string $ref
     * @return PrePlanningUser
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set contentObjetive
     *
     * @param boolean $contentObjetive
     * @return PrePlanningUser
     */
    public function setContentObjetive($contentObjetive)
    {
        $this->contentObjetive = $contentObjetive;

        return $this;
    }

    /**
     * Get contentObjetive
     *
     * @return boolean 
     */
    public function getContentObjetive()
    {
        return $this->contentObjetive;
    }

    /**
     * Set contentIndicator
     *
     * @param boolean $contentIndicator
     * @return PrePlanningUser
     */
    public function setContentIndicator($contentIndicator)
    {
        $this->contentIndicator = $contentIndicator;

        return $this;
    }

    /**
     * Get contentIndicator
     *
     * @return boolean 
     */
    public function getContentIndicator()
    {
        return $this->contentIndicator;
    }

    /**
     * Set contentArrangementProgram
     *
     * @param boolean $contentArrangementProgram
     * @return PrePlanningUser
     */
    public function setContentArrangementProgram($contentArrangementProgram)
    {
        $this->contentArrangementProgram = $contentArrangementProgram;

        return $this;
    }

    /**
     * Get contentArrangementProgram
     *
     * @return boolean 
     */
    public function getContentArrangementProgram()
    {
        return $this->contentArrangementProgram;
    }

    /**
     * Set contentArrangementProgramGoal
     *
     * @param boolean $contentArrangementProgramGoal
     * @return PrePlanningUser
     */
    public function setContentArrangementProgramGoal($contentArrangementProgramGoal)
    {
        $this->contentArrangementProgramGoal = $contentArrangementProgramGoal;

        return $this;
    }

    /**
     * Get contentArrangementProgramGoal
     *
     * @return boolean 
     */
    public function getContentArrangementProgramGoal()
    {
        return $this->contentArrangementProgramGoal;
    }
}
