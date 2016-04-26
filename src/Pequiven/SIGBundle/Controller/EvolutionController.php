<?php

namespace Pequiven\SIGBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de Evolución
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class EvolutionController extends ResourceController
{
    
    /**
     *
     *
     *
     */
    public function exportChrat(Request $request)
    {          
        if($request->isMethod('POST')){
          $exportRequestStream = $request->request->all();          
          $request->request->remove('charttype');
          $request->request->remove('stream');
          $request->request->remove('stream_type');
          $request->request->remove('meta_bgColor');
          $request->request->remove('meta_bgAlpha');
          $request->request->remove('meta_DOMId');
          $request->request->remove('meta_width');
          $request->request->remove('meta_height');
          $request->request->remove('parameters');
          $fusionchartService = $this->getFusionChartExportService();          
          $fileSVG = $fusionchartService->exportFusionChart($exportRequestStream);           
        }        

        //return $fileSVG;
        $this->exportAction($request);            

    }

    /**
     *
     * Exportar informe de Evolución
     *
     */
    public function exportAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $routing = $this->container->getParameter('kernel.root_dir')."/../web/php-export-handler/temp/*.png";
        
        //$fileSVG = $this->exportChrat($request);        
        sleep(1);
        $formula = "";
        //Buscando los Archivos por Codigo
        $nameSVG = glob("$routing");
        $user = $this->getUser()->getId();//Id Usuario    
        $user = str_pad($user, 6,"0", STR_PAD_LEFT);
        
        $cont = 0;
        $contImg = 1;
        foreach ($nameSVG as $value) {            
            $pos = strpos($nameSVG[$cont], $user);            
            if ($pos !== false) {                                 
                if (strpos($nameSVG[$cont], "mscolumnline3d")) {                    
                    $chartEvolution = $nameSVG[$cont];                    
                    $contImg ++;                    
                }
                if (strpos($nameSVG[$cont], "stackedbar3d")) {
                    $chartCause = $nameSVG[$cont];                                                            
                }
            }
            $cont ++;
        }        
        
        $id = $request->get('id'); //id         
        $typeObject = $request->get('typeObj'); //Tipo de objeto (1 = Indicador/2 = Programa G.) 
        //si el indicador es clonado
        if ($typeObject == 1) { 
            $indicator = $this->get('pequiven.repository.indicator')->find($id); //Obtenemos el indicador
            $indicatorBase = $indicator;
            if ($indicator->getParentCloning()) {
                $id = $indicator->getParentCloning()->getId();            
                $indicator = $indicator->getParentCloning();
                //Si el indicador es clonado y viene del estratetico
                if ($indicator->getParentCloning()) {
                    $id = $indicator->getParentCloning()->getId();
                    $indicator = $indicator->getParentCloning();
                }
            }
        }else{
            $indicator = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);
        }

        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $dataAction = $evolutionService->findEvolutionCause($indicator, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas

        $month = $request->get('month'); //El mes pasado por parametro
        
        $font = "";
        if ($typeObject == 1) {            
            $name = $indicatorBase->getRef() . ' ' . $indicatorBase->getDescription(); //Nombre del Indicador
            $type = "indicator";
            //Relación - Objetivo
            foreach ($indicator->getObjetives() as $value) {
                $objRel = $value->getDescription();
            }
            $routingTendency = "/../web/bundles/pequivensig/images/";//Ruta de la Tendencia
            $tendency = $indicator->getTendency()->getId();
            switch ($tendency) {
                case 0:
                    $font = "";
                    break;
                case 1:
                    $font = "1.png";
                    break;
                case 2:
                    $font = "2.png";
                    break;
                case 3:
                    $font = "3.png";
                    break;
            }
            $font = $routing.$routingTendency.$font;            
            $formula = $indicator->getFormula();

        } elseif ($typeObject == 2) {
            $ArrangementProgram = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findWithData($id);
            $type = "arrangementProgram";
            $name = $ArrangementProgram->getRef() . '' . $ArrangementProgram->getDescription();
            //Relacion
            $objRel = $ArrangementProgram->getTacticalObjective()->getDescription();
        }
        
        
        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findBy(array($type => $id, 'month' => $month));
        if ($trend) {
            foreach ($trend as $value) {
                $trendDescription = $value->getDescription(); //Tendencia
            }
        } else {
            $trendDescription = "No se ha Cargando el Analisis de Tendencia";
        }

        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array($type => $id, 'month' => $month));
        if ($causeAnalysis) {
            foreach ($causeAnalysis as $value) {
                $causeA = $value->getDescription();
            }
        } else {
            $causeA = "No se ha Cargando el Analisis de Causas";
        }

        //Verificación
        $verification = $this->get('pequiven.repository.sig_action_verification')->findBy(array($type => $id, 'month' => $month));

        //Periodo
        $period = $this->getPeriodService()->getPeriodActive();
        
            $data = array(
                'formula'       => $formula,            
                'nameSVG'       => $chartEvolution,
                'chartCause'    => $chartCause,
                'month'         => $month,
                'name'          => $name,
                'trend'         => $trendDescription,
                'causeAnalysis' => $causeA,
                'dataAction'    => $dataAction["actionValue"],
                'obj'           => $objRel,
                'verification'  => $verification,
                'period'        => $period,
                'font'          => $font
            );
        
            $this->generatePdf($data);                    
    }

    public function generatePdf($data) {
        $pdf = new \Pequiven\SIGBundle\Model\PDF\SIGPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SIG');
        $pdf->setTitle('INFORME DE EVOLUCIÓN');
        $pdf->SetSubject('Resultados SIG');
        $pdf->SetKeywords('PDF, SIG, Resultados');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // add a page        
        $pdf->AddPage('L');

        // set some text to print 
        $html = $this->renderView('PequivenSIGBundle:Indicator:viewPdf.html.twig', $data);

        // print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('Informe de evolucion' . '.pdf', 'D');

        $this->rmTempFile($data);
    }

    /**
     *
     *  Eliminación de Archivos temporales
     *
     */
    public function rmTempFile($data)
    {   
        $imgChart = $data['nameSVG'];//Ruta
        $imgCause = $data['chartCause'];//Ruta
        
        shell_exec("rm $imgChart");//Eliminamos
        shell_exec("rm $imgCause");//Eliminamos

    }

    /**
     * 
     * @return \Pequiven\SIGBundle\Service\EvolutionService
     */
    protected function getEvolutionService() {
        return $this->container->get('seip.service.evolution');
    } 

    /**
     * @return \Pequiven\SEIPBundle\Service\FusionChartExportService
     */
    private function getFusionChartExportService() {
        return $this->container->get('pequiven_seip.service.fusion_chart');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    } 
	/**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
   
}