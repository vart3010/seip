<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController as baseController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of UserController
 *
 * @author matias
 */
class UserController extends baseController {

    /**
     * Función que retorna la vista con la lista de los usuarios
     * @Template("PequivenSEIPBundle:User:list.html.twig")
     * @return type
     */
    public function listAction() {
        return array(
        );
    }

    /**
     * Función que retorna la vista con la lista de los usuarios
     * @Template("PequivenSEIPBundle:User:listAux.html.twig")
     * @return type
     */
    public function listAuxAction() {
        return array(
        );
    }

    /**
     *
     *
     */
    public function notificationAction(){
        $securityContext = $this->container->get('security.context');        
        $em = $this->getDoctrine()->getManager();  

        $types = [
            1 => "Objetivos",
            2 => "Programas",
            3 => "Indicadores",
            4 => "Seguimiento y Eficacia",
            5 => "Producción",
            6 => "Informes de Evolución",
        ];

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->findBy(array('user' => $securityContext->getToken()->getUser()), array('createdAt' => 'DESC'));

        return $this->render('PequivenSEIPBundle:User:notification.html.twig', array('notifications' => $notification, 'types' => $types));
    }
    
    /**
     *
     *
     */
    public function getNotificationAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        if ($notification->getReadNotification() != true) {
            $this->getNotificationService()->findMessageUser();        
            $this->getNotificationService()->findReadNotification($request->get('idMessage'));            
        }
        
        $data = [
            'description' => $notification->getDescription(),
            'path'        => $notification->getPath()
        ];

        $response->setData($data);

