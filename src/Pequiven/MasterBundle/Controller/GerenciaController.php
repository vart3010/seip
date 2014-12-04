<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\MasterBundle\Form\Type\Gerencia\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
/**
 * Controlador de gerencia de primera linea
 *
 * @author matias
 */
class GerenciaController extends baseController {
    
    /**
     * @Template("PequivenMasterBundle:Gerencia:list.html.twig")
     * @return type
     */
    public function listAction(){
//        return $this->container->get('templating')->renderResponse('PequivenMasterBundle:Gerencia:list.html.'.$this->container->getParameter('fos_user.template.engine'),
//            array(
//
//            ));
        return array(
            
        );
    }
    
    /**
     * Registro de una gerencia de 1ra línea
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws \Pequiven\MasterBundle\Controller\Exception
     * @Template("PequivenMasterBundle:Gerencia:register.html.twig")
     */
    public function createAction(Request $request){

        $form = $this->createForm(new BaseFormType());
        $form->handleRequest($request);
        $nameObject = 'object';
        $lastId = '';
        $em = $this->getDoctrine()->getManager();
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();
        //Obtenemos el valor del nivel del complejo
        $complejoObject = new Complejo();
        $complejoNameArray = $complejoObject->getComplejoNameArray();
        
        $em->getConnection()->beginTransaction();
        if($form->isValid()){
            $object = $form->getData();
            $data =  $this->container->get('request')->get("pequiven_master_gerenciaFirst_registration");
            
            $object->setUserCreatedAt($user);
            
            $em->persist($object);
            
            try{
            $em->flush();
            $lastId = $em->getConnection()->lastInsertId();
            $em->getConnection()->commit();
            } catch (Exception $e){
                $em->getConnection()->rollback();
                throw $e;
            }
            
            return $this->redirect($this->generateUrl('pequiven_master_home', 
                    array('type' => 'gerenciaFirst',
                          'action' => 'REGISTER_SUCCESSFULL'
                        )
                    ));
        }
        
        
        /*return $this->container->get('templating')->renderResponse('PequivenMasterBundle:Gerencia:register.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView(),
                ));*/
        return array(
            'form' => $form->createView(),
            );
    }
    
