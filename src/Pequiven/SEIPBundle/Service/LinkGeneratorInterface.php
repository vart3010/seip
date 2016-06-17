<?php

namespace Pequiven\SEIPBundle\Service;

/**
 * Interface de generador de link
 * 
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
interface LinkGeneratorInterface
{
    public static function getConfigObjects();
    
    public function getIconsDefinition();
}
