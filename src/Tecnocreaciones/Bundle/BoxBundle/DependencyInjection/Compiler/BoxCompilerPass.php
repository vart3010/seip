<?php

namespace Tecnocreaciones\Bundle\BoxBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Agrega todos los boxes al servicio generador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class BoxCompilerPass implements CompilerPassInterface {
    
    public function process(ContainerBuilder $container) 
    {
        $renderBoxDefinition = $container->getDefinition('tecnocreaciones_box.render');
        $tags = $container->findTaggedServiceIds('tecnocreaciones_box.box');
        foreach ($tags as $id => $attributes) {
            $renderBoxDefinition->addMethodCall('addBox',array($container->getDefinition($id)));
        }
    }
}
