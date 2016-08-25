<?php

namespace Pequiven\SIGBundle\Controller\SigEvolutionReport;


use Pequiven\IndicatorBundle\Entity\Indicator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCause;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseType;
use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauseSync;

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauseAnalysis;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionCauseAnalysisType;


/**
 * Controlador Causas Informe de Evolución
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ReportEvolutionCausesController extends ResourceController{   
    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormAnalysisAction(Request $request){
        $idObject = $request->get('idObject');// Id generico pero debo cambiar
        $typeObject  = $request->get('typeObj');//tipo de Objeto
        
        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);
        
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causesanalysis.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'indicator' => $result,
                'form'      => $form->createView(),
                'period'    => $result->getPeriod()->getName()                
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
    public function addCauseAnalysisAction(Request $request){   
        $idObject = $request->get('idObject');//Id
        $typeObject = $request->get('typeObj');//Tipo de Objeto
        $month = $request->get('set_data')['month'];//Carga de Mes pasado

        $user = $this->getUser();        
        $causeAnalysis = new EvolutionCauseAnalysis();
        $form  = $this->createForm(new EvolutionCauseAnalysisType(), $causeAnalysis);

        $analysis = $this->get('pequiven.repository.sig_causes_analysis')->findOneBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));
        if ($analysis) {
            $this->get('session')->getFlashBag()->add('error', "Mes que intentas cargar ya cuenta con un Analisis de Causas.");            
        }else{
            $causeAnalysis->setIdObject($idObject);
            $causeAnalysis->setCreatedBy($user);
            $causeAnalysis->setMonth($month);
            $causeAnalysis->setTypeObject($typeObject);        

            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($causeAnalysis);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', "Analisis de Causas Cargado Correctamente");  
                //return true;          
            }   
        }
        die();
    }

    /**
     * Elimina el analisis de Causas
     * 
     * @param Request $request
     * @return type
     */
    public function deleteAnalysisCAction(Request $request){
        $id = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_causes_analysis')->find($id);        
        if($results){
            $em->remove($results);
            $em->flush();            
            $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteCauseAnalysis', array(), 'PequivenSIGBundle'));
        }  
    }

    /**
     * Retorna el formulario de las causas de desviación
     * 
     * @param Request $request
     * @return type
     */
    function getFormCausesAction(Request $request){        
        $typeObject = $request->get('typeObj');//tipo de Objeto
        $idObject = $request->get('idObject');// Id generico pero debo cambiar que diga id indicator
        
        $evolutionService = $this->getEvolutionService();            
        $result = $evolutionService->getObjectEntity($idObject, $typeObject);

        $causes = $this->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('idObject' => $idObject, 'month' => $request->get('month'), 'typeObject' => $typeObject));

        /*$sumCause = 0;
        foreach ($causes as $valueCauses) {
            $sumCause = $sumCause + $valueCauses->getValueOfCauses();            
        }*/

        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causes.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(
                'form'           => $form->createView(),
                'indicator'      => $result,
                'id'             => $idObject,
                'period'         => $result->getPeriod()->getName(),
                //'sumCause'       => $sumCause
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
    public function addCausesAction(Request $request){   
        $idObject = $request->get('idObject');
        $typeObject = $request->get('typeObj');        
        $month = $request->get('set_data')['month'];//Carga de Mes pasado
        
        $user = $this->getUser();
        $cause = new EvolutionCause();
        $form  = $this->createForm(new EvolutionCauseType(), $cause);
        
        $cause->setIdObject($idObject);
        $cause->setCreatedBy($user);
        $cause->setMonth($month);  
        $cause->setTypeObject($typeObject);      

        $form->handleRequest($request);

        if ($form->isSubmitted() && $month != 0) {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($cause);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Causa Cargada Exitosamente");
        }     
        die();
    }

     /**
     * Elimina las causas
     * 
     * @param Request $request
     * @return type
     */
    public function deleteCauseAction(Request $request){           
        $causeId = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->find($causeId);        
        if($results){
            $em->remove($results);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteCause', array(), 'PequivenSIGBundle'));
            return true;
        }  
    }

    /**
     * Obtiene las causas
     */
    function getCausesToObjectAction(\Symfony\Component\HttpFoundation\Request $request) {     
        $response = new JsonResponse();    

        $idObject = $request->get('idObject');
        $month = $request->get('month');        
        $typeObject = $request->get('typeObject');        
        $query = $request->get('query');
        $results = array();        
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();        
        $repository = $this->get('pequiven.repository.sig_causes_report_evolution');
        //$causes = $repository->findBy(array('idObject' => $idObject, 'month' => $month, 'typeObject' => $typeObject));        
        $dataCauses = $repository->findAll();        
        
        if (!$dataCauses) {
            throw $this->createNotFoundException();
        }
        
        $criteria = array(                                  
            'causes' => $query,                        
        );
        $data = [];
        $results = $this->get('pequiven.repository.sig_causes_report_evolution')->findToValidToCausesEvolution($dataCauses, $criteria, $idObject, $month, $typeObject);                
        $id = $causes = [];
        foreach ($results as $valueCauses) {            
            $data[] = ['id'=>$valueCauses->getId(),'causes'=>$valueCauses->getCauses(), 'valueOfCause'=>$valueCauses->getvalueOfCauses()];
        }
        
        $response->setData($data);
        return $response;
    }
    
    /**
     *
     * Añadiendo Causas Sincronizadas
     *
     */
    public function addCausesSyncAction(Request $request){
        
        if (isset($request->get('data_cause')['load'])) {            
            $idObject = $request->get('idObject');//$request->get('data_indicator')['origen'];
            $typeObject = $request->get('typeObj');                
            $cause = $request->get('data_cause')['load'];

            $user = $this->getUser();
            $sync = new EvolutionCauseSync();        
        
            $sync->setIdObject($idObject);
            $sync->setCreatedBy($user);            
            $sync->setTypeObject($typeObject);      
            $sync->setCause($cause);  
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($sync);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Causa Sincronizada Exitosamente");
        }     
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_causes_sync.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array('data'=>''))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
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
   
}