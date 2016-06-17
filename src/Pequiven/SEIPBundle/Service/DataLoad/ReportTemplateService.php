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
        $chart["captionFontSize"] = "24";
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
            
            $data['dataSource']['annotations'] = $annotations;
        } elseif (isset($options['consolidateCorporationStatusCharge']) && array_key_exists('consolidateCorporationStatusCharge', $options)) {
            unset($options['consolidateCorporationStatusCharge']);
            
            $reportTemplatesExclude = array(
                'CPJAA' =>true,
                'PETROCASA' => true,
            );
            
            $chart["caption"] = 'Producción Pequiven';
            $chart["yAxisName"] = "TM";
            $chart["showLegend"] = "0";
            
            $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();
            
            $reportTemplates = array();

//            $resultReportTemplates = $repositoryReportTemplate->findAll();
            $resultReportTemplates = $repositoryReportTemplate->findReportTemplatesByPeriod(3);
//           var_dump(count($resultReportTemplates));die();
            //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
            foreach($resultReportTemplates as $resultReportTemplate){
                if(!array_key_exists($resultReportTemplate->getLocation()->getAlias(),$reportTemplatesExclude)){
                    $reportTemplates[] = $resultReportTemplate;
                }
            }

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateCorporationStatusCharge' => true, 'dateSearch' => $options['dateSearch'], 'reportTemplates' => $reportTemplates));
            
            foreach($reportTemplates as $reportTemplate) {
// TODO: DEJARLO COMO ESTA LÍNEA                if ($reportTemplate->getPeriod() == $this->getPeriodService()->getPeriodActive()) {
                
                    $category[] = array('label' => $reportTemplate->getLocation()->getAlias());                    
                
            }
            
            $dataRealValues = $dataPlanValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($reportTemplates as $reportTemplate) {
                $dataRealValues['seriesname'] = 'Real';
//                $dataRealValues['includeInLegend'] = '0';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$reportTemplate->getId()]['color'], 'link' => $this->generateUrl('pequiven_data_load_dashboard_production_report_template',array('reportTemplateId' => $reportTemplate->getId(),'typeView' => \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_STATUS_CHARGE)));
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            
//            $chart['paletteColors'] = "#003CFF";
            
            $annotations = array();
//            $dataGroups = array();
//            
//            $dataGroupsWithoutNotification = array();
//            $dataGroupsNotificationPending = array();
//            $dataGroupsNotificationSave = array();
//            
//            $dataGroupsWithoutNotification['id'] = "without-notification";
//            $dataGroupsWithoutNotification['xShift'] = "100";
//            
//            $dataItemsWithoutNotification = array();
//            $dataItemsWithoutNotification["id"] = "without-notification-circle";
//            $dataItemsWithoutNotification["type"] = "circle";
//            $dataItemsWithoutNotification["x"] = "\$chartStartX + 20";
//            $dataItemsWithoutNotification["y"] = "\$legendEndY + 2";
//            $dataItemsWithoutNotification["radius"] = "8";
//            $dataItemsWithoutNotification["color"] = "#FF0004";
//            $dataItemsWithoutNotification["border"] = "2";
//            $dataItemsWithoutNotification["borderColor"] = "#FF0004";
//            $dataGroupsWithoutNotification['items'][] = $dataItemsWithoutNotification;
//            
//            $dataItemsWithoutNotification = array();
//            $dataItemsWithoutNotification["id"] = "without-notification-label";
//            $dataItemsWithoutNotification["type"] = "text";
//            $dataItemsWithoutNotification["text"] = "Sin Notificar";
//            $dataItemsWithoutNotification["rotate"] = "90";
//            $dataItemsWithoutNotification["color"] = "#ffffff";
//            $dataItemsWithoutNotification["x"] = "\$chartStartX + 65";
//            $dataItemsWithoutNotification["y"] = "\$legendEndY + 2";
//            $dataGroupsWithoutNotification['items'][] = $dataItemsWithoutNotification;
//            
//            $dataGroupsNotificationPending['id'] = "notification-pending";
//            $dataGroupsNotificationPending['xShift'] = "100";
//            
//            $dataItemsNotificationPending = array();
//            $dataItemsNotificationPending["id"] = "notification-pending-circle";
//            $dataItemsNotificationPending["type"] = "circle";
//            $dataItemsNotificationPending["x"] = "\$chartStartX + 130";
//            $dataItemsNotificationPending["y"] = "\$legendEndY + 2";
//            $dataItemsNotificationPending["radius"] = "8";
//            $dataItemsNotificationPending["color"] = "#E5E752";
//            $dataItemsNotificationPending["border"] = "2";
//            $dataItemsNotificationPending["borderColor"] = "#E5E752";
//            $dataGroupsNotificationPending['items'][] = $dataItemsNotificationPending;
//            
//            $dataItemsNotificationPending = array();
//            $dataItemsNotificationPending["id"] = "notification-pending-label";
//            $dataItemsNotificationPending["type"] = "text";
//            $dataItemsNotificationPending["text"] = "Notificación Pendiente";
//            $dataItemsNotificationPending["rotate"] = "90";
//            $dataItemsNotificationPending["color"] = "#ffffff";
//            $dataItemsNotificationPending["x"] = "\$chartStartX + 195";
//            $dataItemsNotificationPending["y"] = "\$legendEndY + 2";
//            $dataGroupsNotificationPending['items'][] = $dataItemsNotificationPending;
//            
//            $dataGroupsNotificationSave['id'] = "notification-save";
//            $dataGroupsNotificationSave['xShift'] = "100";
//            
//            $dataItemsNotificationSave = array();
//            $dataItemsNotificationSave["id"] = "notification-save-circle";
//            $dataItemsNotificationSave["type"] = "circle";
//            $dataItemsNotificationSave["x"] = "\$chartStartX + 240";
//            $dataItemsNotificationSave["y"] = "\$legendEndY + 2";
//            $dataItemsNotificationSave["radius"] = "8";
//            $dataItemsNotificationSave["color"] = "#0EED59";
//            $dataItemsNotificationSave["border"] = "2";
//            $dataItemsNotificationSave["borderColor"] = "#0EED59";
//            $dataGroupsNotificationSave['items'][] = $dataItemsNotificationSave;
//            
//            $dataItemsNotificationSave = array();
//            $dataItemsNotificationSave["id"] = "notification-save-label";
//            $dataItemsNotificationSave["type"] = "text";
//            $dataItemsNotificationSave["text"] = "Notificación Completa";
//            $dataItemsNotificationSave["rotate"] = "90";
//            $dataItemsNotificationSave["color"] = "#ffffff";
//            $dataItemsNotificationSave["x"] = "\$chartStartX + 285";
//            $dataItemsNotificationSave["y"] = "\$legendEndY + 2";
//            $dataItemsNotificationSave["autoScale"] = "1";
//            $dataGroupsNotificationSave['items'][] = $dataItemsNotificationSave;
//            
//            $dataGroupsWithoutNotification['autoScale'] = "1";
//            $dataGroupsNotificationPending['autoScale'] = "1";
//            $dataGroupsNotificationSave['autoScale'] = "1";
//            
//            $annotations['groups'][] = $dataGroupsWithoutNotification;
//            $annotations['groups'][] = $dataGroupsNotificationPending;
//            $annotations['groups'][] = $dataGroupsNotificationSave;
//            $annotations['autoScale'] = "1";
//            $annotations['constrainScale'] = "1";
            
            $data['dataSource']['annotations'] = $annotations;
        } elseif(isset($options['reportTemplateByDateStatusCharge']) && array_key_exists('reportTemplateByDateStatusCharge', $options)){
            unset($options['reportTemplateByDateStatusCharge']);
            
            $chart["yAxisName"] = "TM";
            $chart["showLegend"] = "0";
            
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('reportTemplateByDateStatusCharge' => true, 'dateSearch' => $options['dateSearch'], 'typeDate' => $options['typeDate']));
            
            $plantReports = $reportTemplate->getPlantReports();
            
            $dataRealValues = $dataPlanValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($plantReports as $plantReport) {
                $category[] = array('label' => $plantReport->getPlant()->getAlias());
                $dataRealValues['seriesname'] = 'Real';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$plantReport->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$plantReport->getId()]['color']);
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$plantReport->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            
//            $chart['paletteColors'] = "#003CFF";
            
            $annotations = array();
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;

        return $data;
    }
    
    /**
     * Función que devuelve la data para un gráfico tipo MultiSeriesDualAxis
     * @param ReportTemplate $reportTemplate
     * @param type $options
     * @return type
     */
    public function getDataChartMultiSeriesDualAxis(ReportTemplate $reportTemplate, $options = array()){
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
                'annotations' => array(),
                ),
        );

        $chart = array();
        
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
        $chart["divLineDashed"] = "0";
        $chart["dashed"] = "0";
        $chart["divLineDashLen"] = "0";
        $chart["divLineGapLen"] = "0";
        $chart["canvasBgAlpha"] = "0,0";
        $chart["captionFontSize"] = "24";
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
        
        if (isset($options['consolidateCorporationCompliance']) && array_key_exists('consolidateCorporationCompliance', $options)) {
            unset($options['consolidateCorporationCompliance']);
            
            $chart["caption"] = 'Producción Pequiven';
            $chart["pYAxisName"] = "TM";
            $chart["showDivLineValues"] = "0";
            $chart["sYAxisName"] = "% Producción";
            $chart["showLegend"] = "0";
            
            $repositoryReportTemplate = $this->container->get('pequiven.repository.report_template');
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();
            
            $reportTemplatesExclude = array(
                'CPJAA' =>true,
                'PETROCASA' => true,
            );
            
            $reportTemplates = array();

//            $resultReportTemplates = $repositoryReportTemplate->findAll();
            $resultReportTemplates = $repositoryReportTemplate->findReportTemplatesByPeriod(3);
            
            if($securityContext->isGranted(array('ROLE_SEIP_OPERATION_REPORT_TEMPLATES_ALL'))){
                $userReportTemplates = $resultReportTemplates;
            } else{
                $userReportTemplates = $user->getReportTemplates();
            }
            $userReportTemplatesArray = array();
            foreach($userReportTemplates as $userReportTemplate){
                $userReportTemplatesArray[$userReportTemplate->getId()] = true;
            }
            //Seteamos sólo los reportTemplates de PQV, ya que los de la EEMM y Filiales se buscan directo en el controlador del gráfico
            foreach($resultReportTemplates as $resultReportTemplate){
                if(!array_key_exists($resultReportTemplate->getLocation()->getAlias(),$reportTemplatesExclude) && array_key_exists($resultReportTemplate->getId(), $userReportTemplatesArray)){
                    $reportTemplates[] = $resultReportTemplate;
                }
            }

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateCorporationCompliance' => true, 'dateSearch' => $options['dateSearch'], 'reportTemplates' => $reportTemplates));
            
            foreach($reportTemplates as $reportTemplate) {
//                if ($reportTemplate->getPeriod() == $this->getPeriodService()->getPeriodActive()) {
                
                    $category[] = array('label' => $reportTemplate->getLocation()->getAlias());                    
                
            }
            
            $dataRealValues = $dataPlanValues = $dataComplianceValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($reportTemplates as $reportTemplate) {
                $dataRealValues['seriesname'] = 'Real';
//                $dataRealValues['includeInLegend'] = '0';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataComplianceValues["renderAs"] = "line";
                $dataComplianceValues["parentYAxis"] = "S";
                $dataComplianceValues["showValues"] = "0";
                $dataComplianceValues["color"] = "#B7B7B6";
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$reportTemplate->getId()]['color'], 'link' => $this->generateUrl('pequiven_data_load_dashboard_production_report_template',array('reportTemplateId' => $reportTemplate->getId(),'typeView' => \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_COMPLIANCE)));
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
                $dataComplianceValues['data'][] = array('value' => number_format($dataSerialized[$reportTemplate->getId()]['compliance'], 2, ',', '.'), 'displayValue' => number_format($dataSerialized[$reportTemplate->getId()]['compliance'], 2, ',', '.').' %');
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            $data['dataSource']['dataset'][] = $dataComplianceValues;
            
