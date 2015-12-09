<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * OnePerTen
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_onePerTen")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\OnePerTenRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class OnePerTen {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * cedula del 1
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=12,nullable=true)
     */
    private $cedula;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * fecha voto
     * @ORM\Column(name="fechaVoto", type="datetime", nullable=true)
     */
    private $fechaVoto;
    
    /**
     * voto
     * @var integer
     *
     * @ORM\Column(name="voto", type="integer", nullable=true)
     */
    private $voto = 0;
    
    /**
     * psuv
     * @var integer
     *
     * @ORM\Column(name="psuv", type="integer", nullable=true)
     */
    private $psuv;
    
    /**
     * intPsuv
     * @var integer
     *
     * @ORM\Column(name="intPsuv", type="integer", nullable=true)
     */
    private $intPsuv;
    
    /**
     * intOpo
     * @var integer
     *
     * @ORM\Column(name="intOpo", type="integer", nullable=true)
     */
    private $intOpo;
    
    /**
     * reubicado
     * @var integer
     *
     * @ORM\Column(name="reubicado", type="integer", nullable=true)
     */
    private $reubicado;
    
    /**
     * esperanza
     * @var integer
     *
     * @ORM\Column(name="esperanza", type="integer", nullable=true)
     */
    private $esperanza;
    
    /**
     * vpresidencial1
     * @var integer
     *
     * @ORM\Column(name="vpresidencial1", type="integer", nullable=true)
     */
    private $vpresidencial1;
    
    /**
     * vregionales
     * @var integer
     *
     * @ORM\Column(name="vregionales", type="integer", nullable=true)
     */
    private $vregionales;
    
    /**
     * vpresidencial2
     * @var integer
     *
     * @ORM\Column(name="vpresidencial2", type="integer", nullable=true)
     */
    private $vpresidencial2;
    
    /**
     * vmunicipales
     * @var integer
     *
     * @ORM\Column(name="vmunicipales", type="integer", nullable=true)
     */
    private $vmunicipales;

    /**
     * @var \Pequiven\SEIPBundle\Entity\Sip\OnerPerTenMembers
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers", mappedBy="one", cascade={"persist","remove"})
     */
    private $ten;

    public function __construct() {
        $this->ten = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers $onePerTenMembers
     * @return \Pequiven\SEIPBundle\Entity\Sip\OnePerTen
     */
    public function addTen(OnePerTenMembers $onePerTenMembers) {
        $onePerTenMembers->setOne($this);
        $this->ten->add($onePerTenMembers);
        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers $onePerTenMembers
     */
    public function removeTen(OnePerTenMembers $onePerTenMembers) {
        $this->ten->removeElement($onePerTenMembers);
    }

    public function getTen() {
        return $this->ten;
    }

    function getId() {
        return $this->id;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getUser() {
        return $this->user;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setUser(\Pequiven\SEIPBundle\Entity\User $user) {
        $this->user = $user;
    }

    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setVoto($voto) {
        $this->voto = $voto;
    }
    
    function getVoto() {
        return $this->voto;
    }

    function getFechaVoto() {
        return $this->fechaVoto;
    }

    function setFechaVoto($fechaVoto) {
        $this->fechaVoto = $fechaVoto;
    }

    function getPsuv() {
        return $this->psuv;
    }

    function setPsuv($psuv) {
        $this->psuv = $psuv;
    }
    
    function getIntPsuv() {
        return $this->intPsuv;
    }

    function setIntPsuv($intPsuv) {
        $this->intPsuv = $intPsuv;
    }
    
    function getIntOpo() {
        return $this->intOpo;
    }

    function setIntOpo($intOpo) {
        $this->intOpo = $intOpo;
    }
    
    function getReubicado() {
        return $this->reubicado;
    }

    function setReubicado($reubicado) {
        $this->reubicado = $reubicado;
    }
    
    function getEsperanza() {
        return $this->esperanza;
    }

    function setEsperanza($esperanza) {
        $this->esperanza = $esperanza;
    }
    
    function getVpresidencial1() {
        return $this->vpresidencial1;
    }

    function setVpresidencial1($vpresidencial1) {
        $this->vpresidencial1 = $vpresidencial1;
    }
    
    function getVregionales() {
        return $this->vregionales;
    }

    function setVregionales($vregionales) {
        $this->vregionales = $vregionales;
    }
    
    function getVpresidencial2() {
        return $this->vpresidencial2;
    }

    function setVpresidencial2($vpresidencial2) {
        $this->vpresidencial2 = $vpresidencial2;
    }
    
    function getVmunicipales() {
        return $this->vmunicipales;
    }

    function setVmunicipales($vmunicipales) {
        $this->vmunicipales = $vmunicipales;
    }

}
