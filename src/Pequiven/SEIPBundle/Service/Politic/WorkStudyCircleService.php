<?php

namespace Pequiven\SEIPBundle\Service\Politic;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Model\Common\CommonObject;
use Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle;

class WorkStudyCircleService implements ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function generateColumn3d($conf, $datos) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(),
                'dataset' => array(),
            ),
        );


        $chart = array();

        $chart["caption"] = $conf["caption"];
        $chart["subCaption"] = $conf["subCaption"];
        $chart["pYAxisName"] = $conf["ejeyLeft"];
        $chart["sYAxisName"] = "% Inscritos";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
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

        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $usersTemp = $datos["usersTemp"]; //USUARIOS TOTALES DE PEQUIVEN POR COMPLEJO
        $complejosCant = $datos["complejosCant"]; //CANTIDAD DE CIRCULOS POR COMPLEJO
        $cantNotNull = $datos["cantNotNull"]; //CANTIDAD DE USUARIOS REGISTRADOS EN CIRCULOS
        $complejos = $datos["complejos"];

        $categories = array();
        $meta = $real = array();
        for ($i = 0; $i < count($complejos); $i++) {
            $categories[] = array("label" => $complejos[$i]->getRef());

            if ($conf["type"] == "circle") {
                $meta[] = array("value" => round(($usersTemp[$i] / 12), 0, PHP_ROUND_HALF_DOWN));
                $real[] = array("value" => $complejosCant[$i]);
                $perc = (($complejosCant[$i]) * 100) / ($usersTemp[$i] / 12);
                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
            } else if ($conf["type"] == "user") {
                $meta[] = array("value" => ($usersTemp[$i]));
                $real[] = array("value" => $cantNotNull[$i]);
                $perc = ($cantNotNull[$i] * 100) / $usersTemp[$i];
                $percentaje[] = array("value" => number_format($perc, 2, ',', '.'));
            }
        }

        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Real",
            "data" => $real
        );
        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Meta",
            "data" => $meta
        );

        $data["dataSource"]["dataset"][] = array(
            "seriesname" => "Porcentaje",
            "renderAs" => "line",
            "parentYAxis" => "S",
            "showValues" => "0",
            "data" => $percentaje
        );


        $data["dataSource"]["chart"] = $chart;
        $data["dataSource"]["categories"][]["category"] = $categories;

        return json_encode($data);
    }

    public function getDataChartOfProposalData($proposal, $lineas) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(
                ),
                'dataset' => array(
                ),
            ),
        );
        $chart = array();

        $chart["caption"] = "Propuestas por Linea Estrategica";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        //Export
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataMeta = array();

        //Carga de Nombres de Labels
        $dataSetLinea["seriesname"] = "Real";
        $dataSetMeta["seriesname"] = "Meta";

        $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findAll();

        $countLinea = count($lineas);
        //$lineas = $this->get('pequiven.repository.linestrategic')->findAll();
        foreach ($lineas as $value) {
            $linea = $value->getDescription();
            $id = $value->getId();

            for ($i = 0; $i <= $countLinea; $i++) {
                $dataProposal = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findBy(array('lineStrategic' => $id));
                $dataCount = count($dataProposal);
                $label["label"] = $linea;
            }

            $category[] = $label;
            $dataLinea["value"] = $dataCount; //Carga de valores
            $dataSetLinea["data"][] = $dataLinea; //data linea

            $dataMeta["value"] = count($workStudyCircle) * 2;
            $dataSetMeta["data"][] = $dataMeta;
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetLinea;
        $data['dataSource']['dataset'][] = $dataSetMeta;

        return $data;
        //return json_encode($data);
    }

    public function getDataChartOfProposalDataLocalidad($proposal) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(
                ),
                'dataset' => array(
                ),
            ),
        );
        $chart = array();

        $chart["caption"] = "Propuestas por Localidad";
        $chart["sNumberSuffix"] = "%";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000,#e20000";
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
        //Export
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLinea = $dataLista = $dataMeta = array();
        $count = $dataCountComplejo = 0;

        //Carga de Nombres de Labels
        $dataSetLocalidad["seriesname"] = "Real";
        $dataSetMeta["seriesname"] = "Meta";

        $localidad = $em->getRepository('PequivenMasterBundle:Complejo')->findAll(); //Consultar las localidades

        $countLocalidad = count($localidad); //Contar las localidades

        foreach ($localidad as $value) {

            $localidad = $value->getDescription();
            $id = $value->getId();

            $label["label"] = $localidad;
            $category[] = $label;

            $workStudyCircle = $em->getRepository('PequivenSEIPBundle:Politic\WorkStudyCircle')->findBy(array('complejo' => $id));
            //var_dump(count($workStudyCircle));

            $dataVer = $em->getRepository('PequivenSEIPBundle:Politic\Proposal')->findQueryProposalComplejo($id);
            $dataLista = count($dataVer);
            $dataLocalidad["value"] = $dataLista; //Carga de valores reales
            $dataSetLocalidad["data"][] = $dataLocalidad; //data reales

            $dataMeta["value"] = count($workStudyCircle) * 14; //Carga de valores meta
            $dataSetMeta["data"][] = $dataMeta; //data meta
        }

        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetLocalidad;
        $data['dataSource']['dataset'][] = $dataSetMeta;

        return $data;
    }

    public function getDataDocumentsChart() {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'dataset' => array(
                ),
            ),
        );
        $chart = array();

        $chart["caption"] = "Documentos por Localidad";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        //Export
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";


        $em = $this->getDoctrine()->getManager();

        //Carga de Nombres de Labels
        // $dataSetLocal["seriesname"] = "Localidad";
        $dataSetLocal = array();
        $d = array();
        $localidad = $em->getRepository('PequivenMasterBundle:Complejo')->findAll(); //Consultar las localidades

        foreach ($localidad as $value) {
            $dataCount = 0;

            $label = $value->getRef();
            $id = $value->getId();
            $meetings = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findQueryMeetingsComplejo($id);
            //$dataCount = count($meetings);
            foreach ($meetings as $meeting) {
                $dataCount += count($meeting->getMeetingFile());
            }

            $dataLocal["label"] = $label; //Carga de valores
            $dataLocal["value"] = $dataCount; //Carga de valores
            //    $dataSetLocal["data"][] = $dataLocal; //data localidad
            $d[] = $dataLocal;
        }
