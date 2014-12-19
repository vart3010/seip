<?php

namespace Pequiven\IndicatorBundle\Service;

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
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @param array $data
     * @return int
     */
    public function calculateFormulaValue(\Pequiven\MasterBundle\Entity\Formula $formula,array $data) 
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
        } catch( \ErrorException $exc){
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (\Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result = 0;
        }

        return $result;
    }
    
    /**
     * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * 
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @return type
     */
    public function parseFormulaVars(\Pequiven\MasterBundle\Entity\Formula $formula)
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
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     */
    function validateFormula(\Pequiven\MasterBundle\Entity\Formula &$formula) 
    {
        $typeOfCalculation = $formula->getTypeOfCalculation();
        $variableToRealValue = $formula->getVariableToRealValue();
        $variableToPlanValue = $formula->getVariableToPlanValue();
        $typeOfCalculationLabel = $this->trans($formula->getTypeOfCalculationLabel(),array(),'PequivenIndicatorBundle');
        
        $error = null;
        
        //Si el calculo es por promedio simple
        if($typeOfCalculation == \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE){
            $formula
                ->setVariableToRealValue(null)
                ->setVariableToPlanValue(null)
                ;
        }elseif($typeOfCalculation == \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
            if($variableToRealValue === null || $variableToPlanValue === null){
               $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation',array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Real y Plan'
                ),'flashes');
            }
        }elseif($typeOfCalculation == \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_REAL_AUTOMATIC){
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
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
}
