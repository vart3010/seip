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
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request) {
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
     * @Security("is_granted('ROLE_WORKER_PLANNING')")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function updateAction(\Symfony\Component\HttpFoundation\Request $request) {
        return parent::updateAction($request);
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
}
