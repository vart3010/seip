<?php

namespace Pequiven\SIGBundle\Controller\SigEvolutionReport;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#Acciones y Valores
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionAction;
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionValue;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionType;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionValueType;

/**
 * Controlador de los distintos modulos del infome de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */

class ReportEvolutionActionController extends ResourceController
{   
    
    /**
     * Retorna el formulario del plan de acción
     * 
     * @param Request $request
     * @return type
     */
    function getFormPlanAction(Request $request)
    {
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');//Tipo de objeto Indicador, PG u Objetivo
        
        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);

        $user = $this->getUser();//Carga de usuario
        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $data = $evolutionService->findEvolutionCause($result, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas
        
        $id = $result->getId();

        $config = [
            'id' => 'form_action_evolution'
        ];      
        
        $cause = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType($id, $typeObject));
        $form_value  = $this->createForm(new EvolutionActionValueType());
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator'     => $result,
                'config'        => $config,                
                'form_value'    => $form_value->createView(),
                'form'          => $form->createView(),
                'period'        => $result->getPeriod()->getName()
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Retorna el formulario del plan de acción para cargar valores
     * 
     * @param Request $request
     * @return type
     */
    function getFormPlanAddAction(Request $request)
    {   
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');

        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);

        $user = $this->getUser();//Carga de usuario
        $evolutionService = $this->getEvolutionService(); //Obtenemos el servicio de las causas            
        $data = $evolutionService->findEvolutionCause($result, $request, $typeObject); //Carga la data de las causas y sus acciones relacionadas
        
        $form_value  = $this->createForm(new EvolutionActionValueType());
        $form = 0;
        
        $config = [
            'id' => 'form_action_values_evolution'
        ];
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator'     => $result,                
                'config'        => $config,
                'form_value'    => $form_value->createView(),
                'form'          => $form,
                'period'        => $result->getPeriod()->getName()                
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
        $em = $this->getDoctrine()->getManager();
        $idObject = $request->get('idObject');
        $typeObject = $this->getRequest()->get('typeObj');
        
        $evolutionService = $this->getEvolutionService();            
        $object = $evolutionService->getObjectEntity($idObject, $typeObject);

        switch ($request->get('typeObj')) {
            case 1:
                $objectName = "Indicador";
                $route = "pequiven_indicator_evolution";
                break;
            case 2:
                $objectName = "Programa de Gestión";
                $route = "pequiven_seip_arrangementprogram_evolution_sig";
                break;
            case 3:
                $objectName = "Objetivo";    
                $route = "pequiven_sig_objetive_evolution_show";            
                break;
        }
        
        
        $user = $this->getUser();
        
        $monthSet    = $request->get('set_data')['month'];//recibiendo mes
        $causeAction = $request->get('actionResults')['evolutionCause'];//Recibiendo Causa
        $responsible = $request->get('actionResults')['responsible'];//Recibiendo Responsable
        $AcValue     = $request->get('actionValue')['advance'];//RecibiendoValue
        
        $ref = $this->findEvolutionActionRef($request, $monthSet, $causeAction); //Carga la data de la referencia

        $AcObservation = $request->get('actionValue')['observations'];//RecibiendoObservations

        $causeResult = $this->get('pequiven.repository.sig_causes_report_evolution')->find($causeAction);
        
        //Calculando la cantidad de meses que durara la acción
        $dateStart = $request->get('actionResults')['dateStart'];
        $dateEnd   = $request->get('actionResults')['dateEnd'];
        
        $monthStart = explode("/", $dateStart);//Sacando el mes de inicio
        $monthEnd   = explode("/", $dateEnd);//Sacando el mes de cierre        
        
        $dStart = $monthStart[1];//Pasando mes de Inicio
        $dEnd   = $monthEnd[1];//Pasando el mes de Cierre
        
        $count = 0; $data = (int)$dStart;
            
        $em->getConnection()->beginTransaction();
        $action = new EvolutionAction();
        $form  = $this->createForm(new EvolutionActionType($idObject, $typeObject), $action);
        
        $form->handleRequest($request);
        
        $contaRes = 0;   
        //Recibiendo responsables
        $reponsibles = explode(",", $responsible);         
        $catnRes = count($reponsibles);
        //Creación de url
        $routeParameters = array(
            'id'    => $idObject,
            'month' => $monthSet
        );
        
        $apiDataUrl = $this->generateUrl($route, $routeParameters);        
        //Añadiendo responsables
        for ($i=0; $i < $catnRes; $i++) {             
            $user = $this->get('pequiven_seip.repository.user')->find($reponsibles[$i]);
            $notification = $this->getNotificationService()->setDataNotification("Informe de Evolución", "Ha sido asignado como responsable a un Plan de Acción en el Informe de Evolucion del ".$objectName." ". $object->getRef() ." con fecha de incio: ".$dateStart." y fecha de cierre: ".$dateEnd.", el cual presenta un avance de inicio de ".$AcValue."%.", 6 , 1, $apiDataUrl, $user);                        
            $action->addResponsible($user);            
        }
        
        $action->setRef($ref);//referencia
        $action->setCreatedBy($user);
        $action->setEvolutionCause($causeResult);
        $action->setMonth($data);//Carga de Mes(var month)
        $action->setTypeObject($typeObject);//Tipo de Objeto        

        $em->persist($action);
        $em->flush();                
        
        try {
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
        throw $e;
        }        

