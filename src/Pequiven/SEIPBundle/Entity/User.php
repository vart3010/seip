<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User model
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 * @ORM\Entity()
 * @ORM\Table(name="seip_user")
 */
class User extends BaseUser implements \Tecnocreaciones\Vzla\GovernmentBundle\Model\UserInterface
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var type 
     */
    protected $id;
    
    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime",nullable=true)
     */
    private $createdAt;
    
    /**
     * Date update
     * 
     * @var type 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at",type="datetime",nullable=true)
     */
    private $updatedAt;
    
    /**
     * @ORM\Column(name="first_name",type="string",length=100,nullable=true)
     * @var type 
     */
    private $firstName;
    
    /**
     * @ORM\Column(name="last_name",type="string",length=100,nullable=true)
     * @var type 
     */
    private $lastName;
    
    /**
     *@ORM\Column(name="num_personal",type="integer",nullable=true)
     * @var type 
     */
    private $numPersonal;
    
    /**
     * @var string
     */
    protected $username;
    
    /**
     * @ORM\OneToMany(targetEntity="\Pequiven\SEIPBundle\Entity\User", mappedBy="parent")
     */
    private $children;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;
    
    /** 
     * Complejo
     * @var=\Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;
    
    /**
     * Gerencia
     * @var=\Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     * GerenciaSecond
     * @var=\Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond")
     * @ORM\JoinColumn(name="fk_gerencia_second", referencedColumnName="id")
     */
    private $gerenciaSecond;
    
    /**
     * Cargo
     * @var \Pequiven\MasterBundle\Entity\Cargo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Cargo")
     * @ORM\JoinColumn(name="fk_cargo", referencedColumnName="id")
     */
    private $cargo;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return User
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

    /**
     * Add groups
     *
     * @param \Coramer\Sigtec\CoreBundle\Entity\Group $groups
     * @return User
     */
    public function addGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Coramer\Sigtec\CoreBundle\Entity\Group $groups
     */
    public function removeGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Set numPersonal
     *
     * @param integer $numPersonal
     * @return User
     */
    public function setNumPersonal($numPersonal)
    {
        $this->numPersonal = $numPersonal;

        return $this;
    }

    /**
     * Get numPersonal
     *
     * @return integer
     */
    public function getNumPersonal()
    {
        return $this->numPersonal;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \Pequiven\SEIPBundle\Entity\User $children
     * @return User
     */
    public function addChild(\Pequiven\SEIPBundle\Entity\User $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Pequiven\SEIPBundle\Entity\User $children
     */
    public function removeChild(\Pequiven\SEIPBundle\Entity\User $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\User $parent
     * @return User
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set Complejo
     *
     * @param \Pequiven\MasterBundle\Entity\Complejo $complejo
     * @return User
     */
    public function setComplejo(\Pequiven\MasterBundle\Entity\Complejo $complejo = null)
    {
        $this->complejo = $complejo;

        return $this;
    }

    /**
     * Get Complejo
     *
     * @return \Pequiven\MasterBundle\Entity\Complejo 
     */
    public function getComplejo()
    {
        return $this->complejo;
    }

    /**
     * Set Gerencia
     *
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return User
     */
    public function setGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia = null)
    {
        $this->gerencia = $gerencia;

        return $this;
    }

    /**
     * Get Gerencia
     *
     * @return \Pequiven\MasterBundle\Entity\Gerencia 
     */
    public function getGerencia()
    {
        return $this->gerencia;
    }

    /**
     * Set Cargo
     *
     * @param \Pequiven\MasterBundle\Entity\Cargo $cargo
     * @return User
     */
    public function setCargo(\Pequiven\MasterBundle\Entity\Cargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get Cargo
     *
     * @return \Pequiven\MasterBundle\Entity\Cargo 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set gerenciaSecond
     *
     * @param \Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond
     * @return User
     */
    public function setGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond = null)
    {
        $this->gerenciaSecond = $gerenciaSecond;

        return $this;
    }

    /**
     * Get gerenciaSecond
     *
     * @return \Pequiven\MasterBundle\Entity\GerenciaSecond 
     */
    public function getGerenciaSecond()
    {
        return $this->gerenciaSecond;
    }
}
