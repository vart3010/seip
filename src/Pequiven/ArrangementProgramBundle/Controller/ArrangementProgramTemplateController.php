<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de las plantillas del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ArrangementProgramTemplateController extends SEIPController
{
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) {
        $type = $request->get("type");
        $entity = new \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate();
        $user = $this->getUser();
        $entity
                ->setType($type)
                ->setCreatedBy($user);
        $entity->setCategoryArrangementProgram($this->getSeipConfiguration()->getArrangementProgramAssociatedTo());
        $form = $this->createCreateForm($entity,array('type' => $type));
        if($request->isMethod('GET')){
            $form->remove('timeline');
        }
        $form->handleRequest($request);
        if($request->isMethod('POST') && $form->isValid()){
            $autoOpenOnSave = $request->get('autoOpenOnSave',false);
            if($autoOpenOnSave == true){
                $this->setFlash('autoOpenOnSave', true);
            }
            if($entity->getTimeline() === null){
                $timeLine = new Timeline();
                $entity->setTimeline($timeLine);
            }
            
            $this->domainManager->create($entity);
            
            if (null === $entity) {
                return $this->redirectHandler->redirectToIndex();
            }
            
            return $this->redirectHandler->redirectTo($entity);
        }
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setData(array(
                $this->config->getResourceName() => $entity,
                'form'                           => $form->createView()
            ))
        ;
        return $this->handleView($view);
    }
    
    /**
     * Creates a form to create a \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate entity.
     *
     * @param ArrangementProgram $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate $entity,array $parameters)
    {
        $form = $this->createForm('pequiven_seip_arrangementprogram_template', $entity, array(
            'action' => $this->generateUrl('pequiven_arrangementprogram_template_create',$parameters),
            'method' => 'POST',
        ));

        return $form;
    }
}
