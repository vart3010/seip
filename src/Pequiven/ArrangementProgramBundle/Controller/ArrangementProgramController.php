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
 * @Route("/arrangementprogram")
 */
class ArrangementProgramController extends SEIPController
{

    /**
     * Lists all ArrangementProgram entities.
     *
     * @Route("/", name="pequiven_arrangementprogram")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ArrangementProgram entity.
     *
     * @Route("/", name="pequiven_arrangementprogram_create")
     * @Method("POST")
     * @Template("PequivenArrangementProgramBundle:ArrangementProgram:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ArrangementProgram();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $period = $this->getRepositoryById('period')->findOneActive();
            $entity->setPeriod($period);
            $this->save($entity,true);

            return $this->redirect($this->generateUrl('arrangementprogram_show', array('id' => $entity->getId())));
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
    private function createCreateForm(ArrangementProgram $entity)
    {
        $form = $this->createForm(new ArrangementProgramType(), $entity, array(
            'action' => $this->generateUrl('pequiven_arrangementprogram_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new ArrangementProgram entity.
     *
     * @Route("/{type}/new", name="pequiven_arrangementprogram_new",requirements={"type":"1|2|3"})
     * @Method("GET")
     * @Template()
     */
    public function newAction($type)
    {
        $entity = new ArrangementProgram();
        $entity->setType($type);
        $period = $this->getRepositoryById('period')->findOneActive();
        $entity->setPeriod($period);
        $timeLine = new \Pequiven\ArrangementProgramBundle\Entity\Timeline();
        //$timeLine->addGoal(new \Pequiven\ArrangementProgramBundle\Entity\Goal());
        $entity->addTimeline($timeLine);
        
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ArrangementProgram entity.
     *
     * @Route("/{id}", name="arrangementprogram_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
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
     * @Route("/{id}/edit", name="arrangementprogram_edit")
     * @Method("GET")
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
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
     * @Route("/{id}", name="arrangementprogram_update")
     * @Method("PUT")
     * @Template("PequivenArrangementProgramBundle:ArrangementProgram:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
        }
        
    
        $originalTimelines = new \Doctrine\Common\Collections\ArrayCollection();
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getTimelines() as $timeline) {
            foreach ($timeline->getGoals() as $goal) {
//                var_dump($goal);
            }
            $originalTimelines->add($timeline);
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $timelines = $entity->getTimelines();
//            var_dump($timelines[0]);
//            var_dump($_POST['arrangementprogram']['timelines']['0']['goals']);
            foreach ($originalTimelines as $originalTimeline) {
                if(false === $entity->getTimelines()->contains($originalTimeline)){
                    $entity->getTimelines()->removeElement($originalTimeline);
                    $em->remove($originalTimeline);
                }else{
                    $timeline = $entity->getTimelines()->get($entity->getTimelines()->indexOf($originalTimeline));
                    //var_dump($timeline->getGoals());
                    foreach ($originalTimeline->getGoals() as $originalGoal) {
//                        var_dump($timeline->getGoals()->contains($originalGoal));
                        if(false === $timeline->getGoals()->contains($originalGoal)){
                            $timeline->getGoals()->removeElement($originalGoal);
                            $em->remove($originalGoal);
                        }
                    }
                }
                
            }
            $em->flush();

            return $this->redirect($this->generateUrl('arrangementprogram_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ArrangementProgram entity.
     *
     * @Route("/{id}", name="arrangementprogram_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PequivenArrangementProgramBundle:ArrangementProgram')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ArrangementProgram entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('arrangementprogram'));
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
