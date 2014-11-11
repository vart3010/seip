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
        ;
    }
    
    function addArea($areaName,$boxName) {
        if($this->boxRender->hasBox($boxName)){
            
        }
    }
    
    function renderArea($name)
    {
        
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
