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
    public function calculateFormulaValueFromDashboardEquation(Formula $formula, $data){
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

//        $chart['caption'] = $indicator->getDescription();
//        $chart["captionPadding"] = "10";
        $chart["showshadow"] = "0";
        $chart["showvalue"] = "1";
        $chart["useColorNameAsValue"] = "1";
        $chart["placeValuesInside"] = "1";
        $chart["valueFontSize"] = "13";
        $chart["baseFontColor"] = "#333333";
        $chart["baseFont"] = "Helvetica Neue,Arial";
        $chart["captionFontSize"] = "10";
//        $chart["captionFontBold"] = "1";
        $chart["showborder"] = "0";
        $chart["bgcolor"] = "#FFFFFF";
        $chart["bgalpha"] = "0";
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBorderThickness"] = "0";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
//        $chart["clickURL"] = 'n-'.$this->generateUrl('pequiven_indicator_show', array('id' => $indicator->getId()));
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
                    $colorData["label"] = number_format($indicator->getResultReal(), 2, ',', '.') . '%';
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
        $chart["caption"] = number_format($indicator->getResultReal(), 2, ',', '.');
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
                'category' => array(
                ),
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
                'dataSet' => array(
                ),
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

                foreach ($indicatorsChildrens as $indicatorChildren) {
                    $set = array();
                    $set["label"] = $indicatorChildren->getRef().' '.$indicatorChildren->getSummary() . ': ' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["value"] = $sumResultChildren != 0 ? bcdiv($indicatorChildren->getResultReal(), $sumResultChildren, 2) : bcadd(0, 0, 2);
                    $set["displayValue"] = $indicatorChildren->getRef() . ' - ' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["toolText"] = $indicatorChildren->getSummary() . ':{br}' . number_format($indicatorChildren->getResultReal(), 2, ',', '.') . '%';
                    $set["color"] = $this->getColorOfResult($indicatorChildren);
                    $set["labelLink"] = $this->generateUrl('pequiven_indicator_show', array('id' => $indicatorChildren->getId()));
                    $set["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    $dataSet[] = $set;
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
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.').' ' . $arrayVariable['unit'];
                $set["toolText"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
//                $set["color"] = $this->getColorOfResult($indicatorChildren);
//                $set["labelLink"] = $this->generateUrl('pequiven_indicator_show', array('id' => $indicator->getId()));
//                $set["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                $dataSet[] = $set;
            }
        } elseif(isset($options['withVariablesRealPlanFromDashboardEquation']) && array_key_exists('withVariablesRealPlanFromDashboardEquation', $options)){
            unset($options['withVariablesRealPlanFromDashboardEquation']);
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanFromDashboardEquation' => true));
            
            $set = array();
            $set["label"] = $arrayVariables['dashboardEquationReal']['description'];
            $set["value"] = $arrayVariables['dashboardEquationReal']['value'];
            $set["displayValue"] = number_format($arrayVariables['dashboardEquationReal']['value'], 2, ',', '.').' ' . $arrayVariables['dashboardEquationReal']['unit'];
            $set["toolText"] = number_format($arrayVariables['dashboardEquationReal']['value'], 2, ',', '.') . ' ' . $arrayVariables['dashboardEquationReal']['unit'];
            $dataSet[] = $set;
            
            $set = array();
            $set["label"] = $arrayVariables['dashboardEquationPlan']['description'];
            $set["value"] = $arrayVariables['dashboardEquationPlan']['value'];
            $set["displayValue"] = number_format($arrayVariables['dashboardEquationPlan']['value'], 2, ',', '.').' ' . $arrayVariables['dashboardEquationPlan']['unit'];
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
                'data' => array(
                ),
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
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.').' '.$arrayVariable['unit'];;
                $dataChart[] = $set;
            }
        } elseif (isset($options['viewVariablesFromRealEquation']) && array_key_exists('viewVariablesFromRealEquation', $options)) {
            unset($options['viewVariablesFromRealEquation']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesFromRealEquation' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.').' '.$arrayVariable['unit'];
                $dataChart[] = $set;
            }
        } elseif(isset($options['viewVariablesMarkedReal']) && array_key_exists('viewVariablesMarkedReal', $options)){
            unset($options['viewVariablesMarkedReal']);
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesMarkedReal' => true));
            foreach ($arrayVariables as $arrayVariable) {
                $set = array();
                $set["label"] = $arrayVariable['description'];
                $set["value"] = bcadd($arrayVariable['value'], 0, 2);
                $set["displayValue"] = number_format($arrayVariable['value'], 2, ',', '.') . ' ' . $arrayVariable['unit'];
                $dataChart[] = $set;
            }
        } elseif(isset($options['viewVariablesMarkedPlan']) && array_key_exists('viewVariablesMarkedPlan', $options)){
            unset($options['viewVariablesMarkedReal']);
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
        
        $totalNumChildrens = count($indicator->getChildrens()); //Número de indicadores asociados
        
        $category = $dataSetReal = $dataSetPlan = $medition = array();
        
        if(isset($options['byFrequencyNotification']) && array_key_exists('byFrequencyNotification', $options)){
            unset($options['byFrequencyNotification']);
            
            if($indicator->getDetails()){
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            
            $arrayVariables = array();
            if($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            } elseif($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            }
            
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["renderas"] = "area";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            for ($i = 0;$i < $totalValueIndicators; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $i;
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }
        } elseif(isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification',$options)){
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);
            
            if($indicator->getDetails()){
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesMarkedRealPlanByFrequencyNotification' => true));
         
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["renderas"] = "area";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            for ($i = 0;$i < $totalValueIndicators; $i++) {
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
    public function getDataChartColumnMultiSeries3d(Indicator $indicator, $options = array()){
        
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
        
        $category = $dataSetReal = $dataSetPlan = $medition = array();
        
        if(isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification', $options)){
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);
            
            if($indicator->getDetails()){
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries' => true));
         
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetReal["showValues"] = "1";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            for ($i = 0;$i < $totalValueIndicators; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
                $label["label"] = $i;
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }
        } elseif(isset($options['withVariablesRealPlanFromDashboardEquationFromChildrens']) && array_key_exists('withVariablesRealPlanFromDashboardEquationFromChildrens', $options)){
            unset($options['withVariablesRealPlanFromDashboardEquationFromChildrens']);
            
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries' => true));
            
            if($indicator->getDetails()){
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
         
            $dataSetPlan["seriesname"] = $indicator->getShowByPlanValue();
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $indicator->getShowByRealValue();
            $dataSetReal["showValues"] = "1";
            
            $childrens = $indicator->getChildrens();
            
            foreach($childrens as $children){
                $label = $dataReal = $dataPlan = array();
                $label["label"] = $children->getSummary();
                $dataReal["value"] = number_format($arrayVariables[$children->getRef()]['dashboardEquationReal']['value'], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
            }
        } elseif(isset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquation']) && array_key_exists('withVariablesRealPlanByFrequencyNotificationFromDashboardEquation', $options)){
            unset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquation']);
            
            $arrayVariables = array();
            $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries' => true));
            
            if($indicator->getDetails()){
                $chart["yAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
         
            $dataSetPlan["seriesname"] = $arrayVariables['dashboardEquationPlan']['description'];
            $dataSetPlan["showValues"] = "1";
            $dataSetReal["seriesname"] = $arrayVariables['dashboardEquationReal']['description'];
            $dataSetReal["showValues"] = "1";
            
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
            $totalValueIndicators = count($indicator->getValuesIndicator());
            for ($i = 0;$i < $totalValueIndicators; $i++) {
                $label = $dataReal = $dataPlan = array();
                $label["label"] = $labelsFrequencyNotificationArray[($i+1)];
                $dataReal["value"] = number_format($arrayVariables['dashboardEquationReal']['value'][$i], 2, ',', '.');
                $dataPlan["value"] = number_format($arrayVariables['dashboardEquationPlan']['value'][$i], 2, ',', '.');

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
     * Función para 
     * @param Indicator $indicator
     * @return type
     */
    public function getArrayVariablesFormulaWithData(Indicator $indicator, $options = array()) {
        $formula = $indicator->getFormula();
        $valuesIndicator = $indicator->getValuesIndicator();
        $arrayVariables = array();
        
        
        if(isset($options['viewVariablesRealPlan']) && array_key_exists('viewVariablesRealPlan',$options)){
            unset($options['viewVariablesRealPlan']);
            $unit = '';
            foreach($valuesIndicator as $valueIndicator){
                $parameters = $valueIndicator->getFormulaParameters();
                foreach ($parameters as $parameter => $key) {
                    if ($parameter == 'real_from_equation' || $parameter == 'plan_from_equation') {
                        $arrayVariables[$parameter]['value'] = $key;
                        $arrayVariables[$parameter]['description'] = $parameter == 'real_from_equation' ? $indicator->getShowByRealValue() : $indicator->getShowByPlanValue();
                        $arrayVariables[$parameter]['unit'] = '';
                        if($indicator->getDetails()){
                            $unit = $parameter == 'real_from_equation' ? $indicator->getDetails()->getResultRealUnit() : $indicator->getDetails()->getResultPlanUnit();
                            $arrayVariables[$parameter]['unit'] = $unit;
                        }
                    }
                }
            }
        } elseif(isset($options['viewVariablesRealPlanAutomatic']) && array_key_exists('viewVariablesRealPlanAutomatic', $options)){
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
            if($indicator->getDetails()){
                $arrayVariables[$varReal->getName()]['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables[$varPlan->getName()]['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
        } elseif(isset($options['viewVariablesRealPlanAutomaticByFrequencyNotification']) && array_key_exists('viewVariablesRealPlanAutomaticByFrequencyNotification', $options)){
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
        } elseif(isset($options['viewVariablesRealPlanFromEquationByFrequencyNotification']) && array_key_exists('viewVariablesRealPlanFromEquationByFrequencyNotification', $options)){
            unset($options['viewVariablesRealPlanFromEquationByFrequencyNotification']);
            $arrayVariables['descriptionReal'] = $indicator->getShowByRealValue();
            $arrayVariables['descriptionPlan'] = $indicator->getShowByPlanValue();
            foreach($valuesIndicator as $valueIndicator){
                $parameters = $valueIndicator->getFormulaParameters();
                foreach ($parameters as $parameter => $key) {
                    if ($parameter == 'real_from_equation') {
                        $arrayVariables['valueReal'][] = $key;
                    } elseif($parameter == 'plan_from_equation'){
                        $arrayVariables['valuePlan'][] = $key;
                    }
                }
                $arrayVariables['medition'][] = $valueIndicator->getValueOfIndicator();
            }
        } elseif(isset($options['viewVariablesMarkedReal']) && array_key_exists('viewVariablesMarkedReal', $options)){
            unset($options['viewVariablesMarkedReal']);
            $variables = $formula->getVariables();
            foreach($variables as $variable){
                if($variable->getShowRealInDashboardPie()){
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }
            foreach($valuesIndicator as $valueIndicator){
                foreach($variables as $variable){
                    if($variable->getShowRealInDashboardPie()){
                        $nameParameter = $variable->getName();
                        $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                    }
                }
            }
        } elseif(isset($options['viewVariablesMarkedPlan']) && array_key_exists('viewVariablesMarkedPlan', $options)){
            unset($options['viewVariablesMarkedPlan']);
            $variables = $formula->getVariables();
            foreach($variables as $variable){
                if($variable->getShowPlanInDashboardPie()){
                    $nameParameter = $variable->getName();
                    $arrayVariables[$nameParameter]['value'] = 0.0;
                    $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                    $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                    $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                }
            }
            foreach($valuesIndicator as $valueIndicator){
                foreach($variables as $variable){
                    if($variable->getShowPlanInDashboardPie()){
                        $nameParameter = $variable->getName();
                        $arrayVariables[$nameParameter]['value'] = $arrayVariables[$nameParameter]['value'] + $valueIndicator->getParameter($nameParameter);
                    }
                }
            }
        } elseif(isset($options['withVariablesMarkedRealPlanByFrequencyNotification']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotification', $options)){
            unset($options['withVariablesMarkedRealPlanByFrequencyNotification']);
            $variables = $formula->getVariables();
            $varReal = $varPlan = '';
            foreach($variables as $variable){
                if($variable->getShowRealInDashboardBarArea()){
                    $varReal = $variable->getName();
                    $arrayVariables['descriptionReal'] = $variable->getDescription();
                    $arrayVariables['summaryReal'] = $variable->getSummary();
                } elseif($variable->getShowPlanInDashboardBarArea()){
                    $varPlan = $variable->getName();
                    $arrayVariables['descriptionPlan'] = $variable->getDescription();
                    $arrayVariables['summaryPlan'] = $variable->getSummary();
                }
            }
            
            foreach($valuesIndicator as $valueIndicator){
                $arrayVariables['valueReal'][] = $valueIndicator->getParameter($varReal);
                $arrayVariables['valuePlan'][] = $valueIndicator->getParameter($varPlan);
            }
        } elseif(isset($options['withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries']) && array_key_exists('withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries', $options)){
            unset($options['withVariablesMarkedRealPlanByFrequencyNotificationColumnMultiSeries']);
            $variables = $formula->getVariables();
            $varReal = $varPlan = '';
            foreach($variables as $variable){
                if($variable->getShowRealInDashboardColumn()){
                    $varReal = $variable->getName();
                    $arrayVariables['descriptionReal'] = $variable->getDescription();
                    $arrayVariables['summaryReal'] = $variable->getSummary();
                } elseif($variable->getShowPlanInDashboardColumn()){
                    $varPlan = $variable->getName();
                    $arrayVariables['descriptionPlan'] = $variable->getDescription();
                    $arrayVariables['summaryPlan'] = $variable->getSummary();
                }
            }
            
            foreach($valuesIndicator as $valueIndicator){
                $arrayVariables['valueReal'][] = $valueIndicator->getParameter($varReal);
                $arrayVariables['valuePlan'][] = $valueIndicator->getParameter($varPlan);
            }
        } elseif(isset($options['withVariablesRealPlanFromDashboardEquation']) && array_key_exists('withVariablesRealPlanFromDashboardEquation', $options)){
            unset($options['withVariablesRealPlanFromDashboardEquation']);
            
            $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationPlan']['value'] = 0.0;
            $arrayVariables['dashboardEquationReal']['unit'] = $arrayVariables['dashboardEquationPlan']['unti'] = '';
            $arrayVariables['dashboardEquationReal']['description'] = $arrayVariables['dashboardEquationPlan']['description'] = '';
            
            $arrayVariables['dashboardEquationReal']['description'] = $indicator->getShowByRealValue();
            $arrayVariables['dashboardEquationPlan']['description'] = $indicator->getShowByPlanValue();
            if($indicator->getDetails()){
                $arrayVariables['dashboardEquationReal']['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables['dashboardEquationPlan']['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
            
            foreach($valuesIndicator as $valueIndicator){
                $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formula,$valueIndicator->getFormulaParameters());
                $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationReal']['value'] + $valuesFromDashboardEquation['dashboardEquationReal'];
                $arrayVariables['dashboardEquationPlan']['value'] = $arrayVariables['dashboardEquationPlan']['value'] + $valuesFromDashboardEquation['dashboardEquationPlan'];
            }
            
        } elseif(isset($options['withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries']) && array_key_exists('withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries', $options)){
            unset($options['withVariablesRealPlanFromDashboardEquationFromChildrensMultiSeries']);
            
            $childrens = $indicator->getChildrens();
            
            foreach($childrens as $children){//Inicializamos en 0, los valores para el gráfico
                $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] = 0.0;
            }
            
            foreach($childrens as $children){
                $childrenValuesIndicator = $children->getValuesIndicator();
                $formulaChildren = $children->getFormula();
                foreach($childrenValuesIndicator as $childrenValueIndicator){
                    $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formulaChildren,$childrenValueIndicator->getFormulaParameters());
                    $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationReal']['value'] + $valuesFromDashboardEquation['dashboardEquationReal'];
                    $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] = $arrayVariables[$children->getRef()]['dashboardEquationPlan']['value'] + $valuesFromDashboardEquation['dashboardEquationPlan'];
                }
            }
        } elseif(isset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries']) && array_key_exists('withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries', $options)){
            unset($options['withVariablesRealPlanByFrequencyNotificationFromDashboardEquationMultiSeries']);
            
//            $arrayVariables['dashboardEquationReal']['value'] = $arrayVariables['dashboardEquationPlan']['value'] = 0.0;
            $arrayVariables['dashboardEquationReal']['unit'] = $arrayVariables['dashboardEquationPlan']['unti'] = '';
            $arrayVariables['dashboardEquationReal']['description'] = $arrayVariables['dashboardEquationPlan']['description'] = '';
            
            $arrayVariables['dashboardEquationReal']['description'] = $indicator->getShowByRealValue();
            $arrayVariables['dashboardEquationPlan']['description'] = $indicator->getShowByPlanValue();
            if($indicator->getDetails()){
                $arrayVariables['dashboardEquationReal']['unit'] = $indicator->getDetails()->getResultRealUnit();
                $arrayVariables['dashboardEquationPlan']['unit'] = $indicator->getDetails()->getResultPlanUnit();
            }
            
            foreach($valuesIndicator as $valueIndicator){
                $valuesFromDashboardEquation = $this->calculateFormulaValueFromDashboardEquation($formula,$valueIndicator->getFormulaParameters());
                $arrayVariables['dashboardEquationReal']['value'][] = $valuesFromDashboardEquation['dashboardEquationReal'];
                $arrayVariables['dashboardEquationPlan']['value'][] = $valuesFromDashboardEquation['dashboardEquationPlan'];
            }
        } else{
            $variables = $formula->getVariables();

            if(isset($options['viewVariablesFromPlanEquation']) && array_key_exists('viewVariablesFromPlanEquation', $options)){
                unset($options['viewVariablesFromPlanEquation']);
                $vars = $this->getArrayVars($formula, $formula->getSourceEquationPlan());

                foreach ($valuesIndicator as $valueIndicator) {
                    foreach ($variables as $variable) {
                        if (array_search($variable->getName(), $vars)) {
                            $nameParameter = $variable->getName();
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                            $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                            $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                            $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                        }
                    }
                }
            } elseif(isset($options['viewVariablesFromRealEquation']) && array_key_exists('viewVariablesFromRealEquation', $options)){
                unset($options['viewVariablesFromRealEquation']);
                $vars = $this->getArrayVars($formula, $formula->getSourceEquationReal());

                foreach ($valuesIndicator as $valueIndicator) {
                    foreach ($variables as $variable) {
                        if (array_search($variable->getName(), $vars)) {
                            $nameParameter = $variable->getName();
                            $arrayVariables[$nameParameter]['value'] = $valueIndicator->getParameter($nameParameter);
                            $arrayVariables[$nameParameter]['description'] = $variable->getDescription();
                            $arrayVariables[$nameParameter]['summary'] = $variable->getSummary();
                            $arrayVariables[$nameParameter]['unit'] = $variable->getUnitResultValue();
                        }
                    }
                }
            }
        }

        return $arrayVariables;
    }

    /**
     * Función que retorna el valor acumulado de una variable, de acuerdo a las notificaciones qiue tenga el indicador
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

        $totalNumChildrens = count($indicator->getChildrens()); //Número de indicadores asociados
        
        $category = $dataSetReal = $dataSetPlan = $medition = array();
        $dataSetReal["seriesname"] = "Real";
        $dataSetPlan["seriesname"] = "Plan";
        $medition["seriesname"] = "% Cumplimiento";
        $medition["renderas"] = "line";
        $medition["parentYAxis"] = "S";
        $medition["showValues"] = "0";

        if(isset($options['childrens']) && array_key_exists('childrens', $options)){
            unset($options['childrens']);
            if ($totalNumChildrens > 0) {//La info a mostrar es de los indicadores asociados
                $indicatorsChildrens = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicator->getId()); //Obtenemos los indicadores asociados
                if($indicator->getDetails()){
                    $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
                }
                foreach ($indicatorsChildrens as $indicatorChildren) {
                    $label = $dataReal = $dataPlan = $dataMedition = array();
                    $label["label"] = $indicatorChildren->getSummary();
                    $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    $dataReal["value"] = number_format($indicatorChildren->getValueFinal(), 2, ',', '.');
                    $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    $dataPlan["value"] = number_format($indicatorChildren->getTotalPlan(), 2, ',', '.');
                    $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                    $dataMedition["value"] = number_format($indicatorChildren->getResultReal(), 2, ',', '.');

                    $category[] = $label;
                    $dataSetReal["data"][] = $dataReal;
                    $dataSetPlan["data"][] = $dataPlan;
                    $medition["data"][] = $dataMedition;
                }
            }
        } elseif(isset($options['withVariablesRealPLan']) && array_key_exists('withVariablesRealPLan', $options)) {//La info a mostrar es de los resultados propios en base al real o plan
            unset($options['withVariablesRealPLan']);
            if($indicator->getDetails()){
                $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            $label = $dataReal = $dataPlan = $dataMedition = array();
            $label["label"] = $indicator->getSummary();
            $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
            $dataReal["value"] = number_format($indicator->getValueFinal(), 2, ',', '.');
            $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
            $dataPlan["value"] = number_format($indicator->getTotalPlan(), 2, ',', '.');
            $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
            $dataMedition["value"] = number_format($indicator->getResultReal(), 2, ',', '.');

            $category[] = $label;
            $dataSetReal["data"][] = $dataReal;
            $dataSetPlan["data"][] = $dataPlan;
            $medition["data"][] = $dataMedition;
        } elseif(isset($options['byFrequencyNotification']) && array_key_exists('byFrequencyNotification', $options)){
            unset($options['byFrequencyNotification']);
            if($indicator->getDetails()){
                $chart["pYAxisName"] = $indicator->getDetails()->getResultManagementUnit();
            }
            $arrayVariables = array();
            if($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_FROM_EQ){
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanFromEquationByFrequencyNotification' => true));
            } elseif($indicator->getFormula()->getTypeOfCalculation() == Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC){
                $arrayVariables = $this->getArrayVariablesFormulaWithData($indicator, array('viewVariablesRealPlanAutomaticByFrequencyNotification' => true));
            }
            
            $dataSetReal["seriesname"] = $arrayVariables['descriptionReal'];
            $dataSetPlan["seriesname"] = $arrayVariables['descriptionPlan'];
            $medition["seriesname"] = $indicator->getSummary();
            $medition["renderas"] = "line";
            $medition["parentYAxis"] = "S";
            $medition["showValues"] = "0";

            $totalValueIndicators = count($indicator->getValuesIndicator());
            $labelsFrequencyNotificationArray = $this->getLabelsByIndicatorFrequencyNotification($indicator);
            for ($i = 0;$i < $totalValueIndicators; $i++) {
                $label = $dataReal = $dataPlan = $dataMedition = array();
//                $label["label"] = $i;
                $label["label"] = $labelsFrequencyNotificationArray[($i+1)];
//                $label["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                $dataReal["value"] = number_format($arrayVariables['valueReal'][$i], 2, ',', '.');
//                $dataReal["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                $dataPlan["value"] = number_format($arrayVariables['valuePlan'][$i], 2, ',', '.');
//                $dataPlan["link"] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorChildren->getId()));
                $dataMedition["value"] = number_format($arrayVariables['medition'][$i], 2, ',', '.');

                $category[] = $label;
                $dataSetReal["data"][] = $dataReal;
                $dataSetPlan["data"][] = $dataPlan;
                $medition["data"][] = $dataMedition;
            }
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetReal;
        $data['dataSource']['dataset'][] = $dataSetPlan;
        $data['dataSource']['dataset'][] = $medition;

        return $data;
    }
    
    /**
     * Función que retorna las etiquetas de los rangos de la frecuencia de notificación del indicador
     * @param Indicator $indicator
     * @return array
     */
    public function getLabelsByIndicatorFrequencyNotification(Indicator $indicator){
        $frequency = $indicator->getFrequencyNotificationIndicator();
        $labelsFrequencyArray = array();
        
        if($frequency->getDays() == 30){
            $labelsFrequencyArray = CommonObject::getLabelsMonths();
        } elseif($frequency->getDays() == 60){
            $labelsFrequencyArray = CommonObject::getLabelsBimonthly();
        } elseif($frequency->getDays() == 90){
            $labelsFrequencyArray = CommonObject::getLabelsTrimonthly();
        } elseif($frequency->getDays() == 120){
            $labelsFrequencyArray = CommonObject::getLabelsFourmonthly();
        } elseif($frequency->getDays() == 180){
            $labelsFrequencyArray = CommonObject::getLabelsSixmonthly();
        }
        
        return $labelsFrequencyArray;
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
                'categories' => array(
                ),
                'dataSet' => array(
                ),
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
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())) . '"><b>' . $indicator->getParent()->getRef() . '</b></a></span>';
            $textArrow.= '<span style="padding-left:" class="icon-forward"></span>';
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())) . '"><b>' . $indicator->getRef() . '</b></a></span>';
        } elseif ($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO) {
            if (count($indicator->getParent()->getParent()) > 0) {
                $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getParent()->getId())) . '"><b>' . $indicator->getParent()->getParent()->getRef() . '</b></a></span>';
                $textArrow.= '<span class="icon-forward"></span>';
            }
            $textArrow.= '<span class="thin"><a href="' . $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())) . '"><b>' . $indicator->getParent()->getRef() . '</b></a></span>';
            $textArrow.= '<span class="icon-forward"></span>';
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
    public function calculateSimpleAverage(LineStrategic &$lineStrategic, $mode = 1) {
        $indicators = $lineStrategic->getIndicators();
        $quantity = count($indicators);
        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $value = 0.0;
        foreach ($indicators as $indicator) {
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
    
    public function getSecurityContext()
    {
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
        }

        //var_dump($band);
        return $band;
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
