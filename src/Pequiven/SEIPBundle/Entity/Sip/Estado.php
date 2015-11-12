<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 * @author Victor Tortolero vart10.30@gmail.com
 * @ORM\Table(name="sip_estado")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\EstadoRepository")
 */
class Estado {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;
    
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

    function setId($id) {
        $this->id = $id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescription() {
        return $this->description;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
