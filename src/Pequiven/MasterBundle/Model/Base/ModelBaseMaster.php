<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Model\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo base de mastros
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ModelBaseMaster extends ModelBase 
{
    /**
     * ¿Item activo?
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean")
     */
    protected $enabled = true;
    
    function getEnabled() {
        return $this->enabled;
    }
    
    function isEnabled() {
        return $this->enabled;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }
}
