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
 * Box o widget para usuarios
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface UserBoxInterface 
{
    function addModelBox(ModelBoxInterface $boxes);
    
    public function removeModelBox(ModelBoxInterface $boxes);
    
    /**
     * @return ModelBoxInterface Description
     */
    public function getModelBoxes();
}
