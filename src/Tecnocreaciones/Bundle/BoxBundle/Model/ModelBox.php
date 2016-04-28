<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Definicion de un box o widget
 *
 * @author inhack20
 * @ORM\MappedSuperclass()
 */
abstract class ModelBox implements ModelBoxInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="boxName", type="string",length=200)
     */
    protected $boxName;
    
    /**
     * @var array
     *
     * @ORM\Column(name="areas", type="json_array")
     */
    protected $areas;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    protected $locked = false;

    /**
     * Set name
     *
     * @param string $name
     * @return Box
     */
    public function setBoxName($boxName)
    {
        $this->boxName = $boxName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getBoxName()
    {
        return $this->boxName;
    }

    /**
     * Set areas
     *
     * @param string $areas
     * @return Box
     */
    public function setAreas($areas)
    {
        $this->areas = $areas;

        return $this;
    }

    /**
     * Get areas
     *
     * @return string 
     */
    public function getAreas()
    {
        return $this->areas;
    }
    
    function isLocked() {
        return $this->locked;
    }

    function setLocked($locked) {
        $this->locked = $locked;
    }
}
