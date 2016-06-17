<?php

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Description of IconsBox
 *
 */
class IconsNavBarBoxByComplejo extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de las líneas estratégicas en formato de barra de navegación de acuerdo al complejo seleccionado';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_iconsnavbar_by_complejo';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();

        $idComplejo = $this->getRequest()->get('idComplejo');
        $idLineStrategic = $this->getRequest()->get('id');
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        $tree = $data = $style = array();
        $indicatorService = $this->getIndicatorService();
        $resultService = $this->getResultService();
        
        foreach($linesStrategics as $lineStrategic){
            $indicators = $this->container->get('pequiven.repository.indicator')->findByLineStrategicAndOrderShowFromParent($lineStrategic->getId(),'ASC',array('specific' => true,'complejo' => $idComplejo));
            
            foreach ($indicators as $indicator) {
                if(!isset($tree[(string)$lineStrategic])){
                    $tree[(string)$lineStrategic] = array(
                        'parent' => $lineStrategic,
                        'child' => array(),
                    );
                }
                $tree[(string)$lineStrategic]['child'][(string)$indicator] = $indicator;
                $data[(string)$lineStrategic->getRef()][(string)$indicator->getRef()] = $indicatorService->getDataDashboardWidgetBulb($indicator);
            }
        }
//        die();

        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics'    => $linesStrategics,
            'idLineStrategic'    => $idLineStrategic,
            'idComplejo'         => $idComplejo,
            'tree' => $tree,
            'data' => $data,
            'style' => $style,
            'indicatorService' => $indicatorService,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING','ROLE_ICONS_LINE_NAV_BAR')); 
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:viewIconsNavBarByComplejo.html.twig';
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getAreasPermitted() {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::DASHBOARD,
            \Pequiven\SEIPBundle\Model\Box\AreasBox::PRINCIPAL
        );
    }
    
    public function getIndicatorService()
    {
        return $this->container->get('pequiven_indicator.service.inidicator');
    }
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
}