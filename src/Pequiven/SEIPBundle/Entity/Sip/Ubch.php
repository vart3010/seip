<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Sip\Center\Ubch as modelUbch;

/**
 * ubch
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="sip_ubch")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Ubch extends modelUbch{

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
     * @ORM\Column(name="cedula", type="string", length=12, nullable=true)
     */
    private $cedula;

    /**
     * nombre 
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * telefono
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=12, nullable=true)
     */
    private $telefono;

    /**
     * cod_centro
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer", nullable=true)
     */
    private $codigoCentro;

    /**
     * cargo
     * @var integer
     *
     * @ORM\Column(name="cargo", type="integer", nullable=true)
     */
    private $cargo = 2;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * observations
     * @var string
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;

    /**
     * notification
     * @var integer
     *
     * @ORM\Column(name="notification", type="integer")
     */
    private $notification = 0;

    function getId() {
        return $this->id;
    }

    function getCedula() {
        return $this->cedula;
    }
    
    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getTelefono() {
        return $this->telefono;
    }
    
    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function getCodigoCentro() {
        return $this->codigoCentro;
    }
    
    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }

    function getCargo() {
        return $this->cargo;
    }
    
    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function getNotification() {
        return $this->notification;
    }
    
    function setNotification($notification) {
        $this->notification = $notification;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }
    
    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }
    
    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function getObservations() {
        return $this->observations;
    }
    
    function setObservations($observations) {
        $this->observations = $observations;
    }

}
