<?php

namespace Tecnocreaciones\Bundle\BoxBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TecnocreacionesBoxBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container) {
        $container->addCompilerPass(new DependencyInjection\Compiler\BoxCompilerPass());
    }
}
