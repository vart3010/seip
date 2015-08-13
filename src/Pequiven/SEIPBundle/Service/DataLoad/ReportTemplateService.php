<?php

namespace Pequiven\SEIPBundle\Service\DataLoad;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
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

        if (isset($options['consolidateByReportTemplate']) && array_key_exists('consolidateByReportTemplate', $options)) {
            unset($options['consolidateByReportTemplate']);

            $dataSerialized = array();
            $dataSerialized = $this->getDataSerialized($reportTemplate, array('consolidateByReportTemplate' => true));

            $plantReports = $reportTemplate->getPlantReports();
            $totalPlantReports = count($plantReports);
            
            //Añadimos los valores, por cada planta del reportTemplate
            for ($i = 0; $i < $totalPlantReports; $i++) {
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
    
    /**
     * Función que retorna la data serializada para los distintos tipo de gráficos que se necesitan para los reportTemplates
     * @param ReportTemplate $reportTemplate
     * @param type $options
     * @return array
     */
    public function getDataSerialized(ReportTemplate $reportTemplate, $options = array()) {
        
        $dataSeralized = array();
        
        
        
        return $dataSeralized;
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

}