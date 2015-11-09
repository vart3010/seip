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
     * @var integer
     *
     * @ORM\Column(name="codigoEstado", type="integer")
     */
    private $codigoEstado;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoMunicipio", type="integer")
     */
    private $codigoMunicipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoParroquia",type="integer")
     */
    private $codigoParroquia;

    /**
     * Codigo de Centro
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
    
    function getId() {
        return $this->id;
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

    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
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

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function setDescription($description) {
        $this->description = $description;
    }



}
