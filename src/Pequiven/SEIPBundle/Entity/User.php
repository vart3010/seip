<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Pequiven\MasterBundle\Entity\Rol;

/**
 * User model
 *
 * @author Carlos Mendoza <inhack20@tecnocreaciones.com>
 * 
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\UserRepository")
 * @ORM\Table(name="seip_user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=false)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=false)),
 * })
 * @ORM\HasLifecycleCallbacks
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
     *@ORM\Column(name="num_personal",type="integer",nullable=true)
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
     * Dirección
     * @var \Pequiven\MasterBundle\Entity\Direction
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Direction")
     * @ORM\JoinColumn(name="fk_direction", referencedColumnName="id")
     */
    private $direction;
    
    /** 
     * Complejo
     * 
     * @var \Pequiven\MasterBundle\Entity\Complejo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Complejo")
     * @ORM\JoinColumn(name="fk_complejo", referencedColumnName="id")
     */
    private $complejo;
    
    /**
     * Gerencia
     * 
     * @var \Pequiven\MasterBundle\Entity\Gerencia
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Gerencia")
     * @ORM\JoinColumn(name="fk_gerencia", referencedColumnName="id")
     */
    private $gerencia;
    
    /**
     * GerenciaSecond
     * 
     * @var \Pequiven\MasterBundle\Entity\GerenciaSecond
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\GerenciaSecond")
     * @ORM\JoinColumn(name="fk_gerencia_second", referencedColumnName="id")
     */
    private $gerenciaSecond;
    
    /**
     * Cargo
     * 
     * @var \Pequiven\MasterBundle\Entity\Cargo
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Cargo")
     * @ORM\JoinColumn(name="fk_cargo", referencedColumnName="id")
     */
    private $cargo;
    
    /**
     * @var \Pequiven\MasterBundle\Entity\Rol
     * @ORM\ManyToMany(targetEntity="Pequiven\MasterBundle\Entity\Rol")
     * @ORM\JoinTable(name="fos_user_user_rol",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * Programas de gestion
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
     * @ORM\ManyToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram",mappedBy="responsibles")
     */
    protected $arrangementPrograms;

    /**
     * Metas
     * 
     * @var \Pequiven\ArrangementProgramBundle\Entity\Goal
     * @ORM\ManyToMany(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Goal",mappedBy="responsibles")
     */
    private $goals;
    
    /**
     * Supervisores
     * @var User
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="supervised")
     */
    private $supervisors;
    
    /**
     * Supervisados
     * @var User
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="supervisors")
     * @ORM\JoinTable(name="user_supervised",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="supervised_user_id", referencedColumnName="id")}
     *      )
     */
    private $supervised;
    
    /**
     * Configuracion del usuario
     * 
     * @var \Pequiven\SEIPBundle\Entity\User\Configuration
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\User\Configuration",inversedBy="user",cascade={"persist","remove"})
     */
    private $configuration;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->goals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->arrangementPrograms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supervisors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supervised = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
    
    /**
     * Set direction
     *
     * @param \Pequiven\MasterBundle\Entity\Direction $direction
     * @return Gerencia
     */
    public function setDirection(\Pequiven\MasterBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Pequiven\MasterBundle\Entity\Direction 
     */
    public function getDirection()
    {
        return $this->direction;
    }
    
    public function __toString() {
        return sprintf("%s %s (%s)",$this->getFirstName(),$this->getLastName(),$this->getNumPersonal());
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add goals
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Goal $goals
     * @return User
     */
    public function addGoal(\Pequiven\ArrangementProgramBundle\Entity\Goal $goals)
    {
        $this->goals[] = $goals;

        return $this;
    }

    /**
     * Remove goals
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\Goal $goals
     */
    public function removeGoal(\Pequiven\ArrangementProgramBundle\Entity\Goal $goals)
    {
        $this->goals->removeElement($goals);
    }

    /**
     * Get goals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGoals()
    {
        return $this->goals;
    }
    /**
     * Devuelve el nivel del rol asignado
     * @return integer
     */
    public function getLevelByGroup()
    {
        if(!isset($this->levelByGroup)){
            $level = 0;
            $groups = $this->getGroups();
            foreach ($groups as $group) {
                if($group->getLevel() > $level){
                    $level = $group->getLevel();
                }
            }
            $this->levelByGroup = $level;
        }
        return $this->levelByGroup;
    }
    
    /**
     * Devuelve el nivel real del rol asignado, nunca devuelve rol auxiliar
     * 
     * @return integer
     */
    public function getLevelRealByGroup(){
        if(!isset($this->levelRealByGroup)){
            $this->levelRealByGroup = Rol::getRoleLevel($this->getLevelByGroup());
        }
        return $this->levelRealByGroup;
    }
    
    public function getFullNameUser(){
        return $this->firstname . ' '.$this->lastname. ' ('.$this->numPersonal.' | '.$this->username.')';
    }
    
    /**
     * Add supervisors
     *
     * @param \Pequiven\SEIPBundle\Entity\User $supervisors
     * @return User
     */
    public function addSupervisor(\Pequiven\SEIPBundle\Entity\User $supervisors)
    {
        $this->supervisors->add($supervisors);

        return $this;
    }

    /**
     * Remove supervisors
     *
     * @param \Pequiven\SEIPBundle\Entity\User $supervisors
     */
    public function removeSupervisor(\Pequiven\SEIPBundle\Entity\User $supervisors)
    {
        $this->supervisors->removeElement($supervisors);
    }

    /**
     * Get supervisors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupervisors()
    {
        return $this->supervisors;
    }

    /**
     * Add supervised
     *
     * @param \Pequiven\SEIPBundle\Entity\User $supervised
     * @return User
     */
    public function addSupervised(\Pequiven\SEIPBundle\Entity\User $supervised)
    {
        $this->supervised->add($supervised);

        return $this;
    }

    /**
     * Remove supervised
     *
     * @param \Pequiven\SEIPBundle\Entity\User $supervised
     */
    public function removeSupervised(\Pequiven\SEIPBundle\Entity\User $supervised)
    {
        $this->supervised->removeElement($supervised);
    }

    /**
     * Get supervised
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupervised()
    {
        return $this->supervised;
    }
    
    /**
     * Add arrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementPrograms
     * @return User
     */
    public function addArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementPrograms)
    {
        $this->arrangementPrograms->add($arrangementPrograms);

        return $this;
    }

    /**
     * Remove arrangementPrograms
     *
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementPrograms
     */
    public function removeArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementPrograms)
    {
        $this->arrangementPrograms->removeElement($arrangementPrograms);
    }

    /**
     * Get arrangementPrograms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArrangementPrograms()
    {
        return $this->arrangementPrograms;
    }

    /**
     * Set configuration
     *
     * @param \Pequiven\SEIPBundle\Entity\User\Configuration $configuration
     * @return User
     */
    public function setConfiguration(\Pequiven\SEIPBundle\Entity\User\Configuration $configuration = null)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Pequiven\SEIPBundle\Entity\User\Configuration 
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}