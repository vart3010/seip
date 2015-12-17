<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Gerencia as modelGerencia;
use Pequiven\MasterBundle\Model\Evaluation\AuditableInterface;
use Pequiven\MasterBundle\Entity\GerenciaSecond;

/**
 * Estructura de Cargos
 *
 * @ORM\Table(name="FeeStructure")
 * @ORM\Entity
 * @author Gilbert <glavrjk@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class FeeStructure {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * Complejo
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $complejo;

    /**
     * Gerencia de 1ra Línea
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gerencia;

    /**
     * Gerencia de 2da Línea
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gerenciasecond;

    /**
     * Coordinación
     * @var \Pequiven\MasterBundle\Entity\Coordinacion
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Coordinacion",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coordinacion;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\FeeStructure",inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", nullable=true)
     */
    private $parent;

    /**
     * @var \Pequiven\MasterBundle\Entity\FeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\MasterBundle\Entity\FeeStructure",mappedBy="parent",cascade={"persist"}))
     */
    protected $children;

    /**
     * @var boolean
     * @ORM\Column(name="staff", type="boolean")
     */
    private $staff = false;

    /**
     * @var string
     * @ORM\Column(name="codigo", type="string", length=100, nullable=true)
     */
    private $codigo;

    /**
     * Cargo
     * @var string
     * @ORM\Column(name="charge", type="string")
     */
    private $charge;

    /** ID USUARIO
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $User;

    /**
     * @var \Pequiven\MasterBundle\Entity\MovementFeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\MasterBundle\Entity\MovementFeeStructure",mappedBy="feestructure",cascade={"persist"}))
     */
    protected $movementFeeStructure;

    function getId() {
        return $this->id;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCharge() {
        return $this->charge;
    }

    function getUser() {
        return $this->User;
    }

    function getStaff() {
        return $this->staff;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function getParent() {
        return $this->parent;
    }

    function getChildren() {
        return $this->children;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCharge($charge) {
        $this->charge = $charge;
    }

    function setUser($User) {
        $this->User = $User;
    }

    function setStaff($staff) {
        $this->staff = $staff;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function setChildren(\Pequiven\MasterBundle\Entity\FeeStructure $children) {
        $this->children = $children;
    }

    function getComplejo() {
        return $this->complejo;
    }

    function getGerencia() {
        return $this->gerencia;
    }

    function getCoordinacion() {
        return $this->coordinacion;
    }

    function getGerenciasecond() {
        return $this->gerenciasecond;
    }

    function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo) {
        $this->complejo = $complejo;
    }

    function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia) {
        $this->gerencia = $gerencia;
    }

    function setGerenciasecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciasecond) {
        $this->gerenciaSecond = $gerenciasecond;
    }

    function setCoordinacion(\Pequiven\MasterBundle\Entity\Coordinacion $coordinacion) {
        $this->coordinacion = $coordinacion;
    }

}
