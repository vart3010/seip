<?php

namespace Pequiven\SIGBundle\Controller;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SIGBundle\Entity\ManagementSystem;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionType;

use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorLastPeriodType;

class IndicatorSigController extends ResourceController
{   
    /**
     * Lista de Indicadores por nivel(Estratégico, Táctico u Operativo)
     * Filtrados por managementSystems
     * @param Request $request
     * @return type
     */
    function listAction(Request $request) {

        $level = $request->get('level'); 

        $rol = null;
        $roleByLevel = array(
            IndicatorLevel::LEVEL_ESTRATEGICO => array('ROLE_SEIP_INDICATOR_VIEW_STRATEGIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC'),
            IndicatorLevel::LEVEL_TACTICO => array('ROLE_SEIP_INDICATOR_VIEW_TACTIC', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC'),
            IndicatorLevel::LEVEL_OPERATIVO => array('ROLE_SEIP_INDICATOR_VIEW_OPERATIVE', 'ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')
        );
        if (isset($roleByLevel[$level])) {
            $rol = $roleByLevel[$level];
        }

        $this->getSecurityService()->checkSecurity($rol);
        

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->container->get('pequiven.repository.sig_indicator');
        
        $criteria['indicatorLevel'] = $level;
        $criteria['applyPeriodCriteria'] = true;

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorByLevelSIG', array($criteria, $sorting)
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
        $routeParameters = array(
            '_format' => 'json',
            'level' => $level,
        );
        $apiDataUrl = $this->generateUrl('pequiven_indicatorsig_list', $routeParameters);
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'valuesIndicator','managementSystems','api_details', 'sonata_api_read', 'formula'));
        if ($request->get('_format') == 'html') {
            $labelsSummary = array();
            foreach (Indicator::getLabelsSummary() as $key => $value) {
                $labelsSummary[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

            $data = array(
                'apiDataUrl' => $apiDataUrl,
                $this->config->getPluralResourceName() => $resources,
                'level' => $level,
                'labelsSummary' => $labelsSummary
            );
            $view->setData($data);

        } else {
            $formatData = $request->get('_formatData', 'default');

            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);

    }

    /**
     * Vista indice de evolucion
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function evolutionAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);
        
        //Carga de data de Indicador para armar grafica
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartOfIndicatorEvolution($indicator, array('withVariablesRealPLan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        //$response->setData($dataChart); //Seteamos la data del gráfico en Json
        //Carga de los datos de la grafica de las Causas de Desviación
        $dataCause = $indicatorService->getDataChartOfCausesIndicatorEvolution($indicator); //Obtenemos la data del grafico de las causas de desviación
        /*$response->setData($dataCause); //Seteamos la data del gráfico en Json
        var_dump($response);
        die();*/

        //Consultamos las Causas Relacionadas al indicador        
        $indicator = $idIndicator;
        $results = $this->get('pequiven.repository.sig_causes_indicator')->findByindicator($indicator);
        //Carga de las Acciones
        $action = $this->get('pequiven.repository.sig_action_indicator')->findByindicatorRel($indicator);

        //return $response;
        
        // Fin configuracion de grafico     
        //$view = $this->view();
        //$view->getSerializationContext()->setGroups(array('id','api_list'));  

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('evolution.html'))
            ->setData(array(
                'data'                           => $dataChart,
                'dataCause'                      => $dataCause,
                'cause'                          => $results,
                'data_action'                    => $action,
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView()
            ));

