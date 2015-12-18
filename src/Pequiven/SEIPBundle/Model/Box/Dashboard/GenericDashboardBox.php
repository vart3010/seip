<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\Box\Dashboard;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Description of GenericDashboardBox
 *
 */
class GenericDashboardBox extends GenericBox
{
    public function getName() {
        return 'pequiven_seip_box_genericdashboardbox';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:Dashboard/genericDashboardBox.html.twig';
    }
    
    public function getParameters() {
        return array();
    }

    public function getDescription() {
        return 'Genera una imagen en el inicio del sistema por defecto en el dashboard';
    }
    
    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }
    
    public function getAreasPermitted() {
        return array(
            \Pequiven\SEIPBundle\Model\Box\AreasBox::DASHBOARD
        );
    }
}
