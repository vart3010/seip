<?php

namespace Pequiven\SEIPBundle\Twig\Extension;

use CG\Core\ClassUtils;

class CoreExtension extends \Twig_Extension
{
    protected $loader;

    public function __construct(\Twig_LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_top', null, array('node_class' => 'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', 'is_safe' => array('html'))),
            new \Twig_SimpleFunction('print_error', array($this,'printError'), array('is_safe' => array('html'))),
        );
    }
    
    function printError($error) {
        $path = $this->generateAsset('bundles/tecnocreacionesvzlagovernment/template/developer/img/icons/icon-error.png');
        $base = "<div class='alert alert-danger-seip margin-bottom wrapped anthracite-bg with-mid-padding align-center' style='min-height:20px;font-size: 19px'>
        <img src='$path' style='width:21px;height:21px;padding-right: 6px'>
            <span>$error</span>
        </div>";
        return $base;
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'seip_core';
    }
    
    function generateAsset($path,$packageName = null){
        return $this->container->get('templating.helper.assets')
               ->getUrl($path, $packageName);
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     *
     * @var ContainerInterface
     */
    private $container;
}
