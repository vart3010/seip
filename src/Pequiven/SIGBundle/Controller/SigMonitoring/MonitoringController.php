<?php

namespace Pequiven\SIGBundle\Controller\SigMonitoring;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
    	$managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
    	
    	return $this->render('PequivenSIGBundle:Monitoring:show.html.twig', array('data' => $managemensystems));
    }

    public function exportAction(Request $request){
        $id = $request->get('id');
        $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
        
        $resource = $this->findOr404($request);
        
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
            'font' => array(
                'bold' => true
            )
        );
        
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
        
        ///$fileName = sprintf('SEIP-Seguimiento y Verificación-%s-%s.xls',$now->format('Ymd-His'));
        $fileName = 'SEIP-Seguimiento y Verificación-%s-%s.xls'.$now->format('Ymd-His');

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
}
