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
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\ObjetiveBundle\Form\Type\Tactic\RegistrationFormType as BaseFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
use Pequiven\MasterBundle\Entity\Rol;

/**
 * Description of ObjetiveController
 *
 * @author matias
 */
class ObjetiveTacticController extends baseController 
{
    /**
     * Función que retorna la vista con la lista de los objetivos tácticos
     * @Template("PequivenObjetiveBundle:Tactic:list.html.twig")
     * @return type
     */
    public function listAction() 
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_TACTIC');
        return array(
        );
    }

    /**
     * Finds and displays a Objetive entity of level Tactic by Id.
     *
     */
    public function showAction(Request $request) 
    {
        $securityService = $this->getSecurityService();
        $securityService->checkSecurity(array('ROLE_SEIP_OBJECTIVE_VIEW_TACTIC','ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_TACTIC','ROLE_SEIP_SIG_OBJECTIVE_VIEW_TACTIC'));

        $resource = $this->findOr404($request);
        if(!$securityService->isGranted('ROLE_SEIP_PLANNING_VIEW_OBJECTIVE_TACTIC')){
            if(!$securityService->isGranted('ROLE_SEIP_SIG_OBJECTIVE_VIEW_TACTIC')){
                $securityService->checkSecurity('ROLE_SEIP_OBJECTIVE_VIEW_TACTIC',$resource);
            } else{
                $securityService->checkSecurity('ROLE_SEIP_SIG_OBJECTIVE_VIEW_TACTIC',$resource);
            }
        }

        $indicatorService = $this->getIndicatorService();
        $hasPermissionToApproved = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_APPROVED_TACTIC",$resource);
        $hasPermissionToUpdate = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_EDIT_TACTIC",$resource);
        $isAllowToDelete = $securityService->isGrantedFull("ROLE_SEIP_OBJECTIVE_DELETE_TACTIC",$resource);
        
        $view = $this
            ->view()
            ->setTemplate('PequivenObjetiveBundle:Tactic:show.html.twig')
            ->setTemplateVar('entity')
            ->setData(array(
                'entity' => $resource,
                'indicatorService' => $indicatorService,
                'hasPermissionToUpdate' => $hasPermissionToUpdate,
                'isAllowToDelete' => $isAllowToDelete,
                'hasPermissionToApproved' => $hasPermissionToApproved,
            ))
        ;

        $groups = array_merge(array('id','api_list','gerencia','gerenciaSecond'), $request->get('_groups',array()));
        $view->getSerializationContext()->setGroups($groups);
        return $this->handleView($view);
    }

    /**
     * Función que devuelve el paginador con los objetivos tácticos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function objetiveListAction(Request $request) 
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_LIST_TACTIC');
        
        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        $criteria['objetiveLevel'] = ObjetiveLevel::LEVEL_TACTICO;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorTactic', array($criteria, $sorting)
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
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'indicators', 'formula'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
//            var_dump($this->config->getRedirectRoute('objetiveTacticList'));
//            die();
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Función que registra un objetivo táctico
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Template("PequivenObjetiveBundle:Tactic:register.html.twig")
     * @return type
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createAction(Request $request) 
    {
        $this->getPeriodService()->checkIsOpen();
        
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_OBJECTIVE_CREATE_TACTIC');
        
        $form = $this->createForm($this->get('pequiven_objetive.tactic.registration.form.type'));

        $nameObject = 'object';
        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $role = $user->getRoles();

        $em->getConnection()->beginTransaction();
        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
//            var_dump('epale');
//            die();
            $object = $form->getData();
            $data = $this->container->get('request')->get("pequiven_objetive_tactic_registration");

            $period = $this->getPeriodService()->getPeriodActive();
            
//            $object->setWeight(bcadd(str_replace(',', '.', $data['weight']), '0', 2));
            $data['tendency'] = (int) $data['tendency'];
            $object->setGoal(bcadd(str_replace(',', '.', $data['goal']), '0', 2));
            $ref = $data['ref'];

            //Obtenemos y Seteamos el nivel del objetivo
            $objetiveLevel = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('level' => ObjetiveLevel::LEVEL_TACTICO));
            $object->setObjetiveLevel($objetiveLevel);

            $object->setUserCreatedAt($user);

            //Si el usuario tiene rol Directivo
            if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
                if (!isset($data['check_gerencia'])) {//En caso de que las gerencias a impactar por el objetivo sean seleccionadas en el select
                    $totalRef = $this->setRef(array('objetiveStrategics' => $data['parents'], 'totalGerencias' => count($data['gerencia'])));
                    if($totalRef[0] != $data['ref']){
                        $this->updateIndicatorRef($data, $totalRef);
                    }
                    if (isset($data['indicators'])) {
                        $respIndicator = $this->createIndicator($data, array('totalGerencia' => count($data['gerencia'])), $totalRef);
                    }
                    for ($i = 0; $i < count($data['gerencia']); $i++) {
                        ${$nameObject . $i} = clone $object;
                        ${$nameObject . $i}->resetIndicators();
                        $gerencia = $this->get('pequiven.repository.gerenciafirst')->findOneBy(array('id' => $data['gerencia'][$i]));
                        ${$nameObject . $i}->setGerencia($gerencia);
                        ${$nameObject . $i}->setPeriod($period);
                        ${$nameObject . $i}->setRef($totalRef[$i]);
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
                } else {//En caso de que las gerencias a impactar, sean todas la de las localidades seleccionadas
                    $j = 0;
                    for ($i = 0; $i < count($data['complejo']); $i++) {//Recorremos todas las localidades seleccionadas
                        //Obtenemos todas las gerencias de 1ra línea de las localidades seleccionadas
                        $gerencias = $this->get('pequiven.repository.gerenciafirst')->findBy(array('complejo' => $data['complejo'][$i]));
                        $totalRef = $this->setRef(array('objetiveStrategics' => $data['parents'], 'totalGerencias' => count($gerencias)));
                        if($totalRef[0] != $data['ref']){
                            $this->updateIndicatorRef($data, $totalRef);
                        }
                        if (isset($data['indicators'])) {
                            $respIndicator = $this->createIndicator($data, count($gerencias), $totalRef);
                        }
                        foreach ($gerencias as $gerencia) {//Recorremos todos los resultados de las gerencias obtenidas
                            ${$nameObject . $j} = clone $object;
                            ${$nameObject . $j}->resetIndicators();
                            ${$nameObject . $j}->setGerencia($gerencia);
                            ${$nameObject . $j}->setPeriod($period);
                            ${$nameObject . $j}->setRef($totalRef[$j]);
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
                }
                //Si el usuario tiene rol Gerente General de Complejo o Gerente 1ra línea
            } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX', 'ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
                $object->setGerencia($user->getGerencia());
                $object->setPeriod($period);
                $totalRef = $this->setRef(array('objetiveStrategics' => $data['parents'], 'totalGerencias' => 1));
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
                $totalRef = $this->setRef(array('objetiveStrategics' => $data['parents'], 'totalGerencias' => 1));
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
            foreach ($totalRef as $value) {
                $objetives = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('ref' => $value, 'period' => $period->getId()));
                foreach($objetives as $objetive){
                    $this->addObjetiveParents($objetive,$data['parents']);
                    $this->createArrangementRange($objetive, $data);
                }
            }

            if ($securityContext->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX'))) {
                if (isset($data['indicators'])) {
                    $this->removeIndicators($totalRef);
                    $this->addIndicators($totalRef);
                    $this->addIndicatorArrangementRange($totalRef);
                }
            }

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.registerObjetiveTacticSuccessfull', array(), 'PequivenObjetiveBundle'));
            return $this->redirect($this->generateUrl('pequiven_objetive_menu_list_tactic', array(
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
        
        $objetivesStrategics = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('id' => $parents,'period' => $period));
        
        $totalObjetivesStrategics = count($objetivesStrategics);
        $em->getConnection()->beginTransaction();
        if ($totalObjetivesStrategics > 0) {
            foreach ($objetivesStrategics as $objetiveStrategic) {
                $objetiveStrategic->addChildren($objetive);
                $em->persist($objetiveStrategic);
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
    public function removeIndicators($totalRef = array()) {

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        //$objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => '1.3.10.'));
        //$indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => '1.3.9.'));
        $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $totalRef[0]));
        $j = 1;
        foreach ($totalRef as $refObjetive) {//Recorremos todas las referencias de los objetivos creados
            if ($j > 1) {//En caso de que sea la referencia de los objetivos creados menos el primero
                $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $refObjetive));
                foreach ($indicators as $indicator) {
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
    public function addIndicators($totalRef = array()) {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $j = 1;
        foreach ($totalRef as $refObjetive) {//Recorremos todas las referencias de los objetivos creados
            if ($j > 1) {//En caso de que sea la referencia de los objetivos creados menos el primero
                $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refObjetive));
                $objetive = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('ref' => $refObjetive));
                foreach ($indicators as $indicator) {
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
     * Función que sirve para crear los rango para los Indicadores Tácticos creados de más
     * @param type $totalRef
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function addIndicatorArrangementRange($totalRef) {
        $nameObject = 'object';
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        //Obtenemos los Indicatores Tácticos creados originalmente desde el formulario de Objetivos Tácticos
        $indicatorsOriginals = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $totalRef[0]));
        $arrangementRangeOriginals = array();
        $k = 0;
        foreach ($indicatorsOriginals as $indicatorOriginal) {//Recorremos los Indicadores Tácticos creados originalmente desde el formulario de Objetivos Tácticos
            //Obtenemos los Rangos de Gestión de los Indicadores Tácticos creados originalmente
            $arrangementRangeOriginals[$k] = $em->getRepository('PequivenArrangementBundle:ArrangementRange')->findOneBy(array('indicator' => $indicatorOriginal));
            $k++;
        }

        $j = 1;
        $i = 0;
        $periodActive = $this->getPeriodService()->getPeriodActive();
        foreach ($totalRef as $refObjetive) {
            if ($j > 1) {//En caso de que sea la referencia de los objetivos creados menos el primero
                $indicators = $this->get("pequiven.repository.indicator")->findBy(array('refParent' => $refObjetive));
                $p = 0;
                foreach ($indicators as $indicator) {
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
     * Función que crea los Indicadores Tácticos para los Objetivos Tácticos que serán creados de más (cuando se selecciona más de una Gerencia de 1ra Línea)
     * @param type $data
     * @param type $options
     * @param type $totalRef
     * @return boolean
     * @throws \Pequiven\ObjetiveBundle\Controller\Exception
     */
    public function createIndicator($data = array(), $options = array(), $totalRef = array()) {

        $nameObject = 'object';
        $totalGerencias = $options['totalGerencia']; //Total de Gerencias de 1ra Línea que abarca el Objetivo Táctico a crear
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $j = 0; //Contador de Indicadores Tácticos asociados al Objetivo Táctico
        for ($i = 0; $i < $totalGerencias; $i++) {//Recorremos las Gerencias Seleccionada            
            if ($i >= 1) {//Consultamos en caso de que exista más de una Gerencia de 1ra Línea
                $k = 1; //Contador de Indicadores seleccionados en el Select del Formulario
                foreach ($data['indicators'] as $value) {//Recorremos los Indicadores Tácticos ya creados asociados al Objetivo Táctico a crear
                    $indicator = $this->get("pequiven.repository.indicator")->findOneBy(array('id' => $value));
                    ${$nameObject . $j} = new Indicator();
                    ${$nameObject . $j}->setRef('IT-' . $totalRef[$i] . $k);
                    ${$nameObject . $j}->setRefParent($totalRef[$i]);
                    ${$nameObject . $j}->setTmp(false);
                    ${$nameObject . $j}->setWeight($indicator->getWeight());
                    ${$nameObject . $j}->setIndicatorLevel($indicator->getIndicatorLevel());
                    ${$nameObject . $j}->setFormula($indicator->getFormula());
                    ${$nameObject . $j}->setTendency($indicator->getTendency());
                    ${$nameObject . $j}->setDescription($indicator->getDescription());
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
            if ($data['tendency'] < 3) {//Comportamiento No Estable
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomMixedTop']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedTop'])));
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomMixedBottom']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomMixedBottom'])));
            } else { //Comportamiento Estable
                //Rango Bajo-Alto
                $arrangementRange->setRankBottomMixedTop(bcadd(str_replace(',', '.', $data['rankBottomTopBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedTop($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomTopBasic'])));
                //Rango Bajo-Bajo
                $arrangementRange->setRankBottomMixedBottom(bcadd(str_replace(',', '.', $data['rankBottomBottomBasic']), '0', 3));
                $arrangementRange->setOpRankBottomMixedBottom($em->getRepository('PequivenMasterBundle:Operator')->findOneBy(array('id' => $data['opRankBottomBottomBasic'])));
            }
        }
        
        $em->persist($arrangementRange);

