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
        $boxRender = $this->get('tecnocreaciones_box.render');
        $areaRender = $this->get('tecnocreaciones_box.area.render');
        
        $boxsByName = $boxRender->getBoxsByName();
        $modelBoxes = $areaRender->getModelBoxes();
        
//        var_dump($listAreasDefinition);
//        var_dump($boxsByName);
//        var_dump($areas);
//        var_dump($modelBoxes);
//        die;
       $boxesUser = array();
        foreach ($boxsByName as $box) {
            $data = array();
            foreach ($modelBoxes as $modelBox) {
                if ($box->getName() !== $modelBox->getBoxName()){
                    continue;
                }
                foreach ($modelBox->getAreaName() as $key => $value) {
                    $data[] = $key;
                }
                $box->extraData = $modelBox->getAreaName();
                $boxesUser[] = $box;
                break;
            }
        }
        
        $formBoxes = $this->getFormBuilderBoxes()->getForm();
        
        return array(
            'boxes' => $boxesUser,
            'formBoxes' => $formBoxes->createView(),
        );
    }
    
    /**
     * 
     * @param type $data
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    private function getFormBuilderBoxes($data = array()) 
    {
        $areaRender = $this->get('tecnocreaciones_box.area.render');
        $boxRender = $this->get('tecnocreaciones_box.render');
        
        $modelBoxes = $areaRender->getModelBoxes();
        $boxsByName = $boxRender->getBoxsByName();
        
         $formBuilderBoxes = $this->createFormBuilder($data,array(
            'csrf_protection' => false,
        ));
        foreach ($boxsByName as $box) {
            $data = array();
            foreach ($modelBoxes as $modelBox) {
                if ($box->getName() !== $modelBox->getBoxName()){
                    continue;
                }
                foreach ($modelBox->getAreaName() as $key => $value) {
                    $data[] = $key;
                }
                $box->extraData = $modelBox->getAreaName();
                break;
            }
            $this->buildFormBoxes($formBuilderBoxes, $box,$data);
        }
        return $formBuilderBoxes;
    }


    private function buildFormBoxes(\Symfony\Component\Form\FormBuilderInterface &$formBuilder,  \Tecnocreaciones\Bundle\BoxBundle\Model\BoxInterface $box,array $data = array())
    {
        if($box->hasPermission() === false){
            return ;
        }
        $areaRender = $this->get('tecnocreaciones_box.area.render');
        $nameBox = $box->getName();
        $name = sprintf('%s',$nameBox);
        
        $choices = array();
        
        $listAreasDefinition = $areaRender->getListAreasDefinition();
        foreach ($listAreasDefinition as $areaName => $labelArea) {
            if(in_array($areaName, $box->getAreasNotPermitted()) === true){
                continue;
            }
            $choices[$areaName] = $labelArea;
        }
            
        $formBuilder->add($name,'choice',array(
            'label' => sprintf('%s <b>(%s)</b>',  $this->trans($nameBox,array(),$box->getTranslationDomain()),$this->trans($box->getDescription(),array(),$box->getTranslationDomain())),
            'attr' => array(
                'class' => 'select2 input-large'
            ),
            'choices' => $choices,
            'multiple' => true,
            'data' => $data,
            'required' => false,
        ));
    }


    /**
     * 
     */
    function addAction(\Symfony\Component\HttpFoundation\Request $request)
    {
//        var_dump($data);
        $formBoxes = $this->getFormBuilderBoxes()->getForm();
        if($formBoxes->submit($request)->isValid()){
            $data = $formBoxes->getData();
            $boxManager = $this->getBoxManager();
            foreach ($data as $boxName => $areasName) {
                if($areasName == ''){
                    continue;
                }
                $box = $boxManager->find($boxName);
//                var_dump($areasName);
    //            var_dump($box);
                $quantityAreasName = count($areasName);
                if($box === null){
                    $box = $boxManager->buildModelBox($boxName, $areasName);
                }
                
                if($quantityAreasName > 0){
                    $box->setAreaName($boxManager->buildAreasName($areasName));
                    $boxManager->save($box);
                }else if ($quantityAreasName <= 0){
                    $boxManager->remove($box);
                }
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