//            $chart['paletteColors'] = "#003CFF";
            
            $annotations = array();
            
            $data['dataSource']['annotations'] = $annotations;
        } elseif(isset($options['reportTemplateByDateCompliance']) && array_key_exists('reportTemplateByDateCompliance', $options)){
            unset($options['reportTemplateByDateCompliance']);
            
            $chart["pYAxisName"] = "TM";
            $chart["showDivLineValues"] = "0";
            $chart["sYAxisName"] = "% Producción";
            $chart["showLegend"] = "0";
            
            $user = $this->getUser();
            $securityContext = $this->getSecurityContext();

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('reportTemplateByDateCompliance' => true, 'dateSearch' => $options['dateSearch'], 'typeDate' => $options['typeDate']));
            
            $plantReports = $reportTemplate->getPlantReports();
            
            $dataRealValues = $dataPlanValues = $dataComplianceValues = array();
            
            //Añadimos los valores, por cada planta del reportTemplate
            foreach($plantReports as $plantReport) {
                $category[] = array('label' => $plantReport->getPlant()->getAlias());
                $dataRealValues['seriesname'] = 'Real';
                $dataPlanValues['seriesname'] = 'Plan';
                $dataComplianceValues["renderAs"] = "line";
                $dataComplianceValues["parentYAxis"] = "S";
                $dataComplianceValues["showValues"] = "0";
                $dataComplianceValues["color"] = "#B7B7B6";
                $dataRealValues['data'][] = array('value' => number_format($dataSerialized[$plantReport->getId()]['real'], 2, ',', '.'), 'color' => $dataSerialized[$plantReport->getId()]['color']);
                $dataPlanValues['data'][] = array('value' => number_format($dataSerialized[$plantReport->getId()]['plan'], 2, ',', '.'), 'color' => "#003CFF");
                $dataComplianceValues['data'][] = array('value' => number_format($dataSerialized[$plantReport->getId()]['compliance'], 2, ',', '.'), 'displayValue' => number_format($dataSerialized[$plantReport->getId()]['compliance'], 2, ',', '.').' %');
            }
            
            $data['dataSource']['dataset'][] = $dataRealValues;
            $data['dataSource']['dataset'][] = $dataPlanValues;
            $data['dataSource']['dataset'][] = $dataComplianceValues;
            
