<?php

namespace Pequiven\SEIPBundle\Model\Box\EvolutionHistory;

/**
 * Muestra los historicos del Informe de Evolución
 *
 * @author Maximo Sojo
 */
class EvolutionHistoryItemsBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox {

    public function getName() {
        return 'pequiven_seip_box_evolution_items';
    }

    public function getParameters() {

       $idIndicator = $this->getRequest()->get('id');
       
        $month = date("m");//Carga del mes "Automatico"
        $mesData = date("F");//Data mes
        
        $labelMonth = $this->getMonths();
       
        
        $count = 1;
        
        for ($i=0; $i < $month; $i++) { 
       
              $setMonth[] = $count;
              $count = $count + 1;

        }  
          
        $indicator = $idIndicator;
        $listMonth = $setMonth;
        $boxmonth =  $month;
        $typeObject = 1;
        
        return array(
            'Box_indicator' => $indicator,
            'Box_month'     => $boxmonth,
            'listMonth'     => $listMonth,
            'labelsMonths'  => $labelMonth,
            'typeObject'    => $typeObject
            );
        
    }

    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }

    public function getDescription() {
        return 'Muestra los diferentes Historicos del Informe de Evolution';
    }

    public function getTemplateName() {

        
        return 'PequivenSIGBundle:Template:Box\EvolutionHistory.html.twig';
    }

    public function getMonths() {
        
        $labelsMonths = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );
        
        return $labelsMonths;
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     * 
     * @return type
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

}