//        if ($totalObjetives > 0) {
//            foreach ($objetives as $objetive) {
//                $objectArrangementRange = clone $arrangementRange;
//                $objectArrangementRange->setObjetive($objetive);
//                $em->persist($objectArrangementRange);
//            }
//        }

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
    public function selectObjetiveStrategicFromLineStrategicAction(Request $request) {
        $response = new JsonResponse();

        $objetiveChildrenStrategic = array();
        $em = $this->getDoctrine()->getManager();

        $lineStrategicId = $request->request->get('lineStrategicId');
        $lineStrategicArray = explode(',', $lineStrategicId);

        //En caso de que la variable de línea estratégica sea un número
        if (is_array($lineStrategicArray)) {
            //$results = $em->getRepository('PequivenObjetiveBundle:Objetive')->findBy(array('lineStrategics' => $lineStrategicArray,'objetiveLevel' => $objetiveLevelId));
            $results = $this->get('pequiven.repository.objetive')->getByLineStrategic($lineStrategicArray);
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
     * Devuelve las Gerencias de acuerdo a los Complejos seleccionados (Sólo para el caso de que el usuario sea rol directivo)
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

        $objetiveStrategicId = $request->request->get('objetiveStrategicId');
        $options['objetiveStrategics'] = $objetiveStrategicId;

        $ref = $this->setNewRef($options);

        $data[] = array('ref' => $ref);
        $response->setData($data);
        return $response;
    }

    /**
     * Función que devuelve la referencia del objetivo táctico que se esta creando
     * @param array $options
     */
    public function setNewRef($options = array()) {
        $em = $this->getDoctrine()->getManager();
        $objetivesStrategics = explode(',', $options['objetiveStrategics']);
        $totalObjetivesStrategics = count($objetivesStrategics);
        $period = $this->getPeriodService()->getPeriodActive();

        $objetiveStrategic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetivesStrategics[$totalObjetivesStrategics - 1],'period' => $period));
        $refObjetiveStrategic = $objetiveStrategic->getRef();

        $em->getFilters()->disable('softdeleteable');
        $results = $this->get('pequiven.repository.objetivetactic')->getByParent($objetivesStrategics[$totalObjetivesStrategics - 1], array('searchByRef' => true,'viewAll' => true));
        $em->getFilters()->enable('softdeleteable');
        $total = count($results);

        if (is_array($results) && $total > 0) {
            $ref = $refObjetiveStrategic . ($total + 1) . '.';
        } else {
            $ref = $refObjetiveStrategic . '1.';
        }

        //En caso de que el objetivo tenga varios padres
        if ($totalObjetivesStrategics > 1) {
            $ref.='m';
        }

        return $ref;
    }

    /**
     * Función que devuelve la referencia del objetivo táctico que se esta creando
     * @param array $options
     */
    public function setRef($options = array()) {
        $period = $this->getPeriodService()->getPeriodActive();
        $em = $this->getDoctrine()->getManager();
        $objetivesStrategics = $options['objetiveStrategics'];
        $totalObjetivesStrategics = count($objetivesStrategics);
        $totalRef = array();

        $objetiveStrategic = $em->getRepository('PequivenObjetiveBundle:Objetive')->findOneBy(array('id' => $objetivesStrategics[$totalObjetivesStrategics - 1]));
        $refObjetiveStrategic = $objetiveStrategic->getRef();
        
        $em->getFilters()->disable('softdeleteable');
        $results = $this->get('pequiven.repository.objetivetactic')->getByParent($objetivesStrategics[$totalObjetivesStrategics - 1], array('searchByRef' => true, 'setRef' => true, 'viewALL' => true));
        $em->getFilters()->enable('softdeleteable');
        $total = count($results);

        for ($i = 0; $i < $options['totalGerencias']; $i++) {
            $totalRef[$i] = $refObjetiveStrategic . ($total + ($i + 1)) . '.';
            //En caso de que el objetivo tenga varios padres
            if ($totalObjetivesStrategics > 1) {
                $totalRef[$i].='m';
            }
        }

        return $totalRef;
    }
    
    /**
     * Función que actualiza la referencia de los Indicadores, en caso de que se creen dos Objetivos Tácticos por diferente usuarios al mismo tiempo
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
