<?php

namespace Pequiven\SEIPBundle\Model\Box\EvolutionHistory;

/**
 * Muestra los historicos del Informe de Evolución
 *
 * @author Maximo Sojo
 */
class EvolutionHistoryItemsObjetiveBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox {

    public function getName() {
        return 'pequiven_seip_box_evolution_items_objetive';
    }

    public function getParameters() {
        
        $object = $this->getRequest()->get('id');
        
        $em = $this->getDoctrine()->getManager();
        
        $month = date("m");//Carga del mes "Automatico"
        $mesData = date("F");//Data mes
        
        $year = 2016;

        $labelMonth = $this->getMonths();       
        $count = 1;
        
        for ($i=0; $i < $month; $i++) {        
              $setMonth[] = $count;
              $count = $count + 1;
        }  
        
        $listMonth = $setMonth;
        $boxmonth =  $month;
        $typeObject = 3;
        
        return array(
            'Box_indicator' => $object,
            'Box_month'     => $boxmonth,
            'listMonth'     => $listMonth,
            'labelsMonths'  => $labelMonth,
            'typeObject'    => $typeObject,
            'year'          => $year,            
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
