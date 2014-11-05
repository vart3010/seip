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
                'createPaginatorByRol',
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
            
            $user = $this->getUser();
            $level = $user->getLevelRealByGroup();
            $isAllowFilterComplejo = $this->getUserManager()->isAllowFilterComplejo($user);//Filtro de localidad
            $isAllowFilterFirstLineManagement = $this->getUserManager()->isAllowFilterFirstLineManagement($user);//Filtro de gerencia de primera linea
            $isAllowFilterManagementSecondLine = $this->getUserManager()->isAllowFilterManagementSecondLine($user);//Filtro de gerencia de segunda linea
            $isAllowFilterTypeManagement = ($level >= \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO);

            $typesManagement = array();
            foreach (\Pequiven\MasterBundle\Entity\GerenciaSecond::getTypesManagement() as $key => $typeManagement) {
                $typesManagement[] = array(
                    'id' => $key,
                    'label' => $this->trans($typeManagement,array(),'PequivenArrangementProgramBundle')
                );
            }
            //PequivenArrangementProgramBundle
            $view->setData(array(
                'labelsStatus' => $labelsStatus,
                'isAllowFilterComplejo' => $isAllowFilterComplejo,
                'isAllowFilterFirstLineManagement' => $isAllowFilterFirstLineManagement,
                'isAllowFilterManagementSecondLine' => $isAllowFilterManagementSecondLine,
                'isAllowFilterTypeManagement' => $isAllowFilterTypeManagement,
                'typesManagement' => $typesManagement,
                'user' => $user
            ));
        }else{
            $view->getSerializationContext()->setGroups(array('id','api_list','period','tacticalObjective','operationalObjective','complejo','gerencia','gerenciaSecond'));
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    public function listTemplateAction(Request $request) {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorByRol',
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
            ->setTemplate($this->config->getTemplate('listTemplate.html'))
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
            
            $user = $this->getUser();
            $level = $user->getLevelRealByGroup();
            $isAllowFilterComplejo = $this->getUserManager()->isAllowFilterComplejo($user);//Filtro de localidad
            $isAllowFilterFirstLineManagement = $this->getUserManager()->isAllowFilterFirstLineManagement($user);//Filtro de gerencia de primera linea
            $isAllowFilterManagementSecondLine = $this->getUserManager()->isAllowFilterManagementSecondLine($user);//Filtro de gerencia de segunda linea
            $isAllowFilterTypeManagement = ($level >= \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO);

            $typesManagement = array();
            foreach (\Pequiven\MasterBundle\Entity\GerenciaSecond::getTypesManagement() as $key => $typeManagement) {
                $typesManagement[] = array(
                    'id' => $key,
                    'label' => $this->trans($typeManagement,array(),'PequivenArrangementProgramBundle')
                );
            }
            //PequivenArrangementProgramBundle
            $view->setData(array(
                'labelsStatus' => $labelsStatus,
                'isAllowFilterComplejo' => $isAllowFilterComplejo,
                'isAllowFilterFirstLineManagement' => $isAllowFilterFirstLineManagement,
                'isAllowFilterManagementSecondLine' => $isAllowFilterManagementSecondLine,
                'isAllowFilterTypeManagement' => $isAllowFilterTypeManagement,
                'typesManagement' => $typesManagement,
                'user' => $user
            ));
        }else{
            $view->getSerializationContext()->setGroups(array('id','api_list','period','tacticalObjective','operationalObjective','complejo','gerencia','gerenciaSecond'));
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    public function assignedAction(Request $request) {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorByAssigned',
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
            ->setTemplate($this->config->getTemplate('assignedIndex.html'))
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
            
            $user = $this->getUser();
            $level = $user->getLevelRealByGroup();
            $isAllowFilterComplejo = $this->getUserManager()->isAllowFilterComplejo($user);//Filtro de localidad
            $isAllowFilterFirstLineManagement = $this->getUserManager()->isAllowFilterFirstLineManagement($user);//Filtro de gerencia de primera linea
            $isAllowFilterManagementSecondLine = $this->getUserManager()->isAllowFilterManagementSecondLine($user);//Filtro de gerencia de segunda linea
            $isAllowFilterTypeManagement = ($level >= \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO);

            $typesManagement = array();
            foreach (\Pequiven\MasterBundle\Entity\GerenciaSecond::getTypesManagement() as $key => $typeManagement) {
                $typesManagement[] = array(
                    'id' => $key,
                    'label' => $this->trans($typeManagement,array(),'PequivenArrangementProgramBundle')
                );
            }
            //PequivenArrangementProgramBundle
            $view->setData(array(
                'labelsStatus' => $labelsStatus,
                'isAllowFilterComplejo' => $isAllowFilterComplejo,
                'isAllowFilterFirstLineManagement' => $isAllowFilterFirstLineManagement,
                'isAllowFilterManagementSecondLine' => $isAllowFilterManagementSecondLine,
                'isAllowFilterTypeManagement' => $isAllowFilterTypeManagement,
                'typesManagement' => $typesManagement,
                'user' => $user
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
        
        $arrangementProgramManager = $this->getArrangementProgramManager();
        
        $isAllowToApprove = $arrangementProgramManager->isAllowToApprove($entity);
        $isAllowToReview = $arrangementProgramManager->isAllowToReview($entity);
        $isAllowToSendToReview = $arrangementProgramManager->isAllowToSendToReview($entity);
        $hasPermissionToUpdate = $arrangementProgramManager->hasPermissionToUpdate($entity);
        
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
        
        if(!$this->getArrangementProgramManager()->hasPermissionToUpdate($entity)){
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
        $arrangementProgramManager = $this->getArrangementProgramManager();
        if(!$arrangementProgramManager->isAllowToReview($resource)){
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
        $arrangementProgramManager = $this->getArrangementProgramManager();
        
        if(!$arrangementProgramManager->isAllowToSendToReview($resource)){
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
     * Regresa el programa de gestion a "borrador"
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function sendToDraftAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $arrangementProgramManager = $this->getArrangementProgramManager();
        
        if(!$arrangementProgramManager->isAllowToSendToDraft($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $observation = $request->get('observation');
        if(empty($observation)){
            $this->flashHelper->setFlash('error', 'error_observation');
        }else{
            $resource->setStatus(ArrangementProgram::STATUS_DRAFT);
            $this->addObservation($resource, $observation);
                    
            $this->domainManager->dispatchEvent('pre_send_to_draft', new ResourceEvent($resource));

            $this->domainManager->update($resource);
            $this->flashHelper->setFlash('success', 'send_to_draft');

            $this->domainManager->dispatchEvent('pre_send_to_draft', new ResourceEvent($resource));
        }
        
        
        return $this->redirectHandler->redirectTo($resource);
    }
    
    /**
     * Regresa el programa de gestion a "revision"
     * 
     * @param Request $request
     * @return type
     * @throws type
     */
    function returnToReviewAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $arrangementProgramManager = $this->getArrangementProgramManager();
        
        if(!$arrangementProgramManager->isAllowReturnToReview($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $observation = $request->get('observation');
        if(empty($observation)){
            $this->flashHelper->setFlash('error', 'error_observation');
        }else{
            $resource->setStatus(ArrangementProgram::STATUS_IN_REVIEW);
            $this->addObservation($resource, $observation);
                    
            $this->domainManager->dispatchEvent('pre_return_to_review', new ResourceEvent($resource));

            $this->domainManager->update($resource);
            $this->flashHelper->setFlash('success', 'return_to_review');

            $this->domainManager->dispatchEvent('post_return_to_review', new ResourceEvent($resource));
        }
        
        
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
        $arrangementProgramManager = $this->getArrangementProgramManager();
        if(!$arrangementProgramManager->isAllowToApprove($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        
        if($arrangementProgramManager->isYouCanApprove($resource) === true){
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
        }else{
            $this->flashHelper->setFlash('error', 'planned_not_complete');
        }
        
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
        $arrangementProgramManager = $this->getArrangementProgramManager();
        
        if(!$arrangementProgramManager->isAllowToApprove($resource)){
            throw $this->createAccessDeniedHttpException();
        }
        $observation = $request->get('observation');
        if(empty($observation)){
            $this->flashHelper->setFlash('error', 'error_observation');
        }else{
            $resource->setStatus(ArrangementProgram::STATUS_REJECTED);
            $this->addObservation($resource, $observation);
            
            $user = $this->getUser();
            $details = $resource->getDetails();
            $details
                    ->setRejectedBy($user)
                    ->setRejectedDate(new DateTime());

            $this->domainManager->dispatchEvent('pre_rejected', new ResourceEvent($resource));

            $this->domainManager->update($resource);
            $this->flashHelper->setFlash('success', 'rejected');

            $this->domainManager->dispatchEvent('post_rejected', new ResourceEvent($resource));
        }
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
        
        if(!$this->getArrangementProgramManager()->hasPermissionToUpdate($resource)){
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
     * Manejador de programa de gestion
     * 
     * @return \Pequiven\ArrangementProgramBundle\Model\ArrangementProgramManager
     */
    private function getArrangementProgramManager()
    {
        return $this->get('seip.arrangement_program.manager');
    }
    
    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() 
    {
        return $this->get('seip.user_manager');
    }
    
    private function addObservation(ArrangementProgram $entity,$description) {
        $observation = new ArrangementProgram\Observation();
            $observation
                ->setDescription($description)
                ->setCreatedBy($this->getUser())
                ;
            $entity->addObservation($observation);
    }
}
