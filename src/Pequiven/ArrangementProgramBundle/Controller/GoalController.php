<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pequiven\ArrangementProgramBundle\Entity\Goal;
use Pequiven\ArrangementProgramBundle\Form\GoalType;

/**
 * Goal controller.
 */
class GoalController extends \Pequiven\SEIPBundle\Controller\SEIPController {

    /**
     * Lists all Goal entities.
     * 
     * @Template()
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PequivenArrangementProgramBundle:Goal')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Goal entity.
     *
     * @Template("PequivenArrangementProgramBundle:Goal:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Goal();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setPeriod($this->getPeriodService()->getPeriodActive());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('goal_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Goal entity.
     *
     * @param Goal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Goal $entity, $typeForm = \Pequiven\ArrangementProgramBundle\Entity\GOAL_TYPE_FORM) {
        $form = $this->createForm(new GoalType($typeForm), $entity, array(
            'action' => $this->generateUrl('goal_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Goal entity.
     *
     * @Template()
     */
    public function newAction() {
        $entity = new Goal();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Goal entity.
     *
     * @Template()
     */
    public function showAction(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Goal entity.
     *
     * @Template("PequivenArrangementProgramBundle:Goal:_form.html.twig")
     */
    public function getFormAction($typeForm)
    {
        $entity = new Goal();
        $form = $this->createCreateForm($entity, $typeForm);
        $form->remove('responsibles');

        $periodService = $this->getPeriodService();
        $periodActive = $periodService->getPeriodActive();
        $dateStart = $periodActive->getDateStart();
        $dateEnd = $periodActive->getDateEnd();

        $yearActive = $dateStart->format('Y');

        return array(
            'goal' => $form->createView(),
            'yearActive' => $yearActive,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        );
    }

    /**
     * Displays a form to edit an existing Goal entity.
     *
     * @Route("/{id}/edit", name="goal_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Goal entity.
     *
     * @param Goal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Goal $entity) {

        $form = $this->createForm(new GoalType(), $entity, array(
            'action' => $this->generateUrl('goal_update', array('id' => $entity->getId())),
            'method' => 'PUT',            
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Goal entity.
     *
     * @Template("PequivenArrangementProgramBundle:Goal:edit.html.twig")
     */
    public function updateAction(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('goal_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Goal entity.
     *
     */
    public function deleteAction(Request $request) {
        $id = $request->get("id");
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PequivenArrangementProgramBundle:Goal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Goal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('goal'));
    }

    /**
     * Creates a form to delete a Goal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('goal_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

}
