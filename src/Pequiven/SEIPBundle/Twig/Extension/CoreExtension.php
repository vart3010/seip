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
            new \Twig_SimpleFunction('contentHeader', array($this,'contentHeader'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('generateLink', array($this,'generateLink'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('generateLinkUrlOnly', array($this,'generateLinkUrlOnly'), array('is_safe' => array('html'))),
        );
    }
    
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('str_pad', function($input, $padlength, $padstring='', $padtype = STR_PAD_LEFT){
                return str_pad($input, $padlength, $padstring, $padtype);
            }),
        );
    }
    
    function contentHeader() {
        $parameters = array();
        $args = func_get_args();
        foreach ($args as $key => $arg) {
            if(empty($arg)){
                continue;
            }
            $item = new \stdClass();
            $item->link = null;
            $item->label = null;
            if(is_array($arg)){
                $count = count($arg);
                if($count > 1){
                    throw new \LogicException('The array elment must be one, count');
                }
                foreach ($arg as $key => $value) {
                    $item->link = $key;
                    $item->label = $value;
                }
            }else{
                $item->label = $arg;
            }
            $parameters[] = $item;
        }
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        $periodDescription = '';
        if($period){
            $periodDescription = $period->getDescription();
        }
        
        return $this->container->get('templating')->render('PequivenSEIPBundle:Template:Developer/contentHeader.html.twig', 
            array(
                'breadcrumbs' => $parameters,
                'period' => $periodDescription
            )
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
     * Genera un link completo para mostrar el objeto
     * 
     * @param type $entity
     * @param type $type
     * @return type
     */
    function generateLink($entity,$type = \Pequiven\SEIPBundle\Service\LinkGenerator::TYPE_LINK_DEFAULT,array $parameters = array())
    {
        return $this->container->get('seip.service.link_generator')->generate($entity,$type,$parameters);
    }
    
    /**
     * Genera solo la url de el objeto
     * 
     * @param type $entity
     * @param type $type
     * @return type
     */
    function generateLinkUrlOnly($entity,$type = \Pequiven\SEIPBundle\Service\LinkGenerator::TYPE_LINK_DEFAULT,array $parameters = array())
    {
        return $this->container->get('seip.service.link_generator')->generateOnlyUrl($entity,$type,$parameters);
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