//            $chart['paletteColors'] = "#003CFF";
            
            $annotations = array();
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
                } elseif($dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] > 0 && !$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                }
            }
        } elseif(isset($options['consolidateCorporationStatusCharge']) && array_key_exists('consolidateCorporationStatusCharge', $options)){
            unset($options['consolidateCorporationStatusCharge']);
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
                } elseif($dataSerialized[$reportTemplate->getId()]['contNotificationTotal'] > 0 && !$dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$reportTemplate->getId()]['flagNotificationHalf']){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                }
            }
        } elseif(isset($options['consolidateCorporationCompliance']) && array_key_exists('consolidateCorporationCompliance', $options)){
            unset($options['consolidateCorporationCompliance']);
            $reportTemplates = $options['reportTemplates'];
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            
            //SETEAMOS LOS VALORES POR DEFECTO
            foreach($reportTemplates as $reportTemplate){
                $dataSerialized[$reportTemplate->getId()]['real'] = $dataSerialized[$reportTemplate->getId()]['plan'] =  $dataSerialized[$reportTemplate->getId()]['compliance'] = 0.0;
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
                    }
                }
                
                if($dataSerialized[$reportTemplate->getId()]['plan'] > 0){
                    $dataSerialized[$reportTemplate->getId()]['compliance'] = ($dataSerialized[$reportTemplate->getId()]['real'] / $dataSerialized[$reportTemplate->getId()]['plan'])*100;
                } elseif($dataSerialized[$reportTemplate->getId()]['plan'] == 0 && $dataSerialized[$reportTemplate->getId()]['real'] > 0){
                    $dataSerialized[$reportTemplate->getId()]['compliance'] = 100.0;
                }
                
                if($dataSerialized[$reportTemplate->getId()]['compliance'] < 50.0){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#FF0004';
                } elseif($dataSerialized[$reportTemplate->getId()]['compliance'] >= 50.0 && $dataSerialized[$reportTemplate->getId()]['compliance'] <= 90.0){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$reportTemplate->getId()]['compliance'] > 90.0){
                    $dataSerialized[$reportTemplate->getId()]['color'] = '#0EED59';
                }
            }
        } elseif(isset($options['reportTemplateByDateStatusCharge']) && array_key_exists('reportTemplateByDateStatusCharge', $options)){
            unset($options['reportTemplateByDateStatusCharge']);
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            
            $plantReports = $reportTemplate->getPlantReports();
            
            //SETEAMOS LOS VALORES POR DEFECTO
            foreach($plantReports as $plantReport){
                $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['plan'] = 0.0;
                $dataSerialized[$plantReport->getId()]['color'] = '#FF0004';
                $dataSerialized[$plantReport->getId()]['contNotificationTotal'] = 0;
                $dataSerialized[$plantReport->getId()]['flagNotificationHalf'] = false;
                $dataSerialized[$plantReport->getId()]['observations'] = array();
            }
            
            //RELLENAMOS LA DATA
            foreach($plantReports as $plantReport){
                $productReports = $plantReport->getProductsReport();
                $contProductReports = 0;
                foreach($productReports as $productReport){
                    $contProductReports++;
                    $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                    $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($daySearch) : 0.0;
                    $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($daySearch) : 0.0;
                    $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['real'] + $valueReal;
                    $dataSerialized[$plantReport->getId()]['plan'] = $dataSerialized[$plantReport->getId()]['plan'] + $valuePlan;
                    if(array_key_exists($monthSearch, $productDetailDailyMonths)){
                        if(!$dataSerialized[$plantReport->getId()]['flagNotificationHalf']){
                            $dataSerialized[$plantReport->getId()]['flagNotificationHalf'] = $productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE_PENDING ? true : false;
                        }
                        if($productDetailDailyMonths[$monthSearch]->getStatusByDay($daySearch) == \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductDetailDailyMonth::STATUS_SAVE){
                            $dataSerialized[$plantReport->getId()]['contNotificationTotal']++;
                        }
                    }
                }

                //Comparamos si todos los productReports estan notificados en su totalidad
                if($contProductReports == $dataSerialized[$plantReport->getId()]['contNotificationTotal']){
                    $dataSerialized[$plantReport->getId()]['color'] = '#0EED59';
                } elseif($dataSerialized[$plantReport->getId()]['contNotificationTotal'] > 0 && !$dataSerialized[$plantReport->getId()]['flagNotificationHalf']){
                    $dataSerialized[$plantReport->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$plantReport->getId()]['flagNotificationHalf']){
                    $dataSerialized[$plantReport->getId()]['color'] = '#E5E752';
                }
            }
        } elseif(isset($options['reportTemplateByDateCompliance']) && array_key_exists('reportTemplateByDateCompliance', $options)){
            unset($options['reportTemplateByDateCompliance']);
            
            $options['dateSearch'] = str_replace('/', '-', $options['dateSearch']);
            $daySearch = date("j", strtotime($options['dateSearch']));
            $monthSearch = date("n", strtotime($options['dateSearch']));
            $typeDate = $options['typeDate'];
            
            $plantReports = $reportTemplate->getPlantReports();
            
            //SETEAMOS LOS VALORES POR DEFECTO
            foreach($plantReports as $plantReport){
                $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['plan'] =  $dataSerialized[$plantReport->getId()]['compliance'] = 0.0;
            }
            
            //RELLENAMOS LA DATA
            foreach($plantReports as $plantReport){
                $productReports = $plantReport->getProductsReport();
                $contProductReports = 0;
                foreach($productReports as $productReport){
                    $contProductReports++;
                    $productDetailDailyMonths = $productReport->getProductDetailDailyMonthsSortByMonth();
                    
                    if($typeDate == 'day'){
                        $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($daySearch) : 0.0;
                        $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($daySearch) : 0.0;
                        $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['real'] + $valueReal;
                        $dataSerialized[$plantReport->getId()]['plan'] = $dataSerialized[$plantReport->getId()]['plan'] + $valuePlan;
                    } elseif($typeDate == 'month'){
                        for($day = 1; $day <= $daySearch; $day++){
                            $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($day) : 0.0;
                            $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($day) : 0.0;
                            $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['real'] + $valueReal;
                            $dataSerialized[$plantReport->getId()]['plan'] = $dataSerialized[$plantReport->getId()]['plan'] + $valuePlan;
                        }
                    } elseif($typeDate == 'year'){
                        for($day = 1; $day <= $daySearch; $day++){
                            $valueReal = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getValueGrossByDay($day) : 0.0;
                            $valuePlan = array_key_exists($monthSearch, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$monthSearch]->getPlanGrossByDay($day) : 0.0;
                            $dataSerialized[$plantReport->getId()]['real'] = $dataSerialized[$plantReport->getId()]['real'] + $valueReal;
                            $dataSerialized[$plantReport->getId()]['plan'] = $dataSerialized[$plantReport->getId()]['plan'] + $valuePlan;
                        }
                        for($month = 1; $month < $monthSearch; $month++){
                            $dataSerialized[$plantReport->getId()]['real']+= array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossReal() : 0;
                            $dataSerialized[$plantReport->getId()]['plan']+= array_key_exists($month, $productDetailDailyMonths) == true ? $productDetailDailyMonths[$month]->getTotalGrossPlan() : 0;
//                            if($productReport->getId() == 1){
//                                var_dump($dataSerialized[$plantReport->getId()]['plan']);
//                                var_dump($productDetailDailyMonths[$month]->getTotalGrossPlan());
//                                var_dump($month);
//                            }
                        }
                    }
                }
//                die();
                
                if($dataSerialized[$plantReport->getId()]['plan'] > 0){
                    $dataSerialized[$plantReport->getId()]['compliance'] = ($dataSerialized[$plantReport->getId()]['real'] / $dataSerialized[$plantReport->getId()]['plan'])*100;
                } elseif($dataSerialized[$plantReport->getId()]['plan'] == 0 && $dataSerialized[$plantReport->getId()]['real'] > 0){
                    $dataSerialized[$plantReport->getId()]['compliance'] = 100.0;
                }
                
                if($dataSerialized[$plantReport->getId()]['compliance'] < 50.0){
                    $dataSerialized[$plantReport->getId()]['color'] = '#FF0004';
                } elseif($dataSerialized[$plantReport->getId()]['compliance'] >= 50.0 && $dataSerialized[$plantReport->getId()]['compliance'] <= 90.0){
                    $dataSerialized[$plantReport->getId()]['color'] = '#E5E752';
                } elseif($dataSerialized[$plantReport->getId()]['compliance'] > 90.0){
                    $dataSerialized[$plantReport->getId()]['color'] = '#0EED59';
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
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
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