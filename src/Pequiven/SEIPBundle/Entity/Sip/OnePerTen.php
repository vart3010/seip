<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Sip\OnePerTen as modelOnePerTen;

/**
 * OnePerTen
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_onePerTen")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\OnePerTenRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class OnePerTen extends modelOnePerTen {

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
     * Usuario con 1x10
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
     * Análisis político de la persona
     * @var string
     *
     * @ORM\Column(name="analisis", type="text", nullable=true)
     */
    private $analisis;

    /**
     * Fecha en la que reportó el voto por mensaje o llamada en las elecciones de la asamblea 2015
     * @ORM\Column(name="fechaVoto", type="datetime", nullable=true)
     */
    private $fechaVoto;
    
    /**
     * Reporte del voto por mensaje o llamada en las elecciones de la asamblea 2015
     * voto
     * @var integer
     *
     * @ORM\Column(name="voto", type="integer", nullable=true)
     */
    private $voto = 0;
    
    /**
     * Inscrito en el PSUV (Militante)
     * psuv
     * @var integer
     *
     * @ORM\Column(name="psuv", type="integer", nullable=true)
     */
    private $psuv;
    
    /**
     * Votó en las internas del PSUV rumbo a las elecciones asamblea 2015
     * intPsuv
     * @var integer
     *
     * @ORM\Column(name="intPsuv", type="integer", nullable=true)
     */
    private $intPsuv;
    
    /**
     * Votó en las internas de la MUD rumbo a las elecciones asamblea 2015
     * intOpo
     * @var integer
     *
     * @ORM\Column(name="intOpo", type="integer", nullable=true)
     */
    private $intOpo;
    
    /**
     * ¿La persona se reubicó para las elecciones asamblea 2015?
     * reubicado
     * @var integer
     *
     * @ORM\Column(name="reubicado", type="integer", nullable=true)
     */
    private $reubicado;
    
    /**
     * Firma del decreto Esperanza
     * esperanza
     * @var integer
     *
     * @ORM\Column(name="esperanza", type="integer", nullable=true)
     */
    private $esperanza;
    
    /**
     * Votó en las elecciones presidenciales 2012
     * vpresidencial1
     * @var integer
     *
     * @ORM\Column(name="vpresidencial1", type="integer", nullable=true)
     */
    private $vpresidencial1;
    
    /**
     * Votó en las elecciones regionales 2012
     * vregionales
     * @var integer
     *
     * @ORM\Column(name="vregionales", type="integer", nullable=true)
     */
    private $vregionales;
    
    /**
     * Votó en las elecciones presidenciales 2013
     * vpresidencial2
     * @var integer
     *
     * @ORM\Column(name="vpresidencial2", type="integer", nullable=true)
     */
    private $vpresidencial2;
    
    /**
     * Votó en las elecciones municipales 2013
     * vmunicipales
     * @var integer
     *
     * @ORM\Column(name="vmunicipales", type="integer", nullable=true)
     */
    private $vmunicipales;
    
    /**
     * Firmó en la Lista Sumate 2002
     * fref
     * @var integer
     *
     * @ORM\Column(name="fref", type="integer", nullable=true)
     */
    private $fref;
    
    /**
     * ¿Es vanguardia PSUV?
     * vanguardia
     * @var integer
     *
     * @ORM\Column(name="vanguardia", type="integer", nullable=true)
     */
    private $vanguardia;
    
    /**
     * ¿Es miembro de alguna UBCH?
     * ubch
     * @var integer
     *
     * @ORM\Column(name="ubch", type="integer", nullable=true)
     */
    private $ubch;
    
    /**
     * 
     * firmaCompromiso
     * @var integer
     *
     * @ORM\Column(name="firmaCompromiso", type="integer", nullable=true)
     */
    private $firmaCompromiso;
    
    /**
     * militante (Que es parte del PSUV)
     * @var integer
     *
     * @ORM\Column(name="militante", type="integer", nullable=true)
     */
    private $militante;

    /**
     * @var \Pequiven\SEIPBundle\Entity\Sip\OnerPerTenMembers
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Sip\OnePerTenMembers", mappedBy="one", cascade={"persist","remove"})
     */
    private $ten;
    
    /**
     * Votó en las elecciones asamblea 2015
     * vasamblea6
     * @var integer
     *
     * @ORM\Column(name="vasamblea6", type="integer", nullable=true)
     */
    private $vasamblea6;
    
    /**
     * Realizó 1x10 en el PSUV
     * onePerTenPsuv
     * @var integer
     *
     * @ORM\Column(name="onePerTenPsuv", type="integer", nullable=true)
     */
    private $onePerTenPsuv;
    
    /**
     * Fue Miembro de algún 1x10 en el PSUV
     * memberOnePerTenPsuv
     * @var integer
     *
     * @ORM\Column(name="memberOnePerTenPsuv", type="integer", nullable=true)
     */
    private $memberOnePerTenPsuv;
    
    /**
     * Fue CUTL en las elecciones asamblea 2015
     * cutl
     * @var integer
     *
     * @ORM\Column(name="cutl", type="integer", nullable=true)
     */
    private $cutl;
    
    /**
     * Fue Trabajador de Sala Situacional en las elecciones asamblea 2015
     * sala
     * @var integer
     *
     * @ORM\Column(name="sala", type="integer", nullable=true)
     */
    private $sala;
    
    /**
     * Fue Trabajador por el CNE en las elecciones asamblea 2015
     * cne
     * @var integer
     *
     * @ORM\Column(name="cne", type="integer", nullable=true)
     */
    private $cne;
    
    /** Fecha de Nacimiento de la Persona
     * @var \DateTime
     * @ORM\Column(name="bornDate", type="datetime",nullable=true)
     */
    private $bornDate;
    
    /**
     * Edad para el 2002, con que firmó en la Lista Sumate en el 2003 o 2004
     * ageSignatureSumate
     * @var integer
     *
     * @ORM\Column(name="ageSignatureSumate", type="integer", nullable=true)
     */
    private $ageSignatureSumate;
    
    /**
     * @var float
     * workEfficiencyAssemblyElections
     * @ORM\Column(name="workEfficiencyAssemblyElections", type="float", nullable=true)
     */
    private $workEfficiencyAssemblyElections = 0;
    
    /**
     * En caso de que el trabajador tenga un status por defecto
     * markedStatus
     * @var integer
     *
     * @ORM\Column(name="markedStatus", type="integer", nullable=true)
     */
    private $markedStatus = 0;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="lastDateCalculateProfile", type="datetime",nullable=true)
     */
    private $lastDateCalculateProfile;
    
    /**
     * Valor del perfil del usuario
     * profileValue
     * @var integer
     * @ORM\Column(name="profileValue", type="integer", nullable=true)
     */
    private $profileValue;
    
    /**
     * Valor real del perfil del usuario
     * profileValue
     * @var integer
     * @ORM\Column(name="realProfileValue", type="integer", nullable=true)
     */
    private $realProfileValue;

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
    
    function getFref() {
        return $this->fref;
    }

    function setFref($fref) {
        $this->fref = $fref;
    }
    
    function getVanguardia() {
        return $this->vanguardia;
    }

    function setVanguardia($vanguardia) {
        $this->vanguardia = $vanguardia;
    }
    
    function getUbch() {
        return $this->ubch;
    }

    function setUbch($ubch) {
        $this->ubch = $ubch;
    }
    
    function getFirmaCompromiso() {
        return $this->firmaCompromiso;
    }

    function setFirmaCompromiso($firmaCompromiso) {
        $this->firmaCompromiso = $firmaCompromiso;
    }
       
    function getMilitante() {
        return $this->militante;
    }

    function setMilitante($militante) {
        $this->militante = $militante;
    }
    
    function getVasamblea6() {
        return $this->vasamblea6;
    }

    function setVasamblea6($vasamblea6) {
        $this->vasamblea6 = $vasamblea6;
    }
    
    function getOnePerTenPsuv() {
        return $this->onePerTenPsuv;
    }

    function setOnePerTenPsuv($onePerTenPsuv) {
        $this->onePerTenPsuv = $onePerTenPsuv;
    }
    
    function getMemberOnePerTenPsuv() {
        return $this->memberOnePerTenPsuv;
    }

    function setMemberOnePerTenPsuv($memberOnePerTenPsuv) {
        $this->memberOnePerTenPsuv = $memberOnePerTenPsuv;
    }
    
    function getAnalisis() {
        return $this->analisis;
    }

    function setAnalisis($analisis) {
        $this->analisis = $analisis;
    }
    
    function getCutl() {
        return $this->cutl;
    }

    function setCutl($cutl) {
        $this->cutl = $cutl;
    }

    function getSala() {
        return $this->sala;
    }

    function getCne() {
        return $this->cne;
    }

    function setSala($sala) {
        $this->sala = $sala;
    }

    function setCne($cne) {
        $this->cne = $cne;
    }
    
    function getBornDate() {
        return $this->bornDate;
    }

    function setBornDate(\DateTime $bornDate) {
        $this->bornDate = $bornDate;
    }

    function getAgeSignatureSumate() {
        return $this->ageSignatureSumate;
    }

    function setAgeSignatureSumate($ageSignatureSumate) {
        $this->ageSignatureSumate = $ageSignatureSumate;
    }
    
    function getWorkEfficiencyAssemblyElections() {
        return $this->workEfficiencyAssemblyElections;
    }

    function setWorkEfficiencyAssemblyElections($workEfficiencyAssemblyElections) {
        $this->workEfficiencyAssemblyElections = $workEfficiencyAssemblyElections;
    }
    
    function getMarkedStatus() {
        return $this->markedStatus;
    }

    function setMarkedStatus($markedStatus) {
        $this->markedStatus = $markedStatus;
    }
    
    function getLastDateCalculateProfile() {
        return $this->lastDateCalculateProfile;
    }

    function setLastDateCalculateProfile(\DateTime $lastDateCalculateProfile) {
        $this->lastDateCalculateProfile = $lastDateCalculateProfile;
    }
    
    public function updateLastDateCalculateProfile() 
    {
        $this->lastDateCalculateProfile = new \DateTime();
    }
    
    function getProfileValue() {
        return $this->profileValue;
    }

    function setProfileValue($profileValue) {
        $this->profileValue = $profileValue;
    }
    
    function getRealProfileValue() {
        return $this->realProfileValue;
    }

    function setRealProfileValue($realProfileValue) {
        $this->realProfileValue = $realProfileValue;
    }

}
