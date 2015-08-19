<?php

namespace Pequiven\SEIPBundle\Service\DataLoad;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\SEIPBundle\Entity\CEI\Company;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para el ReportTemplate
 * 
 * service data_load.service.report_template
 */
class ReportTemplateService implements ContainerAwareInterface {
    
    
    public function getDataChartStackedColumn3d(ReportTemplate $reportTemplate, $options = array()) {

        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );

        $chart = array();

        $chart["caption"] = 'Producción ' . $reportTemplate->getLocation()->getAlias();
//        $chart["subCaption"] = "Sales by quarter";
//        $chart["xAxisName"] = "Indicador";
//        $chart["yAxisName"] = "TM";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "0";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";
        $chart["bgAlpha"] = "0,0";
//        $chart["bgColor"] = "#ffffff";
//        $chart["legendShadow"] = "0";
//        $chart["valueFontColor"] = "#ffffff";
//        $chart["captionFontColor"] = "#ffffff";
//        $chart["canvasBgColor"] = "#ffffff";
//        $chart["theme"] = "fint";

        $category = $dataSetValues = array();

        if (isset($options['consolidateByReportTemplate']) && array_key_exists('consolidateByReportTemplate', $options)) {
            unset($options['consolidateByReportTemplate']);

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateByReportTemplate' => true, 'dateSearch' => $options['dateSearch']));

            $plantReports = $reportTemplate->getPlantReports();//Obtenemos las plantas vinculadas al ReportTemplate
            $totalPlantReports = count($plantReports);
            
            $category[] = array('label' => $dataSerialized['day']['label']);
            $category[] = array('label' => $dataSerialized['month']['label']);
            $category[] = array('label' => $dataSerialized['year']['label']);
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($plantReports as $plantReport) {
                $dataSetValues[$plantReport->getId()]['seriesname'] = $plantReport->getPlant()->getName();
                $dataSetValues[$plantReport->getId()]['data'][] = array('value' => number_format($dataSerialized['day'][$plantReport->getId()]['value'], 2, ',', '.'));
                $dataSetValues[$plantReport->getId()]['data'][] = array('value' => number_format($dataSerialized['month'][$plantReport->getId()]['value'], 2, ',', '.'));
                $dataSetValues[$plantReport->getId()]['data'][] = array('value' => number_format($dataSerialized['year'][$plantReport->getId()]['value'], 2, ',', '.'));
            }

            foreach($plantReports as $plantReport) {
                $data['dataSource']['dataset'][] = $dataSetValues[$plantReport->getId()];
            }
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
//        $data['dataSource']['dataset'][] = $dataSetReal;
//        $data['dataSource']['dataset'][] = $dataSetPlan;

        return $data;
    }
    
    /**
     * Función que devuelve la data para un gráfico tipo MultiSeriesColumna3D
     * @param ReportTemplate $reportTemplate
     * @param type $options
     * @return type
     */
    public function getDataChartMultiSeriesColumn3D(ReportTemplate $reportTemplate, $options = array()){
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
                'annotations' => array(),
            ),
        );

        $chart = array();

