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
    
    /**
     * Areas agregadas
     * @var array 
     */
    private $areas;
    
    /**
     * Areas definidas en el sistema
     * 
     * @var array 
     */
    private $areasDefinition;
    
    /**
     * Adaptadores para agregar los boxes a imprimir
     * @var \Tecnocreaciones\Bundle\BoxBundle\Model\Adapter\AdapterInterface
     */
    private $adapters;
    
    /**
     * Todos los boxes obtenidos a partir de los adaptadores
     * 
     * @var array
     */
    private $modelBoxes;

    /**
     * Se usa como bandera  para inicializar una sola vez los adaptadores
     * @var boolean
     */
    private $initAdapter = false;

    public function __construct() {
        $this->areas = array();
    }
    
    /**
     * Agrega un box a una area
     * 
     * @param type $area
     * @param type $boxName
     * @param type $position
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender
     */
    function addArea($area,$boxName,$position = 0) {
        if($this->boxRender->hasBox($boxName)){
            
            if(!isset($this->areas[$area])){
                $this->areas[$area] = array();
            }
//            if(!isset($this->areas[$area][$position])){
//                $this->areas[$area][$position] = array();
//            }
            if(!array_search($boxName, $this->areas[$area])){
                if(empty($this->areas[$area][$position])){
                    $this->areas[$area][$position] = $boxName;
                }else{
                    $this->areas[$area][] = $boxName;
                }
            }
        }
        return $this;
    }
    
    /**
     * Retorna el area a renderizar
     * @param type $areas Nombre del area
     * @return array
     */
    function getArea($area)
    {
        $areas = array();
        if(isset($this->areas[$area])){
            ksort($this->areas[$area]);
            $areas = $this->areas[$area];
        }
        return $areas;
    }
    
    /**
     * Renderiza un area
     * @param type $area
     */
    function renderArea($area)
    {
        if($this->initAdapter === false){
            $this->initAdapters();
        }
        $result = '';
        $positions = $this->getArea($area);
        foreach ($positions as $boxName) {
            if($this->getBoxRender()->hasBox($boxName)){
                $result .= $this->getBoxRender()->renderBox($boxName);
            }
        }
        return $result;
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender
     */
    public function getBoxRender() {
        return $this->boxRender;
    }

    /**
     * Establece el renderizador de box
     * @param \Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender $boxRender
     */
    public function setBoxRender(\Tecnocreaciones\Bundle\BoxBundle\Service\BoxRender $boxRender) {
        $this->boxRender = $boxRender;
    }
    
    /**
     * Añade una definicion de area
     * @param \Tecnocreaciones\Bundle\BoxBundle\Model\AreaDefinitionInterface $areaDefinition
     */
    public function addAreaDefinition(\Tecnocreaciones\Bundle\BoxBundle\Model\AreaDefinitionInterface $areaDefinition)
    {
        if($this->areasDefinition === null){
            $this->areasDefinition = array();
        }
        $this->areasDefinition[] = $areaDefinition;
    }
    
    /**
     * Retorna la lista de las areas definidas
     * 
     * @throws \LogicException
     */
    public function getListAreasDefinition()
    {
        $listAreas = array();
        if($this->areasDefinition){
            $defaultParameters = array(
                'translation_domain' => 'messages',
            );
            foreach ($this->areasDefinition as $areaDefinition) {
                $areas = $areaDefinition->getAreas();
                foreach ($areas as $area) {
                    if(!isset($area['name'])){
                        throw new \LogicException(sprintf('The area definition require the "name" property'));
                    }
                    $name = $area['name'];
                    if(isset($listAreas[$name])){
                        throw new \LogicException(sprintf('The area definition name "%s" is already defined'));
                    }
                    $areaDefinitionData = array_merge($defaultParameters, $area);
                    $listAreas[$name] = $this->trans($areaDefinitionData['name'],array(),$areaDefinitionData['translation_domain']);
                }
            } 
        }
        return $listAreas;
    }
    
    /**
     * Inicializa la data de los adaptadores
     */
    private function initAdapters()
    {
        if($this->adapters){
            $this->modelBoxes = array();
            foreach ($this->adapters as $adapter)
            {
                $modelBoxes = $adapter->getModelBoxes();
                if($modelBoxes){
                    foreach ($modelBoxes as $modelBox) {
                        foreach ($modelBox->getAreas() as $areas => $data) {
                            $order = $data['position'];
                            $this->addArea($areas, $modelBox->getBoxName(),$order);
                            $this->modelBoxes[$modelBox->getBoxName()] = $modelBox;
                        }
                    }
                }
            }
        }
        $this->initAdapter = true;
    }
    
    /**
     * Agrega un adaptador para obtener los datos
     * @param \Tecnocreaciones\Bundle\BoxBundle\Model\Adapter\AdapterInterface $adapter
     */
    function addAdapter(\Tecnocreaciones\Bundle\BoxBundle\Model\Adapter\AdapterInterface $adapter)
    {
        if($this->adapters === null){
            $this->adapters = array();
        }
        $adapter->setContainer($this->container);
        $this->adapters[] = $adapter;
    }
    
    /**
     * Retorna los boxes en las areas agregadas
     * 
     * @return type
     */
    function getAreas()
    {
        if($this->initAdapter === false){
            $this->initAdapters();
        }
        return $this->areas;
    }
    
    function getModelBoxes() 
    {
        if($this->initAdapter === false){
            $this->initAdapters();
        }
        return $this->modelBoxes;
    }

    /**
     * Traduce un texto
     * @param type $id
     * @param array $parameters
     * @param type $domain
     * @return type
     */
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
