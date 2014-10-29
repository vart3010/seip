<?php

namespace Pequiven\SEIPBundle\Model\Box\ArrangementProgram;

use Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox;

/**
 * Description of SummaryBox
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class SummaryBox extends GenericBox 
{
    public function getName() {
        return 'pequiven_seip_box_arrangementprogram_summary';
    }
    
    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:ArrangementProgram/summary.html.twig';
    }
    
    public function getParameters() {
        $em = $this->getDoctrine()->getManager();
        
        return array('parame' => 'ass');
    }

}