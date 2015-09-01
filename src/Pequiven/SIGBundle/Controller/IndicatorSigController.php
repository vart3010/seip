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

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionTrend;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionTrendType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionVerificationType;

use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorLastPeriodType;

/**
 * Controlador Informe de Evolución del Indicador
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */

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

        $month = $request->get('month'); //El mes pasado por parametro
        
        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas
        
        //Carga de data de Indicador para armar grafica
        $response = new JsonResponse();

        $idIndicator = $request->get('id');

        $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

        $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

        $dataChart = $indicatorService->getDataChartOfIndicatorEvolution($indicator, array('withVariablesRealPLan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

        //$response->setData($dataChart); //Seteamos la data del gráfico en Json
        //Carga de los datos de la grafica de las Causas de Desviación
        $dataCause = $indicatorService->getDataChartOfCausesIndicatorEvolution($indicator, $month); //Obtenemos la data del grafico de las causas de desviación
        /*$response->setData($dataCause); //Seteamos la data del gráfico en Json
        var_dump($response);
        die();*/
        $results = $this->get('pequiven.repository.sig_causes_indicator')->findBy(array('indicator' => $idIndicator,'month' => $month));

        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_indicator')->findByindicator($indicator);
        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('indicator'=>$indicator, 'month' => $month));

        //Carga de la señalización de la tendencia de la grafica
        $tendency = $indicator->getTendency()->getId();
        switch ($tendency) {
                case 0:
                    $font = null;
                    break;
                case 1:
                    $font = "long-arrow-up";
                    break;
                case 2:
                    $font = "long-arrow-down";
                    break;
                case 3:
                    $font = "arrows-h";
                    break;
        }       
        //$view = $this->view();
        //$view->getSerializationContext()->setGroups(array('id','api_list'));  

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('evolution.html'))
            ->setData(array(
                'data'                           => $dataChart,
                'verification'                   => $data["verification"],
                'dataCause'                      => $dataCause,
                'cause'                          => $results,
                'data_action'                    => $data["action"],
                'analysis'                       => $causeAnalysis,
                'trend'                          => $trend,
                'font'                           => $font,
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
        
        $indicatorRel = new Indicator();
        $form  = $this->createForm(new IndicatorLastPeriodType(), $indicatorRel);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form.html'))
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
     * Añade la relacion con el indicador 2014
     * 
     * @param Request $request
     * @return type
     */
    public function addLastPeriodAction(Request $request)
    {   
        $idIndicator = $request->get('idIndicator');
        //var_dump($request->get('pequiven_indicatorbundle_indicator_last_period')['indicatorlastPeriod']);
        //var_dump($request);
        
        $lastPeriod = $request->get('pequiven_indicatorbundle_indicator_last_period')['indicatorlastPeriod'];

        $em = $this->getDoctrine()->getManager();

        $indicatorRel = $this->get('pequiven.repository.sig_indicator')->find($idIndicator);
        
        if ($indicatorRel) {

            $dataLast = $this->get('pequiven.repository.sig_indicator')->find($lastPeriod);
            
            }
        
        //$indicatorRel->setDescription($data);
        $indicatorRel->setIndicatorLastPeriod($dataLast);

        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('pequiven_indicator_evolution',$idIndicator));
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
        $causeAction = $request->get('pequiven_indicatorbundle_evolutionindicator_evolutionaction')['evolutionCause'];
        //var_dump($causeAction);
        //die();

        $causeResult = $this->get('pequiven.repository.sig_causes_indicator')->find($causeAction);
        
        $action = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType(), $action);
        
        $action->setCreatedBy($user);
        $action->setEvolutionCause($causeResult);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();
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
        //var_dump(date("m"));
        //var_dump(date("M"));
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
        $month = date("m");//Carga del mes de Creación de la causa "Automatico"

        $indicator = $request->get('idIndicator');
        $repository = $this->get('pequiven.repository.sig_indicator');
        $results = $repository->find($indicator);
        
        $user = $this->getUser();
        $data = $results;
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        
        $cause->setIndicator($data);
        $cause->setCreatedBy($user);
        $cause->setMonth($month);        

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($cause);
            $em->flush();
        }     
    }

    /**
     * Elimina las causas
     * 
     * @param Request $request
     * @return type
     */
    public function deleteCauseAction(Request $request)
    {   
        //die($request->get('id'));
        $causeId = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_causes_indicator')->find($causeId);
        //var_dump(count($results));
        //die();
        if($results){

        $em->remove($results);
        $em->flush();
        
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
        $idIndicator = $request->get('idIndicator');
        
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_trend.html'))
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
     * Añade la tendencia del indicador
     * 
     * @param Request $request
     * @return type
     */
    public function addTrendAction(Request $request)
    {   
        $indicator = $request->get('idIndicator');
        $repository = $this->get('pequiven.repository.sig_indicator');
        $results = $repository->find($indicator);
        
        $user = $this->getUser();
        $data = $results;
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $trend->setIndicator($data);
        $trend->setCreatedBy($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($trend);
            $em->flush();

           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }     
    }

    /**
     * Retorna el formulario de Verificación del Plan de Acción
     * 
     * @param Request $request
     * @return type
     */
    function getFormVerificationAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);        
        
        $verification = new EvolutionActionVerification();
        $form  = $this->createForm(new EvolutionActionVerificationType(), $verification);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action_verification.html'))
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
     * Añade la Verificacion de Plan de Acción y Seguimiento
     * 
     * @param Request $request
     * @return type
     */
    public function addVerificationAction(Request $request)
    {   
        
        $action = $request->get('pequiven_indicatorbundle_evolutionindicator_evolutionactionverification')['actionPlan'];
        $idVerification = $request->get('pequiven_indicatorbundle_evolutionindicator_evolutionactionverification')['typeVerification'];
        
        //Consulta del tipo de Verificación para el plan de acción
        $ver = $this->get('pequiven.repository.managementsystem_sig_verification')->find($idVerification);
        $statusAction = $ver->getStatus();//Status 0/1 para el plan 

        //Acción
        $actionVer = $this->get('pequiven.repository.sig_action_indicator')->find($action);

        $user = $this->getUser();
        $verification = new EvolutionActionVerification();
        $form  = $this->createForm(new EvolutionActionVerificationType(), $verification);
        
        $verification->setCreatedBy($user);
        $verification->setActionPlan($actionVer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($verification);
            $em->flush();

           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }    

        
        if($actionVer){//Si existe la acción cambio le cambio el status segun sea el caso

            $actionVer->setStatus($statusAction);
            $em->flush();  

        }  
    }

    /**
     * Busca las Causas del indicador para filtrarlas para el plan de acción
     * @param type $param
     */
    function getCausesEvolutionAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $idIndicator = $request->get('idIndicator');
        //echo "indicador"; var_dump($idIndicator);
        //die();
        //$idIndicator = $request->get('id');
       
        $results = $this->get('pequiven.repository.sig_causes_indicator')->findBy(array( 'indicator' => $idIndicator));
        
        //$user = $this->getUser();
        /*$criteria = $request->get('filter',$this->config->getCriteria());
        $repository = $this->get('pequiven.repository.managementsystem_sig');
        $results = $repository->findAll();*/
        
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id','api_list','ref','description'));
        return $this->handleView($view);
    }

    /**
     * Buscamos las acciones de las causas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    private function findEvolutionCause(Request $request)
    {
        //$id = $request->get('idIndicator');
        $idIndicator = $request->get('id'); 
        //Mes Actual
        $monthActual = date("m");
        //Mes Consultado       
        $month = $request->get('month'); 

        //$results = $this->get('pequiven.repository.sig_causes_indicator')->findBy(array('indicator' => $idIndicator,'month'=> $month));
        $results = $this->get('pequiven.repository.sig_causes_indicator')->findBy(array('indicator' => $idIndicator));
  
        //Determinando si esta en historico de informe o periodo actual
        if($month < $monthActual){
            $statusCons = 1;
        }else{
            $statusCons = 0;
        }
        
        $cause = array();
        if($results){

            foreach ($results as $value) {
                
                $idCause = $value->getId();
                
                $cause[] = $idCause;
            }

            $action = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause, 'status' => $statusCons));
             
        }        
        
        if(!$results){
            $action = null;
        }

        //Carga de las acciones para sacar la verificaciones realizadas
        if($action){
         
            foreach ($action as $value) {
                $idAction[] = $value->getId();
            }
        }    

        if(!$action){
            $idAction = null;
        } 
        $verification = $this->get('pequiven.repository.sig_action_verification')->findByactionPlan($idAction);

        //Carga de array con la data
        $data = [

            'action'        => $action, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones
            //'results'     => $results //Pasando la data de las causas si las hay

        ];

        return $data;
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