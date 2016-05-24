<?php

namespace Pequiven\SEIPBundle\Controller;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Pequiven\SEIPBundle\Model\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controlador de data generica en el SEIP
 *
 * @author Matías Jiménez
 */
class GenericDataController extends SEIPController {

    /**
     * Retorna las localidades activas dependiendo del criterio o del usuario
     * @param type $param
     */
    function getComplejosAction(Request $request) {

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
     * Obtiene las categorias de archivos de worStudyCircle
     * @param Request $request
     * @return type
     */
    function getCategoryFileAction(Request $request) {
        $user = $this->getUser();
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven_seip.repository.categoryFile');
        $results = $repository->findCategoryFile();
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Retorna las gerencias de primera línea dependiendo del criterio o del usuario
     * 
     * @param type $param
     */
    function getFirstLineManagementAction(Request $request) {

        $user = $this->getUser();
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven.repository.gerenciafirst');
        $results = $repository->findGerencia($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo', 'gerencia_group'));
        return $this->handleView($view);
    }

    /**
     * Retorna las gerencias de segunda línea dependiendo del criterio o del usuario
     * @param type $param
     */
    function getSecondLineManagementAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $user = $this->getUser();
        $repository = $this->get('pequiven.repository.gerenciasecond');
        $results = $repository->findGerenciaSecond($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'gerencia', 'complejo'));
        return $this->handleView($view);
    }

    /**
     * Retorna los Círculos de Estudio de Trabajo
     * @param Request $request
     * @return type
     */
    function getWorkStudyCircleAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven.repository.work_study_circle');
        $results = $repository->findWorkStudyCircle($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list', 'complejo'));
        return $this->handleView($view);
    }
    
    function getProfilesPoliticEvaluationAction(Request $request){
        $criteria = $request->get('filter', $this->config->getCriteria());
        
        $dataArray = array();
//        $objects = new \stdClass();
//        $objects->id = 1;
//        $objects->description = 'Perfil 1';
//        $dataArray[] = $objects;
//        $objects = new \stdClass();
//        $objects->id = 2;
//        $objects->description = 'Perfil 2';
//        $dataArray[] = $objects;
//        $objects = new \stdClass();
//        $objects->id = 3;
//        $objects->description = 'Perfil 3';
//        $dataArray[] = $objects;
//        $objects = new \stdClass();
//        $objects->id = 4;
//        $objects->description = 'Perfil 4';
//        $dataArray[] = $objects;
//        $objects = new \stdClass();
//        $objects->id = 5;
//        $objects->description = 'Perfil 5';
//        $dataArray[] = $objects;
        
        $dataArray[] = array('id' => 1,'description' => 'Perfil 1');
        $dataArray[] = array('id' => 2,'description' => 'Perfil 2');
        $dataArray[] = array('id' => 3,'description' => 'Perfil 3');
        $dataArray[] = array('id' => 4,'description' => 'Perfil 4');
        $dataArray[] = array('id' => 5,'description' => 'Perfil 5');
        
//        var_dump($dataArray);
//        die();
        
        //$results->setData($dataArray);
        $view = $this->view();
        $view->setData($dataArray);
        //$view->getSerializationContext()->setGroups(array('id', 'description'));
        return $this->handleView($view);
    }

    /**
     * Retorna las Líneas Estratégicas
     * @param Request $request
     * @return type
     */
    function getLineStrategicAction(Request $request) {
        $criteria = $request->get('filter', $this->config->getCriteria());
        $repository = $this->get('pequiven.repository.linestrategic');
        $results = $repository->findLineStrategic($criteria);
        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Retorna las frecuencias de notificación del indicador
     * @param type $param
     */
    function getFrequencyNotificationIndicatorsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator");
        $results = $repository->findBy(array(), array('days' => "ASC"));
        $view = $this->view();
        $view->setData($results);
//        $view->getSerializationContext()->setGroups(array('id','api_list','gerencias'));
        return $this->handleView($view);
    }

    public function getLocationByAction(Request $request) {
        $company = $request->get("company");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Location");
        $results = $repository->findByCompany($company);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    public function getEntityByLocationAction(Request $request) {
        $location = $request->get("location");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Entity");
        $results = $repository->findByLocation($location);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    public function getPlantByEntityAction(Request $request) {
        $entity = $request->get("entity");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Plant");
        $results = $repository->findByEntity($entity);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    public function getProductByPlantAction(Request $request) {
        $plant = $request->get("plant");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Product");
        $results = $repository->findByPlant($plant);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    public function getProductReportByPlantReportAction(Request $request) {
        $plantReport = $request->get("plantReport");
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport");
        $results = $repository->findByPlantReport($plantReport);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    public function searchServiceAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Service", $request);
    }

    public function searchProductAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Product", $request);
    }

    public function searchEntityAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Entity", $request);
    }

    public function searchPlantAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Plant", $request);
    }

    public function searchRegionAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Region", $request);
    }

    public function searchLocationAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Location", $request);
    }

    public function searchCompanyAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\CEI\Company", $request);
    }

    public function searchPeriodAction(Request $request) {
        return $this->getResponseSearch("Pequiven\SEIPBundle\Entity\Period", $request);
    }

    private function getResponseSearch($entity, Request $request) {
        $q = $request->get("q");
        $criteria = array(
            'name' => $q,
        );
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository($entity)->findSearch($criteria);

        $view = $this->view();
        $view->setData($results);
        $view->getSerializationContext()->setGroups(array('id', 'api_list'));
        return $this->handleView($view);
    }

    /**
     * Manejador de usuario o administrador
     * @return UserManager
     */
    private function getUserManager() {
        return $this->get('seip.user_manager');
    }

}
