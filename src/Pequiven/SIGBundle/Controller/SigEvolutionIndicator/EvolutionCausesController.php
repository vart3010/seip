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
        
        $month = date("m");//Carga del mes de Creación de la causa

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

            //return $this->render('PequivenSIGBundle:Indicator:evolution.html.twig', array('id' => $indicator));
            //return $this->redirect($this->generateUrl('pequiven_indicator_evolution',array('id' => $indicator)));
           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }  
    }

    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormAnalysisAction(Request $request)
    {
        $indicator = $this->findIndicatorOr404($request);        
        $idIndicator = $request->get('idIndicator');
        
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
         $month = date("m");//Carga del mes de Creación de la causa

        //$month = $request->get('causeAnalysis_form')['month'];
        //var_dump($month);
        //die();
        

        $indicator = $request->get('idIndicator');
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

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($causeAnalysis);
            $em->flush();

           // return $this->redirect($this->generateUrl('pequiven_causes_form_add'));
        }     
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