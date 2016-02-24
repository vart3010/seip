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
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class MonitoringController extends ResourceController
{
    public function listAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        
        //$repository = $this->getRepository();        
        $repository = $this->container->get('pequiven.repository.sig_management_system'); 
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorManagementSystems',
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
            '_format' => 'json'            
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
            );            
            $view->setData($data);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view); 
    }

    public function showAction(Request $request){
        
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();                        

    	$managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
        
        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->findBy(array('managementSystem' => $id));
        
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
            0 => "Abierta No Vencia",
            1 => "Cerrada",
            2 => "Abierta Vencida"            
        ];

    	return $this->render('PequivenSIGBundle:Monitoring:show.html.twig', array(
            'data'              => $managemensystems,
            'standardization'   => $standardization,
            'detection'         => $labelsDetection,
            'labelsTypeNc'      => $labelsTypeNc,
            'status'            => $status,
            'statusMaintanence' => $statusMaintanence
            ));
    }

    public function addAction(Request $request){
        
        $id = $request->get('id');  
        $period = $this->getPeriodService()->getPeriodActive();

        $standardization = new standardization();
        $form  = $this->createForm(new StandardizationType($period), $standardization);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
            $em = $this->getDoctrine()->getManager();                        

            if ($request->get('analysis')) {
                $standardization->setAnalysis(1);
            }

            $standardization->setManagementSystem($managemensystems);
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
        
        $em = $this->getDoctrine()->getManager();                        
                    
        $id = $request->get('id');

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);
        
        if($standardization){ 

            $standardization->setStatus(1);        
            $em->flush();            
            
            $notification = $this->getNotificationService()->setDataNotification('Estandarizacion', "La data de estandarizacion ha sido cargada puede verificar. ", 4 , 1, "'pequiven_sig_monitoring_show',{'id': ". $id ." }");            
            
            $this->get('session')->getFlashBag()->add('success', "Notificación Enviada Exitosamente");
        }else{
            $this->get('session')->getFlashBag()->add('success', "Notificación no procesada");            
        }            
        return $this->redirect($this->generateUrl("pequiven_sig_monitoring_show", array("id" => $request->get('idManagement'))));         
        die();        
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

    public function exportAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
        
        $resource = $this->findOr404($request);

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->findBy(array('managementSystem' => $id));
        
        //Formato para todo el documento
        $styleArrayBordersContent = array(
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
        );
        
        //Formato en negrita
        $styleArray = array(
            "1" => [      
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                    'rgb' => "007e20"
                    )
                )
            ],
            "2" => [                          
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                    'rgb' => "e4f200"
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

        foreach ($standardization as $key => $standardizationData) {
            $analysis = $arrangementProgram = $cp = $ai = $ae = $re = $po = "";

            $activeSheet->setCellValue('A'.$row, $standardizationData->getArea());//Seteamos 
            $activeSheet->setCellValue('B'.$row, $contRow);//Seteamos 
            
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
            
            if ($standardizationData->getType() == 1) {
                $re = "X";
            }elseif ($standardizationData->getType() == 2) {
                $po = "X";
            }

            $activeSheet->setCellValue('G'.$row, $re);//Seteamos 
            $activeSheet->setCellValue('H'.$row, $po);//Seteamos 

            $activeSheet->setCellValue('I'.$row, $standardizationData->getDescription());//Seteamos 
            
            //Seteamos si hay analisis cargado
            if ($standardizationData->getAnalysis() == 1) {
                $analysis = "X";
            }            
            $activeSheet->setCellValue('J'.$row, $analysis);//Seteamos 
            
            if ($standardizationData->getArrangementProgram()) {
                $arrangementProgram = $standardizationData->getArrangementProgram();
            }
            $activeSheet->setCellValue('K'.$row, $arrangementProgram);//Seteamos 

            $row++;                                
            $contResult++; 
            $contRow++;
        }



        $row = 10;//Fila Inicial del skeleton
        $contRow = ($contRow + $row) - 2;
        $rowLeyend = $contRow + 2;
        for($i=$row;$i<=$contRow;$i++){//Recorremos toda la matriz para setear el alto y los bordes en cada celda
            $activeSheet->getRowDimension($i)->setRowHeight($rowHeight);
            $activeSheet->getStyle(sprintf('A%s:S%s',$i,$i))->applyFromArray($styleArrayBordersContent);
        }
        
        $activeSheet->setCellValue('B'.$rowLeyend, "LEYENDA:");//Seteamos la Leyenda        
        $activeSheet->getStyle(sprintf('B%s:B%s',$rowLeyend,$rowLeyend))->applyFromArray($styleFont);                           
        
        $leyens = [
            1 => "CERRADA: LA ACCIÓN SE CUMPLIÓ EN UN 100%",
            2 => "ABIERTA NO VENCIDA: LA ACCIÓN AÚN ESTÁ ABIERTA Y DENTRO DE LA FECHA DE CIERRE",
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
