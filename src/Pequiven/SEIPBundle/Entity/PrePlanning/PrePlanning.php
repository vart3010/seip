<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\PrePlanning;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\PrePlanning\PrePlanning as Model;
use Tpg\ExtjsBundle\Annotation as Extjs;

/**
 * Entidad para guardar la pre planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * 
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PrePlanning\PrePlanningRepository")
 * @Extjs\Model
 * @Extjs\ModelProxy("/pre-planning/pre-planning")
 */
class PrePlanning extends Model
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Nombre de la planificacion
     * 
     * @var string
     * @ORM\Column(name="name",type="text")
     */
    private $name;

    /**
     *
     * @var PrePlanning
     * 
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning",inversedBy="childrens")
     */
    private $parent;
    
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning",mappedBy="parent",cascade={"persist","remove"})
     */
    private $childrens;

    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Tipo de objeto (O,PG,I)
     * 
     * @var integer
     * @ORM\Column(name="typeObject",type="integer")
     */
    private $typeObject = self::TYPE_OBJECT_ROOT_NODE;
    
    /**
     * Nivel del objeto
     * 
     * @var integer
     * @ORM\Column(name="levelObject",type="integer")
     */
    private $levelObject = self::LEVEL_DEFAULT;
    
    /**
     * Identificador del objeto que se va a planificar
     * 
     * @var integer
     * @ORM\Column(name="idObject",type="integer",nullable=true)
     */
    private $idObject;

    /**
     * Estatus de la plafinicacion
     * 
     * @var integer
     * @ORM\Column(name="status",type="integer")
     */
    private $status = self::STATUS_DRAFT;
    
    /**
     * Usuario dueño del arbol
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $user;
    
    /**
     * Periodo.
     * @var \Pequiven\SEIPBundle\Entity\Period
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     */
    private $period;
    
    /**
     * Parametros de la preplanificacion
     * 
     * @ORM\Column(name="parameters",type="json_array")
     * @var array
     */
    protected $parameters;
    
    /**
     * ¿Requiere aprobacion?
     * 
     * @var boolean
     * @ORM\Column(name="requiresApproval",type="boolean")
     */
    protected $requiresApproval = false;
    
    /**
     * ¿para importar?
     * @var boolean
     * @ORM\Column(name="toImport",type="integer")
     */
    private $toImport = self::TO_IMPORT_DEFAULT;
    
    /**
     * ¿Es editable?
     * @var boolean
     * @ORM\Column(name="editable",type="boolean")
     */
    private $editable = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parameters = array();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PrePlanning
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
     * @return PrePlanning
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
     * @return PrePlanning
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
     * Set typeObject
     *
     * @param integer $typeObject
     * @return PrePlanning
     */
    public function setTypeObject($typeObject)
    {
        $this->typeObject = $typeObject;

        return $this;
    }

    /**
     * Get typeObject
     *
     * @return integer 
     */
    public function getTypeObject()
    {
        return $this->typeObject;
    }

    /**
     * Set idObject
     *
     * @param integer $idObject
     * @return PrePlanning
     */
    public function setIdObject($idObject)
    {
        $this->idObject = $idObject;

        return $this;
    }

    /**
     * Get idObject
     *
     * @return integer 
     */
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return PrePlanning
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $parent
     * @return PrePlanning
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return PrePlanning
     */
    public function setUser(\Pequiven\SEIPBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return PrePlanning
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period = null)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return PrePlanning
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add childrens
     *
     * @param \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $childrens
     * @return PrePlanning
     */
    public function addChildren(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $childrens)
    {
        $childrens->setParent($this);
        
        $this->childrens->add($childrens);

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $childrens
     */
    public function removeChildren(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     * @return PrePlanning
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set requiresApproval
     *
     * @param boolean $requiresApproval
     * @return PrePlanning
     */
    public function setRequiresApproval($requiresApproval)
    {
        $this->requiresApproval = $requiresApproval;

        return $this;
    }

    /**
     * Get requiresApproval
     *
     * @return boolean 
     */
    public function getRequiresApproval()
    {
        return $this->requiresApproval;
    }
    
    /**
     * Is requiresApproval
     *
     * @return boolean 
     */
    public function isRequiresApproval()
    {
        return $this->getRequiresApproval();
    }
    
    function getLevelObject() 
    {
        return $this->levelObject;
    }

    function setLevelObject($levelObject) 
    {
        $this->levelObject = $levelObject;
        
        return $this;
    }
    
    function getToImport() {
        return $this->toImport;
    }

    function setToImport($toImport) {
        $this->toImport = $toImport;
        
        return $this;
    }
    function isEditable()
    {
        return $this->editable;
    }

    function setEditable($editable) {
        $this->editable = $editable;
        
        return $this;
    }

}
