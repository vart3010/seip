<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parroquia
 * @author Maximo Sojo maxsojo13@gmail.com
 * @ORM\Table(name="sip_centro_observations")
 * @ORM\Entity()
 */
class Observations {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer", nullable=true)
     */
    private $codigoCentro;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="string", type="text")
     */
    private $observations;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="integer", nullable=true)
     */
    private $categoria;
    
    
    function getId() {
        return $this->id;
    }   

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }
    
    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }

    function getObservations() {
        return $this->observations;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function getCategoria() {
        return $this->categoria;
    }

}
