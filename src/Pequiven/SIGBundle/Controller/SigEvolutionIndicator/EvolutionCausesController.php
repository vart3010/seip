<?php

namespace Pequiven\SIGBundle\Controller\SigEvolutionIndicator;


use Pequiven\IndicatorBundle\Entity\Indicator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauseAnalysis;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseAnalysisType;


/**
 * Controlador Causas Informe de Evolución
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */

class EvolutionCausesController extends ResourceController
{   
    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormAnalysisAction(Request $request)
    {
        $indicator = $this->get('pequiven.repository.indicator')->find($id);              
        $idIndicator = $request->get('idObject');
        
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causesanalysis.html'))
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
     * Añade el analisis de las causas
     * 
     * @param Request $request
     * @return type
     */
    public function addCauseAnalysisAction(Request $request)

    {   
        //$month = date("m");//Carga del mes de Creación de la causa
        
        $month = $request->get('causeAnalysis_form')['month'];//Carga de Mes pasado

        $indicator = $request->get('idObject');
        $repository = $this->get('pequiven.repository.sig_indicator');
        $results = $repository->find($indicator);
        
        $user = $this->getUser();
        $data = $results;
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);
        
        $causeAnalysis->setIndicator($data);
        $causeAnalysis->setCreatedBy($user);
        $causeAnalysis->setMonth($month);        

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($causeAnalysis);
            $em->flush();

           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }     
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