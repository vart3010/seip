<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * miembros de onePerTen
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_onePerTenMembers")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\OnePerTenMembersRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class OnePerTenMembers {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Id one
     * @var \Pequiven\SEIPBundle\Entity\Sip\OnePerTen
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Sip\OnePerTen", inversedBy="ten")
     */
    private $one;

    /**
     * cedula del 1
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=12)
     */
    private $cedula;

    /**
     * nombre
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * codigo de centro
     * @var string
     *
     * @ORM\Column(name="codCentro", type="string",nullable=true)
     */
    private $codCentro;

    /**
     * Nombre de centro
     * @var string
     *
     * @ORM\Column(name="nombreCentro", type="string",nullable=true)
     */
    private $nombreCentro;

    /**
     * codigo de parroquia
     * @var string
     *
     * @ORM\Column(name="codigoParroquia", type="integer",nullable=true)
     */
    private $codigoParroquia;

    /**
     * Nombre de parroquia
     * @var string
     *
     * @ORM\Column(name="nombreParroquia", type="string",nullable=true)
     */
    private $nombreParroquia;

    /**
     * codigo de municipio
     * @var string
     *
     * @ORM\Column(name="codigoMunicipio", type="integer",nullable=true)
     */
    private $codigoMunicipio;

    /**
     * Nombre de Municipio
     * @var string
     *
     * @ORM\Column(name="nombreMunicipio", type="string",nullable=true)
     */
    private $nombreMunicipio;

    /**
     * codigo de Estado
     * @var string
     *
     * @ORM\Column(name="codigoEstado", type="integer",nullable=true)
     */
    private $codigoEstado;

    /**
     * Nombre de Estado
     * @var string
     *
     * @ORM\Column(name="nombreEstado", type="string",nullable=true)
     */
    private $nombreEstado;

    /**
     * telefono
     * @var string
     *
     * @ORM\Column(name="telefono", type="string")
     */
    private $telefono;

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
     * vasamblea6
     * @var integer
     *
     * @ORM\Column(name="vasamblea6", type="integer", nullable=true)
     */
    private $vasamblea6 = 0;
    
    /**
     * localidadOne
     * @var string
     *
     * @ORM\Column(name="localidadOne", type="string", nullable=true)
     */
    private $localidadOne;
        
    /**
     * @var \Integer
     * 
     * @ORM\Column(name="centroid", type="integer",nullable=true )
     */
    private $centroid;

    function getCodigoParroquia() {
        return $this->codigoParroquia;
    }

    function getNombreParroquia() {
        return $this->nombreParroquia;
    }

    function getCodigoMunicipio() {
        return $this->codigoMunicipio;
    }

    function getNombreMunicipio() {
        return $this->nombreMunicipio;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getNombreEstado() {
        return $this->nombreEstado;
    }

    function getLocalidadOne() {
        return $this->localidadOne;
    }

    function setCodigoParroquia($codigoParroquia) {
        $this->codigoParroquia = $codigoParroquia;
    }

    function setNombreParroquia($nombreParroquia) {
        $this->nombreParroquia = $nombreParroquia;
    }

    function setCodigoMunicipio($codigoMunicipio) {
        $this->codigoMunicipio = $codigoMunicipio;
    }

    function setNombreMunicipio($nombreMunicipio) {
        $this->nombreMunicipio = $nombreMunicipio;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setNombreEstado($nombreEstado) {
        $this->nombreEstado = $nombreEstado;
    }

    function getNombreCentro() {
        return $this->nombreCentro;
    }

    function setNombreCentro($nombreCentro) {
        $this->nombreCentro = $nombreCentro;
    }

    function getOne() {
        return $this->one;
    }

    function setOne(\Pequiven\SEIPBundle\Entity\Sip\OnePerTen $one) {
        $this->one = $one;
    }

    function getId() {
        return $this->id;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodCentro() {
        return $this->codCentro;
    }

    function getTelefono() {
        return $this->telefono;
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

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodCentro($codCentro) {
        $this->codCentro = $codCentro;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
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

    function setLocalidadOne($localidadOne) {
        $this->localidadOne = $localidadOne;
    }

    function setCentroid($centroid) {
        $this->centroid = $centroid;
    }

    function getCentroid() {
        return $this->centroid;
    }

    function setVasamblea6($vasamblea6) {
        $this->vasamblea6 = $vasamblea6;
    }

    function getVasamblea6() {
        return $this->vasamblea6;
    }

}
