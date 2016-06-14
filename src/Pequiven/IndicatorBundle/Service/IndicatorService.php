<?php

namespace Pequiven\IndicatorBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\MasterBundle\Entity\Formula;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el indicador
 * 
 * service pequiven_indicator.service.inidicator
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class IndicatorService implements ContainerAwareInterface {

    private $container;

    /**
     * Toma un string de una formula y realiza el parse a php para calcularlo
     * @param Formula $formula
     * @param array $data
     * @return int
     */
    public function calculateFormulaValue(Formula $formula, $data) {
        if (!is_array($data)) {
            $data = array();
        }
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if (isset($data[$name])) {
                $$name = $data[$name];
            }
        }
        $sourceEquationReal = $sourceEquationPlan = 0.0;
        if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
            $sourceEquationPlan = $this->parseFormulaVars($formula, $formula->getSourceEquationPlan());
            $sourceEquationReal = $this->parseFormulaVars($formula, $formula->getSourceEquationReal());
        }
        $equationParse = $this->parseFormulaVars($formula, $formula->getEquationReal());
        $result = $equation_real = $equation_plan = 0.0;
        try {
            @eval(sprintf('$equation_real = %s;', $sourceEquationReal));
            @eval(sprintf('$equation_plan = %s;', $sourceEquationPlan));
            @eval(sprintf('$result = @%s;', $equationParse));
        } catch (ErrorException $exc) {
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result = 0.0;
        }
        return $result;
    }

    /**
     * 
     * @param Formula $formula
     * @param array $data
     * @return type
     */
    public function calculateFormulaValueFromDashboardEquation(Formula $formula, $data) {
        if (!is_array($data)) {
            $data = array();
        }
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if (isset($data[$name])) {
                $$name = $data[$name];
            }
        }
        $dashboardEquationReal = $dashboardEquationPlan = 0.0;
        $result = array();

        $dashboardEquationReal = $this->parseFormulaVars($formula, $formula->getDashboardEquationReal());
        $dashboardEquationPlan = $this->parseFormulaVars($formula, $formula->getDashboardEquationPlan());

        $result_equation_real = $result_equation_plan = 0.0;
        try {
            @eval(sprintf('$result_equation_real = %s;', $dashboardEquationReal));
            @eval(sprintf('$result_equation_plan = %s;', $dashboardEquationPlan));
        } catch (ErrorException $exc) {
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result_equation_real = $result_equation_plan = 0.0;
        }

        $result['dashboardEquationReal'] = $result_equation_real;
        $result['dashboardEquationPlan'] = $result_equation_plan;

        return $result;
    }

    /**
     * 
     * @param Formula $formula
     * @param array $data
     * @return type
     */
    public function calculateFormulaValueFromSourceEquation(Formula $formula, $data) {
        if (!is_array($data)) {
            $data = array();
        }
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if (isset($data[$name])) {
                $$name = $data[$name];
            }
        }
        $sourceEquationReal = $sourceEquationPlan = 0.0;
        $result = array();

        $sourceEquationReal = $this->parseFormulaVars($formula, $formula->getSourceEquationReal());
        $sourceEquationPlan = $this->parseFormulaVars($formula, $formula->getSourceEquationPlan());

        $result_equation_real = $result_equation_plan = 0.0;
        try {
            @eval(sprintf('$result_equation_real = %s;', $sourceEquationReal));
            @eval(sprintf('$result_equation_plan = %s;', $sourceEquationPlan));
        } catch (ErrorException $exc) {
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result_equation_real = $result_equation_plan = 0.0;
        }

        $result['sourceEquationReal'] = $result_equation_real;
        $result['sourceEquationPlan'] = $result_equation_plan;

        return $result;
    }

    /**
     * 
     * @param Formula $formula
     * @param array $data
     * @return type
     */
    public function calculateFormulaValueFromCardEquation(Formula $formula, $data, $options = array()) {
        if (!is_array($data)) {
            $data = array();
        }
        $variables = $formula->getVariables();
        foreach ($variables as $variable) {
            $name = $variable->getName();
            $$name = 0;
            if (isset($data[$name])) {
                $$name = $data[$name];
            }
        }
        $cardEquation = 0.0;
        $result = array();


        $cardEquation = $options['typeValue'] == 'real' ? $this->parseFormulaVars($formula, $formula->getCardEquationReal()) : $this->parseFormulaVars($formula, $formula->getCardEquationPlan());

        $result_equation = 0.0;
        try {
            @eval(sprintf('$result_equation = %s;', $cardEquation));
        } catch (ErrorException $exc) {
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result_equation = 0.0;
        }

        return $result_equation;
    }

    /**
     * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * 
     * @param Formula $formula
     * @return type
     */
    public function parseFormulaVars(Formula $formula, $equationReal) {
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
        $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
//        $equationReal = '6 + ( num_hoja_entrada_servicios_entregadas / num_valuaciones_solicitadas ) * 100 + casa - 1';
        $stringSplit = str_split($equationReal);
        $newEquation = $varEquation = '';
        foreach ($stringSplit as $key => $char) {
            if (in_array($char, $especialCaracter, true)) {
                $newEquation .= $char;
                continue;
            }
            $nextKey = $key + 1;
            $nextChar = isset($stringSplit[$nextKey]) ? $stringSplit[$nextKey] : null;
            $varEquation .= $char;
            if (in_array($nextChar, $especialCaracter, true)) {
                if (in_array($varEquation[0], $numbers)) {
                    
                } else {
                    $newEquation .= '$';
                }
                $newEquation .= $varEquation;
                $varEquation = '';
            }
        }
        if (strlen($varEquation) > 0) {//Se adjunta lo que queda de la formula que no contiene variable
            if (in_array($varEquation[0], $numbers)) {
                
            } else {
                $newEquation .= '$';
            }
            $newEquation .= $varEquation;
        }
        $formulaPaser = $newEquation;

        return $formulaPaser;
    }

    /**
     * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * 
     * @param Formula $formula
     * @return type
     */
    public function getArrayVars(Formula $formula, $equationSource) {
        $vars = array();
        $contArray = 1;
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
        $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
//        $equationReal = '6 + ( num_hoja_entrada_servicios_entregadas / num_valuaciones_solicitadas ) * 100 + casa - 1';
        $stringSplit = str_split($equationSource);
        $newEquation = $varEquation = '';

        foreach ($stringSplit as $key => $char) {
            if (in_array($char, $especialCaracter, true)) {
                $newEquation .= $char;
                continue;
            }
            $nextKey = $key + 1;
            $nextChar = isset($stringSplit[$nextKey]) ? $stringSplit[$nextKey] : null;
            $varEquation .= $char;
            if (in_array($nextChar, $especialCaracter, true)) {
                if (in_array($varEquation[0], $numbers)) {
                    
                } else {
                    $newEquation .= '$';
                }
                $newEquation .= $varEquation;
//                array_push($vars, $varEquation);
                $vars[$contArray] = $varEquation;
                $contArray++;
                $varEquation = '';
            }
        }

        return $vars;
    }

    /**
     * Valida la configuracion de una formula
     * @param Formula $formula
     */
    function validateFormula(Formula &$formula) {
        $typeOfCalculation = $formula->getTypeOfCalculation();
        $variableToRealValue = $formula->getVariableToRealValue();
        $variableToPlanValue = $formula->getVariableToPlanValue();
        $sourceEquationPlan = $formula->getSourceEquationPlan();
        $sourceEquationReal = $formula->getSourceEquationReal();
        $typeOfCalculationLabel = $this->trans($formula->getTypeOfCalculationLabel(), array(), 'PequivenIndicatorBundle');

        $error = null;

//Si el calculo es por promedio simple o acumulativo
        if ($typeOfCalculation == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE || $typeOfCalculation == Formula::TYPE_CALCULATION_ACCUMULATE) {
            $formula
                    ->setVariableToRealValue(null)
                    ->setVariableToPlanValue(null)
            ;
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
            if ($variableToRealValue === null || $variableToPlanValue === null) {
                $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation', array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Real y Plan'
                        ), 'flashes');
            }
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AUTOMATIC) {
            $formula
                    ->setVariableToPlanValue(null)
            ;
            if ($variableToRealValue === null) {
                $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation', array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Real'
                        ), 'flashes');
            }
        } elseif ($typeOfCalculation == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
            $formula
                    ->setVariableToPlanValue(null)
                    ->setVariableToRealValue(null)
            ;
            if ($sourceEquationPlan === null || $sourceEquationReal === null) {
                $error = $this->trans('pequiven.indicator.invalid_configuration_formula_type_calculation', array(
                    '%formula%' => (string) $formula,
                    'typeOfCalculation' => $typeOfCalculationLabel,
                    'requireVars' => 'Origen de ecuación real y Origen de ecuación del plan'
                        ), 'flashes');
            }
        }
        return $error;
    }

    function validateIndicatorParent(Indicator $indicator) {
        $formula = $indicator->getFormula();
        $error = null;
        if ($formula != null) {
            if ($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_AUTOMATIC) {
                if ($formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC && $formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ
                ) {
                    $error = $this->trans('pequiven_indicator.errors.not_support_formula_parent', array(), 'PequivenIndicatorBundle');
                }
                if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                    $variables = $formula->getVariables();
                    if (count($variables) != 2) {
                        $error = $this->trans('pequiven_indicator.errors.the_formula_should_only_have_two_defined_variables', array(), 'PequivenIndicatorBundle');
                    } else {
                        $findVariables = 0;
                        foreach ($variables as $variable) {
                            if ($variable->getName() == Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) {
                                $findVariables++;
                            } else if ($variable->getName() == Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) {
                                $findVariables++;
                            }
                        }
                        if ($findVariables != 2) {
                            $error = $this->trans('pequiven_indicator.errors.the_formula_must_have_the_variables_defined_plan_and_real', array(), 'PequivenIndicatorBundle');
                        }
                    }
                }
            }
        } else {
            $error = $this->trans('pequiven_indicator.errors.formula_unassigned', array(), 'PequivenIndicatorBundle');
        }
        return $error;
    }

    /**
     * Valida que el indicator hijo sea compatible para calcular resultados de formula automatico.
     * @param Indicator $indicator
     * @return type
     */
    function validateChildOfParent(Indicator $indicator) {
        $error = null;
        $parent = $indicator->getParent();
        $formula = $parent->getFormula();
        $frequencyNotificationIndicator = $indicator->getFrequencyNotificationIndicator();

        if ($formula != null) {
            if ($formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC && $formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ
            ) {
                $error = $this->trans('pequiven_indicator.errors.not_support_formula_parent', array(), 'PequivenIndicatorBundle');
            }
        } else {
            $error = $this->trans('pequiven_indicator.errors.formula_unassigned_parent', array(), 'PequivenIndicatorBundle');
        }
        $tendency = $parent->getTendency();
        if ($error === null) {
            if ($indicator->getFrequencyNotificationIndicator() !== null) {
                if ($parent->getFrequencyNotificationIndicator() !== $frequencyNotificationIndicator) {
                    $error = $this->trans('pequiven_indicator.errors.assigned_frequency_not_support', array(), 'PequivenIndicatorBundle');
                } else {
                    $formulaChild = $indicator->getFormula();
                    if ($formulaChild !== null) {
                        if ($formulaChild->getTypeOfCalculation() === Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC || $formulaChild->getTypeOfCalculation() === Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                            if ($indicator->getTendency() !== $tendency) {
                                $error = $this->trans('pequiven_indicator.errors.trends_should_be_equal', array(), 'PequivenIndicatorBundle');
                            }
                        } else {
                            $error = $this->trans('pequiven_indicator.errors.not_support_formula', array(), 'PequivenIndicatorBundle');
                        }
                    } else {
                        $error = $this->trans('pequiven_indicator.errors.formula_unassigned', array(), 'PequivenIndicatorBundle');
                    }
                }
            } else {
                $error = $this->trans('pequiven_indicator.errors.frequency_not_assigned_parent', array(), 'PequivenIndicatorBundle');
            }
        }

        return $error;
    }

    /**
     * 
     * @param Indicator $indicator
     * @param type $options
     */
    public function getValuesFromReportTemplate(Indicator $indicator, Indicator\ValueIndicator $valueIndicator, $options = array()) {
        $results = array();
//Obtenemos el productReport a partir del Detalle de configuracion
        $productsReports = $indicator->getValueIndicatorConfig()->getProductReports();

        $formula = $indicator->getFormula();

        if ($formula->getTypeOfCalculation() != \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
            $varRealName = $formula->getVariableToRealValue()->getName();
            $varPlanName = $formula->getVariableToPlanValue()->getName();
            $results[$varRealName] = $results[$varPlanName] = 0.0;
        } else {
            $varRealName = 'real';
            $results[$varRealName] = 0.0;
        }

//Separamos el tipo de sección de resultado del indicador
        if ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_PRODUCTION_GROSS) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
                foreach ($productsReports as $productReport) {
                    $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                    $valueReal = array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossReal() : 0;
                    $valuePlan = array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossPlan() : 0;
                    $results[$varRealName] = $results[$varRealName] + $valueReal;
                    $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
                }
            }
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_PRODUCTION_NET) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
                foreach ($productsReports as $productReport) {
                    $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                    $valueReal = array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalNetReal() : 0;
                    $valuePlan = array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalNetPlan() : 0;
                    $results[$varRealName] = $results[$varRealName] + $valueReal;
                    $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
                }
            }
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_UNREALIZED_PRODUCTION) {
            $productReportService = $this->getProductReportService();
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
            }
            foreach ($productsReports as $productReport) {
                $unrealizedProductionMonths = $productReport->getUnrealizedProductionsSortByMonth();
                $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();

                $dateConsulting = $productReportService->getTimeNowMonth($month, $unrealizedProductionMonths[$month]);
                $dataOverProduction = $productReportService->getArrayByDateFromInternalCausesPnr($dateConsulting, $productReport);

                $valueReal = array_key_exists($month, $unrealizedProductionMonths) == true ? $unrealizedProductionMonths[$month]->getTotal() - $dataOverProduction[\Pequiven\SEIPBundle\Entity\CEI\Fail::TYPE_FAIL_INTERNAL]['Sobre Producción']['month'] : 0;
                $valuePlan = array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossPlan() : 0;
                $results[$varRealName] = $results[$varRealName] + $valueReal;
                $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
            }
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_RAW_MATERIAL) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
            }
            $totalRawMaterials = 0;
            $value = 0.0;
            foreach ($productsReports as $productReport) {
                $rawsMaterialsConsumptionPlanning = $productReport->getRawMaterialConsumptionPlannings();
                foreach ($rawsMaterialsConsumptionPlanning as $rawMaterialConsumptionPlanning) {
                    $detailRawMaterialConsumptionsByMonth = $rawMaterialConsumptionPlanning->getDetailByMonth();
                    if ($formula->getTypeOfCalculation() != \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                        $valueReal = array_key_exists($month, $detailRawMaterialConsumptionsByMonth) == true ? $detailRawMaterialConsumptionsByMonth[$month]->getTotalReal() : 0;
                        $valuePlan = array_key_exists($month, $detailRawMaterialConsumptionsByMonth) == true ? $detailRawMaterialConsumptionsByMonth[$month]->getTotalPlan() : 0;
                        $results[$varRealName] = $results[$varRealName] + $valueReal;
                        $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
                    } else {
                        $value = array_key_exists($month, $detailRawMaterialConsumptionsByMonth) == true ? $value + $detailRawMaterialConsumptionsByMonth[$month]->getPercentage() : $value;
                        $totalRawMaterials++;
                    }
                }
            }
            if ($formula->getTypeOfCalculation() == \Pequiven\MasterBundle\Entity\Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                $results[$varRealName] = $value / $totalRawMaterials;
            }
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_SERVICES) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
            }
            $totalServices = 0;
            $value = 0.0;
            foreach ($productsReports as $productReport) {
                $planReport = $productReport->getPlantReport();
                $services = $planReport->getConsumerPlanningServices();

                foreach ($services as $service) {
                    $detailServiceByMonth = $service->getDetailsByMonth();
                    $value = array_key_exists($month, $detailServiceByMonth) == true ? $value + $detailServiceByMonth[$month]->getPercentage() : $value;
                    $totalServices++;
                }
            }
            $results[$varRealName] = $value / $totalServices;
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_SERVICE_FACTOR) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
            }
            $value = 0.0;
            foreach ($productsReports as $productReport) {
                $planReport = $productReport->getPlantReport();
                $servicesFactors = $planReport->getConsumerPlanningServiceFactor();

                foreach ($servicesFactors as $serviceFactor) {
                    $detailServiceByMonth = $serviceFactor->getDetailsByMonth();
                    $valueReal = array_key_exists($month, $detailServiceByMonth) == true ? $detailServiceByMonth[$month]->getTotalReal() : 0;
                    $valuePlan = array_key_exists($month, $detailServiceByMonth) == true ? $detailServiceByMonth[$month]->getTotalPlan() : 0;
                    $results[$varRealName] = $results[$varRealName] + $valueReal;
                    $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
                }
            }
        } elseif ($options['typeOfResultSection'] == Indicator::TYPE_RESULT_SECTION_GAS_FLOW) {
            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
                if (!$valueIndicator->getId()) {
                    $month = count($indicator->getValuesIndicator()) + 1;
                } else {
                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
                }
            }
            $value = 0.0;
            foreach ($productsReports as $productReport) {
                $planReport = $productReport->getPlantReport();
                $gasFlows = $planReport->getConsumerPlanningGasFlow();

                foreach ($gasFlows as $gasFlow) {
                    $detailGasFlowByMonth = $gasFlow->getDetailsByMonth();
                    $valueReal = array_key_exists($month, $detailGasFlowByMonth) == true ? $detailGasFlowByMonth[$month]->getPercentage() : 0;
                    $valuePlan = array_key_exists($month, $detailGasFlowByMonth) == true ? $detailGasFlowByMonth[$month]->getPlanFlow() : 0;
                    $results[$varRealName] = $results[$varRealName] + $valueReal;
                    $results[$varPlanName] = $results[$varPlanName] + $valuePlan;
                }
            }

//            if ($indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency() == 12) {
//                if (!$valueIndicator->getId()) {
//                    $month = count($indicator->getValuesIndicator()) + 1;
//                } else {
//                    $month = $this->getOrderOfValueIndicator($indicator, $valueIndicator);
//                }
//            }
//            $value = 0.0;
//            foreach ($productsReports as $productReport) {
//                $planReport = $productReport->getPlantReport();
//                $gasFlows = $planReport->getConsumerPlanningGasFlow();
//
//                foreach ($gasFlows as $gasFlow) {
//                    $detailGasFlowByMonth = $gasFlow->getDetailsByMonth();
//                    $value = array_key_exists($month, $detailGasFlowByMonth) == true ? $value + $detailGasFlowByMonth[$month]->getPercentage() : $value;
//                }
//            }
//            $results[$varRealName] = $value;
        }

        return $results;
    }

    /**
     * Retorna el orden del valor del indicador, respecto a los demás
     * @param Indicator $indicator
     */
    public function getOrderOfValueIndicator(Indicator $indicator, \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator) {
        $cont = 1;
        foreach ($indicator->getValuesIndicator() as $valIndicator) {
            if ($valIndicator->getId() == $valueIndicator->getId()) {
                return $cont;
            }
            $cont++;
        }
    }

    /**
     * Función que devuelve la data para el widget de tipo bulbo en el dashboard de los resultados estratégicos
     * @param Indicator $indicator
     * @return string
     * @author Matias Jimenez
     */
    public function getDataDashboardWidgetBulb(Indicator $indicator, $modeUrl = CommonObject::OPEN_URL_OTHER_WINDOW) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'colorRange' => array(
                    'color' => array(),
                ),
            ),
        );
        $chart = array();

        $chart["showshadow"] = "0";
        $chart["showvalue"] = "1";
        $chart["useColorNameAsValue"] = "1";
        $chart["placeValuesInside"] = "1";
        $chart["valueFontSize"] = "13";
        $chart["baseFontColor"] = "#333333";
        $chart["baseFont"] = "Helvetica Neue,Arial";
        $chart["captionFontSize"] = "10";
        $chart["showborder"] = "0";
        $chart["bgcolor"] = "#FFFFFF";
        $chart["bgalpha"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBorderThickness"] = "0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        if ($modeUrl == CommonObject::OPEN_URL_OTHER_WINDOW) {
            $chart["clickURL"] = 'n-' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
        } else {
            $chart["clickURL"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
        }
        $chart["clickURLOverridesPlotLinks"] = "0";

        $color = $colorData = array();
        $colorData["minvalue"] = "0";
        $colorData["maxvalue"] = "100";

        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $arrangementRange = $indicator->getArrangementRange();
        $tendency = $indicator->getTendency();
        $errorArrangementRange = null;
        if ($arrangementRange !== null) {
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($arrangementRange, $tendency);
            if ($errorArrangementRange == null) {
                if ($indicator->getEvaluateInPeriod()) {//En caso de que sea medidio en el período actual
                    $value = number_format($indicator->getResultReal(), 2, ',', '.') . '%';
                    if ($indicator->getShowTagInDashboardResult()) {
                        foreach ($indicator->getTagsIndicator() as $tagIndicator) {
                            if ($tagIndicator->getShowInIndicatorDashboardResult()) {
                                if ($tagIndicator->getTypeTag() == Indicator\TagIndicator::TAG_TYPE_NUMERIC) {
                                    $value = $tagIndicator->getValueOfTag();
                                } else {
                                    $value = $tagIndicator->getTextOfTag();
                                }
                                $value = $tagIndicator->getUnitResult() != "" ? number_format($value, 2, ',', '.') . ' ' . strtoupper($tagIndicator->getUnitResultValue()) : number_format($value, 2, ',', '.') . '%';
                            }
                        }
                    }
                    if ($indicator->getShowResultWithoutPercentageInDashboard()) {
                        $value = number_format($indicator->getResultReal(), 2, ',', '.');
                    }
                    $colorData["label"] = $value;
                    if ($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                        $colorData["code"] = "#1aaf5d";
                    } elseif ($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                        $colorData["code"] = "#f2c500";
                    } elseif ($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                        $colorData["code"] = "#c02d00";
                    }
                } else {
                    $colorData["code"] = "#544040";
                    $colorData["label"] = $this->trans('pequiven_indicator.errors.indicatorNoEvaluateInPeriod', array(), 'PequivenIndicatorBundle');
                }
            } else {
                $colorData["code"] = "#000000";
                $colorData["label"] = $errorArrangementRange;
            }
        } else {
            $colorData["code"] = "#000000";
            $colorData["label"] = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }

        $color[] = $colorData;
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['colorRange']['color'] = $color;

        return $data;
    }

    /**
     * Función que devuelve la data para el widget de tipo tacómetro
     * @param Indicator $indicator
     * @return string
     * @author Matias Jimenez
     */
    public function getDataWidgetAngularGauge(Indicator $indicator) {
        $arrangemenetRangeService = $this->getArrangementRangeService();

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'colorRange' => array(
                    'color' => array(),
                ),
                'dials' => array(
                    'dial' => array(),
                ),
            ),
        );

//Sección Data Básica del Gráfico
        $chart = array();

