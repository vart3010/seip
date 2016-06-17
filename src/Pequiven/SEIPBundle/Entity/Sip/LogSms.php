<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Victor Tortolero vart10.30@gmail.com
 * log de sms
 *
 * @ORM\Table(name="sip_log_sms")
 * @ORM\Entity()
 */
class LogSms {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * cedula
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=255, nullable=true)
     */
    private $cedula;

    /**
     * A = ASISTENCIA , V=VOTO , M= REPORTE DE MESA
     * tipo
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=2, nullable=true)
     */
    private $tipo;

    /**
     * codigo centro
     * @var string
     *
     * @ORM\Column(name="codigoCentro", type="string", length=255, nullable=true)
     */
    private $codigoCentro;

    /**
     * mesa
     * @var string
     *
     * @ORM\Column(name="mesa", type="string", nullable=true)
     */
    private $mesa;

    /**
     * mensaje
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=255)
     */
    private $mensaje;

    /**
     * categoria
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * status
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * obs
     * @var string
     *
     * @ORM\Column(name="obs", type="string", length=255, nullable=true)
     */
    private $obs;

    /**
     * resp
     * @var string
     *
     * @ORM\Column(name="resp", type="string", length=255, nullable=true)
     */
    private $resp;
    
     /**
     * fecha 
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;
    
    /**
     * telefono
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;
    
    function getId() {
        return $this->id;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getMesa() {
        return $this->mesa;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getStatus() {
        return $this->status;
    }

    function getObs() {
        return $this->obs;
    }

    function getResp() {
        return $this->resp;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setMesa($mesa) {
        $this->mesa = $mesa;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setResp($resp) {
        $this->resp = $resp;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }




}
