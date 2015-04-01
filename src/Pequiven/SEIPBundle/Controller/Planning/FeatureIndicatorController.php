<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\Planning;

use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Form\Indicator\FeatureIndicatorType;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of FeatureIndicatorController
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FeatureIndicatorController extends SEIPController 
{
    /**
     * Retorna el formulario de la formula del indicador
     * 
     * @param Request $request
     * @return type
     */
    function getFormAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);
        
        $featureIndicator = $this->resourceResolver->getResource(
            $this->getRepository(),
            'findOneBy',
            array(array('id' => $request->get('id',0))));
        
        $form = $this->createForm(new FeatureIndicatorType());
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $indicator,
                'form' => $form->createView(),
                'featureIndicator' => $featureIndicator
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }
    
    public function addAction (Request $request)
    {
        $featureIndicator = $this->createNew();
        
        $indicator = $this->findIndicatorOr404($request);
        $form = $this->createForm(new FeatureIndicatorType(),$featureIndicator);
        $form->handleRequest($request);
        $errors = null;
        if($form->isValid()){
            $indicator->addFeaturesIndicator($featureIndicator);
            
            $featureIndicator->setIndicator($indicator);
            $featureIndicator->setCreatedBy($this->getUser());
            
            $this->save($featureIndicator,true);
        }else {
            $errors = $form;
        }
        $view = $this
            ->view()
            ->setData(array(
                'indicator' => $indicator,
                "errors" => $errors,
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','valuesIndicator','api_details','sonata_api_read',"featuresIndicator"));
        return $this->handleView($view);
    }
    
    /**
     * Busca el indicador o retorna un 404
     * @param Request $request
     * @return Indicator
     * @throws type
     */
    private function findIndicatorOr404(Request $request)
    {
        $id = $request->get('idIndicator');
        
        $indicator = $this->get('pequiven.repository.indicator')->find($id);
        if(!$indicator){
            throw $this->createNotFoundException();
        }
        return $indicator;
    }
}