        return $response;        
    }

    /**
     *
     *
     */
    public function delNotificationAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        $em->remove($notification);
        $em->flush();
        
        $response->setData($notification->getDescription());

        return $response;        
    }

     /**
     *
     *
     */
    public function NotificationFavouriteAction(Request $request){
        $response = new JsonResponse();        
        
        $em = $this->getDoctrine()->getManager();   

        $notification = $em->getRepository("\Pequiven\SEIPBundle\Entity\User\Notification")->find($request->get('idMessage'));
        
        $notification->setTypeMessage(2);
        
        $em->flush();
        
        $response->setData($notification->getDescription());

        return $response;        
    }

    public function getNotifyDataAction(Request $request){
        $response = new JsonResponse();   
        
        $data = [
            'notify' => 0,
            'fav'    => 1,
            'trash'  => 0
        ];

        $response->setData($data);

        return $response;        
    }

    /**
     * Función que devuelve el paginador con los objetivos operativos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function userListAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorUser', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('list.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'gerencia', 'gerenciaSecond', 'rol', 'sonata_api_read'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    /**
     * Función que devuelve el paginador con los objetivos operativos
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function userListAuxAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $criteria = $request->get('filter', $this->config->getCriteria());
        $sorting = $request->get('sorting', $this->config->getSorting());
        $repository = $this->getRepository();

        if ($this->config->isPaginated()) {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'createPaginatorUserAux', array($criteria, $sorting)
            );

            $maxPerPage = $this->config->getPaginationMaxPerPage();
            if (($limit = $request->query->get('limit')) && $limit > 0) {
                if ($limit > 100) {
                    $limit = 100;
                }
                $maxPerPage = $limit;
            }
            $resources->setCurrentPage($request->get('page', 1), true, true);
            $resources->setMaxPerPage($maxPerPage);
        } else {
            $resources = $this->resourceResolver->getResource(
                    $repository, 'findBy', array($criteria, $sorting, $this->config->getLimit())
            );
        }

        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('listAux.html'))
                ->setTemplateVar($this->config->getPluralResourceName())
        ;
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'gerencia', 'gerenciaSecond', 'rol', 'sonata_api_read'));
        if ($request->get('_format') == 'html') {
            $view->setData($resources);
        } else {
            $formatData = $request->get('_formatData', 'default');
            $view->setData($resources->toArray('', array(), $formatData));
        }
        return $this->handleView($view);
    }

    public function showAction(Request $request) {
        $view = $this
                ->view()
                ->setTemplate($this->config->getTemplate('show.html'))
                ->setTemplateVar($this->config->getResourceName())
                ->setData($this->findOr404($request))
        ;
//        $groups = array_merge(array('api_list'), $request->get('_groups',array()));
//        $view->getSerializationContext()->setGroups($groups);
        return $this->handleView($view);
    }

    /**
     * Busca un usuario
     * 
     * @param Request $request
     * @return type
     */
    function searchAction(Request $request) {
        $query = $request->get('query');
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,
        );
        $results = $this->get('pequiven_seip.repository.user')->searchUserByCriteria($criteria);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }
    
    /**
     * Busca un coordinador
     * 
     * @param Request $request
     * @return type
     */
    function searchCoordinatorAction(Request $request) {
        $query = $request->get('query');
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,
        );
        $results = $this->get('pequiven_seip.repository.user')->searchCoordinator($criteria);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }
    
    /**
     * Busca un coordinador
     * 
     * @param Request $request
     * @return type
     */
    function searchOnlyCoordinatorAction(Request $request) {
        
        $query = $request->get('query');
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,
        );
        
        $criteria['workStudyCircleId'] = $request->get('workStudyCircleId');
        
        $results = $this->get('pequiven_seip.repository.user')->searchOnlyCoordinator($criteria);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }
    
    

    /**
     * Filtra los usuarios que esten por debajo
     * @param Request $request
     * @return type
     * 
     */
    function searchFilterAction(Request $request) {
        $query = $request->get('query');
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,
        
        );
        $user = $this->getUser();
        $securityService = $this->getSecurityService();
        //Si tiene el rol para ver la gestiòn de todos (preferiblemente ROLE_SEIP_PLANNING_VIEW_ALL_MANAGEMENT_USER) no envias el levelUser
        if (!$securityService->isGranted('ROLE_SEIP_PLANNING_VIEW_ALL_MANAGEMENT_USER_ITEMS')) {
            $levelUser = $user->getLevelRealByGroup();
            $criteria['levelUser'] = $levelUser;
            if($levelUser == \Pequiven\MasterBundle\Entity\Rol::ROLE_MANAGER_FIRST || $levelUser == \Pequiven\MasterBundle\Entity\Rol::ROLE_GENERAL_COMPLEJO){
                $criteria['idGerenciaUser'] = $this->getUser()->getGerencia()->getId();
            } elseif($levelUser == \Pequiven\MasterBundle\Entity\Rol::ROLE_MANAGER_SECOND){
                $criteria['idGerenciaUser'] = $this->getUser()->getGerencia()->getId();
                $criteria['idGerenciaSecondUser'] = $this->getUser()->getGerenciaSecond()->getId();
            }
            $results = $this->get('pequiven_seip.repository.user')->searchUserByCriteriaUnder($criteria);
        } else {
            $results = $this->get('pequiven_seip.repository.user')->searchUserByCriteriaUnder($criteria);
        }
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }

    /*
     * Función que devuelve la(s) gerencias de 2da línea asociada a las gerencias de 1ra línea cargadas de acuerdo al objetivo táctico seleccionado
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */

    public function selectGerenciaSecondListAction(Request $request) {
        $response = new JsonResponse();
        $gerenciaSecondChildren = array();
        $em = $this->getDoctrine()->getManager();

        $gerencia = $request->request->get('gerencia');

        if ((int) $gerencia == 0) {
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true));
        } else {
            $results = $this->get('pequiven.repository.gerenciasecond')->findBy(array('enabled' => true, 'gerencia' => $gerencia));
        }

        foreach ($results as $result) {
            $complejo = $result->getGerencia()->getComplejo();
            $gerencia = $result->getGerencia();
            $gerenciaSecondChildren[] = array(
                'idGroup' => $complejo->getId() . '-' . $gerencia->getId(),
                'optGroup' => $complejo->getRef() . '-' . $gerencia->getDescription(),
                'id' => $result->getId(),
                'description' => $result->getDescription()
            );
        }

        $response->setData($gerenciaSecondChildren);

        return $response;
    }

    function addConfigurationAction(Request $request) {
        $resource = $this->findOr404($request);
        if ($resource->getConfiguration() == null) {
            $resource->setConfiguration(new \Pequiven\SEIPBundle\Entity\User\Configuration());
            $this->domainManager->update($resource);
        }
        return $this->redirectHandler->redirectTo($resource);
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     *  Notification
     *
     */
    protected function getNotificationService() {        
        return $this->container->get('seip.service.notification');        
    }

}
