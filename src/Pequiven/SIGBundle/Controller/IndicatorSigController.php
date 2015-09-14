<?php

namespace Pequiven\SIGBundle\Controller;


use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\SIGBundle\Entity\ManagementSystem;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
//use Pequiven\SEIPBundle\Model\Common\CommonObject;
//use Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator\EvolutionActionValue;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction;
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionValueType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionTrend;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionTrendType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionVerificationType;

use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorLastPeriodType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\IndicatorConfigSigType;

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

        $sumCause = 0;//Declaración de Variable

        $idIndicator = $request->get('id');
        
        //$cause = 101;

        $month = $request->get('month'); //El mes pasado por parametro
        
        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas
        
        //Cargando el Archivo
        $uploadFile = $request->get("uploadFile");//Recibiendo archivo


        //SI SE SUBIO EL ARCHIVO SE PROCEDE A GUARDARLO
        if ($uploadFile != null) {

            $band = false;
            //VALIDACION QUE SEA UN ARCHIVO PERMITIDO
            foreach ($request->files as $file) {
                if (in_array($file->guessExtension(), \Pequiven\IndicatorBundle\Model\Indicator\ValueIndicatorFile::getTypesFile())) {
                    $band = true;
                }
            }
            if ($band) {
                $this->createValueCauseFile($resource, $request);
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
                $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get("id"),"month" => $month)));
            }
        }
        //fin de la carga
        
        //Carga de data de Indicador para armar grafica
        $response = new JsonResponse();

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
        
        foreach ($results as $value) {
            $dataCa = $value->getValueOfCauses();
            $sumCause = $sumCause + $dataCa;
        }

        //Carga el analisis de la tendencia
        $trend = $this->get('pequiven.repository.sig_trend_indicator')->findBy(array('indicator' => $indicator, 'month' => $month));

        //Carga del analisis de las causas
        $causeAnalysis = $this->get('pequiven.repository.sig_causes_analysis')->findBy(array('indicator'=>$indicator, 'month' => $month));

        //Carga de la señalización de la tendencia de la grafica
        //$tendency = $indicator->getIndicatorSigTendency();
        $tendency = $indicator->getTendency()->getId();
        
        $font = array();
            switch ($tendency) {
                    case 0:
                        $font = [
                        'icon'=>'',
                        'text'=>''                    
                        ];
                        break;
                    case 1:
                        $font = [
                        'icon' => 'long-arrow-up',
                        'text' => 'Mejor hacia...'
                        ];
                        break;
                    case 2:
                        $font = [
                        'icon' => 'long-arrow-down',
                        'text' => 'Mejor hacia...'
                        ];
                        break;
                    case 3:
                        $font = [
                        'icon' => 'long-arrow-right',
                        'text' => 'Estable...'
                        ];                    
                        break;
            }       
        //$view = $this->view();
        //$view->getSerializationContext()->setGroups(array('id','api_list'));              

            $dataAction = [
                'action' => $data["action"],
                'values' => $data["actionValue"] 
            ];

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('evolution.html'))
            ->setData(array(
                'data'                           => $dataChart,
                'verification'                   => $data["verification"],
                'dataCause'                      => $dataCause,
                'sumCause'                       => $sumCause,
                'cause'                          => $results,
                'month'                          => $month,
                'dataAction'                     => $dataAction,
                'analysis'                       => $causeAnalysis,
                'trend'                          => $trend,
                'font'                           => $font,
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView()
            ));

        return $this->handleView($view);
    }

    public function createValueCauseFile(Indicator $indicator, Request $request) {

        $EvolutionCauseFile = new Indicator\EvolutionIndicator\EvolutionCauseFile();
        
        $fileUploaded = false;
        
        $month = date("m");//Carga del mes de Creación de la causa "Automatico"  
        //var_export($request->files);
        //die();
        $causeAnalysis = $request->get('cause');
        //die();

        $causeData = $this->get('pequiven.repository.sig_causes_analysis')->find($causeAnalysis);
        
            if ($causeData->getId() == $causeAnalysis) {
                //die("paso");
                $EvolutionCauseFile->setValueCause($causeData);
                foreach ($request->files as $file) {
                    //VALIDA QUE EL ARCHIVO SEA UN PDF
                    //SE GUARDAN LOS CAMPOS EN BD
                  //  die("entro al foreach");
                    $EvolutionCauseFile->setCreatedBy($this->getUser());
                    $EvolutionCauseFile->setNameFile($file->getClientOriginalName());
                    $EvolutionCauseFile->setPath(Indicator\EvolutionIndicator\EvolutionCauseFile::getUploadDir());
                    $EvolutionCauseFile->setExtensionFile($file->guessExtension());

                    //SE MUEVE EL ARCHIVO AL SERVIDOR
                    $file->move($this->container->getParameter("kernel.root_dir") . '/../web/' . Indicator\EvolutionIndicator\EvolutionCauseFile::getUploadDir(), Indicator\ValueIndicator\ValueIndicatorFile::NAME_FILE . $causeData->getId());
                    $fileUploaded = $file->isValid();
                }
            }
        
        if (!$fileUploaded) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($EvolutionCauseFile);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('action.messages.saveFileSuccess', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get("id"),"month" => $month)));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.errorFileUpload', array(), 'PequivenIndicatorBundle'));
            $request->request->set("uploadFile", "");
            $this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $request->get("id"),"month" => $month)));            
        }
    }
    /**
     *
     * Generate URL files
     * 
     */
    public function generateUrlFile(Request $request) {

        $response = new JsonResponse();
        $data = array();
        $data["url"] = $this->generateUrl("pequiven_indicator_vizualice_file", array("id" => $request->get("id")));
        $response->setData($data);
        return $response;
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

        $lastPeriod = $request->get('lastPeriod')['indicatorlastPeriod'];

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
        $idIndicator = $this->findIndicatorOr404($request); 

        $user = $this->getUser();//Carga de usuario

        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas

        foreach ($idIndicator->getObjetives() as $value) {
          
            $complejo = $value->getComplejo()->getRef();
            $gerencia = $value->getGerencia()->getAbbreviation();

        }

        //$action = $data["cant"];
        $indicator = $idIndicator->getId();

        $codifigication = [
            'complejo' => strtoupper($complejo),
            'gerencia' => strtoupper($gerencia),
            'cant'     => $data["cant"]
        ];

        $config = [
            'id' => 'form_action_evolution'
        ];
        //var_dump($codifigication);
        //die();       
        
        $cause = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType(), $indicator, array('indicator' => $indicator));
        //$form = $this->createForm(new AvatarFormType(), $user, array('user' => $user)) Ejm <---- 
        $form_value  = $this->createForm(new EvolutionActionValueType());
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator'     => $idIndicator,
                'config'        => $config,
                'code'          => $codifigication,
                'form_value'    => $form_value->createView(),
                'form'          => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Retorna el formulario del plan de acción
     * 
     * @param Request $request
     * @return type
     */
    function getFormPlanAddAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request); 

        $user = $this->getUser();//Carga de usuario

        $data = $this->findEvolutionCause($request);//Carga la data de las causas y sus acciones relacionadas
        
        //$cause = new EvolutionAction();
        //$form  = $this->createForm(new EvolutionActionType());
        $form_value  = $this->createForm(new EvolutionActionValueType());
        $codifigication = $form = 0;
        
        $config = [
            'id' => 'form_action_values_evolution'
        ];
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator'     => $indicator,
                'code'          => $codifigication,
                'config'        => $config,
                'form_value'    => $form_value->createView(),
                'form'          => $form
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
        $causeAction = $request->get('actionResults')['evolutionCause'];//Recibiendo
        
        $AcValue = $request->get('actionValue')['advance'];//RecibiendoValue
        $AcObservation = $request->get('actionValue')['observations'];//RecibiendoObservations
        
        $month = date("m");//Carga del mes de Creación de la causa "Automatico"  

        $causeResult = $this->get('pequiven.repository.sig_causes_indicator')->find($causeAction);
        
        //Calculando la cantidad de meses que durara la acción
        $dateStart = $request->get('actionResults')['dateStart'];
        $dateEnd = $request->get('actionResults')['dateEnd'];
        //$advance = $request->get('actionResults')['advance'];
        
        $dStart = $dateStart["month"];
        $dEnd   = $dateEnd["month"];
        //var_dump($dStart);
        $count = 0; $data = (int)$dStart;
            //var_dump($data);
            $action = new EvolutionAction();
            $form  = $this->createForm(new EvolutionActionType(), $action);
            
            $action->setCreatedBy($user);
            $action->setEvolutionCause($causeResult);
            $action->setMonth($data);//Carga de Mes(var month)
            //$action->setAdvance($advance);


            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($action);
                $em->flush();
            } 
    
            $idAction = $action->getId();               
            if ($idAction) {
                for ($i=$dStart; $i <= $dEnd; $i++) { 
                
                        $action = $this->get('pequiven.repository.sig_action_indicator')->find($idAction);

                        $relactionValue = new EvolutionActionValue();

                        $relactionValue->setAdvance($AcValue);
                        $relactionValue->setObservations($AcObservation);
                        $relactionValue->setMonth($data);
                        $relactionValue->setActionValue($action);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($relactionValue);
                        $em->flush();

                    $count = $count + 1;
                    $data = $dStart + $count;
                    $AcObservation = null;
                    $AcValue = 0;
                }
            }

        //}

    }

    /**
     * Elimina las acciones
     * 
     * @param Request $request
     * @return type
     */
    public function deletePlanAction(Request $request)
    {   
        //die($request->get('id'));
        $idAction = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_action_indicator')->find($idAction);
        
        if($results){

            $em->remove($results);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteAction', array(), 'PequivenSIGBundle'));
       
        }  
    }

    /**
     * Añade Valores del Plan de Acción
     * 
     * @param Request $request
     * @return type
     */
    public function addValuesAction(Request $request)
    {    
        $idAction = $request->get('idAction'); //Recibiendo de $request el id del valor

        //Recibiendo de formulario
        $AcValue = $request->get('actionValue')['advance'];//RecibiendoValue
        $AcObservation = $request->get('actionValue')['observations'];//RecibiendoObservations
        
        //Consultando valores
        $actionResults = $this->get('pequiven.repository.sig_action_value_indicator')->find($idAction);
        
        $actionResults->setAdvance($AcValue);
        $actionResults->setObservations($AcObservation);

                $em = $this->getDoctrine()->getManager();
                $em->flush();


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

            //$this->get('session')->getFlashBag()->add('error', $this->trans('action.messages.InvalidFile', array(), 'PequivenIndicatorBundle'));
            //$this->redirect($this->generateUrl("pequiven_indicator_evolution", array("id" => $indicator, "month" => $month)));
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

        $month = date("m");//Carga del mes de Creación de la causa "Automatico"        
        
        $user = $this->getUser();
        $data = $results;
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $trend->setIndicator($data);
        $trend->setCreatedBy($user);
        $trend->setMonth($month);

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
        
        $action = $request->get('actionVerification')['actionPlan'];
        $idVerification = $request->get('actionVerification')['typeVerification'];
        
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

        
        if($actionVer){//Si existe la acción le cambio el status segun sea el caso

            $actionVer->setStatus($statusAction);
            $em->flush();  

        }  
    }

    /**
     * Retorna el formulario de la configuración de la Gráfica
     * 
     * @param Request $request
     * @return type
     */
    function getFormConfigAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);  
        
        $config = new Indicator();
        $form  = $this->createForm(new IndicatorConfigSigType(), $config);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_config_chart.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator'  => $indicator,
                'form' => $form->createView(),
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Añade la configuración
     * 
     * @param Request $request
     * @return type
     */
    public function addConfigChartAction(Request $request)
    {    
        $idIndicator = $request->get('idIndicator');
        //var_dump($request->get('lastPeriod')['indicatorlastPeriod']);
        //var_dump($request);
        //die();
        $medition = $request->get('configSig')['indicatorSigMedition'];
        //$objetive = $request->get('configSig')['indicatorSigObjetive'];
        //$tendency = $request->get('configSig')['indicatorSigTendency'];

        $em = $this->getDoctrine()->getManager();

        $indicatorConfig = $this->get('pequiven.repository.sig_indicator')->find($idIndicator);
        
        /*if ($indicatorConfig) {

            $dataLast = $this->get('pequiven.repository.sig_indicator')->find($lastPeriod);
            
            }*/
        
        $indicatorConfig->setIndicatorSigMedition($medition);
        //$indicatorConfig->setIndicatorSigObjetive($objetive);
        //$indicatorConfig->setIndicatorSigTendency($tendency);

        $em->flush();//Carga de Datos a DB
                                       
    }

    /**
     * Busca las Causas del indicador para filtrarlas para el plan de acción
     * @param type $param
     */
    function getCausesEvolutionAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $idIndicator = $request->get('idIndicator');//Recibiendo indicator
       
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
        //Carga de variable base
        $opc = false; $idAction = $actionResult = 0; $idCons = [0];
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

            $action = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause));
             
        }        
        
        if(!$results){
            $action = null;
        }

        //Carga de las acciones para sacar la verificaciones realizadas
        if($action){
         
            foreach ($action as $value) {
                //$idAction[] = $value->getId();
                $relation = $value->getRelactionValue();
                    //var_dump(count($relation));
                    foreach ($relation as $value) {
                            
                            $monthAction = $value->getMonth();
                            $monthGet = (int)$month;

                        if ($monthAction === $monthGet) {
                            //var_dump(count($value->getId()));
                            $idAction = $value->getActionValue()->getId();
                            $idCons[] = $idAction;
                            //var_dump($value->getActionValue()->getId());
                            //$actionResult = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idAction));
                            
                        }            
                    }
            }
            $actionResult = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idCons));
            //var_dump($idCons);
            //die();
        }  

        $actionsValues = EvolutionActionValue::getActionValues($idCons, $month);  
        
        $cant = count($actionResult);
        //var_dump($cant);
        //var_dump(count($actionResult));
        //die();

        if($opc = false){
            $idAction = null;
        } 
        $verification = $this->get('pequiven.repository.sig_action_verification')->findByactionPlan($idAction);

        //Carga de array con la data
        $data = [

            'action'        => $actionResult, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones
            //'results'     => $results //Pasando la data de las causas si las hay
            'actionValue'   => $actionsValues,
            'cant'          => $cant

        ];

        return $data;
    } 

    public function exportAction(Request $request) {

        $month = $request->get('month'); //El mes pasado por parametro
        
        $idIndicator = $request->get('id');//Indicador 

        //Carga de data de Indicador para armar grafica
            $response = new JsonResponse();

            $indicatorService = $this->getIndicatorService(); //Obtenemos el servicio del indicador

            $indicator = $this->get('pequiven.repository.indicator')->find($idIndicator); //Obtenemos el indicador

            $dataChart = $indicatorService->getDataChartOfIndicatorEvolution($indicator, array('withVariablesRealPLan' => true)); //Obtenemos la data del gráfico de acuerdo al indicador

            $dataCause = $indicatorService->getDataChartOfCausesIndicatorEvolution($indicator, $month); //Obtenemos la data del grafico de las causas de desviación
        
        $name = $indicator->getRef().''.$indicator->getDescription();
        

        $user = $this->getUser();

        $data = array(
            'month' => $month,
            'name'  => $name
        );

        $this->generatePdf($data);
    }

    public function generatePdf($data) {
        $pdf = new \Pequiven\SEIPBundle\Model\PDF\SeipPdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        //$pdf->setFooterText($this->trans('pequiven_seip.message_footer', array(), 'PequivenSEIPBundle'));

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle('INFORME DE EVOLUCIÓN');
        $pdf->SetSubject('Resultados SEIP');
        $pdf->SetKeywords('PDF, SEIP, Resultados');

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

// set font
//            $pdf->SetFont('times', 'BI', 12);
// add a page

        $pdf->AddPage('L');

// set some text to print

        $html = $this->renderView('PequivenSIGBundle:Indicator:viewPdf.html.twig', $data);

// print a block of text using Write()
        $pdf->writeHTML($html, true, false, true, false, '');

//            $pdf->Output('Reporte del dia'.'.pdf', 'I');
        $pdf->Output('Informe de evolucion' . '.pdf', 'D');
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

    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
   
}