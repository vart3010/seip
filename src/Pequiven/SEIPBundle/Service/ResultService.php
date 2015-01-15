<?php

namespace Pequiven\SEIPBundle\Service;

use Pequiven\MasterBundle\Entity\Formula;
use Pequiven\IndicatorBundle\Entity\Indicator;

/**
 * Servicio que se encarga de actualizar los resultados
 * 
 * service seip.service.result
 * @author inhack20
 */
class ResultService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $container;
 
    /**
     * Devuelve un resultado por el tipo
     * @param array $results Pequiven\SEIPBundle\Model\Result
     * @param int $type Pequiven\SEIPBundle\Model\Result::TYPE_RESULT_*
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
    private function updateResultOfObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$myResult,$andFlush = true)
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
    public function calculateResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result,$andFlush = true) {
        $em = $this->getDoctrine()->getManager();
        
        if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
            $this->calculateResultTypeArrangementPrograms($result);
        }elseif($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_INDICATOR){
            $this->calculateResultTypeIndicator($result);
        }elseif($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE){
            $this->calculateResultTypeObjetive($result);
        }
        
        if($result->getParent() == null && $result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
            $parent = $result;
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());
            
            $em->persist($parent);
            
            
        }
        if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
            if($result->getParent() == null){
                $parent = $result;
            }else{
                $parent = $result->getParent();
            }
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
    private function calculateResultTypeArrangementPrograms(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
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
    private function calculateResultTypeIndicator(\Pequiven\SEIPBundle\Entity\Result\Result &$result) 
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
    private function calculateResultTypeObjetive(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetive = $this->resolveObjetiveOfResult($result);
        $itemsResult = $objetive->getChildrens();
        $this->calculateResultItems($result, $itemsResult);
    }
    
    private function resolveObjetiveOfResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
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
    private function calculateResultItems(\Pequiven\SEIPBundle\Entity\Result\Result &$result,$itemsResult)
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
    public function updateResultOfObjects($objects,$andFlush = true) 
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
    public function refreshValueArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram,$andFlush = true)
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
    public function refreshValueIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator,$andFlush = true)
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
        
        $indicatorService = $this->getIndicatorService();
        
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
            }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                $this->calculateFormulaRealPlanAutomaticFromEQ($indicator);
            }
        }
        $indicator->updateLastDateCalculateResult();
        $tendenty = $indicator->getTendency();
        if($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MAX){
            
        }else if($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MIN){//Decreciente
            $result = $indicator->getTotalPlan() - $indicator->getResult();
            $indicator->setProgressToDate($result);
        }
        
        $em = $this->getDoctrine()->getManager();
        
        
        $em->persist($indicator);
        $em->persist($details);
        if($andFlush){
            $em->flush();
        }
        
        $objetives = $indicator->getObjetives();
        
        $this->updateResultOfObjects($objetives);
    }
    
     /**
     * Calcula la formula con promedio simple
     * 
     * @param Indicator $indicator
     */
     private function calculateFormulaSimpleAverage(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
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
    private function calculateFormulaRealPlanAutomatic(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
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
     * Calcula la formula con plan y real automatico a partir de equaciones de las formulas
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomaticFromEQ(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
    {
        $indicatorService = $this->getIndicatorService();
        
        $formula = $indicator->getFormula();
        
        $sourceEquationPlan = $indicatorService->parseFormulaVars($formula,$formula->getSourceEquationPlan());
        $sourceEquationReal = $indicatorService->parseFormulaVars($formula,$formula->getSourceEquationReal());
        
        $equation_real = $equation_plan = 0.0;
        
        $valuesIndicator = $indicator->getValuesIndicator();
        $totalPlan = $totalReal = $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            
            foreach ($formulaParameters as $name => $value) {
                $$name = 0;
                if(isset($formulaParameters[$name])){
                    $$name = $value;
                }
            }
            
            eval(sprintf('$equation_real = %s;',$sourceEquationReal));
            eval(sprintf('$equation_plan = %s;',$sourceEquationPlan));
            
            $totalPlan += $equation_plan;
            $totalReal += $equation_real;
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
    private function calculateFormulaRealAutomatic(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
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
    private function calculateFormulaAccumulate(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) {
        $valuesIndicator = $indicator->getValuesIndicator();
        $quantity = 0;
        $value = 0.0;
        foreach ($valuesIndicator as $valueIndicator) {
            $quantity++;
            $value += $valueIndicator->getValueOfIndicator();
        }
        $indicator->setValueFinal($value);
    }
    
    public function getResultChildresObjetives(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive,$childrens) {
        $myProgress = $myContribution = $myContributionWithWeight = $myDuty = $myDutyWithWeight = 0.0;
        $result = $this->getResultByType($objetive->getResults(),  \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OBJECTIVE);
        $countMyChildrens = count($childrens);
        $countAllChildrens = count($objetive->getChildrens());
        if($result){
            $this->calculateResultItems($result, $childrens);
            $myProgress = $result->getResult();
            $weight = $result->getWeight();
            if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $myContribution = (($myProgress * $countMyChildrens) / $countAllChildrens);
                $myContributionWithWeight = ((($myProgress * $countMyChildrens) / $countAllChildrens) * $weight) / 100;
                $myDuty = (100 / $countAllChildrens) * $countMyChildrens;
                $myDutyWithWeight = ($myDuty * $weight / 100);
            }else{
                $totalWeight = 0.0;
                foreach ($childrens as $child) {
                    $totalWeight +=$child->getWeight();
                }
                $myContribution = $myProgress;
                $myContributionWithWeight = ($myProgress * $weight) / 100;
                $myDuty = $totalWeight;
                $myDutyWithWeight = ($totalWeight * $weight ) / 100;
                
            }
        }
        
        return array(
            'myProgress' => $myProgress,
            'myContribution' => $myContribution,
            'myContributionWithWeight' => $myContributionWithWeight,
            'myDuty' => $myDuty,//Mi deber
            'myDutyWithWeight' => $myDutyWithWeight,//Mi deber con peso
        );
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
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
    protected function getUser()
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
    
    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    private function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
