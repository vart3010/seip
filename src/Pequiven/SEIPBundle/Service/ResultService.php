<?php

namespace Pequiven\SEIPBundle\Service;

use Pequiven\MasterBundle\Entity\Formula;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\Tendency;
use Pequiven\MasterBundle\Entity\ArrangementRangeType;
use Pequiven\MasterBundle\Entity\Operator;

/**
 * Servicio que se encarga de actualizar los resultados
 * 
 * service seip.service.result
 * @author inhack20
 */
class ResultService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $errors;
    
    protected $container;
    
    public function __construct() {
        $this->errors = array();
    }
    
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
        
        if($result->getParent() !== null && $result->getTypeResult() !== \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
            $parent = $result->getParent();
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());
            
            $em->persist($parent);
        }else if($result->getParent() == null && $result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
            $parent = $result;
            foreach ($result->getChildrens() as $child) {
                $this->calculateResult($child);
            }
            $this->calculateResultItems($parent, $parent->getChildrens());
            $em->persist($parent);
        }else if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_OF_RESULT){
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
                    if(!$arrangementProgram->isAvailableInResult()){
                        continue;
                    }
                    $countResult++;
                    $total += $arrangementProgram->getResult();
                }
            }
        }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
            //Fix error al configurar mal la regla del resultado en el PG
            $em = $this->getDoctrine()->getManager();
            $indicators = $objetive->getIndicators();
            foreach ($arrangementPrograms as $value) {
                $value->clearLastDateCalculateResult();
                $em->persist($value);
            }
            foreach ($indicators as $value) {
                $value->clearLastDateCalculateResult();
                $em->persist($value);
            }
            $em->flush();
            throw new \LogicException(sprintf('Los programas de gestion no se calculan con promedio ponderado, revise el resultado con id "%s"',$result->getId()));
        }
        
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            if($countResult == 0){//Fix division por cero
                $countResult = 1;
            }
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
                if(!$item->isAvailableInResult()){
                    continue;
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
                if(!$item->isAvailableInResult()){
                    continue;
                }
                
                $countResult++;
                $total += $item->getResultWithWeight();
            }
        }
        if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
            //Fix division por cero
            if($countResult == 0){
                $countResult = 1;
            }
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
        if($objects === null){
            return;
        }
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
        $arrangementRangeService = $this->getArrangementRangeService();

        $formula = $indicator->getFormula();
        if($formula !== null && $indicatorService->validateFormula($formula) === null){
            $typeOfCalculation = $formula->getTypeOfCalculation();
            if($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_MANUALLY){
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
            }else{
                $this->calculateFormulaRealPlanAutomaticFromChild($indicator);
            }
        }
        
        $indicator->updateLastDateCalculateResult();
        $tendenty = $indicator->getTendency();
        if(!$tendenty){
            throw new \LogicException(sprintf('El indicador "%s(%s)" no tiene una tendencia definida.',$indicator->getRef(),$indicator->getId()));
        }
        $arrangementRange = $indicator->getArrangementRange();
        if(!$arrangementRange){
            throw new \LogicException(sprintf('El indicador "%s(%s)" no tiene un rango de gestión definido.',$indicator->getRef(),$indicator->getId()));
        }
        if($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MAX){
            $result = $indicator->getResult();
            $indicator->setResultReal($result);
            
            if($arrangementRangeService->validateArrangementRange($arrangementRange, $tendenty) == null){
                if($this->calculateRangeGood($indicator,$tendenty)){//Rango Verde R*100% (Máximo 100)
                    if($result > 100){
                        $result = 100;
                    }
                } else if($this->calculateRangeMiddle($indicator,$tendenty)){//Rango Medio R*50%
                    $result = $result/2;
                } else if($this->calculateRangeBad($indicator,$tendenty)){//Rango Rojo R*0%
                    $result = 0;
                }
            }
            
            $indicator->setProgressToDate($result);
        }else if($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_MIN){//Decreciente
            $result = 100 - $indicator->getResult();
            $indicator->setResultReal($result);
            
            if($arrangementRangeService->validateArrangementRange($arrangementRange, $tendenty) == null){
                if($this->calculateRangeGood($indicator,$tendenty)){//Rango Verde R*100% (Máximo 100)
                    if($result > 100){
                        $result = 100;
                    }
                } else if($this->calculateRangeMiddle($indicator,$tendenty)){//Rango Medio R*50%
                    $result = $result/2;
                } else if($this->calculateRangeBad($indicator,$tendenty)){//Rango Rojo R*0%
                    $result = 0;
                }
            }
            
            $indicator->setProgressToDate($result);
        }else if($tendenty->getRef() == \Pequiven\MasterBundle\Model\Tendency::TENDENCY_EST){
            $result = $indicator->getResult();
            $indicator->setResultReal($result);
            
            if($arrangementRangeService->validateArrangementRange($arrangementRange, $tendenty) == null){
                if($this->calculateRangeGood($indicator,$tendenty)){//Rango Verde R*100% (Máximo 100)
                    if($result > 100){
                        $result = 100;
                    }
                } else if($this->calculateRangeMiddle($indicator,$tendenty)){//Rango Medio R*50%
                    $result = $result/2;
                } else if($this->calculateRangeBad($indicator,$tendenty)){//Rango Rojo R*0%
                    $result = 0;
                }
            }
            
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
        
        if($indicator->getParent() !== null){
            $this->refreshValueIndicator($indicator->getParent(),true);
        }
    }
    
    /**
     * Cálculo de Rango Verde para los Indicadores con tendencia Estable
     * @param type $result
     * @return boolean
     */
    private function calculateRangeGood(Indicator &$indicator, Tendency &$tendency){
        $arrangementRange = $indicator->getArrangementRange();
        $result = $indicator->getResult();
        $isGood = false;
        
        if($tendency->getRef() == Tendency::TENDENCY_EST){
            if(strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                if($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                    $isGood = true;
                }
            } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                if($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                    $isGood = true;
                }
            } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                if($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                    $isGood = true;
                }
            } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                if($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                    $isGood = true;
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MAX){
            if($arrangementRange->getTypeRangeTop() == ArrangementRangeType::RANGE_TYPE_TOP_BASIC){
                if(strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankTopBasic()){
                        $isGood = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0){
                    if($result > $arrangementRange->getRankTopBasic()){
                        $isGood = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankTopBasic()){
                        $isGood = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeTop() == ArrangementRangeType::RANGE_TYPE_TOP_MIXED){
                if(strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                        $isGood = true;
                    }
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MIN){
            if($arrangementRange->getTypeRangeBottom() == ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC){
                if(strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankBottomBasic()){
                        $isGood = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result < $arrangementRange->getRankBottomBasic()){
                        $isGood = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result <= $arrangementRange->getRankBottomBasic()){
                        $isGood = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeBottom() == ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED){
                if(strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()){
                        $isGood = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()){
                        $isGood = true;
                    }
                }
            }
        }

        return $isGood;
    }
    
    /**
     * Cálculo de Rango Amarillo para los Indicadores con tendencia Estable
     * @param type $result
     * @return boolean
     */
    private function calculateRangeMiddle(Indicator &$indicator, Tendency &$tendency){
        $arrangementRange = $indicator->getArrangementRange();
        $result = $indicator->getResult();
        $isMiddle = false;
        
        if($tendency->getRef() == Tendency::TENDENCY_EST){
            if(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                    $isMiddle = true;
                }
            }
            if(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                    $isMiddle = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                    $isMiddle = true;
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MAX){
            if($arrangementRange->getTypeRangeMiddleTop() == ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC || $arrangementRange->getTypeRangeMiddleBottom() == ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC){
                if(strcmp($arrangementRange->getOpRankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankMiddleTopBasic() || $result == $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankMiddleTopBasic()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOprankMiddleBottomBasic()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopBasic() && $result < $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankMiddleTopBasic() && $result <= $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankMiddleTopBasic() && $result < $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankMiddleTopBasic() && $result <= $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleTop() == ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED || $arrangementRange->getTypeRangeMiddleBottom() == ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED){
                if(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                }
                if(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MIN){
            if($arrangementRange->getTypeRangeMiddleTop() == ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_BASIC || $arrangementRange->getTypeRangeMiddleBottom() == ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_BASIC){
                if(strcmp($arrangementRange->getOpRankMiddleTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankMiddleTopBasic() || $result == $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankMiddleTopBasic()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOprankMiddleBottomBasic()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopBasic() && $result < $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankMiddleTopBasic() && $result <= $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankMiddleTopBasic() && $result < $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                } elseif($arrangementRange->getOprankMiddleTopBasic()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOprankMiddleBottomBasic()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankMiddleTopBasic() && $result <= $arrangementRange->getRankMiddleBottomBasic()){
                        $isMiddle = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeMiddleTop() == ArrangementRangeType::RANGE_TYPE_MIDDLE_TOP_MIXED || $arrangementRange->getTypeRangeMiddleBottom() == ArrangementRangeType::RANGE_TYPE_MIDDLE_BOTTOM_MIXED){
                if(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result < $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleBottomMixedTop() && $result <= $arrangementRange->getRankMiddleBottomMixedBottom()){
                        $isMiddle = true;
                    }
                }
                if(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result > $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result < $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                } elseif(strcmp($arrangementRange->getOpRankMiddleTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankMiddleTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankMiddleTopMixedTop() && $result <= $arrangementRange->getRankMiddleTopMixedBottom()){
                        $isMiddle = true;
                    }
                }
            }
        }

        return $isMiddle;
    }
    
    /**
     * Cálculo de Rango Rojo para los Indicadores con tendencia Estable
     * @param type $result
     * @return boolean
     */
    private function calculateRangeBad(Indicator &$indicator, Tendency &$tendency){
        $arrangementRange = $indicator->getArrangementRange();
        $result = $indicator->getResult();
        
        $isBad = false;

        if($tendency->getRef() == Tendency::TENDENCY_EST){
            if(strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0){
                if($result < $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()){
                    $isBad = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0){
                if($result <= $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()){
                    $isBad = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0){
                if($result < $arrangementRange->getRankBottomMixedBottom() || $result > $arrangementRange->getRankBottomMixedTop()){
                    $isBad = true;
                }
            } elseif(strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0){
                if($result <= $arrangementRange->getRankBottomMixedBottom() || $result >= $arrangementRange->getRankBottomMixedTop()){
                    $isBad = true;
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MAX){
            if($arrangementRange->getTypeRangeBottom() == ArrangementRangeType::RANGE_TYPE_BOTTOM_BASIC){
                if(strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankBottomBasic()){
                        $isBad = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result < $arrangementRange->getRankBottomBasic()){
                        $isBad = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankBottomBasic()->getRef(), Operator::REF_OPERATOR_SMALLER_EQUAL_THAN) == 0){
                    if($result <= $arrangementRange->getRankBottomBasic()){
                        $isBad = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeBottom() == ArrangementRangeType::RANGE_TYPE_BOTTOM_MIXED){
                if(strcmp($arrangementRange->getOpRankBottomMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankBottomMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankBottomMixedTop() && $result < $arrangementRange->getRankBottomMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankBottomMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankBottomMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankBottomMixedTop() && $result <= $arrangementRange->getRankBottomMixedBottom()){
                        $isBad = true;
                    }
                }
            }
        } elseif($tendency->getRef() == Tendency::TENDENCY_MIN){
            if($arrangementRange->getTypeRangeTop() == ArrangementRangeType::RANGE_TYPE_TOP_BASIC){
                if(strcmp($arrangementRange->getOpRankTopBasic()->getRef(), Operator::REF_OPERATOR_EQUAL) == 0){
                    if($result == $arrangementRange->getRankTopBasic()){
                        $isBad = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_THAN) == 0){
                    if($result > $arrangementRange->getRankTopBasic()){
                        $isBad = true;
                    }
                } elseif(strcmp($arrangementRange->getOprankTopBasic()->getRef(), Operator::REF_OPERATOR_HIGHER_EQUAL_THAN) == 0){
                    if($result >= $arrangementRange->getRankTopBasic()){
                        $isBad = true;
                    }
                }
            } elseif($arrangementRange->getTypeRangeTop() == ArrangementRangeType::RANGE_TYPE_TOP_MIXED){
                if(strcmp($arrangementRange->getOpRankTopMixedTop()->getRef(),Operator::REF_OPERATOR_HIGHER_THAN) == 0 && strcmp($arrangementRange->getOpRankTopMixedBottom()->getRef(),Operator::REF_OPERATOR_SMALLER_THAN) == 0){
                    if($result > $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result > $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_THAN){
                    if($result >= $arrangementRange->getRankTopMixedTop() && $result < $arrangementRange->getRankTopMixedBottom()){
                        $isBad = true;
                    }
                } elseif($arrangementRange->getOpRankTopMixedTop()->getRef() == Operator::REF_OPERATOR_HIGHER_EQUAL_THAN && $arrangementRange->getOpRankTopMixedBottom()->getRef() == Operator::REF_OPERATOR_SMALLER_EQUAL_THAN){
                    if($result >= $arrangementRange->getRankTopMixedTop() && $result <= $arrangementRange->getRankTopMixedBottom()){
                        $isBad = true;
                    }
                }
            }
        }
        
        return $isBad;
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
        if($quantity == 0){//Fix error de division por cero.
            $quantity = 1;
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
//        if($indicator->getParent() !== null){
//            $this->refreshValueIndicator($indicator->getParent());
//        }
    }
    
    /**
     * Calcula la formula con plan y real a partir de la formula
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomaticFromChild(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
    {
        $childrens = $indicator->getChildrens();
        $indicatorService = $this->getIndicatorService();
        
        $resultsItems = array();
        foreach ($childrens as $child) {
            $i = 0;
            $formula = $child->getFormula();
            
            foreach ($child->getValuesIndicator() as $valueIndicator) {
                if(!isset($resultsItems[$i])){
                    $resultsItems[$i] = array('plan' => 0.0,'real' => 0.0);
                }
                $plan = $real = 0.0;
                $formulaParameters = $valueIndicator->getFormulaParameters();
                
                    if($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
                        $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
                        $variableToRealValueName = $formula->getVariableToRealValue()->getName();
                        $plan = $formulaParameters[$variableToPlanValueName];
                        $real = $formulaParameters[$variableToRealValueName];
                    }elseif($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                        $result = $this->getFormulaResultFromEQ($formula, $formulaParameters);
                        $plan = $result['plan'];
                        $real = $result['real'];
                    }
                
                $resultsItems[$i]['plan'] = $resultsItems[$i]['plan'] + $plan;
                $resultsItems[$i]['real'] = $resultsItems[$i]['real'] + $real;
                $i++;
                
            }//fin for each
        }//fin for each childrens
        
        $totalPlan = $totalReal = 0.0;
        //Calcular el total plan y real.
        foreach ($resultsItems as $resultItem) {
            $totalPlan += $resultItem['plan'];
            $totalReal += $resultItem['real'];
        }
        $frequencyNotificationIndicator = $indicator->getFrequencyNotificationIndicator();
        
        //Actualizar valores de los resultados del indicador padre.
        $formula = $indicator->getFormula();
        $variableToPlanValueName = $formula->getVariableToPlanValue()->getName();
        $variableToRealValueName = $formula->getVariableToRealValue()->getName();
        
        $valuesIndicator = $indicator->getValuesIndicator();
        if(count($valuesIndicator) != $frequencyNotificationIndicator->getNumberResultsFrequency()){
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            foreach ($indicator->getValuesIndicator() as $valueIndicator) {
                $indicator->removeValuesIndicator($valueIndicator);
                $em->remove($valueIndicator);
            }
            $em->flush();
            
            for($i= 0;$i < $frequencyNotificationIndicator->getNumberResultsFrequency();$i++){
                $valueIndicator = new Indicator\ValueIndicator();
                $valueIndicator
                    ->setFormula($formula)
                    ->setCreatedBy($user)
                ;
                $indicator->addValuesIndicator($valueIndicator);
            }
        }
        $i = 0;
        foreach ($indicator->getValuesIndicator() as $valueIndicator) {
            $formulaUsed = $valueIndicator->getFormula();
            $formulaParameters = $valueIndicator->getFormulaParameters();
            $plan = $real = 0.0;
            if(isset($resultsItems[$i])){
                $plan = $resultsItems[$i]['plan'];
                $real = $resultsItems[$i]['real'];
            }
            $valueIndicator->setParameter($variableToPlanValueName, $plan);
            $valueIndicator->setParameter($variableToRealValueName, $real);
            $value = $indicatorService->calculateFormulaValue($formulaUsed, $valueIndicator->getFormulaParameters());
            $valueIndicator->setValueOfIndicator($value);
            $i++;
        }
//        var_dump($totalPlan);
//        var_dump($totalReal);
//        die;
        $indicator
            ->setTotalPlan($totalPlan)
            ->setValueFinal($totalReal);
    }
    
    /**
     * Calcula la formula con plan y real automatico a partir de equaciones de las formulas
     * 
     * @param Indicator $indicator
     */
    private function calculateFormulaRealPlanAutomaticFromEQ(\Pequiven\IndicatorBundle\Entity\Indicator &$indicator) 
    {
        $formula = $indicator->getFormula();
        
        $valuesIndicator = $indicator->getValuesIndicator();
        $totalPlan = $totalReal = $value = $equation_real = $equation_plan = 0.0;
        
        foreach ($valuesIndicator as $valueIndicator) {
            $formulaParameters = $valueIndicator->getFormulaParameters();
            
            $result = $this->getFormulaResultFromEQ($formula, $formulaParameters);
            $totalPlan += $result['plan'];
            $totalReal += $result['real'];
        }
        
        $value = $totalReal;
        $indicator
                ->setTotalPlan($totalPlan)
                ->setValueFinal($value);
    }
    
    private function getFormulaResultFromEQ(Formula $formula,$formulaParameters)
    {
        $equation_real = $equation_plan = 0.0;
        
        $indicatorService = $this->getIndicatorService();
        $sourceEquationPlan = $indicatorService->parseFormulaVars($formula,$formula->getSourceEquationPlan());
        $sourceEquationReal = $indicatorService->parseFormulaVars($formula,$formula->getSourceEquationReal());
        
        foreach ($formulaParameters as $name => $value) {
                $$name = 0;
                if(isset($formulaParameters[$name])){
                    $$name = $value;
                }
            }
            
        eval(sprintf('$equation_real = %s;',$sourceEquationReal));
        eval(sprintf('$equation_plan = %s;',$sourceEquationPlan));
        
        return array(
            'real' => $equation_real,
            'plan' => $equation_plan,
        );
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
    
    /**
     * Obtiene el resumen del resultado de mis hijos
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @param type $childrens
     * @return type
     */
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
     * Valida que los objetivos tengan avances
     * @param array $objetives
     * @return boolean
     */
    public function validateAdvanceOfObjetives($objetives,$valid = true) {
        
        $limitErrors = 10;
//        var_dump('Pasados - '.count($objetives));
        foreach ($objetives as $objetive) {
            $childrens = $objetive->getChildrens();
//            var_dump('Padre - '.$objetive->getRef().' - Hijos - '.count($childrens));
            $arrangementPrograms = $objetive->getArrangementPrograms();
            //Se evalua que los programas de gestion tengan notificacion.
            foreach ($arrangementPrograms as $arrangementProgram) {
                $details = $arrangementProgram->getDetails();
                $url = $this->generateUrl('pequiven_seip_arrangementprogram_show',
                    array(
                        'id' => $arrangementProgram->getId()
                    ),\Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
                );
                $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$arrangementProgram);
                //Se evalua que la notificacion no este en progeso
                if($details->getNotificationInProgressByUser() !== null){
                    $this->addErrorTrans('pequiven_seip.errors.user_must_complete_notification_process_management_program',array(
                        '%user%' => $details->getNotificationInProgressByUser(),
                        '%arrangementProgram%' => $link,
                    ));
                    $valid = false;
                    continue;
                }
                //Se evalua que no tenga avance cargado
                if($details->getLastNotificationInProgressByUser()  === null && $arrangementProgram->getResult() == 0){
                    $this->addErrorTrans('pequiven_seip.errors.the_management_program_does_not_progress_loaded',array(
                        '%arrangementProgram%' => $link,
                    ));
                    $valid = false;
                }
            }
            
            $indicators = $objetive->getIndicators();
            foreach ($indicators as $indicator) {
                if($indicator->hasNotification() === false){
                    $url = $this->generateUrl('pequiven_indicator_show',
                        array(
                            'id' => $indicator->getId()
                        ),\Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
                    );
                    $link = sprintf('<a href="%s" target="_blank">%s</a>',$url,$indicator);
                    $this->addErrorTrans('pequiven_seip.errors.the_indicator_has_not_loaded_values',array(
                        '%indicator%' => $link,
                    ));
                    $valid = false;
                }
            }
            
            if(count($childrens) > 0){
                $valid =  $this->validateAdvanceOfObjetives($childrens,$valid);
            }
            if(!$valid && count($this->errors) > $limitErrors){
                return false;
            }
        }
        return $valid;
    }
    
    private function addErrorTrans($error,array $parameters = array()) {
        if(is_array($error)){
            $this->errors = array_merge($this->errors,$error);
        }else{
            $message = $this->trans($error,$parameters,'PequivenSEIPBundle');
            $this->errors[md5($message)] = $message;
        }
    }
    
    function getErrors() {
        return $this->errors;
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
    
    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService()
    {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * Generates a URL from the given parameters.
     *
     * @param string         $route         The name of the route
     * @param mixed          $parameters    An array of parameters
     * @param bool|string    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }
    
    function generateAsset($path,$packageName = null){
        return $this->container->get('templating.helper.assets')
               ->getUrl($path, $packageName);
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
}
