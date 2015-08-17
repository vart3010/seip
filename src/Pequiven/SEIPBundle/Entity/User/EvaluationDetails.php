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


}