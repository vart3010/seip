<?php

namespace Tecnocreaciones\Bundle\BoxBundle\Service;

use Exception;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tecnocreaciones\Bundle\BoxBundle\Model\BoxInterface;

/**
 * Servicio para renderizar los box
 * 
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class BoxRender implements ContainerAwareInterface
{
    /**
     * Todos los box disponibles
     * @var array
     */
    private $boxs;
    /**
     * Todos los box disponibles agrupados por nombres
     * @var array
     */
    private $boxsByName;
    
    /**
     * Javascript de los box por grupos
     * @var array
     */
    private $assetsJs;
    /**
     * Css de los box por grupos
     * @var array
     */
    private $assetsCss;
    
    private $container;
    
    const GROUP_DEFAULT = 'default';
    
    /**
     * Cantidad de box agregados
     * @var array
     */
    private $quantityBox = 0;
    
    private $boxsToRender;
    
    public function __construct() {
        $this->boxs = array();
        $this->boxsToRender = array();
    }
    
    function getBoxs() {
        return $this->boxs;
    }
    
    function getBoxsByName() 
    {
        if($this->boxsByName === null){
            $this->boxsByName = array();
            foreach ($this->getBoxs() as $group => $boxes) {
                foreach ($boxes as $box) {
                    $this->boxsByName[$box->getName()] = $box;
                }
            }
        }
        return $this->boxsByName;
    }

    function countBox() {
        return $this->quantityBox;
    }

    /**
     * Añade un box al render
     * @param BoxInterface $box
     * @throws Exception
     */
    function addBox(BoxInterface $box) {
        foreach ($box->getGroups() as $group) {
            //Init group
            if(!isset($this->boxs[$group])){
                $this->boxs[$group] = array();
            }
            if(isset($this->boxs[$group][$box->getName()])){
                throw new Exception(sprintf('Box "%s" already exists!',$box->getName()));
            }
            $box->setContainer($this->container);
            $this->boxs[$group][$box->getName()] = $box;
        }
        $this->quantityBox++;
    }
    
    /**
     * Renderiza un box
     * 
     * @param type $name
     * @param type $group
     * @return type
     */
    function renderBox($name,$group = self::GROUP_DEFAULT)
    {
        $templateRendered = null;
        if(!$this->hasBox($name,$group)){
            return $templateRendered;
        }
        $box = $this->getBox($name,$group);
        $box->setContainer($this->container);
        if($box->hasPermission() === true){
            $parameters = $box->getParameters();
            if(!is_array($parameters)){
                $parameters = array($parameters);
            }
            $templateRendered = $this->renderView($box->getTemplateName(),$parameters);
            $this->addAssetsJs($box->getAssetsJs());
            $this->addAssetsCss($box->getAssetsCss());
            if(!isset($this->boxsToRender[$box->getName()])){
                $this->boxsToRender[$box->getName()] = $box;
            }
        }
        return $templateRendered;
    }
    
    function renderBoxGroup($group = self::GROUP_DEFAULT) {
        
    }
    
    /**
     * Retorna el box segun el grupo
     * 
     * @param type $name
     * @param type $group
     * @return BoxInterface
     * @throws Exception
     */
    function getBox($name,$group = self::GROUP_DEFAULT)
    {
        if(isset($this->boxs[$group][$name]) === false){
            throw new Exception(sprintf('Box "%s" not exists!',$name));
        }
        return $this->boxs[$group][$name];
    }
    
    /**
     * Verifica si un box existe en el grupo
     * 
     * @param type $name
     * @param type $group
     * @return boolean
     */
    function hasBox($name,$group = self::GROUP_DEFAULT) {
        if(isset($this->boxs[$group][$name]) === true){
            return true;
        }
        return false;
    }
    /**
     * Retorna los assets js necesarios para los boxes que se renderizaron
     * 
     * @param type $group
     * @return type
     */
    function getAssetsJs() {
        $assetsJs = $this->assetsJs;
        $this->assetsJs = array();
        return $assetsJs;
    }
    
    /**
     * Retorna los assets css necesarios para los boxes que se renderizaron
     * 
     * @param type $group
     * @return type
     */
    function getAssetsCss() {
        $assetsCss = $this->assetsCss;
        $this->assetsCss = array();
        
        return $assetsCss;
    }

    /**
     * Agrega los assets de javascript necesarios para renderizar correctamente el resumen box
     * 
     * @param array|string $assetsJs
     * @param type $group
     */
    function addAssetsJs($assetsJs) {
        if(!is_array($assetsJs)){
            $assetsJs = array();
        }
        foreach ($assetsJs as $asset) {
            $id = md5($asset);
            if(!isset($this->assetsJs[$id])){
                $this->assetsJs[$id] = $asset;
            }
        }
    }

    /**
     * Agrega los assets de css necesarios para renderizar correctamente el resumen box
     * 
     * @param array|string $assetsCss
     * @param type $group
     */
    function addAssetsCss($assetsCss) {
        if(!is_array($assetsCss)){
            $assetsCss = array();
        }
        foreach ($assetsCss as $asset) {
            $id = md5($asset);
            if(!isset($this->assetsCss[$id])){
                $this->assetsCss[$id] = $asset;
            }
        }
    }


     /**
     * Returns a rendered view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    protected function renderView($view, array $parameters = array())
    {
        return $this->container->get('templating')->render($view, $parameters);
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function clear()
    {
        $this->boxsToRender = array();
        $this->assetsJs = array();
        $this->assetsCss = array();
    }
}
