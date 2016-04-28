<?php

namespace Pequiven\IndicatorBundle\Model\Box;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of IconsSummaryBox
 *
 */
class IconsSummaryBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene un resumen en formato dashboard de los indicadores por línea estratégica';
    }

    public function getName() {
        return 'pequiven_indicator_box_iconssummary';
    }

    public function getParameters() {

        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $idLineStrategic = $request->get('id');
        
        $indicators = $this->container->get('pequiven.repository.indicator')->findByLineStrategic($idLineStrategic);
        
        $iconsLineStrategic = LineStrategic::getIcons();
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:viewIconsNavBar.html.twig';
    }
    
    public function getTranslationDomain() {
        return 'PequivenIndicatorBundle';
    }
    
    public function getAreasPermitted() {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::DASHBOARD,
            \Pequiven\SEIPBundle\Model\Box\AreasBox::PRINCIPAL
        );
    }
}
