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

/**
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface ModelBoxInterface 
{
    public function setBoxName($name);
    
    public function getBoxName();
    
    public function setBoxOrder($orderBox);
    
    public function getBoxOrder();
    
    public function setAreaName($areaName);
    
    public function getAreaName();
}
