<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CUTL
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_cutl")
 * @ORM\Entity()
 */
class Cutl {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * municipio
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=255)
     */
    private $municipio;

    /**
     * parroquia
     * @var string
     *
     * @ORM\Column(name="parroquia", type="string", length=255)
     */
    private $parroquia;
    
    /**
     * Eje
     * @var integer
     *
     * @ORM\Column(name="eje", type="integer")
     */
    private $eje = 0;

    /**
     * codigo centro
     * @var string
     *
     * @ORM\Column(name="codigoCentro", type="integer")
     */
    private $codigoCentro;

    /**
     * centro
     * @var string
     *
     * @ORM\Column(name="centro", type="string")
     */
    private $centro;

    /**
     * cedula
     * @var string
     *
     * @ORM\Column(name="cedula", type="integer")
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
     * nombreSeip
     * @var string
     *
     * @ORM\Column(name="nombreSeip", type="string")
     */
    private $nombreSeip;

    /**
     * nombreCutl
     * @var string
     *
     * @ORM\Column(name="nombreCutl", type="string")
     */
    private $nombreCutl;

    /**
     * telefono seip
     * @var string
     *
     * @ORM\Column(name="telefonoSeip", type="string")
     */
    private $telefonoSeip;

    /**
     * telefono firma
     * @var string
     *
     * @ORM\Column(name="telefonoFirma", type="string")
     */
    private $telefonoFirma;

    /**
     * telefono cutl
     * @var string
     *
     * @ORM\Column(name="telefonoCutl", type="string")
     */
    private $telefonoCutl;

    /**
     * gerenciafirst
     * @var string
     *
     * @ORM\Column(name="gerenciafirst", type="string")
     */
    private $gerenciafirst;

    /**
     * gerenciaSecond
     * @var string
     *
     * @ORM\Column(name="gerenciaSecond", type="string")
     */
    private $gerenciaSecond;
    
    /**
     * cedula
     * @var integer
     *
     * @ORM\Column(name="orderCenter", type="integer")
     */
    private $orderCenter;

    function getId() {
        return $this->id;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function getParroquia() {
        return $this->parroquia;
    }
    
        
    function getEje() {
        return $this->eje;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getCentro() {
        return $this->centro;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNombreSeip() {
        return $this->nombreSeip;
    }

    function getNombreCutl() {
        return $this->nombreCutl;
    }

    function getTelefonoSeip() {
        return $this->telefonoSeip;
    }

    function getTelefonoFirma() {
        return $this->telefonoFirma;
    }

    function getTelefonoCutl() {
        return $this->telefonoCutl;
    }

    function getGerenciafirst() {
        return $this->gerenciafirst;
    }

    function getGerenciaSecond() {
        return $this->gerenciaSecond;
    }

    function getOrderCenter() {
        return $this->orderCenter;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    function setParroquia($parroquia) {
        $this->parroquia = $parroquia;
    }
    
    function setEje($eje) {
        $this->eje = $eje;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setCentro($centro) {
        $this->centro = $centro;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setNombreSeip($nombreSeip) {
        $this->nombreSeip = $nombreSeip;
    }

    function setNombreCutl($nombreCutl) {
        $this->nombreCutl = $nombreCutl;
    }

    function setTelefonoSeip($telefonoSeip) {
        $this->telefonoSeip = $telefonoSeip;
    }

    function setTelefonoFirma($telefonoFirma) {
        $this->telefonoFirma = $telefonoFirma;
    }

    function setTelefonoCutl($telefonoCutl) {
        $this->telefonoCutl = $telefonoCutl;
    }

    function setGerenciafirst($gerenciafirst) {
        $this->gerenciafirst = $gerenciafirst;
    }

    function setGerenciaSecond($gerenciaSecond) {
        $this->gerenciaSecond = $gerenciaSecond;
    }

    function setOrderCenter($orderCenter) {
        $this->orderCenter = $orderCenter;
    }

}
