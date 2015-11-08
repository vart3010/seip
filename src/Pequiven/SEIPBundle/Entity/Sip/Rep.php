<?php

namespace Pequiven\SEIPBundle\Sip\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Rep
 *
 * @ORM\Table(name="sip_rep")
 * @ORM\Entity()
 */
class Rep {

    /**
     * @var integer
     *
     * @ORM\Column(name="idcedula", type="integer")
     * @ORM\Id
     */
    private $idCedula;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidad", type="string",length=255)
     */
    private $nacionalidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer")
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_nac", type="string")
     */
    private $fechaNac;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="psuv", type="string")
     */
    private $psuv;

    /**
     * @var interger
     *
     * @ORM\Column(name="codigoEstado", type="integer")
     */
    private $codigoEstado;

    /**
     * @var interger
     *
     * @ORM\Column(name="codigoMunicipio", type="integer")
     */
    private $codigoMunicipio;

    /**
     * @var interger
     *
     * @ORM\Column(name="codigoParroquia", type="integer")
     */
    private $codigoParroquia;

    /**
     * @var interger
     *
     * @ORM\Column(name="circuito", type="integer")
     */
    private $circuito;

    /**
     * @var interger
     *
     * @ORM\Column(name="codigoCentro", type="integer")
     */
    private $codigoCentro;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="mesa", type="string")
     */
    private $mesa;

    function getIdCedula() {
        return $this->idCedula;
    }

    function getNacionalidad() {
        return $this->nacionalidad;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getFechaNac() {
        return $this->fechaNac;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getPsuv() {
        return $this->psuv;
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

    function getCircuito() {
        return $this->circuito;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getMesa() {
        return $this->mesa;
    }

    function setIdCedula($idCedula) {
        $this->idCedula = $idCedula;
    }

    function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setPsuv($psuv) {
        $this->psuv = $psuv;
    }

    function setCodigoEstado(interger $codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setCodigoMunicipio(interger $codigoMunicipio) {
        $this->codigoMunicipio = $codigoMunicipio;
    }

    function setCodigoParroquia(interger $codigoParroquia) {
        $this->codigoParroquia = $codigoParroquia;
    }

    function setCircuito(interger $circuito) {
        $this->circuito = $circuito;
    }

    function setCodigoCentro(interger $codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setMesa($mesa) {
        $this->mesa = $mesa;
    }

}