        return $this->handleView($view);
    }

    /**
     * Retorna el formulario de la relacion del indicador con periodo 2014
     * 
     * @param Request $request
     * @return type
     */
    function getFormAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request); 
        //var_dump($request->get('idIndicator'));
        
        /*$valueIndicator = $this->resourceResolver->getResource(
            $this->getRepository(),
            'findOneBy',
            array(array('id' => $request->get('id',0))));*/
        $indicatorRel = new Indicator();
        $form  = $this->createForm(new IndicatorLastPeriodType(), $indicatorRel);
        //$form = $this->buildForm();
        //$form = $this->buildForm($indicator,$valueIndicator);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $indicator,
                'form' => $form->createView(),
                //'valueIndicator' => $valueIndicator
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Añade la relacion con el indicador 2014
     * 
     * @param Request $request
     * @return type
     */
    public function addLastPeriodAction(Request $request)
    {   
        $idIndicator = $request->get('idIndicator');
        //var_dump($request->get('pequiven_indicatorbundle_indicator_last_period')['indicatorlastPeriod']);
        $lastPeriod = $request->get('pequiven_indicatorbundle_indicator_last_period')['indicatorlastPeriod'];

        $em = $this->getDoctrine()->getManager();

        $indicatorRel = $this->get('pequiven.repository.sig_indicator')->find($idIndicator);
        
        if ($indicatorRel) {

            $dataLast = $this->get('pequiven.repository.sig_indicator')->find($lastPeriod);
            
            }
        //$indicatorRel = new Indicator();
        //$form  = $this->createForm(new IndicatorLastPeriodType(), $indicatorRel);
        
        //$indicatorRel->setDescription($data);
        $indicatorRel->setIndicatorLastPeriod($dataLast);


        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            //$em->persist($indicatorRel);
            $em->flush();
            //return $this->redirect($this->generateUrl('pequiven_action_evolution_add'));
        //}                
    }

    /**
     * Retorna el formulario del plan de acción
     * 
     * @param Request $request
     * @return type
     */
    function getFormPlanAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);        
        
        $cause = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType(), $cause);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $indicator,
                'form' => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Añade el Plan de Acción
     * 
     * @param Request $request
     * @return type
     */
    public function addAction(Request $request)
    {   
        $user = $this->getUser();

        $indicator = $request->get('idIndicator');
        $repository = $this->get('pequiven.repository.sig_indicator');
        $results = $repository->find($indicator);

        $action = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType(), $action);
        
        $action->setIndicatorRel($results);
        $action->setCreatedBy($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            //return $this->redirect($this->generateUrl('pequiven_action_evolution_add'));
        }                
    }

    /**
     * Retorna el formulario de las causas de desviación
     * 
     * @param Request $request
     * @return type
     */
    function getFormCausesAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);                
        $idIndicator = $request->get('idIndicator');
        
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causes.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'form'           => $form->createView(),
                'indicator'      => $indicator,
                'id' => $idIndicator
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Añade las Causas
     * 
     * @param Request $request
     * @return type
     */
    public function addCausesAction(Request $request)
    {   
        $indicator = $request->get('idIndicator');
        $repository = $this->get('pequiven.repository.sig_indicator');
        $results = $repository->find($indicator);
        
        $user = $this->getUser();
        $data = $results;
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        
        $cause->setIndicator($data);
        $cause->setCreatedBy($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($cause);
            $em->flush();

           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }     
    }

    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormTrendAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);        
        
        $valueIndicator = $this->resourceResolver->getResource(
            $this->getRepository(),
            'findOneBy',
            array(array('id' => $request->get('id',0))));

        //$form = $this->buildForm();
        //$form = $this->buildForm($indicator,$valueIndicator);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_trend.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $indicator,
                //'form' => $form->createView(),
                'valueIndicator' => $valueIndicator
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Busca las Causas del indicador para filtrarlas para el plan de acción
     * @param type $param
     */
    function getCausesEvolutionAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $idIndicator = $request->get('idIndicator');
        var_dump($idIndicator);
        die();
        //$idIndicator = $request->get('id');
        $results = $this->get('pequiven.repository.sig_causes_indicator')->findByindicator($idIndicator);
        var_dump(count($results));
        die();
        //$user = $this->getUser();
        $criteria = $request->get('filter',$this->config->getCriteria());
        $repository = $this->get('pequiven.repository.managementsystem_sig');
        $results = $repository->findAll();
        //var_dump(count($results));
        //die();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','description'));
        return $this->handleView($view);
    }

    /**
     * Busca el indicador o retorna un 404
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator
     * @throws type
     */
    private function findIndicatorOr404(Request $request)
    {
        $id = $request->get('idIndicator');
        
        $indicator = $this->get('pequiven.repository.indicator')->find($id);
        if(!$indicator){
            throw $this->createNotFoundException();
        }
        return $indicator;
    }    

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {

        return $this->container->get('seip.service.security');
    }  

    /**
     * @return \Pequiven\SEIPBundle\Service\FusionChartExportService
     */
    private function getFusionChartExportService()
    {
        return $this->container->get('pequiven_seip.service.fusion_chart');
    } 

    /**
     * 
     * @return \Pequiven\IndicatorBundle\Service\IndicatorService
     */
    protected function getIndicatorService() {
        return $this->container->get('pequiven_indicator.service.inidicator');
    } 
   
}