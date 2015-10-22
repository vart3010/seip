<?php

namespace Pequiven\SIGBundle\Controller\SigEvolutionReport;


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

class ReportEvolutionCausesController extends ResourceController
{   
    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormAnalysisAction(Request $request)
    {
        $typeObj = $request->get('typeObj');//tipo de Objeto
        $id = $request->get('idIndicator');// Id generico pero debo cambiar que diga id indicator
        
        if ($typeObj == 1) {

            $result = $this->findIndicatorOr404($request);  

        }elseif ($typeObj == 2) {
            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $result = $repository->find($id); 
        }

        
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causesanalysis.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $result,
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
        $result = $request->get('idIndicator');//Id

        $typeObject = $request->get('typeObj');//Tipo de Objeto

        $month = $request->get('causeAnalysis_form')['month'];//Carga de Mes pasado

        $user = $this->getUser();        
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);

        if ($typeObject == 1) {

            $repository = $this->get('pequiven.repository.sig_indicator');
            $results = $repository->find($result);            
            
            $causeAnalysis->setIndicator($results);

        }elseif ($typeObject == 2) {

            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $results = $repository->find($result);            
            
            $causeAnalysis->setArrangementProgram($results);            
        }    
        
        $causeAnalysis->setCreatedBy($user);
        $causeAnalysis->setMonth($month);
        $causeAnalysis->setTypeObject($typeObject);        

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($causeAnalysis);
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
        
        $typeObj = $request->get('typeObj');//tipo de Objeto
        $id = $request->get('idIndicator');// Id generico pero debo cambiar que diga id indicator
        
        if ($typeObj == 1) {

            $result = $this->findIndicatorOr404($request);                    

        }elseif ($typeObj == 2) {
            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $result = $repository->find($id); 
        }
        
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causes.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'form'           => $form->createView(),
                'indicator'      => $result,
                'id' => $id
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
        $result = $request->get('idIndicator');

        $typeObject = $request->get('typeObj');
        
        $month = $request->get('evolutioncause')['month'];//Carga de Mes pasado
        
        $user = $this->getUser();
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        
        if ($typeObject == 1) {

            $repository = $this->get('pequiven.repository.sig_indicator');
            $results = $repository->find($result);            
            
            $cause->setIndicator($results);

        }elseif ($typeObject == 2) {

            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $results = $repository->find($result);            
            
            $cause->setArrangementProgram($results);            
        } 

        $cause->setCreatedBy($user);
        $cause->setMonth($month);  
        $cause->setTypeObject($typeObject);      

        $form->handleRequest($request);

        if ($form->isSubmitted() && $month != 0) {
            
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
        
        $causeId = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->find($causeId);
        
        if($results){

            $em->remove($results);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteCause', array(), 'PequivenSIGBundle'));
        
        }  
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