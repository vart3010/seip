<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlador de las plantillas del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ArrangementProgramTemplateController extends SEIPController
{
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $this->getSecurityService()->checkSecurity('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_FROM_TEMPLATE');
        
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
            $formatData = $request->get('_formatData','default');
            $view->getSerializationContext()->setGroups(array('id','api_list'));
            $view->setData($resources->toArray($this->config->getRedirectRoute('index'),array(),$formatData));
        }
        return $this->handleView($view);
    }
    
    /**
     * 
     * Security("is_granted('ROLE_WORKER_PLANNING')")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function createAction(\Symfony\Component\HttpFoundation\Request $request) {
        
        $type = $request->get("type");
        $associate = $request->get("associate");
        $entity = new \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate();
        $user = $this->getUser();
        $entity
                ->setType($type)
                ->setCreatedBy($user);
//        $entity->setCategoryArrangementProgram($this->getSeipConfiguration()->getArrangementProgramAssociatedTo());
        $entity->setCategoryArrangementProgram($this->get('pequiven.repository.category_arrangement_program')->find($associate));
        $form = $this->createCreateForm($entity,array('type' => $type, 'associate' => $associate));
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
     * @Security("is_granted('ROLE_WORKER_PLANNING')")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function updateAction(\Symfony\Component\HttpFoundation\Request $request) {
        $resource = $this->findOr404($request);
        $form = $this->getForm($resource);
        if (($request->isMethod('PUT') || $request->isMethod('POST'))) {

            $originalGoalsArray = array();
            $timeline = $resource->getTimeline();
            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($timeline->getGoals() as $goal) {
                $originalGoalsArray[$timeline->getId()][] = $goal;
            }

            $form->submit($request,false);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $autoOpenOnSave = $request->get('autoOpenOnSave',false);
                if($autoOpenOnSave == true){
                    $this->setFlash('autoOpenOnSave', true);
                }
                $timeline = $resource->getTimeline();
                if(isset($originalGoalsArray[$timeline->getId()])){
                    $goals = $originalGoalsArray[$timeline->getId()];
                    foreach ($goals as $originalGoal) {
                        if(false === $timeline->getGoals()->contains($originalGoal)){
                            $timeline->getGoals()->removeElement($originalGoal);
                            $em->remove($originalGoal);
                        }
                    }
                }
                $em->flush();
                $this->domainManager->update($resource);
                return $this->redirectHandler->redirectTo($resource);
            }
        }
        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('update.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }
    
    /**
     * @Security("is_granted('ROLE_WORKER_PLANNING')")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request) {
        return parent::deleteAction($request);
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
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
}
