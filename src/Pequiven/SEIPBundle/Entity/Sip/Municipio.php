<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Victor Tortolero vart10.30@gmail.com
 * Municipio
 *
 * @ORM\Table(name="sip_municipio")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\MunicipioRepository")
 */
class Municipio {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoMunicipio", type="integer")
     * @ORM\Id
     */
    private $codigoMunicipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoEstado", type="integer")
     */
    private $codigoEstado;

    /**
     * Nombre de Estado
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    function getId() {
        return $this->id;
    }

    function getCodigoMunicipio() {
        return $this->codigoMunicipio;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getCodigoParroquia() {
        return $this->codigoParroquia;
    }

    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoMunicipio($codigoMunicipio) {
        $this->codigoMunicipio = $codigoMunicipio;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setCodigoParroquia($codigoParroquia) {
        $this->codigoParroquia = $codigoParroquia;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
