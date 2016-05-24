<?php

namespace Pequiven\IndicatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Entity\Indicator;

/**
 * Grupos de Indicadores
 *
 * @ORM\Table(name="seip_indicator_group")
 * @ORM\Entity
 * @author Gilbert <glavrjk@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false) 
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\IndicatorGroupRepository") 
 */
class IndicatorGroup {

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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * @var string
     * @ORM\Column(name="codigo", type="string", length=100, nullable=true)
     */
    private $codigo;

    /**
     * Nombre
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * Nombre
     * @var string
     * @ORM\Column(name="logo", type="string", nullable=true)
     */
    private $logo;

    /**
     * Nombre
     * @var string
     * @ORM\Column(name="color", type="string", nullable=true)
     */
    private $color;

    /**
     * Grupo al Que Pertenece     
     * @var IndicatorGroup
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\IndicatorGroup",inversedBy="childrens",cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", nullable=true)
     */
    protected $parent = null;

    /**
     * @var IndicatorGroup
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\IndicatorGroup",mappedBy="parent",cascade={"persist"}))
     */
    protected $childrens;

    /**
     * @var Indicator     
     * @ORM\ManyToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="indicatorGroup")     
     */
    private $indicators;

    public function __toString() {
        return $this->description;
    }

    public function __construct() {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescription() {
        return $this->description;
    }

    function getParent() {
        return $this->parent;
    }

    function getChildrens() {
        return $this->childrens;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setParent(IndicatorGroup $parent) {
        $this->parent = $parent;
    }

    function setChildrens(IndicatorGroup $childrens) {
        $this->childrens = $childrens;
    }

    function getLogo() {
        return $this->logo;
    }

    function getColor() {
        return $this->color;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function setColor($color) {
        $this->color = $color;
    }

    public function addIndicator(Indicator $indicators) {
        $this->indicators[] = $indicators;
        return $this;
    }

    public function removeIndicator(Indicator $indicators) {
        $this->indicators->removeElement($indicators);
    }

    public function getIndicators() {
        return $this->indicators;
    }

}