//Sección para Setear el dial
        $dial = array();

        $colorData = $arrangemenetRangeService->getDataColorRangeWidget($indicator->getArrangementRange(), $indicator->getTendency(), CommonObject::ARRANGEMENT_RANGE_WITHOUT_CLEARANCE);

        $chart["lowerlimit"] = $colorData['lowerLimit'];
        $chart["upperlimit"] = $colorData['upperLimit'];
        $value = number_format($indicator->getResultReal(), 2, ',', '.');
        if ($indicator->getShowTagInDashboardResult()) {
            foreach ($indicator->getTagsIndicator() as $tagIndicator) {
                if ($tagIndicator->getShowInIndicatorDashboardResult()) {
                    if ($tagIndicator->getTypeTag() == Indicator\TagIndicator::TAG_TYPE_NUMERIC) {
                        $value = $tagIndicator->getValueOfTag();
                    } else {
                        $value = $tagIndicator->getTextOfTag();
                    }
                    $value = $tagIndicator->getUnitResult() != "" ? number_format($value, 2, ',', '.') . ' ' . strtoupper($tagIndicator->getUnitResultValue()) : number_format($value, 2, ',', '.') . '%';
                }
            }
        }
        $chart["caption"] = $value;
        $chart["captionFontColor"] = $this->getColorOfResult($indicator);
        $chart["captionOnTop"] = "0";
        $chart["autoScale"] = "1";
        $chart["numbersuffix"] = "%";
        $chart["tickvaluedistance"] = "8";
        $chart["showvalue"] = "0";
        $chart["gaugeinnerradius"] = "0";
        $chart["bgcolor"] = "#FFFFFF";
        $chart["pivotfillcolor"] = "#6c6c6c";
        $chart["pivotradius"] = "8";
        $chart["pivotfilltype"] = "radial";
        $chart["pivotfillratio"] = "0,100";
        $chart["showtickvalues"] = "1";
        $chart["showborder"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["clickURL"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));

        $dial["value"] = $indicator->getResultReal() < (float) $colorData['lowerLimit'] ? $colorData['lowerLimit'] : ($indicator->getResultReal() > $colorData['upperLimit'] ? $colorData['upperLimit'] : number_format($indicator->getResultReal(), 2, ',', '.'));
        $dial["showValue"] = "0";
        $dial["rearextension"] = "5";
        $dial["radius"] = "50%";
        $dial["bgcolor"] = "#6c6c6c";
        $dial["bordercolor"] = "#333333";
        $dial["basewidth"] = "4";
        $dial["editMode"] = "1";

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['colorRange']['color'] = $colorData['color'];
        $data['dataSource']['dials']['dial'][] = $dial;

        return $data;
    }

    /**
     * Función que devuelve la data para el widget de tipo torta multi nivel en el dashboard de cada indicador
     * @param Indicator $indicator
     * @return string
     * @author Matias Jimenez
     */
    public function getDataDashboardWidgetMultiLevelPie(Indicator $indicator) {
        $objectIndicator = $indicator;
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'category' => array(),
            ),
        );
        $chart = array();

        $chart["caption"] = $indicator->getRef() . '-' . $indicator->getSummary();
//        $chart["subCaption"] = "Last Quarter";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["baseFontColor"] = "#000000";
        $chart["baseFont"] = "Helvetica Neue,Arial";
        $chart["basefontSize"] = "9";
        $chart["subcaptionFontBold"] = "0";
        $chart["bgcolor"] = "#FFFFFF";
        $chart["canvasBgcolor"] = "#FFFFFF";
        $chart["showBorder"] = "0";
        $chart["showShadow"] = "0";
        $chart["showToolTipShadow"] = "1";
        $chart["showCanvasBorder"] = "0";
        $chart["pieFillAlpha"] = "90";
        $chart["pieBorderThickness"] = "2";
        $chart["hoverFillColor"] = "#ddceca";
        $chart["pieBorderColor"] = "#ffffff";
        $chart["useHoverColor"] = "1";
        $chart["showValuesInTooltip"] = "1";
        $chart["showPercentInTooltip"] = "0";
        $chart["useEllipsesWhenOverflow"] = "1";
        $chart["labelDisplay"] = "stagger";
        $chart["hasRTLText"] = "1";

//Seleccionamos la data del pie de acuerdo al nivel del indicador
        $category = array();
        $categoryLineStrategic = array();
        $categoryObjetiveStrategic = array();
        $categoryObjetiveTactic = array();

//Para un Indicador de Nivel Estratégico
        if ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {
            foreach ($indicator->getLineStrategics() as $lineStrategic) {//Anexamos la data del centro
                $idLineStrategic = $lineStrategic->getId();
                $category["label"] = $lineStrategic->getRef(); //$lineStrategic->getDescription();
                $category["color"] = "#ffffff";
                $category["value"] = "100";
                $category["toolText"] = $lineStrategic->getDescription();
                $category["link"] = $this->generateUrl('pequiven_line_strategic_show', array('id' => $lineStrategic->getId()));
                $categoryLineStrategic["label"] = $indicator->getRef(); //$indicator->getSummary();
                $categoryLineStrategic["color"] = $this->getColorOfResult($indicator);
                $categoryLineStrategic["value"] = "100";
                $categoryLineStrategic["toolText"] = $indicator->getDescription() . ' - ' . number_format($indicator->getResultReal(), 2, ',', '.');
                $categoryLineStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                if (($numChildrens = count($indicator->getChildrens())) > 0) {
                    $numDiv = bcdiv(100, $numChildrens, 2);
                    foreach ($indicator->getChildrens() as $children) {
                        $IndicatorTacticArray = array();
                        $IndicatorTacticArray["label"] = $children->getRef();
                        $IndicatorTacticArray["color"] = $this->getColorOfResult($children);
                        $IndicatorTacticArray["value"] = $numDiv;
                        $IndicatorTacticArray["toolText"] = $indicator->getDescription() . ' - ' . number_format($children->getResultReal(), 2, ',', '.');
                        $IndicatorTacticArray['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                        $categoryObjetiveStrategic[] = $IndicatorTacticArray;
                    }
                }
                $categoryLineStrategic['category'] = $categoryObjetiveStrategic;
                $category["category"][] = $categoryLineStrategic;
            }
        } elseif (($indicatorParent = $indicator->getParent()) != NULL) {
            $seeTree = true;
            $flagParent = false;
            $cont = 1;
            while (!$flagParent) {
                if ($indicatorParent->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {//En caso de que estemos en el indicador Táctico
                    $flagParent = true;
                    if ($cont == 1) {//En caso de que se este viendo un indicador táctico
//                        $indicatorsGroup = $indicatorParent->getChildrens();
                        $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());
                    }
                    foreach ($indicatorParent->getLineStrategics() as $lineStrategic) {
                        $idLineStrategic = $lineStrategic->getId();

                        $category["label"] = $lineStrategic->getRef();
                        $category["color"] = "#ffffff";
                        $category["value"] = "100";
                        $category["toolText"] = $lineStrategic->getDescription();
                        $category["link"] = $this->generateUrl('pequiven_line_strategic_show', array('id' => $lineStrategic->getId()));
                        $categoryLineStrategic["label"] = $indicatorParent->getRef(); //$indicator->getSummary();
                        $categoryLineStrategic["color"] = $this->getColorOfResult($indicatorParent);
                        $categoryLineStrategic["value"] = "100";
                        $categoryLineStrategic["toolText"] = $indicatorParent->getDescription() . ' - ' . number_format($indicatorParent->getResultReal(), 2, ',', '.');
                        $categoryLineStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorParent->getId()));
                        $categoryObjetiveStrategic["label"] = $objectIndicator->getRef();
                        $categoryObjetiveStrategic["color"] = $this->getColorOfResult($objectIndicator);
                        $categoryObjetiveStrategic["value"] = "100";
                        $categoryObjetiveStrategic["toolText"] = $objectIndicator->getDescription() . ' - ' . number_format($objectIndicator->getResultReal(), 2, ',', '.');
                        $categoryObjetiveStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $objectIndicator->getId()));

                        if (($numChildrens = count($objectIndicator->getChildrens())) > 0) {
                            $numDiv = bcdiv(100, $numChildrens, 2);
                            foreach ($objectIndicator->getChildrens() as $children) {
                                $IndicatorOperativeArray = array();
                                $IndicatorOperativeArray["label"] = $children->getRef();
                                $IndicatorOperativeArray["color"] = $this->getColorOfResult($children);
                                $IndicatorOperativeArray["value"] = $numDiv;
                                $IndicatorOperativeArray["toolText"] = $children->getDescription() . ' - ' . number_format($children->getResultReal(), 2, ',', '.');
                                $IndicatorOperativeArray['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                                $categoryObjetiveTactic[] = $IndicatorOperativeArray;
                            }
                        }
                        $categoryObjetiveStrategic['category'] = $categoryObjetiveTactic; //Anexamos los Objetivos Operativos
                        $categoryLineStrategic['category'][] = $categoryObjetiveStrategic; //Anexamos el Objetivo Táctico
                        $category["category"][] = $categoryLineStrategic; //Anexamos el Objetivo Estratégico
                    }
                } else {
                    $cont++;
//                    $indicatorsGroup = $indicatorParent->getChildrens();//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                    $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId()); //En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                    $objectIndicator = $indicatorParent;
                    $indicatorParent = $indicatorParent->getParent();
                }
            }
        }
//        print_r($category);
//        die();

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['category'][] = $category;
        return $data;
    }

    /**
     * Función que devuelve la data para el widget de tipo dona en el dashboard del indicador
     * @param Indicator $indicator
     * @param type $options
     * @return type
     */
    public function getDataDashboardWidgetDoughnut(Indicator $indicator, $options = array()) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'dataSet' => array(),
            ),
        );
        $chart = array();

//        $chart["caption"] = $indicator->getRef().'-'.$indicator->getSummary();
        $chart["caption"] = $indicator->getSummary();
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["use3DLighting"] = "1";
        $chart["showShadow"] = "0";
        $chart["enableSmartLabels"] = "1";
        $chart["startingAngle"] = "0";
        $chart["showLabel"] = "1";
        $chart["showPercentValues"] = "1";
        $chart["showLegend"] = "1";
        $chart["legendShadow"] = "0";
        $chart["legendBorderAlpha"] = "0";
        $chart["defaultCenterLabel"] = $indicator->getSummary() . ': ' . number_format($indicator->getResultReal(), 2, ',', '.') . '%';
        $chart["centerLabel"] = "\$label";
        $chart["centerLabelBold"] = "1";
        $chart["manageLabelOverflow"] = "1";
        $chart["useEllipsesWhenOverflow"] = "1";
//        $chart["showTooltip"] = "1";
        $chart["decimals"] = "0";
        $chart["captionFontSize"] = "14";
        $chart["captionPadding"] = "-10";
        $chart["borderThickness"] = "2";
        $chart["labelFontBold"] = "1";
        $chart["plotHoverEffect"] = "1";
        $chart["legendCaptionBold"] = "1";
        $chart["legendPosition"] = "BOTTOM";
        $chart["useDataPlotColorForLabels"] = "1";
        $chart["minimiseWrappingInLegend"] = "1";

        $dataSet = array();

        $totalNumChildrens = count($indicator->getChildrens()); //Número de indicadores asociados
//        $numDiv = $totalNumChildrens > 0 ? bcdiv(100, $totalNumChildrens,2) : 100;
        if (isset($options['childrens']) && array_key_exists('childrens', $options)) {
            unset($options['childrens']);
            if ($totalNumChildrens > 0) {
                $sumResultChildren = 0; //Suma de resultados de medición de los hijos
                $indicatorsChildrens = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicator->getId()); //Obtenemos los indicadores asociados
                foreach ($indicatorsChildrens as $indicatorChildren) {
                    $sumResultChildren+= $indicatorChildren->getResultReal();
                }
                $cont = 1;
                foreach ($indicatorsChildrens as $indicatorChildren) {
                    $set = array();
                    $set["label"] = $indicatorChildren->getRef() . ' ' . $indicatorChildren->getSummary() . ': ' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["value"] = $sumResultChildren != 0 ? bcdiv($indicatorChildren->getResultReal(), $sumResultChildren, 2) : $cont == 1 ? bcadd(100, 0, 2) : bcadd(0, 0, 2);
                    $set["displayValue"] = $indicatorChildren->getRef() . ' - ' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["toolText"] = $indicatorChildren->getSummary() . ':{br}' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["color"] = $this->getColorOfResult($indicatorChildren);
                    if (count($indicatorChildren->getCharts()) > 0) {
                        $set["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    }
                    $set["labelLink"] = $this->generateUrl('pequiven_indicator_show', array('id' => $indicatorChildren->getId()));
                    $dataSet[] = $set;
                    $cont++;
                }
            }
        } elseif (isset($options['withVariablesRealPLan']) && array_key_exists('withVariablesRealPLan', $options)) {//Para que muestre las variables de acuerdo a 
            unset($options['withVariablesRealPLan']);
            $arrayVariables = array();
            if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlan' => true));
            } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomatic' => true));
            }
//            $valueMax = 0;
//            if (!$indicator->getVariablesRealPlanComplement()) {
//                foreach ($arrayVariables as $arrayVariable) {
//                    if ($arrayVariable['value'] > $valueMax) {
//                        $valueMax = $arrayVariable['value'];
//                    }
//                }
//            }
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = $arrayVariable['value'];
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                $set["toolText"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
//                $set["color"] = $this->getColorOfResult($indicatorChildren);
//                $set["labelLink"] = $this->generateUrl('pequiven_indicator_show', array('id' => $indicator->getId()));
//                $set["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                $dataSet[] = $set;
            }
        } elseif (isset($options['withVariablesRealPlanFromDashboardEquation']) && array_key_exists('withVariablesRealPlanFromDashboardEquation', $options)) {
            unset($options['withVariablesRealPlanFromDashboardEquation']);
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanFromDashboardEquation' => true));

            $set = array();
            $set["label"] = $arrayVariables['dashboardEquationReal']['description'];
            $set["value"] = $arrayVariables['dashboardEquationReal']['value'];
            $set["displayValue"] = number_format($arrayVariables['dashboardEquationReal']['value'], 2, ',', '.') . ' ' . $arrayVariables['dashboardEquationReal']['unit'];
            $set["toolText"] = number_format($arrayVariables['dashboardEquationReal']['value'], 2, ',', '.') . ' ' . $arrayVariables['dashboardEquationReal']['unit'];
            $dataSet[] = $set;

            $set = array();
            $set["label"] = $arrayVariables['dashboardEquationPlan']['description'];
            $set["value"] = $arrayVariables['dashboardEquationPlan']['value'];
            $set["displayValue"] = number_format($arrayVariables['dashboardEquationPlan']['value'], 2, ',', '.') . ' ' . $arrayVariables['dashboardEquationPlan']['unit'];
            $set["toolText"] = number_format($arrayVariables['dashboardEquationPlan']['value'], 2, ',', '.') . ' ' . $arrayVariables['dashboardEquationPlan']['unit'];
            $dataSet[] = $set;
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['dataSet'] = $dataSet;
        return $data;
    }

    /**
     * Función que devuelve la data para el widget de tipo dona en el dashboard del indicador
     * @param Indicator $indicator
     * @param type $options
     * @return type
     */
    public function getDataDashboardPie(Indicator $indicator, $options = array()) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'data' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $indicator->getSummary();
        ;

        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000";
        $chart["bgColor"] = "ffffff";
        $chart["showBorder"] = "0";
        $chart["use3DLighting"] = "1";
        $chart["showShadow"] = "0";
        $chart["enableSmartLabels"] = "1";
        $chart["startingAngle"] = "0";
        $chart["showPercentValues"] = "1";
        $chart["showPercentInTooltip"] = "0";
        $chart["showLabel"] = "1";
        $chart["decimals"] = "0";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "1";
        $chart["showPercentInTooltip"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBorderThickness"] = "0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showHoverEffect"] = "0";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["legendItemFontSize"] = "12";
        $chart["legendItemFontColor"] = "#666666";

        $dataChart = array();

        if (isset($options['viewVariablesFromPlanEquation']) && array_key_exists('viewVariablesFromPlanEquation', $options)) {//Para el caso de que se muestren las variables sumativas al plan del indicador cuyo cálculo es a partir de ecuación
            unset($options['viewVariablesFromPlanEquation']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesFromPlanEquation' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                ;
                $dataChart[] = $set;
            }
        } elseif (isset($options['viewVariablesFromRealEquation']) && array_key_exists('viewVariablesFromRealEquation', $options)) {
            unset($options['viewVariablesFromRealEquation']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesFromRealEquation' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                $dataChart[] = $set;
            }
        } elseif (isset($options['viewVariablesMarkedReal']) && array_key_exists('viewVariablesMarkedReal', $options)) {
            unset($options['viewVariablesMarkedReal']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesMarkedReal' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                $dataChart[] = $set;
            }
        } elseif (isset($options['viewVariablesMarkedPlan']) && array_key_exists('viewVariablesMarkedPlan', $options)) {
            unset($options['viewVariablesMarkedPlan']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesMarkedPlan' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                $dataChart[] = $set;
            }
        } else {
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array());
            foreach ($arrayVariables as $ind => $key) {
                $set = array();
                $set["label"] = $ind; // . ': ' . number_format($key, 2, ',', '.');
                $set["value"] = bcadd($key, 0, 2);
                $dataChart[] = $set;
            }
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['data'] = $dataChart;

        return $data;
    }

    /**
     * 
     * @param Indicator $indicator
     * @param type $options
     * @return string
     */
    public function getDataDashboardBarsArea(Indicator $indicator, $options = array()) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );
        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Sales analysis of last year";
