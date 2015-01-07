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
 * Box fijo o manual
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BoxStaticLocked extends ModelBox
{
    protected $locked = true;
    
    public function __construct() {
        $this->areas = array();
    }
    
    function setArea($name,$data = array())
    {
        $this->areas[$name] = $data;
    }
}
