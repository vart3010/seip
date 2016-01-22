<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\SupplyCenter as Model;

/**
 * Centro de Acopio
 *
 * @author Victor Tortolero <vart10..30@gmail.com>
 * @ORM\Table(name="seip_cei_SupplyCenter")
 * @ORM\Entity()
 */
class SupplyCenter extends Model {  

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Nombre del centro
     * @var String 
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;

    /**
     * alias de centro 
     * @var String 
     * @ORM\Column(name="alias",type="string",nullable=true)
     */
    private $alias;

    /**
     * codigo ("sap") 
     * @var String 
     * @ORM\Column(name="codigo",type="string",nullable=true)
     */
    private $codigo;

    /**
     * clasificacion
     * @var String 
     * @ORM\Column(name="clasificacion",type="string",nullable=true)
     */
    private $clasificacion = null;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getAlias() {
        return $this->alias;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getClasificacion() {
        return $this->clasificacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

}
