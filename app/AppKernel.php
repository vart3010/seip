<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
//            new Lunetics\LocaleBundle\LuneticsLocaleBundle(),//Manejador pagina multi-lenguaje
            new Knp\Bundle\MenuBundle\KnpMenuBundle(), //Contructor del menu
            new FOS\UserBundle\FOSUserBundle(), //Manejador de usuario
            new FOS\RestBundle\FOSRestBundle(), //Servicios Rest
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(), //Generado de rutas javascript
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(), //Auth2 protocolo
            new JMS\SerializerBundle\JMSSerializerBundle(), //Serializador de objetos en json y xml
            new JMS\TranslationBundle\JMSTranslationBundle(), //Traductor optimizado
            new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(), //Traduccion disponible en javascript
            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Tpg\ExtjsBundle\TpgExtjsBundle(), //Conector se Sencha con ExtJs
            //SonataAdminBundle dependencias
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(), //Sonata ORM
            new Sonata\AdminBundle\SonataAdminBundle(), //Administracion
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\UserBundle\SonataUserBundle(),
            new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(), //Bundle para auditar entidades
            new \Genemu\Bundle\FormBundle\GenemuFormBundle(), //Tipos de form adicionales select2
//            new Shtumi\UsefulBundle\ShtumiUsefulBundle(),
            new Tecnocreaciones\Bundle\AjaxFOSUserBundle\TecnocreacionesAjaxFOSUserBundle(), //Manejador se sesion via ajax
            new Tecnocreaciones\Vzla\GovernmentBundle\TecnocreacionesVzlaGovernmentBundle(), //Plantilla
            new Tecnocreaciones\Bundle\TemplateBundle\TecnocreacionesTemplateBundle(),
            new Tecnocreaciones\Bundle\InstallBundle\TecnocreacionesInstallBundle(),
            new Tecnocreaciones\Bundle\ToolsBundle\TecnocreacionesToolsBundle(),
            new Tecnocreaciones\Vzla\EntityBundle\TecnocreacionesVzlaEntityBundle(),
            new Tecnocreaciones\Vzla\FixturesBundle\TecnocreacionesVzlaFixturesBundle(),
            new Pequiven\SEIPBundle\PequivenSEIPBundle(),
            new Pequiven\SIGBundle\PequivenSIGBundle(),
            new Pequiven\MasterBundle\PequivenMasterBundle(),
            new Pequiven\ObjetiveBundle\PequivenObjetiveBundle(),
            new Pequiven\IndicatorBundle\PequivenIndicatorBundle(),
            new Pequiven\ArrangementBundle\PequivenArrangementBundle(),
            new Pequiven\ArrangementProgramBundle\PequivenArrangementProgramBundle(),
            new Tecnocreaciones\Bundle\BoxBundle\TecnocreacionesBoxBundle(),
            new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle(),
            //REPORTEADOR
            //new Mesd\Jasper\ReportBundle\MesdJasperReportBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            //$bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
