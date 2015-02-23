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
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface PrePlanningInterface
{
    public function setLevelObject($levelObject);
    
    public function setName($name);
    
    public function getParameters();
    
    public function setRequiresApproval($requiresApproval);
    
    public function getStatus();
}
