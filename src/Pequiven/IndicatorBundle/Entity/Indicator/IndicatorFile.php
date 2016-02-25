<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\IndicatorFile as Model;

/**
 * indicator file
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_indicator_file")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class IndicatorFile extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameFile", type="string", length=255, nullable=true)
     */
    private $nameFile;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nameFileOriginal", type="string", length=255, nullable=true)
     */
    private $nameFileOriginal;

    /**
     * @var string
     *
     * @ORM\Column(name="extensionFile", type="string", length=5, nullable=true)
     */
    private $extensionFile;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text", nullable=true)
     */
    private $path;

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
     * Usuario que subio la ficha
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * * Usuario que actualizo la ficha
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     */
    private $updatedBy;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * User que lo actualizo
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="indicatorFiles")
     * @ORM\JoinColumn(name="fk_indicator_file", referencedColumnName="id")
     */
    private $indicator;

    /**
     * Constructor
     */
    public function __construct() {

        $this->indicator = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getNameFile() {
        return $this->nameFile;
    }

    function getExtensionFile() {
        return $this->extensionFile;
    }

    function getPath() {
        return $this->path;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getUpdatedBy() {
        return $this->updatedBy;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNameFile($nameFile) {
        $this->nameFile = $nameFile;
    }

    function setExtensionFile($extensionFile) {
        $this->extensionFile = $extensionFile;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
    }

    function setUpdatedBy(\Pequiven\SEIPBundle\Entity\User $updatedBy) {
        $this->updatedBy = $updatedBy;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    /**
     * 
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorFile
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator) {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getIndicator() {
        return $this->indicator;
    }

    function getNameFileOriginal() {
        return $this->nameFileOriginal;
    }

    function setNameFileOriginal($nameFileOriginal) {
        $this->nameFileOriginal = $nameFileOriginal;
    }

    function getEnabled() {
        return $this->enabled;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
