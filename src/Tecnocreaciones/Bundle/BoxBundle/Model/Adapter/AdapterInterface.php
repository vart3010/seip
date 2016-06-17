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
 * Definicion de adaptardor de los boxes o widget
 * 
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface AdapterInterface extends \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    function getModelBoxes();
}