//        $chart["subCaption"] = "Sales by quarter";
//        $chart["xAxisName"] = "Indicador";
//        $chart["yAxisName"] = "TM";
//        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500";
        $chart["showBorder"] = "0";
        $chart["showCanvasBorder"] = "0";
        $chart["usePlotGradientColor"] = "0";
        $chart["plotBorderAlpha"] = "10";
        $chart["legendBorderAlpha"] = "0";
        $chart["legendBgAlpha"] = "0";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["baseFontColor"] = "#ffffff";
        $chart["legendItemFontColor"] = "#ffffff";
        $chart["showHoverEffect"] = "1";
        $chart["valuePosition"] = "ABOVE";
        $chart["rotateValues"] = "0";
        $chart["placeValuesInside"] = "0";
        $chart["divlineColor"] = "#999999";
        $chart["divLineDashed"] = "1";
        $chart["divLineDashLen"] = "1";
        $chart["divLineGapLen"] = "1";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["captionFontSize"] = "14";
        $chart["subcaptionFontSize"] = "14";
        $chart["subcaptionFontBold"] = "0";
        $chart["decimalSeparator"] = ",";
        $chart["thousandSeparator"] = ".";
        $chart["inDecimalSeparator"] = ",";
        $chart["inThousandSeparator"] = ".";
        $chart["decimals"] = "2";
        $chart["formatNumberScale"] = "0";
        $chart["bgAlpha"] = "0,0";
        $chart["toolTipBgColor"] = "#000000";

        $category = $dataSetValues = array();

        if (isset($options['consolidateByTypeCompany']) && array_key_exists('consolidateByTypeCompany', $options)) {
            unset($options['consolidateByTypeCompany']);
            
            $chart["caption"] = $options['typeCompany'] == \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MATRIZ ? 'Producción PQV' : 'Producción EEMM y FILIALES';
            
            $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();
            $typeCompany = $options['typeCompany'];

            $arrayTypesCompany = array();
            
            if($typeCompany == Company::TYPE_OF_COMPANY_MATRIZ){
                $arrayTypesCompany[Company::TYPE_OF_COMPANY_MATRIZ] = true;
            } elseif($typeCompany == Company::TYPE_OF_COMPANY_AFFILIATED_MIXTA){
                $arrayTypesCompany[Company::TYPE_OF_COMPANY_AFFILIATED] = true;
                $arrayTypesCompany[Company::TYPE_OF_COMPANY_MIXTA] = true;
            }

            $reportTemplates = array();

            if($securityContext->isGranted(array('ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL'))){
                $resultReportTemplates = $repositoryReportTemplate->findAll();
                //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
                foreach($resultReportTemplates as $resultReportTemplate){
                    if(array_key_exists($resultReportTemplate->getCompany()->getTypeOfCompany(), $arrayTypesCompany)){
                        $reportTemplates[] = $resultReportTemplate;
                    }
                }
            } else{
                $resultReportTemplates = $user->getReportTemplates();
                //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
                foreach($resultReportTemplates as $resultReportTemplate){
                    if(array_key_exists($resultReportTemplate->getCompany()->getTypeOfCompany(), $arrayTypesCompany)){
                        $reportTemplates[] = $resultReportTemplate;
                    }
                }
            }

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateByTypeCompany' => true, 'dateSearch' => $options['dateSearch'], 'typeCompany' => $options['typeCompany'], 'reportTemplates' => $reportTemplates));
            
            foreach($reportTemplates as $reportTemplate) {
                $category[] = array('label' => $reportTemplate->getName());
            }
            
            $dataRealValues = $dataPlanValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($reportTemplates as $reportTemplate) {
                $dataRealValues['seriesname'] = 'Real';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$reportTemplate->getId()]['color']);
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            
            $annotations = array();
            
//             "groups": [
//                {
//                   "id": "total-label",
//                   "items": [
//                      {
//                         "id": "total-label-bg",
//                         "type": "rectangle",
//                         "radius": "3",
//                         "x": "$chartEndX - 120",
//                         "y": "$captionStartY",
//                         "toX": "$chartEndX - 20",
//                         "toY": "$captionStartY + 30",
//                         "fillColor": "#0075c2",
//                         "alpha": "70"
//                      },
//                      {
//                         "id": "total-label-value",
//                         "type": "text",
//                         "fontColor": "#ffffff",
//                         "fontSize": "10",
//                         "x": "$chartEndX - 70",
//                         "y": "$captionStartY + 15",
//                         "wrapWidth": "90",
//                         "wrapHeight": "25",
//                         "text": "Total: $7.5M"
//                      }
//                   ]
//                }
//             ]
            
            $data['dataSource']['annotations'] = $annotations;
        } elseif (isset($options['consolidateCorporation']) && array_key_exists('consolidateCorporation', $options)) {
            unset($options['consolidateCorporation']);
            
            $chart["caption"] = 'Producción Corporación PQV';
            
            $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();
            
            $reportTemplates = array();

            $resultReportTemplates = $repositoryReportTemplate->findAll();
            //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
            foreach($resultReportTemplates as $resultReportTemplate){
                if($resultReportTemplate->getLocation()->getAlias() != 'CPJAA'){
                    $reportTemplates[] = $resultReportTemplate;
                }
            }

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateCorporation' => true, 'dateSearch' => $options['dateSearch'], 'reportTemplates' => $reportTemplates));
            
            foreach($reportTemplates as $reportTemplate) {
                $category[] = array('label' => $reportTemplate->getName());
            }
            
            $dataRealValues = $dataPlanValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($reportTemplates as $reportTemplate) {
                $dataRealValues['seriesname'] = 'Real';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$reportTemplate->getId()]['color']);
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            
            $annotations = array();
            
