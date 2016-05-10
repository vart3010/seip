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
 * Permite definir las areas del sistema
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface AreaDefinitionInterface
{
    /**
     * @return array Array con todas las areas (El atributo name es requerido)
     * array(
     *      array('name' => 'tecnocreaciones.area1', 'translation_domain' => 'messages')
     * )
     */
    function getAreas();
}
