<?php

namespace Pequiven\MasterBundle\Entity\ArrangementProgram;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de meta (Tipo de actividad)
 *
 * @ORM\Table("seip_c_type_goal")
 * @ORM\Entity
 */
class TypeGoal
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
     * Descripcion
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram")
     */
    private $categoryArrangementProgram;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $active;

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
     * Set description
     *
     * @param string $description
     * @return TypeGoal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categoryArrangementProgram
     *
     * @param integer $categoryArrangementProgram
     * @return TypeGoal
     */
    public function setCategoryArrangementProgram($categoryArrangementProgram)
    {
        $this->categoryArrangementProgram = $categoryArrangementProgram;

        return $this;
    }

    /**
     * Get categoryArrangementProgram
     *
     * @return integer 
     */
    public function getCategoryArrangementProgram()
    {
        return $this->categoryArrangementProgram;
    }
}
