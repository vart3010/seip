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
    /**
     * Añade o actualiza un valor del indicador
     * @param Request $request
     * @return type
     */
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
                'indicator'      => $indicator,
                'form'           => $form->createView(),
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
     * 
     * @param Request $request
     * @return type
     */
    public function obtainValuesAction(Request $request){
        $indicator = $this->findIndicatorOr404($request);
        $indicatorService = $this->getIndicatorService();
        $formula = $indicator->getFormula();
        
        $parameters = array();
        $parameters['result'] = 0;
        $parameters['showBoth'] = 1;
        
        if($indicator->getTypeDetailValue() == \Pequiven\IndicatorBundle\Entity\Indicator::TYPE_DETAIL_DAILY_LOAD_PRODUCTION){
        
            if($formula->getTypeOfCalculation() != \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $varPlanName = $formula->getVariableToPlanValue()->getName();
                $parameters['varPlanName'] = $varPlanName;
                $varRealName = $formula->getVariableToRealValue()->getName();
                $parameters['varRealName'] = $varRealName;
            } else{
                $varRealName = 'real';
                $parameters['varRealName'] = $varRealName;
            }

            $valueIndicator = $this->resourceResolver->getResource(
                $this->getRepository(),
                'findOneBy',
                array(array('id' => $request->get('id',0))));

            if(!$valueIndicator){
                $valueIndicator = new \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator();
            }

            //Método para obtener el orden del valor del indicador
            $options['typeOfResultSection'] = $indicator->getTypeOfResultSection();
            $results = $indicatorService->getValuesFromReportTemplate($indicator, $valueIndicator, $options);

            $parameters['real'] = $results[$varRealName];
            if($formula->getTypeOfCalculation() != \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $parameters['plan'] = $results[$varPlanName];
            } else{
                $parameters['showBoth'] = 0;
            }
        }
        $view = $this
            ->view()
            ->setData($parameters)
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
        $dataApi = array();
        $groupSerialization = array('id','api_list');
        $data = array(
            'numResult' => $numResult,
            'indicator' => $indicator,
            'valueIndicator' => $valueIndicator,
            'valueIndicatorDetail' => $valueIndicatorDetail,
        );
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
            $products = $services = $productsGroups = array();
            foreach ($dataApi as $value) {
                $typeOf = $value->getProduct()->getTypeOf();
                if(!isset($productsGroups[$typeOf])){
                    $productsGroups[$typeOf] = array();
                }
                $productsGroups[$typeOf][] = $value;
            }
            $productTypesLabel = \Pequiven\SEIPBundle\Entity\CEI\Product::getTypesLabel();
            $leafByGroup = array();
            foreach ($productsGroups as $key => $group) {
                $leaf = $this->buildLeaft(array(
                    "leaf"  => false,
                    "expanded" => true
                ));
                if(isset($productTypesLabel[$key])){
                    $leaf['name'] = $this->trans($productTypesLabel[$key].'s',array(),"PequivenSEIPBundle");
                }
                if($key == \Pequiven\SEIPBundle\Entity\CEI\Product::TYPE_PRODUCT){
                    $leaf["iconCls"] = "fa fa-cubes";
                }else if($key == \Pequiven\SEIPBundle\Entity\CEI\Product::TYPE_SERVICE){
                    $leaf["iconCls"] = "fa fa-cogs";
                }
                $leaf['children'] = $this->getStructureTree($group);
                $leafByGroup[] = $leaf;
            }
            $data = array(
                "success" => true,
                "text" =>  "Root",
                "children"=> $leafByGroup,
            );
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
     * @deprecated since version number
     * @param Request $request
     * @return type
     * @throws type
     */
    function updateDetailAction(Request $request) 
    {
        $valueIndicator = $this->getRepository()->find($request->get("id"));
        $valueIndicatorDetail = $valueIndicator->getValueIndicatorDetail();
        $indicator = $valueIndicator->getIndicator();
        
        $result = array("data" => null);
        
        if($indicator->getTypeDetailValue() == \Pequiven\IndicatorBundle\Entity\Indicator::TYPE_DETAIL_DAILY_LOAD_PRODUCTION)
        {
            $repository = $this->get("pequiven.repository.product_detail_daily_month");
            $slug = $request->get("slug");

            $productDetailDailyMonth = $repository->find($slug);

            if(!$productDetailDailyMonth){
                throw $this->createNotFoundException("The product_detail_daily_month not found.");
            }

            $dataRequest = $request->request->all();
            unset($dataRequest['id']);
            unset($dataRequest['null']);

            $form = $this->createForm(new \Pequiven\IndicatorBundle\Form\Indicator\ValueIndicator\Detail\ProductDetailDailyMonthType(),$productDetailDailyMonth);
            $form->submit($dataRequest,false);
            $success = false;

            if($form->isValid()){
                $this->save($productDetailDailyMonth,true);

                $parent = $productDetailDailyMonth->getParent();
                if($parent !== null){
                    $parent->updateParentTotals();
                    $this->save($parent,true);
                }
                $serializationContext = \JMS\Serializer\SerializationContext::create()->setGroups(array('id','api_list'));
                $result["children"] = $child = json_decode($this->getSerializer()->serialize($productDetailDailyMonth, 'json',$serializationContext),true);
                $success = true;
            }
        }
        
        
        $result["success"] = $success;
        $result["total"] = 1;
        $result["message"] = 1;
        
        $groupSerialization = array('id','api_list','product','components');
        
        $view = $this->view();
        $view->setData($result);
        $view->getSerializationContext()->setGroups($groupSerialization);
        return $view;
    }
    
    private function getStructureTree($objects,$limitCurrentLevel = 0) 
    {
        $tree = array();
        foreach ($objects as $child) {
           $tree[] = $this->getLeaf($child,$limitCurrentLevel);
        }
        return $tree;
    }
    
    private function getLeaf(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $item,$limitCurrentLevel)
    {
        $serializationContext = \JMS\Serializer\SerializationContext::create()->setGroups(array('id','api_list'));
        $child = json_decode($this->getSerializer()->serialize($item, 'json',$serializationContext),true);
        $child['name'] = $item->getProduct()->getName();
        $child['iconCls'] = null;
        if($item->getProduct()->getTypeOf() == \Pequiven\SEIPBundle\Entity\CEI\Product::TYPE_SERVICE){
            $child['iconCls'] = "fa fa-cog";
        }
        else if($item->getProduct()->getTypeOf() == \Pequiven\SEIPBundle\Entity\CEI\Product::TYPE_PRODUCT){
            $child['iconCls'] = "fa fa-cube";
        }
        $child['parentId'] = null;
        $child['leaf'] = true;
        
        if(count($item->getComponents()) > 0){
            $child['parentId'] = $item->getId();
            $limitLevel = 5;
            $child['leaf'] = false;
            $child['iconCls'] = "fa fa-sort-amount-asc";
            if($limitCurrentLevel < $limitLevel){
                $child['expanded'] = true;
                $child['children'] = $this->getStructureTree($item->getComponents(), ($limitCurrentLevel+1));
            }else{
                $child['expanded'] = false;
            }
        }else{
            $child['expanded'] = false;
        }
        return $child;
    }
    
    private function buildLeaft(array $parameters = array())
    {
        $default = array(
            'name' => 'Name',
            'iconCls' => "fa fa-cubes",
            'leaf' => true,
            "parentId" => null,
            "expanded" => false,
        );
        
        return array_merge($default,$parameters);
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
                $description = $variable->getDescription();
                if($formulaDetail){
                    if($formulaDetail->getVariableDescription()!= ""){
                        $description = $formulaDetail->getVariableDescription();
                    }
                    $unit = '('.$formulaDetail->getUnit().')';
                }
                
                $type = 'text';
                $parameters = array(
                    'label' => $description .' '.$unit,
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
     * Construye el formulario para la rerlacion con el indicador 2014
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicatorAction $action
     * @return type
     */
    private function buildActionForm() 
    {
       
        $form = $this->createFormBuilder(array(
            'csrf_protection' => false,
        ));

                $description = "Accion: ";
                $editable = true;
                $name = "action";
                $type = 'text';

                $parameters = array(
                    'label' => $description,
                    'label_attr' => array(
                        'class' => 'label'
                    ),
                    'attr' => array(
                        'class' => 'input'
                    ),
                    'disabled' => !$editable,
                );
                $form->add($name,$type,$parameters);

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
    
    /**
     * 
     * @return \JMS\Serializer\Serializer
     */
    private function getSerializer()
    {
        return $this->container->get('jms_serializer');
    }
}