//        $chart["xAxisname"] = "Month";
        $chart["yAxisName"] = "Amount (In USD)";
        $chart["numberPrefix"] = "$";
        $chart["showBorder"] = "0";
        $chart["showValues"] = "0";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showCanvasBorder"] = "0";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["showAlternateHGridColor"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBorderThickness"] = "0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        $chart["formatNumberScale"] = "0";

        $totalNumChildrens = count($indicator->getChildrens()); //Número de indicadores asociados

        $category = $dataSetReal = $dataSetPlan = $medition = array();

        if (isset($options['byFrequencyNotification']) && array_key_exists('byFrequencyNotification', $options)) {
            unset($options['byFrequencyNotification']);

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $arrayVariables = array();
            if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            }

            $dataSetPlan["seriesname"] = isset($arrayVariables['descriptionPlan']) ? $arrayVariables['descriptionPlan'] : 'Plan';
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = isset($arrayVariables['descriptionReal']) ? $arrayVariables['descriptionReal'] : 'Real';
            $dataSetReal["renderas"] = "area";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] || 0 && $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }

            for ($i = 0; $i < $resultNumbers; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $i;
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }
        } elseif (isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification', $options)) {
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesMarkedRealPlanByFrequencyNotification' => true));

            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["renderas"] = "area";

            $totalValueIndicators = count($indicator->getValuesIndicator());

            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] != 0 || $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }

            for ($i = 0; $i < $resultNumbers; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $i;
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetReal;
        $data['dataSource']['dataset'][] = $dataSetPlan;

        return $data;
    }

    /**
     * 
     * @param Indicator $indicator
     * @param type $options
     * @return array
     */
    public function getDataChartColumnMultiSeries3d(Indicator $indicator, $options = array()) {

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Sales by quarter";
//        $chart["xAxisName"] = "Indicador";
        $chart["yAxisName"] = "TM";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";

        $category = $dataSetReal = $dataSetPlan = $medition = array();

        if (isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification', $options)) {
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries' => true));
            $showDataExtra = false;

//$result[indicator.id][real][numero_resultado] = valor
            $result = array();
//CPHC
            $result[1489]['real'] = array(1 => 0.0, 2 => 11789.0, 3 => 10273.0, 4 => 12329);
            $result[1490]['real'] = array(1 => 0.0, 2 => 65389.0, 3 => 40249.0, 4 => 33910);
            $result[1491]['real'] = array(1 => 0.0, 2 => 6957.0, 3 => 15243.0, 4 => 24557);
            $result[1492]['real'] = array(1 => 0.0, 2 => 9975.0, 3 => 17873.0, 4 => 27348);
            $result[1493]['real'] = array(1 => 0.0, 2 => 2340.0, 3 => 3798.0, 4 => 4980);
            $result[1494]['real'] = array(1 => 0.0, 2 => 2866.0, 3 => 5174.0, 4 => 7166);
            $result[1495]['real'] = array(1 => 0.0, 2 => 11461.0, 3 => 8738.0, 4 => 12221);
            $result[1496]['real'] = array(1 => 0.0, 2 => 0.0, 3 => 15146.0, 4 => 17763);
            $result[1497]['real'] = array(1 => 0.0, 2 => 2629.0, 3 => 3870.0, 4 => 4918);
            $result[1498]['real'] = array(1 => 0.0, 2 => 1397.0, 3 => 7987.0, 4 => 10390);
//CPAMC
            $result[1503]['real'] = array(1 => 0.0, 2 => 14749.0, 3 => 15177.0, 4 => 18122.0);
            $result[1504]['real'] = array(1 => 0.0, 2 => 15973.0, 3 => 16606.0, 4 => 18343);
            $result[1505]['real'] = array(1 => 0.0, 2 => 27139.0, 3 => 28044.0, 4 => 31695);
            $result[1506]['real'] = array(1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0);
            $result[1507]['real'] = array(1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0);
            $result[1508]['real'] = array(1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0);
            $result[1509]['real'] = array(1 => 0.0, 2 => 6789.0, 3 => 8579.0, 4 => 12976);
            $result[1510]['real'] = array(1 => 0.0, 2 => 11697, 3 => 13714.0, 4 => 16967);

            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["showValues"] = "1";
            
            if(in_array($indicator->getId(),$result)){
                $showDataExtra = true;
            }
            
            $dataSetExtra = array();
            
            if ($indicator->getResultsAdditionalInDashboardColumn() && $showDataExtra == true) {
                $dataSetExtra["seriesname"] = 'Costo Unitario + Otros Ingresos/Gastos';
                $dataSetExtra["showValues"] = '1';
                $dataSetExtra["color"] = '#DF1D3A';
            }

            $totalValueIndicators = count($indicator->getValuesIndicator());

            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] != 0 || $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }

            for ($i = 0; $i < $resultNumbers; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = $dataExtra = array();
                $label["label"] = $i;
                if ($indicator->getResultsAdditionalInDashboardColumn() && $showDataExtra == true) {
                    if ($i == 0) {
                        $dataExtra['showValue'] = '1';
                        $dataExtra['displayValue'] = '*';
                        $dataExtra['toolText'] = 'En espera de Información';
                    }
                    $dataExtra["value"] = number_format($result[$indicator->getId()]['real'][$i + 1], 2, ',', '.');
                }
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');

                $category[] = $label;
                if($showDataExtra == true){
                    $dataSetExtra["data"][] = $dataExtra;
                }
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }

            if($showDataExtra == true){
                $data['dataSource']['dataset'][] = $dataSetExtra;
            }
            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
        } elseif (isset($options['withVariablesRealPlanFromDashboardEquationFromChildrens']) && array_key_exists('withVariablesRealPlanFromDashboardEquationFromChildrens', $options)) {
            unset($options['withVariablesRealPlanFromDashboardEquationFromChildrens']);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries' => true));

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $dataSetPlan["seriesname"] = $indicator->getShowByPlanValue();
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $indicator->getShowByRealValue();
            $dataSetReal["showValues"] = "1";

            $childrens = $indicator->getChildrens();

            foreach ($childrens as $children) {
                $label = $dataReal = $dataPlan = array();
                $label["label"] = $children->getSummary();
                $dataReal["value"] = number_format($arrayVariables[$children->getRef()]['dashboardEquationReal']['value'], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'], 2, ',', '.');
                if (count($children->getCharts()) > 0) {
                    $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                    $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                }

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }

            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
        } elseif (isset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquation']) && array_key_exists('withVariablesRealPlanByFrequencyNotificationFromDashboardEquation', $options)) {
            unset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquation']);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries' => true));

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $dataSetPlan["seriesname"] = $arrayVariables['dashboardEquationPlan']['description'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['dashboardEquationReal']['description'];
            $dataSetReal["showValues"] = "1";

            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
            $totalValueIndicators = count($indicator->getValuesIndicator());

            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['dashboardEquationReal']['value'][$i] != 0 || $arrayVariables['dashboardEquationPlan']['value'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }

            for ($i = 0; $i < $resultNumbers; $i++) {
                $label = $dataReal = $dataPlan = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];
                $dataReal["value"] = number_format($arrayVariables['dashboardEquationReal']['value'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['dashboardEquationPlan']['value'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }

            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
        } elseif ((isset($options['resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated']) && array_key_exists('resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated', $options))) {
            unset($options[$options['path_array']]);

            $dataSetActualPeriod = $dataSetLastPeriod = array();

            $dataSetActualPeriod["seriesname"] = $indicator->getPeriod()->getDescription();
            $dataSetActualPeriod["showValues"] = "1";
            $dataSetLastPeriod["seriesname"] = $indicator->getPeriod()->getParent()->getDescription();
            $dataSetLastPeriod["showValues"] = "1";

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array($options['path_array'] => true, 'variables' => $options['variables'], 'path_array' => $options['path_array']));

            $variables = $indicator->getFormula()->getVariables();
            $childrens = $indicator->getChildrens();

            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $label = $dataActualPeriod = $dataLastPeriod = array();
                    $label["label"] = $children->getSummary();
                    $dataActualPeriod["value"] = number_format($arrayVariables[$children->getRef()][$children->getPeriod()->getName()]['value'], 2, ',', '.');
                    $dataLastPeriod["value"] = number_format($arrayVariables[$children->getRef()][$children->getPeriod()->getParent()->getName()]['value'], 2, ',', '.');
                    if (count($children->getCharts()) > 0) {
                        $dataActualPeriod["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                        $dataLastPeriod["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                    }

                    $category[] = $label;
                    $dataSetActualPeriod["data"][] = $dataActualPeriod;
                    $dataSetLastPeriod["data"][] = $dataLastPeriod;
                }
            }

            $label = $dataActualPeriod = $dataLastPeriod = array();
            $label["label"] = 'Acumulado';
            $dataActualPeriod["value"] = number_format($arrayVariables[$indicator->getPeriod()->getName()]['total'], 2, ',', '.');
            $dataLastPeriod["value"] = number_format($arrayVariables[$indicator->getPeriod()->getParent()->getName()]['total'], 2, ',', '.');
            $category[] = $label;
            $dataSetActualPeriod["data"][] = $dataActualPeriod;
            $dataSetLastPeriod["data"][] = $dataLastPeriod;

            $data['dataSource']['dataset'][] = $dataSetActualPeriod;
            $data['dataSource']['dataset'][] = $dataSetLastPeriod;
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;

        return $data;
    }

    /**
     * 
     * @param Indicator $indicator
     * @param type $options
     * @return array
     */
    public function getDataChartColumn3d(Indicator $indicator, $options = array()) {

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'data' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Sales by quarter";
        $chart["xAxisName"] = "Mes";
//        $chart["yAxisName"] = "TM";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["valueFontColor"] = "#000000";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "0";
        $chart["placeValuesInside"] = "0";
        $chart["showShadow"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["divlineThickness"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";

        if (isset($options['resultIndicatorsAssociatedWithTotalByMonth']) && array_key_exists('resultIndicatorsAssociatedWithTotalByMonth', $options)) {
            unset($options['resultIndicatorsAssociatedWithTotalByMonth']);
            $month = $options['month'];
            $labelsMonths = CommonObject::getLabelsMonths();

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('resultIndicatorsAssociatedWithTotalByMonth' => true, 'month' => $month));

            $childrens = $indicator->getChildrens();
            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $data['dataSource']['data'][] = $arrayVariables[$children->getId()];
                }
            }
            $data['dataSource']['data'][] = $arrayVariables['total'];

            $chart["xAxisName"] = $labelsMonths[$month];
        } elseif (isset($options['resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth']) && array_key_exists('resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth', $options)) {
            unset($options['resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth']);
            $month = $options['month'];
            $labelsMonths = CommonObject::getLabelsMonths();

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth' => true, 'month' => $month));

            $data['dataSource']['data'][] = $arrayVariables[Indicator::TYPE_OF_COMPANY_MATRIZ];
            $data['dataSource']['data'][] = $arrayVariables[Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA];
            $data['dataSource']['data'][] = $arrayVariables['total'];

            $chart["xAxisName"] = $labelsMonths[$month];
        }

        $data['dataSource']['chart'] = $chart;

        return $data;
    }

    public function getDataChartStackedColumn3d(Indicator $indicator, $options = array()) {

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Sales by quarter";
//        $chart["xAxisName"] = "Indicador";
        $chart["yAxisName"] = "TM";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "0";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";

        $category = $dataSetValues = array();

        if (isset($options['variablesByFrequencyNotificationWithTotal']) && array_key_exists('variablesByFrequencyNotificationWithTotal', $options)) {
            unset($options['variablesByFrequencyNotificationWithTotal']);

            if ($indicator->getDetails()) {
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('variablesByFrequencyNotificationWithTotal' => true));

            $totalValueIndicators = count($indicator->getValuesIndicator());
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            $variables = $indicator->getFormula()->getVariables();
            $contVariables = count($variables);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                foreach ($variables as $variable) {
                    $showValue = $arrayVariables[$variable->getName()][$i] == 0 ? 0 : 1;
                    $dataSetValues[$variable->getName()]['data'][] = array('value' => number_format($arrayVariables[$variable->getName()][$i], 2, ',', '.'), 'showValue' => $showValue);
                }

                $category[] = $label;
            }

//Añadimos el acumulado
            foreach ($variables as $variable) {
                $showValue = $arrayVariables[$variable->getName()]['total'] == 0 ? 0 : 1;
                $dataSetValues[$variable->getName()]['seriesname'] = $arrayVariables[$variable->getName()]['description'];
                $dataSetValues[$variable->getName()]['showValues'] = "1";
                $dataSetValues[$variable->getName()]['data'][] = array('value' => number_format($arrayVariables[$variable->getName()]['total'], 2, ',', '.'), 'showValue' => $showValue);
            }

            foreach ($indicator->getFormula()->getVariables() as $variable) {
                $data['dataSource']['dataset'][] = $dataSetValues[$variable->getName()];
            }

            $category[] = array('label' => 'ACUMUL');
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
//        $data['dataSource']['dataset'][] = $dataSetReal;
//        $data['dataSource']['dataset'][] = $dataSetPlan;

        return $data;
    }

    public function getDataChartLineMultiSeries(Indicator $indicator, $options = array()) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Sales by quarter";
        $chart["xAxisName"] = "Meses";
//        $chart["yAxisName"] = "TM";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "0";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["divlineThickness"] = "1";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";
        $chart["showAxisLines"] = "0";
        $chart["showAlternateHGridColor"] = "0";
//        $chart["showValues"] = "1";

        $category = $dataSetValues = array();

        if (isset($options['resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens']) && array_key_exists('resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens', $options)) {
            unset($options['resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens']);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens' => true));

            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            $variables = $indicator->getFormula()->getVariables();
            $contVariables = count($variables);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }

            $dataSetValues['MATRIZ'] = array('seriesname' => $arrayVariables['MATRIZ']['seriesname'], 'data' => $arrayVariables['MATRIZ']['data']);
            $dataSetValues['AFILIADA_MIXTA'] = array('seriesname' => $arrayVariables['AFILIADA_MIXTA']['seriesname'], 'data' => $arrayVariables['AFILIADA_MIXTA']['data']);
            $dataSetValues['PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['PERIODO_ACTUAL']['seriesname'], 'data' => $arrayVariables['PERIODO_ACTUAL']['data']);
            $dataSetValues['PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['PERIODO_ANTERIOR']['seriesname'], 'data' => $arrayVariables['PERIODO_ANTERIOR']['data']);

            $data['dataSource']['dataset'][] = $dataSetValues['MATRIZ'];
            $data['dataSource']['dataset'][] = $dataSetValues['AFILIADA_MIXTA'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ANTERIOR'];
        } elseif ((isset($options['resultIndicatorPersonalInjuryWithAccumulatedTime']) && array_key_exists('resultIndicatorPersonalInjuryWithAccumulatedTime', $options)) || (isset($options['resultIndicatorPersonalInjuryWithoutAccumulatedTime']) && array_key_exists('resultIndicatorPersonalInjuryWithoutAccumulatedTime', $options)) || (isset($options['resultIndicatorLostDaysAccumulatedTime']) && array_key_exists('resultIndicatorLostDaysAccumulatedTime', $options))) {
            unset($options[$options['path_array']]);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array($options['path_array'] => true, 'variables' => $options['variables'], 'path_array' => $options['path_array']));

            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            $variables = $indicator->getFormula()->getVariables();
            $contVariables = count($variables);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }

            $dataSetValues['PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['PERIODO_ACTUAL']['seriesname'], 'data' => $arrayVariables['PERIODO_ACTUAL']['data']);
            $dataSetValues['PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['PERIODO_ANTERIOR']['seriesname'], 'data' => $arrayVariables['PERIODO_ANTERIOR']['data']);

            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ANTERIOR'];
        } elseif ((isset($options['resultIndicatorWithTrendlineHorizontal']) && array_key_exists('resultIndicatorWithTrendlineHorizontal', $options))) {
            unset($options[$options['resultIndicatorWithTrendlineHorizontal']]);

            $arrayVariables = array();

            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
//            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotificationWithoutValidation($indicator);
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }

            if ($indicator->getId() == 1427) {
                $arrayVariables['GRUPO1'] = array('seriesname' => 'Mayores Deudores más Tripoliven, Ferralca', 'data' => array());
                $arrayVariables['GRUPO2'] = array('seriesname' => 'Mayores Deudores más Soca', 'data' => array());
//                $arrayVariables['CONSTANT'] = array('seriesname' => 'Meta Días de Rotación', 'data' => array());

                $arrayVariables['GRUPO1']['data'][] = array('value' => 56, 'showValue' => 1);
                $arrayVariables['GRUPO1']['data'][] = array('value' => 84, 'showValue' => 1);
                $arrayVariables['GRUPO1']['data'][] = array('value' => 59, 'showValue' => 1);
                $arrayVariables['GRUPO1']['data'][] = array('value' => 77, 'showValue' => 1);
                $arrayVariables['GRUPO2']['data'][] = array('value' => 32, 'showValue' => 1);
                $arrayVariables['GRUPO2']['data'][] = array('value' => 57, 'showValue' => 1);
                $arrayVariables['GRUPO2']['data'][] = array('value' => 36, 'showValue' => 1);
                $arrayVariables['GRUPO2']['data'][] = array('value' => 55, 'showValue' => 1);
//                $arrayVariables['CONSTANT']['data'][] = array('value' => 45, 'showValue' => 0);
//                $arrayVariables['CONSTANT']['data'][] = array('value' => 45, 'showValue' => 0);
//                $arrayVariables['CONSTANT']['data'][] = array('value' => 45, 'showValue' => 0);
//                $arrayVariables['CONSTANT']['data'][] = array('value' => 45, 'showValue' => 0);

                $dataSetValues['GRUPO1'] = array('seriesname' => $arrayVariables['GRUPO1']['seriesname'], 'data' => $arrayVariables['GRUPO1']['data'], 'color' => "#0174DF");
                $dataSetValues['GRUPO2'] = array('seriesname' => $arrayVariables['GRUPO2']['seriesname'], 'data' => $arrayVariables['GRUPO2']['data'], 'color' => "#FFBF00");
//                $dataSetValues['CONSTANT'] = array('seriesname' => $arrayVariables['CONSTANT']['seriesname'], 'data' => $arrayVariables['CONSTANT']['data']);

                $data['dataSource']['dataset'][] = $dataSetValues['GRUPO1'];
                $data['dataSource']['dataset'][] = $dataSetValues['GRUPO2'];
//                $data['dataSource']['dataset'][] = $dataSetValues['CONSTANT'];
                $line = array();
                $line[] = array("startvalue" => "45", "color" => "#088A08", "valueOnRight" => "1", "displayvalue" => "Meta Días de Rotación", "thickness" => "3");
                $data['dataSource']['trendlines'][] = array("line" => $line);
//                "trendlines": [
//                    {
//                        "line": [
//                            {
//                                "startvalue": "17022",
//                                "color": "#6baa01",
//                                "valueOnRight": "1",
//                                "displayvalue": "Average"
//                            }
//                        ]
//                    }
//                ]
            }
        } elseif ((isset($options['resultIndicatorWithTrendlineHorizontalOnlyResult']) && array_key_exists('resultIndicatorWithTrendlineHorizontalOnlyResult', $options))) {
            unset($options[$options['resultIndicatorWithTrendlineHorizontalOnlyResult']]);

            $arrayVariables = array();
            $maxValue = 0.0;

            $indicatorValues = $indicator->getValuesIndicator();
            $totalValueIndicators = count($indicatorValues);
            //$numberResults = $indicator->getNumberValueIndicatorToForce() > 0 ? $indicator->getNumberValueIndicatorToForce() : $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $numberResults = $indicator->getNumberValueIndicatorToForce() > 0 ? $indicator->getNumberValueIndicatorToForce() : $totalValueIndicators;
//            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotificationWithoutValidation($indicator);
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            //Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }

            $arrayVariables[$indicator->getId()] = array('seriesname' => $indicator->getSummary(), 'data' => array());

            $cont = 1;
            foreach ($indicatorValues as $indicatorValue) {
                if ($cont <= $numberResults) {
                    $arrayVariables[$indicator->getId()]['data'][] = array('value' => number_format($indicatorValue->getValueOfIndicator(), 2, ',', '.'), 'showValue' => 1);
                    if ($indicatorValue->getValueOfIndicator() > $maxValue) {
                        $maxValue = $indicatorValue->getValueOfIndicator();
                    }
                }
                $cont++;
            }

            $dataSetValues[$indicator->getId()] = array('seriesname' => $arrayVariables[$indicator->getId()]['seriesname'], 'data' => $arrayVariables[$indicator->getId()]['data'], 'color' => "#0174DF");
            $data['dataSource']['dataset'][] = $dataSetValues[$indicator->getId()];

            $valueGoal = 0.0;
            $tendency = $indicator->getTendency();
            $arrangementRange = $indicator->getArrangementRange();
            if ($tendency->getRef() == \Pequiven\MasterBundle\Entity\Tendency::TENDENCY_MAX) {
                $valueGoal = $arrangementRange->getRankTopBasic();
            } elseif ($tendency->getRef() == \Pequiven\MasterBundle\Entity\Tendency::TENDENCY_MIN) {
                $valueGoal = $arrangementRange->getRankBottomBasic();
            }


            if ($valueGoal > $maxValue) {
                $maxValue = $valueGoal + 1.0;
            }

            $chart["yAxisMaxValue"] = number_format($maxValue, 2, ',', '.');

            $line = array();
            $line[] = array("startvalue" => number_format($valueGoal, 2, ',', '.'), "color" => "#088A08", "valueOnRight" => "1", "displayvalue" => "Meta", "thickness" => "3");
            $data['dataSource']['trendlines'][] = array("line" => $line);
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;

        return $data;
    }

    /**
     *  RETORNA LA LISTA DE VARIABLES DE LA FORMULA DE UN INDICADOR EN FORMA DE ARREGLO INDEXADO
     * @param Indicator $indicator
     * @return type
     */
    public function getVariablesInArray(Indicator $indicator) {
        $formula = $indicator->getFormula();
        $variables = $formula->getVariables();


        $arr = array();
        foreach ($variables as $var) {
//$valor = $this->getValueOfVariableFromValueIndicator($indicator, );
            $arr[$var->getId()] = $var->getName();
        }

        return $arr;
    }

    /**
     * 
     * @param Indicator $indicator
     * @param type $options
     * @return type
     */
    public function getValueFromEquationFormula(Indicator $indicator, $options = array()) {
        $formula = $indicator->getFormula();
        $valuesIndicator = $indicator->getValuesIndicator();
        $details = $indicator->getDetails();
        $value = 0.0;
        $totalValuesIndicator = count($valuesIndicator);

        $contValue = 0;
        foreach ($valuesIndicator as $valueIndicator) {
            $contValue++;
            $flagLastResultValid = false;
            if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                continue;
            } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                    if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                        continue;
                    } else {
                        $flagLastResultValid = true;
                    }
                } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                    if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                        continue;
                    } else {
                        $flagLastResultValid = true;
                    }
                }
            }
            $valueFromCardEquation = $this->calculateFormulaValueFromCardEquation($formula, $valueIndicator->getFormulaParameters(), $options);
            if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                $value = $valueFromCardEquation;
            } else {
                $value = $value + $valueFromCardEquation;
            }
        }

        return $value;
    }

    /**
     * Función para 
     * @param Indicator $indicator
     * @return type
     */
    public function getArrayVariablesFormulaWithData(Indicator $indicator, $options = array()) {
        $formula = $indicator->getFormula();
        $valuesIndicator = $indicator->getValuesIndicator();
        $arrayVariables = array();
        $totalValuesIndicator = count($valuesIndicator);
        $details = $indicator->getDetails();


        if (isset($options['viewVariablesRealPlan']) && array_key_exists('viewVariablesRealPlan', $options)) {
            unset($options['viewVariablesRealPlan']);
            $unit = '';
            $arrayVariables['real_from_equation']['value'] = $arrayVariables['plan_from_equation']['value'] = 0.0;
            $arrayVariables['plan_from_equation']['unit'] = $arrayVariables['plan_from_equation']['unit'] = '';
            $arrayVariables['real_from_equation']['description'] = $indicator->getShowByRealValue();
            $arrayVariables['plan_from_equation']['description'] = $indicator->getShowByPlanValue();
            if ($indicator->getDetails()) {
                $arrayVariables['real_from_equation']['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables['plan_from_equation']['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }

                $parameters = $valueIndicator->getFormulaParameters();
                foreach ($parameters as $parameter => $key) {
                    if ($parameter == 'real_from_equation' || $parameter == 'plan_from_equation') {
                        if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                            $arrayVariables[$parameter]['value'] = $key;
                        } else {
                            $arrayVariables[$parameter]['value'] = $arrayVariables[$parameter]['value'] + $key;
                        }
                    }
                }
            }
        } elseif (isset($options['viewVariablesRealPlanAutomatic']) && array_key_exists('viewVariablesRealPlanAutomatic', $options)) {
            unset($options['viewVariablesRealPlanAutomatic']);
            $unit = '';
            $varReal = $formula->getVariableToRealValue();
            $arrayVariables[$varReal->getName()]['value'] = $indicator->getValueFinal();
            $arrayVariables[$varReal->getName()]['description'] = $varReal->getDescription();
            $arrayVariables[$varReal->getName()]['unit'] = '';
            $varPlan = $formula->getVariableToPlanValue();
            $arrayVariables[$varPlan->getName()]['value'] = $indicator->getTotalPlan();
            $arrayVariables[$varPlan->getName()]['description'] = $varPlan->getDescription();
            $arrayVariables[$varPlan->getName()]['unit'] = '';
            if ($indicator->getDetails()) {
                $arrayVariables[$varReal->getName()]['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables[$varPlan->getName()]['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
        } elseif (isset($options['viewVariablesRealPlanAutomaticByFrequencyNotification']) && array_key_exists('viewVariablesRealPlanAutomaticByFrequencyNotification', $options)) {
            unset($options['viewVariablesRealPlanAutomaticByFrequencyNotification']);
            $varReal = $formula->getVariableToRealValue();
            $varPlan = $formula->getVariableToPlanValue();
            $nameParameterReal = $varReal->getName();
            $nameParameterPlan = $varPlan->getName();
            $arrayVariables['descriptionReal'] = $varReal->getDescription();
            $arrayVariables['summaryReal'] = $varReal->getSummary();
            $arrayVariables['descriptionPlan'] = $varPlan->getDescription();
            $arrayVariables['summaryPlan'] = $varPlan->getSummary();
            foreach ($valuesIndicator as $valueIndicator) {
                $arrayVariables['valueReal'][] = $valueIndicator->getParameter($nameParameterReal);
                $arrayVariables['valuePlan'][] = $valueIndicator->getParameter($nameParameterPlan);
                $arrayVariables['medition'][] = $valueIndicator->getValueOfIndicator();
            }
        } elseif (isset($options['viewVariablesRealPlanFromEquationByFrequencyNotification']) && array_key_exists('viewVariablesRealPlanFromEquationByFrequencyNotification', $options)) {
            unset($options['viewVariablesRealPlanFromEquationByFrequencyNotification']);
            $arrayVariables['descriptionReal'] = $indicator->getShowByRealValue();
            $arrayVariables['descriptionPlan'] = $indicator->getShowByPlanValue();
            foreach ($valuesIndicator as $valueIndicator) {
                $parameters = $valueIndicator->getFormulaParameters();
                foreach ($parameters as $parameter => $key) {
                    if ($parameter == 'real_from_equation') {
                        $arrayVariables['valueReal'][] = $key;
                    } elseif ($parameter == 'plan_from_equation') {
                        $arrayVariables['valuePlan'][] = $key;
                    }
                }
                $arrayVariables['medition'][] = $valueIndicator->getValueOfIndicator();
            }
        } elseif (isset($options['viewVariablesSimpleAverageByFrequencyNotification']) && array_key_exists('viewVariablesSimpleAverageByFrequencyNotification', $options)) {
            unset($options['viewVariablesSimpleAverageByFrequencyNotification']);
            $arrayVariables['descriptionReal'] = $indicator->getShowByRealValue();
            $arrayVariables['descriptionPlan'] = $indicator->getShowByPlanValue();
            foreach ($valuesIndicator as $valueIndicator) {
                $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formula, $valueIndicator->getFormulaParameters());
                $arrayVariables['valueReal'][] = $valuesFromDashboardEquation['dashboardEquationReal'];
                $arrayVariables['valuePlan'][] = $valuesFromDashboardEquation['dashboardEquationPlan'];
                $arrayVariables['medition'][] = $valueIndicator->getValueOfIndicator();
            }
        } elseif (isset($options['viewVariablesMarkedReal']) && array_key_exists('viewVariablesMarkedReal', $options)) {
            unset($options['viewVariablesMarkedReal']);
            $variables = $formula->getVariables();
            foreach ($variables as $variable) {
                if ($variable->getShowRealInDashboardPie()) {
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }
            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }
                foreach ($variables as $variable) {
                    if ($variable->getShowRealInDashboardPie()) {
                        $nameParameter = $variable->getName();
                        if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                        } else {
                            $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                        }
                    }
                }
            }
        } elseif (isset($options['viewVariablesMarkedPlan']) && array_key_exists('viewVariablesMarkedPlan', $options)) {
            unset($options['viewVariablesMarkedPlan']);
            $variables = $formula->getVariables();
            foreach ($variables as $variable) {
                if ($variable->getShowPlanInDashboardPie()) {
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }
            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }
                foreach ($variables as $variable) {
                    if ($variable->getShowPlanInDashboardPie()) {
                        $nameParameter = $variable->getName();
                        if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                        } else {
                            $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                        }
                    }
                }
            }
        } elseif (isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification', $options)) {
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);
            $variables = $formula->getVariables();
            $varReal = $varPlan = '';
            foreach ($variables as $variable) {
                if ($variable->getShowRealInDashboardBarArea()) {
                    $varReal = $variable->getName();
                    $arrayVariables['descriptionReal'] = $variable->getDescription();
                    $arrayVariables['summaryReal'] = $variable->getSummary();
                } elseif ($variable->getShowPlanInDashboardBarArea()) {
                    $varPlan = $variable->getName();
                    $arrayVariables['descriptionPlan'] = $variable->getDescription();
                    $arrayVariables['summaryPlan'] = $variable->getSummary();
                }
            }

            foreach ($valuesIndicator as $valueIndicator) {
                $arrayVariables['valueReal'][] = $valueIndicator->getParameter($varReal);
                $arrayVariables['valuePlan'][] = $valueIndicator->getParameter($varPlan);
            }
        } elseif (isset($options['withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries', $options)) {
            unset($options['withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries']);
            $variables = $formula->getVariables();
            $varReal = $varPlan = '';
            $arrayVariables['descriptionReal'] = $arrayVariables['descriptionPlan'] = '';
            foreach ($variables as $variable) {
                if ($variable->getShowRealInDashboardColumn()) {
                    $varReal = $variable->getName();
                    $arrayVariables['descriptionReal'] = $variable->getDescription();
                    $arrayVariables['summaryReal'] = $variable->getSummary();
                } elseif ($variable->getShowPlanInDashboardColumn()) {
                    $varPlan = $variable->getName();
                    $arrayVariables['descriptionPlan'] = $variable->getDescription();
                    $arrayVariables['summaryPlan'] = $variable->getSummary();
                }
            }

            foreach ($valuesIndicator as $valueIndicator) {
                $arrayVariables['valueReal'][] = $valueIndicator->getParameter($varReal);
                $arrayVariables['valuePlan'][] = $valueIndicator->getParameter($varPlan);
            }
        } elseif (isset($options['withVariablesRealPlanFromDashboardEquation']) && array_key_exists('withVariablesRealPlanFromDashboardEquation', $options)) {
            unset($options['withVariablesRealPlanFromDashboardEquation']);

            $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationPlan']['value'] = 0.0;
            $arrayVariables['dashboardEquationReal']['unit'] = $arrayVariables['dashboardEquationPlan']['unti'] = '';
            $arrayVariables['dashboardEquationReal']['description'] = $arrayVariables['dashboardEquationPlan']['description'] = '';

            $arrayVariables['dashboardEquationReal']['description'] = $indicator->getShowByRealValue();
            $arrayVariables['dashboardEquationPlan']['description'] = $indicator->getShowByPlanValue();
            if ($indicator->getDetails()) {
                $arrayVariables['dashboardEquationReal']['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables['dashboardEquationPlan']['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }
                $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formula, $valueIndicator->getFormulaParameters());
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                    $arrayVariables['dashboardEquationReal']['value'] = $valuesFromDashboardEquation['dashboardEquationReal'];
                    $arrayVariables['dashboardEquationPlan']['value'] = $valuesFromDashboardEquation['dashboardEquationPlan'];
                } else {
                    $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationReal']['value'] + $valuesFromDashboardEquation['dashboardEquationReal'];
                    $arrayVariables['dashboardEquationPlan']['value'] = $arrayVariables['dashboardEquationPlan']['value'] + $valuesFromDashboardEquation['dashboardEquationPlan'];
                }
            }
        } elseif (isset($options['withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries']) && array_key_exists('withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries', $options)) {
            unset($options['withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries']);

            $childrens = $indicator->getChildrens();

            foreach ($childrens as $children) {//Inicializamos en 0, los valores para el gráfico
                $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] = 0.0;
            }

            foreach ($childrens as $children) {
                $childrenValuesIndicator = $children->getValuesIndicator();
                $formulaChildren = $children->getFormula();
                $totalChildrenValuesIndicator = count($childrenValuesIndicator);
                $contValue = 0;
                $detailsChildren = $children->getDetails();
                foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                    $contValue++;
                    $flagLastResultValid = false;
                    if ($detailsChildren->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalChildrenValuesIndicator) {
                        continue;
                    } elseif ($detailsChildren->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                        if ($formulaChildren->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                            if ($childrenValueIndicator->getParameter($formulaChildren->getVariableToRealValue()) == 0 && $childrenValueIndicator->getParameter($formulaChildren->getVariableToPlanValue()) == 0) {
                                continue;
                            } else {
                                $flagLastResultValid = true;
                            }
                        } elseif ($formulaChildren->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                            if ($childrenValueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $childrenValueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                                continue;
                            } else {
                                $flagLastResultValid = true;
                            }
                        }
                    }
                    $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formulaChildren, $childrenValueIndicator->getFormulaParameters());
                    if ($detailsChildren->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                        $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] = $valuesFromDashboardEquation['dashboardEquationReal'];
                        $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] = $valuesFromDashboardEquation['dashboardEquationPlan'];
                    } else {
                        $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] + $valuesFromDashboardEquation['dashboardEquationReal'];
                        $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] + $valuesFromDashboardEquation['dashboardEquationPlan'];
                    }
                }
            }
        } elseif (isset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries']) && array_key_exists('withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries', $options)) {
            unset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries']);

//            $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationPlan']['value'] = 0.0;
            $arrayVariables['dashboardEquationReal']['unit'] = $arrayVariables['dashboardEquationPlan']['unit'] = '';
            $arrayVariables['dashboardEquationReal']['description'] = $arrayVariables['dashboardEquationPlan']['description'] = '';

            $arrayVariables['dashboardEquationReal']['description'] = $indicator->getShowByRealValue();
            $arrayVariables['dashboardEquationPlan']['description'] = $indicator->getShowByPlanValue();
            if ($indicator->getDetails()) {
                $arrayVariables['dashboardEquationReal']['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables['dashboardEquationPlan']['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }

            foreach ($valuesIndicator as $valueIndicator) {
                $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formula, $valueIndicator->getFormulaParameters());
                $arrayVariables['dashboardEquationReal']['value'][] = $valuesFromDashboardEquation['dashboardEquationReal'];
                $arrayVariables['dashboardEquationPlan']['value'][] = $valuesFromDashboardEquation['dashboardEquationPlan'];
            }
        } elseif (isset($options['viewVariablesFromPlanEquation']) && array_key_exists('viewVariablesFromPlanEquation', $options)) {
            unset($options['viewVariablesFromPlanEquation']);
            $vars = $this->getArrayVars($formula, $formula->getSourceEquationPlan());
            $variables = $formula->getVariables();

            foreach ($variables as $variable) {
                if (array_search($variable->getName(), $vars)) {
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }

            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }
                foreach ($variables as $variable) {
                    if (array_search($variable->getName(), $vars)) {
                        $nameParameter = $variable->getName();
                        if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                        } else {
                            $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                        }
                    }
                }
            }
        } elseif (isset($options['viewVariablesFromRealEquation']) && array_key_exists('viewVariablesFromRealEquation', $options)) {
            unset($options['viewVariablesFromRealEquation']);
            $vars = $this->getArrayVars($formula, $formula->getSourceEquationReal());
            $variables = $formula->getVariables();

            foreach ($variables as $variable) {
                if (array_search($variable->getName(), $vars)) {
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }

            $contValue = 0;
            foreach ($valuesIndicator as $valueIndicator) {
                $contValue++;
                $flagLastResultValid = false;
                if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST && $contValue != $totalValuesIndicator) {
                    continue;
                } elseif ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID) {
                    if ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                        if ($valueIndicator->getParameter($formula->getVariableToRealValue()) == 0 && $valueIndicator->getParameter($formula->getVariableToPlanValue()) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    } elseif ($formula->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                        if ($valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_REAL) == 0 && $valueIndicator->getParameter(Formula\Variable::VARIABLE_REAL_AND_PLAN_FROM_EQ_PLAN) == 0) {
                            continue;
                        } else {
                            $flagLastResultValid = true;
                        }
                    }
                }
                foreach ($variables as $variable) {
                    if (array_search($variable->getName(), $vars)) {
                        $nameParameter = $variable->getName();
                        if ($details->getSourceResult() == Indicator\IndicatorDetails::SOURCE_RESULT_LAST_VALID && $flagLastResultValid == true) {
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                        } else {
                            $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                        }
                    }
                }
            }
        } elseif (isset($options['variablesByFrequencyNotificationWithTotal']) && array_key_exists('variablesByFrequencyNotificationWithTotal', $options)) {
            $variables = $formula->getVariables();

            foreach ($variables as $variable) {
                $nameParameter = $variable->getName();
                $arrayVariables[$nameParameter]['total'] = 0.0;
                $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
            }

            foreach ($valuesIndicator as $valueIndicator) {
                foreach ($variables as $variable) {
                    $nameParameter = $variable->getName();
                    $valVariableIndicator = $valueIndicator->getParameter($nameParameter);
                    $arrayVariables[$nameParameter][] = $valVariableIndicator;
                    $arrayVariables[$nameParameter]['total'] = $arrayVariables[$nameParameter]['total'] + $valVariableIndicator;
                }
            }
        } elseif (isset($options['resultIndicatorsAssociatedWithTotalByMonth']) && array_key_exists('resultIndicatorsAssociatedWithTotalByMonth', $options)) {
            unset($options['resultIndicatorsAssociatedWithTotalByMonth']);

            $month = $options['month'];
            $childrens = $indicator->getChildrens();
            $total = 0.0;
            $variables = $formula->getVariables();

            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $arrayVariables[$children->getId()] = array('label' => $children->getSummary(), 'value' => 0.0);
                }
            }

            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $childrenValuesIndicator = $children->getValuesIndicator();
                    $contChildrenValueIndicator = 1;
                    $variablesChildren = $children->getFormula()->getVariables();
                    foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                        if ($contChildrenValueIndicator == $month) {
                            foreach ($variablesChildren as $variableChildren) {
                                $nameParameter = $variableChildren->getName();
                                $valVariableChildren = $childrenValueIndicator->getParameter($nameParameter);
                                $arrayVariables[$children->getId()]['value'] = $arrayVariables[$children->getId()]['value'] + $valVariableChildren;
                                $total = $total + $valVariableChildren;
                            }
                        }
                        $contChildrenValueIndicator++;
                    }
                }
            }

            $arrayVariables['total'] = array('label' => 'Total Pequiven', 'value' => $total);
        } elseif (isset($options['resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth']) && array_key_exists('resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth', $options)) {
            unset($options['resultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth']);

            $month = $options['month'];
            $childrens = $indicator->getChildrens();
            $total = 0.0;
            $variables = $formula->getVariables();

            $labelsTypesOfCompanies = Indicator::getTypesOfCompanies();

            $arrayVariables[Indicator::TYPE_OF_COMPANY_MATRIZ] = array('label' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_MATRIZ], array(), 'PequivenMasterBundle'), 'value' => 0.0);
            $arrayVariables[Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA] = array('label' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA], array(), 'PequivenMasterBundle'), 'value' => 0.0);

            foreach ($childrens as $children) {
                $childrenValuesIndicator = $children->getValuesIndicator();
                $contChildrenValueIndicator = 1;
                $variablesChildren = $children->getFormula()->getVariables();
                foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                    if ($contChildrenValueIndicator == $month) {
                        foreach ($variablesChildren as $variableChildren) {
                            $nameParameter = $variableChildren->getName();
                            $valVariableChildren = $childrenValueIndicator->getParameter($nameParameter);
                            $arrayVariables[$children->getTypeOfCompany()]['value'] = $arrayVariables[$children->getTypeOfCompany()]['value'] + $valVariableChildren;
                            $total = $total + $valVariableChildren;
                        }
                    }
                    $contChildrenValueIndicator++;
                }
            }

            $arrayVariables['total'] = array('label' => 'Corporación', 'value' => $total);
        } elseif (isset($options['resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens']) && array_key_exists('resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens', $options)) {
            unset($options['resultIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens']);

            $childrens = $indicator->getChildrens();
            $variables = $formula->getVariables();


            $labelsTypesOfCompanies = Indicator::getTypesOfCompanies();

            $arrayVariables['MATRIZ'] = array('seriesname' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_MATRIZ], array(), 'PequivenMasterBundle'), 'data' => array());
            $arrayVariables['AFILIADA_MIXTA'] = array('seriesname' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA], array(), 'PequivenMasterBundle'), 'data' => array());
            $arrayVariables['PERIODO_ACTUAL'] = array('seriesname' => $indicator->getPeriod()->getName(), 'data' => array());
            $arrayVariables['PERIODO_ANTERIOR'] = array('seriesname' => $indicator->getPeriod()->getParent()->getName(), 'data' => array());

            $arrayVarsSpecific = array("lesionados_con_tiempo_perdido" => true, "lesiones_con_tiempo_perdido" => true, "lesionados_sin_tiempo_perdido" => true, "dias_perdidos" => true, "dias_perdidos_severidad" => true);
            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();

