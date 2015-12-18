<?php

namespace Pequiven\SEIPBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\User\EvaluationDetails as ModelEvaluationDetails;
use Pequiven\SEIPBundle\Entity\PeriodItemInterface;

/**
 * EvaluationDetails
 *
 * @ORM\Table(name="seip_evaluation_details")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\User\EvaluationDetailsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EvaluationDetails extends ModelEvaluationDetails implements PeriodItemInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="sumResult", type="float", nullable=true)
     */
    private $sumResult;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="quantityItems", type="integer")
     */
    private $quantityItems = 0;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Usuario que fue evaluado
     * @var \Pequiven\SEIPBundle\Entity\User
     * 
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @var \Pequiven\MasterBundle\Entity\Rol
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Rol")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $role;
    
    /**
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $location;
    
    /**
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $gerencia;
    
    /**
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\GerenciaSecond")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $gerenciaSecond;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="error", type="boolean")
     */
    private $error = false;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="sumGoal", type="float", nullable=true)
     */
    private $sumGoal;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="quantityGoal", type="integer")
     */
    private $quantityGoal = 0;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="resultGoal", type="float", nullable=true)
     */
    private $resultGoal;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="sumArrangementProgram", type="float", nullable=true)
     */
    private $sumArrangementProgram;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="quantityArrangementProgram", type="integer")
     */
    private $quantityArrangementProgram = 0;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="resultArrangementProgram", type="float", nullable=true)
     */
    private $resultArrangementProgram;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="sumObjetive", type="float", nullable=true)
     */
    private $sumObjetive;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="quantityObjetive", type="integer")
     */
    private $quantityObjetive = 0;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="resultObjetive", type="float", nullable=true)
     */
    private $resultObjetive;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="finalResult", type="float", nullable=true)
     */
    private $finalResult;
    
    //TODO:
    //SUM METAS-CANT.METAS-RES.METAS-SUM.PG-CANT.PG-RES.PG-SUM.OBJ-CANT.OBJ-RES.OBJ-RES.FINAL
    //(PROM METAS + PROM PG) * 60% + (PROM OBJ) * 40%
    
    
    /**
     * Constructor
     */
    public function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getSumResult() {
        return $this->sumResult;
    }

    function getQuantityItems() {
        return $this->quantityItems;
    }

    function getPeriod() {
        return $this->period;
    }

    function getUser() {
        return $this->user;
    }

    function getRole() {
        return $this->role;
    }

    function getLocation() {
        return $this->location;
    }

    function getGerencia() {
        return $this->gerencia;
    }

    function getGerenciaSecond() {
        return $this->gerenciaSecond;
    }

    function setSumResult($sumResult) {
        $this->sumResult = $sumResult;
    }

    function setQuantityItems($quantityItems) {
        $this->quantityItems = $quantityItems;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    function setUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->user = $user;
    }

    function setRole(\Pequiven\MasterBundle\Entity\Rol $role) {
        $this->role = $role;
    }

    function setLocation(\Pequiven\MasterBundle\Entity\Complejo $location) {
        $this->location = $location;
    }

    function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia) {
        $this->gerencia = $gerencia;
    }

    function setGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond) {
        $this->gerenciaSecond = $gerenciaSecond;
    }
    
    function getError() {
        return $this->error;
    }

    function setError($error) {
        $this->error = $error;
    }
    
    function getSumGoal() {
        return $this->sumGoal;
    }

    function getQuantityGoal() {
        return $this->quantityGoal;
    }

    function getResultGoal() {
        return $this->resultGoal;
    }

    function getSumArrangementProgram() {
        return $this->sumArrangementProgram;
    }

    function getQuantityArrangementProgram() {
        return $this->quantityArrangementProgram;
    }

    function getResultArrangementProgram() {
        return $this->resultArrangementProgram;
    }

    function getSumObjetive() {
        return $this->sumObjetive;
    }

    function getQuantityObjetive() {
        return $this->quantityObjetive;
    }

    function getResultObjetive() {
        return $this->resultObjetive;
    }

    function getFinalResult() {
        return $this->finalResult;
    }

    function setSumGoal($sumGoal) {
        $this->sumGoal = $sumGoal;
    }

    function setQuantityGoal($quantityGoal) {
        $this->quantityGoal = $quantityGoal;
    }

    function setResultGoal($resultGoal) {
        $this->resultGoal = $resultGoal;
    }

    function setSumArrangementProgram($sumArrangementProgram) {
        $this->sumArrangementProgram = $sumArrangementProgram;
    }

    function setQuantityArrangementProgram($quantityArrangementProgram) {
        $this->quantityArrangementProgram = $quantityArrangementProgram;
    }

    function setResultArrangementProgram($resultArrangementProgram) {
        $this->resultArrangementProgram = $resultArrangementProgram;
    }

    function setSumObjetive($sumObjetive) {
        $this->sumObjetive = $sumObjetive;
    }

    function setQuantityObjetive($quantityObjetive) {
        $this->quantityObjetive = $quantityObjetive;
    }

    function setResultObjetive($resultObjetive) {
        $this->resultObjetive = $resultObjetive;
    }

    function setFinalResult($finalResult) {
        $this->finalResult = $finalResult;
    }




}