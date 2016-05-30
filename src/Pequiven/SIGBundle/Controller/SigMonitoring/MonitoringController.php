<?php

namespace Pequiven\SIGBundle\Controller\SigMonitoring;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\SIGBundle\Entity\Tracing\Standardization;
use Pequiven\SIGBundle\Form\Tracing\StandardizationType;

/**
 * Controlador Seguimiento y Eficacia
 *
 * @author Maximo Sojo <maximosojo@atechnologies.com.ve>
 */
class MonitoringController extends ResourceController
{
    public function listAction(Request $request)
    {   
        $type = $request->get('type');

        if ($type == 1) {
            $queryRepository = "createPaginatorManagementSystems";            
            $repository = $this->container->get('pequiven.repository.sig_management_system'); 
            $title = "Sistemas de la Calidad";
        }elseif($type == 2) {
            $queryRepository = "createPaginatorNormalizedGerency";            
            $repository = $this->container->get('pequiven.repository.gerenciafirst'); 
            $title = "Gerencias Normalizadas";
        }
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,$queryRepository,
                array($criteria, $sorting)
            );
            
            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if(($limit = $request->query->get('limit')) && $limit > 0){
                if($limit > 100){
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'findBy',
                array($criteria, $sorting, $this->config->getLimit())
            );
        }
        $routeParameters = array(
            '_format' => 'json' ,
            'type'    => $type
        );
        $apiDataUrl = $this->generateUrl('pequiven_sig_monitoring_list', $routeParameters);        
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;

        $view->getSerializationContext()->setGroups(array('id','api_list'));