//Seteamos por defecto los valores por número de resultados totales
            for ($i = 1; $i <= $numberResults; $i++) {
                $result['MATRIZ']['value'][$i] = 0.0;
                $result['AFILIADA_MIXTA']['value'][$i] = 0.0;
                $result['PERIODO_ACTUAL']['value'][$i] = 0.0;
//                var_dump($result['PERIODO_ACTUAL']['value'][$i]);
                $result['PERIODO_ANTERIOR']['value'][$i] = 0.0;
            }
//            die();
//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrens as $children) {
                $childrenValuesIndicator = $children->getValuesIndicator();
                $contChildrenValueIndicator = 1;
                $variablesChildren = $children->getFormula()->getVariables();
                $totalChildrenValuesIndicator = count($childrenValuesIndicator);
                foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                    foreach ($variablesChildren as $variableChildren) {
                        if (array_key_exists($variableChildren->getName(), $arrayVarsSpecific)) {
                            $nameParameter = $variableChildren->getName();
                            $valVariableChildren = $childrenValueIndicator->getParameter($nameParameter);
                            if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                                $result['MATRIZ']['value'][$contChildrenValueIndicator] = $result['MATRIZ']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                            } elseif ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA) {
                                $result['AFILIADA_MIXTA']['value'][$contChildrenValueIndicator] = $result['AFILIADA_MIXTA']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                            }
                            $result['PERIODO_ACTUAL']['value'][$contChildrenValueIndicator] = $result['PERIODO_ACTUAL']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                        }
                    }
                    $contChildrenValueIndicator++;
                }
            }

            $em = $this->getDoctrine();
            $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $indicator->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));
            $indicatorLastPeriod = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());

            $childrensLastPeriod = $indicatorLastPeriod->getChildrens();
//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrensLastPeriod as $childrenLastPeriod) {
                $childrenLastPeriodValuesIndicator = $childrenLastPeriod->getValuesIndicator();
                $contChildrenLastPeriodValueIndicator = 1;
                $variablesChildrenLastPeriod = $childrenLastPeriod->getFormula()->getVariables();
                $totalChildrenLastPeriodValuesIndicator = count($childrenLastPeriodValuesIndicator);
                foreach ($childrenLastPeriodValuesIndicator as $childrenLastPeriodValueIndicator) {
                    foreach ($variablesChildrenLastPeriod as $variableChildrenLastPeriod) {
                        if (array_key_exists($variableChildrenLastPeriod->getName(), $arrayVarsSpecific)) {
                            $nameParameter = $variableChildrenLastPeriod->getName();
                            $valVariableChildrenLastPeriod = $childrenLastPeriodValueIndicator->getParameter($nameParameter);
                            $result['PERIODO_ANTERIOR']['value'][$contChildrenLastPeriodValueIndicator] = $result['PERIODO_ANTERIOR']['value'][$contChildrenLastPeriodValueIndicator] + $valVariableChildrenLastPeriod;
                        }
                    }
                    $contChildrenLastPeriodValueIndicator++;
                }
            }

//Seteamos el acumulado para cada serie
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($i > 1) {
                    $result['MATRIZ']['value'][$i] = $result['MATRIZ']['value'][$i] + $result['MATRIZ']['value'][$i - 1];
                    $result['AFILIADA_MIXTA']['value'][$i] = $result['AFILIADA_MIXTA']['value'][$i] + $result['AFILIADA_MIXTA']['value'][$i - 1];
                    $result['PERIODO_ACTUAL']['value'][$i] = $result['PERIODO_ACTUAL']['value'][$i] + $result['PERIODO_ACTUAL']['value'][$i - 1];
                    $result['PERIODO_ANTERIOR']['value'][$i] = $result['PERIODO_ANTERIOR']['value'][$i] + $result['PERIODO_ANTERIOR']['value'][$i - 1];
                }
            }

//Seteamos el arreglo a devolver para cada serie
            $showUntilMonth = 6; //TODO: Ponerlo por el administrador del indicador
            $showValue = 1;
            for ($i = 1; $i <= $numberResults; $i++) {
//                $showValue = $i <= $showUntilMonth ? 1 : 0;
                if ($i <= $showUntilMonth) {
                    $arrayVariables['MATRIZ']['data'][] = array('value' => $result['MATRIZ']['value'][$i], 'showValue' => $showValue);
                    $arrayVariables['AFILIADA_MIXTA']['data'][] = array('value' => $result['AFILIADA_MIXTA']['value'][$i], 'showValue' => $showValue);
                    $arrayVariables['PERIODO_ACTUAL']['data'][] = array('value' => $result['PERIODO_ACTUAL']['value'][$i], 'showValue' => $showValue);
                }
                $arrayVariables['PERIODO_ANTERIOR']['data'][] = array('value' => $result['PERIODO_ANTERIOR']['value'][$i], 'showValue' => $showValue);
            }
        } elseif ((isset($options['resultIndicatorPersonalInjuryWithAccumulatedTime']) && array_key_exists('resultIndicatorPersonalInjuryWithAccumulatedTime', $options)) || (isset($options['resultIndicatorPersonalInjuryWithoutAccumulatedTime']) && array_key_exists('resultIndicatorPersonalInjuryWithoutAccumulatedTime', $options)) || (isset($options['resultIndicatorLostDaysAccumulatedTime']) && array_key_exists('resultIndicatorLostDaysAccumulatedTime', $options))) {
            unset($options[$options['path_array']]);

            $childrens = $indicator->getChildrens();
            $variables = $formula->getVariables();

            $labelsTypesOfCompanies = Indicator::getTypesOfCompanies();

            $arrayVariables['PERIODO_ACTUAL'] = array('seriesname' => $indicator->getPeriod()->getName(), 'data' => array());
            $arrayVariables['PERIODO_ANTERIOR'] = array('seriesname' => $indicator->getPeriod()->getParent()->getName(), 'data' => array());

            $arrayVarsSpecific = $options['variables'];
            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();

//Seteamos por defecto los valores por número de resultados totales
            for ($i = 1; $i <= $numberResults; $i++) {
                $result['PERIODO_ACTUAL']['value'][$i] = 0.0;
                $result['PERIODO_ANTERIOR']['value'][$i] = 0.0;
            }

//Recorremos los valores del indicador
            $contValueIndicator = 1;
            $totalValuesIndicator = count($valuesIndicator);
            foreach ($valuesIndicator as $valueIndicator) {
                foreach ($variables as $variable) {
                    if (array_key_exists($variable->getName(), $arrayVarsSpecific)) {
                        $nameParameter = $variable->getName();
                        $valVariable = $valueIndicator->getParameter($nameParameter);
                        $result['PERIODO_ACTUAL']['value'][$contValueIndicator] = $result['PERIODO_ACTUAL']['value'][$contValueIndicator] + $valVariable;
                    }
                }
                $contValueIndicator++;
            }

            $em = $this->getDoctrine();
            $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $indicator->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));
            $indicatorLastPeriod = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());

//Recorremos los hijos para acumular los valores por número de resultados totales
            $lastPeriodValuesIndicator = $indicatorLastPeriod->getValuesIndicator();
            $contLastPeriodValueIndicator = 1;
            $variablesLastPeriod = $indicatorLastPeriod->getFormula()->getVariables();
            $totalLastPeriodValuesIndicator = count($lastPeriodValuesIndicator);
            foreach ($lastPeriodValuesIndicator as $lastPeriodValueIndicator) {
                foreach ($variablesLastPeriod as $variableLastPeriod) {
                    if (array_key_exists($variableLastPeriod->getName(), $arrayVarsSpecific)) {
                        $nameParameter = $variableLastPeriod->getName();
                        $valVariableLastPeriod = $lastPeriodValueIndicator->getParameter($nameParameter);
                        $result['PERIODO_ANTERIOR']['value'][$contLastPeriodValueIndicator] = $result['PERIODO_ANTERIOR']['value'][$contLastPeriodValueIndicator] + $valVariableLastPeriod;
                    }
                }
                $contLastPeriodValueIndicator++;
            }


//Seteamos el acumulado para cada serie
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($i > 1) {
                    $result['PERIODO_ACTUAL']['value'][$i] = $result['PERIODO_ACTUAL']['value'][$i] + $result['PERIODO_ACTUAL']['value'][$i - 1];
                    $result['PERIODO_ANTERIOR']['value'][$i] = $result['PERIODO_ANTERIOR']['value'][$i] + $result['PERIODO_ANTERIOR']['value'][$i - 1];
                }
            }

//Seteamos el arreglo a devolver para cada serie
            $showUntilMonth = 6; //TODO: Ponerlo por el administrador del indicador
            $showValue = 1;
            for ($i = 1; $i <= $numberResults; $i++) {
//                $showValue = $i <= $showUntilMonth ? 1 : 0;
                if ($i <= $showUntilMonth) {
                    $arrayVariables['PERIODO_ACTUAL']['data'][] = array('value' => $result['PERIODO_ACTUAL']['value'][$i], 'showValue' => $showValue);
                }
                $arrayVariables['PERIODO_ANTERIOR']['data'][] = array('value' => $result['PERIODO_ANTERIOR']['value'][$i], 'showValue' => $showValue);
            }
        } elseif (isset($options['resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated']) && array_key_exists('resultIndicatorsAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodAccumulated', $options)) {
            unset($options['path_array']);

            $childrens = $indicator->getChildrens();
            $variables = $formula->getVariables();
            $showUntilMonth = 3;
//[children][periodo][value]

            $arrayVarsSpecific = $options['variables'];
            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();

//Seteamos por defecto los valores por número de resultados totales
            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $result[$children->getRef()][$children->getPeriod()->getName()]['value'] = 0.0;
                    $result[$children->getRef()][$children->getPeriod()->getParent()->getName()]['value'] = 0.0;
                }
            }
            $result[$indicator->getPeriod()->getName()]['total'] = 0.0;
            $result[$indicator->getPeriod()->getParent()->getName()]['total'] = 0.0;

