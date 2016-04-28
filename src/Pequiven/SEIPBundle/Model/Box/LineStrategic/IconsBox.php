<?php

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;

/**
 * Description of IconsBox
 *
 */
class IconsBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de las líneas estratégicas en formato de íconos';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_icons_dashboard';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics' => $linesStrategics,
        );
    }
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING','ROLE_SEIP_VIEW_RESULT_BY_LINE_STRATEGIC_SPECIAL'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:viewIconsDashboard.html.twig';
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
}
