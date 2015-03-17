<?php

namespace Pequiven\SEIPBundle\Controller\Planning;

use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador de los valores del indicador (Planificacion)
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ValueIndicatorController extends \Pequiven\SEIPBundle\Controller\SEIPController
{
    function addAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);
                
        $formula = $indicator->getFormula();
        $form = $this->buildFormulaForm($indicator);
        $value = 0;
        if($form->submit($request)->isValid()){
            $data = $form->getData();
            $value = $this->getIndicatorService()->calculateFormulaValue($formula, $data);
            
            $user = $this->getUser();
            $details = $indicator->getDetails();
            if(!$details){
                $details = new \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails();
                $indicator->setDetails($details);
            }
            $previusValue = $indicator->getValueFinal();
            $details
                    ->setPreviusValue($previusValue)
                    ->setLastNotificationAt(new \DateTime())
                    ->setLastNotificationBy($user)
                    ->setLastNotificationParameters($data)
                    ->setLastFormulaUsed($formula)
                    ;
            
            $valueIndicator = $this->resourceResolver->getResource(
                $this->getRepository(),
                'findOneBy',
                array(array('id' => $request->get('id',0))));
            
            if(!$valueIndicator){
                $valueIndicator = new \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator();
            }else{
            }
            
            $valueIndicator
                ->setFormulaParameters($data)
                ->setFormula($formula)
                ->setValueOfIndicator($value)
                ;
            if($valueIndicator->getId() == null){
                $valueIndicator
                    ->setCreatedBy($user)
                    ;
                $indicator->addValuesIndicator($valueIndicator);
                
                $this->domainManager->dispatchEvent('pre_add', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($valueIndicator));
            
                $this->save($indicator,true);

                $this->domainManager->dispatchEvent('post_add', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($valueIndicator));
                
            }else{
                $valueIndicator
                    ->setUpdatedBy($user)
                    ->setUpdatedAt(new \DateTime())
                    ;
                $event = new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($valueIndicator);
                $event->setArgument('previusValue', $previusValue);
                        
                $this->domainManager->dispatchEvent('pre_update', $event);
            
                $this->save($valueIndicator,true);

                $this->domainManager->dispatchEvent('post_update', $event);
            }
            $resultService = $this->container->get('seip.service.result');
            $resultService->refreshValueIndicator($indicator);
//            //Refrescar resultados del indicador padre.
//            if($indicator->getParent() !== null){
//                $resultService->refreshValueIndicator($indicator->getParent());
//            }
        }
        
        $view = $this
            ->view()
            ->setData(array(
                'result' => $value,
                'indicator' => $indicator,
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','valuesIndicator','api_details','sonata_api_read'));
        return $view;
    }
    
    /**
     * Retorna el formulario de la formula del indicador
     * 
     * @param Request $request
     * @return type
     */
    function getFormAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);
        
        $valueIndicator = $this->resourceResolver->getResource(
            $this->getRepository(),
            'findOneBy',
            array(array('id' => $request->get('id',0))));
        
        $form = $this->buildFormulaForm($indicator,$valueIndicator);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $indicator,
                'form' => $form->createView(),
                'valueIndicator' => $valueIndicator
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }
    
    /**
     * Da una vista previa del valor de la formula
     * @param Request $request
     * @return type
     */
    function calculateAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);
        
        $formula = $indicator->getFormula();
        $form = $this->buildFormulaForm($indicator);
        $value = 0;
        if($form->submit($request)->isValid()){
            $data = $form->getData();
            $value = $this->getIndicatorService()->calculateFormulaValue($formula, $data);
        }
        
        $view = $this
            ->view()
            ->setData(array(
                'result' => $value,
            ))
        ;
        return $view;
    }
    
    /**
     * Muestra los detalles de un valor de indicador, ya sea el formulario o solo el show
     * @param Request $request
     * @return type
     */
    public function showDetailAction(Request $request)
    {
        $numResult = $request->get('numResult');
        $valueIndicator = $this->findOr404($request);
        $valueIndicatorDetail = $valueIndicator->getValueIndicatorDetail();
        $indicator = $valueIndicator->getIndicator();
        $valueIndicatorConfig = $indicator->getValueIndicatorConfig();
        
        $template = '';
        $data = array(
            'numResult' => $numResult,
            'indicator' => $indicator,
            'valueIndicator' => $valueIndicator,
            'valueIndicatorDetail' => $valueIndicatorDetail,
        );
        $dataApi = array();
        $groupSerialization = array('id','api_list');
        
        if($indicator->getTypeDetailValue() == \Pequiven\IndicatorBundle\Entity\Indicator::TYPE_DETAIL_DAILY_LOAD_PRODUCTION)
        {
            if(!$valueIndicatorDetail){
                $em = $this->getDoctrine()->getManager();
                $products = $valueIndicatorConfig->getProducts();
                
                $valueIndicatorDetail = new \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail();
                $valueIndicatorDetail->setValueIndicator($valueIndicator);
                $valueIndicator->setValueIndicatorDetail($valueIndicatorDetail);
                foreach ($products as $product) {
                    $productDetailDailyMonth = new \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth();
                    $productDetailDailyMonth->setProduct($product);
                    $productDetailDailyMonth->setMonth($numResult);
                    
                    if(count($product->getComponents()) > 0){
                        foreach ($product->getComponents() as $component) {
                            $productDetailDailyMonthComponent = new \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth();
                            $productDetailDailyMonthComponent->setProduct($component);
                            $productDetailDailyMonthComponent->setMonth($numResult);
                            
                            $productDetailDailyMonthComponent->setValueIndicatorDetail($valueIndicatorDetail);
                            $productDetailDailyMonth->addComponent($productDetailDailyMonthComponent);
                        }
                    }
                    
                    $valueIndicatorDetail->addProductsDetailDailyMonth($productDetailDailyMonth);
                }
                $em->persist($valueIndicatorDetail);
                $em->flush();
            }
            $dataApi = $valueIndicatorDetail->getProductsDetailDailyMonth();
            $groupSerialization[] = 'product';
            $groupSerialization[] = 'components';
            
            $template = 'PequivenSEIPBundle:Planning:Indicator/ValueIndicator/Detail/productDetailDailyMonth.html.twig';
        }
        if ($this->config->isApiRequest()) {
            $data = $dataApi;
        }
        $view = $this
            ->view()
            ->setTemplate($template)
            ->setData($data)
        ;
        $view->getSerializationContext()->setGroups($groupSerialization);
        return $view;
    }
    
    /**
     * Construye el formulario de la formula
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @return type
     */
    private function buildFormulaForm(\Pequiven\IndicatorBundle\Entity\Indicator $indicator,\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator = null) 
    {
        $formula = $indicator->getFormula();
        
        $data = array();
        if($valueIndicator){
            $data = $valueIndicator->getFormulaParameters();
        }
        $form = $this->createFormBuilder($data,array(
            'csrf_protection' => false,
        ));
        if($formula){
            $variables = $formula->getVariables();
            foreach ($variables as $variable) {
                $editable = true;
                if($variable->isFromEQ() === true){
//                    continue;
                    $editable = false;
                }
                $name = $variable->getName();
                
                $formulaDetail = $indicator->getFormulaDetailByVariable($variable);
                $unit = '';
                if($formulaDetail){
                    $unit = '('.$formulaDetail->getUnit().')';
                }
                
                $type = 'text';
                $parameters = array(
                    'label' => $variable->getDescription() .' '.$unit,
                    'label_attr' => array(
                        'class' => 'label'
                    ),
                    'attr' => array(
                        'class' => 'input'
                    ),
                    'disabled' => !$editable,
                );
                $form->add($name,$type,$parameters);
            }
        }
        return $form->getForm();
    }
    
    /**
     * Busca el indicador o retorna un 404
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
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
    
    /**
     * Retorna el servicio que administra los indicadores
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    function getIndicatorService()
    {
        return $this->get('pequiven_indicator.service.inidicator');
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\ToolsBundle\Service\UnitConverter
     */
    private function getUnitConverter()
    {
        return $this->container->get('tecnocreaciones_tools.unit_converter');
    }
}