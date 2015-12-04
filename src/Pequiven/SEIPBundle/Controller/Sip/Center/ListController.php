<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador Display
 * @author Gilbert C. <glavrjk@gmail.com>
 *
 */
class ListController extends SEIPController {

    /**
     *
     * 	Voto Pequiven
     *
     */
    public function ListGeneralVoteAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $data = $this->get('pequiven.repository.siplist')->getGeneralVote();

        return $this->render('PequivenSEIPBundle:Sip:Center/List/ListGeneralVote.html.twig', array(
                    'user' => $this->getUser(),
                    'data' => $data
        ));
    }

    protected function getCenterService() {
        return $this->container->get('seip.service.center');
    }

}