//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrens as $children) {
                $childrenValuesIndicator = $children->getValuesIndicator();
                $contChildrenValueIndicator = 1;
                $variablesChildren = $children->getFormula()->getVariables();
                $totalChildrenValuesIndicator = count($childrenValuesIndicator);
                foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                    if ($contChildrenValueIndicator <= $showUntilMonth) {
                        foreach ($variablesChildren as $variableChildren) {
                            if (array_key_exists($variableChildren->getName(), $arrayVarsSpecific)) {
                                $nameParameter = $variableChildren->getName();
                                $valVariableChildren = $childrenValueIndicator->getParameter($nameParameter);
                                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                                    $result[$children->getRef()][$children->getPeriod()->getName()]['value'] = $result[$children->getRef()][$children->getPeriod()->getName()]['value'] + $valVariableChildren;
                                    $result[$indicator->getPeriod()->getName()]['total'] = $result[$indicator->getPeriod()->getName()]['total'] + $valVariableChildren;
                                }
                            }
                        }
                    }
                    $contChildrenValueIndicator++;
                }
            }

            $em = $this->getDoctrine();

//            $childrensLastPeriod = $indicatorLastPeriod->getChildrens();
//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrens as $children) {
                if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                    $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $children->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));
                    $childrenLastPeriod = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());

                    $childrenLastPeriodValuesIndicator = $childrenLastPeriod->getValuesIndicator();
                    $contChildrenLastPeriodValueIndicator = 1;
                    $variablesChildrenLastPeriod = $childrenLastPeriod->getFormula()->getVariables();
                    $totalChildrenLastPeriodValuesIndicator = count($childrenLastPeriodValuesIndicator);
                    foreach ($childrenLastPeriodValuesIndicator as $childrenLastPeriodValueIndicator) {
                        foreach ($variablesChildrenLastPeriod as $variableChildrenLastPeriod) {
                            if (array_key_exists($variableChildrenLastPeriod->getName(), $arrayVarsSpecific)) {
                                $nameParameter = $variableChildrenLastPeriod->getName();
                                $valVariableChildrenLastPeriod = $childrenLastPeriodValueIndicator->getParameter($nameParameter);
                                $result[$children->getRef()][$childrenLastPeriod->getPeriod()->getName()]['value'] = $result[$children->getRef()][$childrenLastPeriod->getPeriod()->getName()]['value'] + $valVariableChildrenLastPeriod;
                                $result[$indicator->getPeriod()->getParent()->getName()]['total'] = $result[$indicator->getPeriod()->getParent()->getName()]['total'] + $valVariableChildrenLastPeriod;
                            }
                        }
                        $contChildrenLastPeriodValueIndicator++;
                    }
                }
            }

            $arrayVariables = $result;
        } elseif (isset($options['resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated', $options)) {
            unset($options['path_array']);

            $childrens = $indicator->getChildrens();
            $variables = $formula->getVariables();

            $labelsTypesOfCompanies = Indicator::getTypesOfCompanies();

            $arrayVariables['MATRIZ'] = array('seriesname' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_MATRIZ], array(), 'PequivenMasterBundle'), 'renderAs' => 'line', 'data' => array());
            $arrayVariables['AFILIADA_MIXTA'] = array('seriesname' => $this->trans($labelsTypesOfCompanies[Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA], array(), 'PequivenMasterBundle'), 'renderAs' => 'line', 'data' => array());
            $arrayVariables['PERIODO_ACTUAL'] = array('seriesname' => $indicator->getPeriod()->getName(), 'renderAs' => 'line', 'data' => array());
            $arrayVariables['PERIODO_ANTERIOR'] = array('seriesname' => $indicator->getPeriod()->getParent()->getName(), 'renderAs' => 'line', 'data' => array());
            $arrayVariables['ACUMULADO_PERIODO_ACTUAL'] = array('seriesname' => 'Acumulado 2015', 'data' => array(), "parentYAxis" => "S", 'renderAs' => 'column');
            $arrayVariables['ACUMULADO_PERIODO_ANTERIOR'] = array('seriesname' => 'Acumulado 2014', 'data' => array(), "parentYAxis" => "S", 'renderAs' => 'column');

            $arrayVarsSpecific = $options['variables'];
            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();

//Seteamos por defecto los valores por número de resultados totales
            for ($i = 1; $i <= $numberResults; $i++) {
                $result['MATRIZ']['value'][$i] = 0.0;
                $result['AFILIADA_MIXTA']['value'][$i] = 0.0;
                $result['PERIODO_ACTUAL']['value'][$i] = 0.0;
                $result['PERIODO_ANTERIOR']['value'][$i] = 0.0;
            }
            $result['ACUMULADO_PERIODO_ACTUAL']['value'] = 0.0;
            $result['ACUMULADO_PERIODO_ANTERIOR']['value'] = 0.0;

//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrens as $children) {
                $childrenValuesIndicator = $children->getValuesIndicator();
                $contChildrenValueIndicator = 1;
                $variablesChildren = $children->getFormula()->getVariables();
                $totalChildrenValuesIndicator = count($childrenValuesIndicator);
                foreach ($childrenValuesIndicator as $childrenValueIndicator) {
                    foreach ($variablesChildren as $variableChildren) {
                        if (array_key_exists($variableChildren->getName(), $arrayVarsSpecific)) {
                            $nameParameter = $variableChildren->getName();
                            $valVariableChildren = $childrenValueIndicator->getParameter($nameParameter);
                            if ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_MATRIZ) {
                                $result['MATRIZ']['value'][$contChildrenValueIndicator] = $result['MATRIZ']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                            } elseif ($children->getTypeOfCompany() == Indicator::TYPE_OF_COMPANY_AFFILIATED_MIXTA) {
                                $result['AFILIADA_MIXTA']['value'][$contChildrenValueIndicator] = $result['AFILIADA_MIXTA']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                            }
                            $result['PERIODO_ACTUAL']['value'][$contChildrenValueIndicator] = $result['PERIODO_ACTUAL']['value'][$contChildrenValueIndicator] + $valVariableChildren;
                        }
                    }
                    $contChildrenValueIndicator++;
                }
            }

            $em = $this->getDoctrine();
            $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $indicator->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));
            $indicatorLastPeriod = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());

            $childrensLastPeriod = $indicatorLastPeriod->getChildrens();
//Recorremos los hijos para acumular los valores por número de resultados totales
            foreach ($childrensLastPeriod as $childrenLastPeriod) {
                $childrenLastPeriodValuesIndicator = $childrenLastPeriod->getValuesIndicator();
                $contChildrenLastPeriodValueIndicator = 1;
                $variablesChildrenLastPeriod = $childrenLastPeriod->getFormula()->getVariables();
                $totalChildrenLastPeriodValuesIndicator = count($childrenLastPeriodValuesIndicator);
                foreach ($childrenLastPeriodValuesIndicator as $childrenLastPeriodValueIndicator) {
                    foreach ($variablesChildrenLastPeriod as $variableChildrenLastPeriod) {
                        if (array_key_exists($variableChildrenLastPeriod->getName(), $arrayVarsSpecific)) {
                            $nameParameter = $variableChildrenLastPeriod->getName();
                            $valVariableChildrenLastPeriod = $childrenLastPeriodValueIndicator->getParameter($nameParameter);
                            $result['PERIODO_ANTERIOR']['value'][$contChildrenLastPeriodValueIndicator] = $result['PERIODO_ANTERIOR']['value'][$contChildrenLastPeriodValueIndicator] + $valVariableChildrenLastPeriod;
                        }
                    }
                    $contChildrenLastPeriodValueIndicator++;
                }
            }

            $showUntilMonth = 6; //TODO: Ponerlo por el administrador del indicador
//Seteamos el acumulado para cada serie
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($i <= $showUntilMonth) {
                    $result['ACUMULADO_PERIODO_ACTUAL']['value'] = $result['ACUMULADO_PERIODO_ACTUAL']['value'] + $result['PERIODO_ACTUAL']['value'][$i];
                }
                $result['ACUMULADO_PERIODO_ANTERIOR']['value'] = $result['ACUMULADO_PERIODO_ANTERIOR']['value'] + $result['PERIODO_ANTERIOR']['value'][$i];
            }

//Seteamos el arreglo a devolver para cada serie
            $showValue = 1;
            for ($i = 1; $i <= $numberResults; $i++) {
//                $showValue = $i <= $showUntilMonth ? 1 : 0;
                if ($i <= $showUntilMonth) {
                    $arrayVariables['MATRIZ']['data'][] = array('value' => $result['MATRIZ']['value'][$i], 'showValue' => $showValue);
                    $arrayVariables['AFILIADA_MIXTA']['data'][] = array('value' => $result['AFILIADA_MIXTA']['value'][$i], 'showValue' => $showValue);
                    $arrayVariables['PERIODO_ACTUAL']['data'][] = array('value' => $result['PERIODO_ACTUAL']['value'][$i], 'showValue' => $showValue);
                }
                $arrayVariables['PERIODO_ANTERIOR']['data'][] = array('value' => $result['PERIODO_ANTERIOR']['value'][$i], 'showValue' => $showValue);
                $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'][] = array('value' => 0.0, 'showValue' => 0);
                $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'][] = array('value' => 0.0, 'showValue' => 0);
            }

            $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'][] = array('value' => $result['ACUMULADO_PERIODO_ACTUAL']['value'], 'showValue' => $showValue);
            $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'][] = array('value' => $result['ACUMULADO_PERIODO_ANTERIOR']['value'], 'showValue' => $showValue);
        } elseif ((isset($options['resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated', $options)) || (isset($options['resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated', $options)) || (isset($options['resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated', $options))) {
            unset($options['path_array']);

            $childrens = $indicator->getChildrens();
            $variables = $formula->getVariables();

            $arrayVariables['PERIODO_ACTUAL'] = array('seriesname' => $indicator->getPeriod()->getName(), 'data' => array(), 'renderAs' => 'line');
            $arrayVariables['PERIODO_ANTERIOR'] = array('seriesname' => $indicator->getPeriod()->getParent()->getName(), 'data' => array(), 'renderAs' => 'line');
            $arrayVariables['ACUMULADO_PERIODO_ACTUAL'] = array('seriesname' => 'Acumulado 2015', 'data' => array(), "parentYAxis" => "S", 'renderAs' => 'column');
            $arrayVariables['ACUMULADO_PERIODO_ANTERIOR'] = array('seriesname' => 'Acumulado 2014', 'data' => array(), "parentYAxis" => "S", 'renderAs' => 'column');

            $arrayVarsSpecific = $options['variables'];
            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();

//Seteamos por defecto los valores por número de resultados totales
            for ($i = 1; $i <= $numberResults; $i++) {
                $result['PERIODO_ACTUAL']['value'][$i] = 0.0;
                $result['PERIODO_ANTERIOR']['value'][$i] = 0.0;
            }
            $result['ACUMULADO_PERIODO_ACTUAL']['value'] = 0.0;
            $result['ACUMULADO_PERIODO_ANTERIOR']['value'] = 0.0;

//Recorremos los valores del indicador
            $contValueIndicator = 1;
            $totalValuesIndicator = count($valuesIndicator);
            foreach ($valuesIndicator as $valueIndicator) {
                foreach ($variables as $variable) {
                    if (array_key_exists($variable->getName(), $arrayVarsSpecific)) {
                        $nameParameter = $variable->getName();
                        $valVariable = $valueIndicator->getParameter($nameParameter);
                        $result['PERIODO_ACTUAL']['value'][$contValueIndicator] = $result['PERIODO_ACTUAL']['value'][$contValueIndicator] + $valVariable;
                    }
                }
                $contValueIndicator++;
            }

            $em = $this->getDoctrine();
            $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $indicator->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));
            $indicatorLastPeriod = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());

//Recorremos los hijos para acumular los valores por número de resultados totales
            $lastPeriodValuesIndicator = $indicatorLastPeriod->getValuesIndicator();
            $contLastPeriodValueIndicator = 1;
            $variablesLastPeriod = $indicatorLastPeriod->getFormula()->getVariables();
            $totalLastPeriodValuesIndicator = count($lastPeriodValuesIndicator);
            foreach ($lastPeriodValuesIndicator as $lastPeriodValueIndicator) {
                foreach ($variablesLastPeriod as $variableLastPeriod) {
                    if (array_key_exists($variableLastPeriod->getName(), $arrayVarsSpecific)) {
                        $nameParameter = $variableLastPeriod->getName();
                        $valVariableLastPeriod = $lastPeriodValueIndicator->getParameter($nameParameter);
                        $result['PERIODO_ANTERIOR']['value'][$contLastPeriodValueIndicator] = $result['PERIODO_ANTERIOR']['value'][$contLastPeriodValueIndicator] + $valVariableLastPeriod;
                    }
                }
                $contLastPeriodValueIndicator++;
            }

            $showUntilMonth = 6; //TODO: Ponerlo por el administrador del indicador
//Seteamos el acumulado para cada serie
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($i <= $showUntilMonth) {
                    $result['ACUMULADO_PERIODO_ACTUAL']['value'] = $result['ACUMULADO_PERIODO_ACTUAL']['value'] + $result['PERIODO_ACTUAL']['value'][$i];
                }
                $result['ACUMULADO_PERIODO_ANTERIOR']['value'] = $result['ACUMULADO_PERIODO_ANTERIOR']['value'] + $result['PERIODO_ANTERIOR']['value'][$i];
            }

//Seteamos el arreglo a devolver para cada serie
            $showValue = 1;
            for ($i = 1; $i <= $numberResults; $i++) {
//                $showValue = $i <= $showUntilMonth ? 1 : 0;
                if ($i <= $showUntilMonth) {
                    $arrayVariables['PERIODO_ACTUAL']['data'][] = array('value' => $result['PERIODO_ACTUAL']['value'][$i], 'showValue' => $showValue);
                }
                $arrayVariables['PERIODO_ANTERIOR']['data'][] = array('value' => $result['PERIODO_ANTERIOR']['value'][$i], 'showValue' => $showValue);
                $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'][] = array('value' => 0.0, 'showValue' => 0);
                $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'][] = array('value' => 0.0, 'showValue' => 0);
            }

            $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'][] = array('value' => $result['ACUMULADO_PERIODO_ACTUAL']['value'], 'showValue' => $showValue);
            $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'][] = array('value' => $result['ACUMULADO_PERIODO_ANTERIOR']['value'], 'showValue' => $showValue);
        }

        return $arrayVariables;
    }

    /**
     * Función que retorna el valor acumulado de una variable, de acuerdo a las notificaciones que tenga el indicador
     * @param Indicator $indicator
     * @param \Pequiven\MasterBundle\Entity\Formula\Variable $variable
     * @return type
     */
    public function getValueOfVariableFromValueIndicator(Indicator $indicator, \Pequiven\MasterBundle\Entity\Formula\Variable $variable) {
        $valueVariable = 0.0;
        $valuesIndicator = $indicator->getValuesIndicator();
        foreach ($valuesIndicator as $valueIndicator) {
            $nameParameter = $variable->getName();
            $valueVariable = $valueVariable + $valueIndicator->getParameter($nameParameter);
        }
        return $valueVariable;
    }

    public function getDataPyramid3DSectioned(Indicator $indicator, $options = array()) {
        $chart = array(
            'dataSource' => array(
                'chart' => array(),
                'data' => array(),
            ),
        );

//CARGO LAS CONFIGURACIONES DEL GRAFICO
        $chart["dataSource"]["chart"] = array(
            "theme" => "fint",
            "showLegend" => "1",
            "caption" => $indicator->getDescription(),
            "captionOnTop" => "1",
            "captionPadding" => "25",
            "captionFontSize" => "16",
            "alignCaptionWithCanvas" => "1",
//            "subcaption" => "Credit Suisse 2013",            
            "borderAlpha" => "20",
            "is2D" => "0",
            "bgColor" => "FFFFFF",
            "showValues" => "1",
            "showlabels" => "0",
//            "numberPrefix" => "Bs./TM",
            "numberSuffix" => " Bs./TM",
//            "plotTooltext" => "Valor del Indicador",
            "showPercentValues" => "0",
            "chartLeftMargin" => "40",
            "thousandSeparator" => ".",
            "decimalSeparator" => ",",
            "decimals" => "0",
            "forceDecimals" => "1",
            "formatNumberScale" => "0",
            "showvalues" => 1
        );

        $colors = array(
            1 => "BDBDBD",
            2 => "CB3D3A",
            3 => "FF8F26",
            4 => "3C7BCF",
            5 => "9BC348",
            6 => "FFFFCC",
            7 => "FFFFFF",
            8 => "FFFFFF",
            9 => "FFFFFF",
            10 => "FFFFFF",
        );

        $idflagColor = $indicator->getId();
        $flagColor = 0;
        $i = 1;
        $indicatorPadre = $indicator;
        $value = 0;

        while (($indicatorPadre->getParent()) != null) {
            $indicatorPadre = $indicatorPadre->getParent();
        }

//PARA REAL    
        if ((isset($options["type"])) && ($options["type"] == 'real')) {
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicatorPadre, array('viewVariablesFromRealEquation' => true));
            foreach ($arrayVariables as $key => $arrays) {
                $arregloVariables[$key] = $arrays["value"];
            }
            $valor = $this->calculateFormulaValueFromSourceEquation($indicatorPadre->getFormula(), $arregloVariables);
            $value = $valor["sourceEquationReal"];
        }

//PARA PLAN    
        if ((isset($options["type"])) && ($options["type"] == 'plan')) {
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicatorPadre, array('viewVariablesFromPlanEquation' => true));
            foreach ($arrayVariables as $key => $arrays) {
                $arregloVariables[$key] = $arrays["value"];
            }
            $valor = $this->calculateFormulaValueFromSourceEquation($indicatorPadre->getFormula(), $arregloVariables);
            $value = $valor["sourceEquationPlan"];
        }

        if ($indicatorPadre->getId() == $idflagColor) {
            $flagColor = 1;
        }
        if ($flagColor == 1) {
            $colorItem = $colors[$i];
        } else {
            $colorItem = "FFFFFF";
        }
        if ($flagColor == 1) {
            $configPadre = array(
                "id" => $indicatorPadre->getId(),
                "label" => str_replace("% Cumplimiento de ", "", $indicatorPadre->getDescription()),
                "value" => $value,
                "color" => $colorItem,
                "type" => $indicatorPadre->getIndicatorLevel()->getDescription(),
                "tooltext" => $indicatorPadre->getIndicatorLevel()->getDescription(),
                "link" => $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorPadre->getId())),
            );

            $chart["dataSource"]["data"][] = $configPadre;
        }

//        $indicadoresHijos = $indicatorPadre->getChildrens();
//        $indicadorHijo = $indicadoresHijos[0];
        $indicadorHijo = $indicatorPadre;

        while ((count($indicadorHijo->getChildrens()) > 0) && ($indicadorHijo != null)) {
            $tempvarios = $indicadorHijo->getChildrens();
            $temp = $tempvarios[0];
            $i++;
            $value = 0;

//PARA REAL        
            if ((isset($options["type"])) && ($options["type"] == 'real')) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($temp, array('viewVariablesFromRealEquation' => true));
                foreach ($arrayVariables as $key => $arrays) {
                    $arregloVariables[$key] = $arrays["value"];
                }
                $valor = $this->calculateFormulaValueFromSourceEquation($temp->getFormula(), $arregloVariables);
                $value = $valor["sourceEquationReal"];
            }

//PARA PLAN    
            if ((isset($options["type"])) && ($options["type"] == 'plan')) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($temp, array('viewVariablesFromPlanEquation' => true));
                foreach ($arrayVariables as $key => $arrays) {
                    $arregloVariables[$key] = $arrays["value"];
                }
                $valor = $this->calculateFormulaValueFromSourceEquation($temp->getFormula(), $arregloVariables);
                $value = $valor["sourceEquationPlan"];
            }

            if ($temp->getId() == $idflagColor) {
                $flagColor = 1;
            }
            if ($flagColor == 1) {
                $colorItem = $colors[$i];
            } else {
                $colorItem = "FFFFFF";
            }
            if ($flagColor == 1) {
                $config = array(
                    "id" => $temp->getId(),
                    "label" => str_replace("% Cumplimiento de ", "", $temp->getDescription()),
                    "value" => $value,
                    "color" => $colorItem,
                    "type" => $temp->getIndicatorLevel()->getDescription(),
                    "tooltext" => $indicatorPadre->getIndicatorLevel()->getDescription(),
                    "link" => $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $temp->getId())),
                );

                $chart["dataSource"]["data"][] = $config;
            }
            $indicadorHijo = $temp;
        }


//        var_dump(json_encode($chart["dataSource"]["data"]));
//        die();
        return $chart;
    }

    public function getDataStackedColumn3DbyIndicator(Indicator $indicator, $options = array()) {
        $chart = array(
            'dataSource' => array(
                'chart' => array(),
                'data' => array(),
            ),
        );

        if (isset($options["colors"])) {
            $colors = $options["colors"];
            $indicatorPadre = $indicator;

            //VALIDO SOLO PARA LOS INDICADORES DE COSTO UNITARIO
            $i = 2;
            while (($indicatorPadre->getParent()) != null) {
                $indicatorPadre = $indicatorPadre->getParent();
                $i++;
            }
            $colorbase = $colors[$i];
        } else {
            $colorbase = "";
        }

//CARGO LAS CONFIGURACIONES DEL GRAFICO
        $chart["dataSource"]["chart"] = array(
            "palette" => "2",
            "bgColor" => "#FFFFFF",
            "caption" => $indicator->getDescription(),
            "captionOnTop" => "1",
            "captionPadding" => "25",
            "captionFontSize" => "16",
            "yAxisName" => "Bs./TM",
            "showlabels" => "1",
            "showvalues" => "1",            
            "showsum" => "0",
            "valueFontColor" => "#000000",
            "valueFontBold" => "0",
            "valueFontSize" => "10",
            "thousandSeparator" => ".",
            "decimalSeparator" => ",",
            "formatNumberScale" => "0",
            "decimals" => "0",
            "useroundedges" => "1",
            "legendborderalpha" => "0",
            "showborder" => "0"
        );

//TRAIGO LOS VALORES PLAN Y REAL DE LAS VARIABLES
        $arrayVariablesP = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesFromPlanEquation' => true));
        $arrayVariablesR = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesFromRealEquation' => true));

//CATEGORIAS DEL ARRAY
        $chart["dataSource"]["categories"][] = array(
            "category" => array(
                array("label" => "PRESUPUESTO"),
                array("label" => "REAL")
            )
        );


        $index = 0;
        foreach ($arrayVariablesP as $arrays) {
            $valoresP[] = str_replace(".", ",", $arrays["value"]);
            $labels[] = ucwords(str_replace(array("ppto ", "Ppto "), "", $arrays["description"]));
            $index++;
        }

        foreach ($arrayVariablesR as $arrays) {
            $valoresR[] = str_replace(".", ",", $arrays["value"]);
            $labels[] = ucwords(str_replace(array("Real ", "real "), "", $arrays["description"]));
        }

//CONSTRUYO LOS VALORES DE LOS ITEMS
        for ($i = 0; $i < $index; $i++) {

            if ($i == 0) {
                $color = $colorbase;
                $child = $indicator->getChildrens();
                if ($child[0] != null) {
                    $link = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $child[0]->getId()));
                } else {
                    $link = "";
                }
            } else {
                $color = "";
                $link = "";
            }

            $value = array(
                array(
                    "value" => $valoresP[$i],
//                    "color" => $color,
                    "link" => $link,
                    "label" => $labels[$i]
                ),
                array(
                    "value" => $valoresR[$i],
//                    "color" => $color,
                    "link" => $link,
                    "label" => $labels[$i]
                ),
            );

            $datos[] = array(
                'seriesname' => $labels[$i],
                'color' => $color,
                'data' => $value
            );
        }

        $chart["dataSource"]["dataset"] = $datos;
        //var_dump(json_encode($chart["dataSource"]["dataset"]));
