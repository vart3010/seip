<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Rep
 *
 * @ORM\Table(name="sip_nomina")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\NominaRepository")
 * @ORM\Table(name="sip_nomina",indexes={@ORM\Index(name="nomina_idx", columns={"nroPersonal","codigoMunicipio","codigoParroquia","codigoEstado","codigoCentro","codigoCentroSimulacro","codigoCentro_6d"})})
 */
class Nomina {

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer")
     * @ORM\Id
     */
    private $cedula;

    /**
     * @var integer
     *
     * @ORM\Column(name="nroPersonal",type="integer",nullable=false)
     */
    private $nroPersonal;

    /**
     * @var string
     *
     * @ORM\Column(name="empleado", type="string")
     */
    private $empleado;

    /**
     * @var localidad
     *
     * @ORM\Column(name="localidad", type="string")
     */
    private $localidad;

    /**
     * @var nivel
     *
     * @ORM\Column(name="nivel", type="string")
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="gerenciaFirst", type="string")
     */
    private $gerenciaFirst;

    /**
     * @var string
     *
     * @ORM\Column(name="gerenciaSecond", type="string")
     */
    private $gerenciaSecond;

    /**
     * @var string
     *
     * @ORM\Column(name="unidadOrganizativa", type="string")
     */
    private $unidadOrganizativa;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string")
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoEstado", type="integer",nullable=false)
     */
    private $codigoEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoMunicipio", type="integer",nullable=false)
     */
    private $codigoMunicipio;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoParroquia", type="integer",nullable=false)
     */
    private $codigoParroquia;

    /**
     * @var string
     *
     * @ORM\Column(name="circusncripcion", type="integer")
     */
    private $circusncripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCentro", type="integer",nullable=false)
     */
    private $codigoCentro;

    /**
     * @var string
     *
     * @ORM\Column(name="centro", type="integer")
     */
    private $centro;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="integer")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCentroSimulacro", type="integer",nullable=false)
     */
    private $codigoCentroSimulacro;

    /**
     * @var string
     *
     * @ORM\Column(name="centroSimulacro", type="integer",nullable=false)
     */
    private $centroSimulacro;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionSimulacro", type="integer")
     */
    private $direccionCentroSimulacro;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCentro_6d", type="integer",nullable=false)
     */
    private $codigoCentro6d;

    /**
     * @var string
     *
     * @ORM\Column(name="centro_6d", type="integer")
     */
    private $centro6d;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_6d", type="integer")
     */
    private $direccion6d;

    /**
     * @var string
     *
     * @ORM\Column(name="psuv", type="string")
     */
    private $psuv;

    /**
     * @var string
     *
     * @ORM\Column(name="v7oct", type="string")
     */
    private $v7oct;

    /**
     * @var string
     *
     * @ORM\Column(name="v16dic", type="string")
     */
    private $v16dic;

    /**
     * @var string
     *
     * @ORM\Column(name="v14abr", type="string")
     */
    private $v14abr;

    /**
     * @var string
     *
     * @ORM\Column(name="v8dic", type="string")
     */
    private $v8dic;

    /**
     * @var string
     *
     * @ORM\Column(name="internasPsuv2015", type="string")
     */
    private $internasPsuv2015;

    /**
     * @var string
     *
     * @ORM\Column(name="intOposicion", type="string")
     */
    private $intOposicion;

    function getCedula() {
        return $this->cedula;
    }

    function getNroPersonal() {
        return $this->nroPersonal;
    }

    function getEmpleado() {
        return $this->empleado;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getGerenciaFirst() {
        return $this->gerenciaFirst;
    }

    function getGerenciaSecond() {
        return $this->gerenciaSecond;
    }

    function getUnidadOrganizativa() {
        return $this->unidadOrganizativa;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getCodigoMunicipio() {
        return $this->codigoMunicipio;
    }

    function getCodigoParroquia() {
        return $this->codigoParroquia;
    }

    function getCircusncripcion() {
        return $this->circusncripcion;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getCentro() {
        return $this->centro;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCodigoCentroSimulacro() {
        return $this->codigoCentroSimulacro;
    }

    function getCentroSimulacro() {
        return $this->centroSimulacro;
    }

    function getDireccionCentroSimulacro() {
        return $this->direccionCentroSimulacro;
    }

    function getCodigoCentro6d() {
        return $this->codigoCentro6d;
    }

    function getCentro6d() {
        return $this->centro6d;
    }

    function getDireccion6d() {
        return $this->direccion6d;
    }

    function getPsuv() {
        return $this->psuv;
    }

    function getV7oct() {
        return $this->v7oct;
    }

    function getV16dic() {
        return $this->v16dic;
    }

    function getV14abr() {
        return $this->v14abr;
    }

    function getV8dic() {
        return $this->v8dic;
    }

    function getInternasPsuv2015() {
        return $this->internasPsuv2015;
    }

    function getIntOposicion() {
        return $this->intOposicion;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNroPersonal($nroPersonal) {
        $this->nroPersonal = $nroPersonal;
    }

    function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setGerenciaFirst($gerenciaFirst) {
        $this->gerenciaFirst = $gerenciaFirst;
    }

    function setGerenciaSecond($gerenciaSecond) {
        $this->gerenciaSecond = $gerenciaSecond;
    }

    function setUnidadOrganizativa($unidadOrganizativa) {
        $this->unidadOrganizativa = $unidadOrganizativa;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setCodigoMunicipio($codigoMunicipio) {
        $this->codigoMunicipio = $codigoMunicipio;
    }

    function setCodigoParroquia($codigoParroquia) {
        $this->codigoParroquia = $codigoParroquia;
    }

    function setCircusncripcion($circusncripcion) {
        $this->circusncripcion = $circusncripcion;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setCentro($centro) {
        $this->centro = $centro;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setCodigoCentroSimulacro($codigoCentroSimulacro) {
        $this->codigoCentroSimulacro = $codigoCentroSimulacro;
    }

    function setCentroSimulacro($centroSimulacro) {
        $this->centroSimulacro = $centroSimulacro;
    }

    function setDireccionCentroSimulacro($direccionCentroSimulacro) {
        $this->direccionCentroSimulacro = $direccionCentroSimulacro;
    }

    function setCodigoCentro6d($codigoCentro6d) {
        $this->codigoCentro6d = $codigoCentro6d;
    }

    function setCentro6d($centro6d) {
        $this->centro6d = $centro6d;
    }

    function setDireccion6d($direccion6d) {
        $this->direccion6d = $direccion6d;
    }

    function setPsuv($psuv) {
        $this->psuv = $psuv;
    }

    function setV7oct($v7oct) {
        $this->v7oct = $v7oct;
    }

    function setV16dic($v16dic) {
        $this->v16dic = $v16dic;
    }

    function setV14abr($v14abr) {
        $this->v14abr = $v14abr;
    }

    function setV8dic($v8dic) {
        $this->v8dic = $v8dic;
    }

    function setInternasPsuv2015($internasPsuv2015) {
        $this->internasPsuv2015 = $internasPsuv2015;
    }

    function setIntOposicion($intOposicion) {
        $this->intOposicion = $intOposicion;
    }

}
