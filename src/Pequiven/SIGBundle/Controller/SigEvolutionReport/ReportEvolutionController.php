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

use Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionTrend;
use Pequiven\IndicatorBundle\Form\EvolutionIndicator\EvolutionTrendType;

/**
 * Controlador de los distintos modulos del infome de evolucion
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */

class ReportEvolutionController extends ResourceController
{   
    
    /**
     * Retorna el formulario del analisis de la tendencia
     * 
     * @param Request $request
     * @return type
     */
    function getFormTrendAction(Request $request)
    {
        
        $id = $request->get('idIndicator');

        $typeObject = $request->get('typeObj');
        if ($typeObject == 1) {
            
            $result = $this->findIndicatorOr404($request);        
            
        }elseif($typeObject == 2){
            
            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $result = $repository->find($id); 
        }
        
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('form/form_trend.html'))
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
     * Añade la tendencia 
     * 
     * @param Request $request
     * @return type
     */
    public function addTrendAction(Request $request)
    {   
        $result = $request->get('idIndicator');
        $typeObject = $request->get('typeObj');
        
        $month = $request->get('evolutiontrend')['month'];//Carga de Mes pasado
        
        $user = $this->getUser();
        
        $trend = new EvolutionTrend();
        $form  = $this->createForm(new EvolutionTrendType(), $trend);
        
        if ($typeObject == 1) {

            $repository = $this->get('pequiven.repository.sig_indicator');
            $results = $repository->find($result);            
            
            $trend->setIndicator($results);

        }elseif ($typeObject == 2) {

            $repository = $this->get('pequiven_seip.repository.arrangementprogram');
            $results = $repository->find($result);            
            
            $trend->setArrangementProgram($results);            
        }        
        
        $trend->setCreatedBy($user);
        $trend->setMonth($month);
        $trend->setTypeObject($typeObject);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($trend);
            $em->flush();           
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