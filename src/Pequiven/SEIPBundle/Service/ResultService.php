<?php

namespace Pequiven\SEIPBundle\Service;

use Pequiven\MasterBundle\Entity\Formula;

/**
 * Servicio que se encarga de actualizar los resultados
 * 
 * @service seip.service.result
 * @author inhack20
 */
class ResultService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $container;
 
    /**
     * Devuelve un resultado por el tipo
     * @param array $results
     * @param type $type
     * @return array
     */
    public function getResultByType($results,$type)
    {
        $myResult = null;
        if($results != null){
            foreach ($results as $result) {
                if($result->getTypeResult() == $type){
                    $myResult = $result;
                    break;
                }
                if($result->getChildrens()->count() > 0){
                    $childResult = $this->getResultByType($result->getChildrens(), $type);
                    if($childResult != null){
                        $myResult= $childResult;
                        break;
                    }
                }
            }
        }
        return $myResult;
    }
    
    /**
     * Actualiza los resultados de un objetivo
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $myResult
     */
    public function updateResultOfObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$myResult,$andFlush = true)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($myResult->getResultDetails());
        
        $objetive = $this->resolveObjetiveOfResult($myResult);
        $results = $objetive->getResults();
        $total = 0.0;
        $countResult = 0;
        //Los resultados siempre son por promedio ponderado
        foreach ($results as $result) {
            $countResult++;
            if($result->getChildrens()->count() > 0){
                //Calcular el valor del resultado, a partir de los hijos
                $totalChild = 0.0;
                $countResultChild = 0;
                foreach ($result->getChildrens() as $children) {
                    $countResultChild++;
                    if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                        $totalChild += $children->getResult();
                    } elseif ($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                        $totalChild += $children->getResultWithWeight();
                    }
                }
                if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                    $totalChild += ($totalChild / $countResultChild);
                }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                    //Nada que hacer
                }
                
                $total += ($totalChild * $result->getWeight()) / 100;
            } else {
                $total += $result->getResultWithWeight();
            }
        }
        
