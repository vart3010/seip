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
    public function indexAction(Request $request) {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginator',
                array($criteria, $sorting)
            );
            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if(($limit = $request->query->get('limit')) && $limit > 0){
                if($limit > 100){
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'findBy',
                array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $view->getSerializationContext()->setGroups(array('id','api_list','period','tacticalObjective','complejo','gerencia'));
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
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
//            $entity->setTimeline($timeLine);
        }
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
                $timeLine = new \Pequiven\ArrangementProgramBundle\Entity\Timeline();
                $entity->setTimeline($timeLine);
            }
            $entity->setDetails(new ArrangementProgram\Details());
            
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
        
        $isAllowToApprove = $this->isAllowToApprove($entity);
        $isAllowToReview = $this->isAllowToReview($entity);
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isAllowToApprove' => $isAllowToApprove,
            'isAllowToReview' => $isAllowToReview,
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
        //Security check
        $user = $this->getUser();
        if($entity->getCreatedBy() !== $user){
            throw $this->createAccessDeniedHttpException();
        }
        if($entity->getStatus() !== \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::STATUS_DRAFT){
            throw $this->createAccessDeniedHttpException();
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
        //Security check
        $user = $this->getUser();
        if($entity->getCreatedBy() !== $user){
            throw $this->createAccessDeniedHttpException();
        }
        if($entity->getStatus() !== \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::STATUS_DRAFT){
            throw $this->createAccessDeniedHttpException();
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
            $autoOpenOnSave = $request->get('autoOpenOnSave',false);
            if($autoOpenOnSave == true){
                $this->setFlash('autoOpenOnSave', true);
            }
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
     * Marca como revisado el programa de gestion
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function revisedAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        if(!$this->isAllowToReview($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $resource->setStatus(ArrangementProgram::STATUS_REVISED);
        
        $user = $this->getUser();
        $details = $resource->getDetails();
        $details
                ->setReviewedBy($user)
                ->setRevisionDate(new \DateTime());
        
        $this->domainManager->dispatchEvent('pre_revised', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'revised');
        
        $this->domainManager->dispatchEvent('post_revised', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * Marca como aprobado el programa de gestion
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function approvedAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        if(!$this->isAllowToApprove($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        
        $resource->setStatus(ArrangementProgram::STATUS_APPROVED);
        
        $user = $this->getUser();
        $details = $resource->getDetails();
        $details
                ->setApprovedBy($user)
                ->setApprovalDate(new \DateTime());
        
        $this->domainManager->dispatchEvent('pre_approved', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'approved');
        
        $this->domainManager->dispatchEvent('post_approved', new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($resource));
        
        return $this->redirectHandler->redirectTo($resource);
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
    
    /**
     * Evalua si el usuario logeado tiene permisos para revisar el programa de gestion
     * @param ArrangementProgram $entity
     * @return boolean
     */
    private function isAllowToReview(ArrangementProgram $entity) {
        $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
        $valid = false;
        if(!$configuration){
            return $valid;
        }
        $user = $this->getUser();
        
        foreach ($configuration->getArrangementProgramUserToRevisers() as $userToReviser) {
            if($user === $userToReviser){
                $valid = true;
                break;
            }
        }
        return $valid;
    }
    
    /**
     * Evalua si el usuario logeado tiene permisos para aprobar el programa de gestion
     * @param ArrangementProgram $entity
     * @return boolean
     */
    private function isAllowToApprove(ArrangementProgram $entity) {
        $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
        $valid = false;
        if(!$configuration){
            return $valid;
        }
        $user = $this->getUser();
        
        if($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC 
            && $configuration->getArrangementProgramUserToApproveTactical() === $user){
            $valid = true;
        }
        if($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE 
            && $configuration->getArrangementProgramUserToApproveOperative() === $user){
            $valid = true;
        }
        return $valid;
    }
}
