<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Parroquia
 * @author Maximo Sojo maxsojo13@gmail.com
 * @ORM\Table(name="sip_centro_inventory")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Inventory {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Date
     * 
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer")
     */
    private $codigoCentro;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="string", type="text", nullable=true)
     */
    private $observations;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\Sip\Center\Material", inversedBy="inventory")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    private $material;

    /**
     * @var string
     *
     * @ORM\Column(name="centro", type="text",nullable=true)
     */
    private $centro;

    /**
     * municipio
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * parroquia
     * @var string
     *
     * @ORM\Column(name="parroquia", type="string", length=255, nullable=true)
     */
    private $parroquia;

    /**
     * estado
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    
    
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

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setCentro($centro) {
        $this->centro = $centro;
    }

    function getCentro() {
        return $this->centro;
    }

    function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    function setParroquia($parroquia) {
        $this->parroquia = $parroquia;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function getParroquia() {
        return $this->parroquia;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    function getEstado() {
        return $this->estado;
    }

    /**
     * Set material
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\Material $material
     */
    public function setMaterial(\Pequiven\SEIPBundle\Entity\Sip\Center\Material $material) {        
        $this->material = $material;
        return $this;
    }

    /**
     * Get material
     *
     * @return Pequiven\SEIPBundle\Entity\Sip\Center\Material
     */
    public function getMaterial() {
        return $this->material;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return material
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

}