//        if($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
//            $total = ($total / $countResult);
//        }elseif($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
//            //Nada que hacer
//        }

        $objetive->setResultOfObjetive($total);//Resultado del objetivo
        $objetive->updateLastDateCalculateResult();
        
        if($andFlush){
            $em->persist($objetive);
        }
        
        if($objetive->getParents()->count() > 0){//Actualizar los resultados del padre
            foreach ($objetive->getParents() as $parent) {
                $myResult = $this->getResultByType($parent->getResults(),\Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE);
                
                if($myResult){
                    $this->calculateResult($myResult);
                }
            }
        }
    }
    
    /**
     * Calcula los resultados
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result,$andFlush = true) {
        $em = $this->getDoctrine()->getManager();
        
        if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
            $this->calculateResultTypeArrangementPrograms($result);
        }elseif($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_INDICATOR){
            $this->calculateResultTypeIndicator($result);
        }elseif($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE){
            $this->calculateResultTypeObjetive($result);
        }
        
        if($result->getParent() != null && $result->getParent()->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
            $parent = $result->getParent();
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());
            
            $em->persist($parent);
        }
        
        $result->updateLastDateCalculateResult();
        $this->updateResultOfObjetive($result,$andFlush);
        
        if($andFlush){
            $em->flush();
        }
    }
    
    /**
     * Calcula el resultado a partir de los programas de gestion
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResultTypeArrangementPrograms(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $arrangementPrograms = $objetive->getArrangementPrograms();
        $countArrangementPrograms = count($arrangementPrograms);
        $total = 0.0;
        $countResult = 0;
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            if($countArrangementPrograms > 0){
                foreach ($arrangementPrograms as $arrangementProgram){
                    if($arrangementProgram->getStatus() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::STATUS_REJECTED){
                        continue;
                    }
                    $countResult++;
                    $total += $arrangementProgram->getResult();
                }
            }
        }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
            throw new \LogicException(sprintf('Los programas de gestion no se calculan con promedio ponderado, revise el resultado con id "%s"',$result->getId()));
        }
        
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            $total = ($total / $countResult);
        }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
            //Nada que hacer
        }
        $result->setTotal($total);
    }
    
    /**
     * Calcula los resultados a partir de los indicadores
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResultTypeIndicator(\Pequiven\SEIPBundle\Entity\Result\Result &$result) 
    {
        $objetive = $this->resolveObjetiveOfResult($result);
        $itemsResult = $objetive->getIndicators();
        $this->calculateResultItems($result, $itemsResult,true);
    }
    
    /**
     * Calcula los resultados a partir de los resultados de cada objetivo
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResultTypeObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $itemsResult = $objetive->getChildrens();
        $this->calculateResultItems($result, $itemsResult);
    }
    
    public function resolveObjetiveOfResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = null;
        if($result->getParent() != null){
            $objetive = $result->getParent()->getObjetive();
        }else{
            $objetive = $result->getObjetive();
        }
        return $objetive;
    }
    
    /**
     * Calcula los resultados de los items
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     * @param type $itemsResult
     * @param type $debug
     */
    public function calculateResultItems(\Pequiven\SEIPBundle\Entity\Result\Result &$result,$itemsResult)
    {
        $total = 0;
        $countResult = 0;
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            foreach ($itemsResult as $item) {
                if(method_exists($item, 'getEnabled')){
                    if($item->getEnabled() == false){
                        continue;
                    }
                }
                
                $countResult++;
                $total += $item->getResult();
            }
        }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
            foreach ($itemsResult as $item) {
                if(method_exists($item, 'getEnabled')){
                    if($item->getEnabled() == false){
                        continue;
                    }
                }
                
                $countResult++;
                $total += $item->getResultWithWeight();
            }
        }
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            $total = ($total / $countResult);
        }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
            //Nada que hacer
        }
        
        $result->setTotal($total);
    }
    
    /**
     * Actualiza los resultados de los objetivos
     * @param type $objects
     */
    function updateResultOfObjects($objects,$andFlush = true) 
    {
        if(!is_array($objects) && !is_a($objects, 'Doctrine\ORM\PersistentCollection'))
        {
            $objects = array($objects);
        }
        foreach ($objects as $object) {
            foreach ($object->getResults() as $result) 
            {
                $this->calculateResult($result,$andFlush);
            }
        }
    }
    
    /**
     * Refresca el valor del programa de gestion
     * 
     * @param \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram
     */
    function refreshValueArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram,$andFlush = true)
    {
        $summary = $arrangementProgram->getSummary(array(
            'limitMonthToNow' => true
        ));
        $arrangementProgram->setProgressToDate($summary['advances']);
        $summary = $arrangementProgram->getSummary();
        $arrangementProgram->setTotalAdvance($summary['advances']);
        $em = $this->getDoctrine()->getManager();
        
        $arrangementProgram->updateLastDateCalculateResult();
        
        $em->persist($arrangementProgram);
        
        $this->updateResultOfObjects($arrangementProgram->getObjetiveByType());
        
        if($andFlush){
            $em->flush();
        }
    }
    
    /**
     * Refresca el valor de un indicador
     * 
     * @param Indicator $indicator
     */
    function refreshValueIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator,$andFlush = true)
    {
        $details = $indicator->getDetails();
        if(!$details){
            $details = new \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails();
            $indicator->setDetails($details);
        }
        $previusValue = $indicator->getValueFinal();
        $details
                ->setPreviusValue($previusValue)
                ;
        
        $indicatorService = $this->container->get('pequiven_indicator.service.inidicator');
        
        $formula = $indicator->getFormula();
        if($formula !== null && $indicatorService->validateFormula($formula) === null){
            $typeOfCalculation = $formula->getTypeOfCalculation();
            if($typeOfCalculation == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $this->calculateFormulaSimpleAverage($indicator);
            }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
                $this->calculateFormulaRealPlanAutomatic($indicator);
            }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AUTOMATIC){
                $this->calculateFormulaRealAutomatic($indicator);
            }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_ACCUMULATE){
                $this->calculateFormulaAccumulate($indicator);
            }
        }
        $indicator->updateLastDateCalculateResult();
        
        $em = $this->getDoctrine()->getManager();
        
        
        $em->persist($indicator);
        $em->persist($details);
        if($andFlush){
            $em->flush();
        }
        
        $objetives = $indicator->getObjetives();
        
        $this->getResultService()->updateResultOfObjects($objetives);
    }
    
     /**
     * Calcula la formula con promedio simple
     * 
     * @param Indicator $indicator
     */
    public function calculateFormulaSimpleAverage(Indicator &$indicator) {
        $valuesIndicator = $indicator->getValuesIndicator();
        $quantity = 0;
        $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $quantity++;
            $value += $valueIndicator->getValueOfIndicator();
        }
        $value = ($value / $quantity);
        $indicator->setValueFinal($value);
    }
    
    /**
     * Calcula la formula con plan y real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    public function calculateFormulaRealPlanAutomatic(Indicator &$indicator) 
    {
        $formula = $indicator->getFormula();
        $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
        $variableToRealValueName = $formula->getVariableToRealValue()->getName();
        
        $valuesIndicator = $indicator->getValuesIndicator();
        
        $totalPlan = $totalReal = $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $totalPlan += $formulaParameters[$variableToPlanValueName];
            $totalReal += $formulaParameters[$variableToRealValueName];
        }
        
        $value = $totalReal;
        $indicator
                ->setTotalPlan($totalPlan)
                ->setValueFinal($value);
    }
    
    /**
     * Calcula la formula con real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    public function calculateFormulaRealAutomatic(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
    {
        $formula = $indicator->getFormula();
        $variableToRealValueName = $formula->getVariableToRealValue()->getName();
        
        $valuesIndicator = $indicator->getValuesIndicator();
        
        $totalReal = $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $totalReal += $formulaParameters[$variableToRealValueName];
        }
        
        $value = $totalReal;
        $indicator
            ->setValueFinal($value);
    }
    
    /**
     * Calcula la formula acumulativo de cada valor de resultado
     * 
     * @param Indicator $indicator
     */
    public function calculateFormulaAccumulate(Indicator &$indicator) {
        $valuesIndicator = $indicator->getValuesIndicator();
        $quantity = 0;
        $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $quantity++;
            $value += $valueIndicator->getValueOfIndicator();
        }
        $indicator->setValueFinal($value);
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
