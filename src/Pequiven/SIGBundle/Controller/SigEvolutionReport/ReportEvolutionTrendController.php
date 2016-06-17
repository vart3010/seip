<?php

namespace Pequiven\SIGBundle\Controller\SigEvolutionReport;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionTrend;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionTrendType;

#Verification
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionActionVerification;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionActionVerificationType;

/**
 * Controlador de los distintos modulos del infome de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */

class ReportEvolutionTrendController extends ResourceController
{   
    
    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormTrendAction(Request $request)
    {
        
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');

        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);

        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_trend.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'object' => $result,
                'form'   => $form->createView(),                
                'period' => $result->getPeriod()->getName()
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     * Añade la tendencia 
     * 
     * @param Request $request
     * @return type
     */
    public function addTrendAction(Request $request)
    {   
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');        
        $month = $request->get('set_data')['month'];//Carga de Mes pasado
        
        $user = $this->getUser();
        
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $trend->setIdObject($idObject);
        $trend->setCreatedBy($user);
        $trend->setMonth($month);
        $trend->setTypeObject($typeObject);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($trend);
            $em->flush(); 
            $this->get('session')->getFlashBag()->add('success', "Analisis de Tendencia Añadido Exitosamente");                        
            //return true;
        }     
        die();
    }

    /**
     * Elimina el analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    public function deletetrendAction(Request $request)
    {   
        $id = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_trend_report_evolution')->find($id);        
        if($results){
            $em->remove($results);
            $em->flush();          
            $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteTrend', array(), 'PequivenSIGBundle'));
            return true;
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
        $id = $request->get('id');        
        $typeObject = $request->get('typeObj');
        
        $month = $request->get('evolutiontrend')['month'];//Carga de Mes pasado
        
        $user = $this->getUser();        
        
        $verification = new EvolutionActionVerification();
        $form  = $this->createForm(new EvolutionActionVerificationType($id, $typeObject), $verification);        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_action_verification.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $id,
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
        $id = $request->get('idObject');//Carga de indicador
        $typeObject = $request->get('typeObj');
        $month = $request->get('month');;//Mes
        $user = $this->getUser();

        $verification = new EvolutionActionVerification();
        $form  = $this->createForm(new EvolutionActionVerificationType(), $verification);
        
        if ($typeObject == 1) {            
            $repository = $this->get('pequiven.repository.sig_indicator');
            $results = $repository->find($id);            
            $verification->setIndicator($results);            
        }elseif($typeObject == 2){            
            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $results = $repository->find($id); 
            $verification->setArrangementProgram($results);            
        }

        $action = $request->get('actionVerification')['actionPlan'];
        $idVerification = $request->get('actionVerification')['typeVerification'];
        
        //Consulta del tipo de Verificación para el plan de acción
        $ver = $this->get('pequiven.repository.managementsystem_sig_verification')->find($idVerification);
        $statusAction = $ver->getStatus();//Status 0/1 para el plan 

        //Acción
        $actionVer = $this->get('pequiven.repository.sig_action_indicator')->find($action);
        
        $verification->setCreatedBy($user);
        $verification->setActionPlan($actionVer);
        $verification->setMonth($month);
        $verification->setTypeObject($typeObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($verification);
            $em->flush();
        }    
        
        if($actionVer){//Si existe la acción le cambio el status segun sea el caso
            $actionVer->setStatus($statusAction);
            $em->flush();  
        }  
        $this->get('session')->getFlashBag()->add('success', "Verificación Cargada Exitosamente");                                
    }

    /**
     *  Delete verification
     *  
     * @param Request $request
     * @return type
     */
    public function deleteVerificationAction(Request $request)
    {
        $id = $request->get('id');//id Verification                
        $em = $this->getDoctrine()->getManager();
        $verification = $this->get('pequiven.repository.sig_action_verification')->find($id);
        
        if($verification){
            $em->remove($verification);
            $em->flush(); 
            $this->get('session')->getFlashBag()->add('success', "Verificación Eliminada Exitosamente");                        
        }
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