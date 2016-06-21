<?php

namespace Pequiven\SEIPBundle\Entity\Sip;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Sip\OnePerTenFile as Model;

/**
 * Archivos de meeting
 * @author Matías Jiménez matei249@gmail.com
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\Sip\OnePerTenFileRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class OnePerTenFile extends Model {

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
     * @var \Pequiven\SEIPBundle\Entity\Sip\OnePerTen
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Sip\OnePerTen",inversedBy="onePerTenFile")
     */
    private $onePerTen;

    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\SEIPBundle\Entity\Politic\CategoryFile", inversedBy="onePerTenFile")
     */
    private $categoryFile;

    public function __construct() {
        $this->categoryFile = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\CategoryFile $categoryFile
     * @return \Pequiven\SEIPBundle\Entity\Sip\OnePerTenFile
     */
    public function addCategoryFile(CategoryFile $categoryFile) {
        $this->categoryFile->add($categoryFile);
        return $this;
    }
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Politic\CategoryFile $categoryFile
     */
    public function removeCategoryFile(CategoryFile $categoryFile) {
        $this->categoryFile->removeElement($categoryFile);
    }
    /**
     * 
     * @return type
     */
    public function getCategoryFile() {
        return $this->categoryFile;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param type $nameFile
     * @return type
     */
    public function setNameFile($nameFile) {
        $nameFile = base64_encode($nameFile);
        $this->nameFile = $nameFile;
        return $nameFile;
    }

    /**
     * 
     * @return type
     */
    public function getNameFile() {
        return base64_decode($this->nameFile);
    }

    /**
     * 
     * @param type $extensionFile
     * @return type
     */
    public function setExtensionFile($extensionFile) {
        $this->extensionFile = $extensionFile;
        return $extensionFile;
    }

    /**
     * 
     * @return type
     */
    public function getExtensionFile() {
        return $this->extensionFile;
    }

    /**
     * 
     * @param type $path
     * @return type
     */
    public function setPath($path) {
        $this->path = $path;
        return $path;
    }

    /**
     * 
     * @return type
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IndicatorSimpleValue
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return IndicatorSimpleValue
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return OnePerTenFile
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $updatedBy
     * @return OnePerTenFile
     */
    public function setUpdatedBy(\Pequiven\SEIPBundle\Entity\User $updatedBy = null) {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function __toString() {
        return $this->getNameFile();
    }
    
    function getOnePerTen() {
        return $this->onePerTen;
    }

    function setOnePerTen(\Pequiven\SEIPBundle\Entity\Sip\OnePerTen $onePerTen) {
        $this->onePerTen = $onePerTen;
    }

}
