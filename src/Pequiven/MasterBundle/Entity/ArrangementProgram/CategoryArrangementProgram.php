<?php

namespace Pequiven\MasterBundle\Entity\ArrangementProgram;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\ArrangementProgram\CategoryArrangementProgram as modelCategoryArrangementProgram;

/**
 * Categoria del programa de gestion
 *
 * @ORM\Table("seip_c_category_arrangement_program")
 * @ORM\Entity(repositoryClass="Pequiven\MasterBundle\Repository\ArrangementProgram\CategoryArrangementProgram")
 * @ORM\Entity
 */
class CategoryArrangementProgram extends modelCategoryArrangementProgram
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;


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
     * @return CategoryArrangementProgram
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

    function getActive() {
        return $this->active;
    }

    function setActive($active) {
        $this->active = $active;
        return $this;
    }
    
    public function __toString() {
        return $this->description;
    }
}
