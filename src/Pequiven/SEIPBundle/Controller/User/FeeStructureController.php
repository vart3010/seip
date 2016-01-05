<?php

namespace Pequiven\SEIPBundle\Controller\User;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Entity\User\FeeStructure;
use Pequiven\SEIPBundle\Entity\User\MovementFeeStructure;
use Pequiven\MasterBundle\Model\Gerencia;

/**
 * GESTION EN LA ESTRUCTURA DE CARGOS SEIP
 */
class FeeStructureController extends SEIPController {

    public function showAction(Request $request) {

        $array = array();
        $idGerente = 1;
        $array[] = $this->getRepository()->find($idGerente);
        $structure = $this->GenerateTree($idGerente, $array);        
        
        //OPCIONES PARA LOS FILTROS
        $em = $this->getDoctrine()->getManager();
        $gerencias = $em->getRepository('PequivenMasterBundle:Gerencia')->getgerencias();
        $gerencias2 = $em->getRepository('PequivenMasterBundle:GerenciaSecond')->getgerenciasSecond();        

        return $this->render('PequivenSEIPBundle:User:FeeStructure/show.html.twig', array(
                    'gerencias' => $gerencias,
                    'gerencias2' => $gerencias2,
                    'user' => $this->getUser(),
                    'structure' => $structure,
        ));
    }

    /**
     * GENERA EL ARBOL DE SUBORDINADOS EN LA ESTRUCTURA ORGANIZATIVA
     * @param type $padre
     * @param type $array
     * @return type
     */
    public function GenerateTree($padre, $array) {

        $children = $this->get('pequiven_seip.repository.feestructure')->getChildren($padre);

        if ($children == null) {
            return $array;
        }

        foreach ($children as $child) {
            $array[] = $child;
            $array = $this->GenerateTree($child->getid(), $array);
        }

        return $array;
    }

}
