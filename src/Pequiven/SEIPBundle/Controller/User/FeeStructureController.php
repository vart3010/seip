<?php

namespace Pequiven\SEIPBundle\Controller\User;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\User\FeeStructure;
use Pequiven\SEIPBundle\Entity\User\MovementFeeStructure;

class FeeStructureController extends SEIPController {

    public function showAction(Request $request) {
       
var_dump('Hola');
die();
//        return $this->render('SeipBundle:User/FeeStructure:show.html.twig', array(
//                    'goal' => $entity,
//                    'user' => $this->getUser(),
//                    'assign' => $formassign->createView(),
//                    'remove' => $formremove->createView(),
//                    'responsibles' => $responsibles,
//                    'movements' => $movements,
//                    'causes' => $causes
//        ));
    }   

}
