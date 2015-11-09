<?php

namespace Pequiven\SEIPBundle\Controller\Sip\Center;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Pequiven\SEIPBundle\Entity\Sip\Center\Observations;
use Pequiven\SEIPBundle\Form\Sip\Center\ObservationsType;

/**
 * Controlador Centros
 * @author Maximo Sojo maxsojo13@gmail.com
 *
 */
class CenterController extends SEIPController {

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function assistsAction(Request $request) {

        $id = $request->get('id');
        
        var_dump($id);
        die();
        
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function formObservationsAction(Request $request) {

        $observations = new Observations();
        
        $form = $this->createForm(new ObservationsType(), $observations);

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('Form/Observations.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
                ->setData(array(            
                'form' => $form->createView(),
                ))
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        
        return $view;
        
    }

    /**
     * Guardamos las obervaciones
     * 
     * @param Request $request
     * @return type
     */
    public function addObservationsAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new ObservationsType(), new Observations());

        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $Observations = $form->getData();

            $em->persist($Observations);
            $em->flush();

            //return $this->redirect(...);
            var_dump("Cargado!");
            die();
        }
        
    }

}
