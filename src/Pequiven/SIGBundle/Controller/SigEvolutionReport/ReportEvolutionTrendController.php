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
            return true;
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