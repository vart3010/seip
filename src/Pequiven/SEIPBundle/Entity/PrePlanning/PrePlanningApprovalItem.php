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

/**
 * Aprobacion de item de pre planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PrePlanning\PrePlanningApprovalItemRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class PrePlanningApprovalItem implements \Pequiven\SEIPBundle\Model\PrePlanning\TypePrePlanningInterface
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
     * Usuario que creo esta aprobacion
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $user;
    
    /**
     * Tipo de objeto (O,PG,I)
     * 
     * @var integer
     * @ORM\Column(name="typeObject",type="integer")
     */
    private $typeObject;
    
    /**
     * Identificador del objeto que se va a planificar
     * 
     * @var integer
     * @ORM\Column(name="idObject",type="integer",nullable=true)
     */
    private $idObject;
    
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
     * Fecha de eliminacion
     * 
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * Get typeObject
     *
     * @return integer 
     */
    public function getTypeObject()
    {
        return $this->typeObject;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PrePlanningApprovalItem
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
     * @return PrePlanningApprovalItem
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
     * @return PrePlanningApprovalItem
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
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return PrePlanningApprovalItem
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
    
    function setTypeObject($typeObject) 
    {
        $this->typeObject = $typeObject;
        
        return $this;
    }

    function setIdObject($idObject) 
    {
        $this->idObject = $idObject;
        
        return $this;
    }
}
