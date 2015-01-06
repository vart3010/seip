<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de boxes
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BoxController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * @Template()
     */
    function indexAction()
    {
        $areaRender = $this->get('tecnocreaciones_box.area.render');
        $boxRender = $this->get('tecnocreaciones_box.render');
        
        $listAreasDefinition = $areaRender->getListAreasDefinition();
        $areas = $areaRender->getAreas();
        $modelBoxes = $areaRender->getModelBoxes();
        $boxsByName = $boxRender->getBoxsByName();

//        var_dump($listAreasDefinition);
//        var_dump($boxsByName);
//        var_dump($areas);
//        var_dump($modelBoxes);
//        die;
        $formBuilderMyBoxes = $this->createFormBuilder();
        foreach ($modelBoxes as $modelBox) {
            if($boxRender->hasBox($modelBox->getBoxName()) === false){
                continue;
            }
            $box = $boxRender->getBox($modelBox->getBoxName());
            if($box->hasPermission() === false){
                continue;
            }
            $nameBox = $box->getName();
            $name = sprintf('my_box[%s][]',$nameBox);
            $choices = array();
            
            foreach ($listAreasDefinition as $areaName => $labelArea) {
                if(in_array($areaName, $box->getAreasNotPermitted()) === true){
                    continue;
                }
                $choices[$areaName] = $labelArea;
            }
            $formBuilderMyBoxes->add($name,'choice',array(
                'label' => sprintf('%s (%s)',  $this->trans($nameBox,array(),$box->getTranslationDomain()),$this->trans($box->getDescription(),array(),$box->getTranslationDomain())),
                'choices' => $choices,
                
            ));
        }
        $formMyBoxes = $formBuilderMyBoxes->getForm();
        return array(
            'listAreasDefinition' => $listAreasDefinition,
            'boxes' => $boxsByName,
            'modelBoxes' => $modelBoxes,
            'boxRender' => $boxRender,
            'formMyBoxes' => $formMyBoxes->createView(),
        );
    }
    
    /**
     * 
     */
    function addAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = $request->get('box');
        $boxManager = $this->getBoxManager();
        foreach ($data as $boxName => $areaName) {
            if($areaName == ''){
                continue;
            }
            $box = $boxManager->find($boxName, $areaName);
            if($box === null){
                $boxManager->save($boxName, $areaName);
            }
        }
        return $this->redirect($this->generateUrl('tecnocreaciones_box_index'));
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
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\BoxBundle\Service\Manager\BoxManager
     */
    private function getBoxManager()
    {
        return $this->container->get('tecnocreaciones_box.box_manager');
    }
}