//        die();
        return $chart;
    }

    /**
     * Gráfico de Columna con Línea y 2 ejes (Para mostar la infocamción de 2 variables respecto al eje izquierdo y el resultado de la medición respecto al eje derecho)
     * @param Indicator $indicator
     * @return type
     */
    public function getChartColumnLineDualAxis(Indicator $indicator, $options = array()) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );
        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["xAxisname"] = "Indicador";
        $chart["pYAxisName"] = "TM";
        $chart["sYAxisName"] = "% Cumplimiento";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
//        $chart["labelDisplay"] = "ROTATE";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";

        $totalNumChildrens = count($indicator->getChildrens()); //Número de indicadores asociados

        $category = $dataSetReal = $dataSetPlan = $medition = array();
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        $medition["seriesname"] = "% Cumplimiento";
        $medition["renderas"] = "line";
        $medition["parentYAxis"] = "S";
        $medition["showValues"] = "0";

        if (isset($options['childrens']) && array_key_exists('childrens', $options)) {
            unset($options['childrens']);
            if ($totalNumChildrens > 0) {//La info a mostrar es de los indicadores asociados
                $indicatorsChildrens = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicator->getId()); //Obtenemos los indicadores asociados
                if ($indicator->getDetails()) {
                    $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
                }
                foreach ($indicatorsChildrens as $indicatorChildren) {
                    $label = $dataReal = $dataPlan = $dataMedition = array();
                    $label["label"] = $indicatorChildren->getSummary();
                    $dataReal["value"] = number_format($indicatorChildren->getValueFinal(), 2, ',', '.');
                    $dataPlan["value"] = number_format($indicatorChildren->getTotalPlan(), 2, ',', '.');
                    $dataMedition["value"] = number_format($indicatorChildren->getResultReal(), 2, ',', '.');
                    if (count($indicatorChildren->getCharts()) > 0) {
                        $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                        $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                        $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    }

                    $category[] = $label;
                    $dataSetReal["data"][] = $dataReal;
                    $dataSetPlan["data"][] = $dataPlan;
                    $medition["data"][] = $dataMedition;
                }
            }

            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
            $data['dataSource']['dataset'][] = $medition;
        } elseif (isset($options['withVariablesRealPLan']) && array_key_exists('withVariablesRealPLan', $options)) {//La info a mostrar es de los resultados propios en base al real o plan
            unset($options['withVariablesRealPLan']);
            if ($indicator->getDetails()) {
                $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            $label = $dataReal = $dataPlan = $dataMedition = array();
            $label["label"] = $indicator->getSummary();
            $dataReal["value"] = number_format($indicator->getValueFinal(), 2, ',', '.');
            $dataPlan["value"] = number_format($indicator->getTotalPlan(), 2, ',', '.');
            $dataMedition["value"] = number_format($indicator->getResultReal(), 2, ',', '.');
            if (count($indicator->getCharts()) > 0) {
                $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
            }

            $category[] = $label;
            $dataSetReal["data"][] = $dataReal;
            $dataSetPlan["data"][] = $dataPlan;
            $medition["data"][] = $dataMedition;

            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
            $data['dataSource']['dataset'][] = $medition;
        } elseif (isset($options['byFrequencyNotification']) && array_key_exists('byFrequencyNotification', $options)) {

//FÍSICO ACUMULADO
            $arrayIndicators[2600] = 88.45;
            $arrayIndicators[2609] = 74.97;
            $arrayIndicators[2611] = 100.0;
            $arrayIndicators[2607] = 90.39;
            $arrayIndicators[2602] = 81.73;
            $arrayIndicators[2605] = 81.73;
            $arrayIndicators[1870] = 82.35;
            $arrayIndicators[1910] = 93.08;
            $arrayIndicators[1912] = 100.0;
            $arrayIndicators[1906] = 80.90;
            $arrayIndicators[1914] = 78.0;
            $arrayIndicators[1904] = 60.0;
            $arrayIndicators[1908] = 82.14;
            $arrayIndicators[1862] = 44.65;
            $arrayIndicators[1858] = 30.60;
            $arrayIndicators[1854] = 7.82;
            $arrayIndicators[1860] = 31.73;
            $arrayIndicators[2595] = 24.80;
            $arrayIndicators[1354] = 49.02;

//FINANCIERO ACUMULADO
            $arrayIndicators[2601] = 804.15;
            $arrayIndicators[2608] = 422.15;
            $arrayIndicators[2610] = 261.70;
            $arrayIndicators[2606] = 120.30;
            $arrayIndicators[2603] = 128.20;
            $arrayIndicators[2604] = 128.20;
            $arrayIndicators[1871] = 589.52;
            $arrayIndicators[1913] = 16.26;
            $arrayIndicators[1911] = 168.82;
            $arrayIndicators[1907] = 60.28;
            $arrayIndicators[1915] = 121.58;
            $arrayIndicators[1905] = 40.29;
            $arrayIndicators[1909] = 182.29;
            $arrayIndicators[1863] = 62.69;
            $arrayIndicators[1859] = 59.10;
            $arrayIndicators[1855] = 80.63;
            $arrayIndicators[1861] = 607.95;
            $arrayIndicators[2596] = 5.69;
            $arrayIndicators[1355] = 2337.93;

//FÍSICO ANUAL
            $arrayIndicators[2650] = 25.47;
            $arrayIndicators[2643] = 16.97;
            $arrayIndicators[2645] = 29.13;
            $arrayIndicators[2641] = 30.30;
            $arrayIndicators[2652] = 81.73;
            $arrayIndicators[2648] = 81.73;
            $arrayIndicators[2666] = 15.47;
            $arrayIndicators[2662] = 6.82;
            $arrayIndicators[2660] = 0.0;
            $arrayIndicators[2656] = 16.18;
            $arrayIndicators[2664] = 23.96;
            $arrayIndicators[2654] = 29.65;
            $arrayIndicators[2658] = 16.20;
            $arrayIndicators[2674] = 16.36;
            $arrayIndicators[2668] = 28.80;
            $arrayIndicators[2676] = 3.37;
            $arrayIndicators[2670] = 11.74;
            $arrayIndicators[2672] = 17.0;
            $arrayIndicators[2684] = 24.99;

//FINANCIERO ANUAL
            $arrayIndicators[2651] = 292.42;
            $arrayIndicators[2644] = 87.51;
            $arrayIndicators[2647] = 166.41;
            $arrayIndicators[2642] = 38.50;
            $arrayIndicators[2653] = 128.20;
            $arrayIndicators[2649] = 128.20;
            $arrayIndicators[2667] = 180.84;
            $arrayIndicators[2663] = 35.74;
            $arrayIndicators[2661] = 4.92;
            $arrayIndicators[2657] = 31.37;
            $arrayIndicators[2665] = 22.18;
            $arrayIndicators[2655] = 18.58;
            $arrayIndicators[2659] = 68.05;
            $arrayIndicators[2675] = 13.44;
            $arrayIndicators[2669] = 55.28;
            $arrayIndicators[2677] = 69.81;
            $arrayIndicators[2671] = 21.74;
            $arrayIndicators[2673] = 4.66;
            $arrayIndicators[2685] = 766.39;

            unset($options['byFrequencyNotification']);
            if ($indicator->getDetails()) {
                $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            $arrayVariables = array();
            if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesSimpleAverageByFrequencyNotification' => true));
            }

            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $medition["seriesname"] = $indicator->getSummary();
            $medition["renderas"] = "line";
            $medition["parentYAxis"] = "S";
            $medition["showValues"] = "0";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
            $realAccumulated = $planAccumulated = 0.0;

            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] != 0 || $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }

            for ($i = 0; $i < $resultNumbers; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');
                $dataMedition["value"] = number_format($arrayVariables['medition'][$i], 2, ',', '.');
//                $label["label"] = $i;
//                $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
//                $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
//                $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));

                $realAccumulated = $realAccumulated + $arrayVariables['valueReal'][$i];
                $planAccumulated = $planAccumulated + $arrayVariables['valuePlan'][$i];

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                if (!$indicator->getShowColumnPlanOneTimeInDashboard()) {
                    $dataSetPlan["data"][] = $dataPlan;
                }
                $medition["data"][] = $dataMedition;
            }

            if ($indicator->getShowColumnAccumulativeInDashboard()) {
                $category[] = array('label' => 'Acumulado');
                $dataSetReal["data"][] = array('value' => number_format($realAccumulated, 2, ',', '.'));
                $dataSetPlan["data"][] = array('value' => number_format($planAccumulated, 2, ',', '.'));
            }

            if ($indicator->getShowColumnPlanOneTimeInDashboard() || $indicator->getShowColumnPlanAtTheEnd()) {
                $category[] = array('label' => 'Plan Anual');
                $valuePlanAtTheEnd = $arrayVariables['valuePlan'][2];
                if (array_key_exists($indicator->getId(), $arrayIndicators)) {
                    $valuePlanAtTheEnd = $arrayIndicators[$indicator->getId()];
                }
                $dataSetReal["data"][] = array('value' => number_format($valuePlanAtTheEnd, 2, ',', '.'), 'color' => '#E91212');
            }


            $data['dataSource']['dataset'][] = $dataSetReal;
            if (!$indicator->getShowColumnPlanOneTimeInDashboard()) {
                $data['dataSource']['dataset'][] = $dataSetPlan;
            }
            $data['dataSource']['dataset'][] = $medition;
        } elseif (isset($options['byDifferentFrequencyNotification']) && array_key_exists('byDifferentFrequencyNotification', $options)) {

            unset($options['byDifferentFrequencyNotification']);
            if ($indicator->getDetails()) {
                $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            $arrayVariables = array();
            if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            }

            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["color"] = "#298A08";
            $dataSetPlan["color"] = "#0101DF";
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $medition["seriesname"] = $indicator->getSummary();
            $medition["renderas"] = "line";
            $medition["parentYAxis"] = "S";
            $medition["showValues"] = "0";
            $medition["color"] = "#B40404";

            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
            $totalValueIndicators = count($indicator->getValuesIndicator());
            $realAccumulated = $planAccumulated = 0.0;

            $realNumberResults = 0; //Número Reales de Valores del Indicador
            $maxVisualizeNumberResults = 0; //Máximo Número de Valores del Indicador
            $arrayVariablesResultsGroup = array(); //ARreglo de Resultados Agrupados por la Frecuencia Seleccionada
            $step = 0; //Paso o Salto de acuerdo a la Frecuencia seleccionada
            if ($indicator->getShowDashboardByQuarter()) {//COnsultados si el indicador será mostrado de acuerdo a una frecuencia trimestral
                $realNumberResults = count($indicator->getValuesIndicator());
                $step = 3;
                $maxVisualizeNumberResults = (int) ($realNumberResults / $step);
                $labelsFrequencyNotificationArray = $this->getLabelsFrequencyNotificationByDaysOfFrequency(90);
                if ($indicator->getResultIsAccumulative()) {
                    $labelsFrequencyNotificationArray = $this->setLabelsFrequencyNotificationByNumbersOfResults(4, $labelsFrequencyNotificationArray, 'until');
                }

                for ($i = 1; $i <= $maxVisualizeNumberResults; $i++) {
                    $arrayVariablesResultsGroup['valueReal'][$i] = 0.0;
                    $arrayVariablesResultsGroup['valuePlan'][$i] = 0.0;
                    $arrayVariablesResultsGroup['medition'][$i] = 0.0;
                }
            }

            $resultNumbers = 1;
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] != 0 || $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }
//            var_dump($resultNumbers);die();

            $contStep = 1;
            $numberOfStep = 1;
            $valTempReal = 0.0;
            $valTempPlan = 0.0;
            $valTempMedition = 0.0;
            for ($i = 0; $i < $resultNumbers; $i++) {
                $valTempReal = $valTempReal + $arrayVariables['valueReal'][$i];
                $valTempPlan = $valTempPlan + $arrayVariables['valuePlan'][$i];
                $valTempMedition = $valTempMedition + $arrayVariables['medition'][$i];
                if ($contStep == $step) {
                    $arrayVariablesResultsGroup['valueReal'][$numberOfStep] = $arrayVariablesResultsGroup['valueReal'][$numberOfStep] + $valTempReal;
                    $arrayVariablesResultsGroup['valuePlan'][$numberOfStep] = $arrayVariablesResultsGroup['valuePlan'][$numberOfStep] + $valTempPlan;
                    $arrayVariablesResultsGroup['medition'][$numberOfStep] = $arrayVariablesResultsGroup['medition'][$numberOfStep] + $valTempMedition;
                    $valTempReal = $valTempPlan = $valTempMedition = 0.0;
                    $numberOfStep++;
                    $contStep = 0;
                }
                $contStep++;
            }