        $idAction = $action->getId();   
        if ($idAction) {
            $action   = $this->get('pequiven.repository.sig_action_indicator')->find($idAction);

            $relactionValue = new EvolutionActionValue();
            $relactionValue->setAdvance($AcValue);
            $relactionValue->setObservations($AcObservation);
            $relactionValue->setMonth($monthSet);
            $relactionValue->setActionValue($action);

            $em->persist($relactionValue);
            $em->flush();

            for ($i=$dStart; $i <= $dEnd; $i++) { 
                if ($data != $monthSet) {                             
                    $AcObservation = null;                    
                    $relactionValue = new EvolutionActionValue();
                    $relactionValue->setAdvance($AcValue);
                    $relactionValue->setObservations($AcObservation);
                    $relactionValue->setMonth($data);
                    $relactionValue->setActionValue($action);

                    $em->persist($relactionValue);
                    $em->flush();                    
                }                
                    $count = $count + 1;
                    $data = $dStart + $count;
            }
        }
        $this->get('session')->getFlashBag()->add('success', "Plan de Acción Cargado Exitosamente");
        die();
    
    }

    /**
     * Elimina las acciones
     * 
     * @param Request $request
     * @return type
     */
    public function deletePlanAction(Request $request)
    {           
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
     * Añade Valores del Plan de Acción en Acciones Heredadas
     * 
     * @param Request $request
     * @return type
     */
    public function addValuesAction(Request $request)
    {    
        $idAction = $request->get('idAction'); //Recibiendo de $request el id del valor        
        
        $month = $this->getRequest()->get('month');
        
        $actionResults = $this->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue'=> $idAction));
        $cant = count($actionResults);
        
        //Recibiendo de formulario
        $AcValue = $request->get('actionValue')['advance'];//RecibiendoValue
        $AcObservation = $request->get('actionValue')['observations'];//RecibiendoObservations
        
        for ($i=0; $i <= $cant ; $i++) { //for segun la cantidad de acciones       
            //Consultando valores
            $actionResult = $this->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue'=> $idAction, 'month'=> $month));
            foreach ($actionResult as $value) {
                $dat = $value->getMonth();                
                if ($value->getMonth() == $month) {//Si la accion tiene el mes igual al pasado la actualiza                
                    $sumAdvance = $value->getAdvance() + $AcValue;                
                    
                    $value->setAdvance($sumAdvance);
                    $value->setObservations($AcObservation);
                            
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();                   

                    $month = $month + 1;//Carga de los meses tantas veces sean para la consulta
                    $AcObservation = null;//
                }
            }
        }
        $this->get('session')->getFlashBag()->add('success', "Avance Cargado Exitosamente");    
        die();                    
    }    

    /**
     * Creando la Referencia de la acción
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    private function findEvolutionActionRef(Request $request, $monthSet, $causeAction)
    {
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');
        $cont = 1; 
        $posCause = 1;        
        
        //Mes Actual
        $monthActual = date("m");
        //Mes Consultado       
        $month = $request->get('month'); 
        $complejo = "S/C-";
        $gerencia = "S/G-";

        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);
        
        
        $causes = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $idObject, 'month' => $monthSet, 'typeObject' => $typeObject));
                
        $cause = array();
        if ($causes) {
            foreach ($causes as $value) {
                $idCause = $value->getId();
                $cause[] = $idCause;
                if ($idCause == $causeAction) {
                    $posCause = $cont;
                }
                $cont++; 
            }
            $action = $this->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause));
        }
        if (!isset($action)) {
            $this->get('session')->getFlashBag()->add('error', "Plan de Acción no Cargado! Ha seleccionado un mes que no posee Causas Cargadas"); 
            die();                                           
        }
        $cantAction = count($action) + 1;
        $cantAction = str_pad($cantAction, 2, "0", STR_PAD_LEFT);        
        $cantAction = $cantAction.''."-";                
        
        if ($typeObject == 1) {            
            foreach ($result->getObjetives() as $value) {                
                $compData = $value->getComplejo();//Consultando si tiene complejo
                $gerData = $value->getGerencia();//Si tiene gerencia
                
                if($compData){
                    $complejo = $compData->getRef().''."-";
                    $complejo = strtoupper($complejo);
                }
                if ($gerData) {                
                    $gerencia = $gerData->getAbbreviation().''."-"; 
                    $gerencia = strtoupper($gerencia);
                }
            }
        }
           
        $monthSet = str_pad($monthSet, 2, "0", STR_PAD_LEFT);
        $monthSet = $monthSet.''."-";
        
        $posCause = str_pad($posCause, 2, "0", STR_PAD_LEFT);
        $posCause = $posCause;
        $ref = $complejo.''.$gerencia.''.$monthSet.''.$cantAction.''.$posCause;
        //Carga de array con la data
        $data = [
            //'id'    => $id,
            'ref'   => $ref
        ];

        return $ref;
    } 

    /**
     * Obtiene los responsable que se pueden asignar a un plan
     */
    function getResponsiblesToPlanAction(\Symfony\Component\HttpFoundation\Request $request) {        
        $query = $request->get('query');
        $results = array();        
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $repository = $this->get('pequiven_seip.repository.user');        
        $users = $repository->findAll();        
        if (!$users) {
            throw $this->createNotFoundException();
        }
        
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,                
        );
            
        $results = $this->get('pequiven_seip.repository.user')->findToAssingTacticArrangementProgramGoal($users, $criteria);        

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }
    
    /**
     * 
     * @return \Pequiven\SIGBundle\Service\EvolutionService
     */
    protected function getEvolutionService() {
        return $this->container->get('seip.service.evolution');
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
     *  Notification
     *
     */
    protected function getNotificationService() {        
        return $this->container->get('seip.service.notification');        
    }
   
}