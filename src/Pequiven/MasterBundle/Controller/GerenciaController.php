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
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
        
        if($user->getGerenciaSecond()->getId() == 50){
            $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($this->findOr404($request))
            ;
            $groups = array_merge(array('api_list'), $request->get('_groups',array()));
            $view->getSerializationContext()->setGroups($groups);
            return $this->handleView($view);
        } else{
            return 'false';
        }
    }
    
    public function updateAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);

        if (($request->isMethod('PUT') || $request->isMethod('POST'))) {
            $form->submit($request,true);
            if($form->isValid()){
                $this->domainManager->update($resource);

                return $this->redirectHandler->redirectTo($resource);
            }
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('update.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView()
            ))
        ;
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
        $gerencia = $em->getRepository('PequivenMasterBundle:Gerencia')->find($idGerencia);//Obtenemos la gerencia
        
        //Obtenemos la sección operativa de la matriz de objetivos
        $sectionOperative = $em->getRepository('PequivenObjetiveBundle:Objetive')->getSectionOperativeByGerencia($gerencia);
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
        
        $row = 8;//Fila Inicial del skeleton
        $contResult = 1;//Contador de resultados totales
        $totalOperative = count($sectionOperative);//Total de registros
        $rowHeight = 70;//Alto de la fila
        
        //Objetivo Táctico
        $beforeObjTacRef = $totalOperative > 0 ? $sectionOperative[0]['ObjTacRef'] : '';//Referencia de la fila pasada
        $contRepObjTac = 0;//Contador que cuenta los objetivos tácticos repetidos
        $contObjTac = 1;//Contador que cuenta el número de objetivos tácticos
        $rowIniTac = 8;//Fila inicial para hacer mergecell en el nivel táctico
        $rowFinTac = 8;//Fila final para hacer mergecell en el nivel táctico
        
        //Objetivo Operativo
        $beforeObjOpeRef = $totalOperative > 0 ? $sectionOperative[0]['ObjOpeRef'] : '';
        $contRepObjOpe = 0;//Contador que cuenta los objetivos operativos repetidos
        
        //Indicador Operativo
        $beforeIndOpeRef = $totalOperative > 0 ? $sectionOperative[0]['IndOpeRef'] : '';
        $contRepIndOpe = 0;//Contador que cuenta los indicadores operativos repetidos
        
        //Recorremos los resultados obtenidos del nivel operativo
        foreach($sectionOperative as $result){
            $activeSheet->setCellValue('G'.$row, $result['ObjTacRef'].' '.$result['ObjTac']);
            $activeSheet->setCellValue('H'.$row, $result['ObjTacGoal']);
            //Seteamos los programas de gestión a nivel táctico
            $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $result['ObjTacRef']));
            $arrangementProgramsTactic = $objetiveTactic->getArrangementPrograms();
            $totalArrangementProgramsTactic = count($arrangementProgramsTactic);
            $textArrangementProgramsTactic = '';
            if($totalArrangementProgramsTactic > 0){
                foreach($arrangementProgramsTactic as $arrangementProgram){
                    $textArrangementProgramsTactic.= $arrangementProgram->getRef() . "\n";
                }
            } else{
                $textArrangementProgramsTactic = 'No cargado';
            }
            $activeSheet->setCellValue('M'.$row, $textArrangementProgramsTactic);
            
            $activeSheet->setCellValue('N'.$row, $result['ObjOpeRef'].' '.$result['ObjOpe']);
            $activeSheet->setCellValue('O'.$row, $result['ObjOpeGerencia']);
            $activeSheet->getStyle('O'.$row)->applyFromArray($styleArray);
            $activeSheet->setCellValue('P'.$row, $result['ObjOpeGoal']);
            $activeSheet->setCellValue('Q'.$row, $result['ObjOpePeso']);
            $textIndOpe = empty($result['IndOpeRef']) ? 'No Aplica' : $result['IndOpeRef'].' '.$result['IndOpe'];
            $textIndOpeFormula = empty($result['IndOpeRef']) ? 'No Aplica' : $result['IndOpeFormula'];
            $textIndOpePeso = empty($result['IndOpeRef']) ? 'No Aplica' : $result['IndOpePeso'];
            $activeSheet->setCellValue('R'.$row, $textIndOpe);
            $activeSheet->setCellValue('S'.$row, $textIndOpeFormula);