//            var_dump($arrayVariablesResultsGroup);die();
            for ($i = 1; $i <= $maxVisualizeNumberResults; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $labelsFrequencyNotificationArray[$i];
                if ($indicator->getResultIsAccumulative()) {
                    $varTempReal = 0.0;
                    $varTempPlan = 0.0;
                    $varTempMedition = 0.0;
                    for ($j = 1; $j <= $i; $j++) {
                        $varTempReal = $varTempReal + $arrayVariablesResultsGroup['valueReal'][$j];
                        $varTempPlan = $varTempPlan + $arrayVariablesResultsGroup['valuePlan'][$j];
                        $varTempMedition = $varTempMedition + $arrayVariablesResultsGroup['medition'][$j];
                    }
                    $dataReal["value"] = number_format($varTempReal, 2, ',', '.');
                    $dataReal["color"] = "#298A08";
                    $dataPlan["color"] = "#0101DF";
                    $dataPlan["value"] = number_format($varTempPlan, 2, ',', '.');
                    $dataMedition["value"] = number_format($varTempMedition, 2, ',', '.');
                    $dataMedition["color"] = "#B40404";
                } else {
                    $dataReal["value"] = number_format($arrayVariablesResultsGroup['valueReal'][$i], 2, ',', '.');
                    $dataPlan["value"] = number_format($arrayVariablesResultsGroup['valuePlan'][$i], 2, ',', '.');
                    $dataMedition["value"] = number_format($arrayVariablesResultsGroup['medition'][$i], 2, ',', '.');
                }

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
                $medition["data"][] = $dataMedition;
            }

            $data['dataSource']['dataset'][] = $dataSetReal;
            $data['dataSource']['dataset'][] = $dataSetPlan;
            $data['dataSource']['dataset'][] = $medition;
        } elseif (isset($options['resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyAccumulated', $options)) {
            unset($options[$options['path_array']]);

            $chart["subCaption"] = $indicator->getShowByRealValue();
            $chart["pYAxisName"] = $indicator->getShowByPlanValue();
            $chart["rotateValues"] = "0";

            unset($chart["sYAxisName"]);
            unset($chart["sNumberSuffix"]);
            unset($chart["sYAxisMaxValue"]);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array($options['path_array'] => true, 'variables' => $options['variables'], 'path_array' => $options['path_array']));

            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            $variables = $indicator->getFormula()->getVariables();
            $contVariables = count($variables);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }

            $category[] = array('label' => 'Acumulado');

            $dataSetValues['MATRIZ'] = array('seriesname' => $arrayVariables['MATRIZ']['seriesname'], 'renderAs' => $arrayVariables['MATRIZ']['renderAs'], 'data' => $arrayVariables['MATRIZ']['data']);
            $dataSetValues['AFILIADA_MIXTA'] = array('seriesname' => $arrayVariables['AFILIADA_MIXTA']['seriesname'], 'renderAs' => $arrayVariables['AFILIADA_MIXTA']['renderAs'], 'data' => $arrayVariables['AFILIADA_MIXTA']['data']);
            $dataSetValues['PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['PERIODO_ACTUAL']['seriesname'], 'renderAs' => $arrayVariables['PERIODO_ACTUAL']['renderAs'], 'data' => $arrayVariables['PERIODO_ACTUAL']['data']);
            $dataSetValues['PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['PERIODO_ANTERIOR']['seriesname'], 'renderAs' => $arrayVariables['PERIODO_ANTERIOR']['renderAs'], 'data' => $arrayVariables['PERIODO_ANTERIOR']['data']);
            $dataSetValues['ACUMULADO_PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['seriesname'], 'data' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'], 'parentYAxis' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['parentYAxis'], 'renderAs' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['renderAs']);
            $dataSetValues['ACUMULADO_PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['seriesname'], 'data' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'], 'parentYAxis' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['parentYAxis'], 'renderAs' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['renderAs']);

            $data['dataSource']['dataset'][] = $dataSetValues['MATRIZ'];
            $data['dataSource']['dataset'][] = $dataSetValues['AFILIADA_MIXTA'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ANTERIOR'];
            $data['dataSource']['dataset'][] = $dataSetValues['ACUMULADO_PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['ACUMULADO_PERIODO_ANTERIOR'];
        } elseif ((isset($options['resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodAccumulated', $options)) || (isset($options['resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodAccumulated', $options)) || (isset($options['resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated']) && array_key_exists('resultIndicatorLostDaysByFrequencyNotificationByPeriodAccumulated', $options))) {
            unset($options[$options['path_array']]);

            unset($chart["sYAxisName"]);
            unset($chart["sNumberSuffix"]);
            unset($chart["sYAxisMaxValue"]);

            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array($options['path_array'] => true, 'variables' => $options['variables'], 'path_array' => $options['path_array']));

            $numberResults = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

            $variables = $indicator->getFormula()->getVariables();
            $contVariables = count($variables);

//Añadimos los valores, por frecuencia de notificación
            for ($i = 0; $i < $numberResults; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i + 1)];

                $category[] = $label;
            }


            $category[] = array('label' => 'Acumulado');

            $dataSetValues['PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['PERIODO_ACTUAL']['seriesname'], 'renderAs' => $arrayVariables['PERIODO_ACTUAL']['renderAs'], 'data' => $arrayVariables['PERIODO_ACTUAL']['data']);
            $dataSetValues['PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['PERIODO_ANTERIOR']['seriesname'], 'renderAs' => $arrayVariables['PERIODO_ANTERIOR']['renderAs'], 'data' => $arrayVariables['PERIODO_ANTERIOR']['data']);
            $dataSetValues['ACUMULADO_PERIODO_ACTUAL'] = array('seriesname' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['seriesname'], 'data' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['data'], 'parentYAxis' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['parentYAxis'], 'renderAs' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['renderAs']);
            $dataSetValues['ACUMULADO_PERIODO_ANTERIOR'] = array('seriesname' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['seriesname'], 'data' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['data'], 'parentYAxis' => $arrayVariables['ACUMULADO_PERIODO_ACTUAL']['parentYAxis'], 'renderAs' => $arrayVariables['ACUMULADO_PERIODO_ANTERIOR']['renderAs']);

            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['PERIODO_ANTERIOR'];
            $data['dataSource']['dataset'][] = $dataSetValues['ACUMULADO_PERIODO_ACTUAL'];
            $data['dataSource']['dataset'][] = $dataSetValues['ACUMULADO_PERIODO_ANTERIOR'];
        } elseif (isset($options['progressProjectsByFrequencyNotification']) && array_key_exists('progressProjectsByFrequencyNotification', $options)) {
            unset($options[$options['path_array']]);

            unset($chart["sYAxisName"]);
            unset($chart["sNumberSuffix"]);
            unset($chart["sYAxisMaxValue"]);
            unset($chart["pYAxisName"]);

            $arrayVariables = array();
//$arrayVariables[idIndicador][tipo_valor][numero_resultado][valor] = '';
//Avance Físico
            $arrayVariables[2600]['real'] = array(1 => 63.69, 2 => 64.47);
            $arrayVariables[2600]['plan'] = array(1 => 66.35, 2 => 72.98, 3 => 77.36, 4 => 88.45);
            $arrayVariables[2600]['maxValue'] = 90;
            $arrayVariables[2600]['pYAxisName'] = '% Avance';
            $arrayVariables[2609]['real'] = array(1 => 58.83, 2 => 58.95);
            $arrayVariables[2609]['plan'] = array(1 => 60.69, 2 => 68.31, 3 => 73.19, 4 => 74.97);
            $arrayVariables[2609]['maxValue'] = 80;
            $arrayVariables[2609]['pYAxisName'] = '% Avance';
            $arrayVariables[2611]['real'] = array(1 => 70.75, 2 => 71.06);
            $arrayVariables[2611]['plan'] = array(1 => 71.75, 2 => 74.02, 3 => 75.48, 4 => 100.0);
            $arrayVariables[2611]['maxValue'] = 100;
            $arrayVariables[2611]['pYAxisName'] = '% Avance';
            $arrayVariables[2607]['real'] = array(1 => 61.50, 2 => 63.40);
            $arrayVariables[2607]['plan'] = array(1 => 66.60, 2 => 76.62, 3 => 83.42, 4 => 90.39);
            $arrayVariables[2607]['maxValue'] = 100;
            $arrayVariables[2607]['pYAxisName'] = '% Avance';
            $arrayVariables[2602]['real'] = array(1 => 34.73, 2 => 35.03);
            $arrayVariables[2602]['plan'] = array(1 => 35.34, 2 => 52.72, 3 => 70.18, 4 => 81.73);
            $arrayVariables[2602]['maxValue'] = 90;
            $arrayVariables[2602]['pYAxisName'] = '% Avance';
            $arrayVariables[2605]['real'] = array(1 => 34.73, 2 => 35.03);
            $arrayVariables[2605]['plan'] = array(1 => 35.34, 2 => 52.72, 3 => 70.18, 4 => 81.73);
            $arrayVariables[2605]['maxValue'] = 90;
            $arrayVariables[2605]['pYAxisName'] = '% Avance';
            $arrayVariables[1870]['real'] = array(1 => 61.14, 2 => 61.56);
            $arrayVariables[1870]['plan'] = array(1 => 68.12, 2 => 72.51, 3 => 77.52, 4 => 83.15);
            $arrayVariables[1870]['maxValue'] = 90;
            $arrayVariables[1870]['pYAxisName'] = '% Avance';
            $arrayVariables[1910]['real'] = array(1 => 87.79, 2 => 87.82);
            $arrayVariables[1910]['plan'] = array(1 => 89.0, 2 => 91.0, 3 => 92.0, 4 => 93.0);
            $arrayVariables[1910]['maxValue'] = 100;
            $arrayVariables[1910]['pYAxisName'] = '% Avance';
            $arrayVariables[1912]['real'] = array(1 => 50.50, 2 => 50.50);
            $arrayVariables[1912]['plan'] = array(1 => 50.65, 2 => 68.65, 3 => 86.65, 4 => 100.0);
            $arrayVariables[1912]['maxValue'] = 100;
            $arrayVariables[1912]['pYAxisName'] = '% Avance';
            $arrayVariables[1906]['real'] = array(1 => 74.80, 2 => 74.80);
            $arrayVariables[1906]['plan'] = array(1 => 78.94, 2 => 79.54, 3 => 82.08, 4 => 86.91);
            $arrayVariables[1906]['maxValue'] = 90;
            $arrayVariables[1906]['pYAxisName'] = '% Avance';
            $arrayVariables[1914]['real'] = array(1 => 54.06, 2 => 55.60);
            $arrayVariables[1914]['plan'] = array(1 => 89.06, 2 => 91.99, 3 => 94.51, 4 => 96.58);
            $arrayVariables[1914]['maxValue'] = 100;
            $arrayVariables[1914]['pYAxisName'] = '% Avance';
            $arrayVariables[1904]['real'] = array(1 => 27.72, 2 => 28.0);
            $arrayVariables[1904]['plan'] = array(1 => 28.87, 2 => 28.87, 3 => 32.10, 4 => 41.79);
            $arrayVariables[1904]['maxValue'] = 50;
            $arrayVariables[1904]['pYAxisName'] = '% Avance';
            $arrayVariables[1908]['real'] = array(1 => 71.96, 2 => 72.66);
            $arrayVariables[1908]['plan'] = array(1 => 72.18, 2 => 74.99, 3 => 77.79, 4 => 80.60);
            $arrayVariables[1908]['maxValue'] = 90;
            $arrayVariables[1908]['pYAxisName'] = '% Avance';
            $arrayVariables[1862]['real'] = array(1 => 7.76, 2 => 7.76);
            $arrayVariables[1862]['plan'] = array(1 => 30.26, 2 => 34.13, 3 => 37.95, 4 => 44.65);
            $arrayVariables[1862]['maxValue'] = 50;
            $arrayVariables[1862]['pYAxisName'] = '% Avance';
            $arrayVariables[1858]['real'] = array(1 => 0.0, 2 => 0.0);
            $arrayVariables[1858]['plan'] = array(1 => 0.01, 2 => 0.90, 3 => 1.44, 4 => 1.8);
            $arrayVariables[1858]['maxValue'] = 10;
            $arrayVariables[1858]['pYAxisName'] = '% Avance';
            $arrayVariables[1854]['real'] = array(1 => 4.45, 2 => 4.60);
            $arrayVariables[1854]['plan'] = array(1 => 4.48, 2 => 4.53, 3 => 5.82, 4 => 7.82);
            $arrayVariables[1854]['maxValue'] = 10;
            $arrayVariables[1854]['pYAxisName'] = '% Avance';
            $arrayVariables[1860]['real'] = array(1 => 19.20, 2 => 19.25);
            $arrayVariables[1860]['plan'] = array(1 => 21.76, 2 => 22.96, 3 => 25.61, 4 => 32.25);
            $arrayVariables[1860]['maxValue'] = 40;
            $arrayVariables[1860]['pYAxisName'] = '% Avance';
            $arrayVariables[2595]['real'] = array(1 => 10.63, 2 => 14.40);
            $arrayVariables[2595]['plan'] = array(1 => 10.66, 2 => 18.32, 3 => 25.82, 4 => 33.50);
            $arrayVariables[2595]['maxValue'] = 40;
            $arrayVariables[2595]['pYAxisName'] = '% Avance';
            $arrayVariables[1354]['real'] = array(1 => 25.20, 2 => 25.88);
            $arrayVariables[1354]['plan'] = array(1 => 29.62, 2 => 34.88, 3 => 40.21, 4 => 46.67);
            $arrayVariables[1354]['maxValue'] = 50;
            $arrayVariables[1354]['pYAxisName'] = '% Avance';
//  Avance Financiero
            $arrayVariables[2601]['real'] = array(1 => 8.30, 2 => 20.88);
            $arrayVariables[2601]['plan'] = array(1 => 70.14, 2 => 160.85, 3 => 130.05, 4 => 292.42);
            $arrayVariables[2601]['maxValue'] = 300;
            $arrayVariables[2608]['real'] = array(1 => 7.23, 2 => 8.18);
            $arrayVariables[2608]['plan'] = array(1 => 36.76, 2 => 59.72, 3 => 72.56, 4 => 87.51);
            $arrayVariables[2608]['maxValue'] = 90;
            $arrayVariables[2610]['real'] = array(1 => 0.49, 2 => 1.04);
            $arrayVariables[2610]['plan'] = array(1 => 9.78, 2 => 17.13, 3 => 22.89, 4 => 166.41);
            $arrayVariables[2610]['maxValue'] = 170;
            $arrayVariables[2606]['real'] = array(1 => 0.31, 2 => 11.66);
            $arrayVariables[2606]['plan'] = array(1 => 23.60, 2 => 30.0, 3 => 34.60, 4 => 38.50);
            $arrayVariables[2606]['maxValue'] = 40;
            $arrayVariables[2603]['real'] = array(1 => 4.47, 2 => 4.53);
            $arrayVariables[2603]['plan'] = array(1 => 54.60, 2 => 107.60, 3 => 126.0, 4 => 128.20);
            $arrayVariables[2603]['maxValue'] = 130;
            $arrayVariables[2604]['real'] = array(1 => 4.47, 2 => 4.53);
            $arrayVariables[2604]['plan'] = array(1 => 54.60, 2 => 107.60, 3 => 126.0, 4 => 128.20);
            $arrayVariables[2604]['maxValue'] = 130;
            $arrayVariables[1871]['real'] = array(1 => 22.41, 2 => 29.16);
            $arrayVariables[1871]['plan'] = array(1 => 96.45, 2 => 220.50, 3 => 316.76, 4 => 363.69);
            $arrayVariables[1871]['maxValue'] = 370;
            $arrayVariables[1911]['real'] = array(1 => 2.92, 2 => 2.92);
            $arrayVariables[1911]['plan'] = array(1 => 0.0, 2 => 31.48, 3 => 64.25, 4 => 64.25);
            $arrayVariables[1911]['maxValue'] = 70;
            $arrayVariables[1913]['real'] = array(1 => 0.66, 2 => 1.15);
            $arrayVariables[1913]['plan'] = array(1 => 35.50, 2 => 35.50, 3 => 35.50, 4 => 35.50);
            $arrayVariables[1913]['maxValue'] = 40;
            $arrayVariables[1907]['real'] = array(1 => 0.0, 2 => 3.93);
            $arrayVariables[1907]['plan'] = array(1 => 0.24, 2 => 12.89, 3 => 39.93, 4 => 56.86);
            $arrayVariables[1907]['maxValue'] = 60;
            $arrayVariables[1915]['real'] = array(1 => 5.42, 2 => 5.42);
            $arrayVariables[1915]['plan'] = array(1 => 3.71, 2 => 17.23, 3 => 28.61, 4 => 44.07);
            $arrayVariables[1915]['maxValue'] = 50;
            $arrayVariables[1905]['real'] = array(1 => 3.85, 2 => 5.23);
            $arrayVariables[1905]['plan'] = array(1 => 37.34, 2 => 55.49, 3 => 76.73, 4 => 88.01);
            $arrayVariables[1905]['maxValue'] = 90;
            $arrayVariables[1909]['real'] = array(1 => 9.56, 2 => 10.51);
            $arrayVariables[1909]['plan'] = array(1 => 19.66, 2 => 67.91, 3 => 71.74, 4 => 75.0);
            $arrayVariables[1909]['maxValue'] = 80;
            $arrayVariables[1863]['real'] = array(1 => 0.0, 2 => 0.13);
            $arrayVariables[1863]['plan'] = array(1 => 5.38, 2 => 11.50, 3 => 11.99, 4 => 13.44);
            $arrayVariables[1863]['maxValue'] = 20;
            $arrayVariables[1859]['real'] = array(1 => 0.0, 2 => 0.0);
            $arrayVariables[1859]['plan'] = array(1 => 29.18, 2 => 37.14, 3 => 44.22, 4 => 55.28);
            $arrayVariables[1859]['maxValue'] = 60;
            $arrayVariables[1855]['real'] = array(1 => 3.0, 2 => 3.0);
            $arrayVariables[1855]['plan'] = array(1 => 6.27, 2 => 64.66, 3 => 67.23, 4 => 69.81);
            $arrayVariables[1855]['maxValue'] = 10;
            $arrayVariables[1861]['real'] = array(1 => 554.10, 2 => 560.21);
            $arrayVariables[1861]['plan'] = array(1 => 557.65, 2 => 565.04, 3 => 571.57, 4 => 575.17);
            $arrayVariables[1861]['maxValue'] = 580;
            $arrayVariables[2596]['real'] = array(1 => 0.0, 2 => 0.0);
            $arrayVariables[2596]['plan'] = array(1 => 0.0, 2 => 2.0, 3 => 29.13, 4 => 116.60);
            $arrayVariables[2596]['maxValue'] = 120;
            $arrayVariables[1355]['real'] = array(1 => 227.66, 2 => 497.39);
            $arrayVariables[1355]['plan'] = array(1 => 819.67, 2 => 1115.29, 3 => 1296.95, 4 => 1614.61);
            $arrayVariables[1355]['maxValue'] = 1700;

            $chart["pYAxisName"] = $arrayVariables[$indicator->getId()]['pYAxisName'];

            $numberResultsTotal = $indicator->getFrequencyNotificationIndicator()->getNumberResultsFrequency();
            $numberResultShowReal = 2;
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotificationWithoutValidation($indicator);

            $result['real']['data'] = array();
            $result['plan']['data'] = array();
            $result['desviacion']['data'] = array();
            $chart["sYAxisMaxValue"] = $arrayVariables[$indicator->getId()]['maxValue'];

//Añadimos los valores, por frecuencia de notificación
            for ($i = 1; $i <= $numberResultsTotal; $i++) {
                $label = array();
                $label["label"] = $labelsFrequencyNotificationArray[$i];
                if ($i <= $numberResultShowReal) {
                    $result['real']['data'][] = array('value' => number_format($arrayVariables[$indicator->getId()]['real'][$i], 2, ',', '.'));
                    $result['desviacion']['data'][] = array('value' => number_format($arrayVariables[$indicator->getId()]['plan'][$i] - $arrayVariables[$indicator->getId()]['real'][$i], 2, ',', '.'));
                }
                $result['plan']['data'][] = array('value' => number_format($arrayVariables[$indicator->getId()]['plan'][$i], 2, ',', '.'));

                $category[] = $label;
            }

            $dataSetValues['real'] = array('seriesname' => 'Avance', 'renderAs' => 'line', 'data' => $result['real']['data']);
            $dataSetValues['plan'] = array('seriesname' => 'Plan', 'renderAs' => 'line', 'data' => $result['plan']['data']);
            $dataSetValues['desviacion'] = array('seriesname' => 'Desviación', 'data' => $result['desviacion']['data'], 'parentYAxis' => 'P', 'renderAs' => 'column', 'color' => '#E50A0A');

            $data['dataSource']['dataset'][] = $dataSetValues['real'];
            $data['dataSource']['dataset'][] = $dataSetValues['plan'];
            $data['dataSource']['dataset'][] = $dataSetValues['desviacion'];
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;

        return $data;
    }

    /**
     * Función que retorna las etiquetas de los rangos de la frecuencia de notificación del indicador
     * @param Indicator $indicator
     * @return array
     */
    public function getLabelsFrequencyNotificationByDaysOfFrequency($days) {
        $labelsFrequencyArray = array();

        if ($days == 30) {
            $labelsFrequencyArray = CommonObject::getLabelsMonths();
        } elseif ($days == 60) {
            $labelsFrequencyArray = CommonObject::getLabelsBimonthly();
        } elseif ($days == 90) {
            $labelsFrequencyArray = CommonObject::getLabelsTrimonthly();
        } elseif ($days == 120) {
            $labelsFrequencyArray = CommonObject::getLabelsFourmonthly();
        } elseif ($days == 180) {
            $labelsFrequencyArray = CommonObject::getLabelsSixmonthly();
        }

        return $labelsFrequencyArray;
    }

    /**
     * Función que redefine las etiquetas por frecuencia de notificación de acuerdo al tipo de resultado del indicador
     * @param Indicator $indicator
     */
    public function setLabelsFrequencyNotificationByNumbersOfResults($numberResults, $labelsFrequencyArray = array(), $type = "from") {

        $labelIni = explode('-', $labelsFrequencyArray[1])[0];
        $labelsArray = array();

        if ($numberResults == 12) {
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($type == "from") {
                    $labelsArray[$i] = $labelsFrequencyArray[$i];
                } elseif ($type == "until") {
                    $labelsArray[$i] = "a " . $labelsFrequencyArray[$i];
                }
            }
        } else {

//Recorremos de acuerdo al número de resultados por frecuencia
            for ($i = 1; $i <= $numberResults; $i++) {
                $labelActually = explode('-', $labelsFrequencyArray[$i])[1];
                if ($i > 1) {
                    if ($type == "from") {
                        $labelsArray[$i] = $labelIni . '-' . $labelActually;
                    } elseif ($type == "until") {
                        $labelsArray[$i] = "a " . $labelActually;
                    }
                } else {
                    if ($type == "from") {
                        $labelsArray[$i] = $labelsFrequencyArray[$i];
                    } elseif ($type == "until") {
                        $labelsArray[$i] = "a " . $labelActually;
                    }
                }
            }
        }


        return $labelsArray;
    }

    /**
     * Función que retorna las etiquetas de los rangos de la frecuencia de notificación del indicador
     * @param Indicator $indicator
     * @return array
     */
    public function getLabelsByIndicatorFrequencyNotification(Indicator $indicator) {
        $frequency = $indicator->getFrequencyNotificationIndicator();
        $labelsFrequencyArray = array();

        if ($frequency) {
            if ($frequency->getDays() == 30) {
                $labelsFrequencyArray = CommonObject::getLabelsMonths();
            } elseif ($frequency->getDays() == 60) {
                $labelsFrequencyArray = CommonObject::getLabelsBimonthly();
            } elseif ($frequency->getDays() == 90) {
                $labelsFrequencyArray = CommonObject::getLabelsTrimonthly();
            } elseif ($frequency->getDays() == 120) {
                $labelsFrequencyArray = CommonObject::getLabelsFourmonthly();
            } elseif ($frequency->getDays() == 180) {
                $labelsFrequencyArray = CommonObject::getLabelsSixmonthly();
            }
        }

        if ($indicator->getResultIsAccumulative()) {
            $labelsFrequencyArray = $this->setLabelsByIndicatorFrequencyNotificationByTypeResultIndicator($indicator, $labelsFrequencyArray);
        }
        if ($indicator->getResultIsAccumulativeWithToMonth()) {
            $labelsFrequencyArray = $this->setLabelsByIndicatorFrequencyNotificationByTypeResultIndicator($indicator, $labelsFrequencyArray, "until");
        }



        return $labelsFrequencyArray;
    }

    /**
     * Función que retorna las etiquetas de los rangos de la frecuencia de notificación del indicador
     * @param Indicator $indicator
     * @return array
     */
    public function getLabelsByIndicatorFrequencyNotificationWithoutValidation(Indicator $indicator) {
        $frequency = $indicator->getFrequencyNotificationIndicator();
        $labelsFrequencyArray = array();

        if ($frequency->getDays() == 30) {
            $labelsFrequencyArray = CommonObject::getLabelsMonths();
        } elseif ($frequency->getDays() == 60) {
            $labelsFrequencyArray = CommonObject::getLabelsBimonthly();
        } elseif ($frequency->getDays() == 90) {
            $labelsFrequencyArray = CommonObject::getLabelsTrimonthly();
        } elseif ($frequency->getDays() == 120) {
            $labelsFrequencyArray = CommonObject::getLabelsFourmonthly();
        } elseif ($frequency->getDays() == 180) {
            $labelsFrequencyArray = CommonObject::getLabelsSixmonthly();
        }

        return $labelsFrequencyArray;
    }

    /**
     * Función que redefine las etiquetas por frecuencia de notificación de acuerdo al tipo de resultado del indicador
     * @param Indicator $indicator
     */
    public function setLabelsByIndicatorFrequencyNotificationByTypeResultIndicator(Indicator $indicator, $labelsFrequencyArray = array(), $type = "from") {
        $frequency = $indicator->getFrequencyNotificationIndicator();

        $labelIni = explode('-', $labelsFrequencyArray[1])[0];
        $labelsArray = array();
        $numberResults = $frequency->getNumberResultsFrequency();

        if ($numberResults == 12) {
            for ($i = 1; $i <= $numberResults; $i++) {
                if ($type == "from") {
                    $labelsArray[$i] = $labelsFrequencyArray[$i];
                } elseif ($type == "until") {
                    $labelsArray[$i] = "a " . $labelsFrequencyArray[$i];
                }
            }
        } else {

//Recorremos de acuerdo al número de resultados por frecuencia
            for ($i = 1; $i <= $numberResults; $i++) {
                $labelActually = explode('-', $labelsFrequencyArray[$i])[1];
                if ($i > 1) {
                    if ($type == "from") {
                        $labelsArray[$i] = $labelIni . '-' . $labelActually;
                    } elseif ($type == "until") {
                        $labelsArray[$i] = "a " . $labelActually;
                    }
                } else {
                    if ($type == "from") {
                        $labelsArray[$i] = $labelsFrequencyArray[$i];
                    } elseif ($type == "until") {
                        $labelsArray[$i] = "a " . $labelActually;
                    }
                }
            }
        }


        return $labelsArray;
    }

    /**
     * Gráfico de Columna con Línea y 2 ejes
     * @param Indicator $indicator
     * @return type
     */
    public function getDataChartOfResultIndicator(Indicator $indicator) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataSet' => array(),
            ),
        );
        $chart = array();

        $chart["caption"] = $indicator->getSummary();
//        $chart["subCaption"] = "Harry's SuperMart - Last Year";
        $chart["xAxisname"] = "Indicador";
        $chart["yAxisName"] = "TM";
//        $chart["sYAxisName"] = "Medición %";
//        $chart["numberPrefix"] = "$";
//        $chart["sNumberSuffix"] = "%";
//        $chart["sYAxisMaxValue"] = "100";
        $chart["bgColor"] = "#ffffff";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["formatNumberScale"] = "0";
        $chart["thousandSeparator"] = ".";
        $chart["decimalSeparator"] = ",";
        $chart["decimals"] = "2";
        $chart["forceDecimals"] = "1";
        $chart["yAxisValueDecimals"] = "2";
        $chart["sYAxisValueDecimals"] = "2";
        $chart["legendShadow"] = "0";
        $chart["showHoverEffect"] = "1";
        $chart["valueFontColor"] = "#000000";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "1";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["labelDisplay"] = "ROTATE";
        $chart["canvasBgColor"] = "#ffffff";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";

        $totalNumValues = count($indicator->getValuesIndicator()); //Número de indicadores asociados

        $category = $dataSetReal = $dataSetPlan = array();
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";

        if ($totalNumValues > 0) {
            $indicatorValues = $indicator->getValuesIndicator();
            $contMonth = 1;
            $labelMonths = CommonObject::getLabelsMonths();
            foreach ($indicatorValues as $indicatorValue) {
                $formulaParameters = $indicatorValue->getFormulaParameters();

                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $labelMonths[$contMonth];
                $dataReal["value"] = $formulaParameters['real']; //number_format($formulaParameters['real'], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $contMonth++;
            }
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetReal;

        return $data;
    }

    /**
     * Función que retorna un span con el reusltado del indciador ademaś del color de acuerdo al rango donde cayó.
     * @param Indicator $indicator
     * @return string
     */
    public function resultWithArrangementRangeColor(Indicator $indicator) {
        $color = '';
        $text = number_format($indicator->showResultOfIndicator(), 2, ',', '.');
        if ($indicator->getShowTagInResult()) {
            foreach ($indicator->getTagsIndicator() as $tagIndicator) {
                if ($tagIndicator->getShowInIndicatorResult()) {
                    if ($tagIndicator->getUnitResult() != "") {
                        $text.= ' ' . strtoupper($tagIndicator->getUnitResultValue());
                    } else {
                        $text.= '%';
                    }
                }
            }
        } else {
            $text.= '%';
        }
        $title = '';
        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $arrangementRange = $indicator->getArrangementRange();
        $tendency = $indicator->getTendency();
        $errorArrangementRange = null;
        if ($arrangementRange !== null) {
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($arrangementRange, $tendency);
            if ($errorArrangementRange == null) {
                if ($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                    $color = "#1aaf5d";
                } elseif ($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                    $color = "#f2c500";
                } elseif ($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                    $color = "#c02d00";
                }
            } else {
                $color = "#000000";
                $text = $errorArrangementRange;
            }
        } else {
            $color = "#000000";
            $text = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }

        if (!$indicator->hasNotification()) {
            $color = "#000000";
            $title = $this->trans('pequiven_indicator.summary.without_result', array(), 'PequivenIndicatorBundle');
        }

        $response = '<span title="' . $title . '" style="color:' . $color . ';"><b>' . $text . '</b></span>';
        return $response;
    }

    /**
     * Función que retorna el color del indicador de acuerdo al resultado de medición en comparación con el rango de gestión definido
     * @param Indicator $indicator
     * @return string
     */
    public function getColorOfResult(Indicator $indicator) {
        $resultService = $this->getResultService();
        $tendency = $indicator->getTendency();
        $color = "#ffffff";
        if ($indicator->getEvaluateInPeriod()) {
            if ($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $color = "#1aaf5d";
            } elseif ($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $color = "#f2c500";
            } elseif ($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                $color = "#ff0000";
            }
        } else {
            $color = "#544040";
        }

        return $color;
    }

    /**
     * Función que retorna
     * @param Indicator $indicator
     * @return string
     */
    public function getArrowOfIndicator(Indicator $indicator) {
        $textArrow = '<hgroup style="text-align: center;" class="thin breadcrumb">';
        if ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO) {
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())) . '"><b>' . $indicator->getRef() . '</b></a></span>';
        } elseif ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO) {
            if ($indicator->getParent() != null) {
                $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())) . '"><b>' . $indicator->getParent()->getRef() . '</b></a></span>';
                $textArrow.= '<span style="padding-left:" class="icon-forward"></span>';
            }
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())) . '"><b>' . $indicator->getRef() . '</b></a></span>';
        } elseif ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO) {
            if ($indicator->getParent() != null) {
                if (count($indicator->getParent()->getParent()) > 0) {
                    $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getParent()->getId())) . '"><b>' . $indicator->getParent()->getParent()->getRef() . '</b></a></span>';
                    $textArrow.= '<span class="icon-forward"></span>';
                }
                $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())) . '"><b>' . $indicator->getParent()->getRef() . '</b></a></span>';
                $textArrow.= '<span class="icon-forward"></span>';
            }
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())) . '"><b>' . $indicator->getRef() . '</b></a></span>';
        }

        $textArrow.= '</hgroup>';

        return $textArrow;
    }

    /**
     * Calcula el promedio simple de los Indicadores
     * @param LineStrategic $lineStrategic
     * @param $mode
     * <b> 1: </b> Cálculo estándar del promedio simple de los indicadores
     * <b> 2: </b> Cálculo de acuerdo al color del resultado de medición de los indicadores
     * @return type
     */
    public function calculateSimpleAverage(LineStrategic &$lineStrategic, $mode = 1, $parameters = array()) {
        $parameters = new \Doctrine\Common\Collections\ArrayCollection($parameters);

        if (($specific = $parameters->remove('specific')) != null) {
            $complejo = $parameters->remove('complejo');
        } else {
            $specific = false;
        }

        $indicators = $lineStrategic->getIndicators();
        $quantity = count($indicators);
        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $value = 0.0;
        foreach ($indicators as $indicator) {
            if ($indicator->getShowByDashboardSpecific() == $specific) {
                if ($mode == 1) {
                    $value += $indicator->getResultReal();
                } else {
                    $arrangementRange = $indicator->getArrangementRange();
                    if ($arrangementRange !== null) {
                        $errorArrangementRange = null;
                        if ($errorArrangementRange == null) {
                            $tendency = $indicator->getTendency();
                            if ($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                                $value += 1;
                            } elseif ($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                                $value += 2;
                            } elseif ($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)) {
                                $value += 3;
                            }
                        } else {
                            $value += 4;
                        }
                    } else {
                        $value += 4;
                    }
                }
            }
        }

        $value = $mode == 1 ? ($value / $quantity) : $value;
