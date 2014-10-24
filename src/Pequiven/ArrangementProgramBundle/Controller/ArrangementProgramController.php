<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use DateTime;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\ArrangementProgramBundle\Entity\Timeline;
use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

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
            $labelsStatus = array();
            foreach (ArrangementProgram::getLabelsStatus() as $key => $value) {
                $labelsStatus[] = array(
                    'id' => $key,
                    'description' => $this->trans($value,array(),'PequivenArrangementProgramBundle'),
                );
            }
            
            $view->setData(array(
                'labelsStatus' => $labelsStatus
            ));
        }else{
            $view->getSerializationContext()->setGroups(array('id','api_list','period','tacticalObjective','operationalObjective','complejo','gerencia','gerenciaSecond'));
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
     * @return Form The form
     */
    private function createCreateForm(ArrangementProgram $entity,array $parameters)
    {
        $form = $this->createForm('arrangementprogram', $entity, array(
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
        $isAllowToSendToReview = $this->isAllowToSendToReview($entity);
        $hasPermissionToUpdate = $this->hasPermissionToUpdate($entity);
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isAllowToSendToReview' => $isAllowToSendToReview,
            'isAllowToApprove' => $isAllowToApprove,
            'isAllowToReview' => $isAllowToReview,
            'hasPermissionToUpdate' => $hasPermissionToUpdate,
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
        if($entity->getStatus() !== ArrangementProgram::STATUS_DRAFT){
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
    * @return Form The form
    */
    private function createEditForm(ArrangementProgram $entity)
    {
        $form = $this->createForm('arrangementprogram', $entity, array(
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
        
        if(!$this->hasPermissionToUpdate($entity)){
            throw $this->createAccessDeniedHttpException();
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
                
        if($request->isMethod('POST') || $request->isMethod('PUT')){
            $originalGoalsArray = array();
            $timeline = $entity->getTimeline();
            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($timeline->getGoals() as $goal) {
                $originalGoalsArray[$timeline->getId()][] = $goal;
            }

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
            if($editForm->isValid() === false){
                $data['formErrors'] = $editForm;
            }
        }//Fin isMethodPost
        
        $data = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ); 
        
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
                ->setRevisionDate(new DateTime());
        
        $this->domainManager->dispatchEvent('pre_revised', new ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'revised');
        
        $this->domainManager->dispatchEvent('post_revised', new ResourceEvent($resource));
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * Marca como revisado el programa de gestion "como en revision"
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function sendToReviewAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        if(!$this->isAllowToSendToReview($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $resource->setStatus(ArrangementProgram::STATUS_IN_REVIEW);
        
        $user = $this->getUser();
        $details = $resource->getDetails();
        $details
                ->setSendToReviewBy($user)
                ->setSendToReviewDate(new DateTime());
        
        $this->domainManager->dispatchEvent('pre_send_to_review', new ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'send_to_review');
        
        $this->domainManager->dispatchEvent('post_send_to_review', new ResourceEvent($resource));
        
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
                ->setApprovalDate(new DateTime());
        
        $this->domainManager->dispatchEvent('pre_approved', new ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'approved');
        
        $this->domainManager->dispatchEvent('post_approved', new ResourceEvent($resource));
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * Marca como rechazado el programa de gestion
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function rejectAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        if(!$this->isAllowToApprove($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        
        $resource->setStatus(ArrangementProgram::STATUS_REJECTED);
        
        $user = $this->getUser();
        $details = $resource->getDetails();
        $details
                ->setRejectedBy($user)
                ->setRejectedDate(new DateTime());
        
        $this->domainManager->dispatchEvent('pre_rejected', new ResourceEvent($resource));
        
        $this->domainManager->update($resource);
        $this->flashHelper->setFlash('success', 'rejected');
        
        $this->domainManager->dispatchEvent('post_rejected', new ResourceEvent($resource));
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * Agregar una observacion al programa de gestion
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function addObservationAction(Request $request)
    {
        $resource = $this->findOr404($request);
        
        if(!$this->hasPermissionToUpdate($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $view = $this->view();
        $result = array(
            'data' => $resource,
            'success' => false,
            'total' => 1
        );
        
        $user = $this->getUser();
        $textObservation = $request->get('observation',null);
        if($textObservation != null){
            $observation = new ArrangementProgram\Observation();
            $observation
                    ->setCreatedBy($user)
                    ->setDescription($textObservation)
                    ;
            $resource->addObservation($observation);
            $result['success'] = true;
            $this->save($observation,true);
        }
        $view->setData($result);
        $view->getSerializationContext()->setGroups(array('id','api_list','goal','goalDetails'));   
        
        return $this->handleView($view);
    }
    
    /**
     * Creates a form to delete a ArrangementProgram entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
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
    protected function isAllowToReview(ArrangementProgram $entity) {
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
    protected function isAllowToApprove(ArrangementProgram $entity) {
        $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
        $valid = false;
        if(!$configuration){
            return $valid;
        }
        $user = $this->getUser();
        
        if($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC 
            && $configuration->getArrangementProgramUsersToApproveTactical()->contains($user) === true){
            $valid = true;
        }
        if($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE 
            && $configuration->getArrangementProgramUsersToApproveOperative()->contains($user) === true){
            $valid = true;
        }
        return $valid;
    }
    
    /**
     * Evalua si el usuario logeado tiene permisos para enviar el programa de gestion a revision
     * @param ArrangementProgram $entity
     * @return boolean
     */
    protected function isAllowToSendToReview(ArrangementProgram $entity) {
        $user = $this->getUser();
        $valid = false;
        if( ($entity->getStatus() === ArrangementProgram::STATUS_DRAFT || $entity->getStatus() === ArrangementProgram::STATUS_REVISED ) &&
                ($entity->getCreatedBy() === $user || $this->isAllowToReview($entity) === true || $this->isAllowToApprove($entity) === true) 
            ){
            $valid = true;
        }

        return $valid;
    }
    
    /**
     * Evalua si el usuario logueado tiene permisos para actualizar el programa
     * @param type $entity
     * @throws type
     */
    protected function hasPermissionToUpdate(ArrangementProgram $entity) {
        //Security check
        $permission = true;
        $user = $this->getUser();
        if($entity->getCreatedBy() !== $user && $this->isAllowToApprove($entity) === false && $this->isAllowToReview($entity) === false){
            $permission = false;
        }
        if($entity->getStatus() === ArrangementProgram::STATUS_APPROVED || $entity->getStatus() === ArrangementProgram::STATUS_REJECTED){
            $permission = false;
        }
        return $permission;
    }
}
