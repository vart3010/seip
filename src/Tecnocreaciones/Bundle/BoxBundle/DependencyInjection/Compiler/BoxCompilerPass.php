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
        $renderAreaRenderDefinition = $container->getDefinition('tecnocreaciones_box.area.render');
        //Busca los boxes definidos
        $tags = $container->findTaggedServiceIds('tecnocreaciones_box.box');
        foreach ($tags as $id => $attributes) {
            $renderBoxDefinition->addMethodCall('addBox',array($container->getDefinition($id)));
        }
        //Busca las areas definidas
        $tags = $container->findTaggedServiceIds('tecnocreaciones_box.area');
        foreach ($tags as $id => $attributes) {
            $renderAreaRenderDefinition->addMethodCall('addAreaDefinition',array($container->getDefinition($id)));
        }
        //Busca los adaptadores de datos definidos
        $tags = $container->findTaggedServiceIds('tecnocreaciones_box.area.adapter');
        foreach ($tags as $id => $attributes) {
            $adapterDefinition = $container->getDefinition($id);
            $renderAreaRenderDefinition->addMethodCall('addAdapter',array($adapterDefinition));
        }
    }
}
