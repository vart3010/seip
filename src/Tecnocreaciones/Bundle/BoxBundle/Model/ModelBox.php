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
     * @var string
     *
     * @ORM\Column(name="area", type="string",length=200)
     */
    protected $areaName;
    
    /**
     * Orden del box
     * @var integer
     * @ORM\Column(name="orderBox",type="integer")
     */
    protected $orderBox;
    
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
     * Set orderBox
     *
     * @param integer $orderBox
     * @return Box
     */
    public function setBoxOrder($orderBox)
    {
        $this->orderBox = $orderBox;

        return $this;
    }

    /**
     * Get orderBox
     *
     * @return integer 
     */
    public function getBoxOrder()
    {
        return $this->orderBox;
    }
    
    /**
     * Set areaName
     *
     * @param string $areaName
     * @return Box
     */
    public function setAreaName($areaName)
    {
        $this->areaName = $areaName;

        return $this;
    }

    /**
     * Get areaName
     *
     * @return string 
     */
    public function getAreaName()
    {
        return $this->areaName;
    }
}
