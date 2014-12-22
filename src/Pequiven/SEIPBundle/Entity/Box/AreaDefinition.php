<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\Box;

/**
 * Definicion de las areas del sistema
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class AreaDefinition implements \Tecnocreaciones\Bundle\BoxBundle\Model\AreaDefinitionInterface
{
    public function getAreas() 
    {
        return array(
            array('name' => 'seip.area.main', 'translation_domain' => 'messages'),
        );
    }
}
