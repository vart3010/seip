<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * 
 * @author Maximo Sojo maxsojo13@gmail.com
 * @ORM\Table(name="sip_nomina_centro")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\NominaCentroRepository")
 * 
 */
class NominaCentro {

    /**
     * @var \Integer
     * 
     * @ORM\Column(name="userid", type="integer")
     * @ORM\Id
     */
    private $userid;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="string",nullable=true)
     */
    private $telefono;

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer",nullable=true)
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEstado", type="string", length=255)
     */
    private $descriptionEstado;

     /**
     * @var string
     *
     * @ORM\Column(name="descriptionMunicipio", type="string", length=255)
     */
    private $descriptionMunicipio;

     /**
     * @var string
     *
     * @ORM\Column(name="descriptionParroquia", type="string", length=255)
     */
    private $descriptionParroquia;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer",nullable=true)
     */
    private $codigoCentro;

    /**
     * @var string
     *
     * @ORM\Column(name="centro", type="string",nullable=true)
     */
    private $centro;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255,nullable=true)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255,nullable=true)
     */
    private $localidad;
    
    /**
     * @var \Integer
     * 
     * @ORM\Column(name="oneid", type="integer",nullable=true)
     */
    private $oneid;
    
    /**
     * @var \Integer
     * 
     * @ORM\Column(name="centroid", type="integer",nullable=true)
     */
    private $centroid;
    
    /**
     * voto
     * @var integer
     *
     * @ORM\Column(name="voto", type="integer", nullable=true)
     */
    private $voto = 0;
    
    function setUserid($userid) {
        $this->userid = $userid;
    }

    function getUserid() {
        return $this->userid;
    }
    
    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function getCedula() {
        return $this->cedula;
    }


    function setDescriptionEstado($descriptionEstado) {
        $this->descriptionEstado = $descriptionEstado;
    }

    function getDescriptionEstado() {
        return $this->descriptionEstado;
    }

    function setDescriptionMunicipio($descriptionMunicipio) {
        $this->descriptionMunicipio = $descriptionMunicipio;
    }

    function getDescriptionMunicipio() {
        return $this->descriptionMunicipio;
    }

    function setDescriptionParroquia($descriptionParroquia) {
        $this->descriptionParroquia = $descriptionParroquia;
    }

    function getDescriptionParroquia() {
        return $this->descriptionParroquia;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }
    
    function getCodigoCentro() {
        return $this->codigoCentro;
    }


    function setCentro($centro) {
        $this->centro = $centro;
    }
    
    function getCentro() {
        return $this->centro;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }
    
    function getLocalidad() {
        return $this->localidad;
    }
    
    function setOneid($oneid) {
        $this->oneid = $oneid;
    }

    function getOneid() {
        return $this->oneid;
    }
    
    function setCentroid($centroid) {
        $this->centroid = $centroid;
    }

    function getCentroid() {
        return $this->centroid;
    }
    
    function setVoto($voto) {
        $this->voto = $voto;
    }
    
    function getVoto() {
        return $this->voto;
    }
}
