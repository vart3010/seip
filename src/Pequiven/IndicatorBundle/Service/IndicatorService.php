<?php

namespace Pequiven\IndicatorBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\Formula;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el indicador
 * 
 * @service pequiven_indicator.service.inidicator
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorService implements ContainerAwareInterface
{
    private $container;
    
    /**
     * Toma un string de una formula y realiza el parse a php para calcularlo
     * @param Formula $formula
     * @param array $data
     * @return int
     */
    public function calculateFormulaValue(Formula $formula,array $data) 
    {
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if(isset($data[$name])){
                $$name = $data[$name];
            }
        }
        $equationParse = $this->parseFormulaVars($formula);
//        var_dump($equationParse);
        $result = 0;
        try {
            eval(sprintf('$result = %s;',$equationParse));
        } catch( ErrorException $exc){
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result = 0;
        }

        return $result;
    }
    
    /**
     * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * 
     * @param Formula $formula
     * @return type
     */
    public function parseFormulaVars(Formula $formula)
    {
        $equationReal = $formula->getEquationReal();
        $variables = $formula->getVariables();
        $formulaPaser = $equationReal;
        foreach ($variables as $variable) {
            $name = $variable->getName();
            if(preg_match('/'.$name.'/i', $formulaPaser)){
                $formulaPaser = preg_replace('/'.$name.'/i', '$'.$name, $formulaPaser);
            }
        }
        return $formulaPaser;
    }
    
    /**
     * Valida la configuracion de una formula
     * @param Formula $formula
     */
    function validateFormula(Formula &$formula) 
    {
        $typeOfCalculation = $formula->getTypeOfCalculation();
        $variableToRealValue = $formula->getVariableToRealValue();
        $variableToPlanValue = $formula->getVariableToPlanValue();
        $typeOfCalculationLabel = $this->trans($formula->getTypeOfCalculationLabel(),array(),'PequivenIndicatorBundle');
        
        $error = null;
        
        //Si el calculo es por promedio simple o acumulativo
        if($typeOfCalculation == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE || $typeOfCalculation == Formula::TYPE_CALCULATION_ACCUMULATE){
            $formula
                ->setVariableToRealValue(null)
                ->setVariableToPlanValue(null)
                ;
        }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
            if($variableToRealValue === null || $variableToPlanValue === null){
               $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation',array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Real y Plan'
                ),'flashes');
            }
        }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AUTOMATIC){
             $formula
                ->setVariableToPlanValue(null)
                ;
            if($variableToRealValue === null){
                $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation',array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Real'
                ),'flashes');
            }
        }
        return $error;
    }
    
    /**
     * Calcula el valor de un indicador
     * 
     * @param Indicator $indicator
     */
    function calculateValueIndicator(Indicator $indicator)
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
        $formula = $indicator->getFormula();
        if($formula !== null && $this->validateFormula($formula) === null){
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
        
        $em->flush();
        
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
    public function calculateFormulaRealAutomatic(Indicator &$indicator) 
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
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}