//        if($quantity == 0){//Fix error de division por cero.
//            $quantity = 1;
//        }

        return $value;
    }

    /**
     * Actualiza las Etiquetas del Indicador que dependen de una ecuación
     * @param Indicator $indicator
     */
    public function updateTagIndicator(Indicator &$indicator) {
        $em = $this->getDoctrine()->getManager();
        $tagIndicatorService = $this->getTagIndicatorService();

        foreach ($indicator->getTagsIndicator() as $tagIndicator) {
            if ($tagIndicator->getTypeTag() == Indicator\TagIndicator::TAG_VALUE_FROM_EQUATION) {
                $parametersForTemplate = array(
                    'indicator' => $indicator,
                    'tagIndicatorService' => $tagIndicatorService,
                );
                $valueTag = trim($this->renderString($tagIndicator->getEquationReal(), $parametersForTemplate));
                $tagIndicator->setValueOfTag($valueTag);
                $em->persist($tagIndicator);
                $em->flush();
            }
        }
    }

    /**
     * Actualiza el detalle de los gráficos de los indicadores
     * @param Indicator $indicator
     */
    public function updateIndicatorChartDetails(Indicator $indicator) {
        $em = $this->getDoctrine()->getManager();
        $indicatorChartDetailsRepository = $this->container->get('pequiven.repository.indicatorchartdetails');

        $charts = $indicator->getCharts();
        $indicatorsChartDetails = $indicator->getIndicatorsChartDetails();
        $totalIndicatorsChartDetails = count($indicatorsChartDetails);

        if ($totalIndicatorsChartDetails == 0) {
            foreach ($charts as $chart) {
                $indicatorChartDetails = new Indicator\IndicatorChartDetails();
                $indicatorChartDetails->setPeriod($indicator->getPeriod());
                $indicatorChartDetails->setIndicator($indicator);
                $indicatorChartDetails->setChart($chart);
                $em->persist($indicatorChartDetails);
                $em->flush();
            }
        } else {
            foreach ($charts as $chart) {
                $flagChart = false;
                foreach ($indicatorsChartDetails as $indicatorChartDetails) {
                    if ($indicatorChartDetails->getChart()->getId() == $chart->getId()) {
                        $flagChart = true;
                    }
                }
                if (!$flagChart) {
                    $indicatorChartDetails = new Indicator\IndicatorChartDetails();
                    $indicatorChartDetails->setPeriod($indicator->getPeriod());
                    $indicatorChartDetails->setIndicator($indicator);
                    $indicatorChartDetails->setChart($chart);
                    $em->persist($indicatorChartDetails);
                    $em->flush();
                }
            }
        }
    }

    /**
     * Function que retorna el promedio del indicador
     * @param indicator $indicator
     * @return type
     */
    public function getPromdIndicator(Indicator $indicator) {

        $result = $acum = $sum = 0;
        $calc = $indicator->getIndicatorSigMedition();
        $contMonth = 1;

        if ($calc === null) {
            $calc = 1;
        }

//Recibiendo la frecuencia de calculo del indicador
//$labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

        foreach ($indicator->getValuesIndicator() as $value) {
            $data = $value->getValueOfIndicator();
//$cant = $labelsFrequencyNotificationArray[$contMonth];

            $contMonth++;
            $sum = $sum + $data;
            $acum = $acum + $data;
        }

//Data Prom
        if ($contMonth == 1) {
            $contMonth = 2;
        }

        if ($calc === 1) {
            if ($indicator->getId() == 1655) {
                $result = $acum / ($contMonth - 1); //Calculo de Promedio                
            } else {
                $result = $indicator->getResultReal();
            }
//$value = ceil($result); //Paso de promedio
            $value = $result; //Paso de promedio
        } elseif ($calc === 0) {
            $value = $sum; //Paso de sumatoria
        }

        return $value;
    }

    /**
     * Function que retorna el objetivo segun tendencia del indicador
     * @param indicator $indicator
     * @return type
     */
    public function getObjIndicator(Indicator $indicator) {


        $trend = 0;
        $trend = $indicator->getTendency()->getId();
        $obj = $indicator->getArrangementRange()->getRankBottomBasic();
//var_dump($trend);
//Creciente
        if ($trend === 1) {
            $obj = $indicator->getArrangementRange()->getRankTopBasic();
//Decreciente            
        } elseif ($trend === 2) {
            $obj = $indicator->getArrangementRange()->getRankBottomBasic();
//Estable
        } elseif ($trend === 3) {
            $value1 = $indicator->getArrangementRange()->getRankTopMixedTop();
            $value2 = $indicator->getArrangementRange()->getRankTopMixedBottom();
            $obj = (($value2 - $value1) / 2) + $value1;
//Sin tendencia
        } else {
            $obj = 0;
        }

        return $obj;
    }

    /**
     * Function que retorna el objetivo segun tendencia del indicador
     * @param indicator $indicator
     * @return type
     */
    public function getIndicatorHasResultValid(Indicator $indicator) {

        $cont = 0;
        $var = FALSE;

        if ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_SIMPLE_AVERAGE) {
//$arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            $var = FALSE;
        } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC) {
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            $var = TRUE;
        } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AUTOMATIC) {
//$arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            $var = FALSE;
        } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_ACCUMULATE) {
//$arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            $var = FALSE;
        } elseif ($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ) {
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            $var = TRUE;
        }

        $totalValueIndicators = count($indicator->getValuesIndicator());
        $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
        $realAccumulated = $planAccumulated = 0.0;

        $resultNumbers = 1;
        if ($var === TRUE) {
            for ($i = 0; $i < $totalValueIndicators; $i++) {
                if ($arrayVariables['valueReal'][$i] != 0 || $arrayVariables['valuePlan'][$i] != 0) {
                    $resultNumbers = $i + 1;
                }
            }
        } else {
            foreach ($indicator->getValuesIndicator() as $value) {
                $cont++;
                $resultNumbers = $cont;
            }
        }

        $results = $resultNumbers;

        return $results;
    }

    public function IndicatorCalculateTendency($indicator,$resultNumbers) {
        $cont = 1;
        $values = count($indicator->getValuesIndicator());

        $dataX = $dataY = $dataXY = $dataXX = [];
        $dataTendency = 0;

        if ($values != 0 and $resultNumbers >= 3) {
            foreach ($indicator->getValuesIndicator() as $value) {
                $data = $value->getValueOfIndicator();
                //var_dump($data);
                if ($cont <= $resultNumbers) {
                    $dataX[] = $cont; //X
                    $dataY[] = $data; //Y
                    $dataXY[] = $data * $cont; //X*Y
                    $dataXX[] = $cont * $cont; //X^2
                }
                $cont++;                                        
            }
            
//echo "X"; var_dump($dataX);                    
//echo "Cantidad"; var_dump(count($dataX));                    
//echo "Y"; var_dump($dataY);
//echo "X*Y"; var_dump($dataXY);
//echo "X2"; var_dump($dataXX);

            $sumaX = array_sum($dataX);
            $sumaY = array_sum($dataY);
//echo "suma X"; var_dump($suma);
//echo "prom X"; var_dump($suma/count($dataX));


            $d = ((count($dataX) * array_sum($dataXY)) - (array_sum($dataX) * array_sum($dataY)));
            $c = ((count($dataX) * array_sum($dataXX)) - (array_sum($dataX) * array_sum($dataX)));
            $b = $d / $c;

            $a = (($sumaY / count($dataY))) - ($b * ($sumaX / count($dataX)));

            $dataTendency = [
                'a' => $a,
                'b' => $b
            ];
        }
//echo "B1"; var_dump($b);
//echo "C1"; var_dump($c);
//y = a + bx
//echo "b";  var_dump($b);
//echo "a";  var_dump($a);
//$y = $a + ($b * 1);
        return $dataTendency;
    }

    public function chargeLastPeriod($indicator, $periods) {
        $cantPeriodValid = count($periods);
        $dataPeriods = [];
        $value14 = $value15 = 0;
        $lastPeriod = $indicator->getIndicatorLastPeriod();
        $period = $indicator->getPeriod()->getId();

        switch ($period) {
            case 1:
                break;
            case 2:
//echo "Indicador 2015 sin lastPeriod";
                break;
            case 3:
                if ($lastPeriod) {
                    $value15 = $lastPeriod->getResultReal();
                    if ($lastPeriod->getIndicatorLastPeriod()) {
                        $value14 = $lastPeriod->getIndicatorLastPeriod()->getResultReal();
                    }
                }
                break;
        }

        $dataPeriods = [
            1 => $value14,
            2 => $value15
        ];

        return $dataPeriods;
    }

    /**
     * Gráfico de Columna para informe de Evolución
     * @param Indicator $indicator
     * @return type
     */
    public function getDataChartOfIndicatorEvolution(Indicator $indicator, $urlExportFromChart, $month) {

        $period = $indicator->getPeriod()->getDescription();
        $periodInvalid = 2;
        $periodInicator = $indicator->getPeriod()->getId();
        $periodCharge = $periodInicator - 1;

        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            

        $dataPeriods = $evolutionService->getLastPeriods($periodInicator); //Obtenemos la data del gráfico de acuerdo al indicador
        $periods = $dataPeriods['periods'];

        $valuesLastPeriod = $this->chargeLastPeriod($indicator, $periods);

        $em = $this->getDoctrine();
        $prePlanningItemCloneObject = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array('idCloneObject' => $indicator->getId(), 'typeObject' => \Pequiven\SEIPBundle\Model\PrePlanning\PrePlanningTypeObject::TYPE_OBJECT_INDICATOR));

        $indicatorParent = 0;
        if ($periodInicator != $periodInvalid AND $prePlanningItemCloneObject) {
            $indicatorParent = $this->container->get('pequiven.repository.indicator')->find($prePlanningItemCloneObject->getIdSourceObject());
        }

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );
        $chart = array();

        $chart["palette"] = "1";
        $chart["showvalues"] = "0";
        $chart["paletteColors"] = "#0075c2,#c90606,#f2c500,#12a830,#1aaf5d";
        $chart["yaxisvaluespadding"] = "10";
        $chart["valueFontColor"] = "#000000";
        $chart["rotateValues"] = "0";
        $chart["theme"] = "fint";
        $chart["showborder"] = "0";
        $chart["decimals"] = $indicator->getDecimalsToChartEvolution();
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar Informe de Evolución PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = $urlExportFromChart;

        $dataTendency = 0;
//Lamado de promedio
        $prom = $this->getPromdIndicator($indicator);
//Lamado obj 2015
        $obj = $this->getObjIndicator($indicator);

        if ($indicator->getViewDataChartEvolutionConsultedMonth() == 1 or $indicator->getFrequencyNotificationIndicator()->getId() == 1) {
            $resultNumbers = $this->getIndicatorHasResultValid($indicator);
        } else {
            $resultNumbers = $month;
        }

//Llamado de frecuencia de Notificacion del Indicador
        $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);

//Número de indicadores asociados
        $totalNumValues = count($indicator->getValuesIndicator());
        if ($totalNumValues >= 3) {
            $dataTendency = $this->IndicatorCalculateTendency($indicator,$resultNumbers);
        }

//Inicialización
        $category = $dataSetReal = $dataSetPlan = $dataSetAcum = array();
        $label = $dataReal = $dataPlan = $dataAcum = $dataMedition = array();

//Promedio o Acumulado
        $medition = "Promedio";
        if ($indicator->getIndicatorSigMedition() == 0) {
            $medition = "Acumulado";
        }

//Carga de Nombres de Labels
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        $dataSetAcum["seriesname"] = "Acumulado";
        $dataSetAnt["seriesname"] = "Periodo";

        $labelProm = $medition;
        $labelobj = "Objetivo " . $indicator->getPeriod()->getName();

        $category = $dataPeriods['category'];

        if ($totalNumValues > 0) {
            $indicatorValues = $indicator->getValuesIndicator();
            $contMonth = 1;
            foreach ($indicatorValues as $indicatorValue) {
                $formulaParameters = $indicatorValue->getFormulaParameters();
                if ($resultNumbers >= $contMonth) {
                    $label["label"] = $labelsFrequencyNotificationArray[$contMonth];
                    $contCant = $contMonth; //Contando la Cantidad de valores
                    $category[] = $label;
                }
                $contMonth++;
            }

            $labelp["label"] = $labelProm; //Label del Prom
            $category[] = $labelp; //Label del Prom
//Label Obj Acum
            $labelo["label"] = $labelobj; //Label del ObjAcum
            $category[] = $labelo; //Label del ObjAcum
//Declaración de Variables
            $valueData = $acumLast = $cant = $promLast = 0;
            $indicatorlast = $indicator->getindicatorLastPeriod();

            for ($i = 0; $i < $periodCharge; $i++) {
                $valueData = round($valuesLastPeriod[$i + 1]);
                $dataAnt["value"] = $valueData;
                $dataAnt["color"] = '#f2c500';
                $dataSetAnt["showvalues"] = "1";
                $dataSetAnt["data"][] = $dataAnt;
            }

            if ($periodInicator != $periodInvalid) {
                $dataSetTend["data"][] = array('value' => '');
                $dataSetReal["data"][] = array('value' => '');
                $dataSetLine["data"][] = array('value' => '');
            }

//Pasando espacios vacios para desarrollo de la gráfica
            $dataSetTend["data"][] = array('value' => '');
            $dataSetReal["data"][] = array('value' => '');

            $contValue = 1;
            foreach ($indicator->getValuesIndicator() as $value) {
                if ($resultNumbers >= $contValue) {
                    $dataReal["value"] = $value->getValueOfIndicator(); //Carga de valores del indicador
                    $dataSetReal["data"][] = $dataReal; //Data Real

                    $dataRealTendency["value"] = $dataTendency['a'] + ($dataTendency['b'] * $contValue);
                    $dataSetTend["data"][] = $dataRealTendency; //Data Real Tendencia
                    $contValue = $contValue;
                }
                $contValue++;
            }

            $dataSetLine["data"][] = array('value' => ''); //Valor vacio para saltar 2014
            for ($i = 0; $i < $contCant; $i++) {
                $dataLine["value"] = $obj; //Carga valores objetivo del Indicador
                $dataSetLine["data"][] = $dataLine; //Data del Objetivo
            }

//Paso de la data ya formateada
            $dataSetV['data'] = array('seriesname' => 'Plan', 'parentyaxis' => 'S', 'renderas' => 'Line', 'data' => $dataSetLine['data']);

//Data Prom
            $dataSetReal["showvalues"] = "1";
            $dataAcum["value"] = $prom; //Pasando data a data prom
            $dataAcum["color"] = '#0a5f87';
            $dataSetReal["data"][] = $dataAcum; //promedio
//Pasando Objetivo Acum
            $dataObj["value"] = $obj; //Pasando data a Dataobj
            $dataObj["color"] = '#087505';
            $dataSetReal["data"][] = $dataObj; //Acumulado
//Carga de Tendencia
            $cantValue = count($dataSetTend['data']);
            $dataSetValues['tendencia'] = 0;
            if ($cantValue >= 4 and $resultNumbers > 2) {
                $dataSetValues['tendencia'] = array('seriesname' => 'Tendencia', 'parentyaxis' => 'S', 'renderas' => 'Line', 'color' => '#dbc903', 'data' => $dataSetTend['data']);
            }
        } else {
            $dataSetValues['tendencia'] = 0;
            $dataSetV['data'] = 0;
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetValues['tendencia'];
        $data['dataSource']['dataset'][] = $dataSetReal;
        $data['dataSource']['dataset'][] = $dataSetAnt;
        $data['dataSource']['dataset'][] = $dataSetV['data'];

        return $data;
    }

    public function obtainIndicatorChartDetails(Indicator $indicator, \Pequiven\SEIPBundle\Entity\Chart $chart) {
        $indicatorChartDetailsRepository = $this->container->get('pequiven.repository.indicatorchartdetails');

        $indicatorChartDetails = $indicatorChartDetailsRepository->findOneBy(array('indicator' => $indicator->getId(), 'chart' => $chart->getId()));

        return $indicatorChartDetails;
    }

    public function obtainIndicatorChartDetailsByOrderShow(Indicator $indicator) {
        $indicatorChartDetailsRepository = $this->container->get('pequiven.repository.indicatorchartdetails');

        $indicatorChartDetails = $indicatorChartDetailsRepository->findBy(array('indicator' => $indicator->getId()), array('orderShow' => 'ASC'));

        return $indicatorChartDetails;
    }

    /**
     * 
     * @param Indicator $indicator
     */
    public function getTagIndicatorByOrder(Indicator $indicator) {
        $tagsIndicator = $this->container->get('pequiven.repository.tagIndicator')->findBy(array('indicator' => $indicator->getId()), array('orderShow' => 'ASC'));

        return $tagsIndicator;
    }

    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

    /**
     * Servicio de las Etiquetas del Indicador
     * @return \Pequiven\IndicatorBundle\Service\TagIndicatorService
     */
    public function getTagIndicatorService() {
        return $this->container->get('pequiven_indicator.service.tag_indicator');
    }

    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService() {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }

    public function getSecurityContext() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context');
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
    protected function generateUrl($route, $parameters = array(), $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_PATH) {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * Renders a string view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return String twig
     */
    private function renderString($string, array $parameters = array()) {
        return $this->container->get('app.twig_string')->render($string, $parameters);
    }

    /**
     * Metodo que retorna si el el indicador tiene padres 
     * 
     * @param Indicator $indicator
     * @return boolean
     */
    public function isIndicatorHasParents(Indicator $indicator) {
        $indicatorParent = $indicator->getParent();

        $flag = false;
        $cont = 1;
        while (!$flag) {
            if ($cont == 1) {
                $objectIndicator = $indicator->getParent();
            } else {
                $objectIndicator = $objectIndicator->getParent();
            }
            if ($objectIndicator != NULL) {
                $indicatorParent = $objectIndicator;
            } else {

                $flag = true;
            }
            $cont++;
        }

        $band = false;
        if ($indicatorParent) {
            $nivel = $indicatorParent->getIndicatorLevel()->getLevel();
            if ($nivel == \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_ESTRATEGICO) {
                $band = true;
            } else {
                $band = false;
            }
        } else {
            $nivel = $indicator->getIndicatorLevel()->getLevel();
            if ($nivel == \Pequiven\IndicatorBundle\Entity\IndicatorLevel::LEVEL_ESTRATEGICO) {
                $band = true;
            }
        }

//var_dump($band);
        return $band;
    }

    /**
     * Metodo que retorna si el el indicador va contra un indicador estrategico 
     * 
     * @param Indicator $indicator
     * @return boolean
     */
    public function isIndicatorHasParentsEstrategic(Indicator $indicator) {

        $indicatorParent = $indicator->getParent();

        $indicatorLevel = $indicator->getIndicatorLevel()->getId();

        $value = false;
        switch ($indicatorLevel) {
            case 1:
                $value = false;
                break;

            case 2:
                if ($indicatorParent) {
                    $value = false;
                } else {
                    $value = true;
                }
                break;

            case 3:
                if ($indicatorParent) {
                    $levelParentOperative = $indicatorParent->getIndicatorLevel()->getId();
                    $indicatorParentOperative = $indicatorParent->getParent();
                    if ($levelParentOperative === $indicatorLevel) {
                        $indicatorParentOperative = $indicatorParentOperative->getParent();
                        if ($indicatorParentOperative) {
                            $value = false;
                        }
                    } elseif ($indicatorParentOperative) {
                        $value = false;
                    } else {
                        $value = true;
                    }
                } else {
                    $value = true;
                }

                break;

            default:
                $value = false;
        }

        return $value;
    }

    public function isGrantedButton(Indicator $indicator) {
        $freq = $indicator->getFrequencyNotificationIndicator()->getDays();
        $rs = 360 / $freq;

        $valuesIndicator = count($indicator->getValuesIndicator());

        if ($rs == $valuesIndicator) {
            return false;
        } else {
            return true;
        }
    }

    public function isGrantToEdit(Indicator $indicator, $indice) {
        $freq = $indicator->getFrequencyNotificationIndicator()->getDays();
        $securityService = $this->getSecurityService();
        $permisoEspecial = $securityService->isGranted(['ROLE_SEIP_PLANNING_INDICATOR_EDIT']);

        if ($permisoEspecial) {
            return 1;
        } else {

            if ($freq != 360) { //SI ES ANUAL ES REGISTRO SIEMPRE SERA EDITABLE
                $trim[] = $indicator->getPeriod()->getIsLoadIndicatorTrim1();
                $trim[] = $indicator->getPeriod()->getIsLoadIndicatorTrim2();
                $trim[] = $indicator->getPeriod()->getIsLoadIndicatorTrim3();
                $trim[] = $indicator->getPeriod()->getIsLoadIndicatorTrim4();

                $x = $indice * $freq;

                $liminf = $x - $freq;

                $rs = array();
                $lastRs = 0;
                $conTri = 1;
                $tiempo_trimestre = 0;
                $flag = false;

                foreach ($trim as $t) {

                    $tiempo_trimestre = $conTri * 30 * 3;

                    if ((($x > $lastRs && $x <= $tiempo_trimestre ) || ($liminf >= $lastRs && $liminf < $tiempo_trimestre)) && ($t == 1)) {
                        $flag = true;
                    }

                    $conTri++;
                    $lastRs = $tiempo_trimestre;
                }

                if ($flag) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 1;
            }
        }
    }

    /**
     * FUNCION QUE RETORNA 
     * SI RETURNID ES FALSE = VERIFICA QUE POR LO MENOS UN VALUEINDICATOR TENGA ARCHIVO
     * SI RETURNID  ES TRUE = RETORNA EL ULTIMO VALUEINDICATOR CON DOCUMENTO CARGADO
     * 
     * @param Indicator $indicator
     * @param type $returnId
     * @return boolean
     */
    public function validFileIndicator(Indicator $indicator, $returnId = false) {
        $band = false;
        $securityService = $this->getSecurityService();
        if ($securityService->isGranted(['ROLE_SEIP_PLANNING_INDICATOR_VISUALIZE_LAST_FILE'])) {
            $vIndicator = "";
            foreach ($indicator->getValuesIndicator() as $valueIndicator) {
                if ($valueIndicator->getValueIndicatorFile()) {
                    if ($returnId) {
                        $vIndicator = $valueIndicator->getId();
                    }
                    $band = true;
//break;
                }
            }
            if ($returnId) {
                return $vIndicator;
            } else {
                return $band;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @return \Pequiven\SIGBundle\Service\EvolutionService
     */
    protected function getEvolutionService() {
        return $this->container->get('seip.service.evolution');
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    protected function getProductReportService() {
        return $this->container->get('seip.service.productReport');
    }

}
