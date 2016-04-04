<?php

namespace Pequiven\SEIPBundle\Model\Box\LineStrategic;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;
use Pequiven\MasterBundle\Entity\LineStrategic;

/**
 * Description of IconsBox
 *
 */
class IconsNavBarBox extends GenericBox 
{
    public function getDescription() {
        return 'Contiene una lista de las líneas estratégicas en formato de barra de navegación';
    }

    public function getName() {
        return 'pequiven_seip_box_linestrategic_iconsnavbar';
    }

    public function getParameters() {
        
        $em = $this->getDoctrine()->getManager();
        $idLineStrategic = $this->getRequest()->get('id');
        
        $iconsLineStrategic = LineStrategic::getIcons();
        $linesStrategics = $this->container->get('pequiven.repository.linestrategic')->findBy(array('deletedAt' => null));
        
        return array(
            'iconsLineStrategic' => $iconsLineStrategic,
            'linesStrategics'    => $linesStrategics,
            'idLineStrategic'    => $idLineStrategic,
            'answer'             => $this->getRequest()->get('r')
        );
    }
    
    
    public function hasPermission() {
        return $this->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING','ROLE_ICONS_LINE_NAV_BAR'));
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:LineStrategic:viewIconsNavBar.html.twig';
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