<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Model\Adapter;

/**
 * Description of BaseAdapter
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BaseAdapter implements AdapterInterface
{
    /**
     *
     * @var \Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender
     */
    protected $areaRender;
    
    function setAreaRender(\Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender $areaRender) 
    {
        $this->areaRender = $areaRender;
    }
}