     /**
     * Función que devuelve el paginador con las gerencias de 2da Línea
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function gerenciaFirstListAction(Request $request){
        
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        
        $repository = $this->getRepository();
        
        //$criteria['user'] = $user->getId();
        
        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorGerenciaFirst',
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

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','complejo'));
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $formatData = $request->get('_formatData','default');

            $view->setData($resources->toArray('',array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    public function showAction(Request $request) {
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('show.html'))
            ->setTemplateVar($this->config->getResourceName())
            ->setData($this->findOr404($request))
        ;
        $groups = array_merge(array('api_list'), $request->get('_groups',array()));
        $view->getSerializationContext()->setGroups($groups);
        return $this->handleView($view);
    }
    
    /**
     * Exportar la matriz de objetivos
     * @param Request $request
     */
    public function exportAction(Request $request)
    {
        $em = $this->getDoctrine();
        $idGerencia = $request->get('id');
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->find($idGerencia);
        
        $sectionOperative = $em->getRepository('PequivenObjetiveBundle:Objetive')->getSectionOperativeByGerencia($gerencia);
        $resource = $this->findOr404($request);
//        $details = $resource->getDetails();
//        $summary = $resource->getSummary();
        
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
        
        $path = $this->get('kernel')->locateResource('@PequivenObjetiveBundle/Resources/skeleton/matriz_de_objetivos.xls');
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
//        $objPHPExcel = new \PHPExcel();
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Matriz de Objetivos')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
                ;
        $objPHPExcel
                ->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->getDefaultRowDimension()->setRowHeight();
        
//        $activeSheet->setTitle($gerencia->getDescription());
        
        $activeSheet->setCellValue('A3', $gerencia->getDescription());
        
        $row = 8;
        $contResult = 1;
        $totalOperative = count($sectionOperative);
        $rowHeight = 70;
        
        //Objetivo Táctico
        $beforeObjTacRef = $sectionOperative[0]['ObjTacRef'];
        $contRepObjTac = 0;
        $contObjTac = 1;
        $rowIniTac = 8;
        $rowFinTac = 8;
        
        //Objetivo Operativo
        $beforeObjOpeRef = $sectionOperative[0]['ObjOpeRef'];
        $contRepObjOpe = 0;
        
        //Indicador Operativo
        $beforeIndOpeRef = $sectionOperative[0]['IndOpeRef'];
        $contRepIndOpe = 0;
        
        foreach($sectionOperative as $result){
            $activeSheet->setCellValue('G'.$row, $result['ObjTacRef'].' '.$result['ObjTac']);
            $activeSheet->setCellValue('H'.$row, $result['ObjTacGoal']);

            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            
            $activeSheet->setCellValue('N'.$row, $result['ObjOpeRef'].' '.$result['ObjOpe']);
            $activeSheet->setCellValue('O'.$row, $result['ObjOpeGerencia']);
            $activeSheet->getStyle('O'.$row)->applyFromArray($styleArray);
            $activeSheet->setCellValue('P'.$row, $result['ObjOpeGoal']);
            $activeSheet->setCellValue('Q'.$row, $result['ObjOpePeso']);
            $activeSheet->setCellValue('R'.$row, $result['IndOpeRef'].' '.$result['IndOpe']);
            $activeSheet->setCellValue('S'.$row, $result['IndOpeFormula']);
            $activeSheet->setCellValue('T'.$row, $result['IndOpeGoal']);
            $activeSheet->setCellValue('U'.$row, $result['IndOpePeso']);
            
            if($contResult > 1){
                
                //Objetivos Tácticos
                if($beforeObjTacRef === $result['ObjTacRef']){
                    $contRepObjTac++;
                    if($contResult === $totalOperative){

                        $activeSheet->mergeCells(sprintf('G%s:G%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('H%s:H%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('M%s:M%s',($row-$contRepObjTac),($row)));

                        //Obtenemos el Objetivo Táctico anterior y seteamos los indicadores en la matriz
                        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $beforeObjTacRef));
                        $indicatorsTactic = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByObjetiveTactic($objetiveTactic);
                        $totalIndicatorsTactic = count($indicatorsTactic);
                        $div = ($contRepObjTac + 1) / $totalIndicatorsTactic;

                        $contIndTactic = 1;
                        foreach($indicatorsTactic as $indicatorTactic){//Recorremos los Indicadores Tácticos para el Objetivo en específico
                            if($contIndTactic === $totalIndicatorsTactic){
                                $rowFinTac = $row;
                            } else{
                                $rowFinTac = $rowIniTac + ($div-1);
                            }
                            $activeSheet->setCellValue('I'.$rowIniTac, $indicatorTactic['IndTacRef'].' '.$indicatorTactic['IndTac']);
                            $activeSheet->setCellValue('J'.$rowIniTac, $indicatorTactic['IndTacFormula']);
                            $activeSheet->setCellValue('K'.$rowIniTac, $indicatorTactic['IndTacGoal']);
                            $activeSheet->setCellValue('L'.$rowIniTac, $indicatorTactic['IndTacPeso']);
                            $activeSheet->mergeCells(sprintf('I%s:I%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('J%s:J%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('K%s:K%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',$rowIniTac,$rowFinTac));
                            $contIndTactic++;
                            $rowIniTac = $rowIniTac + ($div);
                        }
                    }
                } else{

                    //Obtenemos el Objetivo Táctico anterior y seteamos los indicadores en la matriz
                    $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $beforeObjTacRef));
                    $indicatorsTactic = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByObjetiveTactic($objetiveTactic);
                    $totalIndicatorsTactic = count($indicatorsTactic);
                    $div = ($contRepObjTac + 1) / $totalIndicatorsTactic;

                    $contIndTactic = 1;
                    foreach($indicatorsTactic as $indicatorTactic){//Recorremos los Indicadores Tácticos para el Objetivo en específico
                        if($contIndTactic === $totalIndicatorsTactic){
                            $rowFinTac = ($row-1);
                        } else{
                            $rowFinTac = $rowIniTac + ($div-1);
                        }
                        $activeSheet->setCellValue('I'.$rowIniTac, $indicatorTactic['IndTacRef'].' '.$indicatorTactic['IndTac']);
                            $activeSheet->setCellValue('J'.$rowIniTac, $indicatorTactic['IndTacFormula']);
                            $activeSheet->setCellValue('K'.$rowIniTac, $indicatorTactic['IndTacGoal']);
                            $activeSheet->setCellValue('L'.$rowIniTac, $indicatorTactic['IndTacPeso']);
                            $activeSheet->mergeCells(sprintf('I%s:I%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('J%s:J%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('K%s:K%s',$rowIniTac,$rowFinTac));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',$rowIniTac,$rowFinTac));
                        $contIndTactic++;
                        $rowIniTac = $rowIniTac + ($div);
                    }
                    
                    if($contRepObjTac > 0){
                        $activeSheet->mergeCells(sprintf('G%s:G%s',($row-$contRepObjTac -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('H%s:H%s',($row-$contRepObjTac -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('M%s:M%s',($row-$contRepObjTac -1),($row-1)));
                        $contRepObjTac = 0;
                    }
                    $contObjTac++;
                }
                
                $beforeObjTacRef = $result['ObjTacRef'];
                
                //Objetivos Operativos
                if($beforeObjOpeRef === $result['ObjOpeRef']){
                    $contRepObjOpe++;
                    if($contResult === $totalOperative){
                        $activeSheet->mergeCells(sprintf('N%s:N%s',($row-$contRepObjOpe),($row)));
                        $activeSheet->mergeCells(sprintf('O%s:O%s',($row-$contRepObjOpe),($row)));
                        $activeSheet->mergeCells(sprintf('P%s:P%s',($row-$contRepObjOpe),($row)));
                        $activeSheet->mergeCells(sprintf('Q%s:Q%s',($row-$contRepObjOpe),($row)));
                        $activeSheet->mergeCells(sprintf('V%s:V%s',($row-$contRepObjOpe),($row)));
                    }
                } else{
                    if($contRepObjOpe > 0){
                        $activeSheet->mergeCells(sprintf('N%s:N%s',($row-$contRepObjOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('O%s:O%s',($row-$contRepObjOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('P%s:P%s',($row-$contRepObjOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('Q%s:Q%s',($row-$contRepObjOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('V%s:V%s',($row-$contRepObjOpe -1),($row-1)));
                        $contRepObjOpe = 0;
                    }
                }
                $beforeObjOpeRef = $result['ObjOpeRef'];
                
                //Indicadores Operativos
                if($beforeIndOpeRef === $result['IndOpeRef']){
                    $contRepIndOpe++;
                    if($contResult === $totalOperative){
                        $activeSheet->mergeCells(sprintf('R%s:R%s',($row-$contRepIndOpe),($row)));
                        $activeSheet->mergeCells(sprintf('S%s:S%s',($row-$contRepIndOpe),($row)));
                        $activeSheet->mergeCells(sprintf('T%s:T%s',($row-$contRepIndOpe),($row)));
                        $activeSheet->mergeCells(sprintf('U%s:U%s',($row-$contRepIndOpe),($row)));
                    }
                } else{
                    if($contRepIndOpe > 0){
                        $activeSheet->mergeCells(sprintf('R%s:R%s',($row-$contRepIndOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('S%s:S%s',($row-$contRepIndOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('T%s:T%s',($row-$contRepIndOpe -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('U%s:U%s',($row-$contRepIndOpe -1),($row-1)));
                        $contRepIndOpe = 0;
                    }
                }
                $beforeIndOpeRef = $result['IndOpeRef'];
            }
            
            $activeSheet->getRowDimension($row)->setRowHeight($rowHeight);
            $activeSheet->getStyle(sprintf('A%s:V%s',$row,$row))->applyFromArray($styleArrayBordersContent);
            $row++;
            $contResult++;
        }
//        die();
        
//        $activeSheet->getProtection()
//                    ->setSheet(true)
//                    ->setPassword('531P-P1A-2014')
//                ;
        
        $fileName = sprintf('SEIP-Matriz de Objetivos-%s-%s.xls',$gerencia->getDescription(),$now->format('Ymd-His'));
        
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
