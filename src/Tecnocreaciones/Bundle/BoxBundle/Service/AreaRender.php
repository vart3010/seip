<?php

namespace Tecnocreaciones\Bundle\BoxBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicio que renderiza boxes en una area
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class AreaRender implements ContainerAwareInterface
{
    private $container;
    
    /**
     * Contenedor de boxes
     * @var \Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender
     */
    private $boxRender;
    
    private $areas;
            
    public function __construct() {
        $this->areas = array();
    }
    
    /**
     * Agrega un boxe a una area
     * @param type $areaName
     * @param type $boxName
     * @param type $position
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender
     */
    function addArea($areaName,$boxName,$position = 0) {
        if($this->boxRender->hasBox($boxName)){
            if(!isset($this->areas[$areaName])){
                $this->areas[$areaName] = array();
            }
            if(!isset($this->areas[$areaName][$position])){
                $this->areas[$areaName][$position] = array();
            }
            if(!array_search($boxName, $this->areas[$areaName][$position])){
                $this->areas[$areaName][$position][] = $boxName;
            }
            
            return $this;
        }
    }
    
    /**
     * Retorna el area a renderizar
     * @param type $areaName Nombre del area
     * @return array
     */
    function getArea($areaName)
    {
        $areas = array();
        if(isset($this->areas[$areaName])){
            $areas = $this->areas[$areaName];
        }
        return $areas;
    }
    
    /**
     * Renderiza un area
     * @param type $areaName
     */
    function renderArea($areaName)
    {
        $positions = $this->getArea($areaName);
        foreach ($positions as $boxName) {
            if($this->getBoxRender()->hasBox($boxName)){
                $this->getBoxRender()->getBox($boxName);
            }
        }
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender
     */
    function getBoxRender() {
        return $this->boxRender;
    }

    /**
     * Establece el renderizador de box
     * @param \Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender $boxRender
     */
    function setBoxRender(\Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender $boxRender) {
        $this->boxRender = $boxRender;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
