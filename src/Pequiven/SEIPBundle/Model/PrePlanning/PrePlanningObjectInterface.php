<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\PrePlanning;

/**
 * Item que se puede importar entre periodos
 * 
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface PrePlanningObjectInterface 
{
    function setSourceImported($object);
    
    function getSourceImported($object);
}
