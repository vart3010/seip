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
    public function uploadAction(Request $request){
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObject');//typos 1:analisis de causas
        
        //Evolution Service para retorno de objeto
        $evolutionService = $this->getEvolutionService();            
        $object = $evolutionService->getObjectLoadFile($idObject, $typeObject);
        
        $response = new JsonResponse();    
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
        {   
            $nameFile = $typeObject."-".sha1(date('d-m-Y : h:m:s').$idObject);
            
            foreach ($request->files as $file) {
                $file->move($this->container->getParameter("kernel.root_dir") . '/../web/uploads/documents/evolution_files/', $nameFile);
                $fileUploaded = $file->isValid();                
            }   
            $em = $this->getDoctrine()->getManager();
            $object->setFile($nameFile);            
            $em->flush();         

            sleep(3);            
            $response->setData(1);
            return $response;            
        }else{
            throw new Exception("Error Processing Request", 1);   
        }
    }

     public function downloadAction(Request $request){
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObject');//typos 1:analisis de causas

        $em = $this->getDoctrine()->getManager();                        
        
        $evolutionService = $this->getEvolutionService();            
        $object = $evolutionService->getObjectLoadFile($idObject, $typeObject);

        $pathfile = $this->container->getParameter("kernel.root_dir") . '/../web/uploads/documents/evolution_files/'.$object->getFile();
        
        $mi_pdf = $pathfile;
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$mi_pdf.'"');
        readfile($mi_pdf);
        die();

    }
    
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
        $idObject = $request->get('id'); //id         
        $typeObject = $request->get('typeObj'); //Tipo de objeto (1 = Indicador/2 = Programa G.) 
        $month = $request->get('month'); //El mes pasado por parametro
        
        $em = $this->getDoctrine()->getManager();
        
        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);

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
        
        //si el indicador es clonado
        if ($typeObject == 1) { 
            $indicator = $this->get('pequiven.repository.indicator')->find($idObject); //Obtenemos el indicador
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
        }

        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $dataAction = $evolutionService->findEvolutionCause($result, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas
        
        $font = "";
        if ($typeObject == 1) {            
            $name = $indicatorBase->getRef() . ' ' . $indicatorBase->getDescription(); //Nombre del Indicador
            //Relación - Objetivo
            foreach ($indicator->getObjetives() as $value) {
                $objRel = $value->getDescription();
            }           
            $formula = $indicator->getFormula();
            //tendencia
            $tendency = $indicator->getTendency()->getId();
            switch ($tendency) {
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
            $font = $this->generateAsset('bundles/pequivensig/images/'.$font);
        } elseif ($typeObject == 2) {
            $ArrangementProgram = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findWithData($idObject);
            $name = $ArrangementProgram->getRef() . '' . $ArrangementProgram->getDescription();            
            $objRel = $ArrangementProgram->getTacticalObjective()->getDescription();
        } elseif ($typeObject == 3) {            
            $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->find($idObject);
            $name     = $objetive->getRef() . '' . $objetive->getDescription();
            $objRel   = $objetive->getRef() . '' . $objetive->getDescription();
        }
        
        $trendDescription = "No se ha Cargando el Analisis de Tendencia";
        $causeA = "No se ha Cargando el Analisis de Causas";
        
        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_report_evolution')->findOneBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));
        if ($trend) {
            $trendDescription = $trend->getDescription(); //Tendencia
        }
        
        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findOneBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));
        if ($causeAnalysis) {
            $causeA = $causeAnalysis->getDescription();
        }            

        //Verificación
        $verification = $this->get('pequiven.repository.sig_action_verification')->findBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));

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
        //$pdf->setImagenTrend($data['font']);

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
     *  Metodo de Revisión y Aprobación de Informe de Evolución
     *
     */
    public function checkToEvolutionAction(Request $request){        
        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $approve = $evolutionService->updateToCheckApproveEvolution($request->get('id'), $request->get('typeObj'), $request->get('month')); //Carga la data de las causas y sus acciones relacionadas
        $this->get('session')->getFlashBag()->add('success', 'Informe de Evolución '.$approve['message'].' Exitosamente.');                        
        return $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get('id'), "month" => $request->get('month'))));
    }

    /**
     * Servicio para generar los assets
     * @param type $path
     * @param type $packageName
     * @return type
     */
    protected function generateAsset($path,$packageName = null){
        return $this->container->get('templating.helper.assets')
               ->getUrl($path, $packageName);
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