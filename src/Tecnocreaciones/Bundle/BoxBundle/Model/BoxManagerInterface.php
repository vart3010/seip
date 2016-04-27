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
interface BoxManagerInterface extends \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    function save(\Tecnocreaciones\Bundle\BoxBundle\Model\ModelBoxInterface $modelBox);
    
    function remove(\Tecnocreaciones\Bundle\BoxBundle\Model\ModelBoxInterface $box);
    
    function createNew();
    
    function find($boxName);
    
    function buildModelBox($boxName,$areas);
}
