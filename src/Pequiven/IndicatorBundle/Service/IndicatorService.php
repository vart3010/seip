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
        $sourceEquationReal = $sourceEquationPlan = 0.0;
        if($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
            $sourceEquationPlan = $this->parseFormulaVars($formula,$formula->getSourceEquationPlan());
            $sourceEquationReal = $this->parseFormulaVars($formula,$formula->getSourceEquationReal());
        }
        $equationParse = $this->parseFormulaVars($formula,$formula->getEquationReal());
        $result = $equation_real = $equation_plan = 0.0;
        try {
            eval(sprintf('$equation_real = %s;',$sourceEquationReal));
            eval(sprintf('$equation_plan = %s;',$sourceEquationPlan));
            eval(sprintf('$result = @%s;',$equationParse));
        } catch( ErrorException $exc){
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result = 0.0;
        }
        return $result;
    }
    
    /**
     * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * 
     * @param Formula $formula
     * @return type
     */
    public function parseFormulaVars(Formula $formula,$equationReal)
    {
        $especialCaracter = array(
            '(',
            ')',
            '+',
            '-',
            '*',
            '/',
            ' ',
            '  ',
            '   ',
        );
        $numbers = array('0','1','2','3','4','5','6','7','8','9');
//        $equationReal = '6 + ( num_hoja_entrada_servicios_entregadas / num_valuaciones_solicitadas ) * 100 + casa - 1';
        $stringSplit = str_split($equationReal);
        $newEquation = $varEquation = '';
        foreach ($stringSplit as $key => $char) {
            if(in_array($char, $especialCaracter,true)){
                $newEquation .= $char;
                continue;
            }
            $nextKey = $key + 1;
            $nextChar = isset($stringSplit[$nextKey]) ? $stringSplit[$nextKey] : null;
            $varEquation .= $char;
            if(in_array($nextChar, $especialCaracter,true)){
                if(in_array($varEquation[0], $numbers)){
                }else{
                    $newEquation .= '$';
                }
                $newEquation .= $varEquation;
                $varEquation = '';
            }
        }
        if(strlen($varEquation) > 0){//Se adjunta lo que queda de la formula que no contiene variable
            if(in_array($varEquation[0], $numbers)){
            }else{
                $newEquation .= '$';
            }
            $newEquation .= $varEquation;
        }
        $formulaPaser = $newEquation;
        
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
        $sourceEquationPlan = $formula->getSourceEquationPlan();
        $sourceEquationReal = $formula->getSourceEquationReal();
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
        }elseif($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
             $formula
                ->setVariableToPlanValue(null)
                ->setVariableToRealValue(null)
                ;
            if($sourceEquationPlan === null || $sourceEquationReal === null){
                $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation',array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Origen de ecuación real y Origen de ecuación del plan'
                ),'flashes');
            }
        }
        return $error;
    }
    
    function validateIndicatorParent(Indicator $indicator)
    {
        $formula = $indicator->getFormula();
        $error = null;
        if($formula != null){
            if($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_AUTOMATIC && 
                $formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC 
                    && $formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ
                ){
                $error = $this->trans('pequiven_indicator.errors.not_support_formula_parent',array(),'PequivenIndicatorBundle');
            }
            if($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                $variables = $formula->getVariables();
                if(count($variables) != 2){
                    $error = $this->trans('pequiven_indicator.errors.the_formula_should_only_have_two_defined_variables',array(),'PequivenIndicatorBundle');
                }else{
                    $findVariables = 0;
                    foreach ($variables as $variable) {
                        if($variable->getName() == Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN){
                            $findVariables++;
                        }else if($variable->getName() == Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL){
                            $findVariables++;
                        }
                    }
                }
                if($findVariables != 2){
                    $error = $this->trans('pequiven_indicator.errors.the_formula_must_have_the_variables_defined_plan_and_real',array(),'PequivenIndicatorBundle');
                }
            }
        }else{
            $error = $this->trans('pequiven_indicator.errors.formula_unassigned',array(),'PequivenIndicatorBundle');
        }
        return $error;
    }
    
    /**
     * Valida que el indicator hijo sea compatible para calcular resultados de formula automatico.
     * @param Indicator $indicator
     * @return type
     */
    function validateChildOfParent(Indicator $indicator) 
    {
        $error = null;
        $parent = $indicator->getParent();
        $formula = $parent->getFormula();
        $frequencyNotificationIndicator = $indicator->getFrequencyNotificationIndicator();
        
        if($formula != null){
            if($formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC 
                    && $formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ
                ){
                $error = $this->trans('pequiven_indicator.errors.not_support_formula_parent',array(),'PequivenIndicatorBundle');
            }
        }else{
            $error = $this->trans('pequiven_indicator.errors.formula_unassigned_parent',array(),'PequivenIndicatorBundle');
        }
        $tendency = $parent->getTendency();
        if($error === null){
            if($indicator->getFrequencyNotificationIndicator() !== null){
                if($parent->getFrequencyNotificationIndicator() !== $frequencyNotificationIndicator)
                {
                    $error = $this->trans('pequiven_indicator.errors.assigned_frequency_not_support',array(),'PequivenIndicatorBundle');
                }else{
                    $formulaChild = $indicator->getFormula();
                    if($formulaChild !== null){
                        if($formulaChild->getTypeOfCalculation() === Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC || $formulaChild->getTypeOfCalculation() === Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                            if($indicator->getTendency() !== $tendency){
                                $error = $this->trans('pequiven_indicator.errors.trends_should_be_equal',array(),'PequivenIndicatorBundle');
                            }
                        }else{
                            $error = $this->trans('pequiven_indicator.errors.not_support_formula',array(),'PequivenIndicatorBundle');
                        }
                    }else{
                        $error = $this->trans('pequiven_indicator.errors.formula_unassigned',array(),'PequivenIndicatorBundle');
                    }
                }
            }else{
                $error = $this->trans('pequiven_indicator.errors.frequency_not_assigned_parent',array(),'PequivenIndicatorBundle');
            }
        }
        
        return $error;
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