//        var_dump(json_encode($d));
//        die();
        $data['dataSource']['chart'] = $chart;
        $data['dataSource']['dataset'] = $d;


        return ($data);
    }

    public function getDataChartOfMeetingsData($period) {
        $data = array(
            'dataSource' => array(
                'chart' => array(),
                'categories' => array(
                ),
                'dataset' => array(
                ),
            ),
        );
        $chart = array();

        $chart["caption"] = "Reuniones por Localidad";
        $chart["sYAxisName"] = "";
        $chart["sNumberSuffix"] = "";
        $chart["sYAxisMaxValue"] = "100";
        $chart["paletteColors"] = "#0075c2,#1aaf5d,#e20000,#f2c500,#f45b00,#8e0000";
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
        $chart["toolTipColor"] = "#ffffff";
        $chart["toolTipBgColor"] = "#000000";
        $chart["toolTipBgAlpha"] = "80";
        $chart["toolTipBorderRadius"] = "2";
        $chart["toolTipPadding"] = "5";
        $chart["showLegend"] = "1";
        $chart["legendBgColor"] = "#ffffff";
        $chart["legendItemFontSize"] = "10";
        $chart["legendItemFontColor"] = "#666666";
        //Export
        $chart["exportenabled"] = "1";
        $chart["exportatclient"] = "0";
        $chart["exportFormats"] = "PNG= Exportar como PNG|PDF= Exportar como PDF";
        $chart["exportFileName"] = "Grafico Resultados ";
        $chart["exporthandler"] = "http://107.21.74.91/";

        $em = $this->getDoctrine()->getManager();

        $label = $dataLocalidad = array();

        //Carga de Nombres de Labels
        $dataSetLocal["seriesname"] = "Localidad";

        $localidad = $em->getRepository('PequivenMasterBundle:Complejo')->findAll(); //Consultar las localidades

        foreach ($localidad as $value) {

            $label = $value->getRef();
            $id = $value->getId();

            $dataVer = $em->getRepository('PequivenSEIPBundle:Politic\Meeting')->findQueryMeetingsComplejo($id, $period);
            $dataCount = count($dataVer);

            //$category[] = $label;//label cargado con la localidad
            $dataLocal["label"] = $label; //Carga de valores

            $dataLocal["value"] = $dataCount; //Carga de valores
            $dataSetLocal["data"][] = $dataLocal; //data localidad
        }

        $data['dataSource']['chart'] = $chart;
        //$data['dataSource']['categories'][]["category"] = $category;
        $data['dataSource']['dataset'][] = $dataSetLocal;

        return $data;
    }

    /**
     * Función que devuelve si se puede crear un círculo
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @param type $phase
     * @return boolean
     */
    public function isAllowCreateWorkStudyCircleByPhase(\Pequiven\SEIPBundle\Entity\User $user, $phase = \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE) {
        $workStudyCircles = $user->getWorkStudyCircles();
        $createWorkStudyCircle = true;

        foreach ($workStudyCircles as $workStudyCircle) {
            if ($workStudyCircle->getPhase() == $phase) {
                $createWorkStudyCircle = false;
            }
        }

        return $createWorkStudyCircle;
    }

    /**
     * Si el usuario pertenece a un círculo de alguna fase, retorna el círculo al que pertenece
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @param type $phase
     * @return type
     */
    public function obtainWorkStudyCircleByPhase(\Pequiven\SEIPBundle\Entity\User $user, $phase = \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE) {
        $workStudyCircles = $user->getWorkStudyCircles();
        $object = null;

        foreach ($workStudyCircles as $workStudyCircle) {
            if ($workStudyCircle->getPhase() == $phase) {
                $object = $workStudyCircle;
            }
        }

        return $object;
    }

    /**
     * Función que devuelve si se puede editar un CET
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToEdit(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_ONE) {
            if ($this->getSecurityContext()->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_EDIT')) || $workStudyCircle->getCoordinator()->getId() == $user->getId()) {
                $valid = true;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Función que devuelve si se pueden añadir miembros a un CET
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToAddMembers(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_ONE) {
            if ($workStudyCircle->getCoordinator()->getId() == $user->getId()) {
                $valid = true;
            }
        } else {
            $valid = false;
        }
        
        if($this->getSecurityContext()->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_ADD_USERS'))){
            $valid = true;
        }

        return $valid;
    }

    /**
     * Función que devuelve si se permite editar los miembros de un CET
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToEditMembers(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();
        
        if ($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_ONE) {
            if ($this->getSecurityContext()->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_EDIT')) || $workStudyCircle->getCoordinator()->getId() == $user->getId()) {
                $valid = true;
            }
        } else {
            $valid = true;
        }
        
        if($this->getSecurityContext()->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_EDIT_USERS'))){
            $valid = true;
        }

        return $valid;
    }

    /**
     * Función que devuelve si se pueden añadir miembros a un CET
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToDeleteMembers(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getPhase() == WorkStudyCircle::PHASE_ONE) {
            if ($workStudyCircle->getCoordinator()->getId() == $user->getId()) {
                $valid = true;
            }
        } else {
            $valid = false;
        }
        
        if($this->getSecurityContext()->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_DELETE_USERS'))){
            $valid = true;
        }

        return $valid;
    }

    /**
     * Función que devuelve si se puede añadir una reunión a un CET
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToAddMeetings(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getCoordinator()) {
            if ($this->getSecurityContext()->isGranted(array('ROLE_SEIP_MEETING_ADD')) || $workStudyCircle->getCoordinator()->getId() == $user->getId()) {
                $valid = true;
            }
        }

        return $valid;
    }

    /**
     * 
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToAddProposals(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getCoordinator()) {
            if (($this->getSecurityContext()->isGranted(array('ROLE_SEIP_PROPOSAL_ADD')) || $workStudyCircle->getCoordinator()->getId() == $user->getId())) {
//            if(($this->getSecurityContext()->isGranted(array('ROLE_SEIP_PROPOSAL_ADD')) || $workStudyCircle->getCoordinator()->getId() == $user->getId()) && ($workStudyCircle->getId() == 440 || $workStudyCircle->getId() == 441)){
                $valid = true;
            }
        }

        return $valid;
    }

    /**
     * 
     * @param WorkStudyCircle $workStudyCircle
     * @return boolean
     */
    public function isAllowToEditProposals(WorkStudyCircle $workStudyCircle) {
        $valid = false;
        $user = $this->getUser();

        if ($workStudyCircle->getCoordinator()) {
            if (($this->getSecurityContext()->isGranted(array('ROLE_SEIP_PROPOSAL_EDIT')) || $workStudyCircle->getCoordinator()->getId() == $user->getId())) {
                $valid = true;
            }
        } elseif ($this->getSecurityContext()->isGranted(array('ROLE_SEIP_PROPOSAL_EDIT'))) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * 
     * @return \Symfony\Component\Security\Core\SecurityContext
     * @throws \LogicException
     */
    private function getSecurityContext() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context');
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
    public function getUser() {
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