        if($request->get('_format') == 'html'){
        	$data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'title'      => $title,
                'type'       => $type
            );             
            $view->setData($data);
        }else{
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view); 
    }

    public function showAction(Request $request){

        $this->autoVerificationAction($request);        

        $id = $request->get('id');        
        $type = $request->get('type');

        $em = $this->getDoctrine()->getManager();                        
        $dataAdvance = 0;
        if ($type == 1){
            $result = $this->container->get('pequiven.repository.sig_management_system')->find($id);                  
        }elseif ($type == 2) {
            $result = $this->container->get('pequiven.repository.gerenciafirst')->find($id);             
        }
        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->findBy(array('relationObject' => $id, 'typeObject' => $type));
        
        foreach (Standardization::getDetectionArray() as $key => $value) {
                $labelsDetection[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

        foreach (Standardization::getTypeNcArray() as $key => $value) {
                $labelsTypeNc[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

        $status = [
            0 => "Sin Notificar",
            1 => "Notificado"            
        ];

        $statusMaintanence = [
            1 => "Abierta No Vencia",
            2 => "Cerrada",
            3 => "Abierta Vencida"            
        ];

    	return $this->render('PequivenSIGBundle:Monitoring:show.html.twig', array(
            'data'              => $result,
            'standardization'   => $standardization,
            'detection'         => $labelsDetection,
            'labelsTypeNc'      => $labelsTypeNc,
            'status'            => $status,
            'statusMaintanence' => $statusMaintanence,
            'type'              => $type
            ));
    }

    public function addAction(Request $request){
        
        $id = $request->get('id');          
        $period = $this->getPeriodService()->getPeriodActive();
        $standardization = new standardization();
        $form  = $this->createForm(new StandardizationType($period), $standardization);
        
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            $em = $this->getDoctrine()->getManager();                        

            if ($request->get('analysis')) {
                $standardization->setAnalysis(1);
                $standardization->setFile($request->get('fileName'));
            }
            $standardization->setTypeObject($request->get('type'));
            $standardization->setRelationObject($id);
            $em->persist($standardization);            
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Datos Cargados Exitosamente");
            die();
        }                

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/_form.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                
                'form' => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    public function notificationAction(Request $request){
        $securityContext = $this->container->get('security.context');
        $em = $this->getDoctrine()->getManager();
        
        if ($request->isMethod('POST')) {  
            $id = $request->get('id');
            
            $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);            

            $responsible = $request->get('actionResults')['responsible'];
            $responsibles = explode(",", $responsible);       
            $catnRes = count($responsibles);
            
            $routeParameters = array(                
                'id'   => $request->get('idObject'),
                'type' => $request->get('type')
            );

            $apiDataUrl = $this->generateUrl('pequiven_sig_monitoring_show', $routeParameters);
            //$apiDataUrl = "http://".$_SERVER['HTTP_HOST'].$apiDataUrl;

            for ($i=0; $i < $catnRes; $i++) { 
                $user = $this->get('pequiven_seip.repository.user')->find($responsibles[$i]);
                $notification = $this->getNotificationService()->setDataNotification("Estandarizacion", "Ha sido asignado como responsable la data de estandarizacion ha sido cargada puede verificar.", 4 , 1, $apiDataUrl, $user);                                        
                $standardization->addResponsible($user);
            }            
            
            $standardization->setStatus(1);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Notificación Enviada Exitosamente");
        }
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/formNotify.html'))
            ->setTemplateVar($this->config->getPluralResourceName())            
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    public function deleteAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->get('id');

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);
        
        if($standardization){            
            $em->remove($standardization);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Registro Eliminado Exitosamente");
            die();
        }  

    }

    public function autoVerificationAction(Request $request){        
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->get('id');
        $type = $request->get('type');

        $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id);         
        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->findBy(array('relationObject' => $id));
        foreach ($standardization as $valueMaintenance) {
            foreach ($valueMaintenance->getMaintenance() as $value) {
                if ($value->getStatus() == 1) {
                    $dateEnd = $value->getDateEnd();
                    $dateEnd->setTimestamp((int)$dateEnd->format('U'));
                    $fecha_actual = strtotime(date("d-m-Y"));
                    $fecha_entrada = strtotime($dateEnd->format('d-m-Y'));                    
                    if($fecha_actual > $fecha_entrada){
                        //echo "La fecha entrada ya ha pasado";                        
                        $value->setStatus(3);
                        $em->flush();
                    }                    
                }
            }
        }
        return $this->redirect($this->generateUrl("pequiven_sig_monitoring_show", array('id' => $id, 'type' => $type)));         
        die();        
    }

    public function exportAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
        
        $resource = $this->findOr404($request);
        
        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->findBy(array('relationObject' => $id, 'typeObject' => $request->get('type')));
        
        //Formato para todo el documento
        $styleArrayBordersContent = array(
          "1" => [
              'borders' => array(
                'allborders' => array(
                  'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
              ),
              'font' => array(
              ),
              'alignment' => array(
                  'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
                  'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_TOP,
                  'wrap' => true
              )
            ],
          "2" => [
              'borders' => array(
                'allborders' => array(
                  'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
              ),
              'font' => array(
              ),
              'alignment' => array(
                  'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_TOP,
                  'wrap' => true
              )
          ]
        );
        
        //Formato color
        $styleArray = array(
            "1" => [      
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                    'rgb' => "e4f200"
                    )
                )
            ],
            "2" => [                          
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                    'rgb' => "00e203"
                    )
                )
            ],
            "3" => [                          
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                    'rgb' => "ff0000"
                    )
                )
            ]
        );

        //Formato en negrita
        $styleFont = [
            'font' => [
                'bold' => true
            ]
        ];

        $leyens = [
            1 => "ABIERTA NO VENCIDA",
            2 => "CERRADA",
            3 => "ABIERTA VENCIDA"
        ];
        
        $path = $this->get('kernel')->locateResource('@PequivenSIGBundle/Resources/skeleton/base-sig-se.xls');
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Seguimiento y Verificación de la Eficacia')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
                ;
        $objPHPExcel
                ->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->getDefaultRowDimension()->setRowHeight();

        $row = $iniFile = 10;//Fila Inicial del skeleton
        $contResult = $contData = 0;//Contador de resultados totales
        $rowHeight = 70;//Alto de la fila
        $countStandardization = count($standardization);
        $rowIni = $row;//Fila Inicial 
        $rowFin = $row;//Fila Final 
        $contRow = 1;

        foreach ($standardization as $standardizationData) {
            $analysis = $arrangementProgram = $cp = $ai = $ae = $re = $po = "";

            $activeSheet->setCellValue('A'.$row, $standardizationData->getArea());//Seteamos 
            $activeSheet->getStyle(sprintf('A%s:A%s',$row,$row))->applyFromArray($styleArrayBordersContent[1]);
            
            $activeSheet->setCellValue('B'.$row, $contRow);//Seteamos
            $activeSheet->getStyle(sprintf('B%s:E%s',$row,$row))->applyFromArray($styleArrayBordersContent[2]);
            
            if ($standardizationData->getDetection() == 1) {
                $cp = "X";
            }elseif ($standardizationData->getDetection() == 2) {
                $ai = "X";
            }elseif ($standardizationData->getDetection() == 3) {
                $ae = "X";
            }

            $activeSheet->setCellValue('C'.$row, $cp);//Seteamos 
            $activeSheet->setCellValue('D'.$row, $ai);//Seteamos 
            $activeSheet->setCellValue('E'.$row, $ae);//Seteamos 

            $activeSheet->setCellValue('F'.$row, $standardizationData->getCode());//Seteamos el Codigo
            $activeSheet->getStyle(sprintf('F%s:F%s',$row,$row))->applyFromArray($styleArrayBordersContent[1]);

            if ($standardizationData->getType() == 1) {
                $re = "X";
            }elseif ($standardizationData->getType() == 2) {
                $po = "X";
            }

            $activeSheet->setCellValue('G'.$row, $re);//Seteamos 
            $activeSheet->setCellValue('H'.$row, $po);//Seteamos 
            $activeSheet->getStyle(sprintf('G%s:H%s',$row,$row))->applyFromArray($styleArrayBordersContent[2]);

            $activeSheet->setCellValue('I'.$row, $standardizationData->getDescription());//Seteamos 
            $activeSheet->getStyle(sprintf('I%s:I%s',$row,$row))->applyFromArray($styleArrayBordersContent[1]);

            //Seteamos si hay analisis cargado
            if ($standardizationData->getAnalysis() == 1) {
                $analysis = "X";
            }            
            $activeSheet->setCellValue('J'.$row, $analysis);//Seteamos 
            $activeSheet->getStyle(sprintf('J%s:J%s',$row,$row))->applyFromArray($styleArrayBordersContent[2]);

            if ($standardizationData->getArrangementProgram()) {
                $arrangementProgram = $standardizationData->getArrangementProgram();
            }
            $activeSheet->setCellValue('K'.$row, $arrangementProgram);//Seteamos 
            
            if (count($standardizationData->getMaintenance()) > 0) {                
                foreach ($standardizationData->getMaintenance() as $valueMaintenance) {
                    $dateStart = $valueMaintenance->getDateStart();
                    $dateStart->setTimestamp((int)$dateStart->format('U'));

                    $dateEnd = $valueMaintenance->getDateEnd();
                    $dateEnd->setTimestamp((int)$dateEnd->format('U'));
                    
                    $advance = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance")->findBy(array('maintenance' => $valueMaintenance->getId())); 
                    foreach ($advance as $valueAdvance) {
                        $dataAnalsys = $valueMaintenance->getAnalysis();
                        $dataAdvance = $valueAdvance->getAdvance();
                        $dataObservations = $valueAdvance->getObservations();                    
                    }
                    
                    $activeSheet->setCellValue('L'.$row, $dataAnalsys);//Seteamos el analisis
                    $activeSheet->setCellValue('M'.$row, $dateStart->format('d-m-Y'));//Seteamos fecha inicio de la acción
                    $activeSheet->setCellValue('N'.$row, $dateEnd->format('d-m-Y'));//Seteamos fecha fin de la acción
                    $activeSheet->setCellValue('O'.$row, $dataAdvance."%");//Seteamos el avance
                    
                    $activeSheet->setCellValue('P'.$row, $leyens[$valueMaintenance->getStatus()]);//Seteamos estatus
                    $activeSheet->getStyle(sprintf('P%s:P%s',$row,$row))->applyFromArray($styleFont);//Aplicación de estilos
                    $activeSheet->getStyle(sprintf('P%s:P%s',$row, $row))->applyFromArray($styleArray[$valueMaintenance->getStatus()]);
                    
                    $verificationEstatus = $verificationDate = "Sin Verificación Realizada";
                    $model = [ 1 => 'Eficaz', 2 => 'No Eficaz'];
                    if ($valueMaintenance->getStatusVerification() != NULL) { 
                        $dateVerification = $valueMaintenance->getDateVerification();
                        $dateVerification->setTimestamp((int)$dateVerification->format('U'));                        
                        $verificationEstatus = $model[$valueMaintenance->getStatusVerification()];
                        $verificationDate = $dateVerification->format('d-m-Y');
                    }
                    
                    $activeSheet->setCellValue('Q'.$row, $verificationEstatus);//Seteamos
                    $activeSheet->setCellValue('R'.$row, $verificationDate);//Seteamos                        

                    $activeSheet->setCellValue('S'.$row, $dataObservations);//Seteamos
                }                
            }else{
                $activeSheet->setCellValue('L'.$row, 'Sin carga');
                $activeSheet->setCellValue('M'.$row, 'Sin carga');
                $activeSheet->setCellValue('N'.$row, 'Sin carga');
                $activeSheet->setCellValue('O'.$row, 'Sin carga');
                $activeSheet->setCellValue('P'.$row, 'Sin carga');
                $activeSheet->setCellValue('S'.$row, 'Sin carga');                
            }

            $row++;                                
            $contResult++; 
            $contRow++;
        }
        
        $row = 10;//Fila Inicial del skeleton
        $contRow = ($contRow + $row) - 2;
        $rowLeyend = $contRow + 2;
        for($i=$row;$i<=$contRow;$i++){//Recorremos toda la matriz para setear el alto y los bordes en cada celda
            $activeSheet->getRowDimension($i)->setRowHeight($rowHeight);
            $activeSheet->getStyle(sprintf('K%s:S%s',$i,$i))->applyFromArray($styleArrayBordersContent[1]);
        }
        
        $activeSheet->setCellValue('B'.$rowLeyend, "LEYENDA:");//Seteamos la Leyenda        
        $activeSheet->getStyle(sprintf('B%s:B%s',$rowLeyend,$rowLeyend))->applyFromArray($styleFont);                           
        
        $leyens = [
            1 => "ABIERTA NO VENCIDA: LA ACCIÓN AÚN ESTÁ ABIERTA Y DENTRO DE LA FECHA DE CIERRE",
            2 => "CERRADA: LA ACCIÓN SE CUMPLIÓ EN UN 100%",
            3 => "ABIERTA VENCIDA: LA ACCIÓN AÚN ESTÁ ABIERTA PERO SU FECHA DE CIERRE VENCIÓ"
        ];

        $leyensData = [
            1 => "CP: CONTROL DE PROCESOS",
            2 => "AI: AUDITORÍA INTERNA",
            3 => "AE: AUDITORÍA EXTERNA",
            4 => "RE: REAL",
            5 => "PO: POTENCIAL"
        ];

        for ($i=1; $i < 6; $i++) { 
            $rowLeyend = $rowLeyend + 1;
            if ($i < 4) {
                $activeSheet->getStyle(sprintf('B%s:B%s',$rowLeyend,$rowLeyend))->applyFromArray($styleArray[$i]);           
                $activeSheet->getStyle(sprintf('C%s:C%s',$rowLeyend,$rowLeyend))->applyFromArray($styleFont);                           
                $activeSheet->setCellValue('C'.$rowLeyend, $leyens[$i]);//Seteamos                                        
                $activeSheet->mergeCells(sprintf('C%s:I%s',($rowLeyend),($rowLeyend)));
            }
            $activeSheet->setCellValue('J'.$rowLeyend, $leyensData[$i]);//Seteamos Codigifacion 
            $activeSheet->getStyle(sprintf('J%s:J%s',$rowLeyend,$rowLeyend))->applyFromArray($styleFont);                           
            $activeSheet->mergeCells(sprintf('J%s:K%s',($rowLeyend),($rowLeyend)));
        }


        

        $fileName = sprintf('SEIP-Seguimiento y Verificación de las Acciones-%s-%s.xls',$managemensystems->getDescription(),$now->format('Ymd-His'));
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function uploadAction(Request $request){
        $response = new JsonResponse();    
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
        {   
            $nameFile = sha1(date('d-m-Y : h:m:s'));
            foreach ($request->files as $file) {
                $file->move($this->container->getParameter("kernel.root_dir") . '/../web/uploads/documents/standardization_files/', $nameFile);
                $fileUploaded = $file->isValid();                
            }            

            sleep(3);            
            $response->setData($nameFile);
            return $response;            
        }else{
            throw new Exception("Error Processing Request", 1);   
        }
    }

    public function downloadAction(Request $request){
        $em = $this->getDoctrine()->getManager();                        

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($request->get('id'));
        
        $pathfile = $this->container->getParameter("kernel.root_dir") . '/../web/uploads/documents/standardization_files/'.$standardization->getFile();
        
        $mi_pdf = $pathfile;
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$mi_pdf.'"');
        readfile($mi_pdf);
        die();

    }

    /**
     *  Notification
     *
     */
    protected function getNotificationService() {        
        return $this->container->get('seip.service.notification');
    }

    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
}
