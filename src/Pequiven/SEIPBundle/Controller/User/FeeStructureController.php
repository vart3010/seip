<?php

namespace Pequiven\SEIPBundle\Controller\User;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\User\FeeStructure;
use Pequiven\SEIPBundle\Entity\User\MovementFeeStructure;

/**
 * GESTION EN LA ESTRUCTURA DE CARGOS SEIP
 */
class FeeStructureController extends SEIPController {

    public function showAction(Request $request) {

        $array = array();
        $structure = $this->GenerateTree(1, $array);
    
        return $this->render('PequivenSEIPBundle:User:FeeStructure/show.html.twig', array(
                    'user' => $this->getUser(),
                    'structure' => $structure,
        ));
    }

    public function GenerateTree($padre, $array) {

        $children = $this->get('pequiven_seip.repository.feestructure')->getChildren($padre);

        if ($children == null) {
            return $array;
        }

        foreach ($children as $child) {
            $array[] = $child;            
            $array=$this->GenerateTree($child->getid(),$array) ;
        }

        return $array;
    }

}
