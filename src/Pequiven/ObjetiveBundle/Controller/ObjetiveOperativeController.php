<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\ObjetiveBundle\Form\Type\Operative\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;

/**
 * Description of ObjetiveOperativeController
 *
 * @author matias
 */
class ObjetiveOperativeController extends baseController 
{
    /**
     * Función que retorna la vista con la lista de los objetivos operativos
     * @Template("PequivenObjetiveBundle:Operative:list.html.twig")
     * @return type
     */
    public function listAction() 
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_OPERATIVE');
        return array(
        );
    }
    
    /**
     * Finds and displays a Objetive entity of level Operative by Id.
     *
     */
    public function showAction(Request $request)
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_OBJECTIVE_VIEW_OPERATIVE','ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_OPERATIVE','ROLE_SEIP_SIG_OBJECTIVE_VIEW_OPERATIVE'));
        $resource = $this->findOr404($request);
        
        if(!$securityService->isGranted('ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_OPERATIVE')){
            if(!$securityService->isGranted('ROLE_SEIP_SIG_OBJECTIVE_VIEW_OPERATIVE')){
                $securityService->checkSecurity('ROLE_SEIP_OBJECTIVE_VIEW_OPERATIVE',$resource);
            } else{
                $securityService->checkSecurity('ROLE_SEIP_SIG_OBJECTIVE_VIEW_OPERATIVE',$resource);
            }
        }
        $indicatorService = $this->getIndicatorService();
        
        //TODO: Colocar la validación de si el objetivo táctico está aprobado
        $hasPermissionToApproved = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_APPROVED_OPERATIVE",$resource);
        $hasPermissionToUpdate = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_EDIT_OPERATIVE",$resource);
        $isAllowToDelete = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_DELETE_OPERATIVE",$resource);
        
        $view = $this
            ->view()
            ->setTemplate('PequivenObjetiveBundle:Operative:show.html.twig')
            ->setTemplateVar('entity')
            ->setData(array(
                'entity' => $resource,
                'indicatorService' => $indicatorService,
                'hasPermissionToUpdate' => $hasPermissionToUpdate,
                'hasPermissionToApproved' => $hasPermissionToApproved,
                'isAllowToDelete' => $isAllowToDelete,
            ))
        ;
        $groups = array_merge(array('id','api_list','gerencia','gerenciaSecond'), $request->get('_groups',array()));
        $view->getSerializationContext()->setGroups($groups);
        return $this->handleView($view);
    }

    /**
     * Función que devuelve el paginador con los objetivos operativos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function objetiveListAction(Request $request) 
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_OPERATIVE');
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_OPERATIVO;
        $criteria['gerencia'] = $request->get('gerencia');

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorOperative', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','indicators','formula','gerenciaSecond'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * Función que devuelve el paginador con los objetivos operativos vinculantes a un complejo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function objetiveVinculantListAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_OPERATIVO;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorOperativeVinculant', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('viewObjetiveVinculant.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list','indicators','formula','gerenciaSecond'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Función que registra un objetivo operativo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Operative:register.html.twig")
     * @return type
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createAction(Request $request) 
    {
        $this->getPeriodService()->checkIsOpen();
        
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_CREATE_OPERATIVE');
        
        $form = $this->createForm($this->get('pequiven_objetive.operative.registration.form.type'));

        $nameObject = 'object';

        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();

        $em->getConnection()->beginTransaction();
        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_objetive_operative_registration");

            $ref = $data['ref'];
            $data['tendency'] = (int)$data['tendency'];
            $object->setWeight(bcadd(str_replace(',', '.', $data['weight']), '0', 3));
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']), '0', 3));

            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_OPERATIVO));
            $object->setObjetiveLevel($objetiveLevel);

            $securityContext = $this->container->get('security.context');
            $object->setUserCreatedAt($user);
            $object->setPeriod($this->getPeriodService()->getPeriodActive());
            $period = $this->getPeriodService()->getPeriodActive();

            //Si el usuario tiene rol directivo
            if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if (!isset($data['check_gerencia'])) {
                    $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($data['gerenciaSecond'])));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if(isset($data['indicators'])){
                        $respIndicator = $this->createIndicator($data,array('totalGerencia' => count($data['gerenciaSecond'])), $totalRef);
                    }
                    for ($i = 0; $i < count($data['gerenciaSecond']); $i++) {
                        ${$nameObject . $i} = clone $object;
                        ${$nameObject . $i}->resetIndicators();
                        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $data['gerencia']));
                        $gerenciaSecond = $this->get('pequiven.repository.gerenciasecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerencia->getComplejo();
                        ${$nameObject . $i}->setGerencia($gerencia);
                        ${$nameObject . $i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject . $i}->setComplejo($complejo);
                        ${$nameObject . $i}->setRef($totalRef[$i]);
                        ${$nameObject . $i}->setPeriod($period);
                        if (isset($data['indicators'])) {
                            foreach ($data['indicators'] as $value) {
                                $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject . $i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject . $i});
                    }
                } else {//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    //Obtenemos las gerencias de 1ra línea seleccionadas
                    $gerencias = $this->get('pequiven.repository.gerenciafirst')->findBy(array('id' => $data['gerencia']));

                    foreach ($gerencias as $gerencia) {
                        $gerenciasSecond = $this->get('pequiven.repository.gerenciasecond')->findBy(array('gerencia' => $gerencia->getId()));
                        $complejo = $gerencia->getComplejo();
                        $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($gerenciasSecond)));
                        if($totalRef[0] != $data['ref']){
                            $this->updateIndicatorRef($data, $totalRef);
                        }
                        if(isset($data['indicators'])){
                            $respIndicator = $this->createIndicator($data,count($gerenciasSecond), $totalRef);
                        }
                        foreach ($gerenciasSecond as $gerenciaSecond) {
                            ${$nameObject . $j} = clone $object;
                            ${$nameObject . $j}->resetIndicators();
                            ${$nameObject . $j}->setGerencia($gerencia);
                            ${$nameObject . $j}->setGerenciaSecond($gerenciaSecond);
                            ${$nameObject . $j}->setComplejo($complejo);
                            ${$nameObject . $j}->setRef($totalRef[$j]);
                            ${$nameObject . $j}->setPeriod($period);
                            if (isset($data['indicators'])) {
                                foreach ($data['indicators'] as $value) {
                                    $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                    $indicator->setTmp(false);
                                    $em->persist(false);
                                    ${$nameObject . $j}->addIndicator($indicator);
                                }
                            }
                            $em->persist(${$nameObject . $j});
                            $j++;
                        }
                    }
                }
                //Si el usuario tiene rol Gerente General Complejo
            } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX'))) {
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if (!isset($data['check_gerencia'])) {
                    $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($data['gerenciaSecond'])));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if(isset($data['indicators'])){
                        $respIndicator = $this->createIndicator($data,array('totalGerencia' => count($data['gerenciaSecond'])), $totalRef);
                    }
                    $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $user->getGerencia()->getId()));
                    for ($i = 0; $i < count($data['gerenciaSecond']); $i++) {
                        ${$nameObject . $i} = clone $object;
                        ${$nameObject . $i}->resetIndicators();
                        $gerenciaSecond = $this->get('pequiven.repository.gerenciasecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        $complejo = $gerencia->getComplejo();
                        ${$nameObject . $i}->setGerencia($gerencia);
                        ${$nameObject . $i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject . $i}->setComplejo($complejo);
                        ${$nameObject . $i}->setRef($totalRef[$i]);
                        ${$nameObject . $i}->setPeriod($period);
                        if (isset($data['indicators'])) {
                            foreach ($data['indicators'] as $value) {
                                $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject . $i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject . $i});
                    }
                } else {//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $this->get('pequiven.repository.gerenciasecond')->findBy(array('complejo' => $user->getComplejo()->getId(), 'modular' => true));
                    $gerencia = $this->get('pequiven.repository.gerenciafirst')->findBy(array('id' => $user->getGerencia()->getId()));
                    $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($gerenciasSecond)));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if(isset($data['indicators'])){
                        $respIndicator = $this->createIndicator($data,count($gerenciasSecond), $totalRef);
                    }
                    foreach ($gerenciasSecond as $gerenciaSecond) {
                        ${$nameObject . $j} = clone $object;
                        ${$nameObject . $j}->resetIndicators();
                        $complejo = $gerencia->getComplejo();
                        ${$nameObject . $j}->setGerencia($gerencia);
                        ${$nameObject . $j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject . $j}->setComplejo($complejo);
                        ${$nameObject . $j}->setRef($totalRef[$j]);
                        ${$nameObject . $j}->setPeriod($period);
                        if (isset($data['indicators'])) {
                            foreach ($data['indicators'] as $value) {
                                $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject . $j}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject . $j});
                        $j++;
                    }
                }
            } elseif ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
                //En caso de que las gerencias de 2da línea a impactar por el objetivo sean seleccionadas en el select
                if (!isset($data['check_gerencia'])) {
                    $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($data['gerenciaSecond'])));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if(isset($data['indicators'])){
                        $respIndicator = $this->createIndicator($data,array('totalGerencia' => count($data['gerenciaSecond'])), $totalRef);
                    }
                    $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $user->getGerencia()->getId()));
                    $complejo = $gerencia->getComplejo();
                    for ($i = 0; $i < count($data['gerenciaSecond']); $i++) {
                        ${$nameObject . $i} = clone $object;
                        ${$nameObject . $i}->resetIndicators();
                        $gerenciaSecond = $this->get('pequiven.repository.gerenciasecond')->findOneBy(array('id' => $data['gerenciaSecond'][$i]));
                        ${$nameObject . $i}->setGerencia($gerencia);
                        ${$nameObject . $i}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject . $i}->setComplejo($complejo);
                        ${$nameObject . $i}->setRef($totalRef[$i]);
                        ${$nameObject . $i}->setPeriod($period);
                        if (isset($data['indicators'])) {
                            foreach ($data['indicators'] as $value) {
                                $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject . $i}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject . $i});
                    }
                } else {//En caso de que las gerencias de 2da línea a impactar, sean todas la de las gerencias de 1ra línea seleccionadas
                    $j = 0;
                    $gerenciasSecond = $this->get('pequiven.repository.gerenciasecond')->findBy(array('gerencia' => $user->getGerencia()->getId()));
                    $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $user->getGerencia()->getId()));
                    $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => count($gerenciasSecond)));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if(isset($data['indicators'])){
                        $respIndicator = $this->createIndicator($data,count($gerenciasSecond), $totalRef);
                    }
                    foreach ($gerenciasSecond as $gerenciaSecond) {
                        ${$nameObject . $j} = clone $object;
                        ${$nameObject . $j}->resetIndicators();
                        $complejo = $gerencia->getComplejo();
                        ${$nameObject . $j}->setGerencia($gerencia);
                        ${$nameObject . $j}->setGerenciaSecond($gerenciaSecond);
                        ${$nameObject . $j}->setComplejo($complejo);
                        ${$nameObject . $j}->setRef($totalRef[$j]);
                        ${$nameObject . $j}->setPeriod($period);
                        if (isset($data['indicators'])) {
                            foreach ($data['indicators'] as $value) {
                                $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                                $indicator->setTmp(false);
                                $em->persist($indicator);
                                ${$nameObject . $j}->addIndicator($indicator);
                            }
                        }
                        $em->persist(${$nameObject . $j});
                        $j++;
                    }
                }
            } elseif ($securityContext->isGranted(array('ROLE_MANAGER_SECOND', 'ROLE_MANAGER_SECOND_AUX'))) {
                $object->setGerenciaSecond($user->getGerenciaSecond());
                $object->setGerencia($user->getGerencia());
                $object->setComplejo($user->getComplejo());
                $object->setPeriod($period);
                $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => 1));
                if($totalRef[0] != $data['ref']){
                    $this->updateIndicatorRef($data, $totalRef);
                }
                $object->setRef($totalRef[0]);
                if (isset($data['indicators'])) {
                    foreach ($data['indicators'] as $value) {
                        $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                        $indicator->setTmp(false);
                        $em->persist($indicator);
                        $object->addIndicator($indicator);
                    }
                }
                $em->persist($object);
            } else {
                $totalRef = $this->setRef(array('objetiveTactics' => $data['parents'], 'totalGerencias' => 1));
                if($totalRef[0] != $data['ref']){
                    $this->updateIndicatorRef($data, $totalRef);
                }
                $object->setRef($totalRef[0]);
                $object->setPeriod($period);
                if (isset($data['indicators'])) {
                    foreach ($data['indicators'] as $value) {
                        $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                        $indicator->setTmp(false);
                        $em->persist($indicator);
                        $object->addIndicator($indicator);
                    }
                }
                $em->persist($object);
            }

            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                throw $e;
            }

            //Obtenemos el o los últimos objetivos guardados y le añadimos el rango de gestión o semáforo
            foreach($totalRef as $value){
                $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $value, 'period' => $period->getId()));
                foreach($objetives as $objetive){
                    $this->addObjetiveParents($objetive,$data['parents']);
                    $this->createArrangementRange($objetive, $data);
                }
            }
            
            if($securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                if(isset($data['indicators'])){
                    $this->removeIndicators($totalRef);
                    $this->addIndicators($totalRef);
                    $this->addIndicatorArrangementRange($totalRef);
                }
            }

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.registerObjetiveOperativeSuccessfull', array(), 'PequivenObjetiveBundle'));

            return $this->redirect($this->generateUrl('pequiven_objetive_menu_list_operative', array(
                                    )
            ));
        }

        return array(
            'form' => $form->createView(),
            'role_name' => $role[0]
        );
    }
    
    /**
     * Función que guarda en la tabla intermedia el(los) objetivo(s) creado(s) junto con el objetivo padre
     * @param Objetive $objetive
     * @param type $parents
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function addObjetiveParents(Objetive $objetive, $parents = array()) {
        
        $em = $this->getDoctrine()->getManager();
        $period = $this->getPeriodService()->getPeriodActive();
        
        $objetivesTactics = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('id' => $parents,'period' => $period));
        
        $totalObjetivesTactics = count($objetivesTactics);
        $em->getConnection()->beginTransaction();
        if ($totalObjetivesTactics > 0) {
            foreach ($objetivesTactics as $objetiveTactic) {
                $objetiveTactic->addChildren($objetive);
                $em->persist($objetiveTactic);
            }
        }

        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }
    
    /**
     * Función que remueve los indicadores asociados a los objetivos de más
     * @param type $totalRef
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function removeIndicators($totalRef = array()){

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
            
        //$objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => '1.3.10.'));
        //$indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => '1.3.9.'));
        $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $totalRef[0]));
        $j = 1;
        foreach($totalRef as $refObjetive){//Recorremos todas las referencias de los objetivos creados
            if($j>1){//En caso de que sea la referencia de los objetivos creados menos el primero
                $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $refObjetive));
                foreach($indicators as $indicator){
                    $objetive->removeIndicator($indicator);
                    $em->persist($objetive);
                }
            }
            $j++;
        }
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        
        return true;
    }
    
    /**
     * Función que agrega los indicadores reales a cada objetivo creado de más
     * @param type $totalRef
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function addIndicators($totalRef = array()){
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $j = 1;
        foreach($totalRef as $refObjetive){//Recorremos todas las referencias de los objetivos creados
            if($j>1){//En caso de que sea la referencia de los objetivos creados menos el primero
                $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refObjetive));
                $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $refObjetive));
                foreach($indicators as $indicator){
                    $objetive->addIndicator($indicator);
                    $em->persist($objetive);
                }
            }
            $j++;
        }
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        
        return true;
    }
    
    /**
     * Función que sirve para crear los rango para los Indicadores Operativos creados de más
     * @param type $totalRef
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function addIndicatorArrangementRange($totalRef){
        $nameObject = 'object';
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        //Obtenemos los Indicatores Operativos creados originalmente desde el formulario de Objetivos Operativos
        $indicatorsOriginals = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $totalRef[0]));
        $arrangementRangeOriginals = array();
        $k = 0;
        foreach($indicatorsOriginals as $indicatorOriginal){//Recorremos los Indicadores Operativos creados originalmente desde el formulario de Objetivos Operativos
            //Obtenemos los Rangos de Gestión de los Indicadores Operativos creados originalmente
            $arrangementRangeOriginals[$k] = $em->getRepository('PequivenArrangementBundle:ArrangementRange')->findOneBy(array('indicator' => $indicatorOriginal));
            $k++;
        }
        
        $j = 1;
        $i = 0;
        $periodActive = $this->getPeriodService()->getPeriodActive();
        
        foreach($totalRef as $refObjetive){//Recorremos todas las referencias de los objetivos creados
            if($j>1){//En caso de que sea la referencia de los objetivos creados menos el primero
                $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refObjetive));
                $p = 0;
                foreach($indicators as $indicator){
                    ${$nameObject . $i} = new ArrangementRange();
                    ${$nameObject . $i}->setIndicator($indicator);
                    ${$nameObject . $i}->setTypeRangeTop($arrangementRangeOriginals[$p]->getTypeRangeTop());
                    ${$nameObject . $i}->setTypeRangeMiddleTop($arrangementRangeOriginals[$p]->getTypeRangeMiddleTop());
                    ${$nameObject . $i}->setTypeRangeMiddleBottom($arrangementRangeOriginals[$p]->getTypeRangeMiddleBottom());
                    ${$nameObject . $i}->setTypeRangeBottom($arrangementRangeOriginals[$p]->getTypeRangeBottom());
                    ${$nameObject . $i}->setRankTopBasic($arrangementRangeOriginals[$p]->getRankTopBasic());
                    ${$nameObject . $i}->setRankTopMixedTop($arrangementRangeOriginals[$p]->getRankTopMixedTop());
                    ${$nameObject . $i}->setRankTopMixedBottom($arrangementRangeOriginals[$p]->getRankTopMixedBottom());
                    ${$nameObject . $i}->setRankMiddleTopBasic($arrangementRangeOriginals[$p]->getRankMiddleTopBasic());
                    ${$nameObject . $i}->setRankMiddleTopMixedTop($arrangementRangeOriginals[$p]->getRankMiddleTopMixedTop());
                    ${$nameObject . $i}->setRankMiddleTopMixedBottom($arrangementRangeOriginals[$p]->getRankMiddleTopMixedBottom());
                    ${$nameObject . $i}->setRankMiddleBottomBasic($arrangementRangeOriginals[$p]->getRankMiddleBottomBasic());
                    ${$nameObject . $i}->setRankMiddleBottomMixedTop($arrangementRangeOriginals[$p]->getRankMiddleBottomMixedTop());
                    ${$nameObject . $i}->setRankMiddleBottomMixedBottom($arrangementRangeOriginals[$p]->getRankMiddleBottomMixedBottom());
                    ${$nameObject . $i}->setRankBottomBasic($arrangementRangeOriginals[$p]->getRankBottomBasic());
                    ${$nameObject . $i}->setRankBottomMixedTop($arrangementRangeOriginals[$p]->getRankBottomMixedTop());
                    ${$nameObject . $i}->setRankBottomMixedBottom($arrangementRangeOriginals[$p]->getRankBottomMixedBottom());
                    ${$nameObject . $i}->setOpRankTopBasic($arrangementRangeOriginals[$p]->getOpRankTopBasic());
                    ${$nameObject . $i}->setOpRankTopMixedTop($arrangementRangeOriginals[$p]->getOpRankTopMixedTop());
                    ${$nameObject . $i}->setOpRankTopMixedBottom($arrangementRangeOriginals[$p]->getOpRankTopMixedBottom());
                    ${$nameObject . $i}->setOprankMiddleTopBasic($arrangementRangeOriginals[$p]->getOprankMiddleTopBasic());
                    ${$nameObject . $i}->setOpRankMiddleTopMixedTop($arrangementRangeOriginals[$p]->getOpRankMiddleTopMixedTop());
                    ${$nameObject . $i}->setOpRankMiddleTopMixedBottom($arrangementRangeOriginals[$p]->getOpRankMiddleTopMixedBottom());
                    ${$nameObject . $i}->setOprankMiddleBottomBasic($arrangementRangeOriginals[$p]->getOprankMiddleBottomBasic());
                    ${$nameObject . $i}->setOpRankMiddleBottomMixedTop($arrangementRangeOriginals[$p]->getOpRankMiddleBottomMixedTop());
                    ${$nameObject . $i}->setOpRankMiddleBottomMixedBottom($arrangementRangeOriginals[$p]->getOpRankMiddleBottomMixedBottom());
                    ${$nameObject . $i}->setOprankBottomBasic($arrangementRangeOriginals[$p]->getOprankBottomBasic());
                    ${$nameObject . $i}->setOpRankBottomMixedTop($arrangementRangeOriginals[$p]->getOpRankBottomMixedTop());
                    ${$nameObject . $i}->setOpRankBottomMixedBottom($arrangementRangeOriginals[$p]->getOpRankBottomMixedBottom());
                    ${$nameObject . $i}->setPeriod($periodActive);
                    
                    $em->persist(${$nameObject . $i});
                    $i++;
                    $p++;
                }
            }
            $j++;
        }
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        } return true;
    }
    
    /**
     * Función que crea los Indicadores Operativos para los Objetivos Operativos que serán creados de más (cuando se selecciona más de una Gerencia de 1ra Línea)
     * @param type $data
     * @param type $options
     * @param type $totalRef
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createIndicator($data = array(),$options = array(), $totalRef = array()){
        
        $periodService = $this->get('pequiven_seip.service.period');
        $period = $periodService->getPeriodActive();
        $nameObject = 'object';
        $totalGerencias = $options['totalGerencia'];//Total de Gerencias de 1ra Línea que abarca el Objetivo Operativo a crear
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $j = 0;//Contador de Indicadores Operativos asociados al Objetivo Operativo
        for($i = 0; $i < $totalGerencias; $i++){//Recorremos las Gerencias Seleccionada            
            if($i >= 1){//Consultamos en caso de que exista más de una Gerencia de 1ra Línea
                $k = 1;//Contador de Indicadores seleccionados en el Select del Formulario
                foreach ($data['indicators'] as $value) {//Recorremos los Indicadores Operativos ya creados asociados al Objetivo Operativo a crear
                    $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                    ${$nameObject . $j} = new Indicator();
                    ${$nameObject . $j}->setRef('IO-'.$totalRef[$i].$k);
                    ${$nameObject . $j}->setRefParent($totalRef[$i]);
                    ${$nameObject . $j}->setTmp(false);
                    ${$nameObject . $j}->setWeight($indicator->getWeight());
                    ${$nameObject . $j}->setIndicatorLevel($indicator->getIndicatorLevel());
                    ${$nameObject . $j}->setFormula($indicator->getFormula());
                    ${$nameObject . $j}->setTendency($indicator->getTendency());
                    ${$nameObject . $j}->setDescription($indicator->getDescription());
                    ${$nameObject . $j}->setPeriod($period);
                    ${$nameObject . $j}->setUserCreatedAt($user);
                    $em->persist(${$nameObject . $j});
                    $j++;
                    $k++;
                }
            }
        }
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
        
        return true;
    }

    /**
     * Función que guarda en la tabla intermedia el rango de gestión (semáforo) del objetivo creado
     * @param type $objetives
     * @param type $data
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createArrangementRange(Objetive $objetive, $data = array()) {
        $arrangementRange = new ArrangementRange();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
//        $totalObjetives = count($objetives);

        $arrangementRange->setObjetive($objetive);
        $arrangementRange->setPeriod($this->getPeriodService()->getPeriodActive());
        
        //Seteamos los valores de rango alto
        $arrangementRange->setTypeRangeTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeTop'])));
        if ($data['typeArrangementRangeTypeTop'] == 'TOP_BASIC') {
            $arrangementRange->setRankTopBasic(bcadd(str_replace(',', '.', $data['rankTopBasic']), '0', 3));
            $arrangementRange->setOpRankTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopBasic'])));
        } else if ($data['typeArrangementRangeTypeTop'] == 'TOP_MIXED') {
            $arrangementRange->setRankTopMixedTop(bcadd(str_replace(',', '.', $data['rankTopMixedTop']), '0', 3));
            $arrangementRange->setOpRankTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedTop'])));
            $arrangementRange->setRankTopMixedBottom(bcadd(str_replace(',', '.', $data['rankTopMixedBottom']), '0', 3));
            $arrangementRange->setOpRankTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankTopMixedBottom'])));
        }

        //Seteamos los valores de rango medio alto
        $arrangementRange->setTypeRangeMiddleTop($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleTop'])));
        if ($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_BASIC') {
            $arrangementRange->setRankMiddleTopBasic(bcadd(str_replace(',', '.', $data['rankMiddleTopBasic']), '0', 3));
            $arrangementRange->setOpRankMiddleTopBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopBasic'])));
        } else if ($data['typeArrangementRangeTypeMiddleTop'] == 'MIDDLE_TOP_MIXED') {
            $arrangementRange->setRankMiddleTopMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedTop']), '0', 3));
            $arrangementRange->setOpRankMiddleTopMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedTop'])));
            $arrangementRange->setRankMiddleTopMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleTopMixedBottom']), '0', 3));
            $arrangementRange->setOpRankMiddleTopMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleTopMixedBottom'])));
        }

        //Seteamos los valores de rango medio bajo
        $arrangementRange->setTypeRangeMiddleBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeMiddleBottom'])));
        if ($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_BASIC') {
            $arrangementRange->setRankMiddleBottomBasic(bcadd(str_replace(',', '.', $data['rankMiddleBottomBasic']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomBasic'])));
        } else if ($data['typeArrangementRangeTypeMiddleBottom'] == 'MIDDLE_BOTTOM_MIXED') {
            $arrangementRange->setRankMiddleBottomMixedTop(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedTop']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedTop'])));
            $arrangementRange->setRankMiddleBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankMiddleBottomMixedBottom']), '0', 3));
            $arrangementRange->setOpRankMiddleBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankMiddleBottomMixedBottom'])));
        }

        //Seteamos los valores de rango bajo
        $arrangementRange->setTypeRangeBottom($em->getRepository('PequivenMasterBundle:ArrangementRangeType')->findOneBy(array('id' => $data['arrangementRangeTypeBottom'])));
        if ($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_BASIC') {
            $arrangementRange->setRankBottomBasic(bcadd(str_replace(',', '.', $data['rankBottomBasic']), '0', 3));
            $arrangementRange->setOpRankBottomBasic($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBasic'])));
        } else if ($data['typeArrangementRangeTypeBottom'] == 'BOTTOM_MIXED') {
            if($data['tendency'] < 3){//Comportamiento No Estable
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomMixedTop']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedTop'])));
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomMixedBottom']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedBottom'])));
            } else{ //Comportamiento Estable
                //Rango Bajo-Alto
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomTopBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopBasic'])));
                //Rango Bajo-Bajo
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomBottomBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomBasic'])));
            }
        }

//        if ($totalObjetives > 0) {
//            foreach ($objetives as $objetive) {
//                $objectArrangementRange = clone $arrangementRange;
//                $objectArrangementRange->setObjetive($objetive);
//                $em->persist($objectArrangementRange);
//            }
//        }
        
        $em->persist($arrangementRange);
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * Devuelve los Objetivos Estratégicos de acuerdo a la Línea Estratégica seleccionada
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveStrategicFromLineStrategicOperativeAction(Request $request) {
        $response = new JsonResponse();

        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();

        $lineStrategicId = $request->request->get('lineStrategicId');
        $lineStrategicArray = explode(',', $lineStrategicId);

        if (is_array($lineStrategicArray)) {
            $results = $this->get('pequiven.repository.objetiveoperative')->getByLineStrategic($lineStrategicArray);
            $totalResults = count($results);
            if (is_array($results) && $totalResults > 0) {
                foreach ($results as $result) {
                    $objetiveChildrenStrategic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else {
                $objetiveChildrenStrategic[] = array("empty" => true);
            }
        } else {
            $objetiveChildrenStrategic[] = array("empty" => true, "initial" => true);
        }

        $response->setData($objetiveChildrenStrategic);

        return $response;
    }

    /**
     * Devuelve los Objetivos Tácticos de acuerdo al Objetivo Estratégico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveTacticFromObjetiveStrategicAction(Request $request) {
        $response = new JsonResponse();
        $objetiveChildrenTactic = array();

        $objetiveStrategicId = explode(',', $request->request->get('objetiveStrategicId'));

        if (is_array($objetiveStrategicId)) {
            $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetiveStrategicId,array('enabled' => true));

            $totalResults = count($results);
            if (is_array($results) && $totalResults > 0) {
                foreach ($results as $result) {
                    $objetiveChildrenTactic[] = array("id" => $result->getId(), "description" => $result->getRef() . ' ' . $result->getDescription());
                }
            } else {
                $objetiveChildrenTactic[] = array("empty" => true);
            }
        } else {
            $objetiveChildrenTactic[] = array("empty" => true, "initial" => true);
        }

        $response->setData($objetiveChildrenTactic);

        return $response;
    }

    /**
     * Devuelve los Objetivos Estratégicos de acuerdo al Objetivo Táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectObjetiveStrategicFromObjetiveTacticAction(Request $request) {
        $response = new JsonResponse();
        $objetiveStrategicParent = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $objetiveTacticId = $request->request->get('objetiveTacticId');
        $lineStrategicId = $request->request->get('lineStrategicId');
        //Obtenemos el objetivo de acuerdo a la data recibida
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));

        //Obtenemos los objetivos estratégicos de acuerdo a la línea estratégica y el complejo del objetivo táctico
        $objetivesStrategics = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('lineStrategic' => $lineStrategicId, 'complejo' => $objetiveTactic->getComplejo()->getId(), 'objetiveLevel' => ObjetiveLevel::LEVEL_ESTRATEGICO));
        foreach ($objetivesStrategics as $objetiveStrategic) {
            if ($objetiveStrategic->getId() == $objetiveTactic->getParent()->getId()) {
                $objetiveStrategicParent[] = array('id' => $objetiveStrategic->getId(), 'description' => $objetiveStrategic->getRef() . ' ' . $objetiveStrategic->getDescription(), 'selected' => 'YES');
            } else {
                $objetiveStrategicParent[] = array('id' => $objetiveStrategic->getId(), 'description' => $objetiveStrategic->getRef() . ' ' . $objetiveStrategic->getDescription(), 'selected' => 'NO');
            }
        }

        $response->setData($objetiveStrategicParent);

        return $response;
    }

    /**
     * Devuelve los Complejos en los cuales impactará el objetivo a crear de acuerdo al Objetivo Táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectComplejoFromObjetiveTacticAction(Request $request) {
        $response = new JsonResponse();
        $complejoChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $complejoObject = new \Pequiven\MasterBundle\Entity\Complejo();
        $complejoNameArray = $complejoObject->getRefNameArray();

        $objetiveTacticId = $request->request->get('objetiveTacticId');

        //Obtenemos el objetivo táctico para obtener la referencia
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));

        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
            
        }

        //Obtenemos los Objetivos Tácticos que tengan como referencia el obtenido en el paso anterior
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef()));

        $i = 1;
        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            if ($i == 1) {
                $complejoChildren[] = array("id" => $complejo->getId(), "description" => $complejo->getDescription());
            } else {
                if ($objectBefore->getGerencia()->getComplejo()->getId() != $complejo->getId()) {
                    $complejoChildren[] = array("id" => $complejo->getId(), "description" => $complejo->getDescription());
                }
            }
            $objectBefore = clone $result;
            $i++;
        }

        $response->setData($complejoChildren);

        return $response;
    }

    /**
     * Función que devuelve la(s) gerencias de 1ra línea asociada al objetivo seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstFromComplejoAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaFirstChildren = array();
        $em = $this->getDoctrine()->getManager();

        $objetiveTacticId = $request->request->get('objetiveTacticId');
        $complejos = $request->request->get('complejos');
        $complejosArray = explode(',', $complejos);

        //Obtenemos el objetivo para obtener la referencia
        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetiveTacticId));

        //Obtenemos los Objetivos Tácticos que tengan como referencia el obtenido en el paso anterior
        $results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $objetiveTactic->getRef()));

        $i = 1;
        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            foreach ($complejosArray as $value) {
                if ($complejo->getId() == $value) {
                    $gerenciaFirstChildren[] = array(
                        'idComplejo' => $complejo->getId(),
                        'optGroup' => $complejo->getDescription(),
                        'id' => $gerencia->getId(),
                        'description' => $gerencia->getDescription()
                    );
                }
            }
            $i++;
        }

        $response->setData($gerenciaFirstChildren);

        return $response;
    }

    /**
     * Función que devuelve la(s) gerencias de 2da línea asociadaa a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondFromGerenciaFirstAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $gerenciasObjectArray = array();

        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
            $complejos = $request->request->get('complejos');
            $gerencias = $request->request->get('gerencias');
            $gerenciasArray = explode(',', $gerencias);
            $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $gerencias));
        } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
            $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $user->getGerencia()->getId()));
        }
        
        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            $gerenciaSecondChildren[] = array(
                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                'id' => $result->getId(),
                'description' => $result->getDescription()
            );
        }
        

        $response->setData($gerenciaSecondChildren);

        return $response;
    }
    
    /**
     * Función que devuelve la(s) gerencias de 2da línea asociadaa a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $gerenciasObjectArray = array();

        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
            $complejos = $request->request->get('complejos');
            $gerencias = $request->request->get('gerencias');
            $gerenciasArray = explode(',', $gerencias);
            $complejosArray = explode(',', $complejos);
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true));
            $gerenciasObjectArray = $gerenciasArray;
        } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX'))) {
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'complejo' => $user->getComplejo()->getId(), 'modular' => true));
        } elseif ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'gerencia' => $user->getGerencia()->getId()));
        }

//        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
//            foreach ($results as $result) {
//                $complejo = $result->getGerencia()->getComplejo();
//                $gerencia = $result->getGerencia();
//                foreach ($complejosArray as $valueComplejo) {
//                    foreach ($gerenciasObjectArray as $valueGerencia) {
//                        if ($complejo->getId() . '-' . $gerencia->getId() == $valueComplejo . '-' . $valueGerencia) {
//                            $gerenciaSecondChildren[] = array(
//                                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
//                                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
//                                'id' => $result->getId(),
//                                'description' => $result->getDescription()
//                            );
//                        }
//                    }
//                }
//            }
//        } else {
            foreach ($results as $result) {
                $complejo = $result->getGerencia()->getComplejo();
                $gerencia = $result->getGerencia();
                $gerenciaSecondChildren[] = array(
                    'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                    'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                    'id' => $result->getId(),
                    'description' => $result->getDescription()
                );
            }
        //}

        $response->setData($gerenciaSecondChildren);

        return $response;
    }
    
    /**
     * Función que devuelve la(s) gerencias de 2da línea asociada a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaSecondListAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $gerenciasObjectArray = array();
        
        $results = array();
        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
            $gerencia = $request->request->get('gerencia');
            if((int)$gerencia == 0){
                $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true));
            } else{
                $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $gerencia));
            }
        } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))) {
            $results = $this->get('pequiven.repository.gerenciasecond')->findByGerenciaFirst(array('gerencia' => $user->getGerencia()->getId()));
        }

        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            $gerenciaSecondChildren[] = array(
                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                'id' => $result->getId(),
                'description' => $result->getDescription()
            );
        }

        $response->setData($gerenciaSecondChildren);

        return $response;
    }

    /**
     * Devuelve las Gerencias de acuerdo a los Complejos seleccionados
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFromComplejoAction(Request $request) {
        $response = new JsonResponse();
        $dataGerencia = array();
        $complejos = $request->request->get('complejos');
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.gerenciafirst')->getGerenciaOptions(array('complejos' => $complejos));

        foreach ($results as $result) {

            foreach ($result as $gerencia) {
                $dataGerencia[] = array(
                    'idComplejo' => $gerencia->getComplejo()->getId(),
                    'optGroup' => $gerencia->getComplejo()->getDescription(),
                    'id' => $gerencia->getId(),
                    'description' => $gerencia->getDescription()
                );
            }
        }

        $response->setData($dataGerencia);

        return $response;
    }
    
    /**
     * Gerencias de 1ra línea para la tabla de visualización
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function selectGerenciaFirstAction(Request $request) {
        $response = new JsonResponse();

        $dataGerencia = array();
        $em = $this->getDoctrine()->getManager();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
            $results = $this->get('pequiven.repository.gerenciafirst')->getGerenciaOptions();
        } else {
            $results = $this->get('pequiven.repository.gerenciafirst')->getGerenciaOptions(array('complejos' => $user->getComplejo()->getId()));
        }

        $totalResults = count($results);
        if (is_array($results) && $totalResults > 0) {
            foreach ($results as $result) {
                foreach ($result as $gerencia) {
                    $dataGerencia[] = array(
                        'idComplejo' => $gerencia->getComplejo()->getId(),
                        'optGroup' => $gerencia->getComplejo()->getDescription(),
                        'id' => $gerencia->getId(),
                        'description' => $gerencia->getDescription()
                    );
                }
            }
        } else {
            $dataGerencia[] = array("empty" => true);
        }

        $response->setData($dataGerencia);

        return $response;
    }

    /**
     * Devuelve la Referencia del Objetivo, de acuerdo a la cantidad que ya se encuentren registrados
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayRefObjetiveAction(Request $request) {
        $response = new JsonResponse();

        $data = array();
        $options = array();

        $objetiveTacticId = $request->request->get('objetiveTacticId');

        $options['objetiveTactics'] = $objetiveTacticId;

        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Función que devuelve la referencia del objetivo operativo que se esta creando
     * @param array $options
     */
    public function setNewRef($options = array()) {
        $em = $this->getDoctrine()->getManager();
        $objetivesTactics = explode(',', $options['objetiveTactics']);
        $totalObjetivesTactics = count($objetivesTactics);

        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetivesTactics[$totalObjetivesTactics - 1]));
        $refObjetiveTactic = $objetiveTactic->getRef();
        
        $em->getFilters()->disable('softdeleteable');
        $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetivesTactics[$totalObjetivesTactics - 1], array('searchByRef' => true, 'viewAll' => true));
        $em->getFilters()->enable('softdeleteable');
        $total = count($results);
        if (is_array($results) && $total > 0) {
            $ref = $refObjetiveTactic . ($total + 1) . '.';
        } else {
            $ref = $refObjetiveTactic . '1.';
        }

        return $ref;
    }
    
    /**
     * Función que devuelve la referencia del objetivo táctico que se esta creando
     * @param array $options
     */
    public function setRef($options = array()) {
        $em = $this->getDoctrine()->getManager();
        $objetivesTactics = $options['objetiveTactics'];
        $totalObjetivesTactics = count($objetivesTactics);
        $period = $this->getPeriodService()->getPeriodActive();
        $totalRef = array();

        $objetiveTactic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetivesTactics[$totalObjetivesTactics - 1]));
        $refObjetiveTactic = $objetiveTactic->getRef();
        $em->getFilters()->disable('softdeleteable');
        $results = $this->get('pequiven.repository.objetiveoperative')->getByParent($objetivesTactics[$totalObjetivesTactics - 1], array('searchByRef' => true, 'viewAll' => true));
        $em->getFilters()->enable('softdeleteable');
        $total = count($results);
        
        for($i = 0; $i < $options['totalGerencias']; $i++){
            $totalRef[$i] = $refObjetiveTactic . ($total + ($i +1)) . '.';
            //En caso de que el objetivo tenga varios padres
            if ($totalObjetivesTactics > 1) {
                $totalRef[$i].='m';
            }
        }

        return $totalRef;
    }
    
    /**
     * Función que actualiza la referencia de los Indicadores, en caso de que se creen dos Objetivos Operativos por diferente usuarios al mismo tiempo
     * @param type $data
     * @param type $totalRef
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function updateIndicatorRef($data = array(), $totalRef = array()){
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        
        $k = 1; //Contador de Indicadores seleccionados en el Select del Formulario
        foreach ($data['indicators'] as $value) {//Recorremos los Indicadores Tácticos ya creados asociados al Objetivo Táctico a crear
            $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
            $indicator->setRef('IT-' . $totalRef[0] . $k);
            $indicator->setRefParent($totalRef[0]);
            $em->persist($indicator);
            $k++;
        }
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
    
    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    private function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
}
