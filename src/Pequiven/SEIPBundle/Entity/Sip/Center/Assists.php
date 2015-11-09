<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parroquia
 * @author Maximo Sojo maxsojo13@gmail.com
 * @ORM\Table(name="sip_centro_assists")
 * @ORM\Entity()
 */
class Assists {

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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="cedula", type="integer", nullable=true)
     */
    private $cedula;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer", nullable=true)
     */
    private $codigoCentro;
    
    
    function getId() {
        return $this->id;
    }   

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function getCedula() {
        return $this->cedula;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }
    
    function getCodigoCentro() {
        return $this->codigoCentro;
    }


}