//             "groups": [
//                {
//                   "id": "total-label",
//                   "items": [
//                      {
//                         "id": "total-label-bg",
//                         "type": "rectangle",
//                         "radius": "3",
//                         "x": "$chartEndX - 120",
//                         "y": "$captionStartY",
//                         "toX": "$chartEndX - 20",
//                         "toY": "$captionStartY + 30",
//                         "fillColor": "#0075c2",
//                         "alpha": "70"
//                      },
//                      {
//                         "id": "total-label-value",
//                         "type": "text",
//                         "fontColor": "#ffffff",
//                         "fontSize": "10",
//                         "x": "$chartEndX - 70",
//                         "y": "$captionStartY + 15",
//                         "wrapWidth": "90",
//                         "wrapHeight": "25",
//                         "text": "Total: $7.5M"
//                      }
//                   ]
//                }
//             ]
            
            $data['dataSource']['annotations'] = $annotations;
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;

        return $data;
    }
    
    /**
     * Función que retorna la data serializada para los distintos tipo de gráficos que se necesitan para los reportTemplates
     * @param ReportTemplate $reportTemplate
     * @param type $options
     * @return array
     */
    public function getDataSerialized(ReportTemplate $reportTemplate, $options = array()) {
        
        $dataSerialized = array();
        
        if(isset($options['consolidateByReportTemplate']) && array_key_exists('consolidateByReportTemplate', $options)){
            unset($options['consolidateByReportTemplate']);
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            
            //Seteo inicial de la estructura a devolver
            $dataSerialized['day']['label'] = 'Día';
            $dataSerialized['month']['label'] = 'Mes';
            $dataSerialized['year']['label'] = 'Año';
            
            
            $plantReports = $reportTemplate->getPlantReports();
            //[day][plant][value]
            foreach($plantReports as $plantReport){
                $dataSerialized['day'][$plantReport->getId()]['value'] = 0.0;
                $dataSerialized['month'][$plantReport->getId()]['value'] = 0.0;
                $dataSerialized['year'][$plantReport->getId()]['value'] = 0.0;
            }
            
            foreach($plantReports as $plantReport){
                $productReports = $plantReport->getProductsReport();
                foreach($productReports as $productReport){
                    $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                    $dataSerialized['day'][$plantReport->getId()]['value'] = $dataSerialized['day'][$plantReport->getId()]['value'] + array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($daySearch) : 0;
                    for($day = 1; $day <= $daySearch; $day++){
                        $dataSerialized['month'][$plantReport->getId()]['value'] = $dataSerialized['month'][$plantReport->getId()]['value'] + array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($day) : 0;
                    }
                    for($month = 1; $month < $monthSearch; $month++){
                        $dataSerialized['year'][$plantReport->getId()]['value'] = $dataSerialized['year'][$plantReport->getId()]['value'] + array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossReal() : 0;
                    }
                }
                $dataSerialized['year'][$plantReport->getId()]['value'] = $dataSerialized['year'][$plantReport->getId()]['value'] + $dataSerialized['month'][$plantReport->getId()]['value'];
            }
        } elseif(isset($options['consolidateByTypeCompany']) && array_key_exists('consolidateByTypeCompany', $options)){
            unset($options['consolidateByTypeCompany']);
            $reportTemplates = $options['reportTemplates'];
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            
            //SETEAMOS LOS VALORES POR DEFECTO
            foreach($reportTemplates as $reportTemplate){
                $dataSerialized[$reportTemplate->getId()]['real'] = $dataSerialized[$reportTemplate->getId()]['plan'] = 0.0;
                $dataSerialized[$reportTemplate->getId()]['color'] = '#FF0004';
                $dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] = 0;
                $dataSerialized[$reportTemplate->getId()]['flagNotificationHalf'] = false;
            }
            
            //RELLENAMOS LA DATA
            foreach($reportTemplates as $reportTemplate){
                $plantReports = $reportTemplate->getPlantReports();
                $contProductReports = 0;

                foreach($plantReports as $plantReport){
                    $productReports = $plantReport->getProductsReport();
                    foreach($productReports as $productReport){
                        $contProductReports++;
                        $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                        $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($daySearch) : 0.0;
                        $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($daySearch) : 0.0;
                        $dataSerialized[$reportTemplate->getId()]['real'] = $dataSerialized[$reportTemplate->getId()]['real'] + $valueReal;
                        $dataSerialized[$reportTemplate->getId()]['plan'] = $dataSerialized[$reportTemplate->getId()]['plan'] + $valuePlan;
                        if(array_key_exists($monthSearch, $productDetailDailyMonths)){
                            if(!$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                                $dataSerialized[$reportTemplate->getId()]['flagNotificationHalf'] = $productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE_PENDING ? true : false;
                            }
                            if($productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE){
                                $dataSerialized[$reportTemplate->getId()]['contNotificationTotal']++;
                            }
                        }
                    }
                }
                
                //Comparamos si todos los productReports estan notificados en su totalidad
                if($contProductReports == $dataSerialized[$reportTemplate->getId()]['contNotificationTotal']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#0EED59';
                } elseif($contProductReports != $dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] && !$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                }
            }
        } elseif(isset($options['consolidateCorporation']) && array_key_exists('consolidateCorporation', $options)){
            unset($options['consolidateCorporation']);
            $reportTemplates = $options['reportTemplates'];
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            
            //SETEAMOS LOS VALORES POR DEFECTO
            foreach($reportTemplates as $reportTemplate){
                $dataSerialized[$reportTemplate->getId()]['real'] = $dataSerialized[$reportTemplate->getId()]['plan'] = 0.0;
                $dataSerialized[$reportTemplate->getId()]['color'] = '#FF0004';
                $dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] = 0;
                $dataSerialized[$reportTemplate->getId()]['flagNotificationHalf'] = false;
            }
            
            //RELLENAMOS LA DATA
            foreach($reportTemplates as $reportTemplate){
                $plantReports = $reportTemplate->getPlantReports();
                $contProductReports = 0;

                foreach($plantReports as $plantReport){
                    $productReports = $plantReport->getProductsReport();
                    foreach($productReports as $productReport){
                        $contProductReports++;
                        $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                        $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($daySearch) : 0.0;
                        $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($daySearch) : 0.0;
                        $dataSerialized[$reportTemplate->getId()]['real'] = $dataSerialized[$reportTemplate->getId()]['real'] + $valueReal;
                        $dataSerialized[$reportTemplate->getId()]['plan'] = $dataSerialized[$reportTemplate->getId()]['plan'] + $valuePlan;
                        if(array_key_exists($monthSearch, $productDetailDailyMonths)){
                            if(!$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                                $dataSerialized[$reportTemplate->getId()]['flagNotificationHalf'] = $productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE_PENDING ? true : false;
                            }
                            if($productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE){
                                $dataSerialized[$reportTemplate->getId()]['contNotificationTotal']++;
                            }
                        }
                    }
                }
                
                //Comparamos si todos los productReports estan notificados en su totalidad
                if($contProductReports == $dataSerialized[$reportTemplate->getId()]['contNotificationTotal']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#0EED59';
                } elseif($contProductReports != $dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] && !$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                }
            }
        }
        
        return $dataSerialized;
    }
    
    public function getReportTemplatesColors(){
        $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();
            $typeCompany = $options['typeCompany'];

            $arrayTypesCompany = array();
            
            $resultReportTemplates = $repositoryReportTemplate->findAll();
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
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() 
    {
        return $this->container->get('seip.user_manager');
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
}