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
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function arrangementProgramByGerenciaAction(Request $request) {
        $criteria = $request->get('filter',$this->config->getCriteria());
        $sorting = $request->get('sorting',$this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorByGerencia',
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
            ->setTemplate($this->config->getTemplate('viewByGerenciaFirst.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
        ;
        if($request->get('_format') == 'html'){
            $view->setData($resources);
        }else{
            $view->getSerializationContext()->setGroups(array('id','api_list','period','tacticalObjective','operationalObjective','complejo','gerencia','gerenciaSecond'));
            $formatData = $request->get('_formatData','default');
            $view->setData($resources->toArray('',array(),$formatData));
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
        
        $period = $this->container->get('pequiven.repository.period')->findOneActive();
        $criteria['ap.period'] = $period;
        $criteria['ap.user'] = $this->getUser();
        
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                $repository,
                'createPaginatorByAssignedResponsibles',
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
        if($request->isMethod('GET') === true && ($templateSourceId = $request->get('templateSource',null)) !== null){
            $templateSource = $this->get('pequiven_seip.repository.arrangementprogram_template')->find($templateSourceId);
            if(!$templateSource){
                throw $this->createNotFoundException('TemplateSource not found!');
            }
            $srcTimeline = $templateSource->getTimeline();
            $timeLine = new Timeline();
            foreach ($srcTimeline->getGoals() as $srcGoal) {
                $timeLine->addGoal(clone($srcGoal));
            }
            $entity->setTimeline($timeLine);
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
                $timeLine = new Timeline();
                $entity->setTimeline($timeLine);
            }
            if(($templateSourceId = $request->get('templateSource',null)) !== null){
                $templateSource = $this->get('pequiven_seip.repository.arrangementprogram_template')->find($templateSourceId);
                if(!$templateSource){
                    throw $this->createNotFoundException('TemplateSource not found!');
                }
                $srcTimeline = $templateSource->getTimeline();
                $timeLine = new Timeline();
                $timeline = $entity->getTimeline();
                foreach ($timeline->getGoals() as $goal) {
                    foreach ($srcTimeline->getGoals() as $srcGoal) {
                        if($goal->getName() == $srcGoal->getName()){
                            $goalDetails = clone($srcGoal->getGoalDetails());
                            $goal->setGoalDetails($goalDetails);
                            break;
                        }
                    }
                }
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
        $isAllowToDelete = $arrangementProgramManager->isAllowToDelete($entity);
        
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isAllowToSendToReview' => $isAllowToSendToReview,
            'isAllowToApprove' => $isAllowToApprove,
            'isAllowToReview' => $isAllowToReview,
            'hasPermissionToUpdate' => $hasPermissionToUpdate,
            'isAllowToDelete' => $isAllowToDelete,
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
    function returnToDraftAction(Request $request)
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
                    
            $this->domainManager->dispatchEvent('pre_return_to_draft', new ResourceEvent($resource));

            $this->domainManager->update($resource);
            $this->flashHelper->setFlash('success', 'return_to_draft');

            $this->domainManager->dispatchEvent('post_return_to_draft', new ResourceEvent($resource));
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
     * Exportar el reporte tecnico
     * @param Request $request
     */
    public function exportAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $details = $resource->getDetails();
        $summary = $resource->getSummary();
        
        $categoryArrangementProgram = (string)$resource->getCategoryArrangementProgram();
        $tacticalObjective = (string)$resource->getTacticalObjective();
        $operationalObjective = (string)$resource->getOperationalObjective();
        
         $styleArrayBordersContent = array(
          'borders' => array(
            'allborders' => array(
              'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'font' => array(
              'bold' => false
          ),
          'alignment' => array(
              'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
              'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'wrap' => true
          )
        );
        
        $location = '';
        if($resource->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
            $location = (string)$resource->getTacticalObjective()->getGerencia()->getComplejo();
        }else if($resource->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
            $location = (string)$resource->getOperationalObjective()->getGerencia()->getComplejo();
        }
        
        $management = (string)$resource->getTacticalObjective()->getGerencia();
        
        $responsibles = '';
        
        foreach ($resource->getResponsibles() as $responsible) {
            $responsibles .= $responsible;
            $responsibles .= ',';
        }
        $responsiblesLen = strlen($responsibles);
        if($responsiblesLen > 0){
            $responsibles[strlen($responsibles) - 1 ] = '.';
        }
        $responsibles = ucwords(strtolower($responsibles));
        $path = $this->get('kernel')->locateResource('@PequivenArrangementProgramBundle/Resources/skeleton/programa_de_gestion.xls');
        
        $now = new \DateTime();
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SEIP - Programa de gestion')
                ->setCreated()
                ->setLastModifiedBy('SEIP')
                ->setModified()
                ;
        $objPHPExcel
                ->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();
        
        $activeSheet->getDefaultRowDimension()->setRowHeight();
        //Setear informacion base
        $activeSheet
                ->setCellValue('B5',  $categoryArrangementProgram)
                ->setCellValue('F5',  $tacticalObjective)
                ->setCellValue('Q5',  $operationalObjective)
                ->setCellValue('B7',  $location)
                ->setCellValue('F7',  $management)
                ->setCellValue('J7',  $responsibles)
            ;
        
        $timeline = $resource->getTimeline();
        $countGoals = 1;
        $rowGoal = 11;
        $goals = $timeline->getGoals();
        //Agregar las filas faltantes
        if($goals->count() > 13){
            $totalDiff = $goals->count() - 13;
            $activeSheet
                ->insertNewRowBefore(24,$totalDiff);
        }
        //Setear las metas
        foreach ($goals as $goal) {
            $startDate = $goal->getStartDate() ? $goal->getStartDate()->format('Y-m-d') : '';
            $endDate = $goal->getEndDate() ? $goal->getEndDate()->format('Y-m-d') : '';
            
            $responsiblesGoal = '';
            foreach ($goal->getResponsibles() as $responsible) {
                $responsiblesGoal .= ' '.$responsible;
                $responsiblesGoal .= ',';
            }
            $responsiblesLen = strlen($responsiblesGoal);
            if($responsiblesLen > 0){
                $responsiblesGoal[strlen($responsiblesGoal) - 1 ] = '.';
            }
            $responsiblesGoal = ucwords(strtolower($responsiblesGoal));
            
            $weight = $goal->getWeight();
            $goalDetails = $goal->getGoalDetails();
            
            $januaryPlanned = $goalDetails->getJanuaryPlanned();
            $januaryReal = $goalDetails->getJanuaryReal();
            
            $februaryPlanned = $goalDetails->getFebruaryPlanned();
            $februaryReal = $goalDetails->getFebruaryReal();
            
            $marchPlanned = $goalDetails->getMarchPlanned();
            $marchReal = $goalDetails->getMarchReal();
            
            $aprilPlanned = $goalDetails->getAprilPlanned();
            $aprilReal = $goalDetails->getAprilReal();
            
            $mayPlanned = $goalDetails->getMayPlanned();
            $mayReal = $goalDetails->getMayReal();
            
            $junePlanned = $goalDetails->getJunePlanned();
            $juneReal = $goalDetails->getJuneReal();
            
            $julyPlanned = $goalDetails->getJulyPlanned();
            $julyReal = $goalDetails->getJulyReal();
            
            $augustPlanned = $goalDetails->getAugustPlanned();
            $augustReal = $goalDetails->getAugustReal();
            
            $septemberPlanned = $goalDetails->getSeptemberPlanned();
            $septemberReal = $goalDetails->getSeptemberReal();
            
            $octoberPlanned = $goalDetails->getOctoberPlanned();
            $octoberReal = $goalDetails->getOctoberReal();
            
            $novemberPlanned = $goalDetails->getNovemberPlanned();
            $novemberReal = $goalDetails->getNovemberReal();
            
            $decemberPlanned = $goalDetails->getDecemberPlanned();
            $decemberReal = $goalDetails->getDecemberReal();
            
            $goalObservations = $goal->getObservations();
            
            if($countGoals > 13){
                $activeSheet->mergeCells(sprintf('C%s:F%s',$rowGoal,$rowGoal));
                $activeSheet->mergeCells(sprintf('AI%s:AL%s',$rowGoal,$rowGoal));
            }
            
            $activeSheet
                ->setCellValue('B'.$rowGoal,$countGoals)
                ->setCellValue('C'.$rowGoal,$goal->getName())
                ->setCellValue('G'.$rowGoal,$startDate)
                ->setCellValue('H'.$rowGoal,$endDate)
                ->setCellValue('I'.$rowGoal,$responsiblesGoal)
                ->setCellValue('J'.$rowGoal,$weight);
            //Valores planeado y real de la meta
            $activeSheet
                ->setCellValue('K'.$rowGoal,$januaryPlanned)
                ->setCellValue('L'.$rowGoal,$januaryReal)
                ->setCellValue('M'.$rowGoal,$februaryPlanned)
                ->setCellValue('N'.$rowGoal,$februaryReal)    
                ->setCellValue('O'.$rowGoal,$marchPlanned)
                ->setCellValue('P'.$rowGoal,$marchReal)
                ->setCellValue('Q'.$rowGoal,$aprilPlanned)
                ->setCellValue('R'.$rowGoal,$aprilReal)
                ->setCellValue('S'.$rowGoal,$mayPlanned)
                ->setCellValue('T'.$rowGoal,$mayReal)
                ->setCellValue('U'.$rowGoal,$junePlanned)
                ->setCellValue('V'.$rowGoal,$juneReal)
                ->setCellValue('W'.$rowGoal,$julyPlanned)
                ->setCellValue('X'.$rowGoal,$julyReal)
                ->setCellValue('Y'.$rowGoal,$augustPlanned)
                ->setCellValue('Z'.$rowGoal,$augustReal)
                ->setCellValue('AA'.$rowGoal,$septemberPlanned)
                ->setCellValue('AB'.$rowGoal,$septemberReal)
                ->setCellValue('AC'.$rowGoal,$octoberPlanned)
                ->setCellValue('AD'.$rowGoal,$octoberReal)
                ->setCellValue('AE'.$rowGoal,$novemberPlanned)
                ->setCellValue('AF'.$rowGoal,$novemberReal)
                ->setCellValue('AG'.$rowGoal,$decemberPlanned)
                ->setCellValue('AH'.$rowGoal,$decemberReal)
                ->setCellValue('AI'.$rowGoal,$goalObservations)
            ;
            
            $activeSheet->getStyle(sprintf('C%s:I%s',$rowGoal,$rowGoal))->applyFromArray($styleArrayBordersContent);
            $activeSheet->getStyle(sprintf('AI%s:AL%s',$rowGoal,$rowGoal))->applyFromArray($styleArrayBordersContent);
            $rowHeight = 50;
            $responsiblesGoalLen = strlen($responsiblesGoal);
            $goalObservationsLen = strlen($goalObservations);
            if($responsiblesGoalLen > $rowHeight){
                $rowHeight = $responsiblesGoalLen;
            }
            if($goalObservationsLen > $responsiblesGoalLen){
                $rowHeight = $goalObservationsLen;
            }
            $activeSheet->getRowDimension($rowGoal)->setRowHeight($rowHeight);
            $countGoals++;
            $rowGoal++;
        }
        $rowSummary = 24;
        if($rowGoal > $rowSummary){
            $rowSummary = $rowGoal;
        }
        $detailsAdvancesPlanned = $summary['detailsAdvancesPlanned'];
        $detailsAdvancesReal = $summary['detailsAdvancesReal'];
        $totalWeight = $summary['weight'];
        //Setear el peso total distribuido
        $activeSheet->setCellValue('J'.$rowSummary,$totalWeight);
        //Setear avances del programa
        $activeSheet
                ->setCellValue('K'.$rowSummary,$detailsAdvancesPlanned['januaryPlanned'])
                ->setCellValue('L'.$rowSummary,$detailsAdvancesReal['januaryReal'])
                ->setCellValue('M'.$rowSummary,$detailsAdvancesPlanned['februaryPlanned'])
                ->setCellValue('N'.$rowSummary,$detailsAdvancesReal['februaryReal'])
                ->setCellValue('O'.$rowSummary,$detailsAdvancesPlanned['marchPlanned'])
                ->setCellValue('P'.$rowSummary,$detailsAdvancesReal['marchReal'])
                ->setCellValue('Q'.$rowSummary,$detailsAdvancesPlanned['aprilPlanned'])
                ->setCellValue('R'.$rowSummary,$detailsAdvancesReal['aprilReal'])
                ->setCellValue('S'.$rowSummary,$detailsAdvancesPlanned['mayPlanned'])
                ->setCellValue('T'.$rowSummary,$detailsAdvancesReal['mayReal'])
                ->setCellValue('U'.$rowSummary,$detailsAdvancesPlanned['junePlanned'])
                ->setCellValue('V'.$rowSummary,$detailsAdvancesReal['juneReal'])
                ->setCellValue('W'.$rowSummary,$detailsAdvancesPlanned['julyPlanned'])
                ->setCellValue('X'.$rowSummary,$detailsAdvancesReal['julyReal'])
                ->setCellValue('Y'.$rowSummary,$detailsAdvancesPlanned['augustPlanned'])
                ->setCellValue('Z'.$rowSummary,$detailsAdvancesReal['augustReal'])
                ->setCellValue('AA'.$rowSummary,$detailsAdvancesPlanned['septemberPlanned'])
                ->setCellValue('AB'.$rowSummary,$detailsAdvancesReal['septemberReal'])
                ->setCellValue('AC'.$rowSummary,$detailsAdvancesPlanned['octoberPlanned'])
                ->setCellValue('AD'.$rowSummary,$detailsAdvancesReal['octoberReal'])
                ->setCellValue('AE'.$rowSummary,$detailsAdvancesPlanned['novemberPlanned'])
                ->setCellValue('AF'.$rowSummary,$detailsAdvancesReal['novemberReal'])
                ->setCellValue('AG'.$rowSummary,$detailsAdvancesPlanned['decemberPlanned'])
                ->setCellValue('AH'.$rowSummary,$detailsAdvancesReal['decemberReal'])
                ;
        
        //Observaciones del programa.
        $rowObservation = $rowSummary + 2;
        $observations = $resource->getObservations();
        $observationString = '';
        foreach ($observations as $observation) {
            $observationString .= sprintf('%s,',$observation->getDescription());
        }
        $observationsLen = strlen($observationString);
        if($observationsLen > 0){
            $observationString[strlen($observationString) - 1 ] = '.';
            $observationString = ucfirst(strtolower($observationString));
        }else{
            $observationString = 'Ninguna.';
        }
        $activeSheet
                ->setCellValue('B'.$rowObservation,$observationString);
        
        //Agregar los detalles del programa de gestion
        $sendToReviewBy = ucfirst(strtolower($details->getSendToReviewBy() ? $details->getSendToReviewBy() : $this->trans('pequiven.arrangement_program.no_send_to_review_date')));
        $revisionDate = $details->getRevisionDate() ? $details->getRevisionDate()->format($this->getSeipConfiguration()->getGeneralDateFormat()) : $this->trans('pequiven.arrangement_program.no_revison_date');
        
        $approvedBy = ucfirst(strtolower($details->getApprovedBy() ? $details->getApprovedBy() : $this->trans('pequiven.arrangement_program.no_approval_date')));
        $approvalDate = $details->getApprovalDate() ? $details->getApprovalDate()->format($this->getSeipConfiguration()->getGeneralDateFormat()) : $this->trans('pequiven.arrangement_program.no_approval_date');
        if($rowObservation > 26){
            $rowDetails = $rowObservation + 2;
        }else{
            $rowDetails = 28;
        }
        $activeSheet
                ->setCellValue('B'.$rowDetails,$sendToReviewBy)
                ->setCellValue('I'.$rowDetails,$revisionDate)
                ->setCellValue('L'.$rowDetails,$approvedBy)
                ->setCellValue('AI'.$rowDetails,$approvalDate)
                ;
        
        $activeSheet->calculateColumnWidths();
        $activeSheet->getRowDimension('1');
        
        $activeSheet->getProtection()
                    ->setSheet(true)
                    ->setPassword('SEIP-PG-P1A-2014')
                ;
        
        $fileName = sprintf('SEIP-Programa-De-Gestion-%s.xls',$now->format('Ymd-His'));
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
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
    
    protected function trans($id, array $parameters = array(), $domain = 'PequivenArrangementProgramBundle') {
        return parent::trans($id, $parameters, $domain);
    }
}
