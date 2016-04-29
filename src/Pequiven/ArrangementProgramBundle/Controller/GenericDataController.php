<?php

namespace Pequiven\ArrangementProgramBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de data generica del bundle
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class GenericDataController extends SEIPController {

    /**
     * Obtiene los responsable que se pueden asignar a una meta
     */
    function getResponsibleGoalsAction(\Symfony\Component\HttpFoundation\Request $request) {
        $responsiblesId = $request->get('responsibles', array());
        $categoryArrangementProgramId = $request->get('idCategoryArrangementProgram');
        if (is_string($responsiblesId)) {
            $responsiblesId = explode(',', $responsiblesId);
        }
        $query = $request->get('query');
        $results = array();
        if (count($responsiblesId) > 0) {
            $gerencia = $request->get('gerencia', null);
            $repository = $this->getRepositoryById('user');
            $users = $repository->findUsers($responsiblesId);
            if (!$users) {
                throw $this->createNotFoundException();
            }
            $criteria = array(
                'username' => $query,
                'firstname' => $query,
                'lastname' => $query,
                'numPersonal' => $query,
                'categoryArrangementProgramId' => $categoryArrangementProgramId,
            );
            if ($gerencia != null) {
                $criteria['gerencia'] = $gerencia;
            }
            $results = $this->getRepositoryById('user')->findToAssingTacticArrangementProgramGoal($users, $criteria);
        }

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }

    /**
     * Obtiene los responsable que se pueden asignar a un programa de gestion a planificación de procesos
     */
    function getResponsibleArrangementProgramAction(\Symfony\Component\HttpFoundation\Request $request) {
        $categoryArrangementProgramId = $request->get('categoryArrangementProgramId');
        $query = $request->get('query');
        $criteria = array(
            'username' => $query,
            'firstname' => $query,
            'lastname' => $query,
            'numPersonal' => $query,
            'categoryArrangementProgramId' => $categoryArrangementProgramId,
        );

        $results = $this->getRepositoryById('user')->findToAssingTacticArrangementProgram($criteria);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'sonata_api_read'));
        return $this->handleView($view);
    }

    /**
     * Obtiene los tipos de meta de acuerdo al tipo de actividad
     */
    function getTypeGoalAction($category) {
        $results = $this->get('pequiven.repository.type_goal')->findByCategory($category);
        $view = $this->view();
        $view->setData($results);
        return $this->handleView($view);
    }

    /**
     * Busca los objetivos operativos de un objetivo tactico y del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getOperationalObjectivesAction(\Symfony\Component\HttpFoundation\Request $request) {
        $em = $this->getDoctrine()->getManager();
        $categoryArrangementProgramId = $request->get('idCategoryArrangementProgram');

        $objetiveTactic = $em->find('Pequiven\ObjetiveBundle\Entity\Objetive', $request->get('idObjetiveTactical'));
        if (!$objetiveTactic) {
            throw $this->createNotFoundException('objetive tactic not found!');
        }

        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findObjetivesOperationalByObjetiveTactic($objetiveTactic);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerenciaSecond'));
        return $this->handleView($view);
    }

    /**
     * Busca los objetivos operativos tacticos del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getTacticalObjectivesAction(\Symfony\Component\HttpFoundation\Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $criteria['idManagementSystem'] = $request->get('idManagementSystem');
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findTacticalObjetives($user, $criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencia'));
        return $this->handleView($view);
    }

    /**
     * Busca los objetivos operativos del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getOperativesObjectivesAction(\Symfony\Component\HttpFoundation\Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.objetiveoperative');
        $results = $repository->findOperativeObjetives($user, $criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Busca las gerencias de primera linea del usuario
     * 
     * @param type $param
     */
    function getFirstLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {

        $user = $this->getUser();
        $criteria = $request->get('filter', $this->config->getCriteria());
//        if($this->getUserManager()->isAllowFilterComplejo($user) === false){
//            $criteria['complejo'] =  $user->getComplejo();
//        }
        $repository = $this->get('pequiven.repository.gerenciafirst');
        $results = $repository->findGerencia($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo'));
        return $this->handleView($view);
    }

    /**
     * Busca las gerencias de segunda linea
     * @param type $param
     */
    function getSecondLineManagementAction(\Symfony\Component\HttpFoundation\Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $user = $this->getUser();
        if (isset($criteria['view_planning']) && !$criteria['view_planning']) {
            if ($this->getUserManager()->isAllowFilterFirstLineManagement($user) === false) {
                $criteria['gerencia'] = $user->getGerencia();
            }
        }
        $repository = $this->get('pequiven.repository.gerenciasecond');
        $results = $repository->findGerenciaSecond($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencia', 'complejo'));
        return $this->handleView($view);
    }

    /**
     * Busca los complejos
     * @param type $param
     */
    function getComplejosAction(\Symfony\Component\HttpFoundation\Request $request) {

        $user = $this->getUser();
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven_seip.repository.complejo');
        $results = $repository->findComplejos();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencias'));
        return $this->handleView($view);
    }
    
    /**
     * Busca las categorias de archivos Meeting
     * @return type
     */
    public function getCategoryFileAction() {
        $repository = $this->get('pequiven.repository.categoryFile');
        $results = $repository->findCategoryFile();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Busca los sistemas de calidad
     * @param type $param
     */
    function getManagementSystemsAction(\Symfony\Component\HttpFoundation\Request $request) {

        $user = $this->getUser();
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven.repository.sig_management_system');
        $results = $repository->findBy(array("enabled" => 1, "deletedAt" => NULL));
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Busca los responsables
     * @param type $param
     */
    function getResponsiblesAction(\Symfony\Component\HttpFoundation\Request $request) {

        $user = $this->getUser();
        $repository = $this->get('pequiven_seip.repository.user');
        $results = $repository->findUsersByCriteria();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencia', 'sonata_api_read'));
        return $this->handleView($view);
    }

    function getTemplateEmailAction(\Symfony\Component\HttpFoundation\Request $request) {
        $entity = $this->get('pequiven_seip.repository.arrangementprogram')->find($request->get('id'));
        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Programa de gestion %s, no encontrado', $request->get('id')));
        }
        $view = $this->view();
        $templateName = 'PequivenArrangementProgramBundle:ArrangementProgram:email/notityToNotifiers.html.twig';
        $context = array(
            'arrangementProgram' => $entity,
            'user' => $this->getUser(),
        );

        $view->setTemplate($templateName);
        $view->setData($context);

        $toEmail = array(
//            'rarias@pequiven.com' => 'Richard Arias',
//            'gaudybeth.colmenarez@pequiven.com' => 'Gaudybeth Colmenarez',
            'inhack20@gmail.com' => 'Carlos Mendoza',
        );
//        $toEmail = 'gautybeth.colmenarez@pequiven.com';
//        $toEmail = 'rarias@pequiven.com';

        $fromEmail = 'seip@pequiven.com';
        $this->container->get('event_dispatcher')->dispatch(\Pequiven\ArrangementProgramBundle\ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_APPROVED, new \Sylius\Bundle\ResourceBundle\Event\ResourceEvent($entity));
//        $this->container->get('pequiven_seip.mailer.twig_swift')->sendMessage($templateName, $context, $fromEmail, $toEmail);
        return $this->handleView($view);
    }

    /**
     * Busca los objetivos operativos tacticos del usuario logueado
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     * @throws type
     */
    function getGroupLoadAction(\Symfony\Component\HttpFoundation\Request $request) {
        var_dump($request->get("entityId"));
        die();
        
    }

    /**
     * Manejador de usuario o administrador
     * @return \Pequiven\SEIPBundle\Model\UserManager
     */
    private function getUserManager() {
        return $this->get('seip.user_manager');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

}
