<?php

namespace Tecnocreaciones\Bundle\BoxBundle\Twig\Extension;

class BoxBundleExtension extends \Twig_Extension
{
    /**
     *
     * @var ContainerInterface
     */
    private $container;
   
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('renderArea', array($this,'renderArea'), array('is_safe' => array('html'))),
        );
    }
    
    function renderArea($areas)
    {
        return $this->getAreaRender()->renderArea($areas);
    }
    
    /**
     * Renderizador dinamico de areas
     * 
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender
     */
    private function getAreaRender()
    {
        return $this->container->get('tecnocreaciones_box.area.render');
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'tecnocreaciones_box_extension';
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
}
