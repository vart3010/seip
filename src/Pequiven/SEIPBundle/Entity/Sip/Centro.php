<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parroquia
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_centro")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\IndicatorRepository")
 */
class Centro {

    /**
     * @var integer
     *
     * @ORM\Column(name="id",type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * Código de Estado
     * @var integer
     *
     * @ORM\Column(name="codigoEstado", type="integer")
     */
    private $codigoEstado;
    
    /**
     * Estado
     * @var string
     *
     * @ORM\Column(name="descriptionEstado", type="string", length=100)
     */
    private $descriptionEstado;

    /**
     * Código de Municipio
     * @var integer
     *
     * @ORM\Column(name="codigoMunicipio", type="integer")
     */
    private $codigoMunicipio;
    
    /**
     * Municipio
     * @var string
     *
     * @ORM\Column(name="descriptionMunicipio", type="string", length=100)
     */
    private $descriptionMunicipio;

    /**
     * Código de Parroquia
     * @var integer
     *
     * @ORM\Column(name="codigoParroquia",type="integer")
     */
    private $codigoParroquia;
    
    /**
     * Parroquia
     * @var string
     *
     * @ORM\Column(name="descriptionParroquia", type="string", length=100)
     */
    private $descriptionParroquia;

    /**
     * Código de Centro
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer")
     */
    private $codigoCentro;

    /**
     * Nombre Centro
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * Dirección Centro
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;
    
    /**
     * Mesas
     * @var integer
     *
     * @ORM\Column(name="mesas", type="integer")
     */
    private $mesas = 0;
    
    /**
     * Electores
     * @var integer
     *
     * @ORM\Column(name="electores", type="integer")
     */
    private $electores = 0;
    
    /**
     * Eje
     * @var integer
     *
     * @ORM\Column(name="eje", type="integer")
     */
    private $eje = 0;
    
    /**
     * Cédula UBCH
     * @var string
     *
     * @ORM\Column(name="cedulaubch", type="string", length=20)
     */
    private $cedulaubch;
    
    /**
     * Nombre UBCH
     * @var string
     *
     * @ORM\Column(name="nombreubch", type="string", length=100)
     */
    private $nombreubch;
    
    /**
     * Teléfono UBCH
     * @var string
     *
     * @ORM\Column(name="telefonoubch", type="string", length=20)
     */
    private $telefonoubch;
    
    /**
     * Cargo UBCH
     * @var string
     *
     * @ORM\Column(name="cargoubch", type="string", length=50)
     */
    private $cargoubch;
    
    function getId() {
        return $this->id;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }
    
    function getDescriptionEstado() {
        return $this->descriptionEstado;
    }

    function getCodigoMunicipio() {
        return $this->codigoMunicipio;
    }
    
    function getDescriptionMunicipio() {
        return $this->descriptionMunicipio;
    }

    function getCodigoParroquia() {
        return $this->codigoParroquia;
    }
    
    function getDescriptionParroquia() {
        return $this->descriptionParroquia;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getDescription() {
        return $this->description;
    }
    
    function getDireccion() {
        return $this->direccion;
    }
    
    function getMesas() {
        return $this->mesas;
    }
    
    function getElectores() {
        return $this->electores;
    }
    
    function getEje() {
        return $this->eje;
    }
    
    function getCedulaUbch() {
        return $this->cedulaubch;
    }
    
    function getNombreUbch() {
        return $this->nombreubch;
    }
    
    function getTelefonoUbch() {
        return $this->telefonoubch;
    }
    
    function getCargoUbch() {
        return $this->cargoubch;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }
    
    function setDescriptionEstado($descriptionEstado) {
        $this->descriptionEstado = $descriptionEstado;
    }

    function setCodigoMunicipio($codigoMunicipio) {
        $this->codigoMunicipio = $codigoMunicipio;
    }
    
    function setDescriptionMunicipio($descriptionMunicipio) {
        $this->descriptionMunicipio = $descriptionMunicipio;
    }

    function setCodigoParroquia($codigoParroquia) {
        $this->codigoParroquia = $codigoParroquia;
    }
    
    function setDescriptionParroquia($descriptionParroquia) {
        $this->descriptionParroquia = $descriptionParroquia;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    
    function setMesas($mesas) {
        $this->mesas = $mesas;
    }
    
    function setElectores($electores) {
        $this->electores = $electores;
    }
    
    function setEje($eje) {
        $this->eje = $eje;
    }
    
    function setCedulaUbch($cedulaubch) {
        $this->cedulaubch = $cedulaubch;
    }
    
    function setNombreUbch($nombreubch) {
        $this->nombreubch = $nombreubch;
    }
    
    function setTelefonoUbch($telefonoubch) {
        $this->telefonoubch = $telefonoubch;
    }
    
    function setCargoUbch($cargoubch) {
        $this->cargoubch = $cargoubch;
    }
}
