<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Tecnocreaciones\Bundle\AjaxFOSUserBundle\TecnocreacionesAjaxFOSUserBundle(),//Manejador se sesion via ajax
            new Lunetics\LocaleBundle\LuneticsLocaleBundle(),//Manejador pagina multi-lenguaje
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),//Contructor del menu
            new FOS\UserBundle\FOSUserBundle(),//Manejador de usuario
            new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),//Traduccion disponible en javascript
            new Tecnocreaciones\Vzla\GovernmentBundle\TecnocreacionesVzlaGovernmentBundle(),//Plantilla
            new Tecnocreaciones\Bundle\TemplateBundle\TecnocreacionesTemplateBundle(),
            new Tecnocreaciones\Bundle\InstallBundle\TecnocreacionesInstallBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            //$bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
