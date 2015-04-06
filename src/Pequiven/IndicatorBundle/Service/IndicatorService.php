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
    public function calculateFormulaValue(Formula $formula,$data) 
    {
        if(!is_array($data)){
            $data = array();
        }
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
            @eval(sprintf('$equation_real = %s;',$sourceEquationReal));
            @eval(sprintf('$equation_plan = %s;',$sourceEquationPlan));
            @eval(sprintf('$result = @%s;',$equationParse));
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
            if($indicator->getTypeOfCalculation() == Indicator::TYPE_CALCULATION_FORMULA_AUTOMATIC){
                if($formula->getTypeOfCalculation() !== Formula::TYPE_CALCULATION_REAL_AND_PLAN_AUTOMATIC 
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
                        if($findVariables != 2){
                            $error = $this->trans('pequiven_indicator.errors.the_formula_must_have_the_variables_defined_plan_and_real',array(),'PequivenIndicatorBundle');
                        }
                    }
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
     * Función que devuelve la data para el widget de tipo bulbo en el dashboard de los resultados estratégicos
     * @param Indicator $indicator
     * @return string
     * @author Matias Jimenez
     */
    public function getDataDashboardWidgetBulb(Indicator $indicator){
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
        $chart["valueFontSize"] = "10";
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
        $chart["clickURL"] = 'n-'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
        $chart["clickURLOverridesPlotLinks"] = "0";
        
        $color = $colorData = array();
        $colorData["minvalue"] = "0";
        $colorData["maxvalue"] = "100";
        
        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $arrangementRange = $indicator->getArrangementRange();
        $tendency = $indicator->getTendency();
        $errorArrangementRange = null;
        if($arrangementRange !== null){
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($arrangementRange, $tendency);
            if($errorArrangementRange == null){
                if($indicator->getEvaluateInPeriod()){//En caso de que sea medidio en el período actual
                    $colorData["label"] = number_format($indicator->getResultReal(), 2, ',', '.').'%';
                    if($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                        $colorData["code"] = "#1aaf5d";
                    } elseif($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                        $colorData["code"] = "#f2c500";
                    } elseif($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                        $colorData["code"] = "#c02d00";
                    }
                } else{
                    $colorData["code"] = "#544040";
                    $colorData["label"] = $this->trans('pequiven_indicator.errors.indicatorNoEvaluateInPeriod', array(), 'PequivenIndicatorBundle');
                }
            } else{
                $colorData["code"] = "#000000";
                $colorData["label"] = $errorArrangementRange;
            }
        } else{
            $colorData["code"] = "#000000";
            $colorData["label"] = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }
        
        $color[] = $colorData;
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['colorRange']['color'] = $color;
        
        return $data;
    }
    
    /**
     * Función que devuelve la data para el widget de tipo torta multi nivel en el dashboard de cada indicador
     * @param Indicator $indicator
     * @return string
     * @author Matias Jimenez
     */
    public function getDataDashboardWidgetMultiLevelPie(Indicator $indicator){
        $objectIndicator = $indicator;
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'category' => array(
                ),
            ),
        );
        $chart = array();
        
        $chart["caption"] = $indicator->getRef().'-'.$indicator->getSummary();
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
        if($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
            foreach($indicator->getLineStrategics() as $lineStrategic){//Anexamos la data del centro
                $idLineStrategic = $lineStrategic->getId();
                $category["label"] = $lineStrategic->getRef();//$lineStrategic->getDescription();
                $category["color"] = "#ffffff";
                $category["value"] = "100";
                $category["toolText"] = $lineStrategic->getDescription();
                $category["link"] = $this->generateUrl('pequiven_line_strategic_show', array('id' => $lineStrategic->getId()));
                $categoryLineStrategic["label"] = $indicator->getRef();//$indicator->getSummary();
                $categoryLineStrategic["color"] = $this->getColorOfResult($indicator);
                $categoryLineStrategic["value"] = "100";
                $categoryLineStrategic["toolText"] = $indicator->getDescription().' - '.number_format($indicator->getResultReal(), 2, ',', '.');
                $categoryLineStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId()));
                if(($numChildrens = count($indicator->getChildrens())) > 0){
                    $numDiv = bcdiv(100, $numChildrens,2);
                    foreach($indicator->getChildrens() as $children){
                        $IndicatorTacticArray = array();
                        $IndicatorTacticArray["label"] = $children->getRef();
                        $IndicatorTacticArray["color"] = $this->getColorOfResult($children);
                        $IndicatorTacticArray["value"] = $numDiv;
                        $IndicatorTacticArray["toolText"] = $indicator->getDescription().' - '.number_format($children->getResultReal(), 2, ',', '.');
                        $IndicatorTacticArray['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                        $categoryObjetiveStrategic[] = $IndicatorTacticArray;
                    }
                }
                $categoryLineStrategic['category'] = $categoryObjetiveStrategic;
                $category["category"][] = $categoryLineStrategic;
            }
        } elseif(($indicatorParent = $indicator->getParent()) != NULL){
            $seeTree = true;
            $flagParent = false;
            $cont = 1;
            while(!$flagParent){
                if($indicatorParent->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){//En caso de que estemos en el indicador Táctico
                    $flagParent = true;
                    if($cont == 1){//En caso de que se este viendo un indicador táctico
//                        $indicatorsGroup = $indicatorParent->getChildrens();
                        $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());
                    }
                    foreach($indicatorParent->getLineStrategics() as $lineStrategic){
                        $idLineStrategic = $lineStrategic->getId();
                        
                        $category["label"] = $lineStrategic->getRef();
                        $category["color"] = "#ffffff";
                        $category["value"] = "100";
                        $category["toolText"] = $lineStrategic->getDescription();
                        $category["link"] = $this->generateUrl('pequiven_line_strategic_show', array('id' => $lineStrategic->getId()));
                        $categoryLineStrategic["label"] = $indicatorParent->getRef();//$indicator->getSummary();
                        $categoryLineStrategic["color"] = $this->getColorOfResult($indicatorParent);
                        $categoryLineStrategic["value"] = "100";
                        $categoryLineStrategic["toolText"] = $indicatorParent->getDescription().' - '.number_format($indicatorParent->getResultReal(), 2, ',', '.');
                        $categoryLineStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicatorParent->getId()));
                        $categoryObjetiveStrategic["label"] = $objectIndicator->getRef();
                        $categoryObjetiveStrategic["color"] = $this->getColorOfResult($objectIndicator);
                        $categoryObjetiveStrategic["value"] = "100";
                        $categoryObjetiveStrategic["toolText"] = $objectIndicator->getDescription().' - '.number_format($objectIndicator->getResultReal(), 2, ',', '.');
                        $categoryObjetiveStrategic['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $objectIndicator->getId()));

                        if(($numChildrens = count($objectIndicator->getChildrens())) > 0){
                            $numDiv = bcdiv(100, $numChildrens,2);
                            foreach($objectIndicator->getChildrens() as $children){
                                $IndicatorOperativeArray = array();
                                $IndicatorOperativeArray["label"] = $children->getRef();
                                $IndicatorOperativeArray["color"] = $this->getColorOfResult($children);
                                $IndicatorOperativeArray["value"] = $numDiv;
                                $IndicatorOperativeArray["toolText"] = $children->getDescription().' - '.number_format($children->getResultReal(), 2, ',', '.');
                                $IndicatorOperativeArray['link'] = $this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $children->getId()));
                                $categoryObjetiveTactic[] = $IndicatorOperativeArray;
                            }
                        }
                        $categoryObjetiveStrategic['category'] = $categoryObjetiveTactic;//Anexamos los Objetivos Operativos
                        $categoryLineStrategic['category'][] = $categoryObjetiveStrategic;//Anexamos el Objetivo Táctico
                        $category["category"][] = $categoryLineStrategic;//Anexamos el Objetivo Estratégico
                    }
                } else{
                    $cont++;
//                    $indicatorsGroup = $indicatorParent->getChildrens();//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
                    $indicatorsGroup = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicatorParent->getId());//En caso de que se este viendo un indicador operativo, obtenemos los indicadores asociados al táctico, antes de actualizar el objeto indicadorPadre
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
     * @return string
     * @author Matias Jimenez
     */
    public function getDataDashboardWidgetDoughnut(Indicator $indicator){
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
        $chart["use3DLighting"] = "0";
        $chart["showShadow"] = "0";
        $chart["enableSmartLabels"] = "1";
        $chart["startingAngle"] = "0";
        $chart["showLabel"] = "1";
        $chart["showPercentValues"] = "1";
        $chart["showLegend"] = "1";
        $chart["legendShadow"] = "0";
        $chart["legendBorderAlpha"] = "0";
        $chart["defaultCenterLabel"] = $indicator->getSummary().': '.number_format($indicator->getResultReal(), 2, ',', '.').'%';
        $chart["centerLabel"] = "\$label";
        $chart["centerLabelBold"] = "1";
        $chart["manageLabelOverflow"] = "1";
        $chart["useEllipsesWhenOverflow"] = "1";
        $chart["showTooltip"] = "1";
        $chart["decimals"] = "0";
        $chart["captionFontSize"] = "14";
        $chart["captionPadding"] = "-10";
        $chart["borderThickness"] = "2";
        $chart["legendPosition"] = "BOTTOM";
        $chart["useDataPlotColorForLabels"] = "1";
        $chart["minimiseWrappingInLegend"] = "1";
        
        $dataSet = array();
        
        $totalNumChildrens = count($indicator->getChildrens());//Número de indicadores asociados
        $numDiv = $totalNumChildrens > 0 ? bcdiv(100, $totalNumChildrens,2) : 100;
        
        if($totalNumChildrens > 0){
            $indicatorsChildrens = $this->container->get('pequiven.repository.indicator')->findByParentAndOrderShow($indicator->getId());//Obtenemos los indicadores asociados
            foreach($indicatorsChildrens as $indicatorChildren){
                $set = array();
                $set["label"] = $indicatorChildren->getSummary().': '.number_format($indicatorChildren->getResultReal(), 2, ',', '.').'%';
                $set["value"] = $numDiv;
                $set["displayValue"] = $indicatorChildren->getRef().' - '.number_format($indicatorChildren->getResultReal(), 2, ',', '.').'%';
                $set["toolText"] = $indicatorChildren->getSummary().':{br}'.number_format($indicatorChildren->getResultReal(), 2, ',', '.').'%';
                $set["color"] = $this->getColorOfResult($indicatorChildren);
                $dataSet[] = $set;
            }
        }
        
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['dataSet'] = $dataSet;
        return $data;
    }
    
    public function resultWithArrangementRangeColor(Indicator $indicator){
        $color = '';
        $text = number_format($indicator->showResultOfIndicator(), 2, ',', '.');
        if($indicator->getShowTagInResult()){
            foreach ($indicator->getTagsIndicator() as $tagIndicator){
                if($tagIndicator->getShowInIndicatorResult()){
                    if($tagIndicator->getUnitResult() != ""){
                        $text.= ' '.strtoupper($tagIndicator->getUnitResultValue());
                    } else{
                        $text.= '%';
                    }
                }
            }
        } else{
            $text.= '%';
        }
        $title = '';
        $resultService = $this->getResultService();
        $arrangementRangeService = $this->getArrangementRangeService();
        $arrangementRange = $indicator->getArrangementRange();
        $tendency = $indicator->getTendency();
        $errorArrangementRange = null;
        if($arrangementRange !== null){
            $errorArrangementRange = $arrangementRangeService->validateArrangementRange($arrangementRange, $tendency);
            if($errorArrangementRange == null){
                if($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                    $color = "#1aaf5d";
                } elseif($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                    $color = "#f2c500";
                } elseif($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                    $color = "#c02d00";
                }
            } else{
                $color = "#000000";
                $text = $errorArrangementRange;
            }
        } else{
            $color = "#000000";
            $text = $this->trans('pequiven_indicator.errors.arrangementRange_not_assigned', array(), 'PequivenIndicatorBundle');
        }
        
        if(!$indicator->hasNotification()){
            $color = "#000000";
            $title = $this->trans('pequiven_indicator.summary.without_result', array(), 'PequivenIndicatorBundle');
        }
        
        $response = '<span title="'.$title.'" style="color:'.$color.';"><b>'.$text.'</b></span>';
        return $response;
    }
    
    /**
     * Función que retorna el color del indicador de acuerdo al resultado de medición en comparación con el rango de gestión definido
     * @param Indicator $indicator
     * @return string
     */
    public function getColorOfResult(Indicator $indicator){
        $resultService = $this->getResultService();
        $tendency = $indicator->getTendency();
        $color = "#ffffff";
        if($indicator->getEvaluateInPeriod()){
            if($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                $color = "#1aaf5d";
            } elseif($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                $color = "#f2c500";
            } elseif($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                $color = "#ff0000";
            }
        } else{
            $color = "#544040";
        }
        
        return $color;
    }
    
    /**
     * Función que retorna
     * @param Indicator $indicator
     * @return string
     */
    public function getArrowOfIndicator(Indicator $indicator){
        $textArrow = '<hgroup style="text-align: center;" class="thin breadcrumb">';
        if($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())).'">'.$indicator->getRef().'</a></span>';
        } elseif($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO){
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())).'">'.$indicator->getParent()->getRef().'</a></span>';
            $textArrow.= '<span class="icon-forward"></span>';
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())).'">'.$indicator->getRef().'</a></span>';
        } elseif($indicator->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO){
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getParent()->getId())).'">'.$indicator->getParent()->getParent()->getRef().'</a></span>';
            $textArrow.= '<span class="icon-forward"></span>';
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getParent()->getId())).'">'.$indicator->getParent()->getRef().'</a></span>';
            $textArrow.= '<span class="icon-forward"></span>';
            $textArrow.= '<span class="thin"><a href="'.$this->generateUrl('pequiven_indicator_show_dashboard', array('id' => $indicator->getId())).'">'.$indicator->getRef().'</a></span>';
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
            if($mode == 1){
                $value += $indicator->getResultReal();
            } else{
                $arrangementRange = $indicator->getArrangementRange();
                if($arrangementRange !== null){
                    $errorArrangementRange = null;
                    if($errorArrangementRange == null){
                        $tendency = $indicator->getTendency();
                        if($resultService->calculateRangeGood($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                            $value += 1;
                        } elseif($resultService->calculateRangeMiddle($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                            $value += 2;
                        } elseif($resultService->calculateRangeBad($indicator, $tendency, CommonObject::TYPE_RESULT_ARRANGEMENT)){
                            $value += 3;
                        }
                    } else{
                        $value += 4;
                    }
                } else{
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
    public function updateTagIndicator(Indicator &$indicator){
        $em = $this->getDoctrine()->getManager();
        $tagIndicatorService = $this->getTagIndicatorService();
        
        foreach($indicator->getTagsIndicator() as $tagIndicator){
            if($tagIndicator->getTypeTag() == Indicator\TagIndicator::TAG_VALUE_FROM_EQUATION){
                $parametersForTemplate = array(
                    'indicator' => $indicator,
                    'tagIndicatorService' => $tagIndicatorService,
                );
                $valueTag = trim($this->renderString($tagIndicator->getEquationReal(),$parametersForTemplate));
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
    public function getTagIndicatorByOrder(Indicator $indicator){
        $tagsIndicator = $this->container->get('pequiven.repository.tagIndicator')->findBy(array('indicator' => $indicator->getId()),array('orderShow' => 'ASC'));
        
        return $tagsIndicator;
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
    
    /**
     * Servicio de las Etiquetas del Indicador
     * @return \Pequiven\IndicatorBundle\Service\TagIndicatorService
     */
    public function getTagIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.tag_indicator');
    }
    
    /**
     * 
     * @return \Pequiven\ArrangementBundle\Service\ArrangementRangeService
     */
    protected function getArrangementRangeService()
    {
        return $this->container->get('pequiven_arrangement.service.arrangementrange');
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
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
    protected function generateUrl($route, $parameters = array(), $referenceType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
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
    
    /**
     * Renders a string view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return String twig
     */
    private function renderString($string, array $parameters = array())
    {
        return $this->container->get('app.twig_string')->render($string, $parameters);
    }
}
