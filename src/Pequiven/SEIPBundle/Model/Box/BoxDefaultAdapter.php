<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\Box;

use Tecnocreaciones\Bundle\BoxBundle\Model\Adapter\BoxBaseAdapter;

/**
 * Adaptador que devuele los boxes por defecto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class BoxDefaultAdapter extends BoxBaseAdapter {

    public function getModelBoxes() {
        $boxActives = array();
        
//        if ($this->isGranted('ROLE_WORKER_PLANNING')) {
//            $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
//            $boxActive->setBoxName('pequiven_seip_box_tactic_summaryindicatorcharged');
//            $boxActive->setArea(AreasBox::PRINCIPAL, array('position' => 0));
//
//            $boxActives[] = $boxActive;
//        }
        
//        if($this->isGranted(array('ROLE_SEIP_OPERATION_VIEW_MONITOR_PRODUCTION'))){
//            $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
//            $boxActive->setBoxName('dashboard_data_load_production');
//            $boxActive->setArea(AreasBox::DASHBOARD,array('position' => 0));
//
//            $boxActives[] = $boxActive;
//        } else{
            $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
            $boxActive->setBoxName('pequiven_seip_box_genericdashboardbox');
            $boxActive->setArea(AreasBox::DASHBOARD,array('position' => 0));

            $boxActives[] = $boxActive;
//        }
        
//        if ($this->isGranted(array('ROLE_DIRECTIVE', 'ROLE_DIRECTIVE_AUX', 'ROLE_WORKER_PLANNING'))) {
//            //MUESTRA LA VISTA POR DEFECTO DEL SEIP 
//            $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
////            $boxActive->setBoxName('pequiven_seip_box_dashboard_planningdashboard');
//            $boxActive->setBoxName('pequiven_seip_box_genericdashboardbox');
//            $boxActive->setArea(AreasBox::DASHBOARD, array('position' => 0));
//
//            $boxActives[] = $boxActive;
//        } else {
//            $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
//            $boxActive->setBoxName('pequiven_seip_box_genericdashboardbox');
//            $boxActive->setArea(AreasBox::DASHBOARD,array('position' => 0));
//
//            $boxActives[] = $boxActive;
//        }

        //LISTA PROGRAMAS DE GESTIÓN ASOCIADOS
        $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
        $boxActive->setBoxName('pequiven_seip_box_my_arrangementprogram_summary');
        $boxActive->setArea(AreasBox::PRINCIPAL, array('position' => 0));
        $boxActives[] = $boxActive;

        $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
        $boxActive->setBoxName('pequiven_seip_box_user_summary_items');
        $boxActive->setArea(AreasBox::ITEMS, array('position' => 0));
        $boxActives[] = $boxActive;

        $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
        $boxActive->setBoxName('pequiven_seip_box_evolution_items');
        $boxActive->setArea(AreasBox::ITEMS_EVOLUTION, array('position' => 0));
        $boxActives[] = $boxActive;

        $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
        $boxActive->setBoxName('pequiven_seip_box_evolution_items_arrangement');
        $boxActive->setArea(AreasBox::ITEMS_EVOLUTION_ARRANGEMENT, array('position' => 0));
        $boxActives[] = $boxActive;

        $boxActive = new \Tecnocreaciones\Bundle\BoxBundle\Model\BoxStaticLocked();
        $boxActive->setBoxName('pequiven_seip_box_evolution_items_objetive');
        $boxActive->setArea(AreasBox::ITEMS_EVOLUTION_OBJETIVE, array('position' => 0));
        $boxActives[] = $boxActive;

        return $boxActives;
    }

}
