<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Form\ArrangementProgramType;

/**
 * Controlador del programa de gestion
 *
 */
class ArrangementProgramController extends SEIPController
{
    
    /**
     * Creates a new ArrangementProgram entity.
     *
     * @Template("PequivenArrangementProgramBundle:ArrangementProgram:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $type = $request->get("type");
        $entity = new ArrangementProgram();
        $user = $this->getUser();
        $period = $this->getRepositoryById('period')->findOneActive();
        $entity
                ->setType($type)
                ->setPeriod($period)
                ->setCreatedBy($user);
        
        if($request->isMethod('GET')){
            $timeLine = new \Pequiven\ArrangementProgramBundle\Entity\Timeline();
//            $entity->setTimeline($timeLine);
        }
        $form = $this->createCreateForm($entity,array('type' => $type));
        if($request->isMethod('GET')){
            $form->remove('timeline');
        }
        
        if($request->isMethod('POST') && $form->submit($request,false)->isValid()){
            $this->domainManager->create($entity);
            return $this->redirect($this->generateUrl('pequiven_seip_arrangementprogram_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ArrangementProgram entity.
     *
     * @param ArrangementProgram $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ArrangementProgram $entity,array $parameters)
    {
        $form = $this->createForm(new ArrangementProgramType(), $entity, array(
            'action' => $this->generateUrl('pequiven_arrangementprogram_create',$parameters),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Finds and displays a ArrangementProgram entity.
     *
     * @Template()
     */
    public function showAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ArrangementProgram entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a ArrangementProgram entity.
    *
    * @param ArrangementProgram $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ArrangementProgram $entity)
    {
        $form = $this->createForm(new ArrangementProgramType(), $entity, array(
            'action' => $this->generateUrl('arrangementprogram_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing ArrangementProgram entity.
     *
     */
    public function updateAction(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }
        
        $originalGoalsArray = array();
        $timeline = $entity->getTimeline();
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($timeline->getGoals() as $goal) {
            $originalGoalsArray[$timeline->getId()][] = $goal;
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        $editForm->submit($request,false);
        
        if ($editForm->isValid()) {
            $timeline = $entity->getTimeline();
            if(isset($originalGoalsArray[$timeline->getId()])){
                $goals = $originalGoalsArray[$timeline->getId()];
                foreach ($goals as $originalGoal) {
                    if(false === $timeline->getGoals()->contains($originalGoal)){
                        $timeline->getGoals()->removeElement($originalGoal);
                        $em->remove($originalGoal);
                    }
                }
            }
            $this->domainManager->update($entity);

            return $this->redirect($this->generateUrl('pequiven_seip_arrangementprogram_show', array('id' => $id)));
        }
        
        $data = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ); 
        if($editForm->isValid() === false){
            $data['formErrors'] = $editForm;
        }
        
        $view = $this->view($data);
        $view->setTemplate('PequivenArrangementProgramBundle:ArrangementProgram:edit.html.twig');
        return $this->handleView($view);
    }

    /**
     * Creates a form to delete a ArrangementProgram entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('arrangementprogram_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