//            $activeSheet->setCellValue('T'.$row, $result['IndOpeGoal']);
            $activeSheet->setCellValue('U'.$row, $textIndOpePeso);
            //Seteamos los programas de gestión a nivel operativo
            $objetiveOperative = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $result['ObjOpeRef']));
            $arrangementProgramsOperative = $objetiveOperative->getArrangementPrograms();
            $totalArrangementProgramsOperative = count($arrangementProgramsOperative);
            $textArrangementProgramsOperative = '';
            if($totalArrangementProgramsOperative > 0){
                foreach($arrangementProgramsOperative as $arrangementProgram){
                    $textArrangementProgramsOperative.= $arrangementProgram->getRef() . "\n";
                }
            } else{
                $textArrangementProgramsOperative = 'No Cargado';
            }
            $activeSheet->setCellValue('V'.$row, $textArrangementProgramsOperative);
            
            if($contResult > 1){
                
                //Objetivos Tácticos
                if($beforeObjTacRef === $result['ObjTacRef']){//Si cambia el objetivo táctico
                    $contRepObjTac++;
                    if($contResult === $totalOperative){

                        $activeSheet->mergeCells(sprintf('A%s:A%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('B%s:B%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('G%s:G%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('H%s:H%s',($row-$contRepObjTac),($row)));
                        $activeSheet->mergeCells(sprintf('M%s:M%s',($row-$contRepObjTac),($row)));

                        //Obtenemos el Objetivo Táctico anterior y seteamos los indicadores en la matriz
                        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $beforeObjTacRef));
                        $indicatorsTactic = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByObjetiveTactic($objetiveTactic);
                        $objetivesStrategics = $em->getRepository('PequivenObjetiveBundle:Objetive')->getSectionStrategic($objetiveTactic);
                        
                        $totalStrategics = count($objetivesStrategics);
                        $beforeLineStraRef = $objetivesStrategics[0]['LineStraRef'];
                        $contObjStra = 1;
                        $textObjStra = '';
                        $textLineStrategic = '';
                        //Consultamos si el objetivo táctico tiene más de un estratégico padre
                        foreach($objetivesStrategics as $objetiveStrategic){
                            if($totalStrategics > 1){
                                $textObjStra.= $objetiveStrategic['ObjStraRef'].' '.$objetiveStrategic['ObjStra']."\n";
                                if($contObjStra == 1){
                                    $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra']."\n";
                                } else{
                                    if($beforeLineStraRef === $objetiveStrategic['LineStraRef']){
                                    } else{
                                        $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra']."\n";
                                    }
                                    $beforeLineStraRef = $objetiveStrategic['LineStraRef'];
                                }
                            } else{
                                $textObjStra.= $objetiveStrategic['ObjStraRef'].' '.$objetiveStrategic['ObjStra'];
                                $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra'];
                            }
                        }

                        $activeSheet->setCellValue('A'.($row-$contRepObjTac), $textLineStrategic);
                        $activeSheet->setCellValue('B'.($row-$contRepObjTac), $textObjStra);

                        //Sección Indicadores Tácticos
                        $totalIndicatorsTactic = count($indicatorsTactic);
                        if($totalIndicatorsTactic > 0){
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
//                                $activeSheet->setCellValue('K'.$rowIniTac, $indicatorTactic['IndTacGoal']);
                                $activeSheet->setCellValue('L'.$rowIniTac, $indicatorTactic['IndTacPeso']);
                                $activeSheet->mergeCells(sprintf('I%s:I%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('J%s:J%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('K%s:K%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('L%s:L%s',$rowIniTac,$rowFinTac));
                                $contIndTactic++;
                                $rowIniTac = $rowIniTac + ($div);
                            }
                        } else{
                            if($contRepObjTac > 0){
                                $activeSheet->setCellValue('I'.($row-$contRepObjTac), 'No Aplica');
                                $activeSheet->setCellValue('J'.($row-$contRepObjTac), 'No Aplica');
                                $activeSheet->setCellValue('K'.($row-$contRepObjTac), 'No Aplica');
                                $activeSheet->setCellValue('L'.($row-$contRepObjTac), 'No Aplica');
                                $activeSheet->mergeCells(sprintf('I%s:I%s',($row-$contRepObjTac),($row)));
                                $activeSheet->mergeCells(sprintf('J%s:J%s',($row-$contRepObjTac),($row)));
                                $activeSheet->mergeCells(sprintf('K%s:K%s',($row-$contRepObjTac),($row)));
                                $activeSheet->mergeCells(sprintf('L%s:L%s',($row-$contRepObjTac),($row)));
                            }
                        }
                    }
                } else{
                    //Obtenemos el Objetivo Táctico anterior y seteamos los indicadores en la matriz
                    $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $beforeObjTacRef));
                    $indicatorsTactic = $em->getRepository('PequivenIndicatorBundle:Indicator')->getByObjetiveTactic($objetiveTactic);
                    $objetivesStrategics = $em->getRepository('PequivenObjetiveBundle:Objetive')->getSectionStrategic($objetiveTactic);
                    
                    $totalStrategics = count($objetivesStrategics);
                    $beforeLineStraRef = $objetivesStrategics[0]['LineStraRef'];
                    $contObjStra = 1;
                    $textObjStra = '';
                    $textLineStrategic = '';
                    //Consultamos si el objetivo táctico tiene más de un estratégico padre
                    foreach($objetivesStrategics as $objetiveStrategic){
                        if($totalStrategics > 1){
                            $textObjStra.= $objetiveStrategic['ObjStraRef'].' '.$objetiveStrategic['ObjStra']."\n";
                            if($contObjStra == 1){
                                $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra']."\n";
                            } else{
                                if($beforeLineStraRef === $objetiveStrategic['LineStraRef']){
                                } else{
                                    $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra']."\n";
                                }
                                $beforeLineStraRef = $objetiveStrategic['LineStraRef'];
                            }
                        } else{
                            $textObjStra.= $objetiveStrategic['ObjStraRef'].' '.$objetiveStrategic['ObjStra'];
                            $textLineStrategic.= $objetiveStrategic['LineStraRef'].' '.$objetiveStrategic['LineStra'];
                        }
                    }
                    
                    $activeSheet->setCellValue('A'.($row-$contRepObjTac-1), $textLineStrategic);
                    $activeSheet->setCellValue('B'.($row-$contRepObjTac-1), $textObjStra);
                    
                    //Sección Indicadores Tácticos
                    $totalIndicatorsTactic = count($indicatorsTactic);
                    if($totalIndicatorsTactic > 0){
                    
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
//                                $activeSheet->setCellValue('K'.$rowIniTac, $indicatorTactic['IndTacGoal']);
                                $activeSheet->setCellValue('L'.$rowIniTac, $indicatorTactic['IndTacPeso']);
                                $activeSheet->mergeCells(sprintf('I%s:I%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('J%s:J%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('K%s:K%s',$rowIniTac,$rowFinTac));
                                $activeSheet->mergeCells(sprintf('L%s:L%s',$rowIniTac,$rowFinTac));
                            $contIndTactic++;
                            $rowIniTac = $rowIniTac + ($div);
                        }
                    } else{
                        if($contRepObjTac > 0){
                            $activeSheet->setCellValue('I'.($row-$contRepObjTac-1), 'No Aplica');
                            $activeSheet->setCellValue('J'.($row-$contRepObjTac-1), 'No Aplica');
                            $activeSheet->setCellValue('K'.($row-$contRepObjTac-1), 'No Aplica');
                            $activeSheet->setCellValue('L'.($row-$contRepObjTac-1), 'No Aplica');
                            $activeSheet->mergeCells(sprintf('I%s:I%s',($row-$contRepObjTac -1),($row-1)));
                            $activeSheet->mergeCells(sprintf('J%s:J%s',($row-$contRepObjTac -1),($row-1)));
                            $activeSheet->mergeCells(sprintf('K%s:K%s',($row-$contRepObjTac -1),($row-1)));
                            $activeSheet->mergeCells(sprintf('L%s:L%s',($row-$contRepObjTac -1),($row-1)));
                        }
                    }
                    if($contRepObjTac > 0){
                        $activeSheet->mergeCells(sprintf('A%s:A%s',($row-$contRepObjTac -1),($row-1)));
                        $activeSheet->mergeCells(sprintf('B%s:B%s',($row-$contRepObjTac -1),($row-1)));
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
