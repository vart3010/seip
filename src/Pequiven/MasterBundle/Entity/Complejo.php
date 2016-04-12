<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Complejo as modelComplejo;

/**
 * Localidad
 *
 * @ORM\Table(name="seip_c_complejo")
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\ComplejoRepository")
 */
class Complejo extends modelComplejo {

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
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=50)
     */
    private $ref;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * Localidad
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\OneToMany(targetEntity="Pequiven\MasterBundle\Entity\Gerencia",mappedBy="complejo")
     */
    private $gerencias;

    /**
     * @var \Pequiven\SEIPBundle\Entity\User\FeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User\FeeStructure", mappedBy="complejo",cascade={"persist","remove"})
     */
    private $feeStructure;
    
    /**
     * Cantidad de Miembros de los CET en el complejo
     * @var integer
     *
     * @ORM\Column(name="numberMembersCET", type="integer", nullable=true)
     */
    private $numberMembersCET = 0;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Complejo
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
     * @return Complejo
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
     * Set description
     *
     * @param string $description
     * @return Complejo
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Complejo
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Complejo
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null) {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt() {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Complejo
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null) {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt() {
        return $this->userUpdatedAt;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Complejo
     */
    public function setRef($ref) {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef() {
        return $this->ref;
    }

    public function __toString() {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->gerencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add gerencias
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencias
     * @return Complejo
     */
    public function addGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencias) {
        $this->gerencias[] = $gerencias;

        return $this;
    }

    /**
     * Remove gerencias
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencias
     */
    public function removeGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencias) {
        $this->gerencias->removeElement($gerencias);
    }

    /**
     * Get gerencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGerencias() {
        return $this->gerencias;
    }

    function getFeeStructure() {
        return $this->feeStructure;
    }

    function setFeeStructure(\Pequiven\SEIPBundle\Entity\User\FeeStructure $feeStructure) {
        $this->feeStructure = $feeStructure;
    }
    
    function getNumberMembersCET() {
        return $this->numberMembersCET;
    }

    function setNumberMembersCET($numberMembersCET) {
        $this->numberMembersCET = $numberMembersCET;
    }

}
