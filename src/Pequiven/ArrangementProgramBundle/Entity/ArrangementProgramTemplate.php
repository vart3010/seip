<?php

namespace Pequiven\ArrangementProgramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\ArrangementProgramBundle\Model\ArrangementProgram as Model;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Plantilla del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramTemplateRepository")
 */
class ArrangementProgramTemplate extends Model
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
     * @ORM\Column(name="description",type="string",length=200)
     * @var string
     */
    private $description;

    /**
     * Creado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Linea de tiempo
     * @var \Pequiven\ArrangementProgramBundle\Entity\Timeline
     *
     * @ORM\OneToOne(targetEntity="Pequiven\ArrangementProgramBundle\Entity\Timeline",inversedBy="arrangementProgramTemplate",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $timeline;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    function getCreatedBy() {
        return $this->createdBy;
    }

    function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;
        return $this;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ArrangementProgram
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
     * @return ArrangementProgram
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
     * 
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param type $description
     * @return \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate
     */
    function setDescription($description) {
        $this->description = $description;
        
        return $this;
    }

}
