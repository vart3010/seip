<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\DataLoad\Production;

/**
 * Interfaz de rango
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface RangeInterface
{
    public function getType();
    
    public function getProductPlanning();
}
