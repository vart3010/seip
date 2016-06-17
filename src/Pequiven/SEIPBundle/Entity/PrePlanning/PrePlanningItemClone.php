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
use Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningItemClone as Model;

/**
 * Item clonado
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="entity_idx", columns={"typeObject", "period_id","idSourceObject"})})
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PrePlanning\PrePlanningItemCloneRepository")
 */
class PrePlanningItemClone extends Model
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
     * Tipo de objeto (Cualquier objeto importado)
     * 
     * @var integer
     * @ORM\Column(name="typeObject",type="integer")
     */
    private $typeObject;
    
    /**
     * Identificador del objeto que se va a planificar
     * 
     * @var integer
     * @ORM\Column(name="idCloneObject",type="integer",nullable=false)
     */
    private $idCloneObject;
    
    /**
     * Identificador del objeto que se va a planificar
     * 
     * @var integer
     * @ORM\Column(name="idSourceObject",type="integer",nullable=false)
     */
    private $idSourceObject;
    
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
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    
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
     * Set typeObject
     *
     * @param integer $typeObject
     * @return PrePlanningItemClone
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
     * Set idCloneObject
     *
     * @param integer $idCloneObject
     * @return PrePlanningItemClone
     */
    public function setIdCloneObject($idCloneObject)
    {
        $this->idCloneObject = $idCloneObject;

        return $this;
    }

    /**
     * Get idCloneObject
     *
     * @return integer 
     */
    public function getIdCloneObject()
    {
        return $this->idCloneObject;
    }

    /**
     * Set idSourceObject
     *
     * @param integer $idSourceObject
     * @return PrePlanningItemClone
     */
    public function setIdSourceObject($idSourceObject)
    {
        $this->idSourceObject = $idSourceObject;

        return $this;
    }

    /**
     * Get idSourceObject
     *
     * @return integer 
     */
    public function getIdSourceObject()
    {
        return $this->idSourceObject;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PrePlanningItemClone
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
     * @return PrePlanningItemClone
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
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return PrePlanningItemClone
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
     * @return PrePlanningItemClone
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
